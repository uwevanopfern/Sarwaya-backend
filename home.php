<?php  session_start();
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
            //Send SMS to the customer by selecting customer info and send to his phone sms
            $customerID = $object->getBookingCustomerIDModel($confirm);
            $customerPhoneNumber = $object->getCustomerPhoneNumber($customerID);
            $bookingUUID = $object->getBookingUUID($confirm);
            $message = "Ubusabe bwitiki bwemejwe, musubire muri app ahari irisiti yamatiki mwasabye mugure itiki yemejwe.\nUbusabe bwanyu bufite nimero ikurikira: $bookingUUID";
            $sendSMSonCustomer = $object->sendSMS($customerPhoneNumber, $message);

            echo '<script>alert("Booking is confirmed successfully")</script>';

            ?>
            <script type="text/javascript">
                window.location = "home.php";
            </script>
            <?php
        } else {
            echo '<script>alert("Oops, Failed to confirm booking, Try again!")</script>';
        }
    }

    $totalCars = $object->countTotalAgencyCars($admin_agency);
    $totalLocation = $object->countTotalAgencyLocations($admin_agency);
    $totalBookings = $object->countTotalAgencyBooking($admin_agency);

    $totalPaidBooking = $object->getTotalPaidAgencyBooking($admin_agency);

    $totalEarnedAmount = 0;

    while($row = $totalPaidBooking->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        $uuid = $row['booking_uuid'];
        $agency_id = $row['agency_id'];
        $customerID = $row['customer_id'];
        $scheduleID = $row['schedule_id'];
        $booking_date = $row['booking_date'];
        $booking_time = $row['booking_time'];
        $is_paid = $row['is_paid'];
        $transaction_status = $row['transaction_status'];
        $is_confirmed = $row['is_confirmed'];

        $getSchedule = $object->getScheduleDetails($scheduleID);

        while($row = $getSchedule->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $carID = $row['car_id'];
            $agencyID = $row['agency_id'];
            $locationID = $row['location_id'];
            $carDepartTime = $row['car_depart_time'];

            $customerName = $object->getCustomerName($customerID);
            $carName = $object->getCarName($carID);

            $locationCost = $object->getLocationCost($locationID);

            $totalEarnedAmount = $totalEarnedAmount + $locationCost;
        }

    }

    $percentageTotal = $totalEarnedAmount * 95 /100;

?>
<div class="container">
    <section class="mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <h3 style="margin-top: 20px;font-size: 18px;"><strong><?php echo $getName;?></strong> dashboard</h3>
                    <hr>
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        <div class="col-xl-3 col-sm-6 p-2">
                            <div class="card card-common">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-right text-secondary">
                                            <h5 class=" small text-dark font-weight-bold">Total of all bookings</h5>
                                            <h6 class="mr-5" style="font-weight: bold;font-size: 13px;">
                                                <span class="badge badge-info"><?php echo $totalBookings;?></span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 p-2">
                            <div class="card card-common">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-right text-secondary">
                                            <h5 class=" small text-dark font-weight-bold">Total locations</h5>
                                            <h6 class="mr-5" style="font-weight: bold;font-size: 13px;">
                                                <span class="badge badge-info"><?php echo $totalLocation;?></span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 p-2">
                            <div class="card card-common">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-right text-secondary">
                                            <h5 class=" small text-dark font-weight-bold">Total cars of agency</h5>
                                            <h6 class="mr-5" style="font-weight: bold;font-size: 13px;">
                                                <span class="badge badge-info"><?php echo $totalCars;?></span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 p-2">
                            <div class="card card-common">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-right text-secondary">
                                            <h5 class=" small text-dark font-weight-bold">Current amount earned</h5>
                                            <h6 class="mr-5" style="font-weight: bold;font-size: 13px;">
                                                <span class="badge badge-success"><?php echo number_format($percentageTotal). " RWF";?></span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="pt-5">
                        <h6>Current pending booking need to be confirmed</h6>
                    </div>
                    <hr>
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
                                    <th>Booking ID</th>
                                    <th>Agency</th>
                                    <th>Customer</th>
                                    <th>FROM</th>
                                    <th>TO</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>customerTime</th>
                                    <th>customerDate</th>
                                    <th>Cost</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $data = $object->getAllAnonymousPendingBookings($admin_agency);

                                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $bookingID = $row['id'];
                                    $uuid = $row['booking_uuid'];
                                    $customerID = $row['customer_id'];
                                    $agencyID = $row['agency_id'];
                                    $customerDateTime = $row['pre_booked_date'];
                                    $bookingDate = $row['booking_date'];
                                    $bookingTime = $row['booking_time'];
                                    $isPaid = $row['is_paid'];
                                    $transaction_status = $row['transaction_status'];
                                    $isConfirmed = $row['is_confirmed'];
                                    $locationID = $row['anonymous_location'];
                                    $customerTime = $row['customer_time'];

                                    $customerName = $object->getCustomerName($customerID);
                                    $fromLocationName = $object->getFromLocationName($locationID);
                                    $toLocationName = $object->getToLocationName($locationID);
                                    $locationCost = $object->getLocationCost($locationID);

                                ?>
                                <tr style="font-size: 11px;">
                                    <td><?php echo $uuid;?></td>
                                    <td><?php echo $getName;?></td>
                                    <td><?php echo $customerName;?></td>
                                    <td><?php echo $fromLocationName;?></td>
                                    <td><?php echo $toLocationName;?></td>
                                    <td><?php echo $bookingDate;?></td>
                                    <td><?php echo $bookingTime;?></td>
                                    <td><?php echo $customerTime;?></td>
                                    <td><?php echo $customerDateTime;?></td>
                                    <td><?php echo $locationCost. " RWF";?></td>
                                    <td><?php echo $isConfirmed==0?"Pending":"Confirmed";?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-1">
                                                <form action="home.php" method="post">
                                                    <button type="submit" name="confirm">
                                                        <i class="fas fa-save fa-md text-success mr-2">Confirm</i>
                                                        <input type="hidden" name="confirm_booking" value="<?php echo $bookingID;?>">
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-1">
                                                <a href="re_schedule.php?booking_id=<?php echo $bookingID?>"
                                                ><i class="fas fa-edit fa-md text-warning mr-2">Reschedule</i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
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