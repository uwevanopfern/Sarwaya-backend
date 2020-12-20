<?php  session_start();
date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/26/2019
 * Time: 2:39 PM
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

if(isset($_POST['addLocation'])){

    $from       = $_POST['from'];
    $to         = $_POST['to'];
    $locationCost     = $_POST['locationCost'];

    $checkLocationExistance = $object->checkLocationExistance($from, $to, $admin_agency);

    if($checkLocationExistance){
        echo '<script>alert("Oops, Location Name exists, Try new one!")</script>';
    }else{

        $addLocation = $object->addLocation($from, $to, $admin_agency, $locationCost);

        if ($addLocation) {
            echo '<script>alert("Location is saved successfully")</script>';
            ?>
            <script type="text/javascript">
                window.location = "locations.php";
            </script>
            <?php

        } else {
            echo '<script>alert("Oops, Failed to add location, Try again!")</script>';
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
                                <h5 class="text-dark text-center font-weight-bold">Add new location</h5>
                            </div>
                            <div class="card-subtitle">
                                <form class="text-dark py-4" method="post">
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">From</label>
                                        <input type="text" class="form-control button-border form-control-sm" id="from" name="from"
                                               placeholder="Enter FROM location" required>
                                    </div>
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">To</label>
                                        <input type="text" class="form-control button-border form-control-sm" id="to" name="to"
                                               placeholder="Enter TO location" required>
                                    </div>
                                    <div class="form-group box-shadow">
                                        <label for="name">Location Travel Cost</label>
                                        <input type="text" class="form-control button-border form-control-sm" id="locationCost" name="locationCost"
                                               placeholder="Enter location travel Cost e.g: 2000" required>
                                    </div>
                                    <button class="btn btn-primary btn-block button-border" type="submit" name="addLocation">
                                        Add new location
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
                        <h6>List of all locations</h6>
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
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Location Travel Cost</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $data = $object->getAllLocations($admin_agency);

                                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $id = $row['loc_id'];
                                    $from = $row['from_location'];
                                    $to = $row['to_location'];
                                    $location_cost = $row['location_cost'];
                                    ?>
                                    <tr style="font-size: 11px;">
                                        <td><?php echo $from;?></td>
                                        <td><?php echo $to;?></td>
                                        <td><?php echo $location_cost." RWF";?></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-1">
                                                    <a href="edit_location.php?location_id=<?php echo $id;?>"><i class="fas fa-save fa-md text-success mr-2">Edit</i></a>
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