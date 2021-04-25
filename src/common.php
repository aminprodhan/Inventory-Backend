<?php
namespace App;
use \Firebase\JWT\JWT;
use App\DBConn;
class Common{
    public static $encKey="amincpi";
    public static function encrypttData($payload){
        return JWT::encode($payload, self::$encKey);
    }
    public static function decryptData($payload){
        return JWT::decode($payload, self::$encKey, array('HS256'));
    }
    public function getProductsInfo($tokenId){
        $decoded = Common::decryptData($tokenId);
        if(!empty($decoded->uid)){
            $DBConnect=new DBConn();
            $array_col=array(
                "id" => $decoded->uid,
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