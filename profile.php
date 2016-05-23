<?php 
  session_start();
  include 'includes/configuracion.php';
  include 'includes/mixedup.php';
  if(!isset($_SESSION['correo'])){ header('Location: login.php');}
  if(isset($_POST['out'])){session_destroy();header('Location: login.php');}
  if(isset($_POST['subida'])){$uploadfile = '_photos/'.basename($_FILES['userfile']['name']);$subio = move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);}
  if($subio){$foto = basename($_FILES['userfile']['name']); $fotoflag=UpdatePhoto($foto,$_SESSION['correo']);}else{echo $_FILES['userfile']['error'];}
  ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Perfil</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/weather-icons.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
      var fotoflag = <?php echo $fotoflag; ?>
      if(fotoflag){
	alert("La subida ha sido exitosa.");
      }
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


    function post(path, parameters) {
        var form = $('<form></form>');

        form.attr("method", "post");
        form.attr("action", path);

        $.each(parameters, function(key, value) {
            if ( typeof value == 'object' || typeof value == 'array' ){
                $.each(value, function(subkey, subvalue) {
                    var field = $('<input />');
                    field.attr("type", "hidden");
                    field.attr("name", key+'[]');
                    field.attr("value", subvalue);
                    form.append(field);
                });
            } else {
                var field = $('<input />');
                field.attr("type", "hidden");
                field.attr("name", key);
                field.attr("value", value);
                form.append(field);
            }
        });
        $(document.body).append(form);
        form.submit();
    }
    function Logout(){
      post('index.php',{out:0});
    }
    </script>
  </head>
  <body>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	  <span class="sr-only">Menú</span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	</button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav">
	  <li><a href="index.php"><b>Inicio</b></a></li>
	  <li><a href="history.php"><b>Consultar Historiales</b></a></li>
	</ul>
	<ul class="nav navbar-nav navbar-right">
	  <li class="dropdown">
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo getUserPhoto($_SESSION['correo']);?>" style="height:40px;"/>  <?php echo getUserName($_SESSION['correo']);?><span class="caret"></span></a>
	    <ul class="dropdown-menu">
	      <li><a href="profile.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Editar Perfil</a></li>
	      <li role="separator" class="divider"></li>
	      <li><a href="notifications.php"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span> Configurar Notificaciones</a></li>
	      <li role="separator" class="divider"></li>
	      <li><a href="#" onclick="Logout()"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Cerrar Sesión</a></li>
	    </ul>
	  </li>
	  
	</ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
    <div class="container-fluid">
  <div class="jumbotron">
  <h1>Edición de Perfil</h1>
  <p>Realiza los cambios que consideres necesarios en tu perfil y luego clickea en "Guardar".</p>
  </div><!-- jumbotron -->
    <div class="row">
      
      <div class="col-xs-6 col-xs-offset-3">
      <form action="profile.php" method="POST" onsubmit="return checkForm(this);">
      <div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $_SESSION['nombre'];?>" required>
    
    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $_SESSION['apellido'];?>" required>
    
    <label for="inputEmail" >Correo Electrónico</label>
    <input type="email" id="inputEmail" name="inputEmail" class="form-control" value="<?php echo $_SESSION['correo'];?>" required>
    </div>    
    <br>
    <button class="btn btn-lg btn-info btn-block" name="Guardar" type="submit">Continuar</button>
    </form>
    <br><br><br>
    <form enctype="multipart/form-data" action="profile.php" method="POST">
    <div class="form-group">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
    <!-- Name of input element determines name in $_FILES array -->
    <label for="userfile" >Subir foto</label>:
    <input id="userfile" name="userfile" type="file"/><br>
    <input type="submit" name="subida" class="btn btn-warning" value="Subir" />
     <p class="help-block">Tamaño máximo del archivo de 2MB.</p>
    </div>
    <div class="thumbnail">
    <img src="<?php echo getUserPhoto($_SESSION['correo']);?>" />
    </div>
    </form>
 
      </div><!-- col-sm-6-->
  
    </div><!-- row-->
    </div><!--container-fluid-->
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>