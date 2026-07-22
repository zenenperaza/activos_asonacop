<?php

require_once "conexion.php";

class ModeloProveedores{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function mdlMostrarProveedores($tabla, $item, $valor){

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

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarProveedor($tabla, $datos){
    
//          echo '<pre>';
//       var_dump($datos["nombre"]);
//        echo '</pre>';
//       return;
    
//     INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `direccion`, `rif`, `contacto`, `porcentaje_retencion`, `codigo_retencion`, `telefono1`, `telefono2`, `email`, `tipo_persona`, `fecha_modificacion`, `fecha_creacion`) 
//       VALUES (NULL, 'ZENEN PWERAA', 'LAS VERITAS', 'J123369987', 'ZENEN PERAZA', '16', 'PUBLICO', '04245034999', '04169556181', 'PERAZA@OUTLOOK.COM', NULL, current_timestamp(), '22-07-2022');

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (`id_proveedor`, `nombre`, `direccion`, `rif`, `contacto`, `porcentaje_retencion`, `codigo_retencion`, `telefono1`, `telefono2`, `email`, `tipo_persona`, `fecha_creacion`) 
      VALUES (NULL, :nombre, :direccion, :rif, :contacto, :porcentaje_retencion, :codigo_retencion, :telefono1, :telefono2, :email, :tipo_persona , :fecha_creacion)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":rif", $datos["rif"], PDO::PARAM_STR);
		$stmt->bindParam(":contacto", $datos["contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":porcentaje_retencion", $datos["porcentaje_retencion"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo_retencion", $datos["codigo_retencion"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_persona", $datos["tipo_persona"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono1", $datos["telefono1"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono2", $datos["telefono2"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_creacion", $datos["fecha_creacion"], PDO::PARAM_STR);
    
//              echo '<pre>';
//       var_dump($stmt->execute());
//        echo '</pre>';
//       return;

		if($stmt->execute()){

			return "ok";	

		}else{

				return print_r($stmt->errorInfo());
		
		}

		$stmt->close();
		
		$stmt = null;

	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarProveedor($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, direccion = :direccion, rif = :rif, contacto = :contacto, porcentaje_retencion = :porcentaje_retencion,
    codigo_retencion = :codigo_retencion, tipo_persona = :tipo_persona, telefono1 = :telefono1, telefono2 = :telefono2, email = :email WHERE id_proveedor = :id_proveedor");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt -> bindParam(":rif", $datos["rif"], PDO::PARAM_STR);
		$stmt -> bindParam(":contacto", $datos["contacto"], PDO::PARAM_STR);
		$stmt -> bindParam(":porcentaje_retencion", $datos["porcentaje_retencion"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo_retencion", $datos["codigo_retencion"], PDO::PARAM_STR);
		$stmt -> bindParam(":tipo_persona", $datos["tipo_persona"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono1", $datos["telefono1"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono2", $datos["telefono2"], PDO::PARAM_STR);
		$stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarProveedor($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarProveedor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_proveedor = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;


	}

}