    <?php
        require '../../../../vendor/autoload.php';
        use App\models\Admins;
        $info=["status" => 0, "msg" => "something went wrong!!!"];
        $jasonarray = json_decode(file_get_contents('php://input'),true);
        if(isset($jasonarray["data"])) {
            $convJson = (object)$jasonarray["data"];
            $auth = new Admins();
            $info = $auth->isValidUser($convJson);
        }
        echo json_encode($info);

    ?>