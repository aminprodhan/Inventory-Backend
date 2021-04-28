<?php
    namespace Inventory\PhpApi\Tests;
    use GuzzleHttp\Client;
    use PHPUnit\Framework\TestCase;
    use App\ApiTest;
    class ProductCreateApiTest extends TestCase{
        private $api;private $client;
        protected function setUp(): void
        {
            parent::setUp(); // TODO: Change the autogenerated stub

            $this->api=new ApiTest();
            $this->client = new Client([
                'base_uri' => $this->api->serverApi,
                'timeout'  => 2.0,
            ]);
        }
        public function test_product_create()
        {
            $httpApi=$this->api->apiProductCreate();
            $request = $this->client->request('POST', $httpApi["api"], ['body' => json_encode($httpApi["data"])]);
            $decodeData=json_decode($request->getBody(true));
            $this->assertSame(1,$decodeData->status);
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