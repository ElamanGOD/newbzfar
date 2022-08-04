<?php 
    // connecting database
    require "utils/bd.php";
    // variable for user input
    $data = $_POST;
    // array with errors
    $errors = array();
    // checking if user is trying to log in
    if(isset($data['do_login'])){
        // checking emptiness of email input
        if(empty($data['email'])){
            // fill errors variable with error
            $errors[] = "Введите e-mail";
        }
        // checking emptiness of password input
        if(empty($data['password'])){
            // fill errors variable with error
            $errors[] = "Введите пароль";
        }
        // finding any user with inputted email
        $user = R::findOne("users","email = ?",array($data['email']));
        // checking if there is no user with this email
        if(empty($user)){
            // fill errors variable with error
            $errors[] = "Пользователь с таким email не найден";
        }
        // checking if there is any user with this email
        if($user){
            // cheking password correction
            if(!(password_verify($data['password'],$user->password))){
                // fill errors variable with error
                $errors[] = "Пароль введен неправильно";
            }
        }
        // checking if there is no errors
        if(empty($errors)){
            // finding info about user
            $user = R::findOne("users","email = ?",array($data['email']));
            // filling session variable with user data
            $_SESSION['user_info'] = $user;
            //redirecting to main page
            header('Location: /index.php');   
            die();
        }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="icon" href="assets/img/brand/favicon.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .signup{
            margin: 15px 15px;
        }
        body{
            background-image: url("/assets/img/sign.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
        body, html{
            margin: 0; height: 100%; overflow: hidden
        }
        .formsignup{
            border: 2px solid white;
            border-radius: 25px;
        }
    </style>
    <title>Авторизация</title>
  </head>
  <body class="vh-100">
    <div class="row h-100 justify-content-center align-items-center signup">
        <form class="col-10 col-md-6 col-lg-4 bg-white py-5 formsignup" method="post">
            <?php 
            // checking if there's errors
            if(!empty($errors)) { ?>
                <div style="color: red; font-size:24px;" class="col-12 text-center">
                    <?php
                        // showing errors one by one
                        echo array_shift($errors); 
                    ?>
                </div>
            <?php 
            }
            ?>
            <div class="form-group">
                <h2 class="text-center text-dark py-3">Авторизация</h2> 
            </div>
            <div class="form-group w-75 mx-auto">
                <label for="formGroupExampleInput">E-mail</label>
                <input name="email" type="email" class="form-control" placeholder="Ваш E-mail">
            </div>
            <div class="form-group w-75 mx-auto">
                <label for="formGroupExampleInput">Пароль</label>
                <input name="password" type="password" class="form-control" placeholder="Ваш пароль">
            </div>
            <div class="form-group pt-4">
                <button class="btn btn-lg btn-block w-50 btn-success mx-auto" type="submit" name="do_login">Авторизация</button>
            </div>
        </form> 
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>