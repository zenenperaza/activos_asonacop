<?php

require_once "conexion.php";

class ModeloAuditorias{
  
  	/*=============================================
	MOSTRAR AUDITORIA
	=============================================*/

	static public function mdlMostrarAuditorias($tabla, $item, $valor){
    
    if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		

		$stmt -> close();

		$stmt = null;
    
  
}
  
  static public function mdlIngresarAuditoria($tabla, $usuario, $accion){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (`usuario`, `accion`, `fecha`) 
    VALUES (:usuario, :accion, CURRENT_TIME())");

		$stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
		$stmt->bindParam(":accion", $accion, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());
		
		}

// 		$stmt->close();
// 		$stmt = null;

	}

  
  
  
  
  
  
}