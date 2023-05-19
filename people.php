<?php 
require "database.php";
require_once "partials/header.php";
session_start();

if (empty($_SESSION["user"])) {
    header("Location: index.php");
    return;
};


if (isset($_POST) && !empty($_POST)) {

    
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE '%".$_POST['searchUser']."%'");
    // $stmt->bindParam(":username", $_POST['searchUser']);
    $stmt->execute();

    $searchUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($searchUser);

}

?>

<div class="ms_container" style="width: 100%; height: calc(100vh - 4rem - 3rem); background-color: #f4f6fc; overflow:scroll;">
    <div class="container">
        <form action="people.php" method="POST" class="mb-5">
            <div class="mt-3 row flex-column flex-md-row justify-content-center align-items-center">
                <label for="exampleInputEmail1" class="form-label col-10 text-center" style="font-size: 1.3rem;">Find a friend!</label>
                <input class="col-10 col-md-8 me-1 mb-1" type="text" name="searchUser" id="searchUser" placeholder="Find a friend" style="border-radius: 5px; height: 2.5rem; border: 1px solid gray">
                <button class="btn btn-success col-md-3" style="width: 125px;" type="submit">Go!</button>
            </div>
        </form>

        <div class="search-result">
            <div class="row g-3">
                <?php if (isset($searchUsers)) {?>
                    <?php foreach ($searchUsers as $searchUser) { ?>
                        <div class="col-12 col-md-4">
                            <div class="card" style="height: 100%">
                                <?php if ($searchUser['profile_img'] == "") {?>
                                    <img src="assets/user_default.png" class="card-img-top" alt="..." style="height: 15rem; object-fit: cover;">
                                <?php } else { ?>
                                    <img src="<?php echo $searchUser['profile_img']; ?>" class="card-img-top" alt="..." style="height: 15rem; object-fit: cover;">
                                <?php } ?>
                                <div class="card-body">
                                    <h5 class="card-title"> <?php echo $searchUser['username']; ?> </h5>
                                    <p class="card-text"><?php echo $searchUser['bio']; ?></p>
                                    <a href="searchProfile.php?username=<?php echo $searchUser['username']; ?>" class="btn btn-primary">View profile</a>
                                </div>
                            </div>
                        </div>
                        
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<?php require "partials/footer.php"; ?>