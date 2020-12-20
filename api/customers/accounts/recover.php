<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/28/2019
 * Time: 8:27 AM
 */

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include("../../../include/functions.php");
include("../../authorization.php");

$object = new Functions();

$data = json_decode(file_get_contents("php://input"));

// set customer property values
$incomeEmail = $data->email;

$authorization = new Authorization();
$token = $authorization->getBearerToken();

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){

    echo '{';
    echo ('"response": "Request method must be POST!"');
    http_response_code(400);
    echo '}';
}
else{

    if($token) {

        $result = $object->sendRecoveryToCustomer($incomeEmail);
        if ($result == true) {
            echo '{';
            echo '"response": "Check link sent on your email."';
            http_response_code(200);
            echo '}';
        }
        else {
            echo '{';
            echo '"response": "Oops, Unable to send you a link, try again."';
            http_response_code(400);
            echo '}';
        }

    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}