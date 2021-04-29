<?php
namespace App;
use \Firebase\JWT\JWT;
use App\Common;
use PDO;
class DBConn
{
    public $connection;
    protected $query;
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
    public function dbTruncate(){
        $sql="TRUNCATE TABLE `products`";
        self::queryExecute($sql,[]);
        $sql="TRUNCATE TABLE `orders`";
        self::queryExecute($sql,[]);
    }
    public function queryExecute($sql,$values){

        $cdate=Common::getCurrentDateTime();
        $stmt =$this->connection->prepare($sql);
        $stmt->execute($values);
        $stmt=null;
        return 1;
    }
    public function getOrderStatuses(){
        $sql="select * from order_status_details order by sort_id asc";
        return self::getInfo($sql,[],1);
    }
    public function getInfo($sql,$values,$is_all=0){
        $stmt =$this->connection->prepare($sql);
        $stmt->execute($values);
        $results=$is_all > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch();
        $stmt=null;
        return $results;
    }
    public function getProducts(){
        $sql="select p.*,c.`category_name`  from products as p join
             inventory_categories as c on p.category_id=c.id where p.status=? and p.trash=? order by p.id desc";
        return self::getInfo($sql,[1,1],1);
    }
    public function getCategories(){
        $sql="select * from inventory_categories where status=? and root_id=?";
        return self::getInfo($sql,[1,0],1);
    }
    public function isValidLogin($table,$username,$password,$role_id){
        $data=array(
            "token_id" => 0,
        );
        $sql = "SELECT * FROM ".$table." WHERE status=? and user_name=? and password=? and role_id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([1,$username,$password,$role_id]);
        $result_data=$stmt->fetch();
        $stmt=null;
        if (!empty($result_data["id"]))
        {
            $result_data;$msg="Success";$status=1;
            $payload =[
                "uid" => $result_data["id"],
                "role_id" => $result_data["role_id"],
            ];
            $data["role_id"]=$result_data["role_id"];
            $data["name"]=$result_data["name"];
            $data["token_id"]=Common::encrypttData($payload);
        }
        return $data;
    }
}

?>
