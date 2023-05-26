
<?php

if(isset($_COOKIE['email'])){
    $email = $_COOKIE['email'];

    unset($_COOKIE['email']);
    setcookie('email', '', time() - 3600);
}

session_start();
session_unset();
session_destroy();
header('location:index.php');

?>
