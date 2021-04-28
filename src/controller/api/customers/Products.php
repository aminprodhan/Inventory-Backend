<?php

    use App\Common;use App\models\Orders;use App\models\Products;
    require '../../../../vendor/autoload.php';
    $returnInfo=["status" => 0, "msg" => "Something went wrong"];
    if(isset($_GET["tokenId"]))
    {
        $comm=new Common();
        $tokenId=$_GET["tokenId"];$returnInfo["msg"]="Token not found!!";
        $isValidToken=$comm->isValidToken($tokenId);
        if(!empty($isValidToken) && $isValidToken->role_id == 2){
            $order_model=new Orders();$products=new Products();
            $orders=$order_model->getMyOrders($isValidToken);
            $returnInfo=[
                "products" => $products->getProducts(),
                "imgProductUrl" => Common::productImgUrl(),
                "orders" => $orders["orders"],
                "msg" => "Success",
                "status" => 1,
            ];
        }
    }
    echo json_encode($returnInfo);