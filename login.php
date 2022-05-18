<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    var_dump($_POST);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <script src="js/login.js"></script>
</head>

<body>

<div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100 mx-auto">
        <div class="col-md-9 col-lg-6 col-xl-5 disappear">
            <img src="https://images.squarespace-cdn.com/content/v1/56acc1138a65e2a286012c54/1522329772710-DO415TCYVGSQAMRFAI9Q/notes-3236566_1920.jpg?format=1000w" class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form method="post" action="">
                <!-- Email input -->
                <div class="form-outline mb-3 px-5 px-md-0">
                    <input type="email" id="email" name="email" class="form-control form-control-lg " placeholder="Enter a valid email address" />
                    <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-3 px-5 px-md-0">
                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter password" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <div class="text-center text-sm-start mt-4 mb-4 row">
                    <div class="col-6 centered">
                        <button id="logIn" class="btn btn-primary btn-lg btn-padded">Log in</button>
                    </div>
                    <div class="col-6 centered">
                        <div class="centered flex-column">
                            <p class="small fw-bold mt-2 mb-0">Don't have an account?</p>
                            <a href="./signup.php" class="link-danger">Sign up</a>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

</body>

</html>