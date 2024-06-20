<?php
require "php_script/Module.php";
session_start();


$UserObject = get_userInfo($_SESSION['user_id']);

if (isset($_POST["save_changes"])) {
    $username = $_POST['userName'];
    $gender = $_POST['gender'];
    $newpassword = $_POST['userPass'];
    $confirmpassword = $_POST['confirmPass'];

    $check = ($_POST['userPass'] == '') ? "True for empty string" : "False for not Empty stsring";


    if ($newpassword == "" || $confirmpassword == "") {
        echo "<script>alert('Input Field: new password and confirm password should not be empty string.')</script>";
    } else {
        if ($newpassword != $confirmpassword) {
        }
    }

    // echo "<script>alert('$check')</script>";
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
    <!-- bg -->
    <div class="position-absolute overflow-hidden row justify-content-center m-0 p-0" style="min-height: 100vh; min-width: 90vw; z-index: -10;">
        <div class="row justify-content-center align-items-end position-fixed m-0 p-0" style="min-height: 100vh; min-width: 90vw; ">
            <img src="bg4.jpg" class="img-fluid m-0 p-0 mt-5 pt-5" style="filter: blur(0.5px); min-width: 1000px; max-width: 1300px;" alt="">
        </div>
    </div>
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
                                <a class="nav-link fw-semibold" style="color: #2b4141;" href="morePlants.php">More Plants</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold active " style="color: #2b4141;" href="profile.php">Profile</a>
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
        <div class="container px-xxl-0 py-3 mb-5 mb-lg-3 pb-5 pb-lg-0">
            <div class="row gap-4 justify-content-center overflow-auto">
                <div class="contianer row justify-content-center align-items-center text-center text-xl-start gap-3 p-2" style="border-radius: 2.5rem;">
                    <div class="row display-6 fw-semibold justify-content-center">
                        <h1 class="d-flex justify-content-center align-items-center">
                            <i class="fa-regular fa-user me-3 fs-4"></i>
                            My Info
                            <i class="fa-regular fa-user ms-3 fs-4"></i>
                        </h1>
                    </div>
                    <!-- form -->
                    <form class="row col-12 col-md-9 col-xl-7 p-4 shadow-sm gap-3" style="color: #2B4141; border-radius: 2.5rem; 
                        background: rgba(255, 255, 255, 0.719);
                        backdrop-filter: blur(10px);
                        -webkit-backdrop-filter: blur(10px);
                        border: 1px solid rgba(255, 255, 255, 0.72);
                    " method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                        <div class="form-floating px-0">
                            <input type="text" class="form-control rounded-pill lead px-4" style="color: #2B4141;" name="userName" id="userName" placeholder="User Name" value="<?php echo $UserObject->Username; ?>">
                            <label for="userName" class="fw-semibold px-4" style="color: #708585;"></label>
                        </div>

                        <div class="form-floating px-0">
                            <select class="form-select rounded-pill px-4 bg-transparent" style="color: #2B4141; " name="gender" id="gender" required value="<?php echo ($UserObject->Gender == 'M') ? "Male" : "Female" ?>">

                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <label for="gender" class="fw-semibold px-4" style="color: #708585;"></label>
                        </div>

                        <div class="form-floating px-0">
                            <input type="number" class="form-control rounded-pill lead px-4 bg-transparent" style="color: #2B4141; " name="age" id="age" placeholder="Age" value="<?php echo $UserObject->Age; ?>">
                            <label for="age" class="fw-semibold px-4" style="color: #708585;"></label>
                        </div>

                        <div class="form-floating px-0">
                            <input type="text" class="form-control rounded-pill lead px-4" style="color: #2B4141;" name="userName" id="userName" placeholder="User Name" value="address">
                            <label for="userName" class="fw-semibold px-4" style="color: #708585;"></label>
                        </div>


                        <button class="w-100 btn rounded-pill btnHover py-3 fw-semibold" style="color: #2B4141; border-color: #2B4141;" type="submit" name="save_changes">Save Changes</button>
                    </form>
                </div>
                <div class="row display-6 fw-semibold justify-content-center">
                    <h1 class="d-flex justify-content-center align-items-center">
                        <i class="fa-regular fa-user me-3 fs-4"></i>
                        Change Password
                        <i class="fa-regular fa-user ms-3 fs-4"></i>
                    </h1>
                </div>
                <!-- form -->
                <form class="row col-12 col-md-9 col-xl-7 p-4 shadow-sm gap-3" style="color: #2B4141; border-radius: 2.5rem; 
                        background: rgba(255, 255, 255, 0.719);
                        backdrop-filter: blur(10px);
                        -webkit-backdrop-filter: blur(10px);
                        border: 1px solid rgba(255, 255, 255, 0.72);
                    " method="post" action="">


                    <!-- <div class="form-floating px-0">
                            <input type="email" class="form-control rounded-pill lead px-4 bg-transparent" style="color: #2B4141; " name="userEmail" id="userEmail" placeholder="Email">
                            <label for="userEmail" class="fw-semibold px-4" style="color: #708585;"><?php echo $UserObject->Email; ?></label>
                        </div> -->

                    <div class="form-floating px-0">
                        <input type="password" class="form-control rounded-pill lead px-4 bg-transparent" style="color: #2B4141; " name="userPass" id="userPass" placeholder="Password">
                        <label for="userPass" class="fw-semibold px-4" style="color: #708585;">New Password</label>
                    </div>

                    <div class="form-floating px-0">
                        <input type="password" class="form-control rounded-pill lead px-4 bg-transparent" style="color: #2B4141; " name="confirmPass" id="confirmPass" placeholder="Confirm Password">
                        <label for="confirmPass" class="fw-semibold px-4" style="color: #708585;">Confirm Password</label>
                    </div>

                    <button class="w-100 btn rounded-pill btnHover py-3 fw-semibold" style="color: #2B4141; border-color: #2B4141;" type="submit" name="save_changes">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/817c4fe6aa.js" crossorigin="anonymous"></script>
</body>

</html>