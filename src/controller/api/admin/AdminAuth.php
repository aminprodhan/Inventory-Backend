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
            $username = $convJson->user_signin_name;
            $passwrod = $convJson->user_signin_password;
            $info = Admins::isValidUser($username, $passwrod);
        }
        echo json_encode($info);

    ?>