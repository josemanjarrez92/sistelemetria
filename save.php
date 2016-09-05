<?php
  if(!empty($_GET['iduser']) && !empty($_GET['idloc']) && !empty($_GET['idsens']) && !empty($_GET['valor'])){
    if(isset($_GET['iduser']) && isset($_GET['idloc']) && isset($_GET['idsens']) && isset($_GET['valor'])){
      if($_GET['iduser']==7){
	  include 'includes/configuracion.php';
	  $sentencia = "INSERT INTO registros (reg_iduser,reg_idloc,reg_idsens,reg_valor,reg_fechahora) VALUES(".$_GET['iduser'].",".$_GET['idloc'].",".$_GET['idsens'].",".$_GET['valor'].",CURRENT_TIMESTAMP)";
	  $sentencia2 = "INSERT INTO registros (reg_iduser,reg_idloc,reg_idsens,reg_valor,reg_fechahora) VALUES(".$_GET['iduser'].",".$_GET['idloc'].",".$_GET['idsens2'].",".$_GET['valor2'].",CURRENT_TIMESTAMP)";
	  mysqli_query($mysqli,"SET SESSION time_zone = '-5:00'"); 
	  $res = mysqli_query($mysqli,$sentencia);
	  $res2 = mysqli_query($mysqli,$sentencia2);
	  echo "yay";
      }
      else{
	  include 'includes/configuracion.php';
	  date_default_timezone_set('America/Bogota');
	  if($_GET['valor']=='nan'){$_GET['valor']=0;}
	  $sentencia = "INSERT INTO registros (reg_iduser,reg_idloc,reg_idsens,reg_valor,reg_fechahora) VALUES(".$_GET['iduser'].",".$_GET['idloc'].",".$_GET['idsens'].",".$_GET['valor'].",CURRENT_TIMESTAMP)";
	  mysqli_query($mysqli,"SET SESSION time_zone = '-5:00'"); 
	  $res = mysqli_query($mysqli,$sentencia);
	  $now = strftime("%H", time());
	  $target = getTarget($_GET['idsens']);
	  print_r(array_values($target));
	  if(!$target[0]){if($now==$target[1]){$flag=getflag($_GET['idsens']);if($flag==0){echo "HIGH";setflag($_GET['idsens'],1);}else{echo "Already done";}}else{setflag($_GET['idsens'],1);echo "Not same hour";}}else{echo "No target";}
	  }
    }
  }
function getTarget($idsens){
  include 'includes/configuracion.php';
  $mysqli=mysqli_connect($db_host,$db_user ,$db_password,$db_schema); 
  $sentencia="SELECT * FROM acciones WHERE acc_idsens=".$idsens."";
  //$stmt = mysqli_prepare($mysqli,$sentencia);
  //mysqli_stmt_execute($stmt);
 // mysqli_stmt_store_result($stmt);
 // mysqli_stmt_bind_result($stmt,$target);
   $target = mysqli_fetch_assoc(mysqli_query($mysqli,$sentencia));
  if(target){
  echo $sentencia.' y luego '.$target;
  $do = empty($target);
  return [$do, $target];
  }
  //mysqli_stmt_close($stmt);     
  mysqli_close($mysqli);
}
function getflag($idsens){
  include 'includes/configuracion.php';
  $mysqli=mysqli_connect($db_host,$db_user ,$db_password,$db_schema); 
  $sentencia="SELECT acc_flag FROM acciones WHERE acc_idsens=".$idsens."";
  $stmt = mysqli_prepare($mysqli,$sentencia);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  mysqli_stmt_bind_result($stmt,$flag);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);     
  mysqli_close($mysqli);
  return $flag;
}
function setflag($idsens,$valor){
  include 'includes/configuracion.php';
  $mysqli=mysqli_connect($db_host,$db_user ,$db_password,$db_schema); 
  $sentencia="UPDATE acciones SET acc_flag=".$valor." WHERE acc_idsens=".$idsens."";
  $res = mysqli_query($mysqli,$sentencia);
}
?>