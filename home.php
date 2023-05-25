<?php 
require "database.php";
require_once "partials/header.php";
session_start();

if (empty($_SESSION["user"])) {
    header("Location: index.php");
    return;
};

$currentUserQuery = $conn->prepare("SELECT * FROM users WHERE username = :username");
$currentUserQuery->bindParam(":username", $_SESSION["user"]["username"]);
$currentUserQuery->execute();

$currentUserArray = $currentUserQuery->fetchAll(PDO::FETCH_ASSOC);
$currentUser = $currentUserArray[0];
//print_r($currentUser);



$currentConectionsQuery = $conn->prepare("SELECT * FROM conections WHERE user1 = :username");
$currentConectionsQuery->bindParam(":username", $_SESSION["user"]["id"]);
$currentConectionsQuery->execute();

$currentConectionsArray = $currentConectionsQuery->fetchAll(PDO::FETCH_ASSOC);
//print_r($currentConectionsArray);

$follows = count($currentConectionsArray);
//print_r($follows);

$currentUserConections = [];
foreach ($currentConectionsArray as $key => $conection) {
    //print_r($conection['user2']);
    if (!empty($conection)) {
        array_push($currentUserConections, $conection['user2']);
    }
    
}

//print_r($currentUserConections);

$cucquery = implode(',', $currentUserConections);
//print_r($cucquery);

$postsToShowQuery = $conn->prepare("SELECT * FROM posts WHERE id_user IN ($cucquery) ORDER BY date_post DESC");
$postsToShowQuery->execute();

$postsToShow = $postsToShowQuery->fetchAll(PDO::FETCH_ASSOC);

//print_r($postsToShow);
?>

<div class="ms_container" style="width: 100%; height: calc(100vh - 4rem - 3rem); background-color: #f4f6fc; overflow: scroll;">
    <div class="container" style="max-width: 800px">
        <div class="head pt-5 d-flex justify-content-between">
            <h2 class="d-inline-block">Hello <?php echo $_SESSION["user"]["username"]; ?>!</h2>
            <a href="sharepost.php" class="btn btn-primary d-inline-block">Share post</a>
        </div>

        <div class="myposts mt-5 mb-3">

            <div class="row g-3 align-items-stretch">
                <?php foreach ($postsToShow as $post) {?>
                    
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="col-content" style="height: 100%">
                            <div class="card" style="height: 100%">
                                <img src="<?php echo $post['img_post']; ?>" class="card-img-top" alt="..." style="width: 100%; height: 12rem; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $post['title']; ?></h5>
                                    <p class="card-text"><?php echo $post['description']; ?></p>
                                    <p class="card-text"><?php echo $post['date_post']; ?></p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                <?php } ?>
                
            </div>

        </div>
        
    </div>
    
</div>



<?php require_once "partials/footer.php"; ?>