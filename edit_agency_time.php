<?php  session_start();
date_default_timezone_set("Africa/Cairo");
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/12/2019
 * Time: 10:33 PM
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

if (isset($_GET['agency_time_id'])) {

    $agencyTimeID = $_GET['agency_time_id'];
}

$agencyName = $object->selectAgencyNameByAgencyID($admin_agency);

if(isset($_POST['editAgencyTime'])){

    $datetime       = $_POST['datetime'];

    $updateCar = $object->updateAgencyTime($agencyTimeID, $datetime);

    if ($updateCar) {
        echo '<script>alert("Agency time is updated successfully")</script>';
        ?>
        <script type="text/javascript">
            window.location = "agency_time.php";
        </script>
        <?php

    } else {
        echo '<script>alert("Oops, Failed to update agency time, Try again!")</script>';
    }
}

if (isset($_POST['deleteAgencyTime'])) {

    $delete = $object->deleteAgencyTime($agencyTimeID);

    if ($delete){
        echo '<script>alert("Agency time deleted with success")</script>';
        ?>

        <script type="text/javascript">
            window.location = "agency_time.php";
        </script>
        <?php
    } else {
        echo '<script>alert("Oops, Failed to delete, Try again!")</script>';
    }
}

?>
<script src="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="timepicker.css" rel="stylesheet"/>
<div class="container"style="margin-top: 20px;">
    <section>
        <div class="container-fluid">
            <div class="row  align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-dark text-center font-weight-bold">Edit agency time information</h3>
                            </div>
                            <div class="card-subtitle">
                                <?php

                                $data = $object->getAgencyTimeByID($agencyTimeID);

                                while($row = $data->fetch(PDO::FETCH_ASSOC)) {
                                    $ID = $row['id'];
                                    $time = $row['time'];
                                    ?>
                                    <form class="text-dark py-4" method="post">
                                        <div class="form-group font-weight-bold small box-shadow">
                                            <label for="email">Agency Time</label>
                                            <input type="text" name="datetime" id="time" class="form-control button-border"
                                                   value="<?php echo $time;?>" placeholder="Enter Plate Number">
                                        </div>
                                        <button class="btn btn-primary btn-block button-border" type="submit" name="editAgencyTime">
                                            Edit agency time
                                        </button>
                                    </form>
                                <?php }?>
                                <form class="text-dark py-4" method="post">
                                    <button class="btn btn-danger btn-block button-border" type="submit" name="deleteAgencyTime">
                                        Delete agency time
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