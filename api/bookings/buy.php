<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/4/2019
 * Time: 10:33 AM
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include("../../include/functions.php");
include("../authorization.php");

$object = new Functions();

$data = json_decode(file_get_contents("php://input"));

// set customer property values
$bookingID = $data->bookingID;
$paymentPhone = $data->paymentPhone;
$paymentCost = (int)$data->paymentCost;

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

        $result = $object->getBookingDetails($bookingID);
        $num = $result->rowCount();
        $transactionID = rand();


        if($num > 0) {
            $result = $object->buyTicket($bookingID, $paymentPhone, $paymentCost, $transactionID);
            if ($result == true) {
                $payTicket = $object->paymentAPI($paymentPhone, $paymentCost, $transactionID);
                if($payTicket) {
                    echo '{';
                    echo '"response":'.json_encode($payTicket);
                    http_response_code(200);
                    echo '}';
                }
            } else {
                echo '{';
                echo '"response": "Oops, Unable to make payment."';
                http_response_code(400);
                echo '}';
            }
        }else{
            echo '{';
            echo '"response": "Oops, Booking ID not found"';
            http_response_code(400);
            echo '}';
        }
    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}