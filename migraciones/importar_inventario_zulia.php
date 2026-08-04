<?php

require_once __DIR__."/../modelos/conexion.php";

if(PHP_SAPI !== "cli"){
	exit("Esta migración solo puede ejecutarse desde la línea de comandos.\n");
}

$archivoExcel = $argv[1] ?? "D:/Users/peraz/Downloads/INV ZULIA.xlsx";
$ejecutar = in_array("--execute", $argv, true);

function normalizarZulia($valor){
	$valor = preg_replace("/\s+/u", " ", trim((string)$valor));
	return mb_strtoupper($valor, "UTF-8");
}

function codigoSeguroZulia($valor){
	$valor = normalizarZulia($valor);
	$valor = preg_replace("/[^A-Z0-9._-]+/u", "-", $valor);
	return trim(preg_replace("/-+/", "-", $valor), "-");
}

function valorCeldaZulia($celda, $sharedStrings){
	$tipo = (string)$celda->attributes()["t"];
	if($tipo === "s"){
		$indice = (int)$celda->v;
		return trim($sharedStrings[$indice] ?? "");
	}
	if($tipo === "inlineStr"){
		return trim((string)$celda->is->t);
	}
	return trim((string)$celda->v);
}

function leerInventarioZulia($ruta){
	if(!is_file($ruta)){
		throw new RuntimeException("No se encontró el Excel: ".$ruta);
	}

	$zip = new ZipArchive();
	if($zip->open($ruta) !== true){
		throw new RuntimeException("No se pudo abrir el Excel.");
	}

	$sharedStrings = array();
	$contenidoShared = $zip->getFromName("xl/sharedStrings.xml");
	if($contenidoShared !== false){
		$xmlShared = simplexml_load_string($contenidoShared);
		foreach($xmlShared->si as $si){
			$partes = array();
			if(isset($si->t)) $partes[] = (string)$si->t;
			foreach($si->r as $fragmento) $partes[] = (string)$fragmento->t;
			$sharedStrings[] = implode("", $partes);
		}
	}

	$contenidoHoja = $zip->getFromName("xl/worksheets/sheet1.xml");
	$zip->close();
	if($contenidoHoja === false){
		throw new RuntimeException("No se encontró la primera hoja.");
	}

	$xmlHoja = simplexml_load_string($contenidoHoja);
	$xmlHoja->registerXPathNamespace("x", "http://schemas.openxmlformats.org/spreadsheetml/2006/main");
	$filas = array();

	foreach($xmlHoja->xpath("//x:sheetData/x:row") as $filaXml){
		$numero = (int)$filaXml["r"];
		if($numero < 3) continue;

		$fila = array_fill(0, 6, "");
		foreach($filaXml->c as $celda){
			preg_match("/^[A-Z]+/", (string)$celda["r"], $coincidencia);
			$letras = $coincidencia[0] ?? "";
			$columna = 0;
			for($i=0; $i<strlen($letras); $i++){
				$columna = ($columna * 26) + ord($letras[$i]) - 64;
			}
			if($columna >= 1 && $columna <= 6){
				$fila[$columna - 1] = valorCeldaZulia($celda, $sharedStrings);
			}
		}

		if(implode("", $fila) !== ""){
			$filas[] = array("fila_excel"=>$numero, "valores"=>$fila);
		}
	}

	return $filas;
}

function respaldarZulia(PDO $db, $ruta){
	$contenido = "-- Respaldo previo a migración INV ZULIA.xlsx\n-- Fecha: ".date("Y-m-d H:i:s")."\n\n";
	foreach(array("categorias", "activos") as $tabla){
		$contenido .= "-- Tabla `".$tabla."`\n";
		foreach($db->query("SELECT * FROM `".$tabla."`")->fetchAll(PDO::FETCH_ASSOC) as $fila){
			$columnas = array_map(function($col){ return "`".$col."`"; }, array_keys($fila));
			$valores = array_map(function($valor) use ($db){ return $valor === null ? "NULL" : $db->quote((string)$valor); }, array_values($fila));
			$contenido .= "INSERT INTO `".$tabla."` (".implode(",",$columnas).") VALUES (".implode(",",$valores).");\n";
		}
		$contenido .= "\n";
	}
	if(!is_dir(dirname($ruta))) mkdir(dirname($ruta), 0775, true);
	file_put_contents($ruta, $contenido);
}

$mapaCategorias = array(
	"E.TEC." => "EQUIPOS TECNOLÓGICOS",
	"MOBIL" => "MOBILIARIOS",
	"E.OFIC." => "EQUIPOS DE OFICINA",
	"E.ELECT" => "EQUIPOS ELECTRONICOS Y DISPOSITIVOS",
	"E.AUDIOV" => "EQUIPOS AUDIOVISUALES",
	"E.ELECTR." => "ELECTRODOMESTICOS",
	"E. LOGIST" => "EQUIPOS LOGÍSTICOS"
);

$reporte = array(
	"modo" => $ejecutar ? "ejecucion" : "simulacion",
	"archivo" => $archivoExcel,
	"filas_con_datos" => 0,
	"preparados" => 0,
	"insertados" => 0,
	"omitidos_existentes" => 0,
	"filas_omitidas" => array(),
	"errores" => array(),
	"categorias_creadas" => array()
);

try{
	$filas = leerInventarioZulia($archivoExcel);
	$db = Conexion::conectar();
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$categoriasDb = array();
	foreach($db->query("SELECT id,categoria FROM categorias")->fetchAll(PDO::FETCH_ASSOC) as $categoria){
		$categoriasDb[normalizarZulia($categoria["categoria"])] = (int)$categoria["id"];
	}

	$estadoActual = "ZUL23";
	$registros = array();
	$codigos = array();

	foreach($filas as $fila){
		list($vacia, $codigoEstado, $categoriaOrigen, $codigoOrigen, $descripcion, $serial) = $fila["valores"];
		if($categoriaOrigen === "" && $codigoOrigen === "" && $descripcion === "") continue;
		$reporte["filas_con_datos"]++;

		if(trim($codigoEstado) !== "") $estadoActual = codigoSeguroZulia($codigoEstado);
		$categoriaClave = normalizarZulia($categoriaOrigen);
		if(!isset($mapaCategorias[$categoriaClave])){
			$reporte["errores"][] = "Fila ".$fila["fila_excel"].": categoría desconocida `".$categoriaOrigen."`.";
			continue;
		}

		$codigo = codigoSeguroZulia($codigoOrigen);
		if($codigo === ""){
			$reporte["errores"][] = "Fila ".$fila["fila_excel"].": código vacío.";
			continue;
		}

		if(trim($descripcion) === ""){
			$reporte["filas_omitidas"][] = array("fila"=>$fila["fila_excel"], "codigo"=>$codigo, "motivo"=>"Descripción vacía");
			continue;
		}

		$clave = $estadoActual."|".$codigo;
		if(isset($codigos[$clave])){
			$reporte["errores"][] = "Fila ".$fila["fila_excel"].": código duplicado `".$estadoActual."-".$codigo."`.";
			continue;
		}
		$codigos[$clave] = true;

		$registros[] = array(
			"categoria_nombre"=>$mapaCategorias[$categoriaClave],
			"codigo_uf"=>$estadoActual,
			"codigo"=>$codigo,
			"descripcion"=>normalizarZulia($descripcion),
			"serial_numero"=>trim($serial),
			"fecha_adquisicion"=>"",
			"fuente_financiamiento"=>"NO INDICADO",
			"origen_activo"=>"Sin especificar",
			"situacion_contable"=>"Uso interno",
			"ubicacion_fisica"=>"ZULIA",
			"responsable"=>"",
			"fecha_entrega_res"=>"",
			"estado_conservacion"=>"",
			"info_garantia"=>"",
			"observaciones"=>"MIGRADO DESDE INV ZULIA.XLSX (FILA ".$fila["fila_excel"].") | CATEGORÍA ORIGINAL: ".$categoriaClave." | CÓDIGO ORIGINAL: ".normalizarZulia($codigoOrigen),
			"imagen"=>"vistas/img/activos/default/anonymous.png",
			"stock"=>1,
			"precio_compra_bs"=>"0",
			"precio_compra_ds"=>"0",
			"asignaciones"=>0
		);
	}

	$reporte["preparados"] = count($registros);
	if(count($reporte["errores"])) throw new RuntimeException("La simulación detectó errores; no se modificó la base de datos.");

	if($ejecutar){
		$rutaRespaldo = __DIR__."/../db/backups/antes_inventario_zulia_".date("Ymd_His").".sql";
		respaldarZulia($db, $rutaRespaldo);
		$reporte["respaldo"] = realpath($rutaRespaldo);
		$db->beginTransaction();

		foreach(array_unique(array_values($mapaCategorias)) as $nombreCategoria){
			$claveCategoria = normalizarZulia($nombreCategoria);
			if(!isset($categoriasDb[$claveCategoria])){
				$stmtCategoria=$db->prepare("INSERT INTO categorias(categoria) VALUES(:categoria)");
				$stmtCategoria->execute(array(":categoria"=>$nombreCategoria));
				$categoriasDb[$claveCategoria]=(int)$db->lastInsertId();
				$reporte["categorias_creadas"][]=$nombreCategoria;
			}
		}

		$stmtExiste=$db->prepare("SELECT id FROM activos WHERE UPPER(TRIM(codigo_uf))=UPPER(TRIM(:codigo_uf)) AND UPPER(TRIM(codigo))=UPPER(TRIM(:codigo)) LIMIT 1");
		$stmtInsertar=$db->prepare("INSERT INTO activos (id_categoria,codigo,codigo_uf,descripcion,serial_numero,fecha_adquisicion,fuente_financiamiento,origen_activo,situacion_contable,ubicacion_fisica,responsable,fecha_entrega_res,estado_conservacion,info_garantia,observaciones,imagen,stock,precio_compra_bs,precio_compra_ds,asignaciones) VALUES (:id_categoria,:codigo,:codigo_uf,:descripcion,:serial_numero,:fecha_adquisicion,:fuente_financiamiento,:origen_activo,:situacion_contable,:ubicacion_fisica,:responsable,:fecha_entrega_res,:estado_conservacion,:info_garantia,:observaciones,:imagen,:stock,:precio_compra_bs,:precio_compra_ds,:asignaciones)");

		foreach($registros as $registro){
			$stmtExiste->execute(array(":codigo_uf"=>$registro["codigo_uf"],":codigo"=>$registro["codigo"]));
			if($stmtExiste->fetchColumn()){$reporte["omitidos_existentes"]++;continue;}
			$categoriaNombre=$registro["categoria_nombre"];
			unset($registro["categoria_nombre"]);
			$registro["id_categoria"]=$categoriasDb[normalizarZulia($categoriaNombre)];
			$parametros=array();foreach($registro as $clave=>$valor)$parametros[":".$clave]=$valor;
			$stmtInsertar->execute($parametros);
			$reporte["insertados"]++;
		}
		$db->commit();
	}
}catch(Throwable $error){
	if(isset($db) && $db->inTransaction()) $db->rollBack();
	$reporte["fallo"]=$error->getMessage();
}

$dirReportes=__DIR__."/reportes";if(!is_dir($dirReportes))mkdir($dirReportes,0775,true);
$rutaReporte=$dirReportes."/inventario_zulia_".date("Ymd_His")."_".$reporte["modo"].".json";
file_put_contents($rutaReporte,json_encode($reporte,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
echo json_encode($reporte,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)."\nREPORTE: ".realpath($rutaReporte)."\n";
exit(isset($reporte["fallo"])?1:0);

