<?php
    namespace App\models;
    use App\DBConn;
    use App\Common;
    class Admins{
        public  $db;
        public  $comm;
        public function __construct(){
            $this->db=new DBConn();
            $this->comm=new Common();
        }
        public function isValidUser($username,$password){
            $status=0;$msg="Something went wrong";$data=array();
            if(empty($username))
                $msg="User name is required!!";
            else if(empty($password))
                $msg="Password is required!!";
            else {
                $info=$this->db->isValidLogin("admins",$username,$password,1);
                $msg="username or password is wrong!!!";
                if(!empty($info["token_id"]))
                {
                    $status=1;$data=$info;$msg="Success";
                }
            }
            $ara=array(
                "status" => $status,
                "msg" => $msg,
                "uinfo"=> (object)$data
            );
            return $ara;
        }
    }