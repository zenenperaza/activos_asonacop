<?php      
/*=============================================
      AUDITORIA
      =============================================*/

      $usuario = $_SESSION["usuario"];  
      $accion = "Ingresar nuevo Activo - ".$_POST["nuevaDescripcion"];         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 



        /*=============================================
        AUDITORIA
        =============================================*/
        $tablaAuditoria = "activos";
        $itemAuditoria = "id";
        $valorAuditoria = $_GET["idActivo"];
        $respuestaAuditoria =  ModeloActivos::mdlMostrarActivos($tablaAuditoria, $itemAuditoria, $valorAuditoria);

        $usuario = $_SESSION["usuario"];  
        $accion = "Eliminar Activo: ".$respuestaAuditoria['descripcion']." Responsable:  ".$respuestaAuditoria['responsable'];         
        $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
        /*=============================================
        AUDITORIA FIN
        =============================================*/ 