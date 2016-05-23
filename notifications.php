<?php 
  session_start();
  include 'includes/configuracion.php';
  include 'includes/mixedup.php';
  if(!isset($_SESSION['correo'])){ header('Location: login.php');}
  if(isset($_POST['idloc'])){if(!empty($_POST['idloc'])){$_SESSION['idloc']=$_POST['idloc'];}}
  if(isset($_POST['idsen'])){if(!empty($_POST['idsen'])){$_SESSION['idsen']=$_POST['idsen'];}}
  if(isset($_POST['umbral'])){$guardo = saveNotification($_SESSION['idsen'],$_SESSION['correo'],$_POST['umbral']);}
  if($guardo){unset($_SESSION['idloc']);unset($_SESSION['idsen']);unset($_SESSION['action']);header('Location: notifications.php');}
  if(isset($_POST['borrar'])){$borro = deleteNotification($_POST['borrar']);}
  if($borro){unset($_SESSION['idloc']);unset($_SESSION['idsen']);unset($_SESSION['action']);header('Location: notifications.php');}
  ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Notificaciones</title>

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
    function Locacion() {
	    document.getElementById("select_idloc").submit();	
    }
    function Sensor() {
	    document.getElementById("select_idsen").submit();	
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
    function AddNotification(){
	post('notifications.php',{action: 1});
      }
    function GuardarNot(){
	sure = confirm("Está seguro de guardar esta información?");
	if(sure==true){
	valor = document.getElementById("umbral").value;
	  post('notifications.php',{umbral: valor});
	}
      }
    function DeleteNot(idnot){
	sure = confirm("Está seguro de eliminar esta notificación?");
	if(sure==true){
	  post('notifications.php',{borrar: idnot});
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
	  <li><a href="index.php"><b>Inicio</b><span class="sr-only">(current)</span></a></li>
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
	  <!-- li><button class="btn btn-danger btn-sm" onclick="Logout()" data-toggle="tooltip" title="Cerrar Sesión"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></button></li-->
	</ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
    <div class="container-fluid">
    <div class="jumbotron">
    <h1>Configuración de Notificaciones</h1>
    <p>A continuación encontrarás tu lista de notificaciones activas. Puedes eliminarlas o añadir nuevas.</p>
    <p>Al añadir una nueva recuerda clickear en "Guardar" al introducir el valor de umbral.</p>
    </div>
    <div class="row">
      <div class="col-xs-6 col-xs-offset-3">
	  <?php showNotifications($_SESSION['correo']); ?>
	  <br>
	  <?php if($_POST['action']==1){?>
	    <form id="select_idloc" method="POST" action="notifications.php">Elige Ubicación: <?php select_locations($_SESSION['correo']); ?><input type="hidden" name="action" value="1" /></form>
	    <?php if(isset($_SESSION['idloc'])){?>
		  <form id="select_idsen" method="POST" action="notifications.php">Elige Sensor: <?php select_loc_sensors($_SESSION['idloc']); ?><input type="hidden" name="action" value="1" /></form>
		  <?php if(isset($_SESSION['idsen'])){?>
		    <input id="umbral" type="number" name="umbral" min="1" max="100">
		    <button class='btn btn-info' onclick="GuardarNot()" data-toggle="tooltip" title="Guardar"><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span></button>
		  <?php }
		} 
	     } ?>
	<button class='btn btn-success' onclick="AddNotification()"><span class='glyphicon glyphicon-plus' aria-hidden='true'></span></button>
	Añadir Notificación <br>
	
      </div><!-- col-sm-6-->
    </div><!-- row-->
    </div><!--container-fluid-->
    
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