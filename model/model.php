<?php
defined('APPTODO') or die('Access denied');

/* ====Authorization=== */
function authorization($tempsess){
    $login = trim($_POST['login']);
    $login = clear($login);
    $pass = trim($_POST['pass']);
    $query = "SELECT `id`, `name`, `password` FROM `users` WHERE `login` = '$login' LIMIT 1";
    $res = mysql_query($query) or die(mysql_error());
    $row = mysql_fetch_assoc($res);
    if($row['password'] == md5($pass)){
        $tempsess['isauth'] = 1;
        $tempsess['login_user'] = $login;
        $tempsess['id_user'] = $row['id'];
        $tempsess['name_user'] = $row['name'];
    }else{
        $tempsess['error'] = 'Login or password does not match!';
    }
    $_SESSION["tempsess"] = $tempsess;
}
/* ====Authorization=== */

/* ====Registration=== */
function registration($tempsess){
    $login = trim($_POST['login']);
    $login = clear($login);
    
    $query = "SELECT `id` FROM `users` WHERE `login` = '$login' LIMIT 1";
    $res = mysql_query($query) or die(mysql_error());
    $row = mysql_num_rows($res);
    if($row){//user already registered
        $tempsess['error'] = 'This user already registered, please check another login!';
    }else{//user not registred
        $pass = trim($_POST['pass']);
        $pass = md5($pass);
        $name = trim($_POST['name']);
        $name = clear($name);
        
        $query = "INSERT INTO `users` (`login`, `name`, `password`)
                    VALUES ('$login', '$name', '$pass')";
        $res = mysql_query($query) or die(mysql_error());
        if(!(mysql_affected_rows() > 0)){
            $tempsess['error'] = 'Login or password does not match!';
        }else{
            $tempsess['isauth'] = 1;
            $tempsess['login_user'] = $login;
            $tempsess['id_user'] = mysql_insert_id();
            $tempsess['name_user'] = $name;
            $tempsess['success'] = 'You successfully registered! Now you may create own todo list.';
        }
    }
    $_SESSION["tempsess"] = $tempsess;
}
/* ====Registration=== */

/* ====Geting todo list === */
function gettodolist($tempsess){
    $iduser = $tempsess['id_user'];
    
    $query = "SELECT `id`, `name`, `state` FROM `todos` WHERE `id_user` = '$iduser' ORDER BY `id`";
    $res = mysql_query($query) or die(mysql_error());
        
    $todolist = array();
    while($row = mysql_fetch_assoc($res)){
        $todolist[] = $row;
    }
    
    return $todolist; 
}
/* ====Geting todo list === */

/* ====AJAX Add todo=== */
function ajax_addtodo($tempsess){
    $iduser = $tempsess['id_user'];
    
    $name = trim($_POST['name']);
    $name = clear($name);

    $query = "INSERT INTO `todos` (`name`, `id_user`) VALUES ('$name', '$iduser')";
    $res = mysql_query($query) or die(mysql_error());
    if(!(mysql_affected_rows() > 0)){
        $res = array("answer" => "addtodo: May be no connection to the database, please come back later.");
        exit(json_encode($res));
    }
    
    $res = array("answer" => "OK", "id" => mysql_insert_id());
    exit(json_encode($res));
}
/* ====AJAX Add todo=== */

/* ====AJAX update todo=== */
function ajax_updatetodo($tempsess){
    $iduser = $tempsess['id_user'];
    
    $name = trim($_POST['name']);
    $name = clear($name);
    $idtodo = trim($_POST['id']);
    $idtodo = clear($idtodo);
        
    $query = "UPDATE `todos` SET `name` = '$name' WHERE `id` = '$idtodo' and `id_user` = '$iduser' LIMIT 1";
    $res = mysql_query($query) or die(mysql_error());
    if(!(mysql_affected_rows() > 0)){
        $res = array("answer" => "updatetodo: May be no connection to the database, please come back later.");
        exit(json_encode($res));
    }
    
    $res = array("answer" => "OK");
    exit(json_encode($res));
}
/* ====AJAX update todo=== */

/* ====AJAX check all todos=== */
function ajax_checkalltodos($tempsess){
    $iduser = $tempsess['id_user'];
        
    $query = "UPDATE `todos` SET `state` = 1 WHERE `id_user` = '$iduser'";
    $res = mysql_query($query) or die(mysql_error());
    if(!(mysql_affected_rows() > 0)){
        $res = array("answer" => "checkalltodos: May be no connection to the database, please come back later.");
        exit(json_encode($res));
    }
    
    $res = array("answer" => "OK");
    exit(json_encode($res));
}
/* ====AJAX check all todos=== */

/* ====AJAX uncheck all todos=== */
function ajax_uncheckalltodos($tempsess){
    $iduser = $tempsess['id_user'];
        
    $query = "UPDATE `todos` SET `state` = 0 WHERE `id_user` = '$iduser'";
    $res = mysql_query($query) or die(mysql_error());
    if(!(mysql_affected_rows() > 0)){
        $res = array("answer" => "uncheckalltodos: May be no connection to the database, please come back later.");
        exit(json_encode($res));
    }
    
    $res = array("answer" => "OK");
    exit(json_encode($res));
}
/* ====AJAX uncheck all todos=== */

/* ====AJAX check todo=== */
function ajax_checktodo($tempsess){
    $iduser = $tempsess['id_user'];
    
    $idtodo = trim($_POST['id']);
    $idtodo = clear($idtodo);
        
    $query = "UPDATE `todos` SET `state` = 1 WHERE `id` = '$idtodo' and `id_user` = '$iduser' LIMIT 1";
    $res = mysql_query($query) or die(mysql_error());
    if(!(mysql_affected_rows() > 0)){
        $res = array("answer" => "checktodo: May be no connection to the database, please come back later.");
        exit(json_encode($res));
    }
    
    $res = array("answer" => "OK");
    exit(json_encode($res));
}
/* ====AJAX check todo=== */

/* ====AJAX uncheck todo=== */
function ajax_unchecktodo($tempsess){
    $iduser = $tempsess['id_user'];
    
    $idtodo = trim($_POST['id']);
    $idtodo = clear($idtodo);
        
    $query = "UPDATE `todos` SET `state` = 0 WHERE `id` = '$idtodo' and `id_user` = '$iduser' LIMIT 1";
    $res = mysql_query($query) or die(mysql_error());
    if(!(mysql_affected_rows() > 0)){
        $res = array("answer" => "checktodo: May be no connection to the database, please come back later.");
        exit(json_encode($res));
    }
    
    $res = array("answer" => "OK");
    exit(json_encode($res));
}
/* ====AJAX uncheck todo=== */

/* ====AJAX remove todo=== */
function ajax_removetodo($tempsess){
    $iduser = $tempsess['id_user'];
    
    $idtodo = trim($_POST['id']);
    $idtodo = clear($idtodo);
        
    $query = "DELETE FROM `todos` WHERE `id` = '$idtodo' and `id_user` = '$iduser' LIMIT 1";
    $res = mysql_query($query) or die(mysql_error());
    if(!(mysql_affected_rows() > 0)){
        $res = array("answer" => "removetodo: May be no connection to the database, please come back later.");
        exit(json_encode($res));
    }
    
    $res = array("answer" => "OK");
    exit(json_encode($res));
}
/* ====AJAX remove todo=== */

/* ====AJAX remove completed todos=== */
function ajax_rmcompletedtodos($tempsess){
    $iduser = $tempsess['id_user'];
           
    $query = "DELETE FROM `todos` WHERE `state` = 1 and `id_user` = '$iduser'";
    $res = mysql_query($query) or die(mysql_error());
    if(!(mysql_affected_rows() > 0)){
        $res = array("answer" => "rmcompletedtodos: May be no connection to the database, please come back later.");
        exit(json_encode($res));
    }
    
    $res = array("answer" => "OK");
    exit(json_encode($res));
}
/* ====AJAX remove completed todos=== */

/* ====AJAX set filter for show todos === */
function ajax_setfilter($tempsess){
    $show = trim($_POST['show']);
    $show = clear($show);
    if($show != 'All' && $show != 'Active' && $show != 'Completed'){
        $res = array("answer" => "setfilter: show ".$show." todos not support");
        exit(json_encode($res));
    }
    $tempsess['show'] = $show;
    $_SESSION["tempsess"] = $tempsess;
    
    $res = array("answer" => "OK");
    exit(json_encode($res));
}
/* ====AJAX set filter for show todos === */