<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/29/2019
 * Time: 8:14 AM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include("../../../include/functions.php");
include("../../authorization.php");

$object = new Functions();

$data = json_decode(file_get_contents("php://input"));

// set customer property values
$object->customer_name = $data->name;
$object->customer_phone = $data->phone;
$object->customer_email = $data->email;

$authorization = new Authorization();
$token = $authorization->getBearerToken();

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT') != 0){

    echo '{';
    echo ('"response": "Request method must be PUT!"');
    http_response_code(400);
    echo '}';

}
else{

    if($token) {

        $object->customerID = isset($_GET['customerID']) ? $_GET['customerID'] : die();

        if($object->getCustomerID() == $object->customerID){
            // update the customer
            $result = $object->updateCustomer();
            if($result == true){
                echo '{';
                echo '"response": "Your account has been updated successfully."';
                http_response_code(200);
                echo '}';
            } // if unable to create the customer, tell the client
            else {
                echo '{';
                echo '"response": "Oops, Unable to updated account."';
                http_response_code(400);
                echo '}';
            }
        }
        else{
            echo '{';
            echo '"response": "Customer ID not found!"';
            http_response_code(400);
            echo '}';
        }

    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}