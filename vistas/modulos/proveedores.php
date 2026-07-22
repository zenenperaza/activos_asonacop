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
      $accion = "Ingresó a Proveedores... ";         
      $crearAuditoria = ControladorAuditorias::ctrIngresarAuditorias($usuario, $accion);
      /*=============================================
      AUDITORIA FIN
      =============================================*/ 

?>
  <div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar proveedores
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar proveedores</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProveedor">
          
          Agregar proveedor

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre</th>
           <th>Direccion</th>
           <th>RIF</th>
           <th>Contacto</th>
           <th>% Retencion</th>
           <th>Codigo retencion</th>
           <th>Tipo persona</th>
           <th>Telefono 1</th>
           <th>Telefono 2</th>
           <th>Fecha registro</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>
         
         <?php

        $item = null;
        $valor = null;

        $proveedores = ControladorProveedores::ctrMostrarProveedores($item, $valor);

       foreach ($proveedores as $key => $value){
         
         ?>
         <tr>
                  
         <td style="width:10px">#</td>
           <td><?php echo $value['nombre']?></td>
           <td><?php echo $value['direccion']?></td>
           <td><?php echo $value['rif']?></td>
           <td><?php echo $value['contacto']?></td>
           <td><?php echo $value['porcentaje_retencion']?></td>
           <td><?php echo $value['codigo_retencion']?></td>
           <td><?php echo $value['tipo_persona']?></td>
           <td><?php echo $value['telefono1']?></td>
           <td><?php echo $value['telefono2']?></td>
           <td><?php echo $value['fecha_creacion']?></td>
           <td>      <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarProveedor" idProveedor="<?php echo $value['id_proveedor']?>" data-toggle="modal" data-target="#modalEditarProveedor"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger btnEliminarProveedor" idProveedor="<?php echo $value['id_proveedor']?>"><i class="fa fa-times"></i></button>

                    </div> 
          </td>
          </tr>

          <?php
        }


        ?>           
         
        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR USUARIO
======================================-->

<div id="modalAgregarProveedor" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data" autocomplete="off">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar proveedor</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
     
            
            
             <div class="form-group">
               
              <label for="nombre" class="form-label">Nombre</label>
               
              <input type="text" class="form-control input-lg" name="nombre"  id="nombre" placeholder="Ingresar nombre" style="text-transform:uppercase" pattern="[a-zA-Z ]{3,25}" maxlength="70" title="Solo letras y espacios en blanco" onkeypress="return check(event)"  oninput="actualizarNombre()"  required  autocomplete="off-usu">
               
<!--               <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
               
            </div>
            
             <div class="form-group">
               
              <label for="direccion" class="form-label">Direccion</label>
               
              <textarea class="form-control" id="direccion"  name="direccion" rows="3"></textarea>
               
            </div>
            
             <div class="form-group">
               
              <label for="rif" class="form-label">RIF</label>
               
              <input type="text" class="form-control input-lg" name="rif" placeholder="Ingresar rif"  style="text-transform:uppercase"  title="Escriba el RIF valido. Primer caracter es una letra(VEJPG), seguido de 9 numeros. Ejemplo J123456789"  pattern="([VEJPGvejpg]{1})([0-9]{9}$)" required  autocomplete="off-usu">            
                <div id="emailHelp" class="form-text">Ejemplo J123456789</div> 
               
            </div>
            
             <div class="form-group">
               
              <label for="contacto" class="form-label">Nombre de contacto</label>
               
              <input type="text" class="form-control input-lg" name="contacto" id="contacto" style="text-transform:uppercase" placeholder="Ingresar contacto" pattern="[a-zA-Z ]{3,25}"  autocomplete="off-usu">
               
            </div>
            
             <div class="form-group">
               
              <label for="porcentaje_retencion" class="form-label">% Retencion</label>
               
              <input type="text" class="form-control input-lg" name="porcentaje_retencion" placeholder="Ingresar porcentaje de retencion"  autocomplete="off-usu">
               
            </div>
            
            <div class="form-group ">

              <label for="codigo_retencion">Codigo Retencion</label>

              <select id="codigo_retencion" name="codigo_retencion" class="form-control">

                <option selected value="">SELECCIONAR</option>

                <option value="CONTRATADO">CONTRATADO</option>

                <option value="PUBLICO">PUBLICO</option>

              </select>

            </div>
            
            <div class="form-group ">

              <label for="tipo_persona">Tipo de Persona</label>

              <select id="tipo_persona" name="tipo_persona" class="form-control">

                <option value="" selected>SELECCIONAR</option>

                <option value="NATURAL">NATURAL</option>

                <option value="JURIDICO">JURIDICO</option>

              </select>

            </div>
            
             <div class="form-group">
               
              <label for="telefono" class="form-label">Telefono 1</label>
               
              <input type="text" class="form-control input-lg" name="telefono" placeholder="Ingresar telefono"  autocomplete="off-usu"  data-inputmask='"mask": "(9999) 999-9999"'  data-mask>
               
            </div>
            
             <div class="form-group">
               
              <label for="telefono2" class="form-label">Telefono 2</label>
               
              <input type="text" class="form-control input-lg" name="telefono2" placeholder="Ingresar 2do telefono"  autocomplete="off-usu"  data-inputmask='"mask": "(9999) 999-9999"'  data-mask>
               
            </div>
            
            <div class="form-group">
              
            <label for="email">Email </label>
              
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">              
              
          </div>
            
   


          </div>
          
                  <?php

          $crearProveedor = new ControladorProveedores();
          $crearProveedor -> ctrCrearProveedor();

        ?>

        </div>
 <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar proveedor</button>

        </div>



      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR USUARIO
======================================-->

<div id="modalEditarProveedor" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data" autocomplete="off">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar proveedor</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

      
          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
             <div class="form-group">
               
              <label for="nombreEditar" class="form-label">Nombre</label>
               
              <input type="text" value="" class="form-control input-lg" name="nombreEditar" id="nombreEditar" style="text-transform:uppercase" pattern="[a-zA-Z ]{3,25}" maxlength="70" title="Solo letras y espacios en blanco" onkeypress="return check(event)"  oninput="actualizarNombre()"  required  autocomplete="off-usu">
               
<!--               <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
               
            </div>
            
             <div class="form-group">
               
              <label for="direccionEditar" class="form-label">Direccion</label>
               
              <textarea class="form-control" id="direccionEditar"  name="direccionEditar" rows="3"></textarea>
               
            </div>
            
             <div class="form-group">
               
              <label for="rifEditar" class="form-label">RIF</label>
               
              <input type="text" class="form-control input-lg" name="rifEditar" value="" id="rifEditar" style="text-transform:uppercase"  title="Escriba el RIF valido. Primer caracter es una letra(VEJPG), seguido de 9 numeros. Ejemplo J123456789"  pattern="([VEJPGvejpg]{1})([0-9]{9}$)" required  autocomplete="off-usu">            
                <div id="emailHelp" class="form-text">Ejemplo J123456789</div> 
               
            </div>
            
             <div class="form-group">
               
              <label for="contactoEditar" class="form-label">Nombre de contacto</label>
               
              <input type="text" class="form-control input-lg" name="contactoEditar" value="" id="contactoEditar" style="text-transform:uppercase"  pattern="[a-zA-Z ]{3,25}"  autocomplete="off-usu">
               
            </div>
            
             <div class="form-group">
               
              <label for="porcentaje_retencion_editar" class="form-label">% Retencion</label>
               
              <input type="text" class="form-control input-lg" value="" name="porcentaje_retencion_editar" id="porcentaje_retencion_editar" autocomplete="off-usu">
               
            </div>
            
            <div class="form-group ">

              <label for="codigo_retencion_editar">Codigo Retencion</label>

              <select name="codigo_retencion_editar" class="form-control">

                <option id="codigo_retencion_editar" value=""></option>

                <option value="CONTRATADO">CONTRATADO</option>

                <option value="PUBLICO">PUBLICO</option>

              </select>

            </div>
            
            <div class="form-group ">

              <label for="tipo_persona_editar">Tipo de Persona</label>

              <select name="tipo_persona_editar" class="form-control">

                <option id="tipo_persona_editar" ></option>

                <option value="NATURAL">NATURAL</option>

                <option value="JURIDICO">JURIDICO</option>

              </select>

            </div>
            
             <div class="form-group">
               
              <label for="telefonoEditar" class="form-label">Telefono 1</label>
               
              <input type="text" class="form-control input-lg" name="telefonoEditar" id="telefonoEditar" value=""  autocomplete="off-usu"  data-inputmask='"mask": "(9999) 999-9999"'  data-mask>
               
            </div>
            
             <div class="form-group">
               
              <label for="telefonoEditar2" class="form-label">Telefono 2</label>
               
              <input type="text" class="form-control input-lg" name="telefonoEditar2" id="telefonoEditar2"  autocomplete="off-usu"  data-inputmask='"mask": "(9999) 999-9999"'  data-mask>
               
            </div>
            
            <div class="form-group">
              
            <label for="emailEditar">Email </label>
              
            <input type="email" class="form-control" id="emailEditar" value="" name="emailEditar" aria-describedby="emailHelp">              
              
          </div>

          </div>
          
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <input type="hidden" name="idProveedor" id="idProveedor" value="">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary" name="btnEditarProveedor">Modificar proveedor</button>

        </div>

     <?php

         $editarProveedor = new ControladorProveedores();
         $editarProveedor -> ctrEditarProveedor();

        ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $borrarProveedor = new ControladorProveedores();
  $borrarProveedor -> ctrBorrarProveedor();

?> 


<script src="vistas/js/proveedores.js"></script>
