<?php 
    // hiding the warnings
    error_reporting(0);
    // connecting database
    require "utils/bd.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Персональный сайт учителя Зеленов Б.А.</title>
  </head>
  <body>
    <div class="col-12 my-4">
    <h1 class="text-center">Персональный сайт учителя Зеленов Б.А.</h1>
    <div class="col-12 row">
    <div class="col-3"></div>
    <div class="col-6 text-center">
    <?php 
    // checking if user not logged in
    if(!$_SESSION['user_info']){ ?>
      <a href="/signin.php">Авторизация</a> <br>
      <a href="/signup.php">Регистрация</a>
    <?php 
    } 
    // checking if user moderator
    elseif($_SESSION['user_info']->moderator) { ?>
      <a href="/admin.php">Админ панель</a><br>
      <a href="/upload.php">Загрузить материалы</a><br>
      <a href="/search.php">Поиск ученика</a><br>
      <a href="/logout.php">Выйти</a>
    <?php 
    } 
    // checking if user logged in
    elseif($_SESSION['user_info']){ ?>
      <a href="/search_material.php">Поиск материала</a><br>
      <a href="/logout.php">Выйти</a>
    <?php 
    } 
    ?>
    </div>
    <div class="col-3"></div>
    </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>