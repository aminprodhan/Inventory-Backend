<?php
    require '../../../../vendor/autoload.php';
    use App\DBConn;
    use App\Common;
    $db=new DBConn();
    $comm=new Common();
    $returnInfo=array(
        "products" => array(), "status" => 0, "msg" => "Something went wrong"
    );
    $jasonarray = json_decode(file_get_contents('php://input'),true);
    if(!empty($jasonarray["reqData"])) {
        $convJson = (object)$jasonarray["reqData"];
        $tokenId = $jasonarray["tokenId"];
        if (!empty($tokenId)) {
            $isValidToken = $comm->isValidToken($tokenId);
            if (!empty($isValidToken) && $isValidToken->role_id == 1) {
                $item_id = $convJson->id;
                $isDelete=$db->updateTableData("products",$araCol = array("trash"=> 2),$araCol = array("id"=> $item_id));
                if(!empty($isDelete))
                    $comm->removeProductImage($convJson->image);
                $info = $comm->getProductsInfo($tokenId);
                $info["msg"] = "success";
                $info["status"] = 1;
                $returnInfo = $info;
            }
        }
    }
    echo json_encode($returnInfo);
