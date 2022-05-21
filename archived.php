<?php

require_once 'utils/user.php';

$unarchivedSuccessfully = false;
if (isset($_POST['unarchive'])) {
    $id = $_POST['id'];
    $checkQuery = $db->prepare('SELECT * FROM Topic WHERE id=:id AND User_id=:user_id LIMIT 1;');
    $checkQuery->execute([
        ':id' => $id,
        ':user_id' => $_SESSION['user_id']
    ]);
    if ($checkQuery->rowCount() == 1) {
        $sql = "UPDATE Topic SET archived=FALSE WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $unarchivedSuccessfully = true;
    }

}


$topicQuery = $db->prepare('SELECT * FROM Topic WHERE User_id=:user_id AND archived = TRUE;');
$topicQuery->execute([
    ':user_id' => $_SESSION['user_id']
]);

$topics = $topicQuery->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived topics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/inner.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
</head>

<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-primary ms-auto">
    <div class="navbar-brand max-50"><?= htmlspecialchars($_SESSION['user_email'])?></div>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto me-5">
            <a class="nav-item nav-link" href="./topics.php">Topics</a>
            <a class="nav-item nav-link active" href="#">Archived topics</a>
            <a class="nav-item nav-link" href="./account.php">Account</a>
            <a class="nav-item nav-link" href="./logout.php">Log out</a>
        </div>
    </div>
</nav>

<main class="content">

    <div class="d-flex flex-row align-items-center justify-content-center">
        <div class="row text-center text-success h5 my-3"><?php echo $unarchivedSuccessfully ? 'Topic unarchived!' : '&nbsp;' ?></div>
    </div>


    <?php
    if (empty($topics)) {
        echo "
<div class='row my-3 d-flex flex-row align-items-center justify-content-center'> 
<div class='col-12 my-auto'><p class='h2 text-center'>No topics there buddy</p>
</div>
</div>";

    } else {
        foreach ($topics as $topic) {
            echo "
<form class='row my-3 d-flex flex-row align-items-center justify-content-center'  method='post' action=''>
    <input type='hidden' name='id' value='" . htmlspecialchars($topic['id']) . "' readonly>
    <div class='col-2 my-auto'><p class='h4 text-center break-word'>" . htmlspecialchars($topic['name']) . "</p></div>
    <div class='col-1 '><button type='submit' name='unarchive' class='btn btn-secondary btn-padded'>Unarchive</button></div>
</form>    
";
        }
    }

    ?>


</main>
</body>

</html>