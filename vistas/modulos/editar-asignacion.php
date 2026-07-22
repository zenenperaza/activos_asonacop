<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      <Crear>Editar</Crear> asignacion
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active"><Crear>Editar</Crear> asignacion</li>
    
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
               <?php


                    $item = "id";
                    $valor = $_GET["idAsignacion"];
                    $asignacion = ControladorAsignaciones::ctrMostrarAsignaciones($item, $valor);
                   // var_dump($asignacion);

                    $itemUsuario = "id";
                    $valorUsuario = $asignacion["id_usuario"];
                    $usuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemEmpleado = "id";
                    $valorEmpleado = $asignacion["id_empleado"];
                    $empleado = ControladorEmpleados::ctrMostrarEmpleados($itemEmpleado, $valorEmpleado);

                ?>

                <!--=====================================
                ENTRADA DEL USUARIO
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoUsuario" value="<?php echo $usuario["nombre"]; ?>" readonly>

                    <input type="hidden" name="idUsuario" value="<?php echo $usuario["id"]; ?>">

                  </div>

                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>                      

                      
                      <input type="text" class="form-control" id="editarAsignacion" name="editarAsignacion" value="<?php echo $asignacion["codigo"]; ?>" readonly required>    



                    <input type="hidden" name="id" value="<?php echo $asignacion["id"]; ?>">    

                    
                    
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA DEL EMPLEADO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    
                    <select class="form-control" id="seleccionarEmpleado" name="seleccionarEmpleado" required>

                    <option value="<?php echo $empleado["id"]; ?>"><?php echo $empleado["nombre"]; ?></option>

                    <?php

                    $item = null;
                    $valor = null;

                      $empleados = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);

                       foreach ($empleados as $key => $value) {

                         echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';

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


                <?php

                $listaActivo = json_decode($asignacion["activos"], true);

                foreach ($listaActivo as $key => $value) {

                  $item = "id";
                  $valor = $value["id"]; 
                  $orden = "id";                 

                  $respuesta = ControladorActivos::ctrMostrarActivos($item, $valor, $orden);

                  $stockAntiguo = $respuesta["stock"] + $value["cantidad"];
                  
                  echo '<div class="row" style="padding:5px 15px">
            
                        <div class="col-xs-6" style="padding-right:0px">
            
                          <div class="input-group">
                
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarActivo" idActivo="'.$value["id"].'"><i class="fa fa-times"></i></button></span>

                            <input type="text" class="form-control nuevaDescripcionActivo" idActivo="'.$value["id"].'" name="agregarActivo" value="'.$value["descripcion"].'" readonly required>

                          </div>
 
                        </div>

                        <div class="col-xs-3">
              
                          <input type="number" class="form-control nuevaCantidadActivo" name="nuevaCantidadActivo" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" required>

                        </div>

                        <div class="col-xs-3 ingresoPrecio" style="padding-left:0px">

                          <div class="input-group">

                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                   
                            <input type="text" class="form-control nuevoPrecioActivo" precioReal="'.$respuesta["precio_compra_bs"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" readonly required>
   
                          </div>
               
                        </div>

                      </div>';
                }


                ?>

                

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
                           
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalAsignacion" name="nuevoTotalAsignacion" total="" value="<?php echo $asignacion["total"]; ?>" readonly required>

                              <input type="hidden" name="totalAsignacion" id="totalAsignacion" value="<?php echo $asignacion["total"]; ?>">
                              
                        
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

            <button type="submit" class="btn btn-primary pull-right">Guardar cambios</button>

          </div>

        </form>

        <?php

          $editarAsignacion = new ControladorAsignaciones();
          $editarAsignacion -> ctrEditarAsignacion();
          
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
              
              <div class="input-group">v
              
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

                <input type="email" class="form-control" placeholder="Email" name="nuevoEmail" id="nuevoEmail" >

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
