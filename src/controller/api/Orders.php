<?php

    use App\Common;use App\models\Orders;
    require '../../../vendor/autoload.php';
    $msg="Something went wrong";$status=0;
    $returnInfo=["status" => $status, "msg" => $msg];
    if(isset($_GET["tokenId"])) {
        $comm=new Common();$order_model=new Orders();
        $tokenId=$_GET["tokenId"];
        $isValidToken=$comm->isValidToken($tokenId);
        if(!empty($isValidToken)) {
            $returnInfo=$order_model->getMyOrders($isValidToken);
            $returnInfo["status"]=1;
            $returnInfo["msg"]="Success";
        }
    }
    echo json_encode($returnInfo);