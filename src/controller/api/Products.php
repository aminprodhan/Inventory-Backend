<?php

    use App\Common;use App\models\Products;
    require '../../../vendor/autoload.php';
    $returnInfo=["status" => 0, "msg" => "Something went wrong"];
    if(isset($_GET["tokenId"]))
    {
        $comm=new Common();
        $tokenId = $_GET["tokenId"];
        $isValidToken=$comm->isValidToken($tokenId);
        if(!empty($isValidToken) && $isValidToken->role_id == 1) {
            $products=new Products;
            $info = $products->getProductsInfo($isValidToken);
            if (!empty($info)) {
                $info["status"] = 1;
                $info["msg"] = "success";
                $info["imgProductUrl"] = Common::productImgUrl();
                $returnInfo = $info;
            }
        }
    }

    echo json_encode($info);