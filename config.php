<?php
defined('APPTODO') or die('Access denied');

// domen
define('PATH', 'https://mychoice1986.dlinkddns.com/');

// model
define('MODEL', 'model/model.php');

// controller
define('CONTROLLER', 'controller/controller.php');

// folder with all templates 
define('VIEW', 'views/');

// folder with active template
define('TEMPLATE', VIEW.'mytodo/');

// server DB
define('HOST', 'localhost');

// user
define('USER', 'mytodo_user');

// password
define('PASS', '123');

// name DB
define('DB', 'apptodo');

// flag of use my local server
// 0 - I'am not use my local server
// 1 - I'am use my local server
define('DENWER', 1);

mysql_connect(HOST, USER, PASS) or die('No connect to Server');
mysql_select_db(DB) or die('No connect to DB');
mysql_query("SET NAMES 'UTF8'") or die('Cant set charset');