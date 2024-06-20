<?php
require "Module.php";


session_start();

if(isset($_POST['submit'])){
    $id = 0;
    $user_id = $_SESSION['user_id'];
    $plant_nickname = $_POST['plantName'];
    $plant_type = $_POST['plantType'];
    $plant_age = $_POST['plantAge'];
    $action_suggest = "none";
   
    

    $total_num_files = count($_FILES['uploadImg']['name']);

    $filesArray = array();

    for ($i = 0; $i < $total_num_files; $i++){
            
        //this is the variable to store the actual name of the file including its extension
        $imageName = $_FILES['uploadImg']['name'][$i];

        //this variable contains the temporary name of the file, typically it is a path location in xammp
        $tmpName = $_FILES['uploadImg']["tmp_name"][$i];


        // at this line the $imageName is pass in the explode functin which returns a substrings of the $imageName at the delimiter "."
        $imageExtension = explode('.', $imageName);
        //at this line only getting the last substring in the $imageExtension, using it will acess the end substring that contains the extension of the file, and converting it to lowercase
        $imageExtension = strtolower(end($imageExtension));

        //the uniqid() returns a generated string that is unique and then append the . extension of the original file name
        $newImageName = uniqid() . "." .$imageExtension;


        move_uploaded_file($tmpName, '../plant_images_user/' . $newImageName);
        $filesArray[] = $newImageName;
    }


    $imageNameArray = json_encode($filesArray);

    $MyServer = new SERVER("plant");
   
    $sql = "INSERT INTO my_plant VALUES(?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $MyServer->ServerConnection->prepare( $sql );
    $stmt->bind_param("iissdss", $id, $user_id, $plant_nickname, $plant_type, $plant_age, $imageNameArray, $action_suggest);

    $stmt->execute();


    header('Location: ../myPlants.php');
    
}


?>