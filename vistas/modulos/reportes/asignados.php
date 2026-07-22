<?php

$item = null;
$valor = null;

$ventas = ControladorAsignaciones::ctrMostrarAsignaciones($item, $valor);
$empleados = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

$arrayEmpleados = array();
$arraylistaEmpleados = array();

foreach ($ventas as $key => $valueAsignaciones) {
  
  foreach ($empleados as $key => $valueEmpleados) {
    
      if($valueEmpleados["id"] == $valueAsignaciones["id_empleado"]){

        #Capturamos los Empleados en un array
        array_push($arrayEmpleados, $valueEmpleados["nombre"]);

        #Capturamos las nombres y los valores netos en un mismo array
        $arraylistaEmpleados = array($valueEmpleados["nombre"] => $valueAsignaciones["neto"]);

        #Sumamos los netos de cada empleado
        foreach ($arraylistaEmpleados as $key => $value) {
          
          $sumaTotalEmpleados[$key] += $value;
        
        }

      }   
  }

}

#Evitamos repetir nombre
$noRepetirNombres = array_unique($arrayEmpleados);

?>

<!--=====================================
VENDEDORES
======================================-->

<div class="box box-primary">
	
	<div class="box-header with-border">
    
    	<h3 class="box-title">Empleados con asignaciones</h3>
  
  	</div>

  	<div class="box-body">
  		
		<div class="chart-responsive">
			
			<div class="chart" id="bar-chart2" style="height: 300px;"></div>

		</div>

  	</div>

</div>

<script>
	
//BAR CHART
var bar = new Morris.Bar({
  element: 'bar-chart2',
  resize: true,
  data: [
     <?php
    
    foreach($noRepetirNombres as $value){

      echo "{y: '".$value."', a: '".$sumaTotalEmpleados[$value]."'},";

    }

  ?>
  ],
  barColors: ['#f6a'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['ventas'],
  preUnits: '$',
  hideHover: 'auto'
});


</script>