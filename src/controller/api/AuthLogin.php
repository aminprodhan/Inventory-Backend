<?php
    require '../../../vendor/autoload.php';
    use App\models\User;
    $info=["status" => 0, "msg" => "something went wrong!!!"];
    $jasonarray = json_decode(file_get_contents('php://input'),true);
    if(isset($jasonarray["data"])) {
        $auth=new User();
        $convJson = (object)$jasonarray["data"];
        $info = $auth->isValidUser($convJson);
    }
    echo json_encode($info);

?>