<?php

require_once "conexion.php";

class ModeloActivos{

	/*=============================================
	MOSTRAR Activos
	=============================================*/

	static public function mdlMostrarActivos($tabla, $item, $valor, $orden){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE ACTIVO
  
  INSERT INTO `activos` (`id`, `id_categoria`, `codigo`, `codigo_uf`, `descripcion`, `fecha_adquisicion`, `fuente_financiamiento`, `origen_activo`, `situacion_contable`, `ubicacion_fisica`, `responsable`, `fecha_entrega_res`, `estado_conservacion`, `info_garantia`, `observaciones`, `imagen`, `stock`, `precio_compra_bs`, `precio_compra_ds`, `asignaciones`, `fecha_reg`) VALUES (NULL, '1', '199', 'LAR', 'MUEBLES', '20/08/2020', 'UNESCO', 'COMPRA', 'BUENA', 'LARA', 'ZENEN', '12/01/1980', 'BUNEO', 'SIN', 'SIN', 'FOTO.JPG', '1', '1', '1', '0', current_timestamp())
  
   INSERT INTO $tabla (`id_categoria`, `codigo`, `codigo_uf`, `descripcion`, `fecha_adquisicion`, `fuente_financiamiento`, 
    `origen_activo`, `situacion_contable`, `ubicacion_fisica`, `responsable`, `fecha_entrega_res`, `estado_conservacion`, 
    `info_garantia`, `observaciones`, `imagen`, `stock`, `precio_compra_bs`, `precio_compra_ds`) 
    VALUES (:id_categoria, :codigo, :codigo_uf, :descripcion, :fecha_adquisicion, :fuente_financiamiento, :origen_activo,
    :situacion_contable, :ubicacion_fisica, :responsable, :fecha_entrega_res, :estado_conservacion, :info_garantia,
    :observaciones, :imagen, :stock, :precio_compra_bs, :precio_compra_ds)
    
    INSERT INTO $tabla 
        (`id_categoria`, `codigo`, `codigo_uf`, `descripcion`, `fecha_adquisicion`, 
        `fuente_financiamiento`, `origen_activo`, `situacion_contable`, `ubicacion_fisica`, 
        `responsable`, `fecha_entrega_res`, `estado_conservacion`, `info_garantia`, `observaciones`, 
        `imagen`, `stock`, `precio_compra_bs`, `precio_compra_ds`) 
    VALUES ( ".$datos['id_categoria']." , ".$datos['codigo']." , ".$datos['codigo_uf']." , ".$datos['descripcion']." , 
    ".$datos['fecha_adquisicion']." , ".$datos['fuente_financiamiento']." , ".$datos['origen_activo']." , ".$datos['situacion_contable']." , 
    ".$datos['responsable']." , 
    ".$datos['fecha_entrega_res']." , ".$datos['estado_conservacion']." , ".$datos['info_garantia']." ,
    ".$datos['observaciones']." , ".$datos['imagen']." , 
    ".$datos['stock']." , ".$datos['precio_compra_bs']." , ".$datos['precio_compra_ds']." , ".$datos['ubicacion_fisica'].")
	=============================================*/
	static public function mdlIngresarActivo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (`id_categoria`, `codigo`, `codigo_uf`, `descripcion`, `fecha_adquisicion`, `fuente_financiamiento`, 
    `origen_activo`, `situacion_contable`, `ubicacion_fisica`, `responsable`, `fecha_entrega_res`, `estado_conservacion`, 
    `info_garantia`, `observaciones`, `imagen`, `stock`, `precio_compra_bs`, `precio_compra_ds`) 
    VALUES (:id_categoria, :codigo, :codigo_uf, :descripcion, :fecha_adquisicion, :fuente_financiamiento, :origen_activo,
    :situacion_contable, :ubicacion_fisica, :responsable, :fecha_entrega_res, :estado_conservacion, :info_garantia,
    :observaciones, :imagen, :stock, :precio_compra_bs, :precio_compra_ds)");

		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_uf", $datos["codigo_uf"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_adquisicion", $datos["fecha_adquisicion"], PDO::PARAM_STR);
		$stmt->bindParam(":fuente_financiamiento", $datos["fuente_financiamiento"], PDO::PARAM_STR);
		$stmt->bindParam(":origen_activo", $datos["origen_activo"], PDO::PARAM_STR);
		$stmt->bindParam(":situacion_contable", $datos["situacion_contable"], PDO::PARAM_STR);
		$stmt->bindParam(":ubicacion_fisica", $datos["ubicacion_fisica"], PDO::PARAM_STR);
		$stmt->bindParam(":responsable", $datos["responsable"], PDO::PARAM_STR);
		$stmt->bindParam(":estado_conservacion", $datos["estado_conservacion"], PDO::PARAM_STR);
		$stmt->bindParam(":info_garantia", $datos["info_garantia"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_entrega_res", $datos["fecha_entrega_res"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra_bs", $datos["precio_compra_bs"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra_ds", $datos["precio_compra_ds"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());
		
		}

// 		$stmt->close();
// 		$stmt = null;

	}

	/*=============================================
	EDITAR ACTIVO
	=============================================*/
	static public function mdlEditarActivo($tabla, $datos){
 
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :id_categoria, codigo_uf = :codigo_uf, descripcion = :descripcion, fecha_adquisicion = :fecha_adquisicion, fuente_financiamiento = :fuente_financiamiento, origen_activo = :origen_activo, situacion_contable = :situacion_contable, ubicacion_fisica = :ubicacion_fisica, responsable = :responsable, fecha_entrega_res = :fecha_entrega_res, estado_conservacion = :estado_conservacion, info_garantia = :info_garantia, observaciones = :observaciones, imagen = :imagen, stock = :stock, precio_compra_bs = :precio_compra_bs, precio_compra_ds = :precio_compra_ds WHERE codigo = :codigo");

		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_uf", $datos["codigo_uf"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_adquisicion", $datos["fecha_adquisicion"], PDO::PARAM_STR);
		$stmt->bindParam(":fuente_financiamiento", $datos["fuente_financiamiento"], PDO::PARAM_STR);
		$stmt->bindParam(":origen_activo", $datos["origen_activo"], PDO::PARAM_STR);
		$stmt->bindParam(":situacion_contable", $datos["situacion_contable"], PDO::PARAM_STR);
		$stmt->bindParam(":ubicacion_fisica", $datos["ubicacion_fisica"], PDO::PARAM_STR);
		$stmt->bindParam(":responsable", $datos["responsable"], PDO::PARAM_STR);
		$stmt->bindParam(":estado_conservacion", $datos["estado_conservacion"], PDO::PARAM_STR);
		$stmt->bindParam(":info_garantia", $datos["info_garantia"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_entrega_res", $datos["fecha_entrega_res"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra_bs", $datos["precio_compra_bs"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra_ds", $datos["precio_compra_ds"], PDO::PARAM_STR);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR ACTIVO
	=============================================*/

	static public function mdlEliminarActivo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
    
    /*=============================================
	ACTUALIZAR ACTIVO
	=============================================*/

	static public function mdlActualizarActivo($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}


	/*=============================================
	MOSTRAR SUMA ASIGNACIONES
	=============================================*/	

	static public function mdlMostrarSumaAsignaciones($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(asignaciones) as total FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}


}