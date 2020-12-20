<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/28/2019
 * Time: 8:21 PM
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include("../../include/functions.php");
include("../authorization.php");

$object = new Functions();

$authorization = new Authorization();
$token = $authorization->getBearerToken();

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){

    echo '{';
    echo ('"response": "Request method must be GET!"');
    http_response_code(400);
    echo '}';

}else{

    if($token) {

        $object->bookingID = isset($_GET['bookingID']) ? $_GET['bookingID'] : die();
        // create the customer
        $result = $object->getBookingDetails($object->bookingID);
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

                $getSchedule = $object->getScheduleDetails($scheduleID);

                while($row = $getSchedule->fetch(PDO::FETCH_ASSOC)) {
                    $schedule = $row['id'];
                    $carID = $row['car_id'];
                    $agencyID = $row['agency_id'];
                    $locationID = $row['location_id'];
                    $carDepartTime = $row['car_depart_time'];

                    $customerName = $object->getCustomerName($customerID);
                    $carName = $object->getCarName($carID);
                    $locationCost = $object->getLocationCost($locationID);
                    $agencyName = $object->selectAgencyNameByAgencyID($agencyID);

                    $single_booking = array(
                        "booking_id" =>  $bookingID,
                        "booking_uuid" =>  $uuid,
                        "agency_id" => $agencyID,
                        "agency_name" => $agencyName,
                        "schedule_id" => $scheduleID,
                        "customer_id" => $customerID,
                        "car_name" => $carName,
                        "ticket_cost" => $locationCost,
                        "depart_time" =>$carDepartTime,
                        "booking_status" => $isConfirmed==0?"Pending":"Confirmed",
                        "isPaid" =>$isPaid==0?"NOT PAID":"PAID"
                    );

                    array_push($data["data"], $single_booking);
                }
            }
            echo json_encode($data);
        }else{
            echo json_encode(
                array("response" => "No agencies found.")
            );
        }

    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}