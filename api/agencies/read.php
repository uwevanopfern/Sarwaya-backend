<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/28/2019
 * Time: 9:49 AM
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
        // create the customer
        $result = $object->getAllAgencies();
        $num = $result->rowCount();

        if ($num > 0) {

            $data['data'] = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $single_agency = array(
                    "agency_id" => $agency_id,
                    "agency_name" => $agency_name,
                    "agency_description" => $agency_description,
                    "agency_location" => $agency_location,
                    "total_locations" => $countAgencyCars = $object->countTotalAgencyLocations($agency_id)
                );

                array_push($data["data"], $single_agency);
            }
            echo json_encode($data);
        } else {
            echo json_encode(
                array("response" => "No agencies found.")
            );
        }
    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}
