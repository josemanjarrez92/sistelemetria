<?php
$mysqli = mysqli_connect(
    getenv('OPENSHIFT_MYSQL_DB_HOST'), 
    getenv('OPENSHIFT_MYSQL_DB_USERNAME'), 
    getenv('OPENSHIFT_MYSQL_DB_PASSWORD'),
    'aerogenerador', 
    getenv('OPENSHIFT_MYSQL_DB_PORT')
);
?>