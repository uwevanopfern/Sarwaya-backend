<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/28/2019
 * Time: 6:01 PM
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include("../../include/functions.php");
include("../authorization.php");

$authorization = new Authorization();
$token = $authorization->getBearerToken();


$object = new Functions();

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){

    echo '{';
    echo ('"response": "Request method must be POST!"');
    http_response_code(400);
    echo '}';

}else{
    if($token) {

        $data = json_decode(file_get_contents("php://input"));

        // set customer property values
        $agency = $data->agencyID;
        $location = $data->locationID;
        // create the customer
        $result = $object->getScheduleByAgencyLocation($agency,$location);
        $num = $result->rowCount();

        if($num > 0){

            $data = array();
            $data['data'] = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                $single_booking = array(
                    "id"                => $id,
                    "car_id"            => $car_id,
                    "car_name"          => $carName = $object->getCarName($car_id),
                    "agency_id"         => $agency_id,
                    "location_id"       => $location_id,
                    "car_depart_time"   => $car_depart_time,
                    "travel_cost"       => $locationCost = $object->getLocationCost($location_id)
                );

                array_push($data["data"], $single_booking);
            }
            echo json_encode($data);
        }else{
            echo json_encode(
                array("response" => "No schedule found.")
            );
        }

    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}
