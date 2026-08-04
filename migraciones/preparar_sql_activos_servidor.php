<?php

if(PHP_SAPI !== "cli"){
	exit("Este proceso solo puede ejecutarse desde la línea de comandos.\n");
}

$entrada = $argv[1] ?? "D:/Users/peraz/Downloads/activos (3).sql";
$salida = $argv[2] ?? "D:/Users/peraz/Downloads/activos_zulia_migracion_servidor.sql";

if(!is_file($entrada)){
	fwrite(STDERR, "No se encontró el archivo de entrada.\n");
	exit(1);
}

$sql = file_get_contents($entrada);

// Esta copia es solo para agregar datos a una tabla `activos` existente.
$sql = preg_replace('/--\s*Estructura de tabla para la tabla `activos`\s*--\s*CREATE TABLE `activos`\s*\(.*?\) ENGINE=.*?;\s*/s', '', $sql);
$sql = preg_replace('/--\s*Índices para tablas volcadas.*?--\s*AUTO_INCREMENT de las tablas volcadas\s*--/su', '-- Datos preparados para una tabla existente --', $sql);
$sql = preg_replace('/--\s*Ãndices para tablas volcadas.*?--\s*AUTO_INCREMENT de las tablas volcadas\s*--/s', '-- Datos preparados para una tabla existente --', $sql);
$sql = preg_replace('/--\s*AUTO_INCREMENT de la tabla `activos`\s*--\s*ALTER TABLE `activos`.*?;\s*/s', '', $sql);

// El servidor asignará el id autoincremental; los códigos del activo se conservan.
$sql = str_replace('INSERT INTO `activos` (`id`, ', 'INSERT INTO `activos` (', $sql);
$sql = preg_replace('/^\(\d+,\s/m', '(', $sql);

$nota = "-- IMPORTACIÓN DE ACTIVOS EN TABLA EXISTENTE\n".
	"-- El campo `id` fue eliminado para evitar conflictos de clave primaria.\n".
	"-- Se conservan `codigo` y `codigo_uf`.\n".
	"-- No incluye CREATE TABLE, PRIMARY KEY ni ALTER TABLE.\n\n";

$sql = preg_replace('/^-- phpMyAdmin SQL Dump/', $nota.'-- phpMyAdmin SQL Dump', $sql, 1);

if(file_put_contents($salida, $sql) === false){
	fwrite(STDERR, "No se pudo crear el archivo de salida.\n");
	exit(1);
}

echo "Archivo creado: ".$salida."\n";

