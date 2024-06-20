<?php
require "Module.php";

$MyServer = new SERVER('plant');
$sql = " UPDATE number SET numbers = numbers + 1 WHERE id = 0";
$MyServer->ServerConnection->query($sql);

?>