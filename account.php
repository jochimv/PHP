<?php
require_once 'utils/user.php';

var_dump($_POST);
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
    <div class="navbar-brand"><?= $_SESSION['user_email'] ?></div>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto me-5">
            <a class="nav-item nav-link active" href="#">Topics</a>
            <a class="nav-item nav-link" href="./archived.php">Archived topics</a>
            <a class="nav-item nav-link" href="account.php">Account</a>
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
                   placeholder="e-mail" value="<?= $_SESSION['user_email'] ?>">
        </div>
        <div class="row">
            <div class="col-4">
                <button type="submit" class="btn btn-padded btn-success" id="changeEmail">Change</button>
            </div>
            <div class="col-8">
                <h3 class="text-danger" id="resultAreaEmail"></h3>
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
                <h3 class="text-danger" id="resultAreaPassword"></h3>
            </div>
        </div>
    </form>

    <div class="col">
        <a class='btn btn-secondary btn-padded' href="./topics.php">Back</a>
    </div>

</main>
</body>

</html>
