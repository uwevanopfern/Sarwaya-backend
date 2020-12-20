<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/28/2019
 * Time: 6:29 PM
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include("../../include/functions.php");
include("../authorization.php");

$authorization = new Authorization();
$token = $authorization->getBearerToken();


$object = new Functions();

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){

    echo '{';
    echo ('"response": "Request method must be GET!"');
    http_response_code(400);
    echo '}';

}else{
    if($token) {

        $object->customerID = isset($_GET['customerID']) ? $_GET['customerID'] : die();
        // create the customer
        $result = $object->getBookingOfCustomer($object->customerID);
        $num = $result->rowCount();

        if($num > 0){

            $data = array();
            $data['data'] = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                $bookingID = $row['id'];
                $uuid = $row['booking_uuid'];
                $customerID = $row['customer_id'];
                $agencyID = $row['agency_id'];
                $scheduleID = $row['schedule_id'];
                $bookingDate = $row['booking_date'];
                $bookingTime = $row['booking_time'];
                $isPaid = $row['is_paid'];
                $transaction_status = $row['transaction_status'];
                $isConfirmed = $row['is_confirmed'];
                $locationID = $row['anonymous_location'];
                $customerTime = $row['customer_time'];
                $customerDate = $row['pre_booked_date'];

                $customerName = $object->getCustomerName($customerID);
                $locationCost = $object->getLocationCost($locationID);
                $agencyName = $object->selectAgencyNameByAgencyID($agencyID);

                $single_booking = array(
                    "booking_id" =>  $bookingID,
                    "booking_uuid" =>  $uuid,
                    "customer_id" =>  $customerID,
                    "customer_time" =>  $customerTime,
                    "customer_date" =>  $customerDate,
                    "agency_name" => $agencyName,
                    "ticket_cost" => $locationCost,
                    "booking_date" =>$bookingDate,
                    "paymentStatus" =>$transaction_status,
                    "booking_status" => $isConfirmed==0?"Pending":"Confirmed",
                    "isPaid" =>$isPaid==0?"UNPAID":"PAID"
                );

                array_push($data["data"], $single_booking);

            }
            echo json_encode($data);
        }else{
                echo '{';
                echo '"response": "No booking found on this customer."';
                http_response_code(404);
                echo '}';
        }

    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}