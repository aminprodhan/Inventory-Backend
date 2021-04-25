<?php

    use App\Common;
    require '../../../vendor/autoload.php';
    $comm=new Common();
    $returnInfo=array(
        "categories" => array(),
        "products" => array(),
        "status" => 0,
        "msg" => "Something went wrong"
    );
    if(isset($_GET["token_id"]))
    {
        $tokenId=$_GET["token_id"];
        $info = $comm->getProductsInfo($tokenId);
        if(!empty($info)){
            $info["status"]=1;
            $info["msg"]="success";
            $info["imgProductUrl"]=Common::productImgUrl();
            $returnInfo=$info;
        }
    }

    echo json_encode($returnInfo);