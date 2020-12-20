<?php  session_start();
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/21/2019
 * Time: 4:50 PM
 */

include("include/functions.php");
$admin_id = $_SESSION['id'];
$admin_name = $_SESSION['name'];
$admin_email = $_SESSION['email'];
$admin_phone = $_SESSION['phone'];
$admin_role = $_SESSION['role'];
$admin_agency = $_SESSION['agency'];

$object = new Functions();

$getName = $object->selectAgencyNameByAgencyID($admin_agency);


$output = '';
$initial_number = NULL;

if (isset($_POST['export_transaction_logs'])) {

    $data = $object->getAgencyTransactionLogs($admin_agency);

    $output .= '
          <table border="1" cellspacing="0" cellpadding="3">
              <tr>
                <th>#</th>
                <th>AGENCY NAME</th>
                <th>TRANSACTION TYPE</th>
                <th>PERFOMER</th>
                <th>AMOUNT</th>
                <th>RECEIVER</th>
                <th>TIMESTAMP</th>
              </tr>
         ';

    $initial = 1;

    while($row = $data->fetch(PDO::FETCH_ASSOC)) {
        $transactionID = $row['id'];
        $transactionType = $row['trans_type'];
        $performer = $row['performer'];
        $amount = $row['amount'];
        $receiver = $row['receiver'];
        $timestamp = $row['period_time'];

        $initial = 1;
        $initial_number ++;


        $output .= '
              <tr>
                  <td>'.$initial_number.'</td>
                  <td>'.$getName.'</td>
                  <td>'.$transactionType.'</td>
                  <td>'.$performer.'</td>
                  <td>'.$amount.'</td>
                  <td>'.$receiver.'</td>
                  <td>'.$timestamp.'</td>
              </tr>
         ';
        }

    $output .='</table>';
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=transaction_logs.xls");

    echo $output;

}