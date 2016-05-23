<?php
$mysqli = mysqli_connect(
    getenv('OPENSHIFT_MYSQL_DB_HOST'), 
    'admin4zRpBek',  
    'i5GRBfq1eHJR',
    'sistelemetria',
    getenv('OPENSHIFT_MYSQL_DB_PORT')
);
?>