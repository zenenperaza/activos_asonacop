<?php

require_once __DIR__."/../modelos/conexion.php";

header("Content-Type: application/json; charset=utf-8");

$draw = isset($_GET["draw"]) ? (int) $_GET["draw"] : 0;
$inicio = isset($_GET["start"]) ? max(0, (int) $_GET["start"]) : 0;
$cantidad = isset($_GET["length"]) ? (int) $_GET["length"] : 50;
$cantidad = $cantidad === -1 ? 500 : min(max($cantidad, 10), 500);
$busqueda = isset($_GET["search"]["value"]) ? trim($_GET["search"]["value"]) : "";
$oficina = isset($_GET["oficina"]) ? trim($_GET["oficina"]) : "";

$columnasOrden = array(
	"a.id",
	"a.imagen",
	"a.codigo",
	"c.categoria",
	"a.descripcion",
	"a.serial_numero",
	"a.origen_activo",
	"a.situacion_contable",
	"e.nombre",
	"a.ubicacion_fisica",
	"a.stock",
	"a.precio_compra_bs",
	"a.precio_compra_ds",
	"a.fecha_adquisicion",
	"a.observaciones",
	"a.id"
);

$columnaSolicitada = isset($_GET["order"][0]["column"]) ? (int) $_GET["order"][0]["column"] : 0;
$columnaOrden = isset($columnasOrden[$columnaSolicitada]) ? $columnasOrden[$columnaSolicitada] : "a.id";
$direccionOrden = isset($_GET["order"][0]["dir"]) && strtolower($_GET["order"][0]["dir"]) === "asc" ? "ASC" : "DESC";

$desde = " FROM activos a
		   LEFT JOIN categorias c ON c.id = a.id_categoria
		   LEFT JOIN empleados e ON e.id = a.responsable";

$condiciones = array();
$parametros = array();

if($oficina !== ""){
	$condiciones[] = "a.ubicacion_fisica = ?";
	$parametros[] = $oficina;
}

if($busqueda !== ""){
	$camposBusqueda = array(
		"a.id",
		"CONCAT(a.codigo_uf, '-', a.codigo)",
		"c.categoria",
		"a.descripcion",
		"a.serial_numero",
		"a.origen_activo",
		"a.situacion_contable",
		"e.nombre",
		"a.ubicacion_fisica",
		"a.stock",
		"a.precio_compra_bs",
		"a.precio_compra_ds",
		"a.fecha_adquisicion",
		"a.observaciones"
	);

	$busquedas = array();
	foreach($camposBusqueda as $campo){
		$busquedas[] = $campo." LIKE ?";
		$parametros[] = "%".$busqueda."%";
	}
	$condiciones[] = "(".implode(" OR ", $busquedas).")";
}

$donde = count($condiciones) ? " WHERE ".implode(" AND ", $condiciones) : "";

try{
	$conexion = Conexion::conectar();
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$totalActivos = (int) $conexion->query("SELECT COUNT(*) FROM activos")->fetchColumn();

	$stmtFiltrados = $conexion->prepare("SELECT COUNT(*)".$desde.$donde);
	$stmtFiltrados->execute($parametros);
	$totalFiltrados = (int) $stmtFiltrados->fetchColumn();

	$sql = "SELECT a.*, c.categoria, e.nombre AS nombre_responsable"
		 .$desde
		 .$donde
		 ." ORDER BY ".$columnaOrden." ".$direccionOrden
		 ." LIMIT ".$inicio.", ".$cantidad;

	$stmt = $conexion->prepare($sql);
	$stmt->execute($parametros);
	$activos = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$datos = array();

	foreach($activos as $indice => $activo){
		$rutaImagen = htmlspecialchars($activo["imagen"], ENT_QUOTES, "UTF-8");
		$imagen = "<img src='".$rutaImagen."' width='40px' loading='lazy'>";

		if((int) $activo["stock"] <= 10){
			$stock = "<button class='btn btn-danger'>".(int) $activo["stock"]."</button>";
		}else if((int) $activo["stock"] <= 15){
			$stock = "<button class='btn btn-warning'>".(int) $activo["stock"]."</button>";
		}else{
			$stock = "<button class='btn btn-success'>".(int) $activo["stock"]."</button>";
		}

		$id = (int) $activo["id"];
		$codigoActivo = htmlspecialchars($activo["codigo"], ENT_QUOTES, "UTF-8");
		$botones = "<div class='btn-group'>"
				 ."<button class='btn btn-warning btnEditarActivo' idActivo='".$id."' data-toggle='modal' data-target='#modalEditarActivo'><i class='fa fa-pencil'></i></button>"
				 ."<button class='btn btn-danger btnEliminarActivo' idActivo='".$id."' codigo='".$codigoActivo."' imagen='".$rutaImagen."'><i class='fa fa-times'></i></button>"
				 ."</div>";

		$precioBs = is_numeric($activo["precio_compra_bs"])
			? "Bs. ".number_format((float) $activo["precio_compra_bs"], 2, ",", ".")
			: "Bs. ".$activo["precio_compra_bs"];

		$datos[] = array(
			$id,
			$imagen,
			$activo["codigo_uf"]."-".$activo["codigo"],
			$activo["categoria"] ?: "",
			$activo["descripcion"],
			$activo["serial_numero"],
			$activo["origen_activo"],
			$activo["situacion_contable"],
			$activo["nombre_responsable"] ?: "",
			$activo["ubicacion_fisica"],
			$stock,
			$precioBs,
			$activo["precio_compra_ds"],
			$activo["fecha_adquisicion"],
			$activo["observaciones"],
			$botones
		);
	}

	echo json_encode(array(
		"draw" => $draw,
		"recordsTotal" => $totalActivos,
		"recordsFiltered" => $totalFiltrados,
		"data" => $datos
	), JSON_UNESCAPED_UNICODE);

}catch(Exception $error){
	http_response_code(500);
	echo json_encode(array(
		"draw" => $draw,
		"recordsTotal" => 0,
		"recordsFiltered" => 0,
		"data" => array(),
		"error" => "No se pudieron cargar los activos."
	));
}
