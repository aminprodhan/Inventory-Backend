<?php
namespace App;
use \Firebase\JWT\JWT;
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
    public function getCategories(){
        $sql="select * from inventory_categories where status=1 and root_id=0";
        $result_data = $this->connection->query($sql)->fetch_assoc();
        return $result_data;
    }
    public function myOrders($uid,$type){
        $sql="select * from inventory_categories where status=1 and root_id=0";
        $result_data = $this->connection->query($sql)->fetch_assoc();
        return $result_data;
    }
    public function isValidLogin($sql){
        $data=array(
            "token_id" => 0,
        );
        $result_data = $this->connection->query($sql)->fetch_assoc();
        if (!empty($result_data["id"]))
        {
            $result_data;$msg="Success";$status=1;
            $key = "amincpi";
            $payload = array(
                "uid" => $result_data["id"]
            );
            $data=array(
                "role_id" => $result_data["role_id"],
                "name" => $result_data["name"],
                "token_id" => JWT::encode($payload, $key),
                "orders" => self::myOrders($result_data["id"],$result_data["role_id"]),
            );

        }
        return $data;
    }
}

?>
