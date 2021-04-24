<?php
    namespace App\models;
    use App\DBConn;

    class User{
        public static function isValidUser($username,$password){
            $DBConnect=new DBConn();
            $status=0;$msg="Something went wrong";$data=array();
            if(empty($username))
                $msg="User name is required!!";
            else if(empty($password))
                $msg="Password is required!!";
            else {
                $sql = "SELECT * FROM `users` WHERE status=1 and user_name='" . $username . "' and password='" . $password . "'";
                $data=$DBConnect->isValidLogin($sql);
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
?>  