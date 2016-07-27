<?php session_start();
  include 'includes/configuracion.php';
  include 'includes/mixedup.php';
  if(!isset($_SESSION['correo'])){ header('Location: login.php');}
  if(isset($_POST['out'])){session_destroy();header('Location: login.php');}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="30">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Inicio - SisTelemetria</title>

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
	  <li class="active"><a href="#"><b>Inicio</b><span class="sr-only">(current)</span></a></li>
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
    <center><h1>Bienvenido(a), <?php echo getUserName($_SESSION['correo']);?></h1></center>
    <h4>A continuación encontrarás la lista de las ubicaciones que has inscrito.
    Dándole click a cada nombre aparecerá la información más reciente de sus respectivos sensores.
    Recuerda que en la barra superior puedes consultar los historiales de tus sensores,
    añadir ubicaciones y/o sensores, o configurar las notificaciones por correo</h4>
    </div>
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	  <?php showUserLocations($_SESSION['correo']); ?>
	</div><!-- accordion-->
      </div><!-- col-sm-6-->
    </div><!-- row-->
    </div><!--container-fluid-->
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>