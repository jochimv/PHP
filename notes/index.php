<?php

require_once '../utils/user.php';
require_once '../utils/functions.php';
$id = getTopicId();

$deletedSuccesfully = false;
if (isset($_POST['delete'])) {

    $noteBelongsToUser = $db->prepare('SELECT * FROM Note INNER JOIN Topic_Note ON Note.id = Topic_Note.Note_id WHERE Topic_Note.Topic_id=:topic_id AND Note.id=:id  LIMIT 1;');

    $noteBelongsToUser->execute([
        ':topic_id' => $id,
        ':id' => $_POST['id']
    ]);

    if ($noteBelongsToUser->rowCount() == 1) {
        $sql = "DELETE FROM Note WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['id']]);
        $deletedSuccesfully = true;
    } else {
        header('Location: ../topics.php');
    }

}

$notes = null;
$allNotesQuery = $db->prepare('SELECT * FROM Note INNER JOIN Topic_Note ON Note.id = Topic_Note.Note_id WHERE Topic_Note.Topic_id=:topic_id;');

$allNotesQuery->execute([
    ':topic_id' => $id,
]);

if ($allNotesQuery->rowCount() > 0) {
    $notes = $allNotesQuery->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../css/inner.css">
</head>

<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-primary ms-auto">
    <div class="navbar-brand"><?= $_SESSION['user_email'] ?></div>
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
        <div class="col-4 text-center h5 my-3"><?= $_GET['topic'] ?> - notes</div>
        <div class="col-4 text-center h5 my-3 text-success"><?= $deletedSuccesfully ? 'Note deleted!' : '&nbsp;' ?></div>
        <div class='col-2 d-flex align-items-center justify-content-center '><a
                    href='./add.php?topic=<?= $_GET['topic'] ?>' class='btn btn-success btn-padded'>Add</a></div>
        <div class="col-2 d-flex align-items-center justify-content-center">
            <a class='btn btn-secondary btn-padded' href="../topics.php">Back</a>
        </div>
    </div>

    <?php
    if ($notes === null) {
        echo "<div class='row my-3 d-flex flex-row align-items-center justify-content-center'> 
<div class='col-12 my-auto'><p class='h2 text-center'>No notes found</p>
</div>
</div>";
    } else {
        foreach ($notes as $note) {
            echo "<form class='my-3 d-flex flex-row align-items-center justify-content-center' method='post' action='' >
    <input type='hidden' name='id' value='" . $note['id'] . "' readonly>
    <div class='col-4 my-auto text-fit d-flex align-items-center justify-content-center' ><a class='h5 text-center text-wrap mw-40' href='study.php?topic=" . $_GET['topic'] . "&id=" . $note['id'] . "'>" . $note['heading'] . "</a></div>
     <div class='col-4 d-flex align-items-center justify-content-center'><button type='submit' name='delete' class='btn btn-danger btn-padded'>Delete everywhere</button></div>
 
     <div class='col-4 d-flex align-items-center justify-content-center'><a type='submit' href='package_manager.php?topic=" .$_GET['topic']."&id=". $note['id'] . "' class='btn btn-info btn-padded'>Adjust packages</a></div>
</form>    
";
        }
    }

    ?>

</main>
</body>

</html>