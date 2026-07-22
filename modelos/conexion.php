<?php

/*
***************************
SERVIDOR
***************************

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=asonacop_system",
			            "asonacop_zenen",
			            "3317397Jb..");

		$link->exec("set names utf8");

		return $link;

	}

}


/***************************
LOCAL
***************************/


class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=asonacopcom_system",
			            "root",
			            "");

		$link->exec("set names utf8");

		return $link;

	}





// Class Conexion{

// 	static public function conectar(){

// 		$link = new PDO("mysql:host=localhost;dbname=asonacopcom_system",
// 			            "asonacopcom_zenen",
// 			            "3317397Jb..");

// 		$link->exec("set names utf8");

// 		return $link;

// 	}

}