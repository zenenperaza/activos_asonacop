<?php

if($_SESSION["perfil"] == "Usuario"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>  
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar participantes
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar participantes</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarParticipante">
          
          Agregar participantes

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablaParticipantes" width="100%">
         
        <thead>
         
          <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre</th>
           <th>Cédula</th>
           <th>Email</th>
           <th>Estado</th>
           <th>Fecha</th>
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
MODAL AGREGAR Participante
======================================-->

<div id="modalAgregarParticipante" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Participantes</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">
          
          
           <!-- ENTRADA PARA LA nombre -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" id="cedula" name="cedula" placeholder="Ingresar cédula" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA LA nombre -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" name="nombre" placeholder="Ingresar nombre" required>

              </div>

            </div>
            
             <!-- ENTRADA PARA LA apellido -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" name="apellido" placeholder="Ingresar apellido" required>

              </div>

            </div>


            
            <!-- ENTRADA PARA SELECCIONAR sexo -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                <select class="form-control input-lg" name="sexo" id="sexo">
                  
                  <option value="">Selecionar sexo</option>

                  <option value="MASCULINO">MASCULINO</option>

                  <option value="FEMENINO">FEMENINO</option>


                </select>

              </div>

            </div>
            
                  <!-- ENTRADA PARA LA FECHA DE nac -->
          <div class="form-group">

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right input-lg" name="fecha_nacimiento" placeholder="Ingresar fecha de nacimineto (dd/mm/yyyy)" id="datepicker" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask >
                </div>
                <!-- /.input group -->
              </div>
              
                  <!-- ENTRADA PARA EL EMAIL -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control" placeholder="Email" name="email" id="email">

              </div>

            </div> 
            
           <!-- ENTRADA PARA EL TELEFONO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control" placeholder="Ingresar teléfono" name="celular" id="celular" data-inputmask='"mask": "(9999) 999-9999"'  data-mask>

              </div>

            </div>
            
                   

            <!-- ENTRADA PARA EL DIRECCION -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control" placeholder="Ingresar Dirección" name="direccion" id="direccion">

              </div>

            </div>  
                 

                </div>


        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar participante</button>

        </div>

      </form>

       <?php

       /*   $crearActivo = new ControladorActivos();
          $crearActivo -> ctrCrearActivo();
*/
        ?>  


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

                  <option value="LARA">Lara</option>

                  <option value="BOLIVAR">Bolívar</option>

                  <option value="ZULIA">Zulia</option>

                  <option value="TACHIRA">Táchira</option>

                  <option value="MIRANDA">Miranda</option>

                  <option value="ANZOATEGUI">Anzoategui</option>


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

                <input type="text" class="form-control input-lg" name="editarDescripcion"  id="editarDescripcion" required>

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
                    
                    echo '<option value="'.$value["nombre"].' '.$value["apellido"].'">'.$value["nombre"].' '.$value["apellido"].'</option>';
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

    <?php

      $editarActivo = new ControladorActivos();
      $editarActivo -> ctrEditarActivo();

    ?>  



    </div>

  </div>

</div>
 <?php

    $eliminarParticipante = new ControladorParticipantes();
    $eliminarParticipante -> ctrEliminarParticipante();

 ?>



