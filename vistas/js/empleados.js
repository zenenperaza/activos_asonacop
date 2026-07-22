

/*=============================================
SUBIENDO LA FOTO DEL Empleado
=============================================*/
$(".nuevaFoto").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

  		$(".nuevaFoto").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe estar en formato JPG o PNG!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else if(imagen["size"] > 2000000){

  		$(".nuevaFoto").val("");

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
EDITAR EMPLEADO 
=============================================*/
$(document).on("click", ".btnEditarEmpleado", function(){

	var idEmpleado = $(this).attr("idEmpleado");
	
	var datos = new FormData();
	datos.append("idEmpleado", idEmpleado);

	$.ajax({

		url:"ajax/empleados.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#idEmpleado").val(respuesta["id"]);
			$("#editarCedula").val(respuesta["cedula"]);
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarApellido").val(respuesta["apellido"]);
			$("#editarTelefono").val(respuesta["telefono"]);
			$("#editarEmail").val(respuesta["email"]);
			$("#editarDireccion").val(respuesta["direccion"]);
			$("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);
			$("#editarCargo").val(respuesta["cargo"]);
			$("#editarCargo").html(respuesta["cargo"]);
			$("#editarFechaIngreso").val(respuesta["fecha_ingreso"]);

		
            if(respuesta["foto"] != ""){

           	$("#fotoActual").val(respuesta["foto"]);

           	$(".previsualizar").attr("src",  respuesta["foto"]);

           } else {

           	$(".previsualizar").attr("src", "vistas/img/empleados/default/anonymous.png");

           }
		}

	});

})

/*=============================================
ACTIVAR EMPLEADO
=============================================*/
$(document).on("click", ".btnActivarEmpleado", function(){	

	var idEmpleado = $(this).attr("idEmpleado");
	var estadoEmpleado = $(this).attr("estadoEmpleado");

	var datos = new FormData();
 	datos.append("activarId", idEmpleado);
  	datos.append("activarEmpleado", estadoEmpleado);

  	$.ajax({

	  url:"ajax/empleados.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      	if(window.matchMedia("(max-width:767px)").matches){
		
      		 swal({
		      	title: "El empleado ha sido actualizado",
		      	type: "success",
		      	confirmButtonText: "¡Cerrar!"
		    	}).then(function(result) {
		        
		        	if (result.value) {

		        	window.location = "empleados";

		        }

		      });


		}
      }

  	})

  	if(estadoEmpleado == 1){

  		$(this).removeClass('btn-danger');
  		$(this).addClass('btn-success');
  		$(this).html('Interno');
  		$(this).attr('estadoEmpleado',0);

  	}else{

  		$(this).addClass('btn-danger');
  		$(this).removeClass('btn-success');
  		$(this).html('Externo');
  		$(this).attr('estadoEmpleado',1);

  	}

  	

})

/*=============================================
REVISAR SI EL Empleado YA ESTÁ REGISTRADO nuevaCedula
=============================================*/

$("#nuevaCedula").change(function(){

	$(".alert").remove();

	var cedula = $(this).val();

	var datos = new FormData();
	datos.append("validarEmpleado", cedula);

	 $.ajax({
	    url:"ajax/empleados.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevaCedula").parent().after('<div class="alert alert-warning">Este Empleado ya existe en la base de datos</div>');

	    		$("#nuevaCedula").val("");

	    	}

	    }

	})
})

/*=============================================
ELIMINAR Empleado
=============================================*/
$(document).on("click", ".btnEliminarEmpleado", function(){
    
    //idEmpleado="'.$value["id"].'" fotoEmpleado="'.$value["foto"].'" cedula="'.$value["cedula"].'"

  var idEmpleado = $(this).attr("idEmpleado");
  var fotoEmpleado = $(this).attr("fotoEmpleado");
  var cedula = $(this).attr("cedula");

  swal({
    title: '¿Está seguro de borrar el empleado?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar empleado!'
  }).then(function(result){

    if(result.value){

      window.location = "index.php?ruta=empleados&idEmpleado="+idEmpleado+"&cedula="+cedula+"&fotoEmpleado="+fotoEmpleado;

    }

  })

})




