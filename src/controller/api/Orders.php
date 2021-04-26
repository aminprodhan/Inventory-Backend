<?php

    use App\Common;use App\DBConn;
    require '../../../vendor/autoload.php';
    $comm=new Common();
    $msg="Something went wrong";$status=0;
    $returnInfo=array(
        "status" => $status,
        "msg" => $msg,
    );
    if(isset($_GET["tokenId"])) {
        $tokenId=$_GET["tokenId"];
        $isValidToken=$comm->isValidToken($tokenId);
        if(!empty($isValidToken)) {
            $db=new DBConn();
            $oInfo=$db->getMyOrders($isValidToken);
            $returnInfo["orders_today"]=$oInfo["todays"];
            $returnInfo["orderStatuses"]=$db->getOrderStatuses();;
            $returnInfo["orders"]=$oInfo["all"];
            $returnInfo["orderByStatus"]=$oInfo["order_by_status"];
            $returnInfo["status"]=1;
            $returnInfo["msg"]="Success";
        }
    }
    echo json_encode($returnInfo);