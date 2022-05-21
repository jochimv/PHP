<?php
require_once '../utils/user.php';
require_once '../utils/functions.php';

$addedSuccessfully = false;
$flashcardAlreadyExists = false;
$id = getTopicId();
if (!empty($_POST)) {
    $flashcardNameQuery = $db->prepare('SELECT * FROM Flashcard INNER JOIN Topic ON Flashcard.Topic_id = Topic.id WHERE Flashcard.question=:question AND Topic.User_id=:user_id AND Flashcard.Topic_id=:topic_id LIMIT 1;');
    $flashcardNameQuery->execute([
        ':question' => $_POST['question'],
        ':user_id' => $_SESSION['user_id'],
        ':topic_id' => $id
    ]);

    if ($flashcardNameQuery->rowCount() == 1) {

        $flashcardAlreadyExists = true;
    } else {
        $saveQuery = $db->prepare('INSERT INTO Flashcard (question,answer,Topic_id) VALUES (:question,:answer,:topic_id);');
        $saveQuery->execute([
            ':question' => $_POST["question"],
            ':answer' => $_POST['answer'],
            ':topic_id' => $id
        ]);
        $addedSuccessfully = true;
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add flashcard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/inner.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
</head>

<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-primary ms-auto">
    <div class="navbar-brand max-50"><?= htmlspecialchars($_SESSION['user_email'])?></div>
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
        <div class="col-6 h5 break-word"><?= htmlspecialchars($_GET['topic']) ?> - add a flashcard</div>
        <?php if ($addedSuccessfully) {
            echo '<div class="col-6 text-success h5" id="resultArea">New flashcard added!</div>';
        } else if ($flashcardAlreadyExists) {
            echo '<div class="col-6 text-danger h5" id="resultArea">Flashcard with this name already exists</div>';
        } else {
            echo '<div class="col-6 text-danger h5" id="resultArea">&nbsp;</div>';
        }
        ?>
    </div>


    <form method="post" action="" class="gapped-form">
        <div class="form-group">
            <label for="question">Add a question</label>
            <input type="text" class="form-control" id="question" name="question" required maxlength="255"
                   placeholder="What is Forrest Gump’s email password?">
        </div>

        <div class="form-group">
            <label for="answer">Add an answer</label>
            <textarea class="form-control" id="answer" name="answer" required placeholder="1forrest1" maxlength="255"
                      rows="3"></textarea>
        </div>

        <div class="col-6 row">
            <div class="col-4">
            <button class='btn btn-primary btn-padded' id="add">Add</button>
            </div>
            <div class="col-4">
                <a class='btn btn-secondary btn-padded ml-s' href="./index.php?topic=<?=htmlspecialchars($_GET['topic'])?>">Back</a>
            </div>

        </div>
    </form>

</main>
</body>

</html>