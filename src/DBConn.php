<?php
namespace App;
use \Firebase\JWT\JWT;
use App\Common;
use PDO;
class DBConn
{
    //https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection
    //https://websitebeaver.com/php-pdo-prepared-statements-to-prevent-sql-injection

    public $connection;
    protected $query;
    protected $show_errors = TRUE;
    protected $query_closed = TRUE;
    public $query_count = 0;
    private  $sDbHost = 'localhost';
    private $sDbName = 'inv_orders';
    private $sDbUser = 'root';
    private $sDbPwd = '';
    public function __construct( $charset = 'utf8')
    {
        $dsn = "mysql:host=$this->sDbHost;dbname=$this->sDbName;charset=utf8mb4";
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];
        try {
            $this->connection = new PDO($dsn, $this->sDbUser, $this->sDbPwd, $options);
        } catch (Exception $e) {
            error_log($e->getMessage());
            exit('Something weird happened'); //something a user can understand
        }

    }
    public function saveProduct($sql,$values){

        $cdate=Common::getCurrentDateTime();
        $stmt =$this->connection->prepare($sql);
        $stmt->execute($values);
        $stmt=null;
        return 1;
    }
    public function updateMyOrderStatus($tokenInfo,$info){
        $status=$info->statusId;$inv_id=$info->item["id"];
        $sql="update orders set order_status=? where id=?";
        $stmt =$this->connection->prepare($sql);
        $stmt->execute([$status,$inv_id]);
        $stmt=null;
        return self::getMyOrders($tokenInfo);
    }
    public function getOrderStatuses(){
        $sql="select * from order_status_details order by sort_id asc";
        $stmt =$this->connection->prepare($sql);
        $stmt->execute();
        $result_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt=null;$rows=[];
        foreach($result_data as $row)
            $rows[] = $row;
        return $rows;
    }
    public function getMyOrders($uInfo){
        $sql="select o.*,s.name as status_name from orders as o 
                join order_status_details as s on o.order_status=s.id order by o.id desc";
        if($uInfo->role_id == 2) {
            $sql = "select o.*,s.name as status_name from orders as o 
                        join order_status_details as s on o.order_status=s.id
                            where o.customer_id= ? order by o.id desc";
        }
        $stmt =$this->connection->prepare($sql);
        if($uInfo->role_id == 2)
            $stmt->execute([$uInfo->uid]);
        else
            $stmt->execute();
        $result_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt=null;
        $rows=[];$todaysOrder=[];$araStatus=[];
        foreach($result_data as $row)
            {
                $araStatus[$row["order_status"]][]=$row;
                $rows[] = $row;
                if(Common::convertDateTimeToDate($row["created_at"]) == Common::getCurrentDate())
                    $todaysOrder[]=$row;
            }
        $ara=["all" => $rows,"todays"=>$todaysOrder,"order_by_status" => $araStatus];
        return $ara;
    }
    public function makeOrder($uInfo,$order_info){
        $cid=$uInfo->uid;
        $pid=$order_info->item["id"];$qty=$order_info->qty;$price=$order_info->item["price"];
        $cdate=Common::getCurrentDateTime();
        $order_id=$cid.strtotime($cdate);
        $stmt =$this->connection->prepare("INSERT INTO orders (customer_id, order_id,
                                                product_id,qty,price,created_at) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$cid, $order_id,$pid,$qty,$price,$cdate]);
        $stmt=null;
        return 1;
    }
    public function updateTableData($table,$colUpdate=null,$colWhereParams=null){
        $whereCol="1";$defColUpdate="";
        if(!empty($colWhereParams)){
            foreach ($colWhereParams as $key => $val){
                $whereCol=$whereCol." and ".$key."='".$val."' ";
            }
        }
        $araUpdateCol=array();
        if(!empty($colUpdate)){
            foreach ($colUpdate as $key => $val){
                $araUpdateCol[]=" ".$key."='".$val."'";
            }
        }
        $araUpdateCol=implode(',',$araUpdateCol);
        $sql="update ".$table."  set ".$araUpdateCol." where ".$whereCol."";
        //return $sql;
        $status=$this->connection->query($sql);
        return $status;
    }
    public function getInfo($table,$col=null,$colNotIn=null){
        $whereCol="1";$def_not_in="";
        if(!empty($col)){
            foreach ($col as $key => $val){
                $whereCol=$whereCol." and ".$key."='".$val."' ";
            }
        }
        if(!empty($colNotIn)){
            foreach ($colNotIn as $key => $val) {
                $def_not_in = $def_not_in . " and " . $key . " not in (" . $val . ") ";
            }
        }
        $sql="select * from ".$table." where ".$whereCol." ".$def_not_in." ";
        $result_data = $this->connection->query($sql)->fetch_assoc();
        return $result_data;
    }
    public function getProducts(){
        $sql="select p.*,c.`category_name`  from products as p join
             inventory_categories as c on p.category_id=c.id where p.status=? and p.trash=?";
        $stmt =$this->connection->prepare($sql);
        $stmt->execute([1,1]);
        $result_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rows=[];
        foreach($result_data as $row)
        {
            $rows[] = $row;
        }
        return $rows;
    }
    public function getCategories(){

        $sql="select * from inventory_categories where status=? and root_id=?";
        $stmt =$this->connection->prepare($sql);
        $stmt->execute([1,0]);
        $result_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rows=[];
        foreach($result_data as $row)
        {
            $rows[] = $row;
        }
        return $rows;
    }
    public function myOrders($uid,$type){
        $sql="select * from inventory_categories where status=1 and root_id=0";
        $result_data = $this->connection->query($sql)->fetch_assoc();
        return $result_data;
    }
    public function isValidLogin($table,$username,$password,$role_id){
        $data=array(
            "token_id" => 0,
            "role_id" => 0,
        );
        $sql = "SELECT * FROM ".$table." WHERE status=? and user_name=? and password=? and role_id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([1,$username,$password,$role_id]);
        $result_data=$stmt->fetch();
        $stmt=null;
        if (!empty($result_data["id"]))
        {
            $result_data;$msg="Success";$status=1;
            $payload = array(
                "uid" => $result_data["id"],
                "role_id" => $result_data["role_id"],
            );
            $data=array(
                "role_id" => $result_data["role_id"],
                "name" => $result_data["name"],
                "token_id" => Common::encrypttData($payload),
                //"orders" => self::myOrders($result_data["id"],$result_data["role_id"]),
            );

        }
        return $data;
    }
}

?>
