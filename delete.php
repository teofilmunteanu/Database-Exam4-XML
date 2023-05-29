<?php
$name = $_GET['name'];

$xml= new DOMDocument();
$xml->load('CafesData.xml');

$xpath= new DOMXPATH($xml);
foreach ($xpath->query("/root/cafe[name='$name']")as $node){
    $node->parentNode->removeChild($node);
}
$xml->formatoutput=true;
$xml->save('CafesData.xml');

header('location:index.php');

?>