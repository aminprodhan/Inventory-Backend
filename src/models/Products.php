<?php
namespace App\models;
use App\DBConn;
use App\Common;
class Products{
    public static function itemValidate($convJson){
        $comm=new Common();
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

        if($status == 1){
            $isValidSKU = $comm->isValidSKU($sku);
            if (empty($isValidSKU)) {
                $status = 0;
                $ara = array("msg" => "SKU is not valid", "key" => "sku");
                array_push($errors, $ara);
            }
        }

        return (object)[
            "status" => $status,
            "errors" => $errors,
        ];


    }
    public static function createNewItem($convJson){
        /*'" . $name . "','" . $categoryId . "','" . $sku . "',
                    '" . $desc . "','" . $price . "','" . $imageId . "'*/
        $db=new DBConn();$comm=new Common();
        $upload_path = Common::getProductImagePath();
        $imageId = $comm->uploadImages($product_image, $upload_path);
        $sql = "insert into products(name,category_id,sku,description,price,image) values (?,?,?,?,?,?)";
        $values=[$convJson->name,$convJson->categoryId,$convJson->sku,$convJson->desc,$convJson->price,$convJson->desc]
        $db->saveProduct($sql);
    }
    public static function updateProductInfo(){
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
}