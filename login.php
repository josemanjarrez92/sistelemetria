<?php
  include 'includes/configuracion.php';
  if (isset($_SESSION['correo'])){session_destroy();}
  session_start();
    if(isset($_POST['accede'])){
	  $mysqli=mysqli_connect($db_host,$db_user ,$db_password,$db_schema );
	  if (mysqli_connect_errno()) {
	      printf("Connect failed: %s\n", mysqli_connect_error());
	      exit();
	  }
	  $sentencia="SELECT idusuario,nombre,apellido,foto FROM usuarios WHERE correo=? AND pass=?";
	  $stmt = mysqli_prepare($mysqli,$sentencia);
	  $correo=''.$_POST['inputEmail'];
	  $pass=''.$_POST['inputPassword'];
	  mysqli_stmt_bind_param($stmt,'ss',$correo,$pass);
	  mysqli_stmt_execute($stmt);
	  mysqli_stmt_store_result($stmt);
	  if(mysqli_stmt_num_rows($stmt)>0){
	     mysqli_stmt_bind_result($stmt,$idusuario,$nombre,$apellido,$foto);
	     mysqli_stmt_fetch($stmt);
	     $_SESSION['correo']=$correo;
	     $_SESSION['idusuario']=$idusuario;
	     $_SESSION['nombre']=$nombre;
	     $_SESSION['apellido']=$apellido;
	     $_SESSION['foto']=$foto;
	     header('Location: index.php');
	     exit();
	  }
	  else{$err=true;}
	  mysqli_stmt_close($stmt);
	  mysqli_close($mysqli);
    }
    if(isset($_POST['registra'])){
	  $mysqli=mysqli_connect($db_host,$db_user ,$db_password,$db_schema );
	  if (mysqli_connect_errno()) {
	      printf("Connect failed: %s\n", mysqli_connect_error());
	      exit();
	  }
	  $_SESSION['correo']=$_POST['correo'];
	  $correo = $_POST['correo'];
	  $_SESSION['nombre']=$_POST['nombre'];
	  $_SESSION['apellido']=$_POST['apellido'];
	  $sentencia="SELECT nombre,apellido FROM usuarios WHERE correo='".$correo."'";
	  $res = mysqli_query($mysqli,$sentencia);
	  if(mysqli_num_rows($res)>0){$err2=true;}
	  else{header('Location: register.php');exit();}
	  mysqli_close($mysqli);
    }
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
  <div class="jumbotron">
  <h1>¡Bienvenido!</h1>
  <p>Este es nuestro portal de inicio. Si ya tienes una cuenta, puedes iniciar sesión.</p>
  <p>Si aún no has adquirido nuestros servicios... ¡anímate! Regístrate y comienza a monitorear tus sensores desde nuestra plataforma web.</p>
  </div><!-- jumbotron -->
  <div class="row">
  <div class="col-xs-6"> <!-- always half of width -->
  <div class="panel panel-success">
    <div class="panel-heading"><h3 class="panel-title"><center>Iniciar Sesión</center></h3></div>
      <div class="panel-body">
      <form method="post" action="login.php">
        <?php if($err){echo '<div class="alert alert-warning" role="alert">Usuario y/o Contraseña Incorrectos</div>';} ?>
        <label for="inputEmail" class="sr-only">Correo Electrónico</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Correo electrónico" required autofocus>
        <br>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contraseña" required>
        <br>
        <button class="btn btn-primary" name="accede" type="submit">Acceder</button>
      </form>
      <br>
        <div class="form-group">
        <label for="olvide">¿Olvidaste tu contraseña?</label>
        <a href="olvido.php"><button id="olvide" type="button" class="btn btn-block btn-link">Haz click aquí para recuperarla</button></a>
        </div>
      </div>
    </div><!-- panel -->
    </div><!-- col-xs-4 -->
   <div class="col-xs-6">
    <div class="panel panel-info">
      <div class="panel-heading"><h3 class="panel-title"><center>Regístrate</center></h3></div>
      <div class="panel-body">
	<form method="post" action="login.php">
        <?php if($err2){echo '<div class="alert alert-warning" role="alert">Hola,'.$_SESSION['nombre'].' '.$_SESSION['apellido'].'. Ya tienes una cuenta creada. Inicia sesión o si olvidaste la clave, clickea en <i>Olvidé mi contraseña</i></div>';} ?>
        <div class="form-group">
	  <label for="correo">Correo</label>
	  <input type="email" class="form-control" name="correo" id="correo" placeholder="Correo electrónico" required>
	</div>
        <div class="form-group">
	  <label for="nombre">Nombre</label>
	  <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required>
	</div>
        <div class="form-group">
	  <label for="apellido">Apellido</label>
	  <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido" required>
	</div>
        <button class="btn btn-primary" type="submit" name="registra">Registrarme</button>
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