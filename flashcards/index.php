<?php

require_once '../utils/user.php';
require_once '../utils/functions.php';
$id = getTopicId();

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
    <link rel="stylesheet" href="../css/inner.css">
</head>

<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-primary ms-auto">
    <div class="navbar-brand"><?= $_SESSION['user_email']?></div>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto me-5">
            <a class="nav-item nav-link" href="../topics.php">Topics</a>
            <a class="nav-item nav-link" href="../archived.php">Archived topics</a>
            <a class="nav-item nav-link" href="../account.php">Account</a>
            <a class="nav-item nav-link" href="../logout.php">Log out</a>
        </div>
    </div>
</nav>

<main class="content">
    <div class="d-flex flex-row align-items-center justify-content-center">
        <div class="row text-center h5 my-3"><?= $_GET['topic'] ?></div>
</div>

    <div class='row my-3 d-flex align-items-center justify-content-center' >
        <div class='col-4 d-flex align-items-center justify-content-center '><a href='./add.php?topic=<?= $_GET['topic']?>' class='btn btn-success btn-padded'>Add</a></div>
        <div class='col-4 d-flex align-items-center justify-content-center'><a href='./manage.php?topic=<?= $_GET['topic']?>' class='btn btn-info btn-padded'>Manage</a></div>
        <div class='col-4 d-flex align-items-center justify-content-center'><a href='./study.php?topic=<?= $_GET['topic']?>' class='btn btn-danger btn-padded'>Study</a></div>
    </div>

</main>
</body>

</html>