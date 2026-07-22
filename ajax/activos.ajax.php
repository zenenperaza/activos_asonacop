<?php

require_once "../controladores/activos.controlador.php";
require_once "../modelos/activos.modelo.php";


class AjaxActivos{

    
     /*=============================================
  GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
  =============================================*/
  public $idCategoria;

  public function ajaxCrearCodigoActivo(){

    $item = "id_categoria";
    
    $orden = "id";
      
    $valor = $this->idCategoria;

    $respuesta = ControladorActivos::ctrMostrarActivos($item, $valor, $orden);

    echo json_encode($respuesta);

  }


  /*=============================================
  EDITAR ACTIVO
  =============================================*/ 

  public $idActivo;
  public $traerActivos;
  public $nombreActivo;

  public function ajaxEditarActivo(){

    if($this->traerActivos == "ok"){

      $item = null;
      $valor = null;
      $orden = "id";

      $respuesta = ControladorActivos::ctrMostrarActivos($item, $valor, $orden);

      echo json_encode($respuesta);


    }else if($this->nombreActivo != ""){

      $item = "descripcion";
      $orden = "id";
      $valor = $this->nombreActivo;

      $respuesta = ControladorActivos::ctrMostrarActivos($item, $valor, $orden);

      echo json_encode($respuesta);

    }else{

      $item = "id";
      $orden = "id";
      $valor = $this->idActivo;

      $respuesta = ControladorActivos::ctrMostrarActivos($item, $valor, $orden);

      echo json_encode($respuesta);

    }

  }

}


/*=============================================
GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
=============================================*/ 

if(isset($_POST["idCategoria"])){

  $codigoActivo = new AjaxActivos();
  $codigoActivo -> idCategoria = $_POST["idCategoria"];
  $codigoActivo -> ajaxCrearCodigoActivo();

}
/*=============================================
EDITAR ACTTIVOS
=============================================*/ 

if(isset($_POST["idActivo"])){

  $editarActivo = new AjaxActivos();
  $editarActivo -> idActivo = $_POST["idActivo"];
  $editarActivo -> ajaxEditarActivo();

}
/*=============================================
EDITAR ACTIVO
=============================================*/ 

if(isset($_POST["traerActivos"])){

  $traerActivos = new AjaxActivos();
  $traerActivos -> traerActivos = $_POST["traerActivos"];
  $traerActivos -> ajaxEditarActivo();

}

/*=============================================
NOMBRE ACTIVO
=============================================*/ 

if(isset($_POST["nombreActivo"])){

  $nombreActivos = new AjaxActivos();
  $nombreActivos -> nombreActivo = $_POST["nombreActivo"];
  $nombreActivos -> ajaxEditarActivo();

}







