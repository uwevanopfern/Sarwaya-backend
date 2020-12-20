<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/29/2019
 * Time: 5:26 AM
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


$object = new Functions();

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
//            echo json_encode($data);
//            http_response_code(200);

            $token = array(
                "iss" => $iss,
                "aud" => $aud,
                "iat" => $iat,
                "nbf" => $nbf,
                "data" => array(
                    "customer_id" => $customer_id,
                    "customer_name" => $customer_phone,
                    "customer_phone" => $customer_phone,
                    "customer_email" => $customer_email
                )
            );

            // set response code
            http_response_code(200);

            // generate jwt
            $jwt = JWT::encode($token, $key);
            echo json_encode(
                array(
                    "message" => "Successful login.",
                    "jwt" => $jwt
                )
            );
        }

    }else{
        echo '{';
        echo ('"response": "Invalid credentials"');
        http_response_code(403);
        echo '}';
    }
}