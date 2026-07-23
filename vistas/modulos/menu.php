<aside class="main-sidebar">

	 <section class="sidebar">
	 

		<ul class="sidebar-menu">

			<li class="active">

				<a href="inicio">

					<i class="fa fa-home"></i>
					<span>Inicio</span>

				</a>

			</li>

		<?php

		 if($_SESSION["perfil"] == "Administrador"  || $_SESSION["perfil"] == "Usuario" ){

			echo '<li>

				<a href="activos">

					<i class="fa fa-product-hunt"></i>
					<span>Activos</span>

				</a>

			</li> 
            ';
            } else {
            echo '<li>

				<a href="#"  data-toggle="modal" data-target="#sinAcceso">

					<i class="fa fa-product-hunt"></i>
					<span>Activos</span>

				</a>

			</li> ';
        }

		if($_SESSION["perfil"] == "Administrador"  || $_SESSION["perfil"] == "Usuario"){

			echo '

			<li>

				<a href="categorias">

					<i class="fa fa-th"></i>
					<span>Categorías</span>

				</a>

			</li>
			<li>

				<a href="proveedores">

					<i class="fa fa-th"></i>
					<span>Proveedores</span>

				</a>

			</li>';
            } else {
            echo '    


			<li>

				<a href="#" data-toggle="modal" data-target="#sinAcceso">

					<i class="fa fa-th"></i>
					<span>Categorías</span>

				</a>

			</li>';
        }
			if($_SESSION["perfil"] == "Administrador"  || $_SESSION["perfil"] == "Usuario" ){

			echo '<li>

				<a href="empleados">

					<i class="fa fa-users"></i>
					<span>Empleados</span>

				</a>

			</li>
            ';
            } else {
            echo '<li>

				<a href="#"  data-toggle="modal" data-target="#sinAcceso">

					<i class="fa fa-users"></i>
					<span>Empleados</span>

				</a>

			</li>';
        }
           
           if($_SESSION["perfil"] == "Administrador"  || $_SESSION["perfil"] == "Usuario" ){

			echo '<li class="treeview">

				<a href="#">

					<i class="fa fa-list-ul"></i>
					
					<span>Asignaciones</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>
				

				<ul class="treeview-menu">
					
					<li>

						<a href="asignaciones">
							
							<i class="fa fa-circle-o"></i>
							<span>Administrar Asignaciones</span>

						</a>

					</li>

					<li>

						<a href="crear-asignacion">
							
							<i class="fa fa-circle-o"></i>
							<span>Crear Asignacion</span>

						</a>

					</li>

					<li>

						<a href="reportes">
							
							<i class="fa fa-circle-o"></i>
							<span>Reporte de Asignaciones</span>

						</a>

					</li>

				</ul>

			</li> ';
            } else {
            echo '
			<li class="treeview">

				<a href="#">

					<i class="fa fa-list-ul"></i>
					
					<span>Asignaciones</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>
				

				<ul class="treeview-menu">
					
					<li>

						<a href="#"  data-toggle="modal" data-target="#sinAcceso">
							
							<i class="fa fa-circle-o"></i>
							<span>Administrar Asignaciones</span>

						</a>

					</li>

					<li>

						<a href="#"  data-toggle="modal" data-target="#sinAcceso">
							
							<i class="fa fa-circle-o"></i>
							<span>Crear Asignacion</span>

						</a>

					</li>

					<li>

						<a href="#"  data-toggle="modal" data-target="#sinAcceso">
							
							<i class="fa fa-circle-o"></i>
							<span>Reporte de Asignaciones</span>

						</a>

					</li>

				</ul>

			</li> ';
        }
             if($_SESSION["perfil"] == "Administrador"){

			echo '
				<li>

				<a href="usuarios">

					<i class="fa fa-user"></i>
					<span>Usuarios</span>

				</a>

			</li> ';
            } else {
            echo '
            <li>

				<a href="#"  data-toggle="modal" data-target="#sinAcceso">

					<i class="fa fa-user"></i>
					<span>Usuarios</span>

				</a>

			</li> ';
        }
        if($_SESSION["perfil"] == "Administrador"){
          
          echo '
				<li>

				<a href="auditorias">

					<i class="fa fa-list-ol" aria-hidden="true"></i>
					<span>Auditorias</span>

				</a>

			</li> ';
          
          
          
          
        }
      ###################### PARTICIPANTES ########################
//        if($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Administrador"){

// 			echo '
// 				<li>

// 				<a href="participantes">

// 					<i class="fa fa-user"></i>
// 					<span>Talleres - participantes</span>

// 				</a>

// 			</li> ';
//             } else {
//             echo '
//             <li>

// 				<a href="#"  data-toggle="modal" data-target="#sinAcceso">

// 					<i class="fa fa-user"></i>
// 					<span>Talleres - participantes</span>

// 				</a>

// 			</li> ';
//         }
      ?>         

		</ul>

	 </section>

</aside>

<div id="sinAcceso" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-danger" style="background:red; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Sin acceso</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">
          
          DISCULPE! SU NIVEL DE ACCESO NO LE PERMITE ENTRAR A ESTE MÓDULO

          
            </div>

          </div>


        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

   
        </div>

   </div>      

 </div>
 
</div>
