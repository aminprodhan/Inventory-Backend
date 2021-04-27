<?php
namespace App\models;
use App\DBConn;
use App\Common;
class Products{
    public  $db;
    public  $comm;
    public function __construct(){
        $this->db=new DBConn();
        $this->comm=new Common();
    }
    public function isValidItem($item_id){
        $sql="select * from products where id=? and status=? and trash = ?";
        $values=[$item_id,1,1];
        $isValidItem = $this->db->getInfo($sql,$values);
        if (!empty($isValidItem["id"]))
            return $isValidItem;
        return 0;
    }
    public function isValidSKU($sku,$updateId=0){
        $values=[$sku,1];$def_update="";
        if(!empty($updateId))
        {
            $values[]=$updateId;$def_update=" and id != ?";
        }

        $sql="select * from products where sku=? and status=? ".$def_update."";
        $isValidSku = $this->db->getInfo($sql,$values);
        if(!empty($isValidSku["id"]))
            return 0;
        return 1;
    }
    public function itemValidate($convJson,$isUpdate=0){
        $updateId = 0;
        $status=0;$errors=array();
        if(!isset( $convJson->desc)) $errors[] = ["msg" => "Description key is required", "key" => "desc"];
        if(!isset( $convJson->product_image)) $errors[] = ["msg" => "Product Image key is required", "key" => "product_image"];
        if (empty($convJson->name)) $errors[] = ["msg" => "Name is required", "key" => "name"];
        if (empty($convJson->sku)) $errors[] = ["msg" => "SKU is required", "key" => "sku"];
        if (empty($convJson->categoryId)) $errors[] =["msg" => "Category is required", "key" => "categoryId"];
        if (empty($convJson->price)) $errors[] =["msg" => "Price is required", "key" => "price"];
        if(!empty($isUpdate)){
            if(!isset( $convJson->updateId)) $errors[] = ["msg" => "Update id key is required", "key" => "desc"];
            if(!isset( $convJson->isImgUpdate)) $errors[] = ["msg" => "isImgUpdate key is required", "key" => "desc"];
            if(isset($convJson->updateId))
                $updateId=$convJson->updateId;
        }

        if(count($errors) == 0){
            $name = $convJson->name;$status=1;
            $sku = $convJson->sku;
            $categoryId = $convJson->categoryId;
            $price = $convJson->price;
            $desc = $convJson->desc;
            $product_image = $convJson->product_image;
            $isValidSKU = $this->isValidSKU($sku,$updateId);
            if (empty($isValidSKU)) {
                $errors[] = ["msg" => "SKU is not valid", "key" => "sku"];
                $status = 0;
            }
        }
        return (object)[
            "status" => $status,
            "errors" => $errors,
        ];


    }
    public function createNewItem($convJson){

        $upload_path = Common::getProductImagePath();$imageId=0;
        if(!empty($convJson->product_image))
            $imageId =$this->comm->uploadImages($convJson->product_image, $upload_path);
        $sql = "insert into products(name,category_id,sku,description,price,image) values (?,?,?,?,?,?)";
        $values=[$convJson->name,$convJson->categoryId,$convJson->sku,
            $convJson->desc,$convJson->price,$imageId];

        return $this->db->queryExecute($sql,$values);
    }
    public function updateProductInfo($convJson){

        $updateId=$convJson->updateId;$errors=[];$status = 0;
        $isValidItem = $this->isValidItem($updateId);
        if (!empty($isValidItem)) {
            $upload_path = Common::getProductImagePath();
            $isImgUpdate = $convJson->isImgUpdate;$img_def_sql="";
            $values=[$convJson->name,$convJson->categoryId,$convJson->sku,
                $convJson->desc,$convJson->price];
            if ($isImgUpdate) {
                $imageId = $this->comm->uploadImages($convJson->product_image, $upload_path);
                if (!empty($imageId)) {
                    $img_def_sql=",image=?";$values[]=$imageId;
                    if (!empty($isValidItem["image"])) {
                        $this->comm->removeProductImage($isValidItem["image"]);
                    }
                }
            }
            $values[]=$updateId;
            $sql="update products set name=?,category_id=?,sku=?,description=?,price=? ".$img_def_sql." where id=? ";
            $isUpdate = $this->db->queryExecute($sql, $values);
            $status=1;
        } else {
            $ara = array("msg" => "Product Not found", "key" => "name");
            array_push($errors, $ara);
        }
        return (object)[
            "status" => $status,
            "errors" => $errors,
        ];
    }
    public function deleteProduct($convJson){
        $item_id = $convJson->item_id;$status=0;$res=["status" => 0,"msg"=>"Item not found"];
        $isValidItem = $this->isValidItem($item_id);
        if (!empty($isValidItem)) {
            $sql = "update products set trash=? where id=? ";
            $values = [2, $item_id];
            $isDelete = $this->db->queryExecute($sql, $values);
            if (!empty($isDelete))
                $this->comm->removeProductImage($isValidItem["image"]);
            $info = $this->getProducts();
            $res["status"]=1;$res["msg"]="Success";$res["products"]=$info;
        }
        return (object)$res;
    }
    public function getProductsInfo($isValid){

            $uid=$isValid->uid;
            $sql="select * from admins where id=? and status=?";
            $values=[$uid,1];
            $users = $this->db->getInfo($sql,$values);
            if(!empty($users["id"])){
                $role_id=$users["role_id"];
                if($role_id == 1){
                    return $results=array("products" => $this->db->getProducts(),
                        "categories" => $this->db->getCategories());
                }
            }
            return 0;

    }
    public function getProducts(){
        return $this->db->getProducts();
    }

}