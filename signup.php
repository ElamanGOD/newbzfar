<?php 
    // Connecting database
    require "utils/bd.php";
    // variable for user input
    $data = $_POST;
    // array with errors
    $errors = array();
    // check if user trying to signup
    if(isset($data['do_signup'])){
        // checking emptiness of email input
        if(empty($data['email'])){
            // fill errors variable with error
            $errors[] = "Введите e-mail";
        }
        // checking emptiness of firstname input
        if(empty($data['firstname'])){
            // fill errors variable with error
            $errors[] = "Введите имя";
        }
        // checking emptiness of surname input
        if(empty($data['surname'])){
            // fill errors variable with error
            $errors[] = "Введите фамилию";
        }
        // checking emptiness of password input
        if(empty($data['password1'])){
            // fill errors variable with error
            $errors[] = "Введите пароль";
        }
        // checking emptiness of password input
        if(empty($data['password2'])){
            // fill errors variable with error
            $errors[] = "Введите повтор пароля";
        }
        // checking passwords aren't equal 
        if($data['password1'] != $data['password2']){
            // fill errors variable with error
            $errors[] = "Пароли не совпадают";
        }
        // checking emptiness of grade input
        if(empty($data['grade'])){
            // fill errors variable with error
            $errors[] = "Выберите класс";
        }
        // checking another user with this email
        $another = R::findOne("users","email = ?",array($data['email']));
        if($another){
            // fill errors variable with error
            $errors[] = "Пользователь с таким e-mail зарегистрирован";
        }
        // checking no errors
        if(empty($errors)){
            // registration process
            // creating new record
            $user = R::dispense("users");
            // filling the attributes
            $user->email = $data['email'];
            $user->firstname = $data['firstname'];
            $user->surname = $data['surname'];
            $user->password = password_hash($data['password1'],PASSWORD_DEFAULT);
            $user->grade = $data['grade'];
            $user->moderator = false;
            // storing the record
            R::store($user);
            // redirect to main page
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
    <title>Регистрация</title>
  </head>
  <body class="vh-100">
    <div class="row h-100 justify-content-center align-items-center signup">
        <form class="col-10 col-md-6 col-lg-4 bg-white py-2 formsignup" method="post">
            <?php
            // cheking if there's errors
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
                <h2 class="text-center text-dark py-3">Регистрация</h2> 
            </div>
            <div class="form-group w-75 mx-auto">
                <label for="formGroupExampleInput">E-mail</label>
                <input name="email" type="email" class="form-control" placeholder="Ваш E-mail" required>
            </div>
            <div class="form-group w-75 mx-auto">
            <label for="formGroupExampleInput">Имя</label>
                <input name="firstname" type="text" class="form-control" placeholder="Ваше имя" required>
            </div>
            <div class="form-group w-75 mx-auto">
            <label for="formGroupExampleInput">Фамилия</label>
                <input name="surname" type="text" class="form-control" placeholder="Ваша фамилия" required>
            </div>
            <div class="form-group w-75 mx-auto">
            <label for="formGroupExampleInput">Пароль</label>
                <input name="password1" type="password" class="form-control" placeholder="Ваш пароль" required>
            </div>
            <div class="form-group w-75 mx-auto">
            <label for="formGroupExampleInput">Повторите пароль</label>
                <input name="password2" type="password" class="form-control" placeholder="Повторите пароль" required>
            </div>
            <div class="form-group w-75 mx-auto">
            <label for="formGroupExampleInput">Выберите класс</label>
                <select name="grade">
                    <option value="7">7 класс</option>
                    <option value="8">8 класс</option>
                    <option value="9">9 класс</option>
                    <option value="10">10 класс</option>
                    <option value="11">11 класс</option>
                    <option value="12">12 класс</option>
                </select>
            </div>
            <div class="form-group pt-4">
                <button class="btn btn-lg btn-block w-50 btn-success mx-auto" type="submit" name="do_signup">Регистрация</button>
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