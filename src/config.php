<?php

$sDbHost = 'localhost';
$sDbName = 'inventory_laravel_assignment';
$sDbUser = 'root';
$sDbPwd = '';

$con = mysqli_connect($sDbHost,$sDbUser,$sDbPwd,$sDbName);
mysqli_query($con,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 

?>
