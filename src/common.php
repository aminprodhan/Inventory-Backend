<?php
namespace App;
use \Firebase\JWT\JWT;
use App\DBConn;
use Intervention\Image\ImageManagerStatic as Image;

class Common{
    public static $encKey="amincpi";
    public static $rootFolder="Inventory-Backend";
    public static $rootProductImageFolder="product_images";
    public static function encrypttData($payload){
        return JWT::encode($payload, self::$encKey);
    }
    public static function decryptData($payload){
        return JWT::decode($payload, self::$encKey, array('HS256'));
    }
    public function isValidToken($token){
        $decoded = Common::decryptData($token);
        if(!empty($decoded->uid)){
            return $decoded;
        }
        return 0;
    }
    public static function getProductImagePath(){
        $proImagePath=$_SERVER['DOCUMENT_ROOT']."\\".self::$rootFolder."\\product_images\\";
        return $proImagePath;
    }
    public static function productImgUrl(){
        $port=$_SERVER['SERVER_PORT'];
        $domain=$_SERVER['SERVER_NAME'];
         $https="https://";$def_port="";
         if($domain == "localhost")
             $https="http://";
         if($port != 80)
             $def_port=":".$port;
         return $https."".$domain.$def_port."/".self::$rootFolder."/".self::$rootProductImageFolder."/";
    }
    public function uploadImages($product_image,$upload_path){

        $strpos = strpos($product_image, ';');
        $sub = substr($product_image, 0, $strpos);
        $Ex = explode('/', $sub)[1];
        $name = \time() . "." . $Ex;
        $image = Image::make($product_image)->resize(400, 400);
        $image->save($upload_path . $name);
        return $name;
    }
    public function removeProductImage($product_image){
        $file=self::getProductImagePath()."".$product_image;
        if (file_exists($file))
        {
            unlink($file);
        }
    }
    public function isValidSKU($sku,$updateId=0){
        $DBConnect=new DBConn();
        $colWhere=array("sku" => $sku,"status" => 1);
        $colWhereNotIn=array();
        if(!empty($updateId))
            $colWhereNotIn=["id"=>$updateId];

        $isValidSku=$DBConnect->getInfo("products",$colWhere,$colWhereNotIn);
        if(!empty($isValidSku["id"]))
            return 0;
        return 1;
    }

    public function getProductsInfo($tokenId){
        $isValid = self::isValidToken($tokenId);
        if(!empty($isValid)){
            $uid=$isValid->uid;
            $DBConnect=new DBConn();
            $array_col=array(
                "id" => $uid,
                "status" => 1,
            );
            $users = $DBConnect->getInfo("users",$array_col);
            if(!empty($users["id"])){
                $role_id=$users["role_id"];
                if($role_id == 1){
                    return $results=array("products" => $DBConnect->getProducts(),"categories" => $DBConnect->getCategories());
                }
            }
            return 0;
        }
        return 0;
    }
}