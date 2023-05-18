<?php 
require_once "partials/header.php";
session_start();

if (empty($_SESSION["user"])) {
    header("Location: index.php");
    return;
};
?>

<div class="ms_container" style="width: 100%; height: calc(100vh - 4rem - 3rem); background-color: #f4f6fc;">
    <div class="container" style="max-width: 800px">
        <div class="head pt-5 d-flex justify-content-between">
            <h2 class="d-inline-block">Hello <?php echo $_SESSION["user"]["username"]; ?>!</h2>
            <a href="sharepost.php" class="btn btn-primary d-inline-block">Share post</a>
        </div>
        
    </div>
    
</div>



<?php require_once "partials/footer.php"; ?>