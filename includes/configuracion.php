<?php
$mysqli = mysqli_connect(
    getenv('MYSQL_SERVICE_HOST'), 
    getenv('MYSQL_USER'), 
    getenv('MYSQL_PASSWORD'),
    'sistelemetria', 
    getenv('MYSQL_SERVICE_PORT')
);
?>
