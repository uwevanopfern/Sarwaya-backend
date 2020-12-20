<?php  session_start();
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/26/2019
 * Time: 3:11 PM
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

if (isset($_GET['location_id'])) {

    $locationID = $_GET['location_id'];
}

$agencyName = $object->selectAgencyNameByAgencyID($admin_agency);

if(isset($_POST['editLocation'])){

    $from             = $_POST['from'];
    $to               = $_POST['to'];
    $locationCost     = $_POST['locationCost'];

    $updateCar = $object->updateLocation($locationID, $from, $to, $locationCost);

    if ($updateCar) {
        echo '<script>alert("Location is updated successfully")</script>';
        ?>
        <script type="text/javascript">
            window.location = "locations.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to update location, Try again!")</script>';
    }
}

if (isset($_POST['deleteLocation'])) {

    $delete = $object->deleteLocation($locationID);

    if ($delete){
        echo '<script>alert("Location deleted with success")</script>';
        ?>

        <script type="text/javascript">
            window.location = "locations.php";
        </script>
        <?php
    } else {
        echo '<script>alert("Oops, Failed to delete, Try again!")</script>';
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
                                <h5 class="text-dark text-center font-weight-bold">Edit agency information</h5>
                            </div>
                            <div class="card-subtitle">
                                <?php

                                $data = $object->getLocationDetails($locationID);

                                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $id = $row['loc_id'];
                                    $from = $row['from_location'];
                                    $to = $row['to_location'];
                                    $location_cost = $row['location_cost'];

                                    ?>
                                    <form class="text-dark py-4" method="post">
                                        <div class="form-group box-shadow">
                                            <label for="email">From Name</label>
                                            <input type="text" class="form-control button-border" id="from" name="from"
                                                   value="<?php echo $from;?>" placeholder="Enter from Name">
                                        </div>
                                        <div class="form-group box-shadow">
                                            <label for="email">To Name</label>
                                            <input type="text" class="form-control button-border" id="to" name="to"
                                                   value="<?php echo $to;?>" placeholder="Enter to Name">
                                        </div>
                                        <div class="form-group box-shadow">
                                            <label for="name">Location Travel Cost</label>
                                            <input type="text" class="form-control button-border" id="description" name="locationCost"
                                                   value="<?php echo $location_cost;?>" placeholder="Enter Location Cost">
                                        </div>
                                        <button class="btn btn-primary btn-block button-border" type="submit" name="editLocation">
                                            Edit Location
                                        </button>
                                    </form>
                                <?php }?>
                                <form class="text-dark py-4" method="post">
                                    <button class="btn btn-danger btn-block button-border" type="submit" name="deleteLocation">
                                        Delete Location
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