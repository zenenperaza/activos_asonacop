<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Crear asignacion
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Crear asignacion</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->
      
      <div class="col-lg-5 col-xs-12">
        
        <div class="box box-success">
          
          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioAsignacion">

            <div class="box-body">
  
              <div class="box">

                <!--=====================================
                ENTRADA DEL USUARIO
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoUsuario" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idUsuario" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      

                    <?php


                    $item = null;
                    $valor = null;

                    $asignaciones = ControladorAsignaciones::ctrMostrarAsignaciones($item, $valor);

                    if(!$asignaciones){

                      echo '
                      
                      <input type="text" class="form-control" id="nuevaAsignacion" name="nuevaAsignacion" value="10001" readonly required>';
                  

                    }else{

                      foreach ($asignaciones as $key => $value) {
                        
                        
                      
                      }

                      $codigo = $value["codigo"] + 1;



                      echo '<input type="text" class="form-control" id="nuevaAsignacion" name="nuevaAsignacion" value="'.$codigo.'" readonly required>';
                  

                    }


                    ?>
                    
                    
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA DEL EMPLEADO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    
                    <select class="form-control" id="seleccionarEmpleado" name="seleccionarEmpleado" required>

                    <option value="">Seleccionar Empleado</option>

                    <?php

                    $item = null;
                    $valor = null;

                      $empleados = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

                       foreach ($empleados as $key => $value) {

                         echo '<option value="'.$value["id"].'">'.$value["nombre"].' '.$value["apellido"].'</option>';

                       }

                    ?>

                    </select>
                    
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarEmpleado" data-dismiss="modal">Agregar Empleado</button></span>
                  
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR ACTIVO
                ======================================--> 

                <div class="form-group row nuevoActivo">

                

                </div>

                <input type="hidden" id="listaActivos" name="listaActivos">

                <!--=====================================
                BOTÓN PARA AGREGAR ACTIVO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarActivo">Agregar Activo</button>

                <hr>

                <div class="row">

                  <!--=====================================
                  ENTRADA TOTAL
                  ======================================-->
                  
                  <div class="col-xs-8 pull-right">
                    
                    <table class="table">

                      <thead>

                        <tr>
                          <th>Total</th>      
                        </tr>

                      </thead>

                      <tbody>
                      
                        <tr>
                      

                           <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <span class="input-group-addon"><i class="ion ion-social-bs">Bs.</i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalAsignacion" name="nuevoTotalAsignacion" total="" placeholder="00000" readonly required>

                              <input type="hidden" name="totalAsignacion" id="totalAsignacion">
                              
                        
                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>

                <hr>

             

                 
                </div>

                <br>
      
              </div>


          <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right">Guardar Asignacion</button>

          </div>

        </form>

        <?php

          $guardarAsignacion = new ControladorAsignaciones();
          $guardarAsignacion -> ctrCrearAsignacion();
          
        ?>

        </div>
            
      </div>

      <!--=====================================
      LA TABLA DE ActivoS
      ======================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        
        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">
            
            <table class="table table-bordered table-striped dt-responsive tablaAsignaciones">
              
               <thead>

                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripcion</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                </tr>

              </thead>

            </table>

          </div>

        </div>


      </div>

    </div>
   
  </section>

</div>

<!--=====================================
MODAL AGREGAR EMPLEADO
======================================-->

<div id="modalAgregarEmpleado" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Empleado</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">
            
            <!-- ENTRADA PARA EL CEDULA -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="3000000" max="99999999" maxlength="8" class="form-control" placeholder="Ingresar Cédula" name="nuevaCedula" id="nuevaCedula" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control" name="nuevoNombre" placeholder="Ingresar nombre" required>

              </div>

            </div>            
            
            <!-- ENTRADA PARA EL TELEFONO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control" placeholder="Ingresar teléfono" name="nuevoTelefono" id="nuevoTelefono" data-inputmask='"mask": "(9999) 999-9999"'  data-mask >

              </div>

            </div>
            
            <!-- ENTRADA PARA EL EMAIL -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control" placeholder="Email" name="nuevoEmail" id="nuevoEmail" .>

              </div>

            </div>            

            <!-- ENTRADA PARA EL DIRECCION -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control" placeholder="Ingresar Dirección" name="nuevaDireccion" id="nuevaDireccion" >

              </div>

            </div>
            
            <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
              <div class="form-group">

                <div class="input-group date">
                 
                  <div class="input-group-addon">
                   
                    <i class="fa fa-calendar"></i>
                    
                  </div>
                  
                  <input type="text" class="form-control pull-right" name="nuevaFechaNacimiento" placeholder="Ingresar fecha de nacimiento (dd/mm/yyyy)" id="datepicker" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                  
                </div>
                <!-- /.input group -->
              </div>
              
            
            <!-- ENTRADA PARA SELECCIONAR SU CARGO -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 

                <select class="form-control" name="nuevoCargo">
                  
                  <option value="">Selecionar Cargo</option>

                  <option value="Administrador">Administrador</option>

                  <option value="Contador">Contador</option>

                  <option value="Informatico">Informatico</option>

                </select>

              </div>

            </div>
              
              <!-- ENTRADA PARA LA FECHA DE INGRESO -->
              <div class="form-group">

                <div class="input-group date">
                 
                  <div class="input-group-addon">
                   
                    <i class="fa fa-calendar"></i>
                    
                  </div>
                  
                  <input type="text" class="form-control pull-right" name="nuevaFechaIngreso" placeholder="Ingresar fecha Ingreso (dd/mm/yyyy)" id="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                  
                </div>
                <!-- /.input group -->
              </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR FOTO</div>

              <input type="file" class="nuevaFoto" name="nuevaFoto">

              <p class="help-block">Peso máximo de la foto 200 MB</p>

              <img src="vistas/img/empleados/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

            </div>

          </div>

        </div>
 <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar empleado</button>

        </div>

        <?php


          $crearEmpleado = new ControladorEmpleados();
          $crearEmpleado -> ctrCrearEmpleado();


        ?>

      </form>

    </div>

  </div>

</div>
