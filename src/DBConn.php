<?php
namespace App;
use \Firebase\JWT\JWT;
use App\Common;
class DBConn
{

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
        $this->connection = new \mysqli($this->sDbHost, $this->sDbUser, $this->sDbPwd, $this->sDbName);
        if ($this->connection->connect_error) {
            $this->error('Failed to connect to MySQL - ' . $this->connection->connect_error);
        }
        $this->connection->set_charset($charset);
    }
    public function saveProduct($sql){
        $this->connection->query($sql);
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
             inventory_categories as c on p.category_id=c.id where p.status=1 and p.trash=1";
        $result_data = $this->connection->query($sql);
        $rows=[];
        while($row = $result_data->fetch_assoc())
        {
            $rows[] = $row;
        }
        return $rows;
    }
    public function getCategories(){
        $sql="select * from inventory_categories where status=1 and root_id=0";
        $result_data = $this->connection->query($sql);
        while($row = $result_data->fetch_assoc())
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
