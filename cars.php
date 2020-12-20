<?php  session_start();
date_default_timezone_set("Africa/Cairo");

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

if(isset($_POST['addCar'])){

    $plate          = $_POST['plate'];
    $description    = $_POST['description'];

    $checkCarExistance = $object->checkCarExistance($plate);


    if($checkCarExistance){
        echo '<script>alert("Oops, Plate number exists, Try new one!")</script>';
    }else{

        $addCar = $object->addCar($admin_agency, $plate, $description);

        if ($addCar) {
            echo '<script>alert("Car is saved successfully")</script>';
            ?>
            <script type="text/javascript">
                window.location = "cars.php";
            </script>
            <?php

        } else {
            echo '<script>alert("Oops, Failed to add car, Try again!")</script>';
        }
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
                                        <label for="email">Car Plate Number</label>
                                        <input type="text" class="form-control button-border form-control-sm" id="plate" name="plate"
                                               placeholder="Enter Plate Number" required>
                                    </div>
                                    <div class="form-group box-shadow">
                                        <label for="name"><span class="small font-weight-bold mr-5">Car description</span>
                                        <input type="text" class="form-control button-border form-control-sm" id="description" name="description"
                                               placeholder="Enter Car Description" required>
                                    </div>
                                    <button class="btn btn-primary btn-block button-border" type="submit" name="addCar">
                                        Add new car
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
                        <h6>List of all cars</h6>
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
                                    <th>Car Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $data = $object->getAgencyCars($admin_agency);

                                    while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $car_id = $row['car_id'];
                                    $car_plate_number = $row['car_plate_number'];
                                    $car_desc = $row['car_desc'];
                                ?>
                                <tr style="font-size: 11px;">
                                    <td><?php echo $car_plate_number;?></td>
                                    <td><?php echo $agencyName;?></td>
                                    <td><?php echo $car_desc;?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-1">
                                                <a href="edit_car.php?car_id=<?php echo $car_id;?>"><i class="fas fa-save fa-md text-success mr-2">Edit</i></a>
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