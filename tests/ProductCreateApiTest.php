<?php
    namespace Inventory\PhpApi\Tests;
    use App\DBConn;
    use GuzzleHttp\Client;
    use PHPUnit\Framework\TestCase;
    use App\ApiTest;
    class ProductCreateApiTest extends TestCase{
        private $api;private $client;private  $db;
        protected function setUp(): void
        {
            parent::setUp(); // TODO: Change the autogenerated stub
            $this->db=new DBConn();
            $this->db->dbTruncate();
            $this->api=new ApiTest();
            $this->client = new Client([
                'base_uri' => $this->api->serverApi,
                'timeout'  => 2.0,
            ]);
        }
        public function test_product_create()
        {

            $httpApi=$this->api->apiProductCreate();
            $name=$httpApi["data"]["data"]["name"];
            for($i=1;$i<=50;$i++) {
                $cate_id=rand ( 1 , 3);
                $price=rand ( 100 , 2000);
                $httpApi["data"]["data"]["name"]=$name."-".$i;
                $httpApi["data"]["data"]["categoryId"]=$cate_id;
                $httpApi["data"]["data"]["price"]=$price;
                $httpApi["data"]["data"]["sku"]=$i;

                $request = $this->client->request('POST', $httpApi["api"], ['body' => json_encode($httpApi["data"])]);
                $decodeData = json_decode($request->getBody(true));
                $this->assertSame(1, $decodeData->status);
            }
        }
        public function test_product_update()
        {
            $httpApi=$this->api->apiProductUpdate();
            $request = $this->client->request('POST', $httpApi["api"], ['body' => json_encode($httpApi["data"])]);
            $decodeData=json_decode($request->getBody(true));
            $this->assertSame(1,$decodeData->status);
        }
        protected function tearDown(): void
        {
            parent::tearDown(); // TODO: Change the autogenerated stub
            $this->client=null;
        }
}