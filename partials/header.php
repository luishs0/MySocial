<?php date_default_timezone_set('Europe/Madrid'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

     <!-- BOOTSTRAP -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
     <!-- CSS CUSTOM -->
     <link rel="stylesheet" href="style/header.css">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">
            <img class="navbar-logo" src="assets/navbar-logo.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == "/luis_code/mySocial/home.php") { echo "active"; }; ?>" aria-current="page" href="home.php">Home</a>
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == "/luis_code/mySocial/myprofile.php") { echo "active"; }; ?>" href="myprofile.php">My Profile</a>
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == "/luis_code/mySocial/people.php") { echo "active"; }; ?>" href="people.php">People</a>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    </nav>
