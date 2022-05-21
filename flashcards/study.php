<?php

require_once '../utils/user.php';
require_once '../utils/functions.php';
$id = getTopicId();

$flashcardQuery = $db->prepare('SELECT * FROM Flashcard WHERE Topic_id=:topic_id;');
$flashcardQuery->execute([
    ':topic_id' => $id
]);

$flashcards = $flashcardQuery->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/inner.css">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
</head>

<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-primary ms-auto">
    <div class="navbar-brand max-50"><?= htmlspecialchars($_SESSION['user_email']) ?></div>
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
    <div class="d-flex flex-row align-items-center justify-content-center mb-3">
        <div class="col-6 d-flex align-items-center justify-content-center ">
            <div class="row text-center h5 my-3 break-word"><?= htmlspecialchars($_GET['topic']) ?> - flashcards</div>
        </div>
        <div class="col-6 d-flex align-items-center justify-content-center ">
            <a class='btn btn-danger btn-padded'
               href="./index.php?topic=<?= htmlspecialchars($_GET['topic']) ?>">Back</a>
        </div>
    </div>


    <?php
    if (empty($flashcards)) {
        echo "
<div class='row my-3 d-flex flex-row align-items-center justify-content-center'> 
<div class='col-12 my-auto'><p class='h2 text-center'>No flashcards found</p>
</div>
</div>";

    } else {

        echo '<div id="carouselExampleControls" style="height: 500px" class="carousel slide mx-auto" data-bs-ride="carousel" data-bs-interval="false" >
  <div class="carousel-inner h-100">
  <div class="carousel-item active bg-secondary"><div class="d-flex flex-column h-100 align-items-center justify-content-center"><h2 class="text-white"><u>Flashcards</u><h3 class="text-white break-word"> ' .
            htmlspecialchars($_GET['topic']) .
            '</h3></div></div>
  ';
        foreach ($flashcards as $flashcard) {
            echo '<div class="carousel-item bg-secondary"><div class="d-flex flex-column h-100 align-items-center justify-content-center"><h2 class="text-white"><u class="pt-3">Question</u></h2><h3 class="text-white break-word p-3"> '
                . htmlspecialchars($flashcard['question']) .
                '</h3></div></div>';
            echo '<div class="carousel-item bg-secondary"><div class="d-flex flex-column h-100 align-items-center justify-content-center"><h2 class="text-white"><u class="pt-3">Answer</u></h2><h3 class="text-white break-word p-3"> '
                . htmlspecialchars($flashcard['answer']) .
                '</h3></div></div>';
        }
        echo '</div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>';
    }
    ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
