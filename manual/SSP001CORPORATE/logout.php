<?php
// Starting session
session_start();
 
// Removing session data
if(isset($_SESSION["lastname"]))
{
    unset($_SESSION["lastname"]);
}

// remove all session variables
session_unset();
// Destroying session
session_destroy();
?>