<?php
  include 'includes/configuracion.php';
  session_start();
    if(isset($_POST['continuar'])){
	  if (mysqli_connect_errno()) {
	      printf("Connect failed: %s\n", mysqli_connect_error());
	      exit();
	  }
	  $pass=''.$_POST['pwd1'];
	  $sentencia="INSERT INTO usuarios (nombre,apellido,correo,pass) VALUES('".$_SESSION['nombre']."','".$_SESSION['apellido']."','".$_SESSION['correo']."','".$pass."')";
	  $res = mysqli_query($mysqli, $sentencia);
	  if (!$res) {
	    printf("Error: %s\n", mysqli_error($mysqli));
	  }
	  else{header('Location: index.php');exit();}
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
    <script type="text/javascript">

  function checkForm(form)
  {
    re = /^\w+$/;
    if(!re.test(form.nombre.value) && !re.test(form.apellido.value)) {
      alert("Error: Nombre y Apellido solo puede contener letras!");
      form.nombre.focus();
      return false;
    }

    if(form.pwd1.value != "" && form.pwd1.value == form.pwd2.value) {
      if(form.pwd1.value.length < 6) {
        alert("Error: La contrasena debe tener al menos 6 caracteres!");
        form.pwd1.focus();
        return false;
      }
      if((form.pwd1.value == form.nombre.value) || (form.pwd1.value == form.apellido.value)) {
        alert("Error: Contrasena debe ser diferente de nombre o apellido!");
        form.pwd1.focus();
        return false;
      }
    } else {
      alert("Error: Por favor, verifique que ha tecleado una contrasena!");
      form.pwd1.focus();
      return false;
    }

 //   alert("You entered a valid password: " + form.pwd1.value);
    return true;
  }

</script>
  </head>
  <body>
  <div class="container-fluid">
  <div class="jumbotron">
  <h1>¡Gracias por elegirnos!</h1>
  <p>A continuación elige una contraseña para poder seguir con el registro.</p>
  </div><!-- jumbotron -->
  <div class="row">
  <div class="col-xs-8 col-xs-offset-2"> 
   <form method="post" action="register.php" onsubmit="return checkForm(this);">
    <?php if($err){echo '<div class="alert alert-warning" role="alert">Usuario y/o Contraseña Incorrectos</div>';} ?>
    <div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $_SESSION['nombre'];?>" required>
    
    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $_SESSION['apellido'];?>" required>
    
    <label for="inputEmail" >Correo Electrónico</label>
    <input type="email" id="inputEmail" name="inputEmail" class="form-control" value="<?php echo $_SESSION['correo'];?>" required>
    </div>
    <br>
    <div class="form-group">
    <label for="pwd1">Contraseña</label>
    <input type="password" id="pwd1" name="pwd1" class="form-control" placeholder="Contraseña" required autofocus>
    <p class="help-block">Debe tener al menos 6 caracteres.</p>
    <label for="pwd2">Repetir Contraseña</label>
    <input type="password" id="pwd2" name="pwd2" class="form-control" placeholder="Repetir Contraseña" required>
    </div>
    <button class="btn btn-lg btn-success btn-block" name="continuar" type="submit">Finalizar</button>
   </form>
    </div><!-- col-xs-4 -->
  </div><!-- div row -->
  
  </div> <!-- div container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>