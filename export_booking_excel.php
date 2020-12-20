<?php  session_start();
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/27/2019
 * Time: 7:04 PM
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

if (isset($_POST['export_excel'])) {

    $data = $object->getAllAgencyBooking($admin_agency);

    $output .= '
          <table border="1" cellspacing="0" cellpadding="3">
              <tr>
                <th>#</th>
                <th>Booking ID</th>
                <th>AGENCY</th>
                <th>CUSTOMER NAME</th>
                <th>CAR PLATE NUMBER(NAME)</th>
                <th>FROM</th>
                <th>TO</th>
                <th>BOOKING DATE</th>
                <th>BOOKING TIME</th>
                <th>CAR DEPARTURE TIME</th>
                <th>LOCATION TRAVEL COST</th>
                <th>BOOKING CONFIRMATION STATUS</th>
                <th>BOOKING PAYMENT STATUS</th>
              </tr>
         ';

    $initial = 1;

    while($row = $data->fetch(PDO::FETCH_ASSOC)) {
        $bookingID = $row['id'];
        $uuid = $row['booking_uuid'];
        $customerID = $row['customer_id'];
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
            $fromLocationName = $object->getFromLocationName($locationID);
            $toLocationName = $object->getToLocationName($locationID);
            $locationCost = $object->getLocationCost($locationID);

        $initial = 1;
        $initial_number ++;

        $newStatus = $isPaid==0?"NO":"YES";
        $newConfirmation = $isConfirmed==0?"Pending":"Confirmed";

        $output .= '
                  <tr>
                      <td>'.$initial_number.'</td>
                      <td>'.$uuid.'</td>
                      <td>'.$getName.'</td>
                      <td>'.$customerName.'</td>
                      <td>'.$carName.'</td>
                      <td>'.$fromLocationName.'</td>
                      <td>'.$toLocationName.'</td>
                      <td>'.$bookingDate.'</td>
                      <td>'.$bookingTime.'</td>
                      <td>'.$carDepartTime.'</td>
                      <td>'.$locationCost.'</td>
                      <td>'.$newConfirmation.'</td>
                      <td>'.$newStatus.'</td>
                  </tr>
             ';
    }}

    $output .='</table>';
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=booking_reports.xls");

    echo $output;

}