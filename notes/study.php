<?php

require_once '../utils/user.php';
require_once '../utils/functions.php';
$id = getTopicId();


$noteAlreadyExists = false;
$updatedSuccessfully = false;
if (isset($_POST['heading']) && isset($_POST['content'])) {
    $noteBelongsToUser = $db->prepare('SELECT * FROM Note INNER JOIN Topic_Note ON Note.id = Topic_Note.Note_id WHERE Topic_Note.Topic_id=:topic_id AND Note.id=:id  LIMIT 1;');

    $noteBelongsToUser->execute([
        ':topic_id' => $id,
        ':id' => $_POST['id']
    ]);

    if ($noteBelongsToUser->rowCount() === 0) {
       header('Location: ../topics.php');


    } else {
        // kontrola jestli už existuje nějaká note se stejným jménem
        $noteNameQuery = $db->prepare('SELECT * FROM Note INNER JOIN Topic_Note ON Note.id = Topic_Note.Note_id WHERE Note.heading=:heading AND Topic_Note.Topic_id=:topic_id LIMIT 1;');

        $noteNameQuery->execute([
            ':heading' => $_POST['heading'],
            ':topic_id' => $id,
        ]);
        $note = $noteNameQuery->fetch(PDO::FETCH_ASSOC);
        //pokusili jsme se změnit heading na heading, který již existuje
        if ($noteNameQuery->rowCount() == 1 && $_POST['id'] !== $note['id']) {
            $noteAlreadyExists = true;
        } else {

            $sql = "UPDATE Note SET heading=?, text=? WHERE id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$_POST['heading'], $_POST['content'], $_POST['id']]);
            $updatedSuccessfully = true;
        }
    }
}

if (isset($_GET['id']) && isset($_GET['topic'])) {

    $noteBelongsToUser = $db->prepare('SELECT * FROM Note INNER JOIN Topic_Note ON Note.id = Topic_Note.Note_id WHERE Topic_Note.Topic_id=:topic_id AND Note.id=:id  LIMIT 1;');

    $noteBelongsToUser->execute([
        ':topic_id' => $id,
        ':id' => $_GET['id']
    ]);

    if ($noteBelongsToUser->rowCount() === 0) {
        header('Location: ../topics.php');
    } else {
        $note = $noteBelongsToUser->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header('Location: ../topics.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/inner.css">

    <!-- include libraries(jQuery, bootstrap) -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"/>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- include summernote css/js-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>

    <script src="../js/updateNote.js"></script>
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
        <div class="col-6 h5"><?= $_GET['topic'] ?> - update a note</div>
        <?php if ($updatedSuccessfully) {
            echo '<div class="col-6 text-success h5" id="resultArea">Updated successfully!</div>';
        } else if ($noteAlreadyExists) {
            echo '<div class="col-6 text-danger h5" id="resultArea">Note with this name already exists</div>';
        } else {
            echo '<div class="col-6 text-danger h5" id="resultArea">&nbsp;</div>';
        }
        ?>
    </div>


    <form method="post" action="">
        <input type="hidden" name="id" value="<?= $note['id']?>">
        <div class="d-flex flex-column mb-4">
            <label for="heading">Heading</label>
            <input type="text" name="heading" placeholder="PHP lecture #1" id="heading"
                   value="<?= $note['heading'] ?>">
        </div>
        <textarea id="summernote" name="content" placeholder="Some fancy text"></textarea>
        <div class="row w-100 mt-4">
            <div class="col-2 mr-5">
                <button class="btn btn-padded btn-success" id="addNote">Update</button>
            </div>
            <div class="col-2">
                <div class="col-4 d-flex align-items-center justify-content-center ">
                    <a class='btn btn-secondary btn-padded' href="./index.php?topic=<?= $_GET['topic'] ?>">Back</a>
                </div>
            </div>
        </div>
    </form>


    <?php if ($noteAlreadyExists) {
        echo '<script>
        $(document).ready(function() {
            $("#summernote").summernote({
                height: 200
            });
            $("#summernote").summernote("code", "' . $_POST['content'] . '");
        });
    </script>
    ';
    } else {
        echo "<script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 200
            });
            $('#summernote').summernote('code','" . $note['text'] ."');
        });
    </script>";
    }
    ?>

</body>

</html>
