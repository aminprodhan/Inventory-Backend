<?php
    require '../../../vendor/autoload.php';
    $returnInfo=array(
        "categories" => array(),
        "products" => array(),
    );
    if(isset($_GET["token_id"]))
    {
        $returnInfo=$_GET["token_id"];
    }
    echo json_encode($returnInfo);