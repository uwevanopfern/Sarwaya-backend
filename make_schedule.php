<?php  session_start();
date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/6/2019
 * Time: 4:06 PM
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

if (isset($_GET['bookingID']) && $_GET['agencyID'] && $_GET['locationID']) {

    $bookingID  = $_GET['bookingID'];
    $agencyID   = $_GET['agencyID'];
    $locationID = $_GET['locationID'];
}

$agencyName = $object->selectAgencyNameByAgencyID($admin_agency);


if(isset($_POST['makeSchedule'])) {

    $scheduleID = $_POST['schedule'];

    $setScheduleBooking = $object->setScheduleBooking($bookingID, $scheduleID);

    if ($setScheduleBooking) {
        $customerID = $object->getBookingCustomerIDModel($bookingID);
        $customerPhoneNumber = $object->getCustomerPhoneNumber($customerID);
        $bookingUUID = $object->getBookingUUID($bookingID);
        $message = "Ubusabe bwitiki bwemejwe, musubire muri app ahari irisiti yamatiki mwasabye mugure itiki yemejwe.\nUbusabe bwanyu bufite nimero ikurikira: $bookingUUID";
        $sendSMSonCustomer = $object->sendSMS($customerPhoneNumber, $message);

        if($sendSMSonCustomer){
            echo '<script>alert("Booking is set successfully")</script>';
        }
        ?>
        <script type="text/javascript">
            window.location = "anonymous.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to set agency, Try again!")</script>';
    }
}

?>
<div class="container"style="margin-top: 20px;">
    <section>
        <div class="container-fluid">
            <div class="row  align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-dark text-center font-weight-bold">Make schedule</h3>
                            </div>
                            <div class="card-subtitle">
                                <form class="text-dark py-4" method="post">
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">Select car</label>
                                        <select name="schedule" class="form-control button-border form-control-sm">
                                        <?php
                                            $getSchedule = $object->getScheduleByAgencyLocation($agencyID, $locationID);
                                            while($row = $getSchedule->fetch(PDO::FETCH_ASSOC)) {
                                                $ID = $row['id'];
                                                $carID = $row['car_id'];
                                                $agencyID = $row['agency_id'];
                                                $fetchedLocationID = $row['location_id'];
                                                $carDepartTime = $row['car_depart_time'];
                                                $carDepartDate = $row['car_depart_date'];

                                                $carName = $object->getCarName($carID);
                                                $locationCost = $object->getLocationCost($fetchedLocationID);
                                            ?>
                                            <option value="<?php echo $ID;?>">
                                                <?php echo $carName.' time: '. $carDepartTime. ' date '. $carDepartDate;?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary btn-block button-border" type="submit" name="makeSchedule">
                                        Make schedule
                                    </button>
                                </form>
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