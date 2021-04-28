<?php
    namespace App\models;
    use App\DBConn;
    use App\Common;
    class Orders
    {
        public $db;
        public $comm;
        public function __construct()
        {
            $this->db = new DBConn();
            $this->comm = new Common();
        }
        public function makeOrder($uInfo,$order_info){
            $cid=$uInfo->uid;
            if(!isset($order_info->item["id"]) || !isset($order_info->qty) || !isset($order_info->item["price"]))
                return ["msg" => "Something went wrong!!","status" => 0];
            $pid=$order_info->item["id"];$qty=$order_info->qty;$price=$order_info->item["price"];
            $cdate=Common::getCurrentDateTime();
            $order_id=$cid.strtotime($cdate);
            $sql="INSERT INTO orders (customer_id, order_id,product_id,qty,price,created_at) VALUES (?,?,?,?,?,?)";
            $values=[$cid, $order_id,$pid,$qty,$price,$cdate];
            $isCreate=$this->db->queryExecute($sql,$values);
            return ["msg" => "Success","status" => 1];
        }
        public function updateOrderStatus($tokenInfo,$info){
            $status=$info->statusId;$inv_id=$info->orderId;
            $sql="update orders set order_status=? where id=?";
            $values=[$status,$inv_id];
            $this->db->queryExecute($sql,$values);
            $oInfo =self::getMyOrders($tokenInfo);
            $oInfo["status"]=1;$oInfo["msg"]="Success";
            return $oInfo;
        }
        public function getMyOrders($uInfo){
            $values=[];
            $sql="select o.*,s.name as status_name from orders as o 
                join order_status_details as s on o.order_status=s.id order by o.id desc";
            if($uInfo->role_id == 2)
            {
                $sql = "select o.*,s.name as status_name from orders as o 
                        join order_status_details as s on o.order_status=s.id
                            where o.customer_id= ? order by o.id desc";
                $values[]=$uInfo->uid;
            }
            $result_data=$this->db->getInfo($sql,$values,1);
            $rows=[];$todaysOrder=[];$araStatus=[];
            foreach($result_data as $row)
            {
                $araStatus[$row["order_status"]][]=$row;
                $rows[] = $row;
                if(Common::convertDateTimeToDate($row["created_at"]) == Common::getCurrentDate())
                    $todaysOrder[]=$row;
            }
            $returnInfo["orders_today"]=$todaysOrder;
            $returnInfo["orderStatuses"]=$this->db->getOrderStatuses();;
            $returnInfo["orders"]=$rows;
            $returnInfo["orderByStatus"]=$araStatus;
            return $returnInfo;
        }
    }