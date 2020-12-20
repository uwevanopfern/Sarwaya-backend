<?php  session_start();
date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2019
 * Time: 2:21 PM
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

if(isset($_POST['addStaff'])){

    $staffName     = $_POST['staffName'];
    $staffPhone    = $_POST['staffPhone'];
    $staffEmail    = $_POST['staffEmail'];
    $staffPassword = $_POST['staffPassword'];


    $addStaff = $object->addStaff($admin_agency, $staffName, $staffPhone, $staffEmail, $staffPassword);

    if ($addStaff) {
        echo '<script>alert("Staff is saved successfully")</script>';
        ?>
        <script type="text/javascript">
            window.location = "staff.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to add staff, Try again!")</script>';
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
                                <h5 class="text-dark text-center font-weight-bold">Add new staff</h5>
                            </div>
                            <div class="card-subtitle">
                                <form class="text-dark py-4" method="post">
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">Staff Name</label>
                                        <input type="text" class="form-control button-border" id="staffName" name="staffName"
                                               placeholder="Enter Staff Name" required>
                                    </div>
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">Staff Phone</label>
                                        <input type="text" class="form-control button-border" id="staffPhone" name="staffPhone"
                                               placeholder="Enter Staff Phone" required>
                                    </div>
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">Staff Email</label>
                                        <input type="email" class="form-control button-border" id="staffEmail" name="staffEmail"
                                               placeholder="Enter Staff Email" required>
                                    </div>
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">Staff Password</label>
                                        <input type="password" class="form-control button-border" id="staffPassword" name="staffPassword"
                                               placeholder="Enter Staff Password" required>
                                    </div>
                                    <button class="btn btn-primary btn-block button-border" type="submit" name="addStaff">
                                        Add new staff
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
                        <h6>List of all staff</h6>
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
                                    <th>Staff Name</th>
                                    <th>Staff Phone</th>
                                    <th>Staff Email</th>
                                    <th>Staff Password</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $data = $object->getAllStaff($admin_agency);

                                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $admin_id = $row['admin_id'];
                                    $admin_name = $row['admin_name'];
                                    $admin_phone = $row['admin_phone'];
                                    $admin_email = $row['admin_email'];
                                    $admin_password = $row['admin_password'];
                                    ?>
                                    <tr style="font-size: 11px;">
                                        <td><?php echo $admin_name;?></td>
                                        <td><?php echo $admin_phone;?></td>
                                        <td><?php echo $admin_email;?></td>
                                        <td><?php echo $admin_password;?></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-1">
                                                    <a href="edit_staff.php?admin_id=<?php echo $admin_id;?>"><i class="fas fa-save fa-md text-success mr-2">Edit</i></a>
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