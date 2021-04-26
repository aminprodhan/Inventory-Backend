<?php

    use App\Common;
    use App\DBConn;
    require '../../../../vendor/autoload.php';
    $comm=new Common();

    $returnInfo=array(
        "products" => [],
        "orders" => [],
        "status" => 0,
        "msg" => "Something went wrong"
    );
    if(isset($_GET["tokenId"]))
    {
        $db=new DBConn();
        $tokenId=$_GET["tokenId"];
        $isValidToken=$comm->isValidToken($tokenId);
        if(!empty($isValidToken) && $isValidToken->role_id == 2){
            $orders=$db->getMyOrders($isValidToken);
            $returnInfo=[
                "products" => $db->getProducts(),
                "imgProductUrl" => Common::productImgUrl(),
                "orders" => $orders["all"],
            ];
        }
    }
    echo json_encode($returnInfo);