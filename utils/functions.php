<?php

function getTopicId()
{
    require (realpath(dirname(__FILE__) . '/db.php'));
    if (!isset($_GET['topic'])) {
        header('Location: ../topics.php');
    } else {
        $checkQuery = $db->prepare('SELECT * FROM Topic WHERE name=:name AND User_id=:user_id LIMIT 1;');
        $checkQuery->execute([
            ':name' => $_GET['topic'],
            ':user_id' => $_SESSION['user_id']
        ]);
        if (!$checkQuery->rowCount() == 1) {
            header('Location: ../topics.php');
        } else {
            $topic = $checkQuery->fetch(PDO::FETCH_ASSOC);
            return $topic['id'];
        }
    }
}