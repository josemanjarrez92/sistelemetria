<?php
//echo "welcome";
  if(!empty($_GET['x']) && !empty($_GET['y']) && !empty($_GET['z'])){
  echo "primer if";
    if(isset($_GET['x']) && isset($_GET['y']) && isset($_GET['z'])){
    echo "segundo if";
	  include 'includes/configuracion_har.php';
	  date_default_timezone_set('America/Bogota');
	  $sentencia = "INSERT INTO acelerometro (x,y,z,t) VALUES(".$_GET['x'].",".$_GET['y'].",".$_GET['z'].",CURRENT_TIMESTAMP)";
	  mysqli_query($mysqli,"SET SESSION time_zone = '-5:00'"); 
	  $res = mysqli_query($mysqli,$sentencia);
	  if($res){echo "llego";}
	  }
    }
?>