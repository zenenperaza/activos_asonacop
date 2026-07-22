<?php

error_reporting(0);

if(isset($_GET["fechaInicial"])){

    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];

}else{

$fechaInicial = null;
$fechaFinal = null;

}

$respuesta = ControladorAsignaciones::ctrRangoFechasAsignaciones($fechaInicial, $fechaFinal);

$arrayFechas = array();
$arrayAsignaciones = array();
$sumaMontosMes = array();

foreach ($respuesta as $key => $value) {

	#Capturamos sólo el año y el mes
	$fecha = substr($value["fecha"],0,7);

	#Introducir las fechas en arrayFechas
	array_push($arrayFechas, $fecha);

	#Capturamos las asignaciones
	$arrayAsignaciones = array($fecha => $value["total"]);

	#Sumamos los pagos que ocurrieron el mismo mes
	foreach ($arrayAsignaciones as $key => $value) {
		
		$sumaMontosMes[$key] += $value;
	}

}


$noRepetirFechas = array_unique($arrayFechas);


?>

<!--=====================================
GRÁFICO DE VENTAS
======================================-->


<div class="box box-solid bg-teal-gradient">
	
	<div class="box-header">
		
 		<i class="fa fa-th"></i>

  		<h3 class="box-title">Gráfico de Asignaciones</h3>

	</div>

	<div class="box-body border-radius-none nuevoGraficoAsignaciones">

		<div class="chart" id="line-chart-asignaciones" style="height: 250px;"></div>

  </div>

</div>

<script>
	
 var line = new Morris.Line({
    element          : 'line-chart-asignaciones',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

	    foreach($noRepetirFechas as $key){

	    	echo "{ y: '".$key."', asignaciones: ".$sumaMontosMes[$key]." },";


	    }

	    echo "{y: '".$key."', asignaciones: ".$sumaMontosMes[$key]." }";

    }else{

       echo "{ y: '0', asignaciones: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['asignaciones'],
    labels           : ['asignaciones'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : 'Bs',
    gridTextSize     : 10
  });

</script>