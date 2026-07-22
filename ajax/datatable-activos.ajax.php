<?php

require_once "../controladores/activos.controlador.php";
require_once "../modelos/activos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

require_once "../controladores/empleados.controlador.php";
require_once "../modelos/empleados.modelo.php";


class TablaActivos{

 	/*=============================================
 	 MOSTRAR LA TABLA DE Activos
  	=============================================*/ 

	public function mostrarTablaActivos(){
 
		$item = null;
    	$valor = null;
    	$orden = "id";

  		$activos = ControladorActivos::ctrMostrarActivos($item, $valor, $orden);	
  		
  		if(count($activos) == 0){

  			echo '{"data": []}';

		  	return;
  		}

		$datos = array();

		for($i = 0; $i < count($activos); $i++){

			// Imagen
			$imagen = "<img src='".$activos[$i]["imagen"]."' width='40px'>";

			// Categoria
			$item = "id";
			$valor = $activos[$i]["id_categoria"];
			$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

			// Responsable
			$itemResp = "id";
			$valorResp = $activos[$i]["responsable"];
			$responsables = ControladorEmpleados::ctrMostrarEmpleados($itemResp, $valorResp);

			// Stock
			if($activos[$i]["stock"] <= 10){
				$stock = "<button class='btn btn-danger'>".$activos[$i]["stock"]."</button>";
			}else if($activos[$i]["stock"] > 11 && $activos[$i]["stock"] <= 15){
				$stock = "<button class='btn btn-warning'>".$activos[$i]["stock"]."</button>";
			}else{
				$stock = "<button class='btn btn-success'>".$activos[$i]["stock"]."</button>";
			}

			// Botones
			$botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarActivo' idActivo='".$activos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarActivo'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarActivo' idActivo='".$activos[$i]["id"]."' codigo='".$activos[$i]["codigo"]."' imagen='".$activos[$i]["imagen"]."'><i class='fa fa-times'></i></button></div>";

			$codigo = $activos[$i]["codigo_uf"]."-".$activos[$i]["codigo"];

			$precio_compra_bs = number_format($activos[$i]["precio_compra_bs"], 2, ',', '.');
			$precio_compra_ds = $activos[$i]["precio_compra_ds"];
			$precio_compra_bs = "Bs. ".$precio_compra_bs;

			$datos[] = array(
				($i+1),
				$imagen,
				$codigo,
				isset($categorias["categoria"]) ? $categorias["categoria"] : '',
				$activos[$i]["descripcion"],
				$activos[$i]["serial_numero"],
				$activos[$i]["origen_activo"],
				$activos[$i]["situacion_contable"],
				isset($responsables["nombre"]) ? $responsables["nombre"] : '',
				$activos[$i]["ubicacion_fisica"],
				$stock,
				$precio_compra_bs,
				$precio_compra_ds,
				$activos[$i]["fecha_adquisicion"],
				$activos[$i]["observaciones"],
				$botones
			);

		}

		echo json_encode(array("data" => $datos));


	}


}

/*=============================================
ACTIVAR TABLA DE activos
=============================================*/ 
$activarActivos = new TablaActivos();
$activarActivos -> mostrarTablaActivos();

