<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/15/2019
 * Time: 9:38 AM
 * getAgencyTimeByAgencyID
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
    echo ('"response": "Request method must be POST!"');
    http_response_code(400);
    echo '}';

}else{
    if($token) {

        $object->agencyID = isset($_GET['agencyID']) ? $_GET['agencyID'] : die();

        $result = $object->getAgencyTimeByAgencyID($object->agencyID);
        $num = $result->rowCount();

        if($num > 0){

            $data = array();
            $data['data'] = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                $single_object = array(
                    "id"        => $id,
                    "agencyName"        => $agencyName = $object->selectAgencyNameByAgencyID($agency_id),
                    "time"          => $time,
                );

                array_push($data["data"], $single_object);
            }
            echo json_encode($data);
        }else{
            echo json_encode(
                array("response" => "No time table found.")
            );
        }

    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}
