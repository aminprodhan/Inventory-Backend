<?php

    use App\Common;use App\models\Orders;
    require '../../../../vendor/autoload.php';
    $returnInfo=["msg" => "Something went wrong!!","status" => 0];
    $jasonarray = json_decode(file_get_contents('php://input'),true);
    if(isset($jasonarray["tokenId"]) && isset($jasonarray["data"])) {
        $order_model=new Orders();$comm=new Common();
        $tokenId=$jasonarray["tokenId"];
        $isValidToken=$comm->isValidToken($tokenId);$msg="Token not found!!!";
        if(!empty($isValidToken) && $isValidToken->role_id == 2) {
            $convJson = (object)$jasonarray["data"];
            try{
                $returnInfo=$order_model->makeOrder($isValidToken,$convJson);
            }
            catch (\Exception $e){}
        }
    }
    echo json_encode($returnInfo);