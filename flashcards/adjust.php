<?php
require_once '../utils/user.php';

$updatedSuccessfully = false;
if(isset($_POST['id'])){
    $flashcardId = $_POST['id'];
    $checkQuery = $db->prepare('SELECT * FROM Flashcard INNER JOIN Topic ON Flashcard.Topic_id = Topic.id WHERE Flashcard.id=:id AND User_id=:user_id LIMIT 1;');
    $checkQuery->execute([
        ':id' => $flashcardId,
        ':user_id' => $_SESSION['user_id']
    ]);
    if ($checkQuery->rowCount() == 1) {
        $sql = "UPDATE Flashcard SET question=?, answer=? WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['question'],$_POST['answer'],$_POST['id']]);

        $updatedSuccessfully = true;
    } else {
        header('Location: ../topics.php');
    }
} else {
    echo '$_post id not set';
    var_dump($_POST);
}


$topic = null;
if (isset($_GET['id'])){
    $flashcardId = $_GET['id'];
    $checkQuery = $db->prepare('SELECT * FROM Flashcard INNER JOIN Topic ON Flashcard.Topic_id = Topic.id WHERE Flashcard.id=:id AND User_id=:user_id LIMIT 1;');
    $checkQuery->execute([
        ':id' => $flashcardId,
        ':user_id' => $_SESSION['user_id']
    ]);

    if ($checkQuery->rowCount() == 1) {

        $topic = $checkQuery->fetch(PDO::FETCH_ASSOC);
    } else {
        header('Location: ../topics.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/>
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
            <a class="nav-item nav-link" href="#">Pricing</a>
            <a class="nav-item nav-link" href="./logout.php">Log out</a>
        </div>
    </div>
</nav>

<main class="content">

    <div class="d-flex flex-row">
        <div class="col-6 h5">Update flashcard</div>
        <?php if ($updatedSuccessfully) {
            echo '<div class="col-6 text-success h5">Flashcard updated!</div>';
        } else {
            echo '<div class="col-6h5">&nbsp;</div>';
        }

        ?>
    </div>



    <form method="post" action="" class="gapped-form">
        <input type="hidden" value="<?=$_GET['id']?>" name="id" readonly>
        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" class="form-control" id="question" name="question" required
                   placeholder="What is Forrest Gump’s email password?" value="<?=$topic['question'] ?>">
        </div>

        <div class="form-group">
            <label for="answer">Answer</label>
            <textarea class="form-control" id="answer" name="answer" required placeholder="1forrest1"
                      rows="3"><?=$topic['answer'] ?></textarea>
        </div>

        <div class="col-6 row">
            <div class="col-4">
                <button class='btn btn-primary btn-padded'>Adjust</button>
            </div>
            <div class="col-4">
                <a class='btn btn-secondary btn-padded' href="./manage.php?topic=<?=$topic['name']?>">Back</a>
            </div>

        </div>
    </form>


</main>
</body>

</html>
