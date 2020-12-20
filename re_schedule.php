<?php  session_start();
date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/26/2019
 * Time: 8:08 PM
 */

if(!($_SESSION)){  header("Location:index.php");}

include("include/header.php");
include("include/functions.php");

$admin_id = $_SESSION['id'];
$admin_name = $_SESSION['name'];
$admin_email = $_SESSION['email'];
$admin_phone = $_SESSION['phone'];
$admin_role = $_SESSION['role'];
$admin_agency = $_SESSION['agency'];

$object = new Functions();

if (isset($_GET['booking_id'])) {

    $bookingID = $_GET['booking_id'];

}

$agencyName = $object->selectAgencyNameByAgencyID($admin_agency);

if(isset($_POST['re_schedule'])) {

    $customerTime = $_POST['customerTime'];

    $rescheduleBooking = $object->updateCustomerBookingTime($bookingID, $customerTime);

    if ($rescheduleBooking) {
        $customerID = $object->getBookingCustomerIDModel($bookingID);
        $customerPhoneNumber = $object->getCustomerPhoneNumber($customerID);
        $bookingUUID = $object->getBookingUUID($bookingID);
        $message = "Ubusabe bwitiki bwemejwe, musubire muri app ahari irisiti yamatiki mwasabye mugure itiki yemejwe.\nUbusabe bwanyu bufite nimero ikurikira: $bookingUUID";
        $sendSMSonCustomer = $object->sendSMS($customerPhoneNumber, $message);

        if($sendSMSonCustomer){
            echo '<script>alert("Booking is confirmed successfully")</script>';
        }
        ?>
        <script type="text/javascript">
            window.location = "home.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to re schedule agency, Try again!")</script>';
    }

}
?>
<div class="container" style="margin-top: 50px;">
    <section>
        <div class="container-fluid">
            <div class="row  align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h5 class="text-dark text-center font-weight-bold">Re schedule booking</h5>
                            </div>
                            <div class="card-subtitle">
                                <?php

                                $data = $object->getBookingDetails($bookingID);

                                    while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                        $id = $row['id'];
                                        $uuid = $row['booking_uuid'];
                                        $customerID = $row['customer_id'];
                                        $scheduleID = $row['schedule_id'];
                                        $bookingDate = $row['booking_date'];
                                        $bookingTime = $row['booking_time'];
                                        $isPaid = $row['is_paid'];
                                        $transaction_status = $row['transaction_status'];
                                        $isConfirmed = $row['is_confirmed'];
                                        $locationID = $row['anonymous_location'];

                                        $customerName = $object->getCustomerName($customerID);
                                        $fromLocationName = $object->getFromLocationName($locationID);
                                        $toLocationName = $object->getToLocationName($locationID);
                                        $locationCost = $object->getLocationCost($locationID);

                                    ?>
                                    <form class="text-dark py-4" method="post">
                                        <div class="form-group box-shadow">
                                            <label for="email">Customer Name</label>
                                            <input type="text" class="form-control button-border form-control-sm" id="agencyName" name="customerName"
                                                   value="<?php echo $customerName;?>" disabled>
                                        </div>
                                        <div class="form-group box-shadow">
                                            <label for="name">Previous travel location</label>
                                            <input type="text" class="form-control button-border form-control-sm" id="description" name="locationName"
                                                   value="<?php echo $fromLocationName;?> -> <?php echo $toLocationName;?>" disabled>
                                        </div>
                                        <div class="form-group box-shadow">
                                            <label for="email">Select available car</label>
                                            <select name="customerTime" class="form-control button-border form-control-sm" style="font-size: 12px;">
                                                <?php
                                            $data = $object->getAgencyTimeByAgencyID($admin_agency);

                                            while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                                    $id = $row['id'];
                                                    $time = $row['time'];
                                                    ?>
                                                    <option value="<?php echo $time;?>" style="font-size: 12px;">
                                                        <?php echo $time;?>
                                                    </option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                        <button class="btn btn-primary btn-block button-border" type="submit" name="re_schedule">
                                            Re schedule booking
                                        </button>
                                    </form>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</body>
</html>