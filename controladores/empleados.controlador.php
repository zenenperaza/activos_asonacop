<?php

class ControladorEmpleados{

	
    /*=============================================
	REGISTRO DE EMPLEADOS
    nuevaCedula
    nuevoNombre
    nuevoApellido
    nuevoTelefono
    nuevoEmail
    nuevaDireccion
	=============================================*/

	static public function ctrCrearEmpleado(){

		if(isset($_POST["nuevaCedula"])){
       
			if($_POST["nuevaCedula"] && $_POST["nuevoNombre"]){

			   /*=============================================
				VALIDAR IMAGEN 
				=============================================*/

				$ruta = "vistas/img/empleados/default/anonymous.png";

			    	if(isset($_FILES["nuevaFoto"]["tmp_name"]) AND !empty($_FILES["nuevaFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/empleados/".$_POST["nuevaCedula"];

					mkdir($directorio, 0755);

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/empleados/".$_POST["nuevaCedula"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["nuevaFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/empleados/".$_POST["nuevaCedula"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "empleados";
                 /*=============================================
	REGISTRO DE EMPLEADOS
    nuevaCedula
    nuevoNombre
    nuevoApellido
    nuevoTelefono
    nuevoEmail
    nuevaDireccion
    nuevaFechaNacimiento
    nuevoCargo
    nuevaFechaIngreso
	=============================================*/
                
                $nuevoNombre = $_POST["nuevoNombre"];
                $nuevoNombre = strtoupper($nuevoNombre);
                $estado = 1;
                $eliminados = 0;

				$datos = array("cedula" => $_POST["nuevaCedula"],
                               "nombre" => $nuevoNombre,
                               "telefono" => $_POST["nuevoTelefono"],
                               "email" => $_POST["nuevoEmail"],
                               "direccion" => $_POST["nuevaDireccion"],
                               "fecha_nacimiento" => $_POST["nuevaFechaNacimiento"],
                               "cargo" => $_POST["nuevoCargo"],
                               "estado" => $estado,
                               "eliminados" => $eliminados,
                               "fecha_ingreso" => $_POST["nuevaFechaIngreso"],
					           "foto"=>$ruta);

				$respuesta = ModeloEmpleados::mdlIngresarEmpleado($tabla, $datos);
			
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
      $accion = "Ingresar nuevo Empleado - ".$nuevoNombre." - ".$_POST["nuevoEmail"];         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

					echo '<script>

					swal({

						type: "success",
						title: "¡El Empleado ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "empleados";

						}

					});
				

					</script>';


				}	else {
          
					echo '<script>

					swal({

						type: "error",
						title: "¡El Empleado no guardado, falla en al BD!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "empleados";

						}

					});
				

					</script>';

        }


			}else{

				echo '<script>

					swal({

						type: "error",
						title: "¡El empleado no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "empleados";

						}

					});
				

				</script>';

			}


		}


	}
    
    /*=============================================
	MOSTRAR empleado
	=============================================*/

	static public function ctrMostrarEmpleados($item, $valor){

		$tabla = "empleados";

		$respuesta = ModeloEmpleados::MdlMostrarEmpleados($tabla, $item, $valor);

		return $respuesta;
	}

/*=============================================
	EDITAR EMPLEADO
	=============================================*/

	static public function ctrEditarEmpleado(){

		if(isset($_POST["editarCedula"])){

			if(preg_match('/^[0-9]+$/', $_POST["editarCedula"]) &&
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) 
      //          &&
      //          preg_match('/^[()\-0-9 ]+$/', $_POST["editarTelefono"])   &&                         
			   // preg_match('/^[\#\.\-a-zA-Z0-9 ]+$/', $_POST["editarDireccion"]) && 
      //          preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editarEmail"])
               ){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = $_POST["fotoActual"];

				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL Empleado
					=============================================*/

					$directorio = "vistas/img/empleados/".$_POST["editarCedula"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["fotoActual"]) && $_POST["fotoActual"] != "vistas/img/empleados/default/anonymous.png"){

						unlink($_POST["fotoActual"]);

					}else{

						mkdir($directorio, 0755);

					}	

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/empleados/".$_POST["editarCedula"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/empleados/".$_POST["editarCedula"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "empleados";
                
                $editarNombre = $_POST["editarNombre"];
                $editarNombre = strtoupper($editarNombre);
				
				$datos = array("id" => $_POST["idEmpleado"],
                               "cedula" => $_POST["editarCedula"],
                               "nombre" => $editarNombre,
                               "telefono" => $_POST["editarTelefono"],
                               "email" => $_POST["editarEmail"],
                               "direccion" => $_POST["editarDireccion"],
                               "fechaNacimiento" => $_POST["editarFechaNacimiento"],
                               "cargo" => $_POST["editarCargo"],
                               "fechaIngreso" => $_POST["editarFechaIngreso"],
					           "foto"=>$ruta);

				$respuesta = ModeloEmpleados::mdlEditarEmpleado($tabla, $datos);

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
      $accion = "Modificar Empleado - ".$editarNombre." - ".$_POST["editarEmail"]." - ".$_POST["editarCargo"];         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

					echo '<script>

					swal({
						  type: "success",
						  title: "El Empleado ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "empleados";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "empleados";

							}
						})

			  	</script>';

			}

		}

	}
    /*=============================================
	BORRAR EMPELADO
	=============================================*/

	static public function ctrBorrarEmpleado(){

		if(isset($_GET["idEmpleado"])){

			$tabla ="empleados";
			$datos = $_GET["idEmpleado"];

			if($_GET["fotoEmpleado"] != ""  && $_GET["fotoEmpleado"] != "vistas/img/empleados/default/anonymous.png"){

				unlink($_GET["fotoEmpleado"]);
				rmdir('vistas/img/Empleados/'.$_GET["empleado"]);

			}
      
      /*=============================================
      AUDITORIA
      =============================================*/
      $tablaAuditoria = "empleados";
      $itemAuditoria = "id";
      $valorAuditoria = $_GET["idCategoria"];
      $respuestaAuditoria = ModeloEmpleados::MdlMostrarEmpleados($tablaAuditoria, $itemAuditoria, $valorAuditoria);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

			$respuesta = ModeloEmpleados::mdlBorrarEmpleado($tabla, $datos);

			if($respuesta == "ok"){
        
         /*=============================================
      AUDITORIA
      =============================================*/
//       $tablaAuditoria = "usuarios";
//       $itemAuditoria = "id";
//       $valorAuditoria = $_GET["idUsuario"];
//       $respuestaAuditoria = ModeloUsuarios::MdlMostrarUsuarios($tablaAuditoria, $itemAuditoria, $valorAuditoria);
      

      $usuario = $_SESSION["usuario"];  
      $accion = "Borrar Empleado - ".$respuestaAuditoria['nombre']." - ".$respuestaAuditoria['apellido']." - ".$respuestaAuditoria['email'];         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

				echo'<script>

				swal({
					  type: "success",
					  title: "El Empleado ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "empleados";

								}
							})

				</script>';

			}		
    

}
}
}
	


