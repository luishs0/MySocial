<?php
require "database.php";
require_once "partials/header.php";

session_start();

if (empty($_SESSION["user"])) {
    header("Location: index.php");
    return;
};

if (empty($_SESSION["user"])) {
    header("Location: index.php");
    return;
};

$rootImgForm = $_SESSION['user']['profile_img'];



if (isset($_POST) && !empty($_POST)) {

    if (!empty($_FILES['profile_img']['name'] && ($_FILES['profile_img']['type'] == "image/png" || $_FILES['profile_img']['type'] == "image/jpg"  || $_FILES['profile_img']['type'] == "image/jpeg"))) {
        $fileName = $_FILES['profile_img']['name'];
        $temporalRoot = $_FILES['profile_img']['tmp_name'];
        $finalRoot = 'user_img/' . $fileName;

        if ($finalRoot == "user_img/") {
            $finalRoot = "";
        };

        move_uploaded_file($temporalRoot, $finalRoot);
        unlink($rootImgForm);
    } else {
        $finalRoot = $rootImgForm;
    }



    // -------------------------- CONTROL NAME

    $controllName = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $controllName->bindParam(':username', $_POST['username']);
    $controllName->execute();

    if ($controllName->rowCount() > 0 && $_POST['username'] != $_SESSION['user']['username']) {
        $error = "This username is taken.";
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = :username, profile_img = :profile_img, bio = :bio WHERE id = :user_id");
        $stmt->bindParam(':username', $_POST['username']);
        
        $stmt->bindValue(':profile_img', $finalRoot);
        $stmt->bindParam(':bio', $_POST['bio']);
        $stmt->bindParam(':user_id', $_SESSION['user']['id']);
        $stmt->execute();    
    
    
        $editedUser = [
            "username" => $_POST["username"],
            "password" =>  password_hash($_SESSION['user']["password"], PASSWORD_BCRYPT),
            "id" => $_SESSION['user']['id'],
            "profile_img" => $finalRoot,
            "bio" => $_POST['bio']
        ];
    
    
        $_SESSION['user'] = $editedUser;
    
        header("Location: myprofile.php");
    };
}

?>

<div class="ms_container" style="width: 100%; height: calc(100vh - 4rem - 3rem); background-color: #f4f6fc;">

    <div class="container">
 
        <div class="profile_info pt-3">
            <form action="editprofile.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['user']['username']; ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Profile image</label>
                    <input type="file" class="form-control" id="profile_img" name="profile_img">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Bio</label>
                    <input type="text" class="form-control" id="bio" name="bio" value="<?php if ($_SESSION['user']['bio']) { echo $_SESSION['user']['bio']; } else {echo "Write a bio";}; ?>">
                </div>
                <?php if ($error) {?>
                    <div class="mb-3">
                        <p style="color: red"><?php echo $error; ?></p>
                    </div>
                <?php } ?>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    
</div>



<?php require "partials/footer.php"; ?>