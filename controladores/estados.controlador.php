<?php
class ControladorEstados{    


	/*=============================================
	MOSTRAR participante
	=============================================*/

	static public function ctrMostrarEstados($item, $valor){

		$tabla = "estados";

		$respuesta = ModeloEstados::mdlMostrarEstados($tabla, $item, $valor);

		return $respuesta;
	}
}

