<?php
session_start();
$name = $_GET['name'];
$currentEmail = $_SESSION['email'];

$xml= new DOMDocument();
$xml->load('CafesData.xml');

$xpath= new DOMXPATH($xml);
foreach ($xpath->query("/root/cafe[name='$name' and emailAssigned='$currentEmail']")as $node){
    $node->parentNode->removeChild($node);
}
$xml->formatoutput=true;
$xml->save('CafesData.xml');

header('location:index.php');

?>