<?php

session_start();

$msg = "Saved";

$xml=simplexml_load_file("CafesData.xml") or die("Error: Cannot create object");

if(isset($_POST['submit'])){ 
    $name=$_POST['cafe_name'];
    $loc=$_POST['cafe_location'];
    $desc=$_POST['cafe_description'];
    $email=$_SESSION['email'];
    
    if($name=="" || $loc=="" || $desc==""){
        $msg="All fields are mandatory!";
    }
    else{
        $cafeExists = false;
        
        foreach ($xml->children() as $data){
            if($email== $data->emailAssigned && $name == $data->name){
                $cafeExists = true;
                break;
            }
        }
        
        if(!$cafeExists){
            if (!file_exists('./images/')) {
                mkdir('./images', 0777, true);
            }

            $target="./images/". md5(uniqid(time())).basename($_FILES['image']['name']);

            if(! move_uploaded_file($_FILES['image']['tmp_name'],$target)){
                $msg="File not saved!";
            }
            else{
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimetype = finfo_file($finfo, $target);
                $fileTypes = array("jpg", "jpeg", "png", "gif");
                $ok = false;
                foreach($fileTypes as $ft){
                    if($mimetype == 'image/'.$ft){
                        $ok = true;
                    }
                }
                if(! $ok){
                    $msg="Invalid file format!";
                }
            }      
        }
        else{
            $msg = "Caffe already added to this user!";
        }
    }
    
    
    if($msg == "Saved"){         
        $date=$xml->addChild('cafe');
        $date->addChild('name', $name);     
        $date->addChild('location', $loc); 
        $date->addChild('description', $desc);
        $date->addChild('image', $target);
        $date->addChild('emailAssigned', $email); 
//        $date->addChild('delete', 'delete.php?name='.$name);
        file_put_contents('CafesData.xml', $xml->asXML());
         
        header('location:index.php');
    }
    
}
?>

<html>
    <head>
        <title>Upload Cafe</title>
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css1/mystyles2.css" rel="stylesheet">

    </head>
    
    <body>
        <div class="wrapper">
            <div id="formContent">
                <?php 
                    echo $msg;
                ?>
                <br/>
                <a type="button" class="btn btn-primary" href='index.php'>Back</a>
            </div>
        </div>
    </body>
</html>