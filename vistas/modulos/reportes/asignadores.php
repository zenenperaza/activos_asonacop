<?php

$item = null;
$valor = null;

$asignaciones = ControladorAsignaciones::ctrMostrarAsignaciones($item, $valor);
$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

$arrayAsignadores = array();
$arraylistaAsignadores = array();

foreach ($asignaciones as $key => $valueAsignaciones) {

  foreach ($usuarios as $key => $valueUsuarios) {

    if($valueUsuarios["id"] == $valueAsignaciones["id_vendedor"]){

        #Capturamos los vendedores en un array
        array_push($arrayAsignadores, $valueUsuarios["nombre"]);

        #Capturamos las nombres y los valores netos en un mismo array
        $arraylistaAsignadores = array($valueUsuarios["nombre"] => $valueAsignaciones["neto"]);

         #Sumamos los netos de cada vendedor

        foreach ($arraylistaAsignadores as $key => $value) {

            $sumaTotalAsignadores[$key] += $value;

         }

    }
  
  }

}

#Evitamos repetir nombre
$noRepetirNombres = array_unique($arrayAsignadores);

?>


<!--=====================================
VENDEDORES
======================================-->

<div class="box box-success">
	
	<div class="box-header with-border">
    
    	<h3 class="box-title">Asignadores</h3>
  
  	</div>

  	<div class="box-body">
  		
		<div class="chart-responsive">
			
			<div class="chart" id="bar-chart1" style="height: 300px;"></div>

		</div>

  	</div>

</div>

<script>
	
//BAR CHART
var bar = new Morris.Bar({
  element: 'bar-chart1',
  resize: true,
  data: [

  <?php
    
    foreach($noRepetirNombres as $value){

      echo "{y: '".$value."', a: '".$sumaTotalAsignadores[$value]."'},";

    }

  ?>
  ],
  barColors: ['#0af'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['asignaciones'],
  preUnits: '$',
  hideHover: 'auto'
});


</script>