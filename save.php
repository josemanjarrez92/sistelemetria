<?php
  if(!empty($_GET['iduser']) && !empty($_GET['idloc']) && !empty($_GET['idsens']) && !empty($_GET['valor'])){
    if(isset($_GET['iduser']) && isset($_GET['idloc']) && isset($_GET['idsens']) && isset($_GET['valor'])){
	include 'includes/configuracion.php';
	$sentencia = "INSERT INTO registros (reg_iduser,reg_idloc,reg_idsens,reg_valor,reg_fechahora) VALUES(".$_GET['iduser'].",".$_GET['idloc'].",".$_GET['idsens'].",".$_GET['valor'].",CURRENT_TIMESTAMP)";
	mysqli_query($mysqli,"SET SESSION time_zone = '-5:00'"); 
	$res = mysqli_query($mysqli,$sentencia);
	echo "yay";
    }
  }
?>