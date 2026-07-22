<?php
//session_start();

class ControladorAsignaciones{

	/*=============================================
	MOSTRAR Asignaciones
	=============================================*/

	static public function ctrMostrarAsignaciones($item, $valor){

		$tabla = "asignaciones";

		$respuesta = ModeloAsignaciones::mdlMostrarAsignaciones($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR AIGNACION
	=============================================*/

	static public function ctrCrearAsignacion(){

		if(isset($_POST["nuevaAsignacion"])){

			/*=============================================
			ACTUALIZAR LAS ASIGNACIONES DEL EMPLEADO Y REDUCIR EL STOCK Y AUMENTAR LAS ASIGNACIONES DE LOS ACTIVOS
			=============================================*/

			$listaActivos = json_decode($_POST["listaActivos"], true);

			$totalActivosAsignados = array();

			foreach ($listaActivos as $key => $value) {

			   array_push($totalActivosAsignados, $value["cantidad"]);
				
			   $tablaActivos = "activos";

			    $item = "id";
			    $valor = $value["id"]; 
          $orden = "id";

			    $traerActivo = ModeloActivos::mdlMostrarActivos($tablaActivos, $item, $valor, $orden);

				$item1a = "asignaciones";
				$valor1a = $value["cantidad"] + $traerActivo["asignaciones"];

			    $nuevasAsignaciones = ModeloActivos::mdlActualizarActivo($tablaActivos, $item1a, $valor1a, $valor);

				$item1b = "stock";
				$valor1b = $value["stock"];

				$nuevoStock = ModeloActivos::mdlActualizarActivo($tablaActivos, $item1b, $valor1b, $valor);

			}

			$tablaEmpleados = "empleados";

			$item = "id";
			$valor = $_POST["seleccionarEmpleado"];

			$traerEmpleado = ModeloEmpleados::mdlMostrarEmpleados($tablaEmpleados, $item, $valor);

			$item1a = "asignaciones";
			$valor1a = array_sum($totalActivosAsignados) + $traerEmpleado["asignaciones"];

			$asignacionesEmpleado = ModeloEmpleados::mdlActualizarEmpleado($tablaEmpleados, $item1a, $valor1a, $valor);

			$item1b = "registro"; 

			date_default_timezone_set('America/Caracas');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaEmpleado = ModeloEmpleados::mdlActualizarEmpleado($tablaEmpleados, $item1b, $valor1b, $valor);

			/*=============================================
			GUARDAR LA ASIGNACION
			=============================================*/	

			$tabla = "asignaciones";

			$datos = array("id_usuario"=>$_POST["idUsuario"],
						   "id_empleado"=>$_POST["seleccionarEmpleado"],
						   "codigo"=>$_POST["nuevaAsignacion"],
						   "activos"=>$_POST["listaActivos"],
						   "total"=>$_POST["totalAsignacion"]);

			$respuesta = ModeloAsignaciones::mdlIngresarAsignacion($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La asignacion ha sido guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "asignaciones";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	EDITAR AIGNACION
	=============================================*/

	static public function ctrEditarAsignacion(){

		if(isset($_POST["editarAsignacion"])){

			/*=============================================
			FORMATEAR TABLA DE Activos Y LA DE EMPLEADOS
			=============================================*/
			$tabla = "asignaciones";

			$item = "codigo";
			$valor = $_POST["editarAsignacion"];

			$traerAsignacion = ModeloAsignaciones::mdlMostrarAsignaciones($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE Activos EDITADOS
			=============================================*/

			if($_POST["listaActivos"] == ""){

				$listaActivos = $traerAsignacion["activos"];
				$cambioActivo = false;


			}else{

				$listaActivos = $_POST["listaActivos"];
				$cambioActivo = true;
			}

			if($cambioActivo){

				$activos =  json_decode($traerAsignacion["activos"], true);

				$totalActivosAsignados = array();

				foreach ($activos as $key => $value) {

					array_push($totalActivosAsignados, $value["cantidad"]);
					
					$tablaActivos = "activos";

					$item = "id";
					$valor = $value["id"];
          $orden = "id";

					$traerActivo = ModeloActivos::mdlMostrarActivos($tablaActivos, $item, $valor, $orden);

					$item1a = "asignaciones";
					$valor1a = $traerActivo["asignaciones"] - $value["cantidad"];

					$nuevasAsignaciones = ModeloActivos::mdlActualizarActivo($tablaActivos, $item1a, $valor1a, $valor);

					$item1b = "stock";
					$valor1b = $value["cantidad"] + $traerActivo["stock"];

					$nuevoStock = ModeloActivos::mdlActualizarActivo($tablaActivos, $item1b, $valor1b, $valor);

				}

				$tablaEmpleados = "empleados";

				$itemEmpleado = "id";
				$valorEmpleado = $_POST["seleccionarEmpleado"];

				$traerEmpleado = ModeloEmpleados::mdlMostrarEmpleados($tablaEmpleados, $itemEmpleado, $valorEmpleado);

				$item1a = "asignaciones";
				$valor1a = $traerEmpleado["asignaciones"] - array_sum($totalActivosAsignados);

				$asignacionesEmpleado = ModeloEmpleados::mdlActualizarEmpleado($tablaEmpleados, $item1a, $valor1a, $valorEmpleado);

				/*=============================================
				ACTUALIZAR LAS asignaciones DEL EMPLEADO Y REDUCIR EL STOCK Y AUMENTAR LAS AIGNACIONS DE LOS Activos
				=============================================*/

				$listaActivos_2 = json_decode($listaActivos, true);

				$totalActivosAsignados_2 = array();

				foreach ($listaActivos_2 as $key => $value) {

					array_push($totalActivosAsignados_2, $value["cantidad"]);
					
					$tablaActivos_2 = "activos";

					$item_2 = "id";
					$valor_2 = $value["id"];
          $orden = "id";

					$traerActivo_2 = ModeloActivos::mdlMostrarActivos($tablaActivos_2, $item_2, $valor_2, $orden);

					$item1a_2 = "asignaciones";
					$valor1a_2 = $value["cantidad"] + $traerActivo_2["asignaciones"];

					$nuevasAsignaciones_2 = ModeloActivos::mdlActualizarActivo($tablaActivos_2, $item1a_2, $valor1a_2, $valor_2);

					$item1b_2 = "stock";
					$valor1b_2 = $traerActivo_2["stock"] - $value["cantidad"];

					$nuevoStock_2 = ModeloActivos::mdlActualizarActivo($tablaActivos_2, $item1b_2, $valor1b_2, $valor_2);

				}

				$tablaEmpleados_2 = "empleados";

				$item_2 = "id";
				$valor_2 = $_POST["seleccionarEmpleado"];

				$traerEmpleado_2 = ModeloEmpleados::mdlMostrarEmpleados($tablaEmpleados_2, $item_2, $valor_2);

				$item1a_2 = "asignaciones";
				$valor1a_2 = array_sum($totalActivosAsignados_2) + $traerEmpleado_2["asignaciones"];

				$asignacionesEmpleado_2 = ModeloEmpleados::mdlActualizarEmpleado($tablaEmpleados_2, $item1a_2, $valor1a_2, $valor_2);

				$item1b_2 = "registro";

				date_default_timezone_set('America/Caracas');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;

				$fechaEmpleado_2 = ModeloEmpleados::mdlActualizarEmpleado($tablaEmpleados_2, $item1b_2, $valor1b_2, $valor_2);

			}

			/*=============================================
			GUARDAR CAMBIOS DE LA ASIGNACIO0N
			=============================================*/	

			$datos = array("id_usuario"=>$_POST["idUsuario"],
				           "id"=>$_POST["id"],
						   "id_empleado"=>$_POST["seleccionarEmpleado"],
						   "codigo"=>$_POST["editarAsignacion"],
						   "activos"=>$listaActivos,
						   "total"=>$_POST["totalAsignacion"]);



			$respuesta = ModeloAsignaciones::mdlEditarAsignacion($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La asignacion ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "asignaciones";

								}
							})

				</script>';

			} else {
				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La asignacion mo se guarda",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								
							})

				</script>';


			}

		}

	}

	/*=============================================
	ELIMINAR AIGNACION
	=============================================*/

	static public function ctrEliminarAsignacion(){

		if(isset($_GET["idAsignacion"])){

			$tabla = "asignaciones";

			$item = "id";
			$valor = $_GET["idAsignacion"];
     

			$traerAsignacion = ModeloAsignaciones::mdlMostrarAsignaciones($tabla, $item, $valor);

			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA asignacion
			=============================================*/

			$tablaEmpleados = "empleados";

			$itemAsignaciones = null;
			$valorAsignaciones = null;

			$traerAsignaciones = ModeloAsignaciones::mdlMostrarAsignaciones($tabla, $itemAsignaciones, $valorAsignaciones);

			$guardarFechas = array();

			foreach ($traerAsignaciones as $key => $value) {
				
				if($value["id_empleado"] == $traerAsignacion["id_empleado"]){

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if(count($guardarFechas) > 1){

				if($traerAsignacion["fecha"] > $guardarFechas[count($guardarFechas)-2]){

					$item = "registro";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorIdEmpleado = $traerAsignacion["id_empleado"];

					$asignacionesEmpleado = ModeloEmpleados::mdlActualizarEmpleado($tablaEmpleados, $item, $valor, $valorIdEmpleado);

				}else{

					$item = "registro";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdEmpleado = $traerAsignacion["id_empleado"];

					$asignacionesEmpleado = ModeloEmpleados::mdlActualizarEmpleado($tablaEmpleados, $item, $valor, $valorIdEmpleado);

				}


			}else{

				$item = "registro";
				$valor = "0000-00-00 00:00:00";
				$valorIdEmpleado = $traerAsignacion["id_empleado"];

				$asignacionesEmpleado = ModeloEmpleados::mdlActualizarEmpleado($tablaEmpleados, $item, $valor, $valorIdEmpleado);

			}

			/*=============================================
			FORMATEAR TABLA DE Activos Y LA DE EMPLEADOS
			=============================================*/

			$activos =  json_decode($traerAsignacion["activos"], true);

			$totalActivosAsignados = array();

			foreach ($activos as $key => $value) {

				array_push($totalActivosAsignados, $value["cantidad"]);
				
				$tablaActivos = "activos";

				$item = "id";
				$valor = $value["id"];
        $orden = "id";

				$traerActivo = ModeloActivos::mdlMostrarActivos($tablaActivos, $item, $valor, $orden);

				$item1a = "asignaciones";
				$valor1a = $traerActivo["asignaciones"] - $value["cantidad"];

				$nuevasAsignaciones = ModeloActivos::mdlActualizarActivo($tablaActivos, $item1a, $valor1a, $valor);

				$item1b = "stock";
				$valor1b = $value["cantidad"] + $traerActivo["stock"];

				$nuevoStock = ModeloActivos::mdlActualizarActivo($tablaActivos, $item1b, $valor1b, $valor);

			}

			$tablaEmpleados = "empleados";

			$itemEmpleado = "id";
			$valorEmpleado = $traerAsignacion["id_empleado"];

			$traerEmpleado = ModeloEmpleados::mdlMostrarEmpleados($tablaEmpleados, $itemEmpleado, $valorEmpleado);

			$item1a = "asignaciones";
			$valor1a = $traerEmpleado["asignaciones"] - array_sum($totalActivosAsignados);

			$asignacionesEmpleado = ModeloEmpleados::mdlActualizarEmpleado($tablaEmpleados, $item1a, $valor1a, $valorEmpleado);

			/*=============================================
			ELIMINAR AIGNACION
			=============================================*/

			$respuesta = ModeloAsignaciones::mdlEliminarAsignacion($tabla, $_GET["idAsignacion"]);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "La asignacion ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {

								window.location = "asignaciones";

								}
							})

				</script>';

			}		
		}

	}
	/*=============================================
	RANGO FECHAS 
	=============================================*/	

	static public function ctrRangoFechasAsignaciones($fechaInicial, $fechaFinal){

		$tabla = "asignaciones";

		$respuesta = ModeloAsignaciones::mdlRangoFechasAsignaciones($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$tabla = "asignaciones";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$asignaciones = ModeloAsignaciones::mdlRangoFechasAsignaciones($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$asignaciones = ModeloAsignaciones::mdlMostrarAsignaciones($tabla, $item, $valor);

			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].date('d M Y').'.xls';    
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");

			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>EMPLEADO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>USUARIO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>ACTIVOS</td>	
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($asignaciones as $row => $item){

				$empleado = ControladorEmpleados::ctrMostrarEmpleados("id", $item["id_empleado"]);
				$usuario = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_usuario"]);

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
			 			<td style='border:1px solid #eee;'>".$empleado["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>".$usuario["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>");

			 	$activos =  json_decode($item["activos"], true);

			 	foreach ($activos as $key => $valueActivos) {
			 			
			 			echo utf8_decode($valueActivos["cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

		 		foreach ($activos as $key => $valueActivos) {
			 			
		 			echo utf8_decode($valueActivos["descripcion"]."<br>");
		 		
		 		}

		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
		 			</tr>");


			}


			echo "</table>";		

		}
	
		

	}


	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

	public function ctrSumaTotalAsignaciones(){

		$tabla = "asignaciones";

		$respuesta = ModeloAsignaciones::mdlSumaTotalAsignaciones($tabla);

		return $respuesta;

	}

}
	
