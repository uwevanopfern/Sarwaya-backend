<?php  session_start();
date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/28/2019
 * Time: 11:29 AM
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

$agencyName = $object->selectAgencyNameByAgencyID($admin_agency);

if(isset($_POST['scheduleCar'])){

    $car            = $_POST['car'];
    $location       = $_POST['location'];
    $carAvailTime   = $_POST['avTime'];
    $carAvailDate   = $_POST['avDate'];

    $addCar = $object->addSchedule($car, $admin_agency, $location, $carAvailTime, $carAvailDate);

    if ($addCar) {
        echo '<script>alert("Schedule set successfully")</script>';
        ?>
        <script type="text/javascript">
            window.location = "schedule.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to schedule car, Try again!")</script>';
    }

}

?>
<div class="container" style="margin-top: 20px;">
    <section>
        <div class="container-fluid">
            <div class="row  align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h5 class="text-dark text-center font-weight-bold">Add new car</h5>
                            </div>
                            <div class="card-subtitle">
                                <form class="text-dark py-4" method="post">
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">Select car</label>
                                        <select name="car" class="form-control button-border form-control-sm">
                                            <?php
                                            $getAgencyCars = $object->getAgencyCars($admin_agency);
                                            while($row = $getAgencyCars->fetch(PDO::FETCH_ASSOC)) {
                                                $id = $row['agency_id'];
                                                $carPlateNumber = $row['car_plate_number'];
                                                ?>
                                                <option value="<?php echo $id;?>">
                                                    <?php echo $carPlateNumber;?>
                                                </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">Select location</label>
                                        <select name="location" class="form-control button-border form-control-sm">
                                            <?php
                                            $getAgencyLocations = $object->getAgencyLocations($admin_agency);
                                            while($row = $getAgencyLocations->fetch(PDO::FETCH_ASSOC)) {
                                                $id = $row['loc_id'];
                                                $from = $row['from_location'];
                                                $to = $row['to_location'];
                                                $locationCost = $row['location_cost'];
                                                ?>
                                                <option value="<?php echo $id;?>">
                                                    (<?php echo $from;?> >> <?php echo $to;?>) price: <?php echo $locationCost;?>
                                                </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group box-shadow">
                                        <label for="name"><span class="small font-weight-bold mr-5">Car Available Time</span>
                                            <input type="time" class="form-control button-border form-control-sm" id="avTime" name="avTime"
                                                   placeholder="Enter Car Available Time" required>
                                    </div>
                                    <div class="form-group box-shadow">
                                        <label for="name"><span class="small font-weight-bold mr-5">Car Available Date</span>
                                            <input type="date" class="form-control button-border form-control-sm" id="avDate" name="avDate"
                                                   placeholder="Enter Car Available Date" required>
                                    </div>
                                    <button class="btn btn-primary btn-block button-border" type="submit" name="scheduleCar">
                                        Make a schedule
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
                        <h6>List of schedule</h6>
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
                                    <th>Plate Number</th>
                                    <th>Agency</th>
                                    <th>FROM</th>
                                    <th>TO</th>
                                    <th>Car Depart. Time</th>
                                    <th>Car Depart. Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $data = $object->getAgencySchedule($admin_agency);

                                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $id = $row['id'];
                                    $carID = $row['car_id'];
                                    $locationID = $row['location_id'];
                                    $carDepartTime = $row['car_depart_time'];
                                    $carDepartDate = $row['car_depart_date'];

                                    $carName = $object->getCarName($carID);
                                    $fromLocationName = $object->getFromLocationName($locationID);
                                    $toLocationName = $object->getToLocationName($locationID);
                                    $locationCost = $object->getLocationCost($locationID);
                                    ?>
                                    <tr style="font-size: 11px;">
                                        <td><?php echo $carName;?></td>
                                        <td><?php echo $agencyName;?></td>
                                        <td><?php echo $fromLocationName;?></td>
                                        <td><?php echo $toLocationName;?></td>
                                        <td><?php echo $carDepartTime;?></td>
                                        <td><?php echo $carDepartDate;?></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-1">
                                                    <a href="edit_schedule.php?schedule=<?php echo $id;?>"><i class="fas fa-save fa-md text-success mr-2">Edit</i></a>
                                                </div>
                                            </div>
                                            <br>
                                        </td>
                                    </tr>
                                <?php }?>
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