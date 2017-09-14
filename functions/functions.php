<?php
defined('APPTODO') or die('Access denied');

/* ===Print array=== */
function print_arr($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
/* ===Print array=== */

/* ===Filter incoming data=== */
function clear($var){
    $var = mysql_real_escape_string(strip_tags($var));
    return $var;
}
/* ===Filter incoming data=== */

/* ===Redirect=== */
function redirect($http = false){
    if($http) $redirect = $http;
    else    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}
/* ===Redirect=== */