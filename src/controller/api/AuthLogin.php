<?php
    require '../../../vendor/autoload.php';
    use App\models\User;
    $jasonarray = json_decode(file_get_contents('php://input'),true);
    $convJson=(object)$jasonarray["reqData"];
    $username=$convJson->user_signin_name;
    $passwrod=$convJson->user_signin_password;
    $info=User::isValidUser($username,$passwrod);
    echo json_encode($info);

?>