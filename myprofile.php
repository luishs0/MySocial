<?php
require "database.php";
require_once "partials/header.php";

session_start();

if (empty($_SESSION["user"])) {
    header("Location: index.php");
    return;
};


$stmt = $conn->prepare("SELECT * FROM posts WHERE id_user = :id_user");
$stmt->bindParam(":id_user", $_SESSION['user']['id']);
$stmt->execute();

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($posts);

$userConections = $conn->prepare("SELECT * FROM conections WHERE user2 = :user2");
$userConections->bindParam(":user2", $_SESSION['user']['id']);
$userConections->execute();
$conections = $userConections->fetchAll(PDO::FETCH_ASSOC);

// var_dump(count($conections));
$followers = count($conections);
?>

<div class="ms_container" style="width: 100%; height: calc(100vh - 4rem - 3rem); background-color: #f4f6fc; overflow:scroll;">

    <div class="container">
 
        <div class="profile_info text-center pt-5">
            <?php if ($_SESSION["user"]["profile_img"]) { ?>
                <img src="<?php echo $_SESSION["user"]["profile_img"] ?>" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;">
            <?php } else { ?>
                <img src="assets/user_default.png" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;">
            <?php } ?>

            <div class="username mt-3">
                <h2> <?php echo $_SESSION["user"]["username"] ?> </h2>
            </div>

            <div class="bio">
                <?php if ($_SESSION["user"]["bio"]) { ?>
                    <p> <?php echo $_SESSION["user"]["bio"] ?> </p>
                <?php } else { ?>
                    <p>Not bio yet</p>
                <?php } ?>
            </div>

            <div class="followers d-flex justify-content-center mb-3">
                <div class="followers-text"><strong>Followers:</strong> <?php echo $followers ?></div>           
            </div>

            <a class="btn btn-success" href="editprofile.php">Edit profile</a>


            <div class="myposts mt-5 mb-3">

                <div class="row g-3 align-items-stretch">
                    <?php foreach ($posts as $post) { ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="col-content" style="height: 100%">
                                <div class="card" style="height: 100%">
                                    <img src="<?php echo $post['img_post']; ?>" class="card-img-top" alt="..." style="width: 100%; height: 12rem; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $post['title']; ?></h5>
                                        <p class="card-text"><?php echo $post['description']; ?></p>
                                    </div>
                                    <a style="width: 100px; margin: auto; margin-bottom: 1rem" class="btn btn-danger" href="deletePost.php?id=<?php echo $post['id']; ?>">Delete</a>
                                </div>
                            </div>
                            
                        </div>
                    <?php } ?>
                    
                </div>
                
            </div>
        </div>
    </div>

    
</div>



<?php require "partials/footer.php"; ?>