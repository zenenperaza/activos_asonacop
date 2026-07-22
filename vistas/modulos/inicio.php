<!-- Google Font 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3> <?php
                  $item = null;
                  $valor = null;
                  $orden = "id";

                  $activos = ControladorActivos::ctrMostrarActivos($item, $valor, $orden);
                  echo count($activos);
?></h3>

              <p>Activos</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="activos" class="small-box-footer">Ir a activos  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3> <?php
                  $item = null;
                  $valor = null;

                  $activos = ControladorEmpleados::ctrMostrarEmpleados($item, $valor);
                  echo count($activos);
?><sup style="font-size: 20px"></sup></h3>

              <p>Empleados</p>
            </div>
            <div class="icon">
               <i class="ion ion-person-add"></i>
            </div>
            <a href="empleados" class="small-box-footer">Ir a empleados  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3> <?php
                  $item = null;
                  $valor = null;

                  $activos = ControladorAsignaciones::ctrMostrarAsignaciones($item, $valor);
                  echo count($activos);
?></h3>

              <p>Asignaciones</p>
            </div>
            <div class="icon">
               <i class="ion ion-stats-bars"></i>
            </div>
            <a href="asignaciones" class="small-box-footer">Ir a asignaciones  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3> <?php
                  $item = null;
                  $valor = null;

                  $activos = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                  echo count($activos);
?></h3>

              <p>Usuarios</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="usuarios" class="small-box-footer">Ir a usuarios  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3> <?php
           		$item = null;
    	$valor = null;
    	$orden = "id";

  		$participantes = ControladorParticipantes::ctrMostrarParticipantes($item, $valor, $orden);	
                  echo count($participantes);
?></h3>

              <p>Participantes - Talleres</p>
            </div>
            <div class="icon">
               <i class="ion ion-pie-graph"></i>
            </div>
            <a href="participantes" class="small-box-footer">Ir a Participantes - Talleres <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /.row -->
      <!-- Ubicaciones: cuadros por ubicacion_fisica -->
      <div class="row">
        <?php
          $ubicaciones = ControladorActivos::ctrContarPorUbicacion();
          if($ubicaciones){
            foreach($ubicaciones as $u){
              $nombre = htmlspecialchars($u["ubicacion_fisica"]);
              $total = (int)$u["total"];
              echo "<div class='col-lg-2 col-md-3 col-sm-4 col-xs-6'>";
              echo "  <div class='small-box bg-gray' style='background:#f4f4f4;color:#333;'>";
              echo "    <div class='inner'>";
              echo "      <h3>$total</h3>";
              echo "      <p>$nombre</p>";
              echo "    </div>";
              echo "    <div class='icon'><i class='fa fa-map-marker'></i></div>";
              echo "  </div>";
              echo "</div>";
            }
          }
        ?>
      </div>
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
      
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- Map box -->
          <div class="box box-solid bg-light-blue-gradient">
            <div class="box-header">
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip"
                        title="Date range">
                  <i class="fa fa-calendar"></i></button>
                <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                        data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                  <i class="fa fa-minus"></i></button>
              </div>
              <!-- /. tools -->

              <i class="fa fa-map-marker"></i>

              <h3 class="box-title">
                Últimos ingresos
              </h3>
            </div>
            <div class="box-body">
              <div id="world-map" style="height: 250px; width: 100%;"></div>
            </div>
            <!-- /.box-body-->
            <div class="box-footer no-border">
              <div class="row">
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <div id="sparkline-1"></div>
                  <div class="knob-label">Visitas</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <div id="sparkline-2"></div>
                  <div class="knob-label">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center">
                  <div id="sparkline-3"></div>
                  <div class="knob-label">Exists</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.box -->
          
           <!-- Chat box -->
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-comments-o"></i>

              <h3 class="box-title">Chat</h3>

              <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                <div class="btn-group" data-toggle="btn-toggle">
                  <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
                </div>
              </div>
            </div>
            <div class="box-body chat" id="chat-box">
              <!-- chat item -->
              <div class="item">
     

                
              </div>
              <!-- /.item -->
            </div>
            <!-- /.chat -->
            <div class="box-footer">
              <div class="input-group">
                <input class="form-control" placeholder="Type message...">

                <div class="input-group-btn">
                  <button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box (chat box) -->
    <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Email rapido</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="#" method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" placeholder="Titulo">
                </div>
                <div>
                  <textarea class="textarea" placeholder="Mensaje"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              </form>
            </div>
            <div class="box-footer clearfix">
              <button type="button" class="pull-right btn btn-default" id="sendEmail">Enviar
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>     

 </div>   </div>  