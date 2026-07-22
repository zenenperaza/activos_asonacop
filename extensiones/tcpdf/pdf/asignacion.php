<?php
require_once "../../../controladores/asignaciones.controlador.php";
require_once "../../../modelos/asignaciones.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/activos.controlador.php";
require_once "../../../modelos/activos.modelo.php";

require_once "../../../controladores/empl.controlador.php";
//require_once "../../../modelos/emp.modelo.php";

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemAsignacion = "codigo";
$valorAsignacion = $this->codigo;

$respuestaAsignacion = ControladorAsignaciones::ctrMostrarAsignaciones($itemAsignacion, $valorAsignacion);

$fecha = substr($respuestaAsignacion["fecha"],0,-8);
$activos = json_decode($respuestaAsignacion["activos"], true);
$total = number_format($respuestaAsignacion["total"],2);

//TRAEMOS LA INFORMACIÓN DEL EMPLEADO

$itemEmpleado = "id";
$valorEmpleado = $respuestaAsignacion["id_empleado"];

$respuestaEmpleado = ControladorEmpleados::ctrMostrarEmpleados($itemEmpleado, $valorEmpleado);
foreach ($respuestaEmpleado as $key => $value) {
 $value["nombre"];
}

//TRAEMOS LA INFORMACIÓN DEL USUARIO

$itemUsuario = "id";
$valorUsuario = $respuestaAsignacion["id_usuario"];

$respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);


//$respuestaEmpleado["nombre"];
require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

$bloque1 = <<<EOF

	<table>
		
		<tr>
			<td style="width:80px;"><img src="images/logo-negro-bloque.png">

			</td>

			<td style="background-color:white; width:200px;">
				
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					RIF: J-906090-1
					
					<br>
					Dirección: Av Vargas con la redoma Divina Pastora
					
				</div>

			</td>

			<td style="background-color:white; width:130px;">

				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					Teléfono: 0424-5034999				
					
					<br>
					asiganciones@asonacop.com


				</div>
				
			</td>

			<td style="background-color:white; width:140px; text-align:center; color:red;"><br><br>ASIGNACION N.<br>$valorAsignacion</td>


		</tr>

		<tr>
		<td style="background-color:white; width:540px;">
				
				<div style="font-size:8.5px; text-align:center; line-height:5px;">					
					
					<p style="font-weight: bold; font-size:12px">ASONACOP | Gestión Interna</p>

				</div>

			</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$bloque2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:390px">

				Empleado: $value[nombre]

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
			
				Fecha: $fecha

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:540px">Asignado por:  $respuestaUsuario[nombre]</td>

		</tr>

		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Activo</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Cantidad</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Unit</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Valor Total</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

/* ---------------------------------------------------------
 , $orden
    	$orden = "id";
*/

//
//

foreach ($activos as $key => $item) {

$itemActivo = "descripcion";
$valorActivo = $item["descripcion"];
$orden = null;

$respuestaActivo = ControladorActivos::ctrMostrarActivos($itemActivo, $valorActivo, $orden);

$valorUnitario = number_format($respuestaActivo["precio_compra_bs"], 2);

$precioTotal = number_format($item["total"], 2);

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
				$item[descripcion]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[cantidad]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$valorUnitario
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$precioTotal
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

// ---------------------------------------------------------

$bloque5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

		</tr>		
	

		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				Total:
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $total
			</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');



// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

$pdf->Output('factura.pdf'/*, 'D'*/);

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();

?>