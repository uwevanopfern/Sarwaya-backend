<?php  session_start();
date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2019
 * Time: 7:39 PM
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

if (isset($_GET['car_id'])) {

    $carID = $_GET['car_id'];
}

$agencyName = $object->selectAgencyNameByAgencyID($admin_agency);

if(isset($_POST['editCar'])){

    $plate          = $_POST['plate'];
    $description    = $_POST['description'];

    $updateCar = $object->updateCar($carID, $plate, $description);

    if ($updateCar) {
        echo '<script>alert("Car is updated successfully")</script>';
        ?>
        <script type="text/javascript">
            window.location = "cars.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to update car, Try again!")</script>';
    }
}

if (isset($_POST['deleteCar'])) {

    $delete = $object->deleteCar($carID);

    if ($delete){
        echo '<script>alert("Car deleted with success")</script>';
        ?>

        <script type="text/javascript">
            window.location = "cars.php";
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
                                <?php

                                $data = $object->getCarDetails($carID);

                                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $car_id = $row['car_id'];
                                    $car_plate_number = $row['car_plate_number'];
                                    $car_desc = $row['car_desc'];

                                ?>
                                <form class="text-dark py-4" method="post">
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">Car Plate Number</label>
                                        <input type="text" class="form-control button-border" id="plate" name="plate"
                                               value="<?php echo $car_plate_number;?>" placeholder="Enter Plate Number">
                                    </div>
                                    <div class="form-group box-shadow">
                                        <label for="name"><span class="small font-weight-bold mr-5">Car description</span>
                                            <input type="text" class="form-control button-border" id="description" name="description"
                                                   value="<?php echo $car_desc;?>" placeholder="Enter Car Description">
                                    </div>
                                    <button class="btn btn-primary btn-block button-border" type="submit" name="editCar">
                                        Edit car
                                    </button>
                                </form>
                                <?php }?>
                                <form class="text-dark py-4" method="post">
                                    <button class="btn btn-danger btn-block button-border" type="submit" name="deleteCar">
                                        Delete car
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