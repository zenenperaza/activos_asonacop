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
      $accion = "Ingresó a Empleados... ";         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

?>
  <div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar empleados
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar empleados</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEmpleado">
          
          Agregar empleado

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>           
           <th style="width:10px">#</th>
           <th>Foto</th>
           <th>Cédula</th>
           <th>Nombre</th>
           <th>telefono</th>
           <th>E-Mail</th>           
           <th>Dirección</th>
           <th>fecha de Nacimiento</th>
           <th>Estatus</th>
           <th>Cargo</th>
           <th>fecha de Ingreso</th>
           <th>Acciones</th>
         </tr> 

        </thead>
        <tbody>
         
        <?php

        $item = null;
        $valor = null;

        $empleados = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);
 
       foreach ($empleados as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>';
                  
                  if($value["foto"] != ""){

                    echo '<td><img src="'.$value["foto"].'" class="img-thumbnail" width="40px"></td>';

                  }else{

                    echo '<td><img src="vistas/img/empleados/default/anonymous.png" class="img-thumbnail" width="40px"></td>';

                  }
                  
                   echo ' <td>'.$value["cedula"].'</td>
                  <td>'.$value["nombre"].'</td>
                  <td>'.$value["telefono"].'</td>
                  <td>'.$value["email"].'</td>
                  <td>'.$value["direccion"].'</td>';

                  

                  echo '<td>'.$value["fecha_nacimiento"].'</td>';
           
                  if($value["estado"] != 0){

                        echo '<td><button class="btn btn-success btn-xs btnActivarEmpleado" idEmpleado="'.$value["id"].'" estadoEmpleado="0">Interno</button></td>';

                      }else{

                        echo '<td><button class="btn btn-danger btn-xs btnActivarEmpleado" idEmpleado="'.$value["id"].'" estadoEmpleado="1">Externo</button></td>';

                   }    

                 
                  echo '<td>'.$value["cargo"].'</td>
                        <td>'.$value["fecha_ingreso"].'</td>
                  <td>

                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarEmpleado" idEmpleado="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarEmpleado"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger btnEliminarEmpleado" idEmpleado="'.$value["id"].'" fotoEmpleado="'.$value["foto"].'" cedula="'.$value["cedula"].'"><i class="fa fa-times"></i></button>

                    </div>  

                  </td>

                </tr>';
        }


        ?>           
         
        </tbody>        

       </table>

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

                <input type="text" class="form-control" placeholder="Ingresar teléfono" name="nuevoTelefono" id="nuevoTelefono" data-inputmask='"mask": "(9999) 999-9999"'  data-mask>

              </div>

            </div>
            
            <!-- ENTRADA PARA EL EMAIL -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control" placeholder="Email" name="nuevoEmail" id="nuevoEmail">

              </div>

            </div>            

            <!-- ENTRADA PARA EL DIRECCION -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control" placeholder="Ingresar Dirección" name="nuevaDireccion" id="nuevaDireccion">

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

<!--=====================================
MODAL EDITAR EMPLEADO
======================================-->

<div id="modalEditarEmpleado" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar empleado</h4>

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

                <input type="number" min="3000000" max="99999999" maxlength="8" class="form-control" name="editarCedula" id="editarCedula" required>
                
                <input type="hidden" id="idEmpleado" name="idEmpleado">

              </div>

            </div>

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control" name="editarNombre" id="editarNombre" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA EL TELEFONO -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control" name="editarTelefono" id="editarTelefono" data-inputmask='"mask": "(9999) 999-9999"'  data-mask>

              </div>

            </div>
            
            <!-- ENTRADA PARA EL EMAIL -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control" name="editarEmail" id="editarEmail" >

              </div>

            </div>            

            <!-- ENTRADA PARA EL DIRECCION -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control" name="editarDireccion" id="editarDireccion"  >

              </div>

            </div>
            
            <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
              <div class="form-group">

                <div class="input-group date">
                 
                  <div class="input-group-addon">
                   
                    <i class="fa fa-calendar"></i>
                    
                  </div>
                  
                  <input type="text" class="form-control pull-right" name="editarFechaNacimiento" id="editarFechaNacimiento" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                  
                </div>
                <!-- /.input group -->
              </div>
              
            
            <!-- ENTRADA PARA SELECCIONAR SU CARGO -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 

                <select class="form-control input-lg" name="editarCargo">
                  
                  <option id="editarCargo">Selecionar Cargo</option>

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
                  
                  <input type="text" class="form-control pull-right" name="editarFechaIngreso" id="editarFechaIngreso" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                  
                </div>
                <!-- /.input group -->
              </div>

           <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="editarFoto" name="editarFoto">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/empleados/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="fotoActual" id="fotoActual">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Modificar empleado</button>

        </div>

     <?php

         $editarEmpleado = new ControladorEmpleados();
         $editarEmpleado -> ctrEditarEmpleado();

        ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $borrarEmpleado = new ControladorEmpleados();
  $borrarEmpleado -> ctrBorrarEmpleado();

?> 


