/*=============================================
CARGAR LA TABLA DINÁMICA DE Activos
=============================================*/

var filtroOficina = $('.tablaActivos').attr('data-filtro-oficina') || '';

var titulosCamposActivo = {
	nuevaCategoria: 'Categoría',
	nuevoUbicacionFisica: 'Estado / Oficina',
	nuevoCodigoUF: 'Prefijo de ubicación',
	nuevoCodigo: 'Código del activo',
	nuevaDescripcion: 'Descripción',
	nuevoSerialNumero: 'Número serial',
	nuevaFechaAdquisicion: 'Fecha de adquisición',
	nuevaFuenteFinanciamiento: 'Fuente de financiamiento',
	nuevoOrigen: 'Origen del activo',
	nuevoSituacionContable: 'Situación contable',
	nuevoResponsable: 'Responsable',
	nuevaFechaEntregaResponsable: 'Fecha de entrega',
	nuevoEstadoConservacion: 'Estado de conservación',
	nuevaGarantia: 'Información de garantía',
	nuevaObservaciones: 'Observaciones',
	nuevoStock: 'Stock',
	nuevoPrecioCompraBs: 'Precio de compra Bs.',
	nuevoPrecioCompraDs: 'Precio de compra $',
	editarCategoria: 'Categoría',
	editarUbicacionFisica: 'Estado / Oficina',
	editarCodigoUF: 'Prefijo de ubicación',
	editarCodigo: 'Código del activo',
	editarDescripcion: 'Descripción',
	editarSerialNumero: 'Número serial',
	editarFechaAdquisicion: 'Fecha de adquisición',
	editarFuenteFinanciamiento: 'Fuente de financiamiento',
	editarOrigen: 'Origen del activo',
	editarSituacionContable: 'Situación contable',
	editarResponsable: 'Responsable',
	editarFechaEntregaResponsable: 'Fecha de entrega',
	editarEstadoConservacion: 'Estado de conservación',
	editarGarantia: 'Información de garantía',
	editarObservaciones: 'Observaciones',
	editarStock: 'Stock',
	editarPrecioCompraBs: 'Precio de compra Bs.',
	editarPrecioCompraDs: 'Precio de compra $'
};

$.each(titulosCamposActivo, function(nombre, titulo){
	var campo = $('[name="' + nombre + '"]');

	campo.each(function(){
		var control = $(this);
		var grupo = control.closest('.input-group');

		if(grupo.length && !grupo.prev().hasClass('campo-activo-label')){
			$('<label class="campo-activo-label"></label>')
				.text(titulo)
				.insertBefore(grupo);
		}

		control.attr('aria-label', titulo);
	});
});

$('.selector-fecha-activo').datepicker({
	format: 'dd/mm/yyyy',
	language: 'es',
	autoclose: true,
	todayHighlight: true,
	todayBtn: 'linked',
	clearBtn: true,
	orientation: 'bottom auto'
});

$('.selector-fecha-activo input').inputmask('dd/mm/yyyy', {
	placeholder: 'dd/mm/aaaa',
	showMaskOnHover: false
});

$('.tablaActivos').DataTable( {
      "bDestroy": true,
    "iDisplayLength": 50,//Paginación
      "order": [[ 0, "desc" ]],//Ordenar (columna,orden)   
      "serverSide": true,
      dom: 'Bfrtip',
       
     buttons: [
        'copyHtml5',
		'excelHtml5',
		'csvHtml5',
		'pdf'
    ],
    "ajax": {
      "url": "ajax/datatable-activos.ajax.php",
      "type": "GET",
      "data": function (datos) {
        datos.oficina = filtroOficina;
      }
    },
    "deferRender": true, 
	"retrieve": true,
	"processing": true,
	"searchDelay": 400,
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
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
CAPTURANDO LA UBICACION FISICA PARA ASIGNAR CÓDIGO
=============================================*//*
$("#nuevoUbicacionFisica").change(function(){

	var ubicacionFisica = $(this).val().substr(0,3);
    
    //console.log("UbicacionFisica", UbicacionFisica)

	var datos = new FormData();
  	datos.append("ubicacionFisica", ubicacionFisica);

  	$.ajax({

      url:"ajax/activos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){

      	if(!respuesta){

      		var nuevoCodigo = ubicacionFisica+"001";
      		$("#nuevoCodigo").val(nuevoCodigo);

      	}else{

      		var nuevoCodigo = respuesta["codigo"] + 1;
          	$("#nuevoCodigo").val(nuevoCodigo);

      	}
                
      }

  	})

})
/*=============================================
CAPTURANDO LA UBICACION FISICA PARA ASIGNAR CÓDIGO
=============================================*/
$("#nuevoUbicacionFisica").change(function(){
    var ubicacionFisica = $(this).val().substr(0,3);
    $("#nuevoCodigoUF").val(ubicacionFisica);

    if($("#nuevoCodigo").val() === "NaN"){
		$("#nuevoCodigo").val("");
    }

})

$(".editarUbicacionFisica").change(function(){
    var editarCodigoUF = $(this).val().substr(0,3);
    $("#editarCodigoUF").val(editarCodigoUF);
      

})


/*=============================================
CAPTURANDO LA CATEGORIA PARA ASIGNAR CÓDIGO
=============================================*/
$("#nuevaCategoria").change(function(){

	var idCategoria = $(this).val();

	var datos = new FormData();
  	datos.append("idCategoria", idCategoria);

  	$.ajax({

      url:"ajax/activos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){

		var codigoActual = $.trim($("#nuevoCodigo").val());

		if(codigoActual === "NaN"){
			$("#nuevoCodigo").val("");
			codigoActual = "";
		}

      	if(!respuesta){

      		var nuevoCodigo = idCategoria+"01";
			if(!codigoActual){
				$("#nuevoCodigo").val(nuevoCodigo);
			}

      	}else{

			var codigoAnterior = parseInt(respuesta["codigo"], 10);
			if(!codigoActual && !isNaN(codigoAnterior)){
				$("#nuevoCodigo").val(codigoAnterior + 1);
			}

      	}
                
      }

  	})

})

$("#modalAgregarActivo").on("show.bs.modal", function(){
	if($("#nuevoCodigo").val() === "NaN"){
		$("#nuevoCodigo").val("");
	}
});



/*=============================================
SUBIENDO LA FOTO DEL ACTIVO
=============================================*/

$(".nuevaImagen").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

  		$(".nuevaImagen").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe estar en formato JPG o PNG!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else if(imagen["size"] > 2000000){

  		$(".nuevaImagen").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen no debe pesar más de 2MB!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}
})

/*=============================================
EDITAR ACTIVO
=============================================*/

$(".tablaActivos tbody").on("click", "button.btnEditarActivo", function(){

	var idActivo = $(this).attr("idActivo");
	
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

            var datosResponsable = new FormData();
           datosResponsable.append("idEmpleado",respuesta["responsable"]);


               // console.log("respuesta['responsable']", respuesta['responsable']);

            $.ajax({

              url:"ajax/empleados.ajax.php",
              method: "POST",
              data: datosResponsable,
              cache: false,
              contentType: false,
              processData: false,
              dataType:"json",
              success:function(respuesta){

                //console.log("respuesta['nombre']", respuesta['nombre']);

                  
           $("#editarResponsable").val(respuesta["id"]); 
           $("#editarResponsable").html(respuesta["nombre"]);  

              }

          })
          
          var datosCategoria = new FormData();
          datosCategoria.append("idCategoria",respuesta["id_categoria"]);

           $.ajax({

              url:"ajax/categorias.ajax.php",
              method: "POST",
              data: datosCategoria,
              cache: false,
              contentType: false,
              processData: false,
              dataType:"json",
              success:function(respuesta){
                  
                  $("#editarCategoria").val(respuesta["id"]);
                  $("#editarCategoria").html(respuesta["categoria"]);

              }

          })

       

       
          

           $("#editarCodigo").val(respuesta["codigo"]);

           $("#editarCodigoUF").val(respuesta["codigo_uf"]);
           $("#editarIdActivo").val(respuesta["id"]);

           $("#editarDescripcion").val(respuesta["descripcion"]);
          
           $("#editarFechaAdquisicion")
             .closest(".selector-fecha-activo")
             .datepicker("update", respuesta["fecha_adquisicion"]);
          
           $("#editarFuenteFinanciamiento").val(respuesta["fuente_financiamiento"]);
          
           $("#editarOrigen").val(respuesta["origen_activo"]);
           $("#editarOrigen").html(respuesta["origen_activo"]);          
           $("#editarTipoOrigen").val(respuesta["tipo_origen"]);
           $("#editarSerialNumero").val(respuesta["serial_numero"]);
           
           $("#editarSituacionContable").val(respuesta["situacion_contable"]);
           $("#editarSituacionContable").html(respuesta["situacion_contable"]);
          
           $("#editarUbicacionFisica").val(respuesta["ubicacion_fisica"]);
           $("#editarUbicacionFisica").html(respuesta["ubicacion_fisica"]);          
             
          
           $("#editarFechaEntregaResponsable")
             .closest(".selector-fecha-activo")
             .datepicker("update", respuesta["fecha_entrega_res"]);
          
           $("#editarEstadoConservacion").val(respuesta["estado_conservacion"]);
           $("#editarEstadoConservacion").html(respuesta["estado_conservacion"]);
          
           $("#editarGarantia").val(respuesta["info_garantia"]);
          
           $("#editarObservaciones").val(respuesta["observaciones"]);

           $("#editarStock").val(respuesta["stock"]);

           $("#editarPrecioCompraBs").val(respuesta["precio_compra_bs"]);

           $("#editarPrecioCompraDs").val(respuesta["precio_compra_ds"]);

           if(respuesta["imagen"] != ""){

           	$("#imagenActual").val(respuesta["imagen"]);

           	$(".previsualizar").attr("src",  respuesta["imagen"]);

           } else {

           	$(".previsualizar").attr("src", "vistas/img/activos/default/anonymous.png");

           }

      }

  })

})

/*=============================================
ELIMINAR ACTIVO
=============================================*/

$(".tablaActivos tbody").on("click", "button.btnEliminarActivo", function(){

	var idActivo = $(this).attr("idActivo");
	var codigo = $(this).attr("codigo");
	var imagen = $(this).attr("imagen");
	
	swal({

		title: '¿Está seguro de borrar el Activo?',
		text: "¡Si no lo está puede cancelar la accíón!",
		type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar Activo!'
        }).then(function(result){
        if (result.value) {

        	window.location = "index.php?ruta=activos&idActivo="+idActivo+"&imagen="+imagen+"&codigo="+codigo;

        }


	})

})
	
