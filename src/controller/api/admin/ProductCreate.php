<?php
    require '../../../../vendor/autoload.php';
    use App\Common;use App\models\Products;

    $jasonarray = json_decode(file_get_contents('php://input'),true);
    $res["status"] = 0;
    $res["errors"] = array();



    if(isset($jasonarray["tokenId"])) {
        $tokenId=$jasonarray["tokenId"];
        $isValidToken=$comm->isValidToken($tokenId);
        if(!empty($isValidToken) && $isValidToken->role_id == 1) {

            $comm=new Common();
            $convJson = (object)$jasonarray["reqData"];
            $isValid=Products::itemValidate($convJson);
            $status=$isValid->status;$errors=$isValid->errors;
            if ($status != 0) {

                $products = $db->getProducts();
                $res["products"] = $products;
                $res["imgProductUrl"] = Common::productImgUrl();
            }
            $res["status"] = $status;
            $res["errors"] = $errors;
        }
    }
    echo json_encode($res);

?>