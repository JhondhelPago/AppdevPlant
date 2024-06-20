<?php
require "php_script/Module.php";
session_start();

$id = $_SESSION['user_id'];

$MyServer = new SERVER('plant');
$sql = "SELECT * FROM my_plant WHERE user_id = $id";
$result = $MyServer->ServerConnection->query($sql);

$MyPlantObjectArray = ObjectTools::my_plant_to_MyPlant_Object($result);


if (isset($_POST['remove'])) {


    $id  = $_POST['plantid'];

    removePlant($id);
    echo "<script>alert('plant remove')</script>";
    echo "<script>window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";

    // echo "remove";
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
                                <a class="nav-link fw-bold active" style="color: #2b4141;" aria-current="page" href="myPlants.php">My Plants</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold" style="color: #2b4141;" href="morePlants.php">More Plants</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-semibold" style="color: #2b4141;" href="profile.php">Profile</a>
                            </li>
                        </ul>
                        <!-- search -->
                        <form class="d-flex">
                            <input class="form-control me-2 rounded-pill px-4" style="color: #2B4141;" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn rounded-pill btnHover" style="border: 1px solid #2b4141;" type="submit"><i class="bi bi-search" style="color: #2B4141;"></i></button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
        <!-- body -->
        <div class="container px-xxl-0 py-3">
            <!-- add plant container -->
            <div class="row gap-4 justify-content-center overflow-auto">
                <!-- item container -->
                <form class="contianer row justify-content-center align-items-center text-center text-xl-start gap-3 p-2" style="border-radius: 2.5rem;" enctype="multipart/form-data" method="post" action="php_script/AddPlant.php">
                    <div class="row display-6 fw-semibold justify-content-center">
                        <h1 class="d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-plus me-3 fs-4 align-items-center"></i>
                            New Plant
                            <i class="fa-solid fa-plus ms-3 fs-4 align-items-center"></i>
                        </h1>
                    </div>
                    <!-- img -->
                    <!-- <div class="col m-0 p-0 justify-content-center align-items-center text-center" style="">
                        col-12 col-sm-9 col-lg-5  p-0 mb-2 mb-md-0
                        <img class="img-fluid justify-content-center text-center" style="min-width: 350px; min-height: 350px; max-height: 45vh; max-width: 45vh; border-radius: 2rem;" src="sample1.png" alt="plant image">
                    </div> -->
                    <!-- info -->
                    <div class="row col-12 col-md-9 col-xl-7 gap-3" style="color: #2B4141;">
                        <div class="form-floating px-0">
                            <input type="text" class="form-control rounded-pill lead px-4" style="color: #2B4141;" name="plantName" id="plantName" placeholder="Plant Name" required>
                            <label for="plantName" class="fw-semibold px-4">Plant Nickname</label>
                        </div>

                        <div class="form-floating px-0">
                            <select class="form-select rounded-pill px-4" name="plantType" id="plantType" required>
                                <option value="" hidden selected>Choose Plant Type</option>

                                <?php
                                $types = get_AllPlantTypes();
                                foreach ($types as $type) {
                                ?>
                                    <option value="<?php echo $type ?>"><?php echo $type ?></option>

                                <?php
                                }
                                ?>
                            </select>
                            <label for="plantType" class="fw-semibold px-4">Plant Type</label>
                        </div>

                        <div class="form-floating px-0">
                            <input type="number" class="form-control rounded-pill lead px-4" style="color: #2B4141;" name="plantAge" id="plantAge" placeholder="Plant Age" required>
                            <label for="plantAge" class="fw-semibold px-4">Plant Age (in weeks)</label>
                        </div>

                        <input class="form-control rounded-pill lead px-4 py-3" type="file" id="addPlantImg" accept=".jpg, .jpeg, .png" name="uploadImg[]" multiple hidden required>
                        <label for="addPlantImg" class="btn btn-outline-light rounded-pill border text-start fw-semibold px-4 py-3 p-0 m-0" style="cursor: pointer;">
                            <span id="file-chosen">Choose File (.jpg, .jpeg, .png)</span>
                        </label>


                        <button class="w-100 btn rounded-pill btnHover py-3 fw-semibold" style="color: #2B4141; border-color: #2B4141;" type="submit" name="submit">Add Plant</button>
                    </div>
                </form>
            </div>

            <hr class="my-4">

            <!-- list container -->
            <div class="row gap-4 justify-content-center overflow-auto" style="margin-bottom: 50px;">
                <!-- item container -->
                <?php
                foreach ($MyPlantObjectArray as $Plant) {
                    $PlantInfo_src = get_PlantInfo($Plant->plant_type);

                ?>

                    <form class="contianer row justify-content-center align-items-center text-center text-xl-start gap-3 p-2" style="border-radius: 2.5rem; background: #70dada1e;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <!-- img contaier -->
                        <div class="carousel slide carousel-dark slide col m-0 p-0 justify-content-center align-items-center text-center" id="carouselExampleControls" data-bs-ride="carousel">
                            <div class="carousel-inner">

                                <?php
                                $imageArray = json_decode($Plant->plant_image, true);
                                $i = 1;

                                ?>
                                <!-- img -->
                                <div class="carousel-item active">
                                    <img class="img-fluid justify-content-center text-center" style="min-width: 350px; min-height: 350px; max-height: 45vh; max-width: 45vh; border-radius: 2rem;" src="<?php echo "plant_images_user/" . $imageArray[0]  ?>" alt="plant image">
                                </div>

                                <?php
                                while ($i < count($imageArray)) {
                                ?>
                                    <!-- sample 2nd img -->
                                    <div class="carousel-item">
                                        <img class="img-fluid justify-content-center text-center" style="min-width: 350px; min-height: 350px; max-height: 45vh; max-width: 45vh; border-radius: 2rem;" src="<?php echo "plant_images_user/" . $imageArray[$i] ?>" alt="plant image">
                                    </div>

                                    <?php

                                    ?>
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
                            <h2 class="fw-semibold mb-3 mx-4 mx-md-0">Plant Nickname: <?php echo $Plant->plant_nickname; ?></h2>

                            <?php
                            $imageArray = json_decode($Plant->plant_image);
                            ?>



                            <h4 class="fw-normal mb-3 mx-4 mx-md-0">Scientific Name: <em><?php echo $PlantInfo_src->plant_scientific_name; ?></em> <?php echo  " commonly known as " . $PlantInfo_src->plant_type; ?></h4>

                            <h4 class="fw-normal mb-3 mx-4 mx-md-0">action suggest</h4>
                            <p class="fs-6 fw-light mb-0 mx-4 mx-md-0 text-decoration-underline"><a style="text-decoration: none; color: inherit;" href="">Planting Procedure:</a></p>
                            <p><?php echo $PlantInfo_src->planting_procedure; ?></p>

                            <iframe class="ratio" src="<?php echo $PlantInfo_src->planting_vid_link; ?>" width="560" height="315" title="A YouTube video" frameborder="0" allowfullscreen></iframe>

                            <p class="fs-6 fw-light mb-0 mx-4 mx-md-0 text-decoration-underline">Plant Temperature Range:</p>
                            <p class="fs-5 mb-3"><?php echo $PlantInfo_src->Lowest_Temp . " - " . $PlantInfo_src->Highest_Temp; ?></p>

                            <p class="fs-6 fw-light mb-0 mx-4 mx-md-0 text-decoration-underline">Plant Trivia:</p>
                            <p><?php echo $PlantInfo_src->plant_trivia; ?></p>

                            <input type="hidden" name="plantid" id="<?php echo $Plant->id ?>" value="<?php echo $Plant->id ?>"></input>
                            <button class="w-100 btn rounded-pill removeBtnHover" style="color: #2B4141; border-color: #2B4141;" type="submit" name="remove">Remove Plant</button>
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
    <!-- img js -->
    <script>
        const actualBtn = document.getElementById('addPlantImg');
        const fileChosen = document.getElementById('file-chosen');

        actualBtn.addEventListener('change', function() {
            if (this.files.length > 0) {
                let names = '';
                for (let i = 0; i < this.files.length; i++) {
                    names += this.files[i].name + ', ';
                }
                names = names.slice(0, -2);
                fileChosen.textContent = names;
            } else {
                fileChosen.textContent = 'Choose File';
            }
        });
    </script>

    <script>
        // Get the select element
        var selectElement = document.getElementById("plantType");

        // Get the options
        var options = Array.from(selectElement.options);

        // Sort the options alphabetically based on their text content
        options.sort(function(a, b) {
            return a.text.localeCompare(b.text);
        });

        // Clear existing options from the select
        selectElement.innerHTML = '';

        // Add sorted options back to the select
        options.forEach(function(option) {
            selectElement.appendChild(option);
        });
    </script>

</body>

</html>