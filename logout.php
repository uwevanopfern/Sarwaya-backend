<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2019
 * Time: 3:41 PM
 */

session_start();
include('include/functions.php');


$object = new Functions();
$out = $object->logout();

return $out;
