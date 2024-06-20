<?php
require "php_script/Module.php";
session_start();

if (isset($_SESSION['search_bar'])) {
    $search_param = strtolower($_SESSION['search_param']);

    $MyServer = new SERVER('plant');
    $result = $MyServer->ServerConnection->query("SELECT * FROM more_plant");

    $MorePlant = ObjectTools::more_plant_to_MorePlant_Object($result);

    $searchResultArray = array();

    foreach ($MorePlant as $PlantObject) {
        $plantName = strtolower($PlantObject->plant_type);

        if (strpos($plantName, $search_param) !== false) {
            $searchResultArray[] = $PlantObject;
        }
    }

    $MorePlantObject = $searchResultArray;
    unset($_SESSION['search_bar']);
    unset($_SESSION['search_param']);
    echo "true";
} else {

    $MyServer = new SERVER("plant");
    $result = $MyServer->ServerConnection->query("SELECT * FROM more_plant");
    $MorePlantObject = ObjectTools::more_plant_to_MorePlant_Object($result);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Plants</title>
    <link rel="icon" type="image/x-icon" href="leaf-solid.svg">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- iconscout -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Slab:ital,wght@0,700;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <!-- custom css -->
    <link rel="stylesheet" href="all.css">
</head>
<!-- dark 2B4141 -->
<!-- light 8accbb -->

<body class="row m-0 p-0 justify-content-center">
    <div class="row m-0 p-0 col col-sm-11 col-xxl-10 ">
        <!-- nav -->
        <div class="container px-xxl-0 border-bottom">
            <nav class="navbar navbar-expand-lg navbar-white">
                <div class="container-fluid justify-content-start">
                    <i class="fa-solid fa-leaf fs-3 me-2" style="color: #2B4141;"></i>
                    <a class="navbar-brand fs-3 fw-bold" style="color: #2B4141;" href="myPlants.html">Plant Assist</a>
                    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars" style="color: #2b4141;"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- links -->
                        <ul class="navbar-nav mx-auto my-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link fw-semibold" style="color: #2b4141;" aria-current="page" href="myPlants.php">My Plants</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold active" style="color: #2b4141;" href="morePlants.php">More Plants</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold" style="color: #2b4141;" href="profile.php">Profile</a>
                            </li>
                        </ul>
                        <!-- search -->
                        <form class="d-flex" method="post" action="php_script/Search_script.php">
                            <input class="form-control me-2 rounded-pill px-4" style="color: #2B4141;" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn rounded-pill btnHover" style="border: 1px solid #2b4141;" type="submit" name="submit"><i class="bi bi-search" style="color: #2B4141;"></i></button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
        <!-- body -->
        <div class="container px-xxl-0 py-3">
            <!-- list container -->
            <div class="row gap-4 justify-content-center overflow-auto" style="margin-bottom: 50px;">
                <!-- item container -->
                <?php
                foreach ($MorePlantObject as $Plant) {
                ?>
                    <form class="contianer row justify-content-center align-items-center text-center text-xl-start gap-3 p-2" style="border-radius: 2.5rem; background: #70dada1e;">
                        <!-- img contaier -->
                        <div class="carousel slide carousel-dark slide col m-0 p-0 justify-content-center align-items-center text-center" id="carouselExampleControls" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <!-- img -->
                                <div class="carousel-item active">
                                    <img class="img-fluid justify-content-center text-center" style="min-width: 350px; min-height: 350px; max-height: 45vh; max-width: 45vh; border-radius: 2rem;" src="<?php echo "plant_images/" . $Plant->getPlantImages()[0]; ?>" alt="plant image">
                                </div>
                                <!-- sample 2nd img -->

                                <?php
                                $i = 1;
                                while ($i < count($Plant->getPlantImages())) {
                                ?>

                                    <div class="carousel-item">
                                        <img class="img-fluid justify-content-center text-center" style="min-width: 350px; min-height: 350px; max-height: 45vh; max-width: 45vh; border-radius: 2rem;" src="<?php echo "plant_images/" . $Plant->getPlantImages()[$i]; ?>" alt="plant image">
                                    </div>

                                <?php
                                    $i++;
                                }
                                ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <!-- info -->
                        <div class="col-12 col-xl-6 col-xxl-7">
                            <h2 class="fw-semibold mb-3 mx-4 mx-md-0">Plant Nickname: <?php echo $Plant->plant_type; ?> </h2>

                            <h4 class="fw-normal mb-3 mx-4 mx-md-0">Scientific Name: <em><?php echo $Plant->plant_scientific_name; ?></em></h4>

                            <p class="fs-6 fw-light mb-0 mx-4 mx-md-0 text-decoration-underline"><a style="text-decoration: none; color: inherit;" href="">Planting Procedure:</a></p>
                            <p><?php echo $Plant->planting_procedure; ?></p>

                            <iframe class="ratio" src="<?php echo $Plant->planting_vid_link; ?>" width="560" height="315" title="A YouTube video" frameborder="0" allowfullscreen></iframe>

                            <p class="fs-6 fw-light mb-0 mx-4 mx-md-0 text-decoration-underline">Plant Temperature Range:</p>
                            <p class="fs-5 mb-3"><?php echo  $Plant->Lowest_Temp . " - " . $Plant->Highest_Temp;  ?></p>

                            <p class="fs-6 fw-light mb-0 mx-4 mx-md-0 text-decoration-underline">Plant Trivia:</p>
                            <p><?php echo $Plant->plant_trivia; ?></p>

                            <!-- <button class="w-100 btn rounded-pill btnHover mb-3" style="color: #2B4141; border-color: #2B4141;">View Plant</button>
                            <button class="w-100 btn rounded-pill removeBtnHover" style="color: #2B4141; border-color: #2B4141;">Remove Plant</button> -->
                        </div>
                    </form>
                    <!-- temp -->
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/817c4fe6aa.js" crossorigin="anonymous"></script>
</body>

</html>