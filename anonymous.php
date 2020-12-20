<?php  session_start();
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/6/2019
 * Time: 3:38 PM
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

?>
<div class="container">
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="pt-5">
                        <h6>Current anonymous booking request</h6>
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
                                    <th>Customer Name</th>
                                    <th>Customer Date and Time</th>
                                    <th>Location Name</th>
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

                                    $customerName = $object->getCustomerName($customerID);
                                    $fromLocationName = $object->getFromLocationName($locationID);
                                    $toLocationName = $object->getToLocationName($locationID);
                                        ?>
                                        <tr style="font-size: 11px;">
                                            <td><?php echo $uuid;?></td>
                                            <td><?php echo $getName;?></td>
                                            <td><?php echo $customerName;?></td>
                                            <td><?php echo $customerDateTime;?></td>
                                            <td><?php echo $fromLocationName.">>".$toLocationName;?></td>
                                            <td><?php echo $isConfirmed==0?"Pending":"Confirmed";?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-1">
                                                        <a href="make_schedule.php?bookingID=<?php echo $bookingID?>&&agencyID=<?php echo $agencyID?>&&locationID=<?php echo $locationID;?>">
                                                            Make schedule
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