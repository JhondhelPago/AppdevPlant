<?php
require "php_script/Module.php";
session_start();

if(isset($_POST['login_button'])){
    $email = $_POST['userEmail'];
    $password = $_POST['userPass'];


    if($id = LoginResult($email, $password) != null){
        $_SESSION['user_id'] = $id;
        
        header('Location: morePlants.php');

    }else{

        echo "<script>alert('invalid username and password. ')</script>";

    }

}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
<body class="row m-0 p-0 justify-content-center">
    <!-- bg -->
    <div class="position-absolute overflow-hidden row justify-content-center m-0 p-0" style="min-height: 100vh; min-width: 90vw; z-index: -10;">
        <div class="row justify-content-center align-items-end position-fixed m-0 p-0"  style="min-height: 100vh; min-width: 90vw; ">
            <img src="bg4.jpg" class="img-fluid m-0 p-0 mt-5 pt-5" style="filter: blur(0.5px); min-width: 1000px; max-width: 1300px;" alt="">
        </div>
    </div>
    <!-- nav -->
    <div class="container px-xxl-0 border-bottom">
        <nav class="navbar navbar-expand-lg navbar-white">
            <div class="container-fluid justify-content-center">
                <i class="fa-solid fa-leaf fs-2 me-2" style="color: #2B4141;"></i>
                <a class="navbar-brand fs-2 fw-bold user-select-none" style="color: #2B4141; cursor: default;" href="#">Plant Assist</a>
            </div>
        </nav>
    </div>
    <!-- body -->
    <div class="container px-xxl-0 py-3 mb-5 mb-lg-3 pb-5 pb-lg-0">
        <div class="row gap-4 justify-content-center m-0 p-0">
            <div class="contianer row justify-content-center align-items-center text-center text-xl-start gap-3 p-2">
                <h1 class="d-flex justify-content-center align-items-center">
                    Login to your account
                </h1>
                <!-- login form -->
                <form class="row col-12 col-md-9 col-xl-7 p-4 shadow-sm gap-3" style="color: #2B4141; border-radius: 2.5rem; 
                    background: rgba(255, 255, 255, 0.719);
                    backdrop-filter: blur(10px);
                    -webkit-backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.72);
                " 
                method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                >
                    <div class="form-floating px-0">
                        <input type="email" class="form-control rounded-pill lead px-4 bg-transparent" style="color: #2B4141;" name="userEmail" id="userEmail" placeholder="Email">
                        <label for="userEmail" class="fw-semibold px-4" style="color: #708585;">Email</label>
                    </div>

                    <div class="form-floating px-0">
                        <input type="password" class="form-control rounded-pill lead px-4 bg-transparent" style="color: #2B4141;" name="userPass" id="userPass" placeholder="Password">
                        <label for="userPass" class="fw-semibold px-4" style="color: #708585;">Password</label>
                    </div>

                    <button class="w-100 btn rounded-pill btnHover py-3 fw-semibold" style="color: #2B4141; border-color: #2B4141;" type="submit" name="login_button">Login</button>
                    <p class="text-center" >Don't have an account? <a class="switchFormBtn" style="text-decoration: none; color: rgb(15, 160, 124);" href="register.php">Register</a></p>
                    
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/817c4fe6aa.js" crossorigin="anonymous"></script>
    
</body>
</html>