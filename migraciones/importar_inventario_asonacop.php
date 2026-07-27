<?php

require_once __DIR__."/../modelos/conexion.php";

if(PHP_SAPI !== "cli"){
	exit("Esta migración solo puede ejecutarse desde la línea de comandos.\n");
}

$archivoExcel = $argv[1] ?? "D:/Users/peraz/Downloads/INVENTARIO ASONACOP LEVANTADO.xlsx";
$ejecutar = in_array("--execute", $argv, true);

function textoCelda($celda, $sharedStrings){
	$atributos = $celda->attributes();
	$tipo = (string) $atributos["t"];

	if($tipo === "s"){
		$indice = (int) $celda->v;
		return isset($sharedStrings[$indice]) ? trim($sharedStrings[$indice]) : "";
	}

	if($tipo === "inlineStr"){
		return trim((string) $celda->is->t);
	}

	return trim((string) $celda->v);
}

function leerExcel($ruta){
	if(!is_file($ruta)){
		throw new RuntimeException("No se encontró el archivo Excel: ".$ruta);
	}

	$zip = new ZipArchive();
	if($zip->open($ruta) !== true){
		throw new RuntimeException("No se pudo abrir el archivo Excel.");
	}

	$sharedStrings = array();
	$contenidoShared = $zip->getFromName("xl/sharedStrings.xml");

	if($contenidoShared !== false){
		$xmlShared = simplexml_load_string($contenidoShared);
		foreach($xmlShared->si as $si){
			$partes = array();
			if(isset($si->t)){
				$partes[] = (string) $si->t;
			}
			foreach($si->r as $fragmento){
				$partes[] = (string) $fragmento->t;
			}
			$sharedStrings[] = implode("", $partes);
		}
	}

	$contenidoHoja = $zip->getFromName("xl/worksheets/sheet1.xml");
	$zip->close();

	if($contenidoHoja === false){
		throw new RuntimeException("No se encontró la primera hoja del Excel.");
	}

	$xmlHoja = simplexml_load_string($contenidoHoja);
	$xmlHoja->registerXPathNamespace("x", "http://schemas.openxmlformats.org/spreadsheetml/2006/main");
	$filas = array();

	foreach($xmlHoja->xpath("//x:sheetData/x:row") as $filaXml){
		$numeroFila = (int) $filaXml["r"];
		if($numeroFila < 3){
			continue;
		}

		$fila = array_fill(0, 14, "");
		foreach($filaXml->c as $celda){
			$referencia = (string) $celda["r"];
			preg_match("/^[A-Z]+/", $referencia, $coincidencia);
			$letras = $coincidencia[0] ?? "";
			$columna = 0;

			for($i = 0; $i < strlen($letras); $i++){
				$columna = ($columna * 26) + (ord($letras[$i]) - 64);
			}

			if($columna >= 1 && $columna <= 14){
				$fila[$columna - 1] = textoCelda($celda, $sharedStrings);
			}
		}

		if(implode("", $fila) !== ""){
			$filas[] = array("fila_excel" => $numeroFila, "valores" => $fila);
		}
	}

	return $filas;
}

function normalizar($valor){
	$valor = trim((string) $valor);
	$valor = preg_replace("/\s+/u", " ", $valor);
	return mb_strtoupper($valor, "UTF-8");
}

function sqlValor(PDO $db, $valor){
	if($valor === null){
		return "NULL";
	}
	return $db->quote((string) $valor);
}

function respaldarTablas(PDO $db, $ruta, $tablas){
	$contenido = "-- Respaldo previo a migración de inventario ASONACOP\n";
	$contenido .= "-- Fecha: ".date("Y-m-d H:i:s")."\n\n";

	foreach($tablas as $tabla){
		$contenido .= "-- Tabla `".$tabla."`\n";
		$filas = $db->query("SELECT * FROM `".$tabla."`")->fetchAll(PDO::FETCH_ASSOC);

		foreach($filas as $fila){
			$columnas = array_map(function($columna){
				return "`".$columna."`";
			}, array_keys($fila));
			$valores = array_map(function($valor) use ($db){
				return sqlValor($db, $valor);
			}, array_values($fila));

			$contenido .= "INSERT INTO `".$tabla."` (".implode(",", $columnas).") VALUES (".implode(",", $valores).");\n";
		}

		$contenido .= "\n";
	}

	$directorio = dirname($ruta);
	if(!is_dir($directorio)){
		mkdir($directorio, 0775, true);
	}
	file_put_contents($ruta, $contenido);
}

$categorias = array(
	"MOBILIARIO" => array("nombre" => "MOBILIARIOS", "prefijo" => "MOB"),
	"E. TEC." => array("nombre" => "EQUIPOS TECNOLÓGICOS", "prefijo" => "ETEC"),
	"E. ELECT." => array("nombre" => "EQUIPOS ELÉCTRICOS", "prefijo" => "EELEC"),
	"EQ.COC." => array("nombre" => "ELECTRODOMESTICOS", "prefijo" => "ECOC"),
	"MAT. OFIC." => array("nombre" => "MATERIALES DE OFICINA", "prefijo" => "MOF"),
	"MAT. POP." => array("nombre" => "MATERIAL POP", "prefijo" => "MPOP")
);

$responsables = array(
	"CARLOS" => 70,
	"CAROLINA" => 44,
	"DEIBYS" => 27,
	"DIANA" => 90,
	"JOVANNY" => 36,
	"LAUDYS" => 87,
	"MARY" => 33,
	"ROSEILIZ" => 57,
	"SAGRARIO" => 69,
	"SR ANDY" => 34,
	"SR DANNY" => 88,
	"SRA MARITZA" => 40,
	"WILMAN" => 32,
	"ZENEN" => 12,
	"ROSEILIZ/LAUDYS" => 57,
	"WILMAN/CAROLINA" => 32
);

$reporte = array(
	"modo" => $ejecutar ? "ejecucion" : "simulacion",
	"archivo" => $archivoExcel,
	"filas_excel" => 0,
	"preparados" => 0,
	"insertados" => 0,
	"omitidos_existentes" => 0,
	"errores" => array(),
	"categorias_creadas" => array(),
	"responsables_vinculados" => 0,
	"responsables_sin_vincular" => 0
);

try{
	$filasExcel = leerExcel($archivoExcel);
	$reporte["filas_excel"] = count($filasExcel);
	$db = Conexion::conectar();
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$categoriasDb = array();
	foreach($db->query("SELECT id, categoria FROM categorias")->fetchAll(PDO::FETCH_ASSOC) as $categoriaDb){
		$categoriasDb[normalizar($categoriaDb["categoria"])] = (int) $categoriaDb["id"];
	}

	$empleadosDb = array();
	foreach($db->query("SELECT id FROM empleados")->fetchAll(PDO::FETCH_COLUMN) as $idEmpleado){
		$empleadosDb[(int) $idEmpleado] = true;
	}

	$registros = array();
	$codigosPreparados = array();

	foreach($filasExcel as $filaExcel){
		list(
			$codigoEstado,
			$categoriaOrigen,
			$codigoOrigen,
			$descripcion,
			$serial,
			$responsableOrigen,
			$color,
			$marca,
			$modelo,
			$cantidad,
			$condicion,
			$asonacop,
			$socioAportante,
			$porcentaje
		) = $filaExcel["valores"];

		$categoriaClave = normalizar($categoriaOrigen);
		if(!isset($categorias[$categoriaClave])){
			$reporte["errores"][] = "Fila ".$filaExcel["fila_excel"].": categoría no reconocida `".$categoriaOrigen."`.";
			continue;
		}

		$codigoOrigen = normalizar($codigoOrigen);
		if($codigoOrigen === ""){
			$reporte["errores"][] = "Fila ".$filaExcel["fila_excel"].": código vacío.";
			continue;
		}

		$codigoUF = "LAR13";
		$codigo = $categorias[$categoriaClave]["prefijo"]."-".$codigoOrigen;
		$claveCodigo = $codigoUF."|".$codigo;

		if(isset($codigosPreparados[$claveCodigo])){
			$reporte["errores"][] = "Fila ".$filaExcel["fila_excel"].": código duplicado dentro del Excel `".$codigoUF."-".$codigo."`.";
			continue;
		}
		$codigosPreparados[$claveCodigo] = true;

		$cantidadNormalizada = trim($cantidad) === "" ? 1 : (int) $cantidad;
		if($cantidadNormalizada < 1){
			$reporte["errores"][] = "Fila ".$filaExcel["fila_excel"].": cantidad no válida.";
			continue;
		}

		$responsableClave = normalizar($responsableOrigen);
		$idResponsable = $responsables[$responsableClave] ?? "";
		if($idResponsable !== "" && isset($empleadosDb[(int) $idResponsable])){
			$reporte["responsables_vinculados"]++;
		}else{
			$idResponsable = "";
			$reporte["responsables_sin_vincular"]++;
		}

		$detalles = array();
		$detalles[] = "MIGRADO DESDE INVENTARIO ASONACOP LEVANTADO.XLSX (FILA ".$filaExcel["fila_excel"].")";
		$detalles[] = "CÓDIGO ESTADO ORIGINAL: ".normalizar($codigoEstado);
		$detalles[] = "CATEGORÍA ORIGINAL: ".$categoriaClave;
		if($responsableOrigen !== "") $detalles[] = "RESPONSABLE/ÁREA ORIGINAL: ".normalizar($responsableOrigen);
		if($color !== "") $detalles[] = "COLOR: ".normalizar($color);
		if($marca !== "") $detalles[] = "MARCA: ".normalizar($marca);
		if($modelo !== "") $detalles[] = "MODELO: ".normalizar($modelo);
		if($condicion !== "") $detalles[] = "CONDICIÓN FÍSICA: ".normalizar($condicion);
		if($socioAportante !== "") $detalles[] = "SOCIO APORTANTE: ".normalizar($socioAportante);
		if($porcentaje !== "") $detalles[] = "7%: ".normalizar($porcentaje);

		$estadoConservacion = "";
		if(preg_match("/DAÑAD|DAÑADA|DAÑADO/u", normalizar($condicion))){
			$estadoConservacion = "Malo";
		}else if(trim($condicion) !== ""){
			$estadoConservacion = "Regular";
		}

		$registros[] = array(
			"categoria_nombre" => $categorias[$categoriaClave]["nombre"],
			"codigo_uf" => $codigoUF,
			"codigo" => $codigo,
			"descripcion" => normalizar($descripcion),
			"serial_numero" => trim($serial),
			"fecha_adquisicion" => "",
			"fuente_financiamiento" => trim($asonacop) !== "" ? "ASONACOP" : "NO INDICADO",
			"origen_activo" => "Sin especificar",
			"situacion_contable" => "Uso interno",
			"ubicacion_fisica" => "LARA",
			"responsable" => $idResponsable,
			"fecha_entrega_res" => "",
			"estado_conservacion" => $estadoConservacion,
			"info_garantia" => "",
			"observaciones" => implode(" | ", $detalles),
			"imagen" => "vistas/img/activos/default/anonymous.png",
			"stock" => $cantidadNormalizada,
			"precio_compra_bs" => "0",
			"precio_compra_ds" => "0",
			"asignaciones" => 0
		);
	}

	$reporte["preparados"] = count($registros);

	if(count($reporte["errores"]) > 0){
		throw new RuntimeException("La simulación detectó errores; no se modificó la base de datos.");
	}

	if($ejecutar){
		$marcaTiempo = date("Ymd_His");
		$rutaRespaldo = __DIR__."/../db/backups/antes_inventario_asonacop_".$marcaTiempo.".sql";
		respaldarTablas($db, $rutaRespaldo, array("categorias", "activos"));
		$reporte["respaldo"] = realpath($rutaRespaldo);

		$db->beginTransaction();

		foreach($categorias as $categoria){
			$nombreNormalizado = normalizar($categoria["nombre"]);
			if(!isset($categoriasDb[$nombreNormalizado])){
				$stmtCategoria = $db->prepare("INSERT INTO categorias (categoria) VALUES (:categoria)");
				$stmtCategoria->execute(array(":categoria" => $categoria["nombre"]));
				$categoriasDb[$nombreNormalizado] = (int) $db->lastInsertId();
				$reporte["categorias_creadas"][] = $categoria["nombre"];
			}
		}

		$stmtExiste = $db->prepare("SELECT id FROM activos
			WHERE UPPER(TRIM(codigo_uf)) = UPPER(TRIM(:codigo_uf))
			AND UPPER(TRIM(codigo)) = UPPER(TRIM(:codigo))
			LIMIT 1");

		$stmtInsertar = $db->prepare("INSERT INTO activos
			(id_categoria, codigo, codigo_uf, descripcion, serial_numero, fecha_adquisicion,
			 fuente_financiamiento, origen_activo, situacion_contable, ubicacion_fisica,
			 responsable, fecha_entrega_res, estado_conservacion, info_garantia,
			 observaciones, imagen, stock, precio_compra_bs, precio_compra_ds, asignaciones)
			VALUES
			(:id_categoria, :codigo, :codigo_uf, :descripcion, :serial_numero, :fecha_adquisicion,
			 :fuente_financiamiento, :origen_activo, :situacion_contable, :ubicacion_fisica,
			 :responsable, :fecha_entrega_res, :estado_conservacion, :info_garantia,
			 :observaciones, :imagen, :stock, :precio_compra_bs, :precio_compra_ds, :asignaciones)");

		foreach($registros as $registro){
			$stmtExiste->execute(array(
				":codigo_uf" => $registro["codigo_uf"],
				":codigo" => $registro["codigo"]
			));

			if($stmtExiste->fetchColumn()){
				$reporte["omitidos_existentes"]++;
				continue;
			}

			$nombreCategoria = normalizar($registro["categoria_nombre"]);
			$datosInsertar = $registro;
			unset($datosInsertar["categoria_nombre"]);
			$datosInsertar["id_categoria"] = $categoriasDb[$nombreCategoria];

			$stmtInsertar->execute(array(
				":id_categoria" => $datosInsertar["id_categoria"],
				":codigo" => $datosInsertar["codigo"],
				":codigo_uf" => $datosInsertar["codigo_uf"],
				":descripcion" => $datosInsertar["descripcion"],
				":serial_numero" => $datosInsertar["serial_numero"],
				":fecha_adquisicion" => $datosInsertar["fecha_adquisicion"],
				":fuente_financiamiento" => $datosInsertar["fuente_financiamiento"],
				":origen_activo" => $datosInsertar["origen_activo"],
				":situacion_contable" => $datosInsertar["situacion_contable"],
				":ubicacion_fisica" => $datosInsertar["ubicacion_fisica"],
				":responsable" => $datosInsertar["responsable"],
				":fecha_entrega_res" => $datosInsertar["fecha_entrega_res"],
				":estado_conservacion" => $datosInsertar["estado_conservacion"],
				":info_garantia" => $datosInsertar["info_garantia"],
				":observaciones" => $datosInsertar["observaciones"],
				":imagen" => $datosInsertar["imagen"],
				":stock" => $datosInsertar["stock"],
				":precio_compra_bs" => $datosInsertar["precio_compra_bs"],
				":precio_compra_ds" => $datosInsertar["precio_compra_ds"],
				":asignaciones" => $datosInsertar["asignaciones"]
			));
			$reporte["insertados"]++;
		}

		$db->commit();
	}

}catch(Throwable $error){
	if(isset($db) && $db->inTransaction()){
		$db->rollBack();
	}
	$reporte["fallo"] = $error->getMessage();
}

$directorioReportes = __DIR__."/reportes";
if(!is_dir($directorioReportes)){
	mkdir($directorioReportes, 0775, true);
}
$rutaReporte = $directorioReportes."/inventario_asonacop_".date("Ymd_His")."_".$reporte["modo"].".json";
file_put_contents($rutaReporte, json_encode($reporte, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode($reporte, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)."\n";
echo "REPORTE: ".realpath($rutaReporte)."\n";

exit(isset($reporte["fallo"]) ? 1 : 0);

