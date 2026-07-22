<?php

class ControladorParticipantes{

	/*=============================================
	MOSTRAR Participantes
	=============================================*/

	static public function ctrMostrarParticipantes($item, $valor, $orden){

		
       // $tabla = "registros";
    $tabla = "participantes";


		$respuesta = ModeloParticipantes::mdlMostrarParticipantes($tabla, $item, $valor, $orden);

		return $respuesta;

	}

	/*=============================================
	CREAR Activo
	=============================================*/

	static public function ctrCrearActivo(){

		if(isset($_POST["nuevaDescripcion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaFuenteFinanciamiento"]) && 
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoResponsable"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&	
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompraBs"])
             /*  &&
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompraDs"])*/
              ){

		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/

			   	$ruta = "vistas/img/participantes/default/anonymous.png";

			   	if(isset($_FILES["nuevaImagen"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/participantes/".$_POST["nuevoCodigo"];

					mkdir($directorio, 0755);

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/participantes/".$_POST["nuevoCodigo"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["nuevaImagen"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/participantes/".$_POST["nuevoCodigo"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "participantes";
                
                $nuevaDescripcion = $_POST["nuevaDescripcion"];
                $nuevaDescripcion = strtoupper($nuevaDescripcion);

				$datos = array("id_categoria" => $_POST["nuevaCategoria"],
							   "codigo" => $_POST["nuevoCodigo"],
							   "codigo_uf" => $_POST["nuevoCodigoUF"],
							   "descripcion" => $nuevaDescripcion,
							   "fecha_adquisicion" => $_POST["nuevaFechaAdquisicion"],
							   "fuente_financiamiento" => $_POST["nuevaFuenteFinanciamiento"],
							   "origen_activo" => $_POST["nuevoOrigen"],
							   "situacion_contable" => $_POST["nuevoSituacionContable"],
							   "ubicacion_fisica" => $_POST["nuevoUbicacionFisica"],
							   "responsable" => $_POST["nuevoResponsable"],
							   "fecha_entrega_res" => $_POST["nuevaFechaEntregaResponsable"],
							   "estado_conservacion" => $_POST["nuevoEstadoConservacion"],
							   "info_garantia" => $_POST["nuevaGarantia"],
							   "observaciones" => $_POST["nuevaObservaciones"],                     
                               "stock" => $_POST["nuevoStock"],
							   "precio_compra_bs" => $_POST["nuevoPrecioCompraBs"],
							   "precio_compra_ds" => $_POST["nuevoPrecioCompraDs"],
							   "imagen" => $ruta);

				$respuesta = ModeloParticipantes::mdlIngresarActivo($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "El Activo ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "participantes";

										}
									})

						</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El Activo no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "participantes";

							}
						})

			  	</script>';
			}
		}

	}

	/*=============================================
	EDITAR ACTIVO
	=============================================*/

	static public function ctrEditarActivo(){

		if(isset($_POST["editarDescripcion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&
             //  preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarFuenteFinanciamiento"]) && 
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarResponsable"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&	
			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompraBs"])
			    /*&&
			   preg_match('/^[0-9.]+$/ ', $_POST["editarPrecioCompraDs"])*/
			   ){

		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/

			   	$ruta = $_POST["imagenActual"];

			   	if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DE ACTIVO
					=============================================*/

					$directorio = "vistas/img/participantes/".$_POST["editarCodigo"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/participantes/default/anonymous.png"){

						unlink($_POST["imagenActual"]);

					}else{

						mkdir($directorio, 0755);	
					
					}
					
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarImagen"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/participantes/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarImagen"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/participantes/".$_POST["editarCodigo"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "participantes";
                
                $editarDescripcion = $_POST["editarDescripcion"];
                $editarDescripcion = strtoupper($editarDescripcion);

				$datos = array("id_categoria" => $_POST["editarCategoria"],
							   "codigo" => $_POST["editarCodigo"],
							   "codigo_uf" => $_POST["editarCodigoUF"],
							   "descripcion" => $editarDescripcion,
							   "fecha_adquisicion" => $_POST["editarFechaAdquisicion"],
							   "fuente_financiamiento" => $_POST["editarFuenteFinanciamiento"],
							   "origen_activo" => $_POST["editarOrigen"],
							   "situacion_contable" => $_POST["editarSituacionContable"],
							   "ubicacion_fisica" => $_POST["editarUbicacionFisica"],
							   "responsable" => $_POST["editarResponsable"],
							   "fecha_entrega_res" => $_POST["editarFechaEntregaResponsable"],
							   "estado_conservacion" => $_POST["editarEstadoConservacion"],
							   "info_garantia" => $_POST["editarGarantia"],
							   "observaciones" => $_POST["editarObservaciones"],                     
                               "stock" => $_POST["editarStock"],
							   "precio_compra_bs" => $_POST["editarPrecioCompraBs"],
							   "precio_compra_ds" => $_POST["editarPrecioCompraDs"],
							   "imagen" => $ruta);


				$respuesta = ModeloParticipantes::mdlEditarActivo($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

						swal({
							  type: "success",
							  title: "El Activo ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										// window.location = "participantes";

										}
									})

						</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El Activo no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "participantes";

							}
						})

			  	</script>';
			}
		}

	}

	/*=============================================
	BORRAR ACTIVO
	=============================================*/
	static public function ctrEliminarParticipante(){

		if(isset($_GET["id"])){

			//$tabla ="registros";
      $tabla = "registros";
			$datos = $_GET["id"];
		

			$respuesta = ModeloParticipantes::mdlEliminarParticipante($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El Participante ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "participantes";

								}
							})

				</script>';

			}		
		}


	}
		/*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/

	static public function ctrMostrarSumaAsignaciones(){

		$tabla = "asignaciones";

		$respuesta = ModeloParticipantes::mdlMostrarSumaAsignaciones($tabla);

		return $respuesta;

	}


}

