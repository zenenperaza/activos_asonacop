<?php

require_once "../../../modelos/conexion.php";


class ControladorEmpleados{

	
   
    
    /*=============================================
	MOSTRAR empleado
	=============================================*/

	static public function ctrMostrarEmpleados($item, $valor){

		$tabla = "empleados";

		$respuesta = ModeloEmpleados::MdlMostrarEmpleados($tabla, $item, $valor);

		return $respuesta;
	}

}

class ModeloEmpleados{

	/*=============================================
	MOSTRAR EMPLEADOS
	=============================================*/

	static public function mdlMostrarEmpleados($tabla, $item, $valor){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();
		$stmt -> close();

		$stmt = null;

	}

	
}