
<div id="back"></div>

<div class="login-box">
  
  <div class="login-logo">

    <a href="/index.php"><img src="vistas/img/plantilla/favicon.png" class="img-responsive" style="padding:0px;margin:auto;width:90px"></a> 

  </div>

  <div class="login-box-body">

    <p class="login-box-msg">Ingresar al sistema</p>

    <form method="post">

      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="ingUsuario" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">

        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      
      </div>

      <div class="row">
       
        <div class="col-xs-4">

          <button type="submit" class="btn btn-primary btn-block ">Ingresar</button>
        
        </div>

      </div>

   <?php

        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuario();
        
      ?>

    </form>

  </div>

</div>
