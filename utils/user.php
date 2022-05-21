<?php

session_start();

require_once 'db.php';

if (!empty($_SESSION['user_id'])) {
    $userQuery = $db->prepare('SELECT id FROM User_app WHERE id=:id LIMIT 1;');
    $userQuery->execute([
        ':id' => $_SESSION['user_id']
    ]);
    if ($userQuery->rowCount() != 1) {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        header('Location: login.php');
        exit();
    }
}
