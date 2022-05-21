<?php

require_once '../utils/user.php';
require_once '../utils/functions.php';
$id = getTopicId();

$updatedSuccessfully = false;
if (isset($_POST['add'])) {
    $query = $db->prepare('SELECT * FROM Topic_Note WHERE Topic_id=:topic_id AND Note_id=:note_id LIMIT 1;');

    $query->execute([
        ':note_id' => $_GET['id'],
        ':topic_id' => $_POST['id']
    ]);
    if ($query->rowCount() == 1) {
        header('Location: ../topics.php');
    } else {
        $saveQuery = $db->prepare('INSERT INTO Topic_Note VALUES (:topic_id,:note_id);');
        $saveQuery->execute([
            ':note_id' => $_GET['id'],
            ':topic_id' => $_POST['id']
        ]);
        $updatedSuccessfully = true;
    }
} else if (isset($_POST['remove']) || isset($_POST['delete'])){
    $query = $db->prepare('SELECT * FROM Topic_Note WHERE Topic_id=:topic_id AND Note_id=:note_id LIMIT 1;');

    $query->execute([
        ':note_id' => $_GET['id'],
        ':topic_id' => $_POST['id']
    ]);
    if ($query->rowCount() == 0) {

        header('Location: ../topics.php');
    } else {
        $sql = "DELETE FROM Topic_Note WHERE Topic_id=? AND Note_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['id'],$_GET['id']]);
        $updatedSuccessfully = true;
    }
    if(isset($_POST['delete'])){

        $sql = "DELETE FROM Note WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_GET['id']]);
        $updatedSuccessfully = true;
    }
}

$getAllNotesQuery = $db->prepare('SELECT * FROM Note INNER JOIN Topic_Note ON Note.id = Topic_Note.Note_id INNER JOIN Topic ON Topic_Note.Topic_id = Topic.id WHERE Note.id=:id AND Topic.User_id=:user_id;');
$getAllNotesQuery->execute([
    ':id' => $_GET['id'],
    ':user_id' => $_SESSION['user_id']
]);

if($getAllNotesQuery->rowCount() === 0){
    header('Location: ../topics.php');
}

$noteInPackages = $getAllNotesQuery->fetchAll(PDO::FETCH_ASSOC);

$notInQuery = createNotInQuery(extractIds($noteInPackages));
$packagesWithoutNoteQuery = $db->prepare($notInQuery);

$packagesWithoutNoteQuery->execute([':user_id' => $_SESSION['user_id']]);
$packagesWithoutNote = $packagesWithoutNoteQuery->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage packages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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

    <div class="d-flex flex-row align-items-center justify-content-center">
        <div class="col-4 text-center h5 my-3 break-word"><?= htmlspecialchars($noteInPackages[0]['heading']) ?> - packages</div>
        <div class="col-4 text-center h5 my-3 text-success"><?= $updatedSuccessfully ? 'Packages updated!' : '&nbsp;' ?></div>
        <div class="col-2 d-flex align-items-center justify-content-center">
            <a class='btn btn-secondary btn-padded' href="./index.php?topic=<?= htmlspecialchars($_GET['topic']) ?>">Back</a>
        </div>
    </div>
    <form class='my-3 d-flex flex-row align-items-center justify-content-center' method='post' >
        <?php

        foreach ($noteInPackages as $noteInPackage) {

            echo "<form class='my-3 d-flex flex-row align-items-center justify-content-center' method='post' >
    <input type='hidden' name='id' value='" . htmlspecialchars($noteInPackage['id']) . "'>
    <div class='col-4 my-auto text-fit d-flex align-items-center justify-content-center' ><div class='h5 text-center text-wrap mw-40 break-word'>" . htmlspecialchars($noteInPackage['name']) . "</div></div>
     <div class='col-4 d-flex align-items-center justify-content-center'><button type='submit' class='btn btn-padded btn-danger'" . (count($noteInPackages) == 1? "name='delete'>Delete" : "name='remove'>Remove")  . "</button></div>
</form>    
";

        }
        foreach ($packagesWithoutNote as $package) {
            echo "<form class='my-3 d-flex flex-row align-items-center justify-content-center' method='post'  >
    <input type='hidden' name='id' value='" . htmlspecialchars($package['id']) . "'>
    <div class='col-4 my-auto text-fit d-flex align-items-center justify-content-center' ><div class='h5 text-center text-wrap mw-40 break-word'>" . htmlspecialchars($package['name']) . "</div></div>
     <div class='col-4 d-flex align-items-center justify-content-center'><button type='submit' name='add' class='btn btn-padded btn-success'>Add</button></div>
    </form>";
        }
        ?>
    </form>
</main>
</body>

</html>