<?php
  session_start();
  include 'includes/configuracion.php';
  include 'includes/mixedup.php';
  if(!isset($_POST['c'])){$_SESSION['c']=1;}else{$_SESSION['c']=$_POST['c'];}
  if(isset($_POST['locacion'])){$_SESSION['locacion'] = $_POST['locacion'];$_SESSION['idloc']=guardarlocacion($_SESSION['correo'],$_SESSION['locacion'],$_SESSION['c']);}
  if(isset($_POST['sensores'])){$save=guardarsensores($_SESSION['idloc'],$_SESSION['correo'],$_POST['sensores'],$_SESSION['c']);}
  if($save){header('Location: index.php');}
  if(isset($_POST['sensoresn'])){$again=guardarsensores($_SESSION['idloc'],$_SESSION['correo'],$_POST['sensores'],$_SESSION['c']);}
  if($again){unset($_SESSION['locacion']);header('Location: register_locations.php');}
  ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Escoge tus locaciones y sensores</title>
    <link href="css/weather-icons.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
    counter=<?php echo $_SESSION['c'];?>;
      function GuardarLoc(obj){
	loc = document.getElementById('locacion').value;
	obj.innerHTML = "<span class='glyphicon glyphicon-floppy-saved' aria-hidden='true'></span>";
	post('register_locations.php',{locacion: loc})
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
      function AddSensor(){
	counter++;
	post('edit_locations.php',{c: counter});
      }
      function DeleteSensor(obj){
	counter = counter -1;
	post('edit_locations.php',{c: counter});
	sens = document.getElementById(obj);
	sens.parentNode.removeChild(sens);
      }
      function Nueva(){
	sure = confirm("Está seguro de añadir una nueva ubicación?");
	if(sure==true){
	  post('register_locations2.php',{c: 1});
	  }
      }
      function Final(){
	sure = confirm("Está seguro de guardar esta información?");
	if(sure==true){
	  counter=<?php echo $_SESSION['c'];?>;
	  i=1;
	  valores = [];
	  while(i<=counter){
	    var val = document.getElementById("sensor"+i).value;
	    valores.push(val);
	    i++;
	  }
	  post('edit_locations.php',{sensores: valores});
	}
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
	  <li class="active"><a href="#"><b>Inicio</b><span class="sr-only">(current)</span></a></li>
	  <li><a href="history.php"><b>Consultar Historiales</b></a></li>
	</ul>
	<ul class="nav navbar-nav navbar-right">
	  <li class="dropdown">
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo getUserPhoto($_SESSION['correo']);?>" style="height:40px;"/>  <?php echo getUserName($_SESSION['correo']);?><span class="caret"></span></a>
	    <ul class="dropdown-menu">
	      <li><a href="profile.php"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Editar Perfil</a></li>
	      <li><a href="edit_locations.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Editar Ubicaciones/Sensores</a></li>
	      <li role="separator" class="divider"></li>
	      <li><a href="notifications.php"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span> Configurar Notificaciones</a></li>
	    </ul>
	  </li>
	  <button class="btn btn-danger btn-sm" onclick="Logout()" data-toggle="tooltip" title="Cerrar Sesión"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></button>
	</ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <div class="container-fluid">
  <div class="jumbotron">
  <h1>Edición de Lugares y Sensores</h1>
  <p>Abajo se muestran las locaciones que tienes inscritas. Si deseas cambiar algún nombre, recuerda guardar inmediatamente el nuevo nombre</p>
  <p>Para añadir sensores a una ubicación, clickea en el botón con el signo "+". Para añadir una nueva ubicación, utiliza la opción "Nueva Ubicación"</p>
  </div><!-- jumbotron -->
  <div class="row">
  <div class="col-xs-4"></div>
  <div class="col-xs-4">

   <div id="sensors">   
	<?php 
		showLocations($_SESSION['correo']);
	?>
   </div>
  <button class='btn btn-warning btn-lg btn-block' onclick="Nueva()">Nueva Ubicación</button>
  <button class='btn btn-success btn-lg btn-block' onclick="Final()">Finalizar</button>
  </div><!-- col-xs-4 -->
  </div><!-- div row -->
  
  </div> <!-- div container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();
	});
    </script>
  </body>
</html>