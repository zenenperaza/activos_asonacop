<?php

class ControladorActivos{

	/*=============================================
	MOSTRAR Activos
	=============================================*/

	public static function ctrMostrarActivos($item, $valor, $orden){

		$tabla = "activos";

		$respuesta = ModeloActivos::mdlMostrarActivos($tabla, $item, $valor, $orden);

		return $respuesta;

	}

	/*=============================================
	CONTAR ACTIVOS POR UBICACION FISICA
	=============================================*/
	public static function ctrContarPorUbicacion(){

		$tabla = "activos";

		$respuesta = ModeloActivos::mdlContarPorUbicacion($tabla);

		return $respuesta;

	}

	/*=============================================
	CREAR Activo
	=============================================*/

	public static function ctrCrearActivo(){

		if(isset($_POST["nuevaDescripcion"])){

			$tabla = "activos";
			$codigoUF = strtoupper(trim($_POST["nuevoCodigoUF"]));
			$codigo = strtoupper(trim($_POST["nuevoCodigo"]));

			if(!preg_match('/^[A-Z0-9._-]+$/', $codigoUF) || !preg_match('/^[A-Z0-9._-]+$/', $codigo)){
				echo '<script>
					swal({
						type: "error",
						title: "Código no válido",
						text: "Use solamente letras, números, puntos, guiones o guion bajo.",
						confirmButtonText: "Aceptar"
					});
				</script>';
				return;
			}

			if(ModeloActivos::mdlExisteCodigoActivo($tabla, $codigoUF, $codigo)){
				echo '<script>
					swal({
						type: "error",
						title: "Código duplicado",
						text: "Ya existe un activo con el código '.$codigoUF.'-'.$codigo.'. Ingrese un código diferente.",
						confirmButtonText: "Aceptar"
					});
				</script>';
				return;
			}

// 			if(
//         preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&
//                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaFuenteFinanciamiento"]) && 
//                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoResponsable"]) &&
// 			   preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&	
// 			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompraBs"])
//               ){

		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/

			   	$ruta = "vistas/img/activos/default/anonymous.png";

			    	if(isset($_FILES["nuevaImagen"]["tmp_name"]) && !empty($_FILES["nuevaImagen"]["tmp_name"])){

				list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);

				$nuevoAncho = 500;
				$nuevoAlto = 500;

				/*=============================================
				CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL ACTIVO
				============================================*/

				$directorio = "vistas/img/activos/".$_POST["nuevoCodigo"];

				if(!file_exists($directorio)){
					mkdir($directorio, 0777, true);
				}

				/*=============================================
				DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
				============================================*/

				if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){

					/*=============================================
					GUARDAMOS LA IMAGEN EN EL DIRECTORIO
					============================================*/

					$aleatorio = mt_rand(100,999);

					$ruta = "vistas/img/activos/".$_POST["nuevoCodigo"]."/".$aleatorio.".jpg";

					$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);

				}

				if($_FILES["nuevaImagen"]["type"] == "image/png"){

					/*=============================================
					GUARDAMOS LA IMAGEN EN EL DIRECTORIO
					============================================*/

					$aleatorio = mt_rand(100,999);

					$ruta = "vistas/img/activos/".$_POST["nuevoCodigo"]."/".$aleatorio.".png";

					$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);

				}

			}

        $nuevaDescripcion = strtoupper($_POST["nuevaDescripcion"]);         

				$datos = array("id_categoria" => $_POST["nuevaCategoria"],
							   "ubicacion_fisica" => $_POST["nuevoUbicacionFisica"],
							   "codigo_uf" => $codigoUF,
							   "codigo" => $codigo,
							   "descripcion" => $nuevaDescripcion,
					   "serial_numero" => isset($_POST["nuevoSerialNumero"]) ? $_POST["nuevoSerialNumero"] : "",
					   "fecha_adquisicion" => isset($_POST["nuevaFechaAdquisicion"]) && $_POST["nuevaFechaAdquisicion"] !== "" ? $_POST["nuevaFechaAdquisicion"] : "",
					   "fuente_financiamiento" => $_POST["nuevaFuenteFinanciamiento"],
					   "origen_activo" => $_POST["nuevoOrigen"],
					//    "tipo_origen" => $_POST["nuevoTipoOrigen"],
					   "situacion_contable" => $_POST["nuevoSituacionContable"],
					   "responsable" => $_POST["nuevoResponsable"],
					   "fecha_entrega_res" => $_POST["nuevaFechaEntregaResponsable"],
					   "estado_conservacion" => $_POST["nuevoEstadoConservacion"],
					   "info_garantia" => $_POST["nuevaGarantia"],
					   "observaciones" => $_POST["nuevaObservaciones"],
					   "stock" => $_POST["nuevoStock"],
					   "precio_compra_bs" => $_POST["nuevoPrecioCompraBs"],
					   "precio_compra_ds" => $_POST["nuevoPrecioCompraDs"],
					"imagen" => $ruta);
					$respuesta = ModeloActivos::mdlIngresarActivo($tabla, $datos);
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
        $accion = "Ingresar nuevo Activo: ".$_POST["nuevaDescripcion"]." - ".$_POST["nuevaCategoria"]." - ".$_POST["nuevoUbicacionFisica"]." - ".$_POST["nuevoResponsable"]." - ".$_POST["nuevoPrecioCompraBs"]." - ".$_POST["nuevoPrecioCompraDs"];         
        $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
        /*=============================================
        AUDITORIA FIN
        =============================================*/ 

					echo '<script>

						swal({
							type: "success",
							title: "Activo guardado",
							text: "El activo se guardó satisfactoriamente.",
							showConfirmButton: true,
							confirmButtonText: "Aceptar",
							allowOutsideClick: false
						}).then(function(result){
							if(result.value){
								window.location = "activos";
							}
						});

					</script>';

				} 
//       else {
          
//           	echo  "nuevaCategoria ".$_POST["nuevaCategoria"]."<br>" ;
//           	echo  "nuevoUbicacionFisica ".$_POST["nuevoUbicacionFisica"]."<br>" ;
//           	echo  "nuevoCodigoUF ".$_POST["nuevoCodigoUF"]."<br>" ;
//           	echo  "nuevoCodigo ".$_POST["nuevoCodigo"]."<br>" ;
//           	echo  "nuevaDescripcion ".$_POST["nuevaDescripcion"]."<br>" ;
//           	echo  "nuevaFechaAdquisicion ".$_POST["nuevaFechaAdquisicion"]."<br>" ;
//           	echo  "nuevaFuenteFinanciamiento ".$_POST["nuevaFuenteFinanciamiento"]."<br>" ;
//           	echo  "nuevoOrigen ".$_POST["nuevoOrigen"]."<br>" ;
//           	echo  "nuevoSituacionContable ".$_POST["nuevoSituacionContable"]."<br>" ;
//           	echo  "nuevoResponsable ".$_POST["nuevoResponsable"]."<br>" ;
//           	echo  "nuevaFechaEntregaResponsable ".$_POST["nuevaFechaEntregaResponsable"]."<br>" ;
//           	echo  "nuevoEstadoConservacion ".$_POST["nuevoEstadoConservacion"]."<br>" ;
//           	echo  "nuevaGarantia ".$_POST["nuevaGarantia"]."<br>" ;
//           	echo  "nuevaObservaciones ".$_POST["nuevaObservaciones"]."<br>" ;
//           	echo  "nuevoStock ".$_POST["nuevoStock"]."<br>" ;
//           	echo  "nuevoPrecioCompraBs ".$_POST["nuevoPrecioCompraBs"]."<br>" ;
//           	echo  "nuevoPrecioCompraDs ".$_POST["nuevoPrecioCompraDs"]."<br>" ;
//           	echo  "ruta ".$ruta."<br>" ;

//         }


// 			}else{

// 				echo'<script>

// 					swal({
// 						  type: "error",
// 						  title: "¡El Activo no puede ir con los campos vacíos o llevar caracteres especiales!",
// 						  showConfirmButton: true,
// 						  confirmButtonText: "Cerrar"
// 						  }).then(function(result){
// 							if (result.value) {

// 							window.location = "activos";

// 							}
// 						})

// 			  	</script>';
// 			}
		}

	}

	/*=============================================
	EDITAR ACTIVO
	=============================================*/

	public static function ctrEditarActivo(){

		if(isset($_POST["editarDescripcion"])){

			$tabla = "activos";
			$idActivo = (int) $_POST["editarIdActivo"];
			$codigoUF = strtoupper(trim($_POST["editarCodigoUF"]));
			$codigo = strtoupper(trim($_POST["editarCodigo"]));

			if(!preg_match('/^[A-Z0-9._-]+$/', $codigoUF) || !preg_match('/^[A-Z0-9._-]+$/', $codigo)){
				echo '<script>
					swal({
						type: "error",
						title: "Código no válido",
						text: "Use solamente letras, números, puntos, guiones o guion bajo.",
						confirmButtonText: "Aceptar"
					});
				</script>';
				return;
			}

			if(ModeloActivos::mdlExisteCodigoActivo($tabla, $codigoUF, $codigo, $idActivo)){
				echo '<script>
					swal({
						type: "error",
						title: "Código duplicado",
						text: "Ya existe otro activo con el código '.$codigoUF.'-'.$codigo.'. Ingrese un código diferente.",
						confirmButtonText: "Aceptar"
					});
				</script>';
				return;
			}

			if( preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"])
//          &&
//                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarResponsable"]) &&
// 			   preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&	
// 			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompraBs"]
//                    )
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

					$directorio = "vistas/img/activos/".$_POST["editarCodigo"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/activos/default/anonymous.png"){

						unlink($_POST["imagenActual"]);

					}else{

				     mkdir($directorio, 0777, true);
					
					}
					
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarImagen"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/activos/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";

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

						$ruta = "vistas/img/activos/".$_POST["editarCodigo"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

                $editarDescripcion = $_POST["editarDescripcion"];
                $editarDescripcion = strtoupper($editarDescripcion);

				$datos = array("id" => $idActivo,
							   "id_categoria" => $_POST["editarCategoria"],
							   "codigo" => $codigo,
							   "codigo_uf" => $codigoUF,
							   "descripcion" => $editarDescripcion,
					   "serial_numero" => isset($_POST["editarSerialNumero"]) ? $_POST["editarSerialNumero"] : "",
					   "fecha_adquisicion" => isset($_POST["editarFechaAdquisicion"]) && $_POST["editarFechaAdquisicion"] !== "" ? $_POST["editarFechaAdquisicion"] : "",
					   "fuente_financiamiento" => $_POST["editarFuenteFinanciamiento"],
					   "origen_activo" => $_POST["editarOrigen"],
					//    "tipo_origen" => $_POST["editarTipoOrigen"],
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
					$respuesta = ModeloActivos::mdlEditarActivo($tabla, $datos);
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
        $accion = "Modificar Activo: ".$_POST["editarDescripcion"]." - ".$_POST["editarCategoria"]." - ".$_POST["editarResponsable"]." - ".$_POST["editarPrecioCompraBs"]." - ".$_POST["editarPrecioCompraDs"];         
        $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
        /*=============================================
        AUDITORIA FIN
        =============================================*/ 

					echo'<script>

						swal({
							  type: "success",
							  title: "El Activo ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										 window.location = "activos";

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

							window.location = "activos";

							}
						})

			  	</script>';
			}
		}

	}

	/*=============================================
	BORRAR ACTIVO
	=============================================*/
	public static function ctrEliminarActivo(){

		if(isset($_GET["idActivo"])){

			$tabla ="activos";
			$datos = $_GET["idActivo"];

			if($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/activos/default/anonymous.png"){

				unlink($_GET["imagen"]);
				rmdir('vistas/img/activos/'.$_GET["codigo"]);

			}
      
       /*=============================================
        AUDITORIA
        =============================================*/
      
      
      $tablaAuditoria = "activos";
      $itemAuditoria = "id";
      $valorAuditoria = $_GET["idActivo"];
      $orden = "id";
      $respuestaAuditoria =  ModeloActivos::mdlMostrarActivos($tablaAuditoria, $itemAuditoria, $valorAuditoria, $orden);
//       $tabla, $item, $valor, $orden


      $usuario = $_SESSION["usuario"];  
      $accion = "Eliminar Activo: ".$respuestaAuditoria['descripcion']." Responsable:  ".$respuestaAuditoria['responsable'];         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);


      $respuesta = ModeloActivos::mdlEliminarActivo($tabla, $datos);
      

			if($respuesta == "ok"){
        

        /*=============================================
        AUDITORIA FIN
        =============================================*/ 

	echo '<script>

					swal({

						type: "success",
						title: "¡El Activo ha sido eliminado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "activos";

						}

					});
				

					</script>';


			}	
      
		}

	}
		/*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/

	public static function ctrMostrarSumaAsignaciones(){

		$tabla = "activos";

		$respuesta = ModeloActivos::mdlMostrarSumaAsignaciones($tabla);

		return $respuesta;

	}


}
