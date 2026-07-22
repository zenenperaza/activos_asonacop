<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}
      /*=============================================
      AUDITORIA
      =============================================*/

      $usuario = $_SESSION["usuario"];  
      $accion = "Ingresó a Activos... ";         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

?>
  <div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar activos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar activos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarActivo">
          
          Agregar activos

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablaActivos" width="100%">
         
        <thead>
         
          <tr>
           
           <th style="width:10px">#</th>
           <th>Imagen</th>
           <th>Código</th>
           <th>Categoría</th>
           <th>Descripción</th>
           <th>Nro Serial</th>
           <th>Origen</th>
           <th>Situación contable</th>
           <th>Responsable</th>
           <th>Estado/Oficina</th>
           <th>Stock</th>
           <th>Precio de compra Bs</th>
           <th>Precio de compra $</th>
           <th>Fecha adquisición</th>
           <th>Observaciones</th>
           <th>Acciones</th>
           
         </tr> 

        </thead>

     <tbody>
     

                 
        </tbody> 

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR ACTIVO
======================================-->

<div id="modalAgregarActivo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar activos</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>
                  
                  <option value="">Selecionar categoría</option>
                  
                  <?php

                  $item = null;
                  $valor = null;

                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';
                  }

                  ?>

                
  
                </select>

              </div>

            </div>
            <!-- ENTRADA PARA SELECCIONAR UBICACION FISICA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                <select class="form-control input-lg" name="nuevoUbicacionFisica" id="nuevoUbicacionFisica">
                  
                  <option value="">Selecionar ubicación física</option>

                  <option value="ANZOATEGUI">Anzoategui</option>

                  <option value="AMAZONAS">Amazonas</option>

                  <option value="APURE">Apure</option>

                  <option value="ARAGUA">Aragua</option>

                  <option value="BOLIVAR">Bolivar</option>

                  <option value="CARABOBO">Carabobo</option>

                  <option value="DELTA AMACURO">Delta amacuro</option>

                  <option value="DISTRITO CAPITAL">Distrito Capital</option>

                  <option value="FALCON">Falcon</option>

                  <option value="LARA">Lara</option>

                  <option value="MERIDA">Merida</option>

                  <option value="MIRANDA">Miranda</option>

                  <option value="SUCRE">Sucre</option>

                  <option value="TACHIRA">Tachira</option>

                  <option value="ZULIA">Zulia</option>

                </select>

              </div>

            </div>
            
            <!-- ENTRADA PARA EL CÓDIGO POR UBICACION FISICA-->
            
           <div class="form-group row">

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" id="nuevoCodigoUF" name="nuevoCodigoUF" placeholder="Ingresar código por Ubicación física" readonly required>

              </div>      
            </div>          

            <!-- ENTRADA PARA EL CÓDIGO -->
            
               <div class="col-xs-12 col-sm-6">
              
              <div class="input-group">
               
                <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingresar código" readonly required>

              </div>

            </div>
            
          </div>          


            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar descripción" pattern="[A-Za-z0-9 ]{1,100}" required>

              </div>

            </div>

             <!-- ENTRADA PARA EL SERIAL NUMERO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-barcode"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoSerialNumero" placeholder="Ingresar serial número">

              </div>

            </div>
            
             <!-- ENTRADA PARA LA FECHA DE ADQUISICION -->
          <div class="form-group">

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right input-lg" name="nuevaFechaAdquisicion" placeholder="Ingresar fecha de adquisición (dd/mm/yyyy)" id="" >
                </div>
                <!-- /.input group -->
              </div>
            
             <!-- ENTRADA PARA SELECCIONAR FUNETE DE FINANCIAMIENTO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-money"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaFuenteFinanciamiento" id="nuevaFuenteFinanciamiento" placeholder="Ingresar fuente de financiamiento" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA SELECCIONAR ORIGEN DEL ACTIVO -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                <select class="form-control input-lg" name="nuevoOrigen">
                  
                  <option value="">Selecionar origen</option>

                  <option value="Compra">Compra</option>

                  <option value="Donativo">Donativo</option>

                  <option value="Prestamo">Préstamo</option>

                  <option value="Personal">Personal</option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA TIPO DE ORIGEN -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoTipoOrigen" placeholder="Ingresar tipo de origen">

              </div>

            </div>
            <!-- ENTRADA PARA SELECCIONAR SITUACION CONTABLE -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                <select class="form-control input-lg" name="nuevoSituacionContable">
                  
                  <option value="">Selecionar situación contable</option>

                  <option value="Uso interno">Uso interno</option>

                  <option value="Donacion">Donación</option>

                  <option value="Comodato">Comodato</option>

                  <option value="Comodato">En almacen</option>

                  <option value="Desincorporacion">Desincorporación</option>

                  <option value="Perdida por robo">Pérdida por robo</option>

                </select>

              </div>

            </div>
            
             
            <!-- ENTRADA PARA LA RESPONSABLE -->


            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" id="nuevoResponsable" name="nuevoResponsable" required>
                  
                  <option value="">Selecionar responsable</option>
                  
                  <?php

                  $item = null;
                  $valor = null;

                  $empleados = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

                  foreach ($empleados as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["nombre"].' '.$value["apellido"].'</option>';
                  }

                  ?>

                
  
                </select>

              </div>

            </div>
            
             <!-- ENTRADA PARA LA FECHA RESPONSABLE -->

          <div class="form-group">

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right input-lg" name="nuevaFechaEntregaResponsable" placeholder="Ingresar fecha entrega (dd/mm/yyyy)" id="">
                </div>
                <!-- /.input group -->
              </div>
            
             <!-- ENTRADA PARA SELECCIONAR ESTADO DE CONSERVACION -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                <select class="form-control input-lg" name="nuevoEstadoConservacion">
                  
                  <option value="">Selecionar estado de conservación</option>

                  <option value="Excelente">Excelente</option>

                  <option value="Bueno">Bueno</option>

                  <option value="Regular">Regular</option>

                  <option value="Malo">Malo</option>

                </select>

              </div>

            </div>
            
             <!-- ENTRADA PARA LA GARANTIA -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaGarantia" placeholder="Ingresar información de garantia">

              </div>

            </div>
            
             <!-- ENTRADA PARA OBSERVACIONES -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaObservaciones" placeholder="Ingresar observaciones">

              </div>

            </div>
            
             <!-- ENTRADA PARA STOCK -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" name="nuevoStock" min="0" placeholder="Stock" required>

              </div>

            </div>

             <!-- ENTRADA PARA PRECIO COMPRA Bs-->

             <div class="form-group row">

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                    <input type="number" class="form-control input-lg" id="nuevoPrecioCompraBs" name="nuevoPrecioCompraBs" min="0" step="any" placeholder="Precio de compra Bs" required>

                  </div>

                </div>

                <!-- ENTRADA PARA PRECIO COMPRA $ -->

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                    <input type="number" class="form-control input-lg" id="nuevoPrecioCompraDs" name="nuevoPrecioCompraDs" min="0" step="any" placeholder="Precio de compra $">

                  </div>
                
                  <br>

                 

                </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaImagen" name="nuevaImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/activos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar activo</button>

        </div>

      </form>



    </div>

  </div>

</div>



<!--=====================================
MODAL EDITAR ACTIVO
======================================-->

<div id="modalEditarActivo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar activo</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


             <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" name="editarCategoria" readonly required>
                  
                  <option id="editarCategoria"></option>             
                        
                </select>

              </div>

            </div>

                <!-- ENTRADA PARA SELECCIONAR UBICACION FISICA -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                <select class="form-control input-lg editarUbicacionFisica" name="editarUbicacionFisica">
                  
                  <option id="editarUbicacionFisica"></option>


                  <option value="ANZOATEGUI">Anzoategui</option>

                  <option value="AMAZONAS">Amazonas</option>

                  <option value="APURE">Apure</option>

                  <option value="ARAGUA">Aragua</option>

                  <option value="BOLIVAR">Bolivar</option>

                  <option value="CARABOBO">Carabobo</option>

                  <option value="DELTA AMACURO">Delta amacuro</option>

                  <option value="DISTRITO CAPITAL">Distrito Capital</option>

                  <option value="FALCON">Falcon</option>

                  <option value="LARA">Lara</option>

                  <option value="MERIDA">Merida</option>

                  <option value="MIRANDA">Miranda</option>

                  <option value="SUCRE">Sucre</option>

                  <option value="TACHIRA">Tachira</option>

                  <option value="ZULIA">Zulia</option>


                </select>

              </div>

            </div>

                 <!-- ENTRADA PARA EL CÓDIGO POR UBICACION FISICA-->
            
           <div class="form-group row">

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="text" class="form-control input-lg" id="editarCodigoUF" name="editarCodigoUF" readonly required>

              </div>      
            </div>          

            <!-- ENTRADA PARA EL CÓDIGO -->
            
               <div class="col-xs-12 col-sm-6">
              
              <div class="input-group">
               
                <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" placeholder="Ingresar código" readonly required>

              </div>

            </div>
            
          </div>  

           .

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" name="editarDescripcion"  pattern="[A-Za-z0-9 ]{1,100}"  id="editarDescripcion" required>

              </div>

            </div>
            
             <!-- ENTRADA PARA EL SERIAL NUMERO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-barcode"></i></span> 

                <input type="text" class="form-control input-lg" name="editarSerialNumero" id="editarSerialNumero" placeholder="Ingresar serial número">

              </div>

            </div>

             <!-- ENTRADA PARA LA FECHA DE ADQUISICION -->
          <div class="form-group">

                <div class="input-group date">
                 
                  <div class="input-group-addon">
                   
                    <i class="fa fa-calendar"></i>
                    
                  </div>
                  
                  <input type="text" class="form-control pull-right" name="editarFechaAdquisicion" id="editarFechaAdquisicion" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                  
                </div>
                <!-- /.input group -->
              </div>
            
             <!-- ENTRADA PARA SELECCIONAR FUNETE DE FINANCIAMIENTO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-money"></i></span> 

                <input type="text" class="form-control input-lg" name="editarFuenteFinanciamiento" id="editarFuenteFinanciamiento" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA SELECCIONAR ORIGEN DEL ACTIVO -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                <select class="form-control input-lg" name="editarOrigen">
                  
                  <option id="editarOrigen"></option>
                  
                  <option value="Compra">Compra</option>

                  <option value="Donativo">Donativo</option>

                  <option value="Prestamo">Préstamo</option>

                  <option value="Personal">Personal</option>


                </select>

              </div>

            </div>

            <!-- ENTRADA PARA TIPO DE ORIGEN -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span> 

                <input type="text" class="form-control input-lg" name="editarTipoOrigen" id="editarTipoOrigen" placeholder="Ingresar tipo de origen">

              </div>

            </div>
            <!-- ENTRADA PARA SELECCIONAR SITUACION CONTABLE -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                <select class="form-control input-lg" name="editarSituacionContable">
                  
                  <option id="editarSituacionContable"></option>

                  <option value="Uso interno">Uso interno</option>

                  <option value="Donacion">Donación</option>

                  <option value="Comodato">Comodato</option>

                  <option value="Desincorporacion">Desincorporación</option>

                  <option value="Perdida por robo">Pérdida por robo</option>


                </select>

              </div>

            </div>
            
            
            <!-- ENTRADA PARA LA RESPONSABLE -->


            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" name="editarResponsable" required>
                  
                  <option id="editarResponsable">Selecionar responsable</option>
                  
                  <?php

                  $item = null;
                  $valor = null;

                  $empleados = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

                  foreach ($empleados as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["nombre"].' '.$value["apellido"].'</option>';
                  }

                  ?>                
  
                </select>

              </div>

            </div>
                       
             <!-- ENTRADA PARA LA FECHA DE ENTREGA -->
          <div class="form-group">

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="editarFechaEntregaResponsable" id="editarFechaEntregaResponsable" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                </div>
                <!-- /.input group -->
              </div>
            
             <!-- ENTRADA PARA SELECCIONAR ESTADO DE CONSERVACION -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                <select class="form-control input-lg" name="editarEstadoConservacion">
                  
                  <option id="editarEstadoConservacion"></option>

                  <option value="Excelente">Excelente</option>

                  <option value="Bueno">Bueno</option>

                  <option value="Regular">Regular</option>

                  <option value="Malo">Malo</option>


                </select>

              </div>

            </div>
            
             <!-- ENTRADA PARA LA GARANTIA -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" name="editarGarantia" id="editarGarantia">

              </div>

            </div>
            
             <!-- ENTRADA PARA OBSERVACIONES -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" name="editarObservaciones" id="editarObservaciones" >

              </div>

            </div>
            
             <!-- ENTRADA PARA STOCK -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-check"></i></span> 

                <input type="number" class="form-control input-lg" name="editarStock" min="0" id="editarStock" required>

              </div>

            </div>

             <!-- ENTRADA PARA PRECIO COMPRA Bs-->

             <div class="form-group row">

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                    <input type="number" class="form-control input-lg" id="editarPrecioCompraBs" name="editarPrecioCompraBs" min="0" step="any" required>

                  </div>

                </div>

                <!-- ENTRADA PARA PRECIO COMPRA $ -->

                <div class="col-xs-12 col-sm-6">
                
                  <div class="input-group">
                  
                    <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                    <input type="number" class="form-control input-lg" id="editarPrecioCompraDs" name="editarPrecioCompraDs" min="0" step="any" >

                  </div>
                
                  <br>

                 

                </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="editarImagen" name="editarImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/activos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="imagenActual" id="imagenActual">

            </div>

          </div>

        </div>

        <!--===================================== 
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

 



    </div>

  </div>

</div>
<div class="errores"> 
  <?php

      $editarActivo = new ControladorActivos();
      $editarActivo -> ctrEditarActivo();

    ?> 
 <?php

    $eliminarActivo = new ControladorActivos();
    $eliminarActivo -> ctrEliminarActivo();

 ?>


       <?php

          $crearActivo = new ControladorActivos();
          $crearActivo -> ctrCrearActivo();

        ?>  
</div>
 

