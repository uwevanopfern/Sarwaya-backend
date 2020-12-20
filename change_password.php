<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/10/2019
 * Time: 2:11 PM
 */

include("include/functions.php");
$object = new Functions();

if(isset($_GET['email']) && !empty($_GET['email'])){
    $email = $_GET['email'];
}

if (isset($_POST['change'])) {

    $password           = $_POST['password'];
    $confirm_password   = $_POST['confirm_password'];

    if ($password != $confirm_password) {

        echo '<script>alert("Oops, Password dont match, Try again!")</script>';

    } else {

        $changePassword = $object->addNewCustomerPassword($email, $password);
        if($changePassword){
            echo '<script>alert("Password changed with success, return in the app and login again")</script>';
        }else{
            echo '<script>alert("Failed to change password, Try again!")</script>';
        }
    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="title icon" type="image/png" href="images/logo">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>sarwaya</title>
</head>
<body>
<section class="bg-white py-5 my-5">
    <div class="container-fluid py-2 mx-2">
        <div class="row">
            <div class="col-lg-4 col-sm-10 mx-auto mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-dark text-center font-weight-bold">Create new Password</h3>
                        </div>
                        <div class="card-subtitle">
                            <form class="text-dark py-4" method="post">
                                <div class="form-group font-weight-bold small box-shadow">
                                    <label for="email">New Password</label>
                                    <input type="password" class="form-control button-border" id="password" name="password"
                                           placeholder="Enter new password" required>
                                </div>
                                <div class="form-group box-shadow">
                                    <label for="name"><span class="small font-weight-bold mr-5">Confirm Password</span></label>
                                    <input type="password" class="form-control button-border" id="confirm_password" name="confirm_password"
                                           placeholder="Confirm new password" required>
                                </div>
                                <button class="btn btn-primary btn-block button-border" type="submit" name="change">
                                   Change password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
