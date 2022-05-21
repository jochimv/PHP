<?php
require_once 'utils/user.php';

$emailChangedSuccessfully = false;
$passwordChangedSuccessfully = false;
$mailExists = false;
if(isset($_POST['password1'])){
    $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);

    $sql = "UPDATE User_app SET password=? WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$password,$_SESSION['user_id']]);
    $passwordChangedSuccessfully = true;
} else if (isset($_POST['email'])){
    $mailQuery = $db->prepare('SELECT * FROM User_app WHERE email=:email LIMIT 1;');
    $mailQuery->execute([
        ':email' => $_POST['email']
    ]);
    if ($mailQuery->rowCount() > 0) {
        $mailExists = true;
    } else {
        $sql = "UPDATE User_app SET email=? WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['email'],$_SESSION['user_id']]);
        $emailChangedSuccessfully = true;
        $_SESSION['user_email'] = $_POST['email'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/inner.css">
    <script src="./js/changeAccountDetails.js"></script>
</head>

<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-primary ms-auto">
    <div class="navbar-brand"><?= htmlspecialchars($_SESSION['user_email']) ?></div>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto me-5">
            <a class="nav-item nav-link" href="./topics.php">Topics</a>
            <a class="nav-item nav-link" href="./archived.php">Archived topics</a>
            <a class="nav-item nav-link active" href="#">Account</a>
            <a class="nav-item nav-link" href="./logout.php">Log out</a>
        </div>
    </div>
</nav>

<main class="content">

    <form method="post" action="" class="gapped-form change-account-form">
        <h2>Change email</h2>
        <div class="form-group col-4">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required
                   placeholder="e-mail" value="<?= htmlspecialchars($_SESSION['user_email']) ?>">
        </div>
        <div class="row">
            <div class="col-4">
                <button type="submit" class="btn btn-padded btn-success" id="changeEmail">Change</button>
            </div>
            <div class="col-8">
                <?php
                if ($emailChangedSuccessfully){
                    echo '<h3 class="text-success" id="resultAreaEmail">Email changed successfully!</h3>';
                }elseif ($mailExists){
                    echo '<h3 class="text-danger" id="resultAreaEmail">This email is already in use</h3>';
                } else {
                    echo '<h3 class="text-danger" id="resultAreaEmail"></h3>';
                }
                ?>
            </div>
        </div>
    </form>

    <form method="post" action="" class="gapped-form change-account-form">
        <h2>Change password</h2>
        <div class="form-group col-4">
            <label for="password1">New password</label>
            <input class="form-control mb-1" type="password" id="password1" name="password1" required
                   placeholder="Password">
            <label for="password2">Repeat new password</label>
            <input class="form-control" type="password" id="password2" name="password2" required
                   placeholder="Repeat password">
        </div>
        <div class="row">
            <div class="col-4">
                <button type="submit" name="change" class="btn btn-padded btn-success" id="changePassword">Change
                </button>
            </div>
            <div class="col-8">
                <?php
                 if ($passwordChangedSuccessfully){
                     echo '<h3 class="text-success" id="resultAreaPassword">Password changed successfully!</h3>';
                 }else{
                   echo '<h3 class="text-danger" id="resultAreaPassword"></h3>';
                 }
                ?>
            </div>
        </div>
    </form>

    <div class="col">
        <a class='btn btn-secondary btn-padded' href="./topics.php">Back</a>
    </div>

</main>
</body>

</html>
