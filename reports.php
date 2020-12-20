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

    $totalConfirmedBooking = $object->countTotalConfirmedBooking($admin_agency);
    $totalPendingBooking = $object->countTotalPendingBooking($admin_agency);

    $totalSuccessTransactionBooking = $object->countTotalSuccessTransactionBooking($admin_agency);
    $totalPendingTransactionBooking = $object->countTotalPendingTransactionBooking($admin_agency);

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

    if(isset($_POST['refund'])){

        $phone        = $_POST['phone'];
        $amount       = $_POST['amount'];
        $penaltyCharge = $amount * 75 / 100;
        $refund = $object->refundCustomer($phone, round($penaltyCharge));

        if ($refund == "Successfull") {
            $paidRecordsOnRefund = $object->getTotalPaidAgencyBooking($admin_agency);
            while($row = $paidRecordsOnRefund->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                //Update all withdrew rows in database to keep with updated funds which are not withdrew yet!!!
                $object->updateWithdrawStatus($id);
            }
            //Add transaction log in transaction_logs table
            $object->addTransactionLog($admin_agency,"Refund", $admin_name, $amount, $phone);
            echo '<script>alert("Refund is done successfully")</script>';
            ?>
            <script type="text/javascript">
                window.location = "reports.php";
            </script>
            <?php

        } else {
            echo '<script>alert("Oops, '.$refund.', Try again!")</script>';
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
                    <h3 style="margin-top: 20px;font-size: 18px;"><strong><?php echo $getName;?></strong> reports</h3>
                    <hr>
                    <div class="row pt-md-5 mt-md-3 mb-5">
                        <div class="col-xl-3 col-sm-6 p-1">
                            <div class="card card-common">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-right text-secondary">
                                            <h5 class=" small text-dark font-weight-bold">
                                                Pending bookings
                                                <span class="badge badge-info"><?php echo $totalPendingBooking;?></span>
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
                                                Confirmed bookings
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
                                                Pending transactions
                                                <span class="badge badge-info"><?php echo $totalPendingTransactionBooking;?></span>
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
                                                Completed transactions
                                                <span class="badge badge-success"><?php echo $totalSuccessTransactionBooking;?></span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-sm-5 p-1">
                            <div class="card-body">
                                <h6>Current earned amount <strong><?php echo number_format($percentageTotal). " RWF";?></strong></h6>
                                <h6 style="font-size: 12px;">You will be charged <strong>200 RWF</strong></h6>
                                <h6 style="font-size: 12px;">You will receive <strong><?php echo number_format($percentageTotal-200). " RWF";?></strong></h6>
                                <form  method="post" style="font-size: 12px;">
                                    <input type="text" class="form-control" id="receiver" name="receiver"
                                           placeholder="Enter admin receiver MoMo number e.g: 250.." style="font-size: 12px;">
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
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="pt-5">
                        <h6>Search pending and confirmed and by customer</h6>
                    </div>
                    <hr>
                    <div class="col-xl-6 col-lg-4 col-md-6">
                        <form action="export_booking_excel.php" method="post" style="font-size: 12px;">
                            <button type="submit" name="export_excel" class="btn btn-success btn-block btn-sm">
                                <i class="fas fa-file-excel fa-md text-warning mr-2"></i>
                                Export this reports in Excel
                            </button>
                        </form>
                        <br>
                        <form action="export_transaction_logs.php" method="post" style="font-size: 12px;">
                            <button type="submit" name="export_transaction_logs" class="btn btn-info btn-block btn-sm">
                                <i class="fas fa-file-excel fa-md text-danger mr-2"></i>
                                Export transaction logs
                            </button>
                        </form>
                        <form class="text-dark py-4" method="post">
                            <div class="form-group font-weight-bold small box-shadow">
                                <select name="key" class="form-control" style="font-size: 12px;">
                                    <option value="confirmed">By Confirmed Booking</option>
                                    <option value="customer">By Customer Name</option>
                                </select>
                                <hr>
                                <input type="text" class="form-control" id="password" name="customerName"
                                       placeholder="Enter customer Name" style="font-size: 12px;">
                                <br>
                                <button class="btn btn-secondary btn-block button-border btn-sm" type="submit" name="search">
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
                                    <th>Refund</th>
                                </tr>
                                </thead>
                                <?php

                                if(isset($_POST['search'])){

                                    if($_POST['key'] == 'confirmed'){
                                        ?>
                                        <tbody>
                                        <?php
                                        $data = $object->getAllConfirmedPaidBookings($admin_agency);

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

                                            ?>
                                            <tr style="font-size: 11px;">
                                                <td><?php echo $uuid;?></td>
                                                <td><?php echo $getName;?></td>
                                                <td><?php echo $customerName;?></td>
                                                <td><?php echo $carName;?></td>
                                                <td><?php echo $fromLocationName; ?></td>
                                                <td><?php echo $toLocationName; ?></td>
                                                <td><?php echo $bookingDate;?></td>
                                                <td><?php echo $bookingTime;?></td>
                                                <td><?php echo $carDepartTime;?></td>
                                                <td><?php echo $locationCost. " RWF";?></td>
                                                <td><?php echo $isConfirmed==0?"Pending":"Confirmed";?></td>
                                                <td><?php echo $isPaid==0?"NO":"YES";?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    <?php
                                    }
                                    }
                                    else{

                                        $customerName = $_POST['customerName'];
                                        $getCustomerIDName = $object->searchCustomerName($customerName);
                                        $data = $object->getBookingOfCustomer($getCustomerIDName);

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
                                            $phone = $row['payment_phone'];
                                            $amount = $row['payment_cost'];
                                            $isMoneyTaken = $row['is_money_taken'];

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
                                        ?>
                                        <tbody>
                                            <tr style="font-size: 11px;">
                                                <td><?php echo $uuid;?></td>
                                                <td><?php echo $getName;?></td>
                                                <td><?php echo $customerName;?></td>
                                                <td><?php echo $carName;?></td>
                                                <td><?php echo $fromLocationName; ?></td>
                                                <td><?php echo $toLocationName; ?></td>
                                                <td><?php echo $bookingDate;?></td>
                                                <td><?php echo $bookingTime;?></td>
                                                <td><?php echo $carDepartTime;?></td>
                                                <td><?php echo $locationCost. " RWF";?></td>
                                                <td><?php echo $isConfirmed==0?"Pending":"Confirmed";?></td>
                                                <td><?php echo $isPaid==0?"NO":"YES";?></td>
                                                <td><?php if($isPaid==1 && $isMoneyTaken==0){?>
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <form action="reports.php" method="post">
                                                                <input type="hidden" name="phone" value="<?php echo $phone;?>">
                                                                <input type="hidden" name="amount" value="<?php echo $amount;?>">
                                                                <button type="submit" name="refund">
                                                                    <i class="fas fa-money-bill-alt fa-md text-success mr-2"> REFUND</i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    else {?>
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <span class="badge badge-danger">DISABLED</span>
                                                        </div>
                                                    </div>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        <?php } }?>
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