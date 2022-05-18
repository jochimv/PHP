<?php
//načteme připojení k databázi a inicializujeme session
require_once 'utils/user.php';

if (!empty($_SESSION['user_id'])) {
    //uživatel už je přihlášený, nemá smysl, aby se registroval
    header('Location: topics.php');
    exit();
}


if (!empty($_POST)) {

    $email = $_POST['email'];
    $mailExists = false;
    //kontrola, jestli již není e-mail registrovaný
    $mailQuery = $db->prepare('SELECT * FROM User_app WHERE email=:email LIMIT 1;');
    $mailQuery->execute([
        ':email' => $email
    ]);
    if ($mailQuery->rowCount() > 0) {
        $mailExists = true;
    }

    if (!$mailExists) {
        //zaregistrování uživatele
        $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);

        $query = $db->prepare('INSERT INTO User_app (email, password,admin) VALUES (:email, :password, FALSE);');
        $query->execute([
            ':email' => $email,
            ':password' => $password,
        ]);

        //uživatele rovnou přihlásíme
        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['user_email'] = $email;

        //přesměrování na homepage
        header('Location: topics.php');
        exit();
    }
    #endregion zpracování formuláře
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="module" src="js/signup.js"></script>
    <link rel="stylesheet" href="css/outer.css">
</head>

<body>

<div class="container h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100 mx-auto">
        <div class="col-md-9 col-lg-6 col-xl-5 disappear">
            <img src="https://images.squarespace-cdn.com/content/v1/56acc1138a65e2a286012c54/1522329772710-DO415TCYVGSQAMRFAI9Q/notes-3236566_1920.jpg?format=1000w"
                 class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form method="post" action="">

                <div class="form-outline mb-3 px-5 px-md-0">
                    <input type="email" id="email" class="form-control form-control-lg " name="email"
                           placeholder="Enter a valid email address"/>
                    <label class="form-label" for="email">Email address</label>
                </div>

                <div class="form-outline mb-3 px-5 px-md-0">
                    <input type="password" pattern=".{6,32}" title="6 to 32 characters" id="password1"
                           class="form-control form-control-lg" name="password1" placeholder="Enter password"/>
                    <label class="form-label" for="password1">Password</label>
                </div>


                <div class="form-outline mb-3 px-5 px-md-0">
                    <input type="password" pattern=".{6,32}" title="6 to 32 characters" id="password2"
                           class="form-control form-control-lg" name="password2" placeholder="Enter password"/>
                    <label class="form-label" for="password2">Repeat password</label>
                </div>

                <div class="text-center px-5">
                    <p id="resultArea" class="fw-bold text-danger"></p>
                </div>

                <div class="text-center mt-4 pt-2 row">
                    <div class="col-6">
                        <button class="btn btn-primary btn-lg btn-padded" id="signUp">Sign up</button>
                    </div>
                    <div class="col-6">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account?</p>
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