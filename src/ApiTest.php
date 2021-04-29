<?php
    namespace App;
    class ApiTest{
        public $serverApi="http://localhost/";
        public function apiProductCreate(){
            $dataFormat= [
                "api" => $this->serverApi."Inventory-Backend/src/controller/api/admin/ProductCreate.php",
                "data" => [
                            "data" => [
                                        "name"=>"test",
                                        "desc"=>"test",
                                        "sku"=>"9",
                                        "categoryId"=>"3",
                                        "price"=>"42",
                                        "product_image"=>""
                                    ],
                            "tokenId" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOjEsInJvbGVfaWQiOjF9.iOTVIVDUurooLxrmy4YR0CjS1QnXVanGJyGUMhl0EHc"
                            ]
                    ];
            return $dataFormat;

        }
        public function apiProductUpdate(){
            $dataFormat= [
                "api" => $this->serverApi."Inventory-Backend/src/controller/api/admin/ProductUpdate.php",
                "data" => [
                    "data" => [
                        "name"=>"test","desc"=>"test","sku"=>"10","categoryId"=>3,"price"=>425,"product_image"=>"","isImgUpdate"=>false,"updateId"=>2
                    ],
                    "tokenId" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOjEsInJvbGVfaWQiOjF9.iOTVIVDUurooLxrmy4YR0CjS1QnXVanGJyGUMhl0EHc"
                ]
            ];
            return $dataFormat;

        }

    }
