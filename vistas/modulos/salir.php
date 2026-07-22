<?php

session_destroy();

     /*=============================================
      AUDITORIA
      =============================================*/
//       $tablaAuditoria = "usuarios";
//       $itemAuditoria = "id";
//       $valorAuditoria = $_GET["idUsuario"];
//       $respuestaAuditoria = ModeloUsuarios::MdlMostrarUsuarios($tablaAuditoria, $itemAuditoria, $valorAuditoria);
      
//       $crearAuditoria = new ControladorAuditorias();
      $usuario = $_SESSION["usuario"];  
      $accion = "Salir del Sistema";         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

echo '<script>

	window.location = "index.php";

</script>';