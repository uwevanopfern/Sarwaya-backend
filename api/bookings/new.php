<?php date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/28/2019
 * Time: 8:06 PM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");

include("../../include/functions.php");
include("../authorization.php");

$authorization = new Authorization();
$token = $authorization->getBearerToken();

$object = new Functions();

$data = json_decode(file_get_contents("php://input"));

$bookingUUID = (uniqid());
$format_UUID = implode('-', str_split($bookingUUID, 4));
// set booking property values
$object->bookingUUID = $bookingUUID;
$object->agencyID = $data->agencyID;
$object->scheduleID = $data->scheduleID;
$object->customerID = $data->customerID;
$object->bookingDate = date("Y-m-d");
$object->bookingTime = date("H:i:s");

$agency = $data->agencyID;
$schedule = $data->scheduleID;
$customer = $data->customerID;

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    echo '{';
    echo ('"response": "Request method must be POST!"');
    http_response_code(400);
    echo '}';

}else{
    if($token) {

        $result = $object->checkCustomerDuplicateBooking($agency, $schedule, $customer);
        $num = $result->rowCount();
        if($num){
            // Send notification email on admins of specific agency
            echo '{';
            echo ('"response": "Your booking already exists, Book another schedule"');
            http_response_code(400);
            echo '}';

        }else{

        // create the customer
            if($object->addNewBooking()){
                echo '{';
                echo '"response": "Your booking has been added successfully."';
                http_response_code(201);
                echo '}';
            }
            // if unable to create the customer, tell the client
            else {
                echo '{';
                echo '"response": "Oops, Unable to add new booking."';
                http_response_code(400);
                echo '}';
            }
        }
    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }

}
