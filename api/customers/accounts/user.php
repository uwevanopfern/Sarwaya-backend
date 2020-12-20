<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/3/2019
 * Time: 2:56 PM
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include("../../../include/functions.php");
include("../../authorization.php");

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

        $object->customerID = isset($_GET['customerID']) ? $_GET['customerID'] : die();
        // create the customer
        $result = $object->getCustomerDetails();
        $num = $result->rowCount();

        if($num > 0){

            $data = array();
            $data['data'] = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                $customerID = $row['customer_id'];
                $customerName = $row['customer_name'];
                $customerPhone = $row['customer_phone'];
                $customerEmail = $row['customer_email'];

                $customer = array(
                    "customer_id" =>  $customerID,
                    "customer_name" =>  $customerName,
                    "customer_phone" => $customerPhone,
                    "customer_email" => $customerEmail,
                );

                array_push($data["data"], $customer);
            }
            echo json_encode($data);
        }else{
            echo json_encode(
                array("response" => "No customer found.")
            );
        }

    }else{
        echo ('"response": "You are unauthenticated"');
        http_response_code(401);
    }
}