<?php
require "database.php";
require_once "partials/header.php";

session_start();

if (empty($_SESSION["user"])) {
    header("Location: index.php");
    return;
};

if (isset($_GET) && !empty($_GET) && $_GET['username'] != "") {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(":username", $_GET['username']);
    $stmt->execute();

    $userArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $user = $userArray[0];



    $getPosts = $conn->prepare("SELECT * FROM posts WHERE id_user = :id_user");
    $getPosts->bindParam(":id_user", $user['id']);
    $getPosts->execute();

    $postsArray = $getPosts->fetchAll(PDO::FETCH_ASSOC);
    // print_r($postsArray);



    $getFollow = $conn->prepare("SELECT * FROM conections WHERE user1 = :user1 AND user2 = :user2");
    $getFollow->bindParam(':user1', $_SESSION['user']['id']);
    $getFollow->bindParam(':user2', $user['id']);

    $getFollow->execute();

    if ($getFollow->rowCount() > 0) {
        $getFollow = true;
    } else {
        $getFollow = false;
    }

    $userConections = $conn->prepare("SELECT * FROM conections WHERE user2 = :user2");
    $userConections->bindParam(":user2", $user['id']);
    $userConections->execute();
    $conections = $userConections->fetchAll(PDO::FETCH_ASSOC);

    // var_dump(count($conections));
    $followers = count($conections);

} else if ($_GET['username'] == "") {
    header("Location: people.php");
} else {
    header("Location: logout.php");
}



?>

<div class="ms_container" style="width: 100%; height: calc(100vh - 4rem - 3rem); background-color: #f4f6fc; overflow:scroll;">

    <div class="container">
 
        <div class="profile_info text-center pt-5">
            <?php if ($user["profile_img"]) { ?>
                <img src="<?php echo $user["profile_img"] ?>" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;">
            <?php } else { ?>
                <img src="assets/user_default.png" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;">
            <?php } ?>

            <div class="username mt-3">
                <h2> <?php echo $user["username"] ?> </h2>
            </div>

            <div class="bio">
                <?php if ($user["bio"]) { ?>
                    <p> <?php echo $user["bio"] ?> </p>
                <?php } else { ?>
                    <p></p>
                <?php } ?>
            </div>

            <div class="followers d-flex justify-content-center mb-3">
                <div class="followers-text"><strong>Followers: </strong> <?php echo " ".$followers ?> </div>
            </div>

            <?php if ($getFollow) { ?>
                <a href="stopFollowing.php?user1=<?php echo $_SESSION['user']['id']; ?>&user2=<?php echo $user['id']; ?>" class="btn btn-danger">Stop Following</a>
            <?php } else { ?>
                <a href="follow.php?user1=<?php echo $_SESSION['user']['id']; ?>&user2=<?php echo $user['id']; ?>" class="btn btn-success">Follow</a>
            <?php } ?>


            <?php if (count($postsArray) > 0) { ?>
                <div class="myposts mt-5 mb-3">

                    <div class="row g-3 align-items-stretch">
                        <?php foreach ($postsArray as $post) { ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="col-content" style="height: 100%">
                                    <div class="card" style="height: 100%">
                                        <img src="<?php echo $post['img_post']; ?>" class="card-img-top" alt="..." style="width: 100%; height: 12rem; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $post['title']; ?></h5>
                                            <p class="card-text"><?php echo $post['description']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        <?php } ?>
                        
                    </div>
                    
                </div>
            <?php } ?>
        </div>
    </div>

    
</div>



<?php require "partials/footer.php"; ?>