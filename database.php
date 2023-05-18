<?php
    $host = "localhost";
    $database = "social_db";
    $user = "root";
    $password = "";

    $check="";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        $check="true";
    } catch (PDOException $e) {
        $check="false";
    };

?>