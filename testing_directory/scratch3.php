<?php
require "../php_script/Module.php";
$report = new Weather();

echo $report->json_response;

echo "<br>";

echo $report->responseArray[0]->values['temperature'];


?>