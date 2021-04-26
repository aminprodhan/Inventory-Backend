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
        /*$this->connection = new \mysqli($this->sDbHost, $this->sDbUser, $this->sDbPwd, $this->sDbName);
        if ($this->connection->connect_error) {
            $this->error('Failed to connect to MySQL - ' . $this->connection->connect_error);
        }
        $this->connection->set_charset($charset);*/

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
    public function saveProduct($sql){
        $this->connection->query($sql);
    }
    public function makeOrder($uInfo,$order_info){
        $cid=$uInfo->uid;
        $pid=$order_info->item["id"];$qty=$order_info->qty;
        $cdate=Common::getCurrentDateTime();
        $order_id=strtotime($cdate).$cid;
        $stmt =$this->connection->prepare("INSERT INTO orders (customer_id, order_id,
                                                product_id,qty,created_at) VALUES (?,?,?,?,?)");

        $stmt->execute([$cid, $order_id,$pid,$qty,$cdate]);
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
    public function isValidLogin($sql){
        $data=array(
            "token_id" => 0,
            "role_id" => 0,
        );
        $result_data = $this->connection->query($sql)->fetch_assoc();
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
                "orders" => self::myOrders($result_data["id"],$result_data["role_id"]),
            );

        }
        return $data;
    }
}

?>
