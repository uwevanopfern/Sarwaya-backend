<?php
/**
* Created by PhpStorm.
* User: User
* Date: 6/28/2019
* Time: 8:27 AM
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");

include("../../include/functions.php");
include("../authorization.php");

$object = new Functions();
$authorization = new Authorization();
$token = $authorization->getBearerToken();

$data = json_decode(file_get_contents("php://input"));

// set customer property values
$object->customer_name = $data->name;
$object->customer_phone = $data->phone;
$object->customer_email = $data->email;
$object->customer_password = $data->password;

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){

    echo '{';
    echo ('"response": "Request method must be POST!"');
    http_response_code(400);
    echo '}';

}else{

    if($token) {

        $checkCustomerPhone = $object->checkCustomerPhoneExistance($data->phone);
        $checkCustomerEmail = $object->checkCustomerEmailExistance($data->email);
        if ($checkCustomerPhone) {
            echo '{';
            echo('"response": "Phone number already exists, try new one"');
            http_response_code(400);
            echo '}';
        }elseif($checkCustomerEmail){
            echo '{';
            echo('"response": "Email already exists, try new one"');
            http_response_code(400);
            echo '}';
        } else {
            // create the customer
            if ($object->registerCustomer()) {
                echo '{';
                echo '"response": "Your account has been registered successfully."';
                http_response_code(201);
                echo '}';
            } // if unable to create the customer, tell the client
            else {
                echo '{';
                echo '"response": "Oops, Unable to create account."';
                http_response_code(400);
                echo '}';
            }
        }
    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}
