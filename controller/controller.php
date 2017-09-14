<?php
defined('APPTODO') or die('Access denied');

session_start();

// connecting library of functions
require_once 'functions/functions.php';

// connecting model
require_once MODEL;

// Log Out user
if(isset($_GET['logout'])){
    unset($_SESSION["tempsess"]);
    redirect(PATH);
} 

// Init data session
if(isset($_SESSION["tempsess"])){
    $tempsess = $_SESSION["tempsess"];
}else{
    $tempsess = array(
                  'error' => 0,     
                  'success' => 0,   
                  'id_user' => 0,   
                  'login_user' => 0,
                  'name_user' => 0,  
                  'isauth' => 0,
                  'show' => 'All');
}

// getting a dynamic part of the template
$view = empty($_GET['view']) ? 'auth' : $_GET['view'];
// checking flag of user authorization
if($tempsess['isauth'] == 1) $view = 'apptodo';

switch($view){
    case('auth'):
        if($_POST){
            // verification of user authorization
            authorization($tempsess);       
            redirect();
        }
    break;
    
    case('reg'):
        if($_POST){
            // registration of user
            registration($tempsess);
            redirect();
        }     
    break;
    
    case('apptodo'):
        if($_POST){
            if($_POST['cmd'] == 'addtodo') ajax_addtodo($tempsess);
            else if($_POST['cmd'] == 'updatetodo') ajax_updatetodo($tempsess);
            else if($_POST['cmd'] == 'checkalltodos') ajax_checkalltodos($tempsess);
            else if($_POST['cmd'] == 'uncheckalltodos') ajax_uncheckalltodos($tempsess);
            else if($_POST['cmd'] == 'checktodo') ajax_checktodo($tempsess);
            else if($_POST['cmd'] == 'unchecktodo') ajax_unchecktodo($tempsess);
            else if($_POST['cmd'] == 'removetodo') ajax_removetodo($tempsess);
            else if($_POST['cmd'] == 'rmcompletedtodos') ajax_rmcompletedtodos($tempsess);
            else if($_POST['cmd'] == 'setfilter') ajax_setfilter($tempsess);
            redirect();
        }
        $todolist = gettodolist($tempsess);
    break;
    
    default:
        redirect();
}

// connecting view
require_once TEMPLATE.'index.php';