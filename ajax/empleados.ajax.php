<?php

require_once "../controladores/empleados.controlador.php";
require_once "../modelos/empleados.modelo.php";

class AjaxEmpleados{

	/*=============================================
	EDITAR EMPLEADO
	=============================================*/	

	public $idEmpleado;

	public function ajaxEditarEmpleado(){

		$item = "id";
		$valor = $this->idEmpleado;

		$respuesta = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	ACTIVAR EMPLEADO
	=============================================*/	

	public $activarEmpleado;
	public $activarId;


	public function ajaxActivarEmpleado(){

		$tabla = "empleados";

		$item1 = "estado";
		$valor1 = $this->activarEmpleado;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloEmpleados::mdlActualizarEstadoEmpleado($tabla, $item1, $valor1, $item2, $valor2);

	}

	/*=============================================
	VALIDAR NO REPETIR EMPLEADO
	=============================================*/	

	public $validarEmpleado;

	public function ajaxValidarEmpleado(){

		$item = "cedula";
		$valor = $this->validarEmpleado;

		$respuesta = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

		echo json_encode($respuesta);

	}
    
}

/*=============================================
EDITAR EMPLEADO
=============================================*/
if(isset($_POST["idEmpleado"])){

	$editar = new AjaxEmpleados();
	$editar -> idEmpleado = $_POST["idEmpleado"];
	$editar -> ajaxEditarEmpleado();

}

/*=============================================
ACTIVAR EMPLEADO
=============================================*/	

if(isset($_POST["activarEmpleado"])){

	$activarEmpleado = new AjaxEmpleados();
	$activarEmpleado -> activarEmpleado = $_POST["activarEmpleado"];
	$activarEmpleado -> activarId = $_POST["activarId"];
	$activarEmpleado -> ajaxActivarEmpleado();

}

/*=============================================
VALIDAR NO REPETIR EMPLEADO
=============================================*/

if(isset( $_POST["validarEmpleado"])){

	$valEmpleado = new AjaxEmpleados();
	$valEmpleado -> validarEmpleado = $_POST["validarEmpleado"];
	$valEmpleado -> ajaxValidarEmpleado();

}