<?php
function select_sensor($num_sensor){
	include 'includes/configuracion.php';
	$sentencia="SELECT idtipo, tipo_nombre FROM tipos";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num=mysqli_stmt_num_rows ($stmt);
	if($num>0){
	  mysqli_stmt_bind_result($stmt,$idtipo, $nombre_tipo);
	 ?>
	 <div class="form-group" id="sensores<?php echo $num_sensor;?>">
	 <b>Sensor No. <?php echo $num_sensor;?></b>
	 <select name="sensor<?php echo $num_sensor;?>" id="sensor<?php echo $num_sensor;?>">
	 <?php		 while(mysqli_stmt_fetch($stmt)){		 ?>
		 <option value=<?php echo $idtipo; ?>><?php echo $nombre_tipo; ?></option>
		 <?php
		 }
	?>
	 </select>
	 <button class='btn btn-danger' onclick="DeleteSensor('sensores<?php echo $num_sensor; ?>')" data-toggle="tooltip" title="Eliminar Sensor"><span class='glyphicon glyphicon-minus' aria-hidden='true'></span></button>
	 </div>
	 <?php
	 }
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);
  }
  function iconos($idtipo){
	include 'includes/configuracion.php';
	$sentencia="SELECT tipo_icono FROM tipos WHERE idtipo=".$idtipo."";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num=mysqli_stmt_num_rows ($stmt);
	if($num>0){
	  mysqli_stmt_bind_result($stmt,$icono);
	  mysqli_stmt_fetch($stmt);
	 ?>
	 <i class="wi <?php echo $icono; ?>"></i>
	 <?php
	 }
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);
  }
 function generar_selects($cont_sensor){
	$i=1;
	 while($i<=$cont_sensor){?>
	    <?php select_sensor($i); ?>
	    <?php
	    $i++;
	 }
  }
  function getId($correo){
	include 'includes/configuracion.php';
	$sentencia="SELECT idusuario FROM usuarios WHERE correo='".$correo."'";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	mysqli_stmt_bind_result($stmt,$idusuario);
	mysqli_stmt_fetch($stmt);
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);
	return $idusuario;
  }
  function guardarlocacion($correo,$locacion,$numsens){
  include 'includes/configuracion.php';
	$idusuario = getId($correo);
	$sentencia="INSERT INTO locaciones (loc_idusuario,loc_numsens,loc_nombre) VALUES(".$idusuario.",".$numsens.",'".$locacion."')";
	$res = mysqli_query($mysqli,$sentencia);
	$idloc = 0;
	if($res){
	  $dameelid = "SELECT idloc from locaciones ORDER BY idloc DESC LIMIT 1";
	  $stmt = mysqli_prepare($mysqli,$dameelid);
	  mysqli_stmt_execute($stmt);
	  mysqli_stmt_store_result($stmt);
	  mysqli_stmt_bind_result($stmt,$idloc);
	  mysqli_stmt_fetch($stmt);
	  mysqli_stmt_close($stmt);
	}
	else{printf("Error: %s\n", mysqli_error($mysqli));}
	mysqli_close($mysqli);
	return $idloc;
  }
  function guardarsensores($locacion,$correo,$sensores){
  include 'includes/configuracion.php';
	$idusuario = getId($correo);
	$counter = count($sensores);
	$actualiza="UPDATE locaciones SET loc_numsens=".$counter." WHERE idloc=".$locacion."";
	mysqli_query($mysqli,$actualiza);
	for ($j=0; $j<=$counter; $j++){
	  $sentencia="INSERT INTO sensores (sens_idloc,sens_idusuario,sens_idtipo) VALUES(".$locacion.",".$idusuario.",".$sensores[$j].")";
	  mysqli_query($mysqli,$sentencia);
	}
	mysqli_close($mysqli);
	return true;
  }
  function getUserPhoto($correo){
  	include 'includes/configuracion.php';
	$sentencia="SELECT foto FROM usuarios WHERE correo='".$correo."'";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	mysqli_stmt_bind_result($stmt,$foto);
	mysqli_stmt_fetch($stmt);
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);
	$uploaddir = '_photos/';
	$uploadedfile = $uploaddir.$foto;
	return $uploadedfile;
  }
  function getUserName($correo){
    	include 'includes/configuracion.php';
	$sentencia="SELECT nombre,apellido FROM usuarios WHERE correo='".$correo."'";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	mysqli_stmt_bind_result($stmt,$nombre,$apellido);
	mysqli_stmt_fetch($stmt);
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);
	$fullname = $nombre.' '.$apellido;
	return $fullname;
  }
  function getLocations($idusuario){
    	include 'includes/configuracion.php';
	$sentencia="SELECT idloc,loc_nombre,loc_numsens FROM locaciones WHERE loc_idusuario=".$idusuario."";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num=mysqli_stmt_num_rows ($stmt);
	if($num>0){
	  mysqli_stmt_bind_result($stmt,$idloc,$locacion,$numsen);
	  $i=0;
	  while(mysqli_stmt_fetch($stmt)){
	    $idlocs[$i]=$idloc;
	    $locaciones[$i]=$locacion;
	    $numsens[$i]=$numsen;
	    $i++;
	    }
	 }
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);
	return [$idlocs, $locaciones,$numsens];
}
  function getSensors($idloc){
    	include 'includes/configuracion.php';
	$sentencia="SELECT idsens, sens_idtipo,tipo_nombre FROM sensores, tipos WHERE sens_idloc=".$idloc." AND sens_idtipo = idtipo";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num=mysqli_stmt_num_rows ($stmt);
	if($num>0){
	  mysqli_stmt_bind_result($stmt,$idsen, $idtipo,$sensor);
	  $i=0;
	  while(mysqli_stmt_fetch($stmt)){
	    $idsens[$i]=$idsen;
	    $idtipos[$i]=$idtipo;
	    $sensores[$i]=$sensor;
	    $i++;
	    }
	 }
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);
	return [$idsens,$idtipos, $sensores];
}
function showLocations($correo){
	include 'includes/configuracion.php';
	$idusuario = getId($correo);
	list($idlocs,$locaciones,$numsens)=getLocations($idusuario);
	$j = count($idlocs);
	if($j>0){
	$i=0;
	  while($i<=$j-1){
	    ?>
	    <div class="panel panel-success">
	    <div class="panel-heading"><h3 class="panel-title"><center><?php echo $locaciones[$i]; ?></center></h3></div>
	    <div class="panel-body">
	    <b>Nombre de Ubicación</b>
	    <input type="text" id="locacion" placeholder="Nombre de Ubicación" value="<?php echo $locaciones[$i]; ?>">
	    <button class='btn btn-info' onclick="GuardarLoc(this)" data-toggle="tooltip" title="Guardar"><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span></button>
	    <br>
	    <button class='btn btn-success' onclick="AddSensor()"><span class='glyphicon glyphicon-plus' aria-hidden='true'></span></button>
	     Añadir Nuevo Sensor
	    <?php
	    generar_selects($numsens[$i]);
	    ?>
	    </div>
	    </div>
	    <?php
	    $i++;
	  }
	 }
}
function getLastSensorRegister($idsensor){
	include 'includes/configuracion.php';
	$sentencia="SELECT reg_valor,reg_fechahora FROM registros WHERE reg_idsens=".$idsensor." ORDER BY idreg DESC LIMIT 1";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num=mysqli_stmt_num_rows ($stmt);
	if($num>0){
	  mysqli_stmt_bind_result($stmt,$valor,$fechahora);
	  mysqli_stmt_fetch($stmt);
	  return [true,$valor, $fechahora];
	}
	else{return[false,0,0];}
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);	
}
function showUserLocations($correo){
	include 'includes/configuracion.php';
	$idusuario = getId($correo);
	list($idlocs,$locaciones,$numsens)=getLocations($idusuario);
	$j = count($idlocs);
	if($j>0){
	$i=0;
	  while($i<=$j-1){
	    list($idsens,$idtipos, $sensores)=getSensors($idlocs[$i]);
	    ?>
	    <div class="panel panel-success">
	    <div class="panel-heading" role="tab" id="heading<?php echo $idlocs[$i]; ?>">
	    <h4 class="panel-title">
	    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $idlocs[$i]; ?>" aria-expanded="false" aria-controls="<?php echo $idlocs[$i]; ?>">
	    <?php echo $locaciones[$i]; ?>
	    </a></h4></div>
	    <div id="<?php echo $idlocs[$i]; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $idlocs[$i]; ?>">
	    <div class="panel-body">
		<?php
		for($k=0;$k<$numsens[$i];$k++){
		    list($flag,$valor,$fechahora) = getLastSensorRegister($idsens[$k]);
		    ?> <h2><?php
		    iconos($idtipos[$k]);
		    ?> <b><?php echo $sensores[$k];?></b></h2><h3>
		    <?php
		    if(!$flag){
		      ?>
		      <span class="glyphicon glyphicon-thumbs-down"></span>
		      <p>No hay datos disponibles de este sensor.</p>
		      <?php
		    }
		    else{
		      if($valor==0){echo 'Sensor dañado';}else{echo $valor.' '.unidades($idtipos[$k]);}
		      echo "<h4>Obtenido: ".$fechahora."</h4>";
		    }
		    ?></h3><?php
		}
		?>
	    </div>
	    </div>
	    </div>
	    <?php
	    $i++;
	  }
	 }
}
 function UpdatePhoto($foto,$correo){
  include 'includes/configuracion.php';
	$idusuario = getId($correo);
	$actualiza="UPDATE usuarios SET foto='".$foto."' WHERE correo='".$correo."'";
	$res = mysqli_query($mysqli,$actualiza);
	mysqli_close($mysqli);
	return $res;
  }
  function countNotifications($correo){
	include 'includes/configuracion.php';
	$idusuario = getId($correo);
	$sentencia = "SELECT COUNT(idnot) from notificaciones WHERE not_idususario = ".$idusuario."";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num=mysqli_stmt_num_rows ($stmt);
	if($num>0){
	  mysqli_stmt_bind_result($stmt,$conteo);
	  mysqli_stmt_fetch($stmt);
	  return $conteo;
	}
	else{return 0;}
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);	
  }
  function showNotifications($correo){
	include 'includes/configuracion.php';
	$idusuario=getId($correo);
	$sentencia="SELECT idnot,loc_nombre,tipo_nombre,not_umbral FROM `notificaciones`,locaciones,tipos,sensores WHERE loc_idusuario = ".$idusuario." AND idloc = sens_idloc AND sens_idtipo = idtipo AND not_idsens = idsens";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num=mysqli_stmt_num_rows ($stmt);
	if($num>0){
	  mysqli_stmt_bind_result($stmt,$idnot,$locacion,$sensor,$umbral);
	  ?>
	  <table class="table table-hover">
	  <tr><th>Variable</th><th>Ubicación</th><th>Umbral</th></tr>
	  <?php while(mysqli_stmt_fetch($stmt)){ ?>
		    <tr class="warning">
		    <td><?php echo $sensor; ?></td>
		    <td><?php echo $locacion; ?></td>
		    <td><?php echo $umbral; ?></td>
		    <td><button class='btn btn-danger' onclick="DeleteNot(<?php echo $idnot; ?>)" data-toggle="tooltip" title="Eliminar"><span class='glyphicon glyphicon-minus' aria-hidden='true'></span></button></td>
		    </tr>
		    <?php
	  }
	  ?>
	  </table>
	  <?php
	}
  }
  
  function selected($variable,$valor){
	if ($variable==$valor){echo "selected";}
} 

  function select_locations($correo){
	include 'includes/configuracion.php';
	$idusuario=getId($correo);
	$sentencia = "SELECT idloc, loc_nombre from locaciones WHERE loc_idusuario = ".$idusuario."";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num=mysqli_stmt_num_rows ($stmt);
	if($num>0){
	  mysqli_stmt_bind_result($stmt,$idloc,$locacion);
	  ?>
	  <select id="select_idloc" name="idloc" onchange="Locacion()"><option value="0"></option>
	  <?php 
	  while(mysqli_stmt_fetch($stmt)){
	  ?>
	      <option value="<?php echo $idloc; ?>" <?php selected($_SESSION['idloc'],$idloc);?> ><?php echo $locacion;?></option>
	    <?php } ?>
	    </select> <?php
	 }
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);
	
  }
     function select_loc_sensors($idloc){
	include 'includes/configuracion.php';
	$idusuario=getId($correo);
	$sentencia = "SELECT idsens, tipo_nombre from sensores,tipos WHERE sens_idloc = ".$idloc." AND idtipo=sens_idtipo";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num=mysqli_stmt_num_rows ($stmt);
	if($num>0){
	  mysqli_stmt_bind_result($stmt,$idsen,$sensor);?>
	  <select name="idsen" onchange="Sensor()"><option value=0 /><?php 
	  while(mysqli_stmt_fetch($stmt)){?>
	      <option value="<?php echo $idsen; ?>" <?php selected($_SESSION['idsen'],$idsen);?>><?php echo $sensor;?></option>
	    <?php }
	 }
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);	
  }

  function saveNotification($idsen,$correo,$umbral){
	include 'includes/configuracion.php';
	$idusuario=getId($correo);
	$sentencia = "INSERT INTO notificaciones (not_idsens,not_idusuario,not_umbral) VALUES(".$idsen.",".$idusuario.",".$umbral.")";
	$res = mysqli_query($mysqli,$sentencia);
	if (!$res) {
	    printf("Error: %s\n", mysqli_error($mysqli));
	}
	return $res;
  }
  function deleteNotification($idnot){
	include 'includes/configuracion.php';
	$sentencia = "DELETE from notificaciones WHERE idnot = ".$idnot."";
	$res = mysqli_query($mysqli,$sentencia);
	if (!$res) {
	    printf("Error: %s\n", mysqli_error($mysqli));
	}
	return $res;
  }
  function getSensorRegisters($idsensor,$desde,$hasta){
	include 'includes/configuracion.php';
	$sentencia="SELECT reg_valor,reg_fechahora, YEAR(reg_fechahora) , MONTH(reg_fechahora) , DAY(reg_fechahora) , HOUR(reg_fechahora) , MINUTE(reg_fechahora) FROM registros WHERE reg_idsens=".$idsensor." AND reg_fechahora BETWEEN '".$desde."' AND '".$hasta."' ORDER BY reg_fechahora ASC";
	$stmt = mysqli_prepare($mysqli,$sentencia);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$num=mysqli_stmt_num_rows ($stmt);
	if($num>0){
	  mysqli_stmt_bind_result($stmt,$valor,$fechahora,$year,$month,$day,$hour,$minute);
	  $i=0;
	  while(mysqli_stmt_fetch($stmt)){
	    $valores[$i]=$valor;
	    $fechahoras[$i]=$fechahora;
	    $years[$i]=$year;
	    $months[$i]=$month;
	    $days[$i]=$day;
	    $hours[$i]=$hour;
	    $minutes[$i]=$minute;
	    $i++;
	  }
	  return[true,$valores,$fechahoras,$years,$months,$days,$hours,$minutes];
	}
	else{return[false,0,0,0,0,0,0,0];}
	mysqli_stmt_close($stmt);     
	mysqli_close($mysqli);	
}
function unidades($idtipo){
  switch($idtipo){
      case 1:
	$unidad = "C";
	break;
      case 2:
	$unidad = "%";
	break;
  }
  return $unidad;
}
  function showHistory($idloc,$desde,$hasta){
	include 'includes/configuracion.php';
	list($idsens,$idtipos, $sensores) = getSensors($idloc);
	$k = count($idsens);
	if ($k>0){ ?>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	  <?php for($i=0;$i<$k;$i++){
	  ?>
	  <div class="panel panel-warning">
	      <div class="panel-heading" role="tab" id="heading<?php echo $idsens[$i]; ?>">
	      <h4 class="panel-title">
	      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $idsens[$i]; ?>" aria-expanded="false" aria-controls="<?php echo $idsens[$i]; ?>">
	      <?php echo $sensores[$i]; ?> <?php iconos($idtipos[$i]) ?>
	      </a></h4></div>
	      <div id="<?php echo $idsens[$i]; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $idsens[$i]; ?>">
	      <div class="panel-body"> <?php
	      list($reg_flag,$valores,$fechahoras,$years,$months,$days,$hours,$minutes) = getSensorRegisters($idsens[$i],$desde,$hasta); 
	      if($reg_flag){
	      $num_reg=count($valores); ?>
		<script type="text/javascript">
		  google.load('visualization', '1', {packages: ['corechart']});
		google.setOnLoadCallback(drawChart);

		function drawChart() {

		  var data = new google.visualization.DataTable();
		  data.addColumn('datetime', 'X');
		  data.addColumn('number', '<?php echo $sensores[$i]; ?> (<?php echo unidades($idtipos[$i]); ?>)');

		  data.addRows([
		    <?php 
					    for ($j = 0; $j < $num_reg; $j++) {
						    echo "[new Date(". $years[$j].",".($months[$j]-1).",".$days[$j].",".$hours[$j].",".$minutes[$j].",0), ". $valores[$j]."], ";
					    } 
					    
			      ?>
		  ]);

		  var options = {
		    width: 550,
		    height: 363,
		    title: 'Comportamiento de <?php echo $sensores[$i]; ?>',
		    hAxis: {
		      title: 'Tiempo desde <?php echo $fechahoras[0] ?> hasta <?php echo $fechahoras[$num_reg-1] ?>'
		    },
		    vAxis: {
		      title: '<?php echo $sensores[$i]; ?> (<?php echo unidades($idtipos[$i]); ?>)'
		    },
		    backgroundColor: '#f1f8e9'
		  };
		  var chart = new google.visualization.LineChart(document.getElementById('sensor<?php echo $idsens[$i]; ?>'));
		  chart.draw(data, options);
		}
		</script>
		<div id='sensor<?php echo $idsens[$i]; ?>'></div>
	      <?php } ?>
	      </div>
	      </div>
	      </div>
	      <?php
	    }
	    ?> </div> <?php
	  }
  }

?>