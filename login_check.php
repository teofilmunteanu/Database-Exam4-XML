<?php
session_start();

$xml=simplexml_load_file("UsersData.xml") or die("Error: Cannot create object");

$message="Failed";

if(($_POST['email'] != "") && ($_POST['password'] != "")){
    $email = $_POST['email'];
    $pass = md5($_POST['password']);
    
    $userExists = false;
    foreach ($xml->children() as $data){
        if($_POST['email'] == $data->email){
            $userExists = true;
            break;
        }
    }
    
    if($userExists){
        if(isset($_POST['rememberMe'])){
            $expirationAdder = 60*60*24*365;
            setcookie('email', $email, time()+$expirationAdder);
        }

        $message = "Success";
        $_SESSION['email'] = $email;

        header('location: index.php');    
    }
    else{
        $message = "Email/Password Invalid.";
    }
}
else{
    $message = "You must supply an email and password.";
}


if($message == "Failed"){
    $message = "Something went wrong";
}

if($message != "Success")
{
    $_SESSION['messageLogIn'] = $message;
    header('location: login.php');
}

?>

