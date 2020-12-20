<?php  session_start();
date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/28/2019
 * Time: 2:01 PM
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

if (isset($_GET['schedule'])) {

    $schedule = $_GET['schedule'];
}

$agencyName = $object->selectAgencyNameByAgencyID($admin_agency);

if(isset($_POST['updateSchedule'])){

    $car            = $_POST['car'];
    $location       = $_POST['location'];
    $carAvailTime   = $_POST['avTime'];
    $carAvailDate   = $_POST['avDate'];

    $updateCar = $object->updateSchedule($schedule, $car, $location, $carAvailTime, $carAvailDate);

    if ($updateCar) {
        echo '<script>alert("Schedule is updated successfully")</script>';
        ?>
        <script type="text/javascript">
            window.location = "schedule.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to update Schedule, Try again!")</script>';
    }
}

if (isset($_POST['deleteSchedule'])) {

    $delete = $object->deleteSchedule($schedule);

    if ($delete){
        echo '<script>alert("Schedule deleted with success")</script>';
        ?>

        <script type="text/javascript">
            window.location = "schedule.php";
        </script>
        <?php
    } else {
        echo '<script>alert("Oops, Failed to delete, Try again!")</script>';
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
                                <h3 class="text-dark text-center font-weight-bold">Edit car information</h3>
                            </div>
                            <div class="card-subtitle">
                                <form class="text-dark py-4" method="post">
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">Select car</label>
                                        <select name="car" class="form-control button-border">
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
                                        <select name="location" class="form-control button-border">
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
                                            <input type="time" class="form-control button-border" id="avTime" name="avTime"
                                                   placeholder="Enter Car Available Time" required>
                                    </div>
                                    <div class="form-group box-shadow">
                                        <label for="name"><span class="small font-weight-bold mr-5">Car Available Date</span>
                                            <input type="date" class="form-control button-border" id="avDate" name="avDate"
                                                   placeholder="Enter Car Available Date" required>
                                    </div>
                                    <button class="btn btn-primary btn-block button-border" type="submit" name="updateSchedule">
                                        Edit schedule
                                    </button>
                                </form>
                                <form class="text-dark py-4" method="post">
                                    <button class="btn btn-danger btn-block button-border" type="submit" name="deleteSchedule">
                                        Delete schedule
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