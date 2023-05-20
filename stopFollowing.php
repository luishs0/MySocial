<?php
require "database.php";

session_start();

if ($_SESSION['user']['id'] != $_GET['user1']) {
    echo "Not authorized";
    return;
}

$stmt = $conn->prepare("DELETE FROM conections WHERE user1 = :user1 AND user2 = :user2");
$stmt->bindParam(":user1", $_GET['user1']);
$stmt->bindParam(':user2', $_GET['user2']);
$stmt->execute();

$getSearchUser = $conn->prepare("SELECT * FROM users WHERE id = :id");
$getSearchUser->bindParam(':id', $_GET['user2']);
$getSearchUser->execute();

$searchUserArray = $getSearchUser->fetchAll(PDO::FETCH_ASSOC);
$searchUser = $searchUserArray[0];

// var_dump($searchUser);


header("Location: searchProfile.php?username=".$searchUser['username']);

?>