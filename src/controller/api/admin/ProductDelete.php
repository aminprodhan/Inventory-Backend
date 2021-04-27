<?php
    require '../../../../vendor/autoload.php';
    use App\Common;use App\models\Products;
    $returnInfo=["products" => [], "status" => 0, "msg" => "Something went wrong"];
    $jasonarray = json_decode(file_get_contents('php://input'),true);
    if(isset($jasonarray["data"]) && isset($jasonarray["tokenId"]) && isset($jasonarray["data"]["item_id"])) {
        $comm=new Common();
        $tokenId = $jasonarray["tokenId"];
        $isValidToken = $comm->isValidToken($tokenId);
        $returnInfo["msg"]="Token not found!!!";
        if (!empty($isValidToken) && $isValidToken->role_id == 1) {
            $convJson = (object)$jasonarray["data"];
            $pm=new Products();
            try{
                $returnInfo = $pm->deleteProduct($convJson);
            }
            catch (\Exception $e){}
        }
    }
    echo json_encode($returnInfo);
