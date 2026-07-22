
    function actualizarNombre() {
			let nombre = document.getElementById("nombre").value;
			//Se actualiza en municipio inm
			document.getElementById("contacto").value = nombre;
		}

function check(e) {
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla == 8) {
        return true;
    }

    // Patrón de entrada, en este caso solo acepta numeros y letras
    patron = /[a-zA-ZñÑáéíóúÁÉÍÓÚ ]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}
/*=============================================
EDITAR PROVEEDOR
=============================================*/
$(document).on("click", ".btnEditarProveedor", function(){

	var idProveedor = $(this).attr("idProveedor");
	
	var datos = new FormData();
	datos.append("idProveedor", idProveedor);

	$.ajax({

		url:"ajax/proveedores.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
      
      console.log(respuesta["tipo_persona"]);
			
			$("#nombreEditar").val(respuesta["nombre"]);
			$("#direccionEditar").val(respuesta["direccion"]);
			$("#rifEditar").val(respuesta["rif"]);
			$("#contactoEditar").val(respuesta["contacto"]);
			$("#porcentaje_retencion_editar").val(respuesta["porcentaje_retencion"]);
      
			$("#codigo_retencion_editar").html(respuesta["codigo_retencion"]);
			$("#codigo_retencion_editar").val(respuesta["codigo_retencion"]);
      
			$("#tipo_persona_editar").html(respuesta["tipo_persona"]);
			$("#tipo_persona_editar").val(respuesta["tipo_persona"]);
      
      
			$("#telefonoEditar").val(respuesta["telefono1"]);
			$("#telefonoEditar2").val(respuesta["telefono2"]);
      
			$("#emailEditar").val(respuesta["email"]);

			$("#idProveedor").val(respuesta["id_proveedor"]);

		}

	});

})

/*=============================================
ACTIVAR PROVEEDOR
=============================================*/
$(document).on("click", ".btnActivarProveedor", function(){

	var idProveedor = $(this).attr("idProveedor");
	var estadoProveedor = $(this).attr("estadoProveedor");

	var datos = new FormData();
 	datos.append("activarId", idProveedor);
  	datos.append("activarProveedor", estadoProveedor);

  	$.ajax({

	  url:"ajax/proveedores.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      	if(window.matchMedia("(max-width:767px)").matches){
		
      		 swal({
		      	title: "El proveedor ha sido actualizado",
		      	type: "success",
		      	confirmButtonText: "¡Cerrar!"
		    	}).then(function(result) {
		        
		        	if (result.value) {

		        	window.location = "proveedores";

		        }

		      });


		}
      }

  	})

  	if(estadoProveedor == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoProveedor',1);

  	}else{

  		$(this).addClass('btn-success');
  		$(this).removeClass('btn-danger');
  		$(this).html('Activado');
  		$(this).attr('estadoProveedor',0);

  	}

})

/*=============================================
REVISAR SI EL PROVEEDOR YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoProveedor").change(function(){

	$(".alert").remove();

	var proveedor = $(this).val();

	var datos = new FormData();
	datos.append("validarProveedor", proveedor);

	 $.ajax({
	    url:"ajax/proveedores.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoProveedor").parent().after('<div class="alert alert-warning">Este proveedor ya existe en la base de datos</div>');

	    		$("#nuevoProveedor").val("");

	    	}

	    }

	})
})

/*=============================================
ELIMINAR PROVEEDOR
=============================================*/
$(document).on("click", ".btnEliminarProveedor", function(){

  var idProveedor = $(this).attr("idProveedor");
  
  swal({
    title: '¿Está seguro de borrar el proveedor?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar proveedor!'
  }).then(function(result){

    if(result.value){

      window.location = "index.php?ruta=proveedores&idProveedor="+idProveedor;

    }

  })

})




