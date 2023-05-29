<?php
class User{
    public $email;
    public $pass;
    public $lastName;
    public $firstName;
    
    public function setData($e, $p, $ln, $fn){
        $this->email = $e;
        $this->pass = $p;
        $this->lastName = $ln;
        $this->firstName = $fn;
    }
}

session_start();

$xml=simplexml_load_file("UsersData.xml") or die("Error: Cannot create object");

$message="Failed";

if(($_POST['email'] != "") && ($_POST['password'] != "")
        && ($_POST['cpassword'] != "") && ($_POST['lastName'] != "")
        && ($_POST['firstName'] != "")){
    $email = $_POST['email'];

    $emailTaken = false;
    foreach ($xml->children() as $data){
        if($_POST['email'] == $data->email){
            $emailTaken = true;
            break;
        }
    }
    
    
    if(!$emailTaken){
        if(strlen($_POST['password'])>=6){
            if($_POST['password'] == $_POST['cpassword']){
                $user = new User();
                $user->setData($_POST['email'], md5($_POST['password']), $_POST['lastName'], $_POST['firstName']);
                
                $date=$xml->addChild('user');
                $date->addChild('email', $user->email); 
                $date->addChild('lastName', $user->lastName);                
                $date->addChild('firstName', $user->firstName); 
                $date->addChild('password', $user->pass);
                file_put_contents('UsersData.xml', $xml->asXML());

                $message = "Success";

                header('location: index.php');  
            }
            else{
                $message = "Passwords must match";
            }        
        }
        else{
            $message = "Password is too short.";
        }
    }
    else
    {
        $message = "Email already used.";
    }
}
else{
    $message = "All of the fields are mandatory";
}


if($message == "Failed"){
    $message = "Something went wrong";
}

if($message != "Success")
{
    $_SESSION['messageSignUp'] = $message;
    header('location: signup.php');
}


?>

