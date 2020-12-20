<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/1/2019
 * Time: 4:24 PM
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
        $object->agencyID = isset($_GET['agencyID']) ? $_GET['agencyID'] : die();
        // create the customer
        $result = $object->getAgencyLocations($object->agencyID);
        $num = $result->rowCount();

        if ($num > 0) {

            $data['data'] = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $singleLocation = array(
                    "location_id" => $loc_id,
                    "from" => $from_location,
                    "to" => $to_location,
                    "agency_id" => $agency_id,
                    "location_cost" => $location_cost
                );

                array_push($data["data"], $singleLocation);
            }
            echo json_encode($data);
        } else {
            echo json_encode(
                array("response" => "No locations found.")
            );
        }
    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}
