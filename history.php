<?php 
  session_start();
  include 'includes/configuracion.php';
  include 'includes/mixedup.php';
  if(!isset($_SESSION['correo'])){ header('Location: login.php');}
  if(isset($_POST['out'])){session_destroy();header('Location: login.php');}
  if(isset($_POST['idloc'])){$_SESSION['idloc']=$_POST['idloc'];}
  if(isset($_POST['tiempo1'])){$_SESSION['desde']=$_POST['tiempo1'];}
  if(isset($_POST['tiempo2'])){$_SESSION['hasta']=$_POST['tiempo2'];}
  if($_POST['action']==2){unset($_SESSION['idloc']);unset($_SESSION['desde']);unset($_SESSION['hasta']);unset($_SESSION['action']);header('Location: history.php');}
  ?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Historiales</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/weather-icons.min.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
	<script type="text/javascript" src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/d004434a5ff76e7b97c8b07c01f34ca69e635d97/src/js/bootstrap-datetimepicker.js"></script>
	<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/d004434a5ff76e7b97c8b07c01f34ca69e635d97/build/css/bootstrap-datetimepicker.css" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript"
          src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }"></script>

    <script type="text/javascript">
    function Locacion() {
	    valor = document.getElementById("select_idloc").value;	
	    post('history.php',{idloc:valor});
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
    function SetTime(){
	document.getElementById("tiempos").submit();
      }
    function ShowGraph(){
	post('history.php',{action: 1});
      }
    function Nueva(){
	post('history.php',{action: 2});
      }
    </script>
    <script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();
	});
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
	  <li class="active"><a href="history.php"><b>Consultar Historiales</b><span class="sr-only">(current)</span></a></li>
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
    <h1>Consulta de Historiales</h1>
    <p>Para consultar los historiales de tus sensores, especifica el rango de fechas de consulta. Luego, elige la ubicación y clickea en "Mostrar" y ¡listo!</p>
    </div>
    <div class="row">
      <div class="col-xs-6 col-xs-offset-3">
      <button class='btn btn-success' onclick="Nueva()" data-toggle="tooltip" title="Nueva Consulta"><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Nueva Consulta</button>
	    <form method="POST" action="history.php" id="tiempos">
	    
	        <div class="row">

					<div class="form-group">
						<div class='input-group date' id='datetimepicker6' align="center">
							<input type='text' class="form-control" name="tiempo1" <?php if(isset($_SESSION['desde'])){echo 'value="'.$_SESSION['desde'].'"';} ?> />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
							</div>
					</div>

			
			
				
					<div class="form-group">
						<div class='input-group date' id='datetimepicker7' align="center">
							<input type='text' class="form-control" name="tiempo2" <?php if(isset($_SESSION['hasta'])){echo 'value="'.$_SESSION['hasta'].'"';} ?>/>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				<button class='btn btn-info' onclick="SetTime()" data-toggle="tooltip" title="Establecer Fechas"><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Establecer Fechas</button>
			</div>
			
				<script type="text/javascript">
					$(function () {
						$('#datetimepicker6').datetimepicker({format: 'YYYY-MM-DD HH:mm'});
						$('#datetimepicker7').datetimepicker({format: 'YYYY-MM-DD HH:mm'});
						$("#datetimepicker6").on("dp.change", function (e) {
							$('#datetimepicker7').data("DateTimePicker").minDate(e.date);
						});
						$("#datetimepicker7").on("dp.change", function (e) {
							$('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
						});
					});
				</script>
	    </form>
	    <?php if(isset($_SESSION['desde'])){ ?>
	    <label for="idloc">Elige Ubicación</label> 
	    <?php select_locations($_SESSION['correo']); ?>
	   <?php if(isset($_SESSION['idloc'])){ ?>
	   <?php showHistory($_SESSION['idloc'],$_SESSION['desde'],$_SESSION['hasta']); ?>
	   <button class='btn btn-success' onclick="Nueva()" data-toggle="tooltip" title="Nueva Consulta"><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Nueva Consulta</button>
	      <?php } 
	      } ?>
	      
      </div><!-- col-sm-6-->
      
    </div><!-- row-->

    </div><!--container-fluid-->
    

    
  </body>
</html>