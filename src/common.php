<?php
namespace App;
use \Firebase\JWT\JWT;
use App\DBConn;
use Intervention\Image\ImageManagerStatic as Image;
use DateTime;
use DateTimeZone;
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
    public static function convertDateTimeToDate($datetime){

        $tz = new DateTimeZone('Asia/Dhaka');
        $date = new DateTime($datetime);
        //$date->setTimezone($tz);
        return $date->format('Y-m-d');
    }
    public static function getCurrentDate(){
        $date = new DateTime("now", new DateTimeZone('Asia/Dhaka') );
        return $date->format('Y-m-d');
    }
    public static function getCurrentDateTime(){
        $date = new DateTime("now", new DateTimeZone('Asia/Dhaka') );
        return $date->format('Y-m-d H:i:s');
    }
    public function isValidToken($token){
        try {
            $decoded = Common::decryptData($token);
            if (!empty($decoded->uid)) {
                return $decoded;
            }
        }
        catch (\Exception $e){
            return 0;
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



}