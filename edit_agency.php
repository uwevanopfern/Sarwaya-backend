<?php  session_start();
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/26/2019
 * Time: 6:15 AM
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

if (isset($_GET['agency_id'])) {

    $agencyID = $_GET['agency_id'];
}

$agencyName = $object->selectAgencyNameByAgencyID($admin_agency);

if(isset($_POST['editAgency'])){

    $agencyName     = $_POST['agencyName'];
    $description    = $_POST['description'];

    $updateCar = $object->updateAgency($agencyID, $agencyName, $description);

    if ($updateCar) {
        echo '<script>alert("Agency is updated successfully")</script>';
        ?>
        <script type="text/javascript">
            window.location = "agency.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to update agency, Try again!")</script>';
    }
}

if (isset($_POST['deleteAgency'])) {

    $delete = $object->deleteAgency($agencyID);

    if ($delete){
        echo '<script>alert("Agency deleted with success")</script>';
        ?>

        <script type="text/javascript">
            window.location = "agency.php";
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

                                $data = $object->getAgencyDetails($agencyID);

                                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $id = $row['agency_id'];
                                    $name = $row['agency_name'];
                                    $description = $row['agency_description'];

                                    ?>
                                    <form class="text-dark py-4" method="post">
                                        <div class="form-group box-shadow">
                                            <label for="email">Agency Name</label>
                                            <input type="text" class="form-control button-border" id="agencyName" name="agencyName"
                                                   value="<?php echo $name;?>" placeholder="Enter Agency Name">
                                        </div>
                                        <div class="form-group box-shadow">
                                            <label for="name">Agency Description</label>
                                                <input type="text" class="form-control button-border" id="description" name="description"
                                                       value="<?php echo $description;?>" placeholder="Enter Agency Description">
                                        </div>
                                        <button class="btn btn-primary btn-block button-border" type="submit" name="editAgency">
                                            Edit Agency
                                        </button>
                                    </form>
                                <?php }?>
                                <form class="text-dark py-4" method="post">
                                    <button class="btn btn-danger btn-block button-border" type="submit" name="deleteAgency">
                                        Delete Agency
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