<?php

require_once "../../controladores/asignaciones.controlador.php";
require_once "../../modelos/asignaciones.modelo.php";
require_once "../../controladores/empleados.controlador.php";
require_once "../../modelos/empleados.modelo.php";
require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";

$reporte = new ControladorAsignaciones();
$reporte -> ctrDescargarReporte();

