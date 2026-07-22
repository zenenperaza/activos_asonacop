/*=============================================
CARGAR LA TABLA DINÁMICA DE ASIGNACIONES
=============================================*/


$('.tablaAsignaciones').DataTable( {
    "ajax": "ajax/datatable-asignaciones.ajax.php",
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "", "sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	}

} );

/*=============================================
AGREGANDO ACTIVOS A LA ASIGNACION DESDE LA TABLA
=============================================*/

$(".tablaAsignaciones tbody").on("click", "button.agregarActivo", function(){

	var idActivo = $(this).attr("idActivo");

	$(this).removeClass("btn-primary agregarActivo");

	$(this).addClass("btn-default");

	var datos = new FormData();
    datos.append("idActivo", idActivo);

     $.ajax({

     	url:"ajax/activos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){

      	    var descripcion = respuesta["descripcion"];
          	var stock = respuesta["stock"];
          	var precio = respuesta["precio_compra_bs"];

          	/*=============================================
          	EVITAR AGREGAR ACTIVO CUANDO EL STOCK ESTÁ EN CERO
          	=============================================*/

          	if(stock == 0){

      			swal({
			      title: "No hay stock disponible",
			      type: "error",
			      confirmButtonText: "¡Cerrar!"
			    });

			    $("button[idActivo='"+idActivo+"']").addClass("btn-primary agregarActivo");

			    return;

          	}

          	$(".nuevoActivo").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del activo -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarActivo" idActivo="'+idActivo+'"><i class="fa fa-times"></i></button></span>'+

	              '<input type="text" class="form-control nuevaDescripcionActivo" idActivo="'+idActivo+'" name="agregarActivo" value="'+descripcion+'" readonly required>'+

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del activo -->'+

	          '<div class="col-xs-3">'+
	            
	             '<input type="number" class="form-control nuevaCantidadActivo" name="nuevaCantidadActivo" min="1" value="1" stock="'+stock+'" nuevoStock="'+Number(stock-1)+'" required>'+

	          '</div>' +

	          '<!-- Precio del activo -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioActivo" precioReal="'+precio+'" name="nuevoPrecioActivo" value="'+precio+'" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>') 

	        // SUMAR TOTAL DE PRECIOS

	        sumarTotalPrecios()

 // AGRUPAR ACTIVOS EN FORMATO JSON

    listaActivos()

	        // PONER FORMATO AL PRECIO DE LOS ACTIVOS

	        $(".nuevoPrecioActivo").number(true, 2);

      	}

     })

});

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaAsignaciones").on("draw.dt", function(){

	if(localStorage.getItem("quitarActivo") != null){

		var listaIdActivos = JSON.parse(localStorage.getItem("quitarActivo"));

		for(var i = 0; i < listaIdActivos.length; i++){

			$("button.recuperarBoton[idActivo='"+listaIdActivos[i]["idActivo"]+"']").removeClass('btn-default');
			$("button.recuperarBoton[idActivo='"+listaIdActivos[i]["idActivo"]+"']").addClass('btn-primary agregarActivo');

		}


	}


})


/*=============================================
QUITAR ACTIVOS DE LA AISGNACION Y RECUPERAR BOTÓN
=============================================*/

var idQuitarActivo = [];

localStorage.removeItem("quitarActivo");

$(".formularioAsignacion").on("click", "button.quitarActivo", function(){

	$(this).parent().parent().parent().parent().remove();

	var idActivo = $(this).attr("idActivo");

	/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL ACTIVO A QUITAR
	=============================================*/

	if(localStorage.getItem("quitarActivo") == null){

		idQuitarActivo = [];
	
	}else{

		idQuitarActivo.concat(localStorage.getItem("quitarActivo"))

	}

	idQuitarActivo.push({"idActivo":idActivo});

	localStorage.setItem("quitarActivo", JSON.stringify(idQuitarActivo));

	$("button.recuperarBoton[idActivo='"+idActivo+"']").removeClass('btn-default');

	$("button.recuperarBoton[idActivo='"+idActivo+"']").addClass('btn-primary agregarActivo');

	if($(".nuevoActivo").children().length == 0){

		
		$("#nuevoTotalAsignacion").val(0);
		$("#totalAsignacion").val(0);
		$("#nuevoTotalAsignacion").attr("total",0);

	}else{

		// SUMAR TOTAL DE PRECIOS

    	sumarTotalPrecios()


        // AGRUPAR ACTIVOS EN FORMATO JSON

        listaActivos()

	}

})

/*=============================================
AGREGANDO ACTIVOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/

var numActivo = 0;

$(".btnAgregarActivo").click(function(){

	numActivo ++;

	var datos = new FormData();
	datos.append("traerActivos", "ok");
 
	$.ajax({

		url:"ajax/activos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	    	$(".nuevoActivo").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del activo -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarActivo" idActivo><i class="fa fa-times"></i></button></span>'+

	              '<select class="form-control nuevaDescripcionActivo" id="activo'+numActivo+'" idActivo name="nuevaDescripcionActivo" required>'+

	              '<option>Seleccione el activo</option>'+

	              '</select>'+  

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del activo -->'+

	          '<div class="col-xs-3 ingresoCantidad">'+
	            
	             '<input type="number" class="form-control nuevaCantidadActivo" name="nuevaCantidadActivo" min="1" value="1" stock nuevoStock required>'+

	          '</div>' +

	          '<!-- Precio del activo -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioActivo" precioReal="" name="nuevoPrecioActivo" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>');

      	    	// AGREGAR LOS ACTIVOS AL SELECT 

	         respuesta.forEach(funcionForEach);

	         function funcionForEach(item, index){

	         	if(item.stock != 0){

		         	$("#activo"+numActivo).append(

						'<option idActivo="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'
		         	)

		         }

	         }
            
            
	    // SUMAR TOTAL DE PRECIOS

        sumarTotalPrecios()
                        
	    // PONER FORMATO AL PRECIO DE LOS ACTIVOS

        $(".nuevoPrecioActivo").number(true, 2);



	        

	}

	})

})

/*=============================================
SELECCIONAR ACTIVO
=============================================*/

$(".formularioAsignacion").on("change", "select.nuevaDescripcionActivo", function(){

	var nombreActivo = $(this).val();

	var nuevaDescripcionActivo = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionActivo");

	var nuevoPrecioActivo = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioActivo");

	var nuevaCantidadActivo = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadActivo");
			
	var datos = new FormData();
    datos.append("nombreActivo", nombreActivo);

	  $.ajax({

     	url:"ajax/activos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){

     	    $(nuevaDescripcionActivo).attr("idActivo", respuesta["id"]);
      	    $(nuevaCantidadActivo).attr("stock", respuesta["stock"]);
      	    $(nuevaCantidadActivo).attr("nuevoStock", Number(respuesta["stock"])-1);
      	    $(nuevoPrecioActivo).val(respuesta["precio_compra_bs"]);
      	    $(nuevoPrecioActivo).attr("precioReal", respuesta["precio_compra_bs"]);            
            
            // SUMAR TOTAL DE PRECIOS
            
            sumarTotalPrecios()
            
            // AGRUPAR ACTIVOS EN FORMATO JSON

            listaActivos()

      	}

      })

      
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioAsignacion").on("change", "input.nuevaCantidadActivo", function(){

	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioActivo");

	var precioFinal = $(this).val() * precio.attr("precioReal");
	
	precio.val(precioFinal);

	var nuevoStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("nuevoStock", nuevoStock);

	if(Number($(this).val()) > Number($(this).attr("stock"))){

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/

		$(this).val(1);

		var precioFinal = $(this).val() * precio.attr("precioReal");

		precio.val(precioFinal);

		sumarTotalPrecios();

		swal({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock")+" unidades!",
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });

	    return;

	}

	// SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()


    // AGRUPAR ACTIVOS EN FORMATO JSON

    listaActivos()
    

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPrecios(){

	var precioItem = $(".nuevoPrecioActivo");
	var arraySumaPrecio = [];  

	for(var i = 0; i < precioItem.length; i++){

		 arraySumaPrecio.push(Number($(precioItem[i]).val()));
		 
	}

	function sumaArrayPrecios(total, numero){

		return total + numero;

	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	
	$("#nuevoTotalAsignacion").val(sumaTotalPrecio);
	$("#totalAsignacion").val(sumaTotalPrecio);
	$("#nuevoTotalAsignacion").attr("total",sumaTotalPrecio);


}


/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/

$("#nuevoTotalAsignacion").number(true, 2, ',', '.');



/*=============================================
LISTAR TODOS LOS ACTIVOS
=============================================*/

function listaActivos(){

	var listaActivos = [];

	var descripcion = $(".nuevaDescripcionActivo");

	var cantidad = $(".nuevaCantidadActivo");

	var precio = $(".nuevoPrecioActivo");

	for(var i = 0; i < descripcion.length; i++){

		listaActivos.push({ "id" : $(descripcion[i]).attr("idActivo"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "stock" : $(cantidad[i]).attr("nuevoStock"),
							  "precio" : $(precio[i]).attr("precioReal"),
							  "total" : $(precio[i]).val()})

	}
    
   // console.log("listaActivos", listaActivos);

	$("#listaActivos").val(JSON.stringify(listaActivos)); 

}


/*=============================================
BOTON EDITAR ASIGNACION
=============================================*/
$(".tablas").on("click", ".btnEditarAsignacion", function(){

	var idAsignacion = $(this).attr("idAsignacion");

	window.location = "index.php?ruta=editar-asignacion&idAsignacion="+idAsignacion;


})

/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL ACTIVO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarActivo(){

	//Capturamos todos los id de activos que fueron elegidos en la asignacion
	var idActivos = $(".quitarActivo");

	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaAsignaciones tbody button.agregarActivo");

	//Recorremos en un ciclo para obtener los diferentes idActivos que fueron agregados a la asignacion
	for(var i = 0; i < idActivos.length; i++){

		//Capturamos los Id de los activos agregados a la asignacion
		var boton = $(idActivos[i]).attr("idActivo");
		
		//Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
		for(var j = 0; j < botonesTabla.length; j ++){

			if($(botonesTabla[j]).attr("idActivo") == boton){

				$(botonesTabla[j]).removeClass("btn-primary agregarActivo");
				$(botonesTabla[j]).addClass("btn-default");

			}
		}

	}
	
}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaAsignaciones').on( 'draw.dt', function(){

	quitarAgregarActivo();

})



/*=============================================
BORRAR ASIGNACION
=============================================*/
$(".tablas").on("click", ".btnEliminarAsignacion", function(){

  var idAsignacion = $(this).attr("idAsignacion");

  swal({
        title: '¿Está seguro de borrar la asignacion?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar asignacion!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=asignaciones&idAsignacion="+idAsignacion;
        }

  })

})


/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablas").on("click", ".btnImprimirAsignacion", function(){

	var codigoAsignacion = $(this).attr("codigoAsignacion");

	window.open("extensiones/tcpdf/pdf/asignacion.php?codigo="+codigoAsignacion, "_blank");

})

/*=============================================
RANGO DE FECHAS
=============================================*/

$('#daterange-btn').daterangepicker(
  {
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');

    //console.log("fechaInicial",fechaInicial);

    var fechaFinal = end.format('YYYY-MM-DD');
    //console.log("fechaInicial",fechaInicial);

    var capturarRango = $("#daterange-btn span").html();
   
   	localStorage.setItem("capturarRango", capturarRango);

   	window.location = "index.php?ruta=asignaciones&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

  }

)

/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("capturarRango");
	localStorage.clear();
	window.location = "asignaciones";
})

/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensleft .ranges li").on("click", function(){

	var textoHoy = $(this).attr("data-range-key");

	if(textoHoy == "Hoy"){

		var d = new Date();
		
		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();

		if(mes < 10){

			var fechaInicial = año+"-0"+mes+"-"+dia;
			var fechaFinal = año+"-0"+mes+"-"+dia;

		}else if(dia < 10){

			var fechaInicial = año+"-"+mes+"-0"+dia;
			var fechaFinal = año+"-"+mes+"-0"+dia;

		}else if(mes < 10 && dia < 10){

			var fechaInicial = año+"-0"+mes+"-0"+dia;
			var fechaFinal = año+"-0"+mes+"-0"+dia;

		}else{

			var fechaInicial = año+"-"+mes+"-"+dia;
	    	var fechaFinal = año+"-"+mes+"-"+dia;

		}	

    	localStorage.setItem("capturarRango", "Hoy");

    	window.location = "index.php?ruta=asignaciones&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

	}

})





