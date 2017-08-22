<?php // comienza el archivo php
echo "welcome \n"; //echo es para mostrar texto en la página. En este caso mostramos texto para saber en qué etapa del algoritmo vamos.
	if($_GET['type'] == 'acc'){
		if(!empty($_GET['maxx']) && !empty($_GET['mx']) && !empty($_GET['minx']) && !empty($_GET['maxy']) && !empty($_GET['my']) && !empty($_GET['miny']) && !empty($_GET['maxz']) && !empty($_GET['mz']) && !empty($_GET['minz'])){ //las variables que llegan por GET se pueden llamar utilizando $_GET['nombredevariable'].
		echo "no estan vacias \n"; //En efecto, la función empty nos ayuda a verificar si una variable está vacía. Utilizar !empty nos ayuda a verificar lo contrario.
		include 'includes/configuracion_aero.php'; //El archivo configuracion_aero contiene la definición de una variable llamada mysqli. Esta variable
		//contiene toda la información necesaria para conectarse a la base de datos llamada aerogenerador
		//date_default_timezone_set('America/Bogota'); //configuramos la hora del servidor
		$sentencia = "INSERT INTO acelerometro (max_ejex,m_ejex,min_ejex,max_ejey,m_ejey,min_ejey,max_ejez,m_ejez,min_ejez,fecha_hora) VALUES(".$_GET['maxx'].",".$_GET['mx'].",".$_GET['minx'].",".$_GET['maxy'].",".$_GET['my'].",".$_GET['miny'].",".$_GET['maxz'].",".$_GET['mz'].",".$_GET['minz'].",CURRENT_TIMESTAMP)"; //preparamos el query. Los puntos
		// sirven para concatenar caracteres en php.
		mysqli_query($mysqli,"SET time_zone='-05:00'"); //configuramos la hora de la base de datos
		$res = mysqli_query($mysqli,$sentencia); //ejectuamos el query en la base de datos seleccionada. Si todo sale bien, la variable $res será 'true', sino será 'false'
		if($res){echo "Ya guardo!";} //si $res es 'true', decimos que ya guardó.
		}
    }
	elseif($_GET['type'] == 'rpm'){
		if(!empty($_GET['rpm'])){ //las variables que llegan por GET se pueden llamar utilizando $_GET['nombredevariable'].
		echo "no estan vacias \n"; //En efecto, la función empty nos ayuda a verificar si una variable está vacía. Utilizar !empty nos ayuda a verificar lo contrario.
		include 'includes/configuracion_aero.php'; //El archivo configuracion_aero contiene la definición de una variable llamada mysqli. Esta variable
		//contiene toda la información necesaria para conectarse a la base de datos llamada aerogenerador
		//date_default_timezone_set('America/Bogota'); //configuramos la hora del servidor
		$sentencia = "INSERT INTO rpm (rpm,fecha) VALUES(".$_GET['rpm'].",CURRENT_TIMESTAMP)"; //preparamos el query. Los puntos sirven para concatenar caracteres en php.
		mysqli_query($mysqli,"SET time_zone = '-05:00'"); //configuramos la hora de la base de datos
		$res = mysqli_query($mysqli,$sentencia); //ejectuamos el query en la base de datos seleccionada. Si todo sale bien, la variable $res será 'true', sino será 'false'
		if($res){echo "Ya guardo!";} //si $res es 'true', decimos que ya guardó.
		}
	}
?>