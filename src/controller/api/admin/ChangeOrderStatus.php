<?php
    require '../../../../vendor/autoload.php';
    use App\DBConn;
    use App\Common;
    $db=new DBConn();
    $comm=new Common();
    $jasonarray = json_decode(file_get_contents('php://input'),true);
    $msg="Something went wrong";$status=0;
    $returnInfo=array(
        "status" => $status,
        "msg" => $msg,
    );
    if(isset($jasonarray["tokenId"])) {
        $tokenId = $jasonarray["tokenId"];
        $isValidToken = $comm->isValidToken($tokenId);
        if(!empty($isValidToken) && $isValidToken->role_id == 1){
            $convJson = (object)$jasonarray["data"];
            $oInfo=$db->updateMyOrderStatus($isValidToken,$convJson);
            $returnInfo["orders_today"]=$oInfo["todays"];
            $returnInfo["orderStatuses"]=$db->getOrderStatuses();;
            $returnInfo["orders"]=$oInfo["all"];
            $returnInfo["orderByStatus"]=$oInfo["order_by_status"];
            $returnInfo["status"]=1;
            $returnInfo["msg"]="Success";
        }
    }
    echo json_encode($returnInfo);