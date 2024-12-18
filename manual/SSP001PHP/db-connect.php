<?php 
// Hostname
$host = "localhost";
// Username
$uname = "root";
// Password
$pw = "";
// DB name
$db_name = "dummy_db";

try{
    // Opening Database Connection
    $conn = new mysqli($host, $uname, $pw, $db_name);
}catch(Exception $e){
    die($e->getMessage());
}

?>