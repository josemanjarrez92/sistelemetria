<?php // comienza el archivo php
echo "welcome \n"; //echo es para mostrar texto en la página. En este caso mostramos texto para saber en qué etapa del algoritmo vamos.
	if($_GET['type'] == 'acc'){
		if(!empty($_GET['x']) && !empty($_GET['y']) && !empty($_GET['z'])){ //las variables que llegan por GET se pueden llamar utilizando $_GET['nombredevariable'].
		echo "no están vacías \n"; //En efecto, la función empty nos ayuda a verificar si una variable está vacía. Utilizar !empty nos ayuda a verificar lo contrario.
		include 'includes/configuracion_aero.php'; //El archivo configuracion_aero contiene la definición de una variable llamada mysqli. Esta variable
		//contiene toda la información necesaria para conectarse a la base de datos llamada aerogenerador
		date_default_timezone_set('America/Bogota'); //configuramos la hora del servidor
		$sentencia = "INSERT INTO acelerometro (eje_x,eje_y,eje_z,fecha_hora) VALUES(".$_GET['x'].",".$_GET['y'].",".$_GET['z'].",CURRENT_TIMESTAMP)"; //preparamos el query. Los puntos
		// sirven para concatenar caracteres en php.
		mysqli_query($mysqli,"SET SESSION time_zone = '-5:00'"); //configuramos la hora de la base de datos
		$res = mysqli_query($mysqli,$sentencia); //ejectuamos el query en la base de datos seleccionada. Si todo sale bien, la variable $res será 'true', sino será 'false'
		if($res){echo "Ya guardó!";} //si $res es 'true', decimos que ya guardó.
		}
    }
	elseif($_GET['type'] == 'rpm'){
		if(!empty($_GET['rpm'])){ //las variables que llegan por GET se pueden llamar utilizando $_GET['nombredevariable'].
		echo "no están vacías \n"; //En efecto, la función empty nos ayuda a verificar si una variable está vacía. Utilizar !empty nos ayuda a verificar lo contrario.
		include 'includes/configuracion_aero.php'; //El archivo configuracion_aero contiene la definición de una variable llamada mysqli. Esta variable
		//contiene toda la información necesaria para conectarse a la base de datos llamada aerogenerador
		date_default_timezone_set('America/Bogota'); //configuramos la hora del servidor
		$sentencia = "INSERT INTO rpm (rpm,fecha) VALUES(".$_GET['rpm'].",CURRENT_TIMESTAMP)"; //preparamos el query. Los puntos sirven para concatenar caracteres en php.
		mysqli_query($mysqli,"SET SESSION time_zone = '-5:00'"); //configuramos la hora de la base de datos
		$res = mysqli_query($mysqli,$sentencia); //ejectuamos el query en la base de datos seleccionada. Si todo sale bien, la variable $res será 'true', sino será 'false'
		if($res){echo "Ya guardó!";} //si $res es 'true', decimos que ya guardó.
		}
	}
?>