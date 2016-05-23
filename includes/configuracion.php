<?php
$mysqli = mysqli_connect(
    getenv('OPENSHIFT_MYSQL_DB_HOST'), 
    'admin4zRpBek', 
    'sistelemetria', 
    'i5GRBfq1eHJR',
    getenv('OPENSHIFT_MYSQL_DB_PORT')
);
?>