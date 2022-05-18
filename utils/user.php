<?php

  session_start(); //spustíme session

  require_once 'db.php'; //načteme připojení k databázi

  #region kontrola, jestli je přihlášený uživatel platný
  if (!empty($_SESSION['user_id'])){
    $userQuery=$db->prepare('SELECT id FROM User_app WHERE id=:id LIMIT 1;');
    $userQuery->execute([
      ':id'=>$_SESSION['user_id']
    ]);
    if ($userQuery->rowCount()!=1){
      //uživatel už není v DB, nebo není aktivní => musíme ho odhlásit
      unset($_SESSION['user_id']);
      //změněno na email, nebudu používat jméno
      unset($_SESSION['user_email']);
      header('Location: login.php');
      exit();
    }
  }
  #endregion kontrola, jestli je přihlášený uživatel platný