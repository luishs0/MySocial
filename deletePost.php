<?php 
    require "database.php";

    $getPost = $conn->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
    $getPost->bindParam(":id", $_GET['id']);
    $getPost->execute();

    $postArray = $getPost->fetchAll(PDO::FETCH_ASSOC);

    $post = $postArray[0];

    


    $stmt = $conn->prepare("DELETE FROM posts WHERE id = :id");
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();

    unlink($post['img_post']);

    header("Location: myprofile.php");
?>