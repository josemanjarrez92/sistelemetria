<?php
  include 'includes/configuracion.php';
  if (isset($_SESSION['correo'])){session_destroy();}
  session_start();
    if(isset($_POST['enviar'])){
	  $mysqli=mysqli_connect($db_host,$db_user ,$db_password,$db_schema );
	  if (mysqli_connect_errno()) {
	      printf("Connect failed: %s\n", mysqli_connect_error());
	      exit();
	  }
	  $correo=''.$_POST['inputEmail'];
	  $sentencia="SELECT nombre, apellido,pass FROM usuarios WHERE correo='".$correo."'";
	  $stmt = mysqli_prepare($mysqli,$sentencia);
	  if(mysqli_query($mysqli,$sentencia)){
	  mysqli_stmt_execute($stmt);
	  mysqli_stmt_store_result($stmt);
	  mysqli_bind_result($stmt,$nombre,$apellido,$pass);
	  mysqli_stmt_fetch($stmt);
	  $suc = true;
	  // $mensaje = "Hola, ".$nombre." ".$apellido.".\r\n\n Has solicitado un recordatorio de contraseña.\r\n Tu contraseña es : ".$pass." \r\n Ahora ya puedes entrar a nuestro portal. Gracias por usar nuestros servicios \n";
	  //mail($correo,"Recuperación de contraseña",$mensaje);
	  mysqli_stmt_close($stmt);
	  }
	  else{$err=true;}
	  
	  mysqli_close($mysqli);
    }
    if(isset($_POST['volver'])){header('Location: login.php');}
  ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bienvenido a SisTelemetria</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <div class="container-fluid">
  <div class="row">
  <div class="col-xs-4 col-xs-offset-3">
  <div class="panel panel-warning">
    <div class="panel-heading"><h3 class="panel-title"><center>Recuperar Contraseña</center></h3></div>
      <div class="panel-body">
         <form method="post" action="olvido.php">
        <?php if($err){echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Correo electrónico no existente</div>';} ?>
        <div class="form-group">
        <label for="inputEmail">Correo Electrónico</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Correo electrónico" required autofocus>
        </div>
        <br>
        <button class="btn btn-primary" name="enviar" type="submit">Enviar</button>
        <br>
        <br>
         <?php if($suc){echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>Se ha enviado un mensaje a tu correo con la contraseña</div>';} ?>
        <br>
        <br>
        </form>
        <form method="post" action="olvido.php">
         <button class="btn btn-lg btn-warning btn-block" name="volver" type="submit">Regresar a Inicio</button>
      </form>
      </div>
    </div><!-- panel -->
    </div><!-- col-xs-4 -->
  </div><!-- div container -->
  </div> <!-- div row -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>