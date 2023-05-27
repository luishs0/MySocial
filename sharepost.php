<?php 

require "database.php";
require "partials/header.php";
session_start();

// print_r($_POST);
//var_dump($_FILES['img_post']);
if (isset($_POST) && !empty($_POST)) {

    if ($_POST['title'] == "") {
        $error = "The name field has to be completed";
    } else {
        if (!empty($_FILES['img_post']['name'])) {

            if ($_FILES['img_post']['type'] == "image/png") {
                $fileName = $_SESSION['user']['id']."_".date('Y-m-d_H-i-s').".png";
                $temporalRoot = $_FILES['img_post']['tmp_name'];
                $finalRoot = 'post_img/' . $fileName;
    
                move_uploaded_file($temporalRoot, $finalRoot);
    
                $stmt = $conn->prepare("INSERT INTO posts (title, description, img_post, id_user, date_post) VALUES (:title, :description, :img_post, :id_user, :date_post)");
                $stmt->bindParam(":title", $_POST['title']);
                $stmt->bindParam(":description", $_POST['description']);
                $stmt->bindValue(":img_post", $finalRoot);
                $stmt->bindParam(":id_user", $_SESSION['user']['id']);
                $stmt->bindParam(":date_post", date('Y-m-d'));
                $stmt->execute();
    
                header("Location: home.php");
    
            } else if ($_FILES['img_post']['type'] == "image/jpg") {
                $fileName = $_SESSION['user']['id']."_".date('Y-m-d_H-i-s').".jpg";
                $temporalRoot = $_FILES['img_post']['tmp_name'];
                $finalRoot = 'post_img/' . $fileName;
    
                move_uploaded_file($temporalRoot, $finalRoot);
    
                $stmt = $conn->prepare("INSERT INTO posts (title, description, img_post, id_user, date_post) VALUES (:title, :description, :img_post, :id_user, :date_post)");
                $stmt->bindParam(":title", $_POST['title']);
                $stmt->bindParam(":description", $_POST['description']);
                $stmt->bindValue(":img_post", $finalRoot);
                $stmt->bindParam(":id_user", $_SESSION['user']['id']);
                $stmt->bindParam(":date_post", date('Y-m-d'));
                $stmt->execute();
    
                header("Location: home.php");
    
            } else if ($_FILES['img_post']['type'] == "image/jpeg") {
                $fileName = $_SESSION['user']['id']."_".date('Y-m-d_H-i-s').".jpeg";
                $temporalRoot = $_FILES['img_post']['tmp_name'];
                $finalRoot = 'post_img/' . $fileName;
    
                move_uploaded_file($temporalRoot, $finalRoot);
    
                $stmt = $conn->prepare("INSERT INTO posts (title, description, img_post, id_user, date_post) VALUES (:title, :description, :img_post, :id_user, :date_post)");
                $stmt->bindParam(":title", $_POST['title']);
                $stmt->bindParam(":description", $_POST['description']);
                $stmt->bindValue(":img_post", $finalRoot);
                $stmt->bindParam(":id_user", $_SESSION['user']['id']);
                $stmt->bindParam(":date_post", date('Y-m-d'));
                $stmt->execute();
    
    
                header("Location: home.php");
            } else {
                $finalRoot = "";
                $error = "The post image must be jpg, png or jpeg";
            } 
        } else {
            $error = "You have not selected any image";
        }
    }

    
}
?>


<div class="ms_container" style="width: 100%; height: calc(100vh - 4rem - 3rem); background-color: #f4f6fc;">

    <div class="container">

        <form action="sharepost.php" method="POST" class="pt-5" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Post title">
            </div>
            <div class="mb-3">
                <label for="img_post" class="form-label">Image</label>
                <input type="file" class="form-control" id="img_post" name="img_post">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description">
            </div>
            <?php if ($error != "") {?>
                <div class="mb-3">
                    <p style="color: red;"> <?php echo $error; ?> </p>
                </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

</div>



<?php require "partials/footer.php"; ?>