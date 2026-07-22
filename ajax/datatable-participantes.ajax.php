<?php

require_once "../controladores/participantes.controlador.php";
require_once "../modelos/participantes.modelo.php";

require_once "../controladores/estados.controlador.php";
require_once "../modelos/estados.modelo.php";

require_once "../controladores/municipios.controlador.php";
require_once "../modelos/municipios.modelo.php";



class TablaParticipantes{

 	/*=============================================
 	 MOSTRAR LA TABLA DE Participantes
  	=============================================*/ 

	public function mostrarTablaParticipantes(){
 
		$item = null;
    	$valor = null;
    	$orden = "id";

  		$participantes = ControladorParticipantes::ctrMostrarParticipantes($item, $valor, $orden);	
  		
  		if(count($participantes) == 0){

  			echo '{"data": []}';

		  	return;
  		}
		
  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($participantes); $i++){      
              
        $nombreCompleto = $participantes[$i]["primer_nombre"]." ".$participantes[$i]["primer_apellido"];
        
          //$nombreCompleto=utf8_decode($nombreCompleto);
          //$nombreCompleto = ucfirst($nombreCompleto);
        $nombreCompleto = ucwords(strtolower($nombreCompleto));
        $nombres =  "<div class='text-uppercase'>$nombreCompleto</div>";
        
          //$nombreCompleto=utf8_encode($nombreCompleto);
                //ucfirst() 
        
        
        
        	  $item = "id";
		        $valor = $participantes[$i]["estado"];
		        $estados = ControladorEstados::ctrMostrarEstados($item, $valor);
        
//           $item = "id";
// 		      $valor = $participantes[$i]["municipio"];
// 		      $municipios = ControladorMunicipios::ctrMostrarMunicipios($item, $valor);
        

		  	
		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 
        
        /*
        <button class='btn btn-warning btnEditarParticipante' idParticipante='".$participantes[$i]["id"]."' data-toggle='modal' data-target='#modalEditarParticipante'><i class='fa fa-pencil'></i></button>
        */

		  	$botones =  "<div class='btn-group'><button class='btn btn-danger btnEliminarParticipante' id='".$participantes[$i]["id"]."' ><i class='fa fa-times'></i></button></div>"; 

		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$nombres.'",
			      "'.$participantes[$i]["cedula"].'",
			      "'.$participantes[$i]["email"].'",
			      "'.$estados["nombre"].'",
			      "'.$participantes[$i]["fecha"].'",	
			      "'.$botones.'"
			    ],';

		  }

		  $datosJson = substr($datosJson, 0, -1);

		 $datosJson .=   '] 

		 }';
		
		echo $datosJson;


	}
  /**
  
			      "'.$participantes[$i]["profesion"].'",
  
			      "'.$municipios["nombre"].'",
  
  */


}

/*=============================================
ACTIVAR TABLA DE participantes
=============================================*/ 
$activarParticipantes = new TablaParticipantes();
$activarParticipantes -> mostrarTablaParticipantes();

