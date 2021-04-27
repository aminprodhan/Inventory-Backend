    <?php
    require '../../../../vendor/autoload.php';
    use App\Common;use App\models\Products;

    $jasonarray = json_decode(file_get_contents('php://input'),true);
    $res["status"] = 0;$res["msg"]="Something went wrong!!";
    $res["errors"] = array();

    if(isset($jasonarray["tokenId"]) && isset($jasonarray["data"])) {
        $comm=new Common();
        $tokenId=$jasonarray["tokenId"];
        $isValidToken=$comm->isValidToken($tokenId);
        if(!empty($isValidToken) && $isValidToken->role_id == 1) {
            $convJson = (object)$jasonarray["data"];
            $pm = new Products();
            $isValid = $pm->itemValidate($convJson, 1);
            $status = $isValid->status;
            $errors = $isValid->errors;
            if ($status != 0) {
                $status = 0;
                try{
                    $isUpdated = $pm->updateProductInfo($convJson);
                    $products = $pm->getProducts();
                    $res["products"] = $products;
                    $res["imgProductUrl"] = Common::productImgUrl();
                    $status = 1;
                    $res["msg"] = "Success";
                }
                catch (\Exception $e){}
            }
            $res["status"] = $status;
            $res["errors"] = $errors;
        }else{
            $res["msg"]="Token not found!!";
        }
    }
    echo json_encode($res);

    ?>