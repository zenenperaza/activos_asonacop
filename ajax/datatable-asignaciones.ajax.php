<?php

require_once "../controladores/activos.controlador.php";
require_once "../modelos/activos.modelo.php";


class TablaActivosAsignaciones{

 	/*=============================================
 	 MOSTRAR LA TABLA DE ASIGNACIONES
 	
  	=============================================*/ 

	public function mostrarTablaActivosAsignaciones(){

		$item = null;
    	$valor = null;
    	$orden = "id";

  		$activos = ControladorActivos::ctrMostrarActivos($item, $valor, $orden);	
		
  		if(count($activos) == 0){

  			echo '{"data": []}';

		  	return;
  		}
		
  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($activos); $i++){

		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 

		  	$imagen = "<img src='".$activos[$i]["imagen"]."' width='40px'>";

		  	/*=============================================
 	 		STOCK
  			=============================================*/ 

  			if($activos[$i]["stock"] <= 10){

  				$stock = "<button class='btn btn-danger'>".$activos[$i]["stock"]."</button>";

  			}else if($activos[$i]["stock"] > 11 && $activos[$i]["stock"] <= 15){

  				$stock = "<button class='btn btn-warning'>".$activos[$i]["stock"]."</button>";

  			}else{

  				$stock = "<button class='btn btn-success'>".$activos[$i]["stock"]."</button>";

  			}

		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 

		  	$botones =  "<div class='btn-group'><button class='btn btn-primary agregarActivo recuperarBoton' idActivo='".$activos[$i]["id"]."'>Agregar</button></div>"; 

		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$activos[$i]["codigo"].'",
			      "'.$activos[$i]["descripcion"].'",
			      "'.$stock.'",
			      "'.$botones.'"
			    ],';

		  }

		  $datosJson = substr($datosJson, 0, -1);

		 $datosJson .=   '] 

		 }';
		
		echo $datosJson;


	}


}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
$activarActivosAsignaciones = new TablaActivosAsignaciones();
$activarActivosAsignaciones -> mostrarTablaActivosAsignaciones();

