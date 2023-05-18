<?php 

    require "database.php";


    if (isset($_POST) && !empty($_POST)) {

        
        $newUser = [
            "username" => $_POST['username'],
            "password" => password_hash($_POST['password'], PASSWORD_BCRYPT)
        ];


        $error = "";
       
        if (empty($newUser["username"]) || empty($_POST['password']) || empty($_POST['confirmpassword'])) {
            $error = "All fields must be completed";
        } else if ($_POST['password'] != $_POST['confirmpassword']) {
            $error = "Passwords do not match";
        } else if (strlen($_POST['password']) < 5) {
            $error = "The password must have at least 5 characters";
        } else {

            $statement = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $statement->bindParam(":username", $newUser["username"]);
            $statement->execute();

            if ($statement->rowCount() > 0) {
                $error = "This username is taken.";
            } else {
                $conn
                ->prepare("INSERT INTO users (username, password) VALUES (:username, :password)")
                ->execute([
                    ":username" => $newUser["username"],
                    ":password" => $newUser["password"],
                ]);

                $statement = $conn->prepare("SELECT * FROM users WHERE username = :username");
                $statement->bindParam(":username", $newUser["username"]);
                $statement->execute();

                $user = $statement->fetch(PDO::FETCH_ASSOC);

                session_start();
                $_SESSION["user"] = $user;
                
                header("Location: home.php");
                
            }   
        }
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySocial || Register</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="style/index.css">

</head>
<body>
    

<div class="ms_container">
    <div class="container">

        <div class="row index-content justify-content-center align-items-center">

            <div class=" col-12 col-md-6 col-xl-4 d-flex justify-content-center align-items-center">
                <img class="logo-index" src="assets/logo_dark2.png" alt="">
            </div>

            <div class="col-12 col-md-6 col-xl-8 login-form">
                <form action="register.php" method="POST">
                    <h3>Create account</h3>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
                    </div>

                    <?php if ($error) { ?>
                        <div class="mb-3">
                            <p style="color: red;"><?php echo $error; ?></p>
                        </div>
                    <?php } ?>
                    

                    <div class="mb-3">
                        <a class="register-link" href="index.php">I have an account</a>
                    </div>
                    <button type="submit" class="btn btn-info">Submit</button>

                </form>
            </div>

        </div>

    </div>
</div>



<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>



</body>
</html>