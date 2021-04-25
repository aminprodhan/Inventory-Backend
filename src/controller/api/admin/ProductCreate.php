<?php
    require '../../../../vendor/autoload.php';
    use App\DBConn;
    use App\Common;
    $db=new DBConn();
    $comm=new Common();
    $jasonarray = json_decode(file_get_contents('php://input'),true);
    $res["status"] = 0;
    $res["errors"] = array();
    if(isset($jasonarray["reqData"])) {
        $convJson = (object)$jasonarray["reqData"];
        $tokenId=$jasonarray["tokenId"];
        $isValidToken=$comm->isValidToken($tokenId);
        if(!empty($isValidToken) && $isValidToken->role_id == 1) {
            $name = $convJson->name;
            $desc = $convJson->desc;
            $sku = $convJson->sku;
            $categoryId = $convJson->categoryId;
            $price = $convJson->price;
            $updateId = $convJson->updateId;
            $product_image = $convJson->product_image;
            $isImgUpdate = $convJson->isImgUpdate;
            $status=1;$errors=array();
            if (empty($product_image)) {
                $status = 0;
                $ara = array("msg" => "Valid Product Image is required", "key" => "product_image");
                array_push($errors, $ara);
            }
            if (empty($name)) {
                $status = 0;
                $ara = array("msg" => "Name is required", "key" => "name");
                array_push($errors, $ara);
            }
            if (empty($sku)) {
                $status = 0;
                $ara = array("msg" => "Sku is required", "key" => "sku");
                array_push($errors, $ara);
            }
            if (empty($categoryId)) {
                $status = 0;
                $ara = array("msg" => "Category is required", "key" => "categoryId");
                array_push($errors, $ara);
            }
            if (empty($price)) {
                $status = 0;
                $ara = array("msg" => "Price is required", "key" => "price");
                array_push($errors, $ara);
            }
            $res["products"] = array();
            $upload_path = $comm->getProductImagePath();
            if ($status != 0) {
                if (!empty($updateId)) {
                    $colWhere = array("id" => $updateId, "status" => 1, "trash" => 1);
                    $isValidItem = $db->getInfo("products", $colWhere);
                    if (!empty($isValidItem["id"])) {
                        $colWhereNotIn = array("id", $updateId);
                        $isValidSKU = $comm->isValidSKU($sku, $updateId);
                        if (!empty($isValidSKU)) {
                            $araUpdateCol = array(
                                "name" => $name, "sku" => $sku, "category_id" => $categoryId, "price" => $price,
                                "description" => $desc
                            );
                            if ($isImgUpdate) {
                                $imageId = $comm->uploadImages($product_image, $upload_path);
                                if (!empty($imageId)) {
                                    $araUpdateCol["image"] = $imageId;
                                    if (!empty($isValidItem["image"])) {
                                        $comm->removeProductImage($isValidItem["image"]);
                                    }
                                }
                            }
                            $araUpdateWhere = array("id" => $updateId);
                            $isUpdate = $db->updateTableData("products", $araUpdateCol, $araUpdateWhere);
                        } else {
                            $status = 0;
                            $ara = array("msg" => "SKU is not valid", "key" => "sku");
                            array_push($errors, $ara);
                        }
                    } else {
                        $status = 0;
                        $ara = array("msg" => "Product Not found", "key" => "name");
                        array_push($errors, $ara);
                    }
                }
                else {
                    $isValidSKU = $comm->isValidSKU($sku);
                    if (!empty($isValidSKU)) {
                        $imageId = $comm->uploadImages($product_image, $upload_path);
                        $sql = "insert into products(name,category_id,sku,description,price,image) values ('" . $name . "','" . $categoryId . "','" . $sku . "','" . $desc . "','" . $price . "','" . $imageId . "')";
                        $db->saveProduct($sql);
                    }
                    else{
                        $status = 0;
                        $ara = array("msg" => "SKU is not valid", "key" => "sku");
                        array_push($errors, $ara);
                    }
                }
                $products = $db->getProducts();
                $res["products"] = $products;
                $res["imgProductUrl"] = Common::productImgUrl();
            }
            $res["status"] = $status;
            $res["errors"] = $errors;
            //$res["sql"] = $sql;
        }
    }
    echo json_encode($res);

?>