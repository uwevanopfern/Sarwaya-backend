<?php  session_start();
date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/26/2019
 * Time: 7:11 AM
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

if (isset($_GET['admin_id'])) {

    $adminID = $_GET['admin_id'];
}

$agencyName = $object->selectAgencyNameByAgencyID($admin_agency);

if(isset($_POST['editStaff'])){

    $staffName     = $_POST['staffName'];
    $staffPhone    = $_POST['staffPhone'];
    $staffEmail    = $_POST['staffEmail'];
    $staffPassword = $_POST['staffPassword'];

    $updateStaff = $object->updateStaff($adminID, $staffName, $staffPhone, $staffEmail, $staffPassword);

    if ($updateStaff) {
        echo '<script>alert("Staff is updated successfully")</script>';
        ?>
        <script type="text/javascript">
            window.location = "staff.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to update staff, Try again!")</script>';
    }
}

if (isset($_POST['deleteStaff'])) {

    $delete = $object->deleteStaff($adminID);

    if ($delete){
        echo '<script>alert("Staff deleted with success")</script>';
        ?>

        <script type="text/javascript">
            window.location = "staff.php";
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
                                <h5 class="text-dark text-center font-weight-bold">Edit staff information</h5>
                            </div>
                            <div class="card-subtitle">
                                <?php

                                $data = $object->getStaffDetails($adminID);

                                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $admin_id = $row['admin_id'];
                                    $admin_name = $row['admin_name'];
                                    $admin_phone = $row['admin_phone'];
                                    $admin_email = $row['admin_email'];
                                    $admin_password = $row['admin_password'];

                                    ?>
                                    <form class="text-dark py-4" method="post">
                                        <div class="form-group font-weight-bold small box-shadow">
                                            <label for="email">Staff Name</label>
                                            <input type="text" class="form-control button-border" id="staffName" name="staffName"
                                                   value="<?php echo $admin_name;?>" placeholder="Enter Staff Name">
                                        </div>
                                        <div class="form-group box-shadow">
                                            <label for="name"><span class="small font-weight-bold mr-5">Staff Phone</span>
                                                <input type="text" class="form-control button-border" id="staffPhone" name="staffPhone"
                                                       value="<?php echo $admin_phone;?>" placeholder="Enter Staff Phone">
                                        </div>
                                        <div class="form-group box-shadow">
                                            <label for="name"><span class="small font-weight-bold mr-5">Staff Email</span>
                                                <input type="text" class="form-control button-border" id="staffEmail" name="staffEmail"
                                                       value="<?php echo $admin_email;?>" placeholder="Enter Staff Email">
                                        </div>
                                        <div class="form-group box-shadow">
                                            <label for="name"><span class="small font-weight-bold mr-5">Staff Password</span>
                                                <input type="text" class="form-control button-border" id="staffPassword" name="staffPassword"
                                                       value="<?php echo $admin_password;?>" placeholder="Enter Staff Password">
                                        </div>
                                        <button class="btn btn-primary btn-block button-border" type="submit" name="editStaff">
                                            Edit Staff
                                        </button>
                                    </form>
                                <?php }?>
                                <form class="text-dark py-4" method="post">
                                    <button class="btn btn-danger btn-block button-border" type="submit" name="deleteStaff">
                                        Delete Staff
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
</html>