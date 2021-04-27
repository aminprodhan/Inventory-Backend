<?php
    namespace App\models;
    use App\DBConn;
    class Admins{
        public static function isValidUser($username,$password){
            $DBConnect=new DBConn();
            $status=0;$msg="Something went wrong";$data=array();
            if(empty($username))
                $msg="User name is required!!";
            else if(empty($password))
                $msg="Password is required!!";
            else {
                $data=$DBConnect->isValidLogin("admins",$username,$password,1);
                $msg="username or password is wrong!!!";
                if(!empty($data["token_id"]))
                    $status=1;
            }
            $ara=array(
                "status" => $status,
                "msg" => $msg,
                "uinfo"=> (object)$data
            );
            return $ara;
        }
    }