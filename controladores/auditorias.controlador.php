<?php

class ControladorAuditorias{

	/*=============================================
	MOSTRAR Activos
	=============================================*/

	static public function ctrMostrarAuditorias($item, $valor){
    
    $tabla = "auditorias";

		$respuesta = ModeloAuditorias::mdlMostrarAuditorias($tabla, $item, $valor);

		return $respuesta;
      
   
  }
  static public function ctrIngresarAuditorias($usuario, $accion){	
      
				$tabla = "auditorias";          
       
				$respuesta = ModeloAuditorias::mdlIngresarAuditoria($tabla, $usuario, $accion);    
  }
  
  
    
    
  
  
}