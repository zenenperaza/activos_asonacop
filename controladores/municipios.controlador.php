<?php
class ControladorMunicipios{    


	/*=============================================
	MOSTRAR participante
	=============================================*/

	static public function ctrMostrarMunicipios($item, $valor){

		$tabla = "municipios";

		$respuesta = ModeloMunicipios2::mdlMostrarMunicipios($tabla, $item, $valor);

		return $respuesta;
	}
}

