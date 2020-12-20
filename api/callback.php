<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/10/2019
 * Time: 11:48 AM
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");

include("../include/functions.php");
$object = new Functions();

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch($requestMethod) {

    case 'POST':

        $data = json_decode(file_get_contents( 'php://input' ), true );

        $requesttransactionid   =   $data['jsonpayload']['requesttransactionid'];
        $referenceno            =   $data['jsonpayload']['referenceno'];
        $responsecode           =   $data['jsonpayload']['responsecode'];
        $transactionid          =   $data['jsonpayload']['transactionid'];
        $statusdesc             =   $data['jsonpayload']['statusdesc'];
        $status                 =   $data['jsonpayload']['status'];

        $logFile = 'log_'.date("d-M-y").'.log';
        file_put_contents($logFile, $data['jsonpayload'], FILE_APPEND);

        $insertIntouchData = $object->saveIntouchJson($statusdesc, $requesttransactionid, $status, $responsecode);
        if($responsecode == '01'){
            $update = $object->updateTransactionStatus($requesttransactionid, "Success");

            if($update) {
                $message = "success";
                $status = 1;
            } else {
                $message = "Failed";
                $status = 0 ;
            }
            $response = array(
                'success' => $status,
                'message' => $message,
                'request_id'=>$requesttransactionid
            );
            //Send SMS to the user
            $customerID = $object->getCustomerIdByTransactionID($requesttransactionid);
            $customerPhoneNumber = $object->getCustomerPhoneNumber($customerID);
            $bookingUUID = $object->getBookingUUIDByTransactionID($requesttransactionid);
            //Select agency ID by bookingUUID ::::: return agency ID
            $agencyID = $object->getAgencyIDByBookingUUID($bookingUUID);
            //Get phone phone in agency model with above agencyID :::::::: return agencyPhone
            $agencyPhone = $object->getAgencyPhoneByAgencyID($agencyID);
            $message = "Igikorwa cyo kugura itiki cyagenze neza, Nimero yitiki ni $bookingUUID\nMwihutire kugerera aho agence ikorera kugihe.\nMugize ikibazo cyangwa igitekerezo mwaduhamagara kuri iyi numero ($agencyPhone).\nMugire urugendo rwiza!!!!!";
            $object->sendSMS($customerPhoneNumber, $message);
        }else{
            $update = $object->updateTransactionStatus($requesttransactionid, "Failed");
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        break;

    default:
        echo '{';
        echo ('"response": "Request method must be POST!"');
        http_response_code(400);
        echo '}';

        break;
}