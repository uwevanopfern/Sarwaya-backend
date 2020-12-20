<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/29/2019
 * Time: 5:15 AM
 */

// show error reporting
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set("Africa/Cairo");

// variables used for jwt
$key = "example_key";
$iss = "http://example.org";
$aud = "http://example.com";
$iat = 1356999524;
$nbf = 1357000000;
$exp = time() + (9000000000000000*60);
