<?php error_reporting(E_ALL & ~E_NOTICE & E_WARNING & E_PARSE & E_ERROR);?>
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

if(isset($_POST['search'])){

    $agency     = $_POST['agency'];

    $totalConfirmedBooking = $object->countTotalConfirmedBooking($agency);
    $totalPendingBooking = $object->countTotalPendingBooking($agency);

    $totalFailedAgencyBooking = $object->getTotalFailedAgencyBooking($agency);
    $totalPaidAgencyBooking = $object->getTotalPaidAgencyBooking($agency);

    $totalEarnedAmount = 0;

    while($row = $totalPaidAgencyBooking->fetch(PDO::FETCH_ASSOC)) {
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
            $agencyPercent = $totalEarnedAmount * 95 /100;
            $getAllPercent = $totalEarnedAmount * 5 /100;
        }

    }

}

if(isset($_POST['withdraw'])){

    $receiver           =   $_POST['receiver'];
    $refund             =   $object->refundCustomer($receiver, round($percentageTotal));

    if ($refund == "Successfull") {
        $paidRecordsOnWithdraw = $object->getTotalPaidAgencyBooking($admin_agency);
        while($row = $paidRecordsOnWithdraw->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            //Update all withdrew rows in database to keep with updated funds which are not withdrew yet!!!
            $object->updateWithdrawStatus($id);
        }
        //Add transaction log in transaction_logs table
        $object->addTransactionLog($admin_agency, "Withdraw", $admin_name, $percentageTotal, $receiver);
        echo '<script>alert("Withdraw is done successfully")</script>';
        ?>
        <script type="text/javascript">
            window.location = "reports.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, '.$refund.', Try again!")</script>';
    }
}

?>
<div class="container">
    <section class="mb-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <form class="text-dark py-4" method="post">
                            <div class="form-group font-weight-bold small box-shadow">
                                <label for="agency">Select agency</label>
                                <select name="agency" class="form-control button-border">
                                    <?php
                                    $getAllAgencies = $object->getAllAgencies();
                                    while($row = $getAllAgencies->fetch(PDO::FETCH_ASSOC)) {
                                        $id = $row['agency_id'];
                                        $name = $row['agency_name'];
                                        ?>
                                        <option value="<?php echo $id;?>">
                                            <?php echo $name;?>
                                        </option>
                                    <?php }?>
                                </select>
                            </div>
                            <button class="btn btn-outline-info btn-block button-border" type="submit" name="search">
                                Search
                            </button>
                        </form>
                    </div>
                    <hr>
                    <h3 style="margin-top: 20px;font-size: 18px;">Monthly transaction of agency</h3>
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        <div class="col-xl-3 col-sm-6 p-1">
                            <div class="card card-common">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-right text-secondary">
                                            <h5 class=" small text-dark font-weight-bold">
                                                Total of confirmed bookings
                                                <span class="badge badge-success"><?php echo $totalConfirmedBooking;?></span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 p-1">
                            <div class="card card-common">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-right text-secondary">
                                            <h5 class=" small text-dark font-weight-bold">
                                                All income of this agency
                                                <span class="badge badge-success"><?php echo number_format($totalEarnedAmount). " RWF";?></span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 p-1">
                            <div class="card card-common">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-right text-secondary">
                                            <h5 class=" small text-dark font-weight-bold">
                                                Total % income of agency
                                                <span class="badge badge-info"><?php echo number_format($agencyPercent). " RWF";?></span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 p-1">
                            <div class="card card-common">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-right text-secondary">
                                            <h5 class=" small text-dark font-weight-bold">
                                                Total % income of get all
                                                <span class="badge badge-success"><?php echo number_format($getAllPercent). " RWF";?></span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-sm-5 p-1">
                            <div class="card-body">
                                <h6>Current earned amount <strong><?php echo number_format($getAllPercent). " RWF";?></strong></h6>
                                <h6 style="font-size: 12px;">You will be charged <strong>200 RWF</strong></h6>
                                <h6 style="font-size: 12px;">You will receive <strong><?php echo number_format($percentageTotal-200). " RWF";?></strong></h6>
                                <form  method="post" style="font-size: 12px;">
                                    <input type="text" class="form-control" id="receiver" name="receiver"
                                           placeholder="Enter admin receiver MoMo number" style="font-size: 12px;">
                                    <button type="submit" name="withdraw" class="btn btn-info btn-block btn-sm">
                                        <i class="fas fa-money-bill-alt text-warning mr-2"></i>
                                        Withdraw amount earned
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