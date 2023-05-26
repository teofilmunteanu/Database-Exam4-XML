<?php
$name = $_GET['name'];

$xml_data = simplexml_load_file("CafesData.xml") or die("Error : Object Creation failure");
foreach ($xml_data->children() as $data)
    if($data->name == $_GET['name'])
    {
        unlink($data->src);
    }
$xml= new DOMDocument();
$xml->load('CafesData.xml');
$xpath= new DOMXPATH($xml);
foreach($xpath->query("/root/cafes[name='$name']")as $node){
    $node->parentNode->removeChild($node);
}
$xml->formatoutput=true;
$xml->save('CafesData.xml');



?>