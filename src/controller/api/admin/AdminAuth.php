    <?php
        require '../../../../vendor/autoload.php';
        use App\models\Admins;
        $info=array(
            "status" => 0,
            "msg" => "something went wrong!!!",
        );
        $jasonarray = json_decode(file_get_contents('php://input'),true);
        if(isset($jasonarray["data"])) {
            $convJson = (object)$jasonarray["data"];
            if(!empty($convJson->username) && !empty($convJson->password)) {
                $auth = new Admins();
                $username = $convJson->username;
                $passwrod = $convJson->password;
                $info = $auth->isValidUser($username, $passwrod);
            }
        }
        echo json_encode($info);

    ?>