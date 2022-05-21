<?php

require_once 'utils/user.php';
require_once 'utils/facebook.php';


$fbHelper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $fbHelper->getAccessToken();
} catch (Exception $e) {
    echo 'Unable to log in with facebook. ' . $e->getMessage();
    exit();
}

if (!$accessToken) {
    exit('Unable to log in with facebook.');
}


$oAuth2Client = $fb->getOAuth2Client();

$accessTokenMetaData = $oAuth2Client->debugToken($accessToken);

$fbUserId = $accessTokenMetaData->getUserId();


$response = $fb->get('/me?fields=name,email', $accessToken);
$graphUser = $response->getGraphUser();

$fbUserEmail = $graphUser->getEmail();
$fbUserName = $graphUser->getName();


$query = $db->prepare('SELECT * FROM User_app WHERE facebook_id=:facebookId LIMIT 1');
$query->execute([':facebookId' => $fbUserId]);

if ($query->rowCount() > 0) {
    $user = $query->fetch(PDO::FETCH_ASSOC);
} else {
    $query = $db->prepare('SELECT * FROM User_app WHERE email=:email LIMIT 1');
    $query->execute([':email' => $fbUserEmail]);

    if ($query->rowCount() > 0) {
        $user = $query->fetch(PDO::FETCH_ASSOC);

        $updateQuery = $db->prepare('UPDATE User_app SET facebook_id=:facebookId WHERE id=:id LIMIT 1');
        $updateQuery->execute([':facebookId' => $fbUserId, ':id' => $user['id']]);
    } else {
        $insertQuery = $db->prepare('INSERT INTO User_app (email,facebook_id) VALUES (:email, :facebookId)');
        $insertQuery->execute([
            ':email' => $fbUserEmail,
            ':facebookId'=>$fbUserId
        ]);

        $query = $db->prepare('SELECT * FROM User_app WHERE facebook_id=:facebookId LIMIT 1');
        $query->execute([
            ':facebookId' =>$fbUserId
        ]);
        $user=$query->fetch(PDO::FETCH_ASSOC);

    }
}

if(!empty($user)){
    $_SESSION['user_id']=$user['id'];
    $_SESSION['user_email']=$user['email'];
}

header('Location: ./topics.php');