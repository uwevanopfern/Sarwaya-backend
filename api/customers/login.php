<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/28/2019
 * Time: 8:27 AM
 */
include_once '../core.php';
include_once '../../jwt/BeforeValidException.php';
include_once '../../jwt/ExpiredException.php';
include_once '../../jwt/SignatureInvalidException.php';
include_once '../../jwt/JWT.php';
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// database connection will be here

include("../../include/functions.php");
include("../authorization.php");


$object = new Functions();
$authorization = new Authorization();
$token = $authorization->getBearerToken();

$data = json_decode(file_get_contents("php://input"));

// set customer property values
$phone = $data->phone;
$password = $data->password;

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){

    echo '{';
    echo ('"response": "Request method must be POST!"');
    http_response_code(400);
    echo '}';

}else{

    if($token){
//        $payload = JWT::decode($token, BEARER_TOKEN, ['HS256']);
//
//        // Access is granted. Add code of the operation here
//
//        echo json_encode(array(
//            "message" => "Access granted:",
//            "error" => $e->getMessage()
//        ));
        // login Customer
        $result = $object->loginCustomer($phone, $password);
        $num = $result->rowCount();
        if($num > 0){
            $data = array();
            $data['data'] = array();
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $customer_id = $row['customer_id'];
                $customer_name = $row['customer_name'];
                $customer_phone = $row['customer_phone'];
                $customer_email = $row['customer_email'];

                $user_object = array(
                    "customer_id" =>  $customer_id,
                    "customer_name" =>  $customer_name,
                    "customer_phone" => $customer_phone,
                    "customer_email" => $customer_email,
                );
                array_push($data["data"], $user_object);
                echo json_encode($data);
                http_response_code(200);
            }

        }else{
            echo '{';
            echo ('"response": "FAILED"');
            http_response_code(403);
            echo '}';
        }
    }
    else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}
