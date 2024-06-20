<?php
require "../php_script/Module.php";

$plantname = "Snake Plant";
$plantname = strtolower($plantname);
echo $plantname;
echo "<br>";

if(strpos($plantname,  'snake') !== false){
    echo "found";
}else{
    echo "not found";
}
?>