<?php
error_reporting(E_ERROR | E_PARSE);
require_once 'utils/user.php';
require_once 'utils/facebook.php';

if (!empty($_SESSION['user_id'])) {
    //uživatel už je přihlášený, nemá smysl, aby se přihlašoval znovu
    header('Location: topics.php');
    exit();
}

$fbHelper = $fb->getRedirectLoginHelper();
$permissions = ['email'];
$callbackUrl = htmlspecialchars('https://eso.vse.cz/~jocv00/app/fb-callback.php');

$fbLoginUrl = $fbHelper->getLoginUrl($callbackUrl, $permissions);

$invalidCredentials = false;
if (!empty($_POST)) {
    $userQuery = $db->prepare('SELECT * FROM User_app WHERE email=:email LIMIT 1;');
    $userQuery->execute([
        ':email' => trim($_POST['email'])
    ]);
    if ($user = $userQuery->fetch(PDO::FETCH_ASSOC)) {

        if (password_verify($_POST['password'], $user['password'])) {
            //heslo je platné => přihlásíme uživatele
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: topics.php');
            exit();
        } else {
            $invalidCredentials = true;
        }

    } else {
        $invalidCredentials = true;
    }
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
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="css/outer.css">
    <script src="js/login.js"></script>
</head>

<body>

<div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100 mx-auto">
        <div class="col-md-9 col-lg-6 col-xl-5 disappear">
            <img src="https://images.squarespace-cdn.com/content/v1/56acc1138a65e2a286012c54/1522329772710-DO415TCYVGSQAMRFAI9Q/notes-3236566_1920.jpg?format=1000w"
                 class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form method="post" action="">

                <div class="form-outline mb-3 px-5 px-md-0">
                    <input type="email" id="email" name="email" class="form-control form-control-lg "
                           placeholder="Enter a valid email address"/>
                    <label class="form-label" for="email">Email address</label>
                </div>

                <div class="form-outline mb-3 px-5 px-md-0">
                    <input type="password" id="password" name="password" class="form-control form-control-lg"
                           placeholder="Enter password"/>
                    <label class="form-label" for="password">Password</label>
                </div>

                <div class="text-center text-sm-start mt-4 mb-4 row">
                    <div class="col-5 centered">
                        <button id="logIn" class="btn btn-primary btn-lg btn-padded">Log in</button>
                    </div>
                    <div class="col-2 centered">
                        <a href="<?= $fbLoginUrl ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                 class="bi bi-facebook" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col-5 centered">
                        <div class="centered flex-column">
                            <p class="small fw-bold mt-2 mb-0">Don't have an account?</p>
                            <a href="./signup.php" class="link-danger">Sign up</a>
                        </div>
                    </div>
                </div>
                <?php
                if ($invalidCredentials) {
                    echo '<p class="text-center text-danger h5 w-100">Invalid credentials</p>';
                }
                ?>
            </form>

        </div>
    </div>
</div>

</body>

</html>