<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch($requestMethod) {
    case 'POST':

        $host       =   "localhost";
        $user       =   "john_john";
        $pass       =   "L9NGQRoHU2kj";
        $db_name    =   "john_sarwaya";
        $connect    = new mysqli($host,$user,$pass,$db_name);

        $data       = json_decode( file_get_contents( 'php://input' ), true );

        $requesttransactionid   =   $data['jsonpayload']['requesttransactionid'];;
        $referenceno            =   $data['jsonpayload']['referenceno'];;
        $responsecode           =   $data['jsonpayload']['responsecode'];
        $transactionid          =   $data['jsonpayload']['transactionid'];
        $statusdesc             =   $data['jsonpayload']['statusdesc'];
        $status                 =   $data['jsonpayload']['status'];

        if($status=='Successfull'){
            $up=$connect->query("UPDATE booking SET transaction_status='Success' where transactionID='$requesttransactionid'");
        }
        else{
            $up=$connect->query("UPDATE booking SET transaction_status='Failed' where transactionID='$requesttransactionid'");
        }

        $empQuery=$connect->query("INSERT INTO intouch_data SET requestcode='".$responsecode."', requestid='".$transactionid."', statusdesc='".$statusdesc."', status='".$status."'");
        if($empQuery) {
            $messgae = "Success";
            $status = 1;
        } else {
            $messgae = "Failed";
            $status = 0;
        }
        $empResponse = array(
            'success' => $status,
            'message' => $messgae,
            'request_id'=>$requesttransactionid
        );
        header('Content-Type: application/json');
        echo json_encode($empResponse);

        break;

    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
