<?php

require_once "controladores/plantilla.controlador.php";

require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/activos.controlador.php";
require_once "controladores/empleados.controlador.php";
require_once "controladores/asignaciones.controlador.php";
require_once "controladores/participantes.controlador.php";
require_once "controladores/auditorias.controlador.php";
require_once "controladores/proveedores.controlador.php";

require_once "controladores/estados.controlador.php";
require_once "controladores/municipios.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/activos.modelo.php";
require_once "modelos/empleados.modelo.php";
require_once "modelos/asignaciones.modelo.php";
require_once "modelos/participantes.modelo.php";
require_once "modelos/auditorias.modelo.php";
require_once "modelos/proveedores.modelo.php";

require_once "modelos/estados.modelo.php";
require_once "modelos/municipios.modelo.php";


$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();