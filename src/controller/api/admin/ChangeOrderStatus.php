<?php
    require '../../../../vendor/autoload.php';
    use App\models\Orders;
    use App\Common;
    $comm=new Common();
    $jasonarray = json_decode(file_get_contents('php://input'),true);
    $msg="Something went wrong";$status=0;
    $returnInfo=["status" => 0, "msg" => "Something went wrong",];
    if(isset($jasonarray["tokenId"]) && isset($jasonarray["data"])
        && isset($jasonarray["data"]["orderId"]) && isset($jasonarray["data"]["statusId"])) {
        $tokenId = $jasonarray["tokenId"];
        $isValidToken = $comm->isValidToken($tokenId);
        if(!empty($isValidToken) && $isValidToken->role_id == 1){
            $orderModel=new Orders();
            $convJson = (object)$jasonarray["data"];
            $returnInfo=$orderModel->updateOrderStatus($isValidToken,$convJson);
        }
    }
    echo json_encode($returnInfo);