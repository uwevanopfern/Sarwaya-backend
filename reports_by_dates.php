<?php  session_start();

/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/15/2019
 * Time: 6:29 PM
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


$getName = $object->selectAgencyNameByAgencyID($admin_agency);

if(isset($_POST['confirm'])){

    $confirm        = $_POST['confirm_booking'];
    $confirmBooking = $object->confirmBooking($confirm);

    if ($confirmBooking) {
        echo '<script>alert("Booking is confirmed successfully")</script>';
        //Send SMS to the customer by selecting customer info and send to his phone sms
        ?>
        <script type="text/javascript">
            window.location = "home.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to confirm booking, Try again!")</script>';
    }
}

$totalConfirmedBooking = $object->countTotalConfirmedBooking($admin_agency);
$totalPendingBooking = $object->countTotalPendingBooking($admin_agency);

$totalSuccessTransactionBooking = $object->countTotalSuccessTransactionBooking($admin_agency);
$totalPendingTransactionBooking = $object->countTotalPendingTransactionBooking($admin_agency);

?>
<div class="container">
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="pt-5">
                        <h6>Search bookings by given period</h6>
                    </div>
                    <hr>
                    <div class="col-xl-6 col-lg-4 col-md-6">
                        <form class="text-dark py-4" method="post">
                            <div class="form-group font-weight-bold small box-shadow">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group box-shadow">
                                            <label for="name"><span class="small font-weight-bold mr-5">Start Date</span>
                                                <input type="date" class="form-control input-group-sm" id="startDate" name="startDate" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group box-shadow">
                                            <label for="name"><span class="small font-weight-bold mr-5">End Date</span>
                                                <input type="date" class="form-control input-group-sm" id="endDate" name="endDate" required>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-secondary btn-block button-border" type="submit" name="search">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-12 mb-4 mb-xl-0">
                            <table class="table table-striped bg-light ">
                                <thead>
                                <tr class="text-muted" style="font-size: 13px;">
                                    <th>Booking No</th>
                                    <th>Agency</th>
                                    <th>Customer</th>
                                    <th>Car</th>
                                    <th>FROM</th>
                                    <th>TO</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Departure</th>
                                    <th>Cost</th>
                                    <th>Status</th>
                                    <th>Paid</th>
                                </tr>
                                </thead>
                                <?php

                                if(isset($_POST['search'])) {

                                    $startDate = $_POST['startDate'];
                                    $endDate = $_POST['endDate'];

                                    ?>
                                    <tbody>
                                    <?php
                                    $data = $object->searchBookingsByDates($admin_agency, $startDate, $endDate);

                                    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
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

                                        while ($row = $getSchedule->fetch(PDO::FETCH_ASSOC)) {
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

                                            ?>
                                            <tr style="font-size: 11px;">
                                                <td><?php echo $uuid; ?></td>
                                                <td><?php echo $getName; ?></td>
                                                <td><?php echo $customerName; ?></td>
                                                <td><?php echo $carName; ?></td>
                                                <td><?php echo $fromLocationName; ?></td>
                                                <td><?php echo $toLocationName; ?></td>
                                                <td><?php echo $bookingDate; ?></td>
                                                <td><?php echo $bookingTime; ?></td>
                                                <td><?php echo $carDepartTime; ?></td>
                                                <td><?php echo $locationCost . " RWF"; ?></td>
                                                <td><?php echo $isConfirmed == 0 ? "Pending" : "Confirmed"; ?></td>
                                                <td><?php echo $isPaid == 0 ? "NO" : "YES"; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
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
