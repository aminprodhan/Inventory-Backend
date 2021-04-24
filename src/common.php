
<?php 

        function getDeliveryChargeInfo(){
            
            include("../config.php");
            $res["deliveryCharge"]=array();
            
            $sql="SELECT * FROM `tbl_delivery_charge_info` WHERE status=1";
            $result_data = $con->query($sql)->fetch_assoc();

            $ara=array(
                    "min_amount" => $result_data["min_buy_amount"],
                    "d_charge" => $result_data["amount"],
                    "reduce_amount" => $result_data["reduce_amt"],
                );
            return $ara;
        }
        function getCountTotalService($sid,$uid)
        {
            include("../config.php");
            
            $sql="SELECT count(cart_id) as tservice FROM `tbl_cart_info` WHERE trace=0 and inv_id=0 and posting_by='".$uid."' and service_id='".$sid."'";
            
             $result_data = $con->query($sql)->fetch_assoc();
             return $result_data;
        }
        
         function getRootDepartmentFromLed($ph_id){
             include("../config.php");
            $sql="SELECT * from setting as s JOIN (
                SELECT substr(accounts_id,1,11) as aid FROM `ledger` 
                   WHERE parent_head_id='".$ph_id."' and trace=0 limit 1) as t on s.accounts_id=t.aid WHERE s.trace=0";
                   
              $result_data = $con->query($sql)->fetch_assoc();
             return $result_data["id"];
        }
         function getRootDepartmentFromServiceLed($sid){
             include("../config.php");
            $sql="SELECT t.*,s.id as sid,s.name as sname,s.has_d_charge as dcharge from setting as s JOIN (
                SELECT l.*,substr(accounts_id,1,11) as aid FROM `ledger` as l
                   WHERE id='".$sid."' and trace=0 limit 1) as t on s.accounts_id=t.aid WHERE s.trace=0";
                   
              $result_data = $con->query($sql)->fetch_assoc();
             return $result_data;
        }
        
        function getOrderNumber(){
            return 113322;
        }
        
        function getOrderListByStatus($status,$start,$uid){
            include("../config.php");
            $sql="select * from tbl_cart_invoice as tci 
               where status='".$status."' 
                and posting_by='".$uid."' 
                order by inv_id desc limit ".$start.",15 ";
            
            $res["clist"]=array();
            $result_data = $con->query($sql);	
        	while($row= $result_data->fetch_assoc())
        		{ 
        		    $ara=array();
        		    $ara["inv_id"]=$row["inv_id"];
        		    $ara["gross_amount"]=round(($row["gross_amount"] + $row["dcharge"]) - ($row["discount_amount"]+$row["others_discount"]),2);
        		    $ara["discount_amount"]=$row["discount_amount"];
        		    $ara["date_time"]=$row["date_time"];
        		    $ara["name"]=$row["name"];
        		    $ara["mobile"]=$row["mobile"];
        		    $ara["order_number"]=$row["order_number"];
        		    $ara["email"]=$row["email"];
        		    $ara["address"]=$row["address"];
        		    $ara["status"]=$row["status"];
        		    array_push($res["clist"],$ara);
        		}
        		
        	$sql="select count(inv_id) as tsc from tbl_cart_invoice as tci where status='".$status."' and posting_by='".$uid."' ";
            $result_data = $con->query($sql)->fetch_assoc();		
        	$res["tsc"]=$result_data["tsc"];	
        	return $res;
        }
     
        
        
         function getGroupByInfo($gid){
             
            include("../config.php");
            
            $sql="
            
            select t.*,sp.price from tbl_service_price as sp join (
            SELECT REPLACE(GROUP_CONCAT(sp.cate_name),',','<br/>') as r_name FROM tbl_service_category as sp JOIN (
                    SELECT n.price, SUBSTRING_INDEX(SUBSTRING_INDEX(n.cate_id, ',', n.digit+1), ',', -1)  as val FROM tbl_service_price as n INNER JOIN (
                                      SELECT 0 digit 
                                      	UNION ALL 
                                      SELECT 1 
                                        UNION ALL 
                                      SELECT 2 
                                         UNION ALL 
                                      SELECT 3  
                                         UNION ALL 
                                      SELECT 4 
                                         UNION ALL 
                                      SELECT 5 
                                         UNION ALL 
                                      SELECT 6
                                        UNION ALL 
                                      SELECT 7 
                                        UNION ALL 
                                      SELECT 8 
                                         UNION ALL 
                                      SELECT 9  
                                         UNION ALL 
                                      SELECT 10 
                                         UNION ALL 
                                      SELECT 11
                                         UNION ALL 
                                      SELECT 12
                                     ) n
                            		    ON LENGTH(REPLACE(n.cate_id, ',' , '')) <= LENGTH(n.cate_id)-n.digit 
                                    	WHERE n.group_id='".$gid."' and n.trace='0'
                                	) as t on sp.cate_id=t.val
                                    	left JOIN tbl_service_category as sp_root on sp.root=sp_root.cate_id 
                                    	WHERE sp.trace=0 and sp_root.trace=0 ) as t on sp.group_id='".$gid."' and sp.trace='0' ";
                                    	
             $result_data = $con->query($sql)->fetch_assoc();
             return $result_data;
            
        }
        
        
        function getCartIdList($status=0,$uid){
            
            include("../config.php");
            
            $sql="SELECT cart_id as cid,service_id as sid FROM `tbl_cart_info` WHERE trace=0 and inv_id=0 and posting_by='".$uid."'";
            $result_data = $con->query($sql);	
        	return $result_data;
            
        }
        
        function getCountPendingInv($uid,$default_link=0){
            if(empty($default_link))
                include("config.php");
            else
                include("../config.php");
                
            $sql="SELECT count(cart_id) as total_service FROM `tbl_cart_info` WHERE posting_by='".$uid."' and inv_id=0 and trace=0";
            
            $result_data = $con->query($sql)->fetch_assoc();
             return $result_data["total_service"];
        }
       
        function getGrossCartAmount($uid)
        {
            include("../config.php");
            $sql="SELECT sum(amount) as total_price,sum(discount) as total_discount from (
                	SELECT sum(qty*price) as amount,sum(((qty*price)*discount)/100) as discount FROM `tbl_cart_info` 
                		WHERE posting_by='".$uid."' and inv_id='0' and trace='0' GROUP by cart_id ) as t";
                		
             $result_data = $con->query($sql)->fetch_assoc();
             return $result_data; 		
                		
        }
        function getServicePrice($gid){
            
            include("../config.php");
            
            $sql="select * from tbl_service_price 
                    where group_id='".$gid."' and trace='0'";
             $result_data = $con->query($sql)->fetch_assoc();
             return $result_data;
            
        }
        
        function getAnyRowInfo($table,$col,$val,$col2=null,$val2=null,$limit=null){
            
            include("../config.php");
            
            $is_limit="";
            if(!empty($limit))
                $is_limit=" limit ".$limit." ";
            
            $sc="";
            if(!empty($col2)){
                $sc=" and ".$col2."= '".$val2."' ";
            }
            
            $sql="select * from ".$table." 
                    where ".$col."='".$val."'  ".$sc." and trace='0' ".$is_limit." ";
             $result_data = $con->query($sql)->fetch_assoc();
             return $result_data;
            
        }
        
       
     function addToCart($group_id,$qty,$uid,$service_id){
         
         include("../config.php");
         
         $s_type=0;
    	$getServiceInfo=getServiceInfo($service_id);
    	if(!empty($getServiceInfo["list_type"]))
    	    $s_type=$getServiceInfo["list_type"];
         
         $price=0;

         $min_qty=0;
        if($s_type == 2){
            $qty=$getServiceInfo["opening_balance"];
            $price=$getServiceInfo["srate"];
        }
        
        if(!empty($getServiceInfo["opening_balance"])){
            $min_qty=$getServiceInfo["opening_balance"];

        }
             $date_time=getCurrentDateTime();
             $priceInfo=getServicePrice(trim($group_id));
	        if(!empty($priceInfo["pid"]))
	        {
	            //$qty=$l["value"]; //qty
	            /*$min_qty=$priceInfo["min_qty"];
	            if($min_qty < $qty && !empty($min_qty))
	                $qty=$min_qty;*/
	             
	             $price=$priceInfo["price"];   
	             
	             
	             
	        }
            
             $sql="insert into tbl_cart_info(price_id,date_time,pdate,price,qty,posting_by,device_name,service_id,service_type,min_qty) values ('".$group_id."','".$date_time."','".date('Y-m-d')."','".$price."','".$qty."','".$uid."','1','".$service_id."','".$s_type."','".$min_qty."')";
             
            if(!empty($price))
                $con->query($sql);
            
        }
        
        function getCurrentDateTime(){
            $date_time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $hours=$date_time->format('G'); 
            $date_time=$date_time->format('Y-m-d G:i:s');
            return $date_time;
        }
        
        function getServiceInfo($sid){
            
            include("../config.php");
            
            $sql="select * from ledger 
                where id='".$sid."' and trace='0' ";
            $result_data = $con->query($sql)->fetch_assoc();
            
            return $result_data;
            
        }
        
        function getCartStatus($status=0){
            $ara=array(
                    "1" => "Cancel Req. Pending",
                    "2" => "Accepted",
                    "3" => "Cancel By Admin",
                    "4" => "Cancel Accepted",
                );
            
            return $ara[$status];
        }
        
        function getPaymentTypeText($pay_id){
            
            $raw_info=getAnyRowInfo("tbl_payment_type_list","pay_id",$pay_id,"status","1");
    	
    	    $pay_name="Unknown";
    	    if(!empty($raw_info["name"]))
    	        $pay_name=$raw_info["name"];

            return $pay_name;
           
        }
        
        function getProductFromCart($uid,$oid=0,$sid=0){
            
            include("../config.php");
     
            $order_id=" and inv_id='0'";
            $sid_info="";
            if(!empty($oid)){
                $order_id=" and inv_id='".$oid."'";
            }
            
            if(!empty($sid)){
                $sid_info=" and c.service_id='".$sid."'";
            }
            
            
            $sql="SELECT l.parent_head_id as ph_id, c.min_qty, c.cart_id,c.service_type,c.service_id, c.price_id,l.ledger_title as sname,
            c.price,c.qty,c.date_time,c.discount,c.status FROM `tbl_cart_info` as c 
                    JOIN ledger as l on c.service_id=l.id
                    WHERE c.trace='0' and c.posting_by='".$uid."' ".$order_id." ".$sid_info."  group by c.cart_id order by c.service_id,c.cart_id desc ";
	     //   echo $sql;
	        $total_amount=0;
	        $res["clist"]=array();
            $result_data = $con->query($sql);	
        	while($row_name= $result_data->fetch_assoc())
        		{ 
        		    
        		    
        		    
        		    $data=array();
        		    $total_amount=$total_amount+ ($row_name["price"] * $row_name["qty"]);
        		    
        		    $status_text=getCartStatus($row_name["status"]);
        		    $data["sub_list"]=array();
        		    
            		    $sql="SELECT sp_root.cate_name as r_name,sp.*,t.* FROM tbl_service_category as sp JOIN (
                            	SELECT n.price, SUBSTRING_INDEX(SUBSTRING_INDEX(n.cate_id, ',', n.digit+1), ',', -1)  as val
                                FROM
                                   tbl_service_price as n
                                     INNER JOIN
                                     	(
                                      SELECT 0 digit 
                                      	UNION ALL 
                                      SELECT 1 
                                        UNION ALL 
                                      SELECT 2 
                                         UNION ALL 
                                      SELECT 3  
                                         UNION ALL 
                                      SELECT 4 
                                         UNION ALL 
                                      SELECT 5 
                                         UNION ALL 
                                      SELECT 6
                                        UNION ALL 
                                      SELECT 7 
                                        UNION ALL 
                                      SELECT 8 
                                         UNION ALL 
                                      SELECT 9  
                                         UNION ALL 
                                      SELECT 10 
                                         UNION ALL 
                                      SELECT 11
                                         UNION ALL 
                                      SELECT 12
                                     ) n
                            		    ON LENGTH(REPLACE(n.cate_id, ',' , '')) <= LENGTH(n.cate_id)-n.digit 
                                    	WHERE n.group_id='".$row_name["price_id"]."' and n.trace='0'
                                	) as t on sp.cate_id=t.val
                                    	left JOIN tbl_service_category as sp_root on sp.root=sp_root.cate_id 
                                    	WHERE sp.trace=0 and sp_root.trace=0 ";
                    	
                    	        $j=0;
                    	        $cate_name="";
                            	$result_list = $con->query($sql);	
                            	while($row= $result_list->fetch_assoc())
                            		{ 
                            		    $j++;
                            		    $cate_name=$cate_name.".".$row["cate_name"]."<br>";
                            		}
                            	if($row_name["service_type"] == 2)
                            	    {
                            	        $j=1;
                            	        $cate_name="Quantity";
                            	    }
                            	  
                            	    
            		if(!empty($j)){
            		    
            		    $list=array();
                        $list["root_id"]=0;
    		            $list["cate_id"]=$row_name["cart_id"];
    		            $list["root_name"]="";
    		            $list["cate_name"]=$cate_name;
    		            $list["qty"]=$row_name["qty"];
    		            $list["price_id"]=$row_name["price_id"];
    		            $list["price"]=$row_name["price"];
    		            $list["discount"]=0;
    		            $list["sid"]=$row_name["service_id"];
            		    $list["min_qty"]=$row_name["min_qty"];
    		            $list["status_text"]=$status_text;

    		            array_push($data["sub_list"],$list);
            		}
                            		
                    
                    if(in_array($row_name["service_id"], array_column($res["clist"], 'sid'))) {
                        
                        $key=array_search($row_name["service_id"], array_column($res["clist"], 'sid'));
                        //echo $key;
                        $list=array();
                        $list["root_id"]=0;
    		            $list["cate_id"]=$row_name["cart_id"];
    		            $list["ph_id"]=$row_name["ph_id"];
    		            $list["root_name"]="";
    		            $list["cate_name"]=$cate_name;
    		            $list["qty"]=$row_name["qty"];
    		            $list["price_id"]=$row_name["price_id"];
    		            $list["price"]=$row_name["price"];
    		            $list["discount"]=0;
    		            $list["status_text"]=$status_text;
    		            $list["sid"]=$row_name["service_id"];
    		            $list["min_qty"]=$row_name["min_qty"];
                        $data["unit"]=$ll["unit"];
    		            array_push($res["clist"][$key]["sub_list"],$list);
                        //$ara=$res["clist"][$key]["sub_list"] +  $list;
                        //echo print_r($ara)."<br><br>";
                    }
                    else{
                        
                        $ll=getServiceInfo($row_name["service_id"]);
            		    $data["cart_id"]=$row_name["cart_id"];
            		    $data["price_id"]=$row_name["price_id"];
            		    $data["sname"]=$row_name["sname"];
            		    $data["price"]=$row_name["price"];
            		    $data["qty"]=$row_name["qty"];
            		    $data["date_time"]=$row_name["date_time"];
            		    $data["sid"]=$row_name["service_id"];
            		    $data["min_qty"]=$row_name["min_qty"];
            		    $data["spic"]=$ll["spic"];
            		    $data["unit"]=$ll["unit"];
            		    $data["discount"]=$row_name["discount"];
            		    $data["ph_id"]=$ll["parent_head_id"];

                        array_push($res["clist"],$data);
                    }
                    	
        		    
        		}
        		
        	  
        	  $sql="SELECT count(cart_id) as total_service FROM `tbl_cart_info` as c WHERE posting_by='".$uid."' ".$order_id." $sid_info and trace=0";
            
              $result_data = $con->query($sql)->fetch_assoc();
              $res["total_service"]=$result_data["total_service"];
        		
        		$res["total_amount"]=$total_amount;
        		$res["total_discount"]=0;
        		$res["net_amount"]=$total_amount;
	          
	        if(!empty($oid)){
	            $sql="select * from tbl_cart_invoice as tci where inv_id='".$oid."' and trace='0'  ";
	            $result_data = $con->query($sql);
	            $res["inv_info"]=array();
                while($row= $result_data->fetch_assoc())
        		{ 
        		    $ara=array();
        		    $ara["inv_id"]=$row["inv_id"];
        		    $ara["ga"]=round($row["gross_amount"],2);
        		    $ara["dc"]=$row["discount_code"];
        		    $ara["others_discount"]=$row["others_discount"];
        		    $ara["da"]=round($row["discount_amount"],2);
        		    $ara["na"]=round(($row["gross_amount"] + $row["dcharge"]) - ($row["discount_amount"]+$row["others_discount"]),2);
        		    $ara["name"]=$row["name"];
        		    $ara["mobile"]=$row["mobile"];
        		    $ara["email"]=$row["email"];
        		    $ara["address"]=$row["address"];
        		    $ara["status"]=$row["status"];
        		    $ara["on"]=$row["order_number"];
        		    $ara["sm"]=$row["dcharge"];
        		    
        		    $status="Due";
        		    if($row["paid_status"] == '2')
        		        $status="Paid";
        		  
        		    $pay_name=getPaymentTypeText($row["pay_type"]);
        		  
        		    $ara["status_txt"]=$status;
        		    $ara["pay_name"]=$pay_name;
        		    $ara["schedule_time"]=$row["schedule_time"];

        		    array_push($res["inv_info"],$ara);
        		}
	            
	       }  
	             
	        return $res;
            
        }


?>