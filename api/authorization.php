<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/29/2019
 * Time: 5:38 AM
 */
define('BEARER_TOKEN','Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUuY29tIiwiaWF0IjoxMzU2OTk5NTI0LCJuYmYiOjEzNTcwMDAwMDAsImRhdGEiOnsiY3VzdG9tZXJfaWQiOiIyIiwiY3VzdG9tZXJfbmFtZSI6IjA3ODI4MTY1OTciLCJjdXN0b21lcl9waG9uZSI6IjA3ODI4MTY1OTciLCJjdXN0b21lcl9lbWFpbCI6InZhbkBnbWFpbC5jb20ifX0.3aklHnp9QaPGoiZTrQK0ks8BE-xcIm4HCxrGj-7rcQo');

class Authorization{

    public function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    public function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/SarwayaBearerToken\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
    }
}
