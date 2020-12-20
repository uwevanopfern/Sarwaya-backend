<?php  session_start();
date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/12/2019
 * Time: 11:52 AM
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

if(isset($_POST['addTime'])){

    $agency     = $_POST['agency'];
    $datetime   = $_POST['datetime'];

    $addAgency = $object->addAgencyTime($agency, $datetime);

    if ($addAgency) {
        echo '<script>alert("Agency time is saved successfully")</script>';
        ?>
        <script type="text/javascript">
            window.location = "agency_time.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to add agency time, Try again!")</script>';
    }
}

?>
<script src="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="timepicker.css" rel="stylesheet"/>
<div class="container" style="margin-top: 20px;">
    <section>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h5 class="text-dark text-center font-weight-bold">Add new time of agency</h5>
                            </div>
                            <div class="card-subtitle">
                                <form class="text-dark py-4" method="post">
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="email">Select agency</label>
                                        <select name="agency" class="form-control button-border">
                                            <?php
                                            $getAllAgencies = $object->getAllAgencies();
                                            while($row = $getAllAgencies->fetch(PDO::FETCH_ASSOC)) {
                                                $id = $row['agency_id'];
                                                $name = $row['agency_name'];
                                                ?>
                                                <option value="<?php echo $id;?>">
                                                    <?php echo $name;?>
                                                </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group font-weight-bold small box-shadow">
                                        <label for="name">Add new time</label>
                                        <input type="text" name="datetime" id="time" class="form-control button-border form-control-sm"
                                               placeholder="Time" required>
                                    </div>
                                    <button class="btn btn-primary btn-block button-border" type="submit" name="addTime">
                                        Add new time
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
                        <h6>List of times of agencies</h6>
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
                                    <th>Agency Name</th>
                                    <th>Agency Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $data = $object->getAgencyTime();

                                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $id = $row['id'];
                                    $agencyID = $row['agency_id'];
                                    $time = $row['time'];

                                    $agencyName = $object->selectAgencyNameByAgencyID($agencyID);
                                    ?>
                                    <tr style="font-size: 11px;">
                                        <td><?php echo $agencyName;?></td>
                                        <td><?php echo $time;?></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-1">
                                                    <a href="edit_agency_time.php?agency_time_id=<?php echo $id;?>"><i class="fas fa-save fa-md text-success mr-2">Edit</i></a>
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
<script>
    var timepicker = new TimePicker('time', {
        theme: 'blue-grey',
        lang: 'en',

    });
    timepicker.on('change', function(evt) {

        var value = (evt.hour || '00') + ':' + (evt.minute || '00');
        evt.element.value = value;

    });
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>