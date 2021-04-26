<?php

    use App\Common;use App\DBConn;
    require '../../../../vendor/autoload.php';
    $comm=new Common();
    $msg="Something went wrong";$status=0;$order_id=0;

    $jasonarray = json_decode(file_get_contents('php://input'),true);
    if(isset($jasonarray["tokenId"])) {
        $db=new DBConn();
        $convJson = (object)$jasonarray["data"];
        $tokenId=$jasonarray["tokenId"];
        $isValidToken=$comm->isValidToken($tokenId);
        if(!empty($isValidToken) && $isValidToken->role_id == 2) {
            $isOrder=$db->makeOrder($isValidToken,$convJson);
            if(!empty($isOrder)){
                $msg="Success";$status=1;
            }
        }
    }
    $returnInfo=array(
        "status" => $status,
        "msg" => $msg,
    );
    echo json_encode($returnInfo);