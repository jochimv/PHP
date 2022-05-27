<?php
error_reporting(E_ERROR | E_PARSE);
require_once 'utils/user.php';
require_once 'utils/facebook.php';

if (!empty($_SESSION['user_id'])) {
    //uživatel už je přihlášený, nemá smysl, aby se registroval
    header('Location: topics.php');
    exit();
}

$fbHelper = $fb->getRedirectLoginHelper();
$permissions = ['email'];
$callbackUrl = htmlspecialchars('https://eso.vse.cz/~jocv00/app/fb-callback.php');

$fbLoginUrl = $fbHelper->getLoginUrl($callbackUrl, $permissions);

$mailExists = false;

if (!empty($_POST)) {
    $postedEmail = $_POST['email'];
    $getUserByEmailQuery = $db->prepare('SELECT * FROM User_app WHERE email=:email LIMIT 1;');
    $getUserByEmailQuery->execute([
        ':email' => $postedEmail
    ]);
    if ($getUserByEmailQuery->rowCount() > 0) {
        $mailExists = true;
    }

    if (!$mailExists) {
        $hashedPassword = password_hash($_POST['password1'], PASSWORD_DEFAULT);

        $insertNewUserQuery = $db->prepare('INSERT INTO User_app (email, password) VALUES (:email, :password);');
        $insertNewUserQuery->execute([
            ':email' => $postedEmail,
            ':password' => $hashedPassword,
        ]);

        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['user_email'] = $postedEmail;
        header('Location: topics.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="module" src="js/signup.js"></script>
    <link rel="stylesheet" href="css/outer.css">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
</head>

<body>

<div class="container h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100 mx-auto">
        <div class="col-md-9 col-lg-6 col-xl-5 disappear">
            <img src="https://images.squarespace-cdn.com/content/v1/56acc1138a65e2a286012c54/1522329772710-DO415TCYVGSQAMRFAI9Q/notes-3236566_1920.jpg?format=1000w"
                 class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form method="post">

                <div class="form-outline mb-3">
                    <input type="email" id="email" class="form-control form-control-lg " name="email"
                           placeholder="Enter a valid email address"/>
                    <label class="form-label" for="email">Email address</label>
                </div>

                <div class="form-outline mb-3">
                    <input type="password" pattern=".{6,32}" title="6 to 32 characters" id="password1"
                           class="form-control form-control-lg" name="password1" placeholder="Enter password"/>
                    <label class="form-label" for="password1">Password</label>
                </div>


                <div class="form-outline mb-3">
                    <input type="password" pattern=".{6,32}" title="6 to 32 characters" id="password2"
                           class="form-control form-control-lg" name="password2" placeholder="Enter password"/>
                    <label class="form-label" for="password2">Repeat password</label>
                </div>

                <div class="text-center px-5">
                    <p id="resultArea" class="fw-bold text-danger"><?php
                        if($mailExists){
                            echo 'This email is already taken';
                        }
                        ?></p>
                </div>

                <div class="text-center mt-4 pt-2 row">
                    <div class="col-5 centered">
                        <button class="btn btn-primary btn-lg btn-padded" id="signUp">Sign up</button>
                    </div>
                    <div class="col-2 centered">
                        <a href="<?= $fbLoginUrl ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                 class="bi bi-facebook" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col-5 centered d-flex flex-column">
                        <p class="small fw-bold mb-0">Already have an account?</p>
                        <a href="./login.php"
                           class="link-danger">Log
                            in</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


</body>
</html>