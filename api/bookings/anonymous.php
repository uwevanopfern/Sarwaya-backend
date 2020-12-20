<?php date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/3/2019
 * Time: 6:17 PM
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
// set booking property values
$object->bookingUUID = $bookingUUID;
$object->agencyID = $data->agencyID;
$object->customerID = $data->customerID;
$object->preBookedDate = $data->customerDate;
$object->customerTime = $data->customerTime;
$object->locationID = $data->locationID;
$object->bookingDate = date("Y-m-d");
$object->bookingTime = date("H:i:s");


if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
    echo '{';
    echo('"response": "Request method must be POST!"');
    http_response_code(400);
    echo '}';

} else {

    if ($token) {

        $result = $object->checkCustomerDuplicateAnonymousBooking($data->customerTime, $data->customerDate, $data->customerID, $data->locationID);
        $num = $result->rowCount();
        if ($num) {
            // Send notification email on admins of specific agency
            echo '{';
            echo('"response": "Your booking already exists, use different date and time"');
            http_response_code(400);
            echo '}';

        } else {

            if ($object->addAnonymousBooking()) {
                echo '{';
                echo '"response": "Your request has been added successfully."';
                http_response_code(201);
                echo '}';
            } // if unable to create the customer, tell the client
            else {
                echo '{';
                echo '"response": "Oops, Unable to add new booking."';
                http_response_code(400);
                echo '}';
            }
        }
    } else {
        echo('"response": "You are unauthenticated"');
        http_response_code(401);
    }

}
