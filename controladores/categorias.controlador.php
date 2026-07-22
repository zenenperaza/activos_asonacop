<?php

class ControladorCategorias{

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearCategoria(){

		if(isset($_POST["nuevaCategoria"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaCategoria"])){

				$tabla = "categorias";
                

                $datos = $_POST["nuevaCategoria"];
                $datos = strtoupper($datos);

				$respuesta = ModeloCategorias::mdlIngresarCategoria($tabla, $datos);

				if($respuesta == "ok"){
    /*=============================================
      AUDITORIA
      =============================================*/
//       $tablaAuditoria = "usuarios";
//       $itemAuditoria = "id";
//       $valorAuditoria = $_GET["idUsuario"];
//       $respuestaAuditoria = ModeloUsuarios::MdlMostrarUsuarios($tablaAuditoria, $itemAuditoria, $valorAuditoria);
      
//       $crearAuditoria = new ControladorAuditorias();
      $usuario = $_SESSION["usuario"];  
      $accion = "Ingresar nuevo Categoria - ".$_POST["nuevaCategoria"];         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

					echo'<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "categorias";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "categorias";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarCategorias($item, $valor){

		$tabla = "categorias";

		$respuesta = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarCategoria(){

		if(isset($_POST["editarCategoria"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCategoria"])){

				$tabla = "categorias";
                
                $editarCategoria = $_POST["editarCategoria"];
                $editarCategoria = strtoupper($editarCategoria);


				$datos = array("categoria"=>$editarCategoria,
							   "id"=>$_POST["idCategoria"]);

				$respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);

				if($respuesta == "ok"){
        /*=============================================
      AUDITORIA
      =============================================*/

      $usuario = $_SESSION["usuario"];  
      $accion = "Modificar Categoria - ".$editarCategoria;         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

					echo'<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "categorias";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "categorias";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrBorrarCategoria(){

		if(isset($_GET["idCategoria"])){

			$tabla ="categorias";
			$datos = $_GET["idCategoria"];
       /*=============================================
      AUDITORIA
      =============================================*/
      $tablaAuditoria = "categorias";
      $itemAuditoria = "id";
      $valorAuditoria = $_GET["idCategoria"];
      $respuestaAuditoria = ModeloCategorias::mdlMostrarCategorias($tablaAuditoria, $itemAuditoria, $valorAuditoria);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 


			$respuesta = ModeloCategorias::mdlBorrarCategoria($tabla, $datos);

			if($respuesta == "ok"){
        
 /*=============================================
      AUDITORIA
      =============================================*/

      $usuario = $_SESSION["usuario"];  
      $accion = "Borrar Categoria - ".$respuestaAuditoria['categoria'];         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

				echo'<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "categorias";

									}
								})

					</script>';
			}
		}
		
	}
}
