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
	post('register_locations.php',{c: counter});
      }
      function DeleteSensor(obj){
	counter = counter -1;
	post('register_locations.php',{c: counter});
	sens = document.getElementById(obj);
	sens.parentNode.removeChild(sens);
      }
      function Nueva(){
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
	  post('register_locations.php',{sensoresn: valores});
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
	  post('register_locations.php',{sensores: valores});
	}
      }
      
    </script>
  </head>
  <body>
  <div class="container-fluid">
  <div class="jumbotron">
  <h1>Falta muy poco</h1>
  <p>Ahora sólo tienes que añadir los lugares que serán monitoreados y especificar los sensores de cada locación.</p>
  <p>Primero, escribe el nombre de la ubicación y clickea en "Guardar". Luego, añade los sensores que hayas adquirido, especificando el tipo de cada uno</p>
  </div><!-- jumbotron -->
  <div class="row">
  <div class="col-xs-4"></div>
  <div class="col-xs-4">
  <b>Nombre de Ubicación</b>
  <input type="text" id="locacion" placeholder="Nombre de Ubicación" <?php if(isset($_SESSION['locacion'])){echo 'value = "'.$_SESSION["locacion"].'" disabled';}?>>
  <button class='btn btn-info' onclick="GuardarLoc(this)" data-toggle="tooltip" title="Guardar"><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span></button>
  <br>
  <button class='btn btn-success' onclick="AddSensor()"><span class='glyphicon glyphicon-plus' aria-hidden='true'></span></button>
    Añadir Nuevo Sensor
   <div id="sensors">   
	<?php 
		generar_selects($_SESSION['c']);
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