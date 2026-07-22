<?php
session_start();

class ControladorProveedores{

	/*=============================================
	INGRESO DE USUARIO
	=============================================*/

	static public function ctrIngresoProveedor(){

		if(isset($_POST["ingProveedor"])){

			if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["ingProveedor"]) &&  
         preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){

         $encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla = "proveedores";

				$item = "proveedor";
				$valor = $_POST["ingProveedor"];

				$respuesta = ModeloProveedores::MdlMostrarProveedores($tabla, $item, $valor);

				if($respuesta["proveedor"] == $_POST["ingProveedor"] && $respuesta["password"] == $encriptar){
                    
                   if($respuesta["estado"] == 1){

						$_SESSION["iniciarSesion"] = "ok";
						$_SESSION["id"] = $respuesta["id"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["proveedor"] = $respuesta["proveedor"];
						$_SESSION["foto"] = $respuesta["foto"];
						$_SESSION["perfil"] = $respuesta["perfil"];
                     

						/*=============================================
						AUDITORIA
						=============================================*/
            $crearAuditoria = new ControladorAuditorias();
            $proveedor = $respuesta["proveedor"];  
            $accion = "Ingresó al Sistema";         
            $crearAuditoria -> ctrIngresarAuditorias($proveedor, $accion);


						/*=============================================
						REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
						=============================================*/

						date_default_timezone_set('America/Caracas');

						$fecha = date('Y-m-d');
						$hora = date('H:i:s');

						$fechaActual = $fecha.' '.$hora;

						$item1 = "ultimo_login";
						$valor1 = $fechaActual;

						$item2 = "id";
						$valor2 = $respuesta["id"];

						$ultimoLogin = ModeloProveedores::mdlActualizarProveedor($tabla, $item1, $valor1, $item2, $valor2);

						if($ultimoLogin == "ok"){

							echo '<script>

								window.location = "inicio";

							</script>';

						}				
						
					}else{

						echo '<br>
							<div class="alert alert-danger">El proveedor aún no está activado</div>';

					}		



				}else{

					echo '<br><div class="alert alert-danger">Error al ingresar, Datos incorrectos, vuelve a intentarlo</div>';

				}

			}	else{

					echo '<br><div class="alert alert-danger">Error al ingresar, Datos incorrectos, vuelve a intentarlo</div>';

				}

		}

	}
    
    	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function ctrCrearProveedor(){

		if(isset($_POST["nombre"])){		

				$tabla = "proveedores";
      
      $fecha_creacion = date('d-m-Y');
                
				$datos = array("nombre" => strtolower($_POST["nombre"]),
					           "direccion" => $_POST["direccion"],
					           "rif" => $_POST["rif"],
					           "contacto" => strtolower($_POST["contacto"]),
					           "porcentaje_retencion"=>$_POST["porcentaje_retencion"],
					           "codigo_retencion"=>$_POST["codigo_retencion"],
					           "tipo_persona"=>$_POST["tipo_persona"],
					           "telefono1"=>$_POST["telefono"],
					           "telefono2"=>$_POST["telefono2"],
					           "email"=>$_POST["email"],
					           "fecha_creacion"=>$fecha_creacion);
      
//      echo '<pre>';
//       var_dump($datos);
//        echo '</pre>';
//       return;
     /*=============================================
      AUDITORIA
      =============================================*/
//       $tablaAuditoria = "proveedores";
//       $itemAuditoria = "id";
//       $valorAuditoria = $_GET["idProveedor"];
//       $respuestaAuditoria = ModeloProveedores::MdlMostrarProveedores($tablaAuditoria, $itemAuditoria, $valorAuditoria);
      
      $crearAuditoria = new ControladorAuditorias();
      $usuario = $_SESSION["usuario"];  
      $accion = "Agregar nuevo proveedor - ".$_POST["nombre"];         
      $crearAuditoria -> ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

				$respuesta = ModeloProveedores::mdlIngresarProveedor($tabla, $datos);    
// echo $respuesta;
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡El proveedor ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "proveedores";

						}

					});
				

					</script>';


				}
//       else {
//           				echo '<script>

// 					swal({

// 						type: "error",
// 						title: "¡Error al ingresar en la DB!",
// 						showConfirmButton: true,
// 						confirmButtonText: "Cerrar"

// 					}).then(function(result){

// 						if(result.value){
						
// 							window.location = "proveedores";

// 						}

// 					});
				

// 					</script>';
//         }





		}


	}
    
    /*=============================================
	MOSTRAR USUARIO
	=============================================*/

	static public function ctrMostrarProveedores($item, $valor){

		$tabla = "proveedores";

		$respuesta = ModeloProveedores::MdlMostrarProveedores($tabla, $item, $valor);

		return $respuesta;
	}

/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function ctrEditarProveedor(){

		if(isset($_POST["btnEditarProveedor"])){

				
				$tabla = "proveedores";

				$datos = array("nombre" => $_POST["nombreEditar"],
							   "direccion" => $_POST["nombreEditar"],
							   "rif" => $_POST["rifEditar"],
							   "contacto" => $_POST["contactoEditar"],
							   "porcentaje_retencion" => $_POST["porcentaje_retencion_editar"],
							   "codigo_retencion" => $_POST["codigo_retencion_editar"],
							   "tipo_persona" => $_POST["tipo_persona_editar"],
							   "telefono1" => $_POST["telefonoEditar"],
							   "telefono2" => $_POST["telefonoEditar2"],
							   "email" => $_POST["emailEditar"],
							   "id_proveedor" => $_POST["idProveedor"]);
        
      /*=============================================
      AUDITORIA
      =============================================*/
      $tablaAuditoria = "proveedores";
      $itemAuditoria = "id_proveedor";
      $valorAuditoria = $_POST["idProveedor"];
      $respuestaAuditoria = ModeloProveedores::mdlMostrarProveedores($tablaAuditoria, $itemAuditoria, $valorAuditoria);
      
      $crearAuditoria = new ControladorAuditorias();
      $usuario = $_SESSION["usuario"];  
      $accion = "Editar proveedor - ".$respuestaAuditoria["nombre"];         
      $crearAuditoria -> ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

				$respuesta = ModeloProveedores::mdlEditarProveedor($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El proveedor ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "proveedores";

									}
								})

					</script>';

				}
        
		}

	}
    /*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function ctrBorrarProveedor(){

		if(isset($_GET["idProveedor"])){

			$tabla ="proveedores";
			$datos = $_GET["idProveedor"];

		      
      /*=============================================
      AUDITORIA
      =============================================*/
      $tablaAuditoria = "proveedores";
      $itemAuditoria = "id";
      $valorAuditoria = $_GET["idProveedor"];
      $respuestaAuditoria = ModeloUsuarios::MdlMostrarUsuarios($tablaAuditoria, $itemAuditoria, $valorAuditoria);
      
      $crearAuditoria = new ControladorAuditorias();
      $usuario = $_SESSION["usuario"];  
      $accion = "Borrar proveedor - ".$respuestaAuditoria['nombre'];         
      $crearAuditoria -> ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

			$respuesta = ModeloProveedores::mdlBorrarProveedor($tabla, $datos);
      


			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El proveedor ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "proveedores";

								}
							})

				</script>';

			}		
    

}
}
}
	


