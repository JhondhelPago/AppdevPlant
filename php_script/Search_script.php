<?php
require "Module.php";
session_start();


if(isset($_POST['submit'])){
    $_SESSION['search_bar'] = true;

    $_SESSION['search_param'] = $_POST['search_word'];

    // $MyServer = new SERVER('plant');
    // $result = $MyServer->ServerConnection->query("SELECT * FROM more_plant");

    // $MorePlant = ObjectTools::more_plant_to_MorePlant_Object($result);

    // $searchResultArray = array();

    // foreach($MorePlant as $PlantObject){
    //     $plantName = strtolower($PlantObject->plant_type);
        
    //     if(strpos($plantName, $search_param)){
    //         $searchResultArray[] = $PlantObject;
    //     }
    // }


    header('Location: ../morePlants.php');

}


?>