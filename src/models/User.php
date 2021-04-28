<?php
    namespace App\models;
    use App\DBConn;
    class User{
        private $db;
        public function __construct()
        {
            $this->db=new DBConn();
        }
        public function isValidUser($convJson){
            $status=0;$msg="Something went wrong";$data=[];
            if(isset($convJson->username) && isset($convJson->password)){
                $username=$convJson->username;$password=$convJson->password;
                if(empty($username))
                    $msg="User name is required!!";
                else if(empty($password))
                    $msg="Password is required!!";
                else {
                    $data = $this->db->isValidLogin("users", $username, $password, 2);
                    $msg = "username or password is wrong!!!";
                    if (!empty($data["token_id"]))
                        {
                            $status = 1;$msg = "Success";
                        }
                }
            }
            $ara=["status" => $status, "msg" => $msg, "uinfo"=> (object)$data];
            return $ara;
        }
    }
?>  