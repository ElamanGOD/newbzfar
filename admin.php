<?php 
    // hiding the warnings
    error_reporting(0);
    // connecting database
    require "utils/bd.php";
      // variable for user input
      $data = $_POST;
      $success = false;
      // check if user trying to give moderator status
      if(isset($data['do_moderator'])){
        // getting info about user
        $userid = $data['user_id'];
        // finding user
        $user = R::findOne("users","id = ?", array($userid));
        // checking if user found
        if($user){
          // giving moderator status
          $user->moderator = true;
          // storing user data
          R::store($user);
          // variable to define is everything ok
          $success = true;
        }
      }
      if(isset($data['remove_moderator'])){
        // getting info about user
        $userid = $data['user_id'];
        // finding user
        $user = R::findOne("users","id = ?", array($userid));
        // checking if user found
        if($user->moderator){
          // giving moderator status
          $user->moderator = false;
          // storing user data
          R::store($user);
          // variable to define is everything ok
          $success = true;
        }
      }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Панель управления</title>
  <!-- Favicon -->
  <link rel="icon" href="assets/img/brand/favicon.png" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css">
</head>

<body>
  <?php if($_SESSION['user_info']->moderator){ ?>
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="/index.php">
          <h1>BZFAR</h1>
        </a>
      </div>
      <div class="navbar-inner">
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/upload.php"){ echo "active"; } ?>" href="/upload.php">
                <i class="ni ni-cloud-upload-96 text-primary"></i>
                  <span class="nav-link-text">Загрузить материал</span>
              </a>
            </li>
            <?php if($_SESSION['user_info']->moderator){ ?>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/moderate_material.php"){ echo "active"; } ?>" href="/moderate_material.php">
                <i class="ni ni-check-bold text-primary"></i>
                  <span class="nav-link-text">Модерация материала</span>
              </a>
            </li>
            <?php } ?>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/search_material.php"){ echo "active"; } ?>" href="/search_material.php">
                <i class="fas fa-search text-primary"></i>
                  <span class="nav-link-text">Поиск материалов</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/search.php"){ echo "active"; } ?>" href="/search.php">
                <i class="fas fa-search text-primary"></i>
                  <span class="nav-link-text">Поиск ученика</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/messages.php"){ echo "active"; } ?>" href="/messages.php">
                <i class="ni ni-send text-primary"></i>
                  <span class="nav-link-text">Сообщения</span>
              </a>
            </li>
            <?php if($_SESSION['user_info']->moderator){ ?>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/admin.php"){ echo "active"; } ?>" href="/admin.php">
                <i class="fas fa-plus text-primary"></i>
                  <span class="nav-link-text">Управление модераторами</span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <div class="main-content" id="panel">
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold"><?php echo $_SESSION['user_info']->surname . " " . $_SESSION['user_info']->firstname; ?></span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right">
                <a href="/logout.php" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Выйти</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid mt-5">
    <h1 class="text-center">Админ панель</h1>
      <div class="col-12 my-4 text-center">
      <?php 
        // checking if everything is ok outputing the message
        if($success){
          echo "<span style='font-size:36px; color: green;'>Successful</span>";
        }
      ?>
      <div class="col-12 row">
      <div class="col-3"></div>
      <div class="col-6 text-center">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Grade</th>
            <th scope="col">Email</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          // get all users
          $users = R::findAll("users");
          // checking is users found
          if($users){
            // outputing every user by loop
            foreach($users as $user){ ?>
            <tr>
              <th scope="row"><?php echo $user->id; ?></th>
              <td><?php echo $user->firstname; ?></td>
              <td><?php echo $user->surname; ?></td>
              <td><?php echo $user->grade; ?></td>
              <td><?php echo $user->email; ?></td>
              <td>
                <?php if($user->moderator){ ?>
                  <form action="admin.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                    <button class="btn btn-sm btn-success" type="submit" name="remove_moderator">Убрать модераторство</button>
                  </form>
                <?php } else { ?>
                  <form action="admin.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                    <button class="btn btn-sm btn-danger" type="submit" name="do_moderator">Сделать модератором</button>
                  </form>
                <?php } ?>              
              </td>
            </tr>
          <?php
            }
          } 
          ?>
        </tbody>
      </table>
      </div>
      <div class="col-3"></div>
      </div>
      </div>
      <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-12">
            <div class="copyright text-center  text-lg-left  text-muted">
              &copy; 2020 <a href="https://github.com/ElamanGOD" class="font-weight-bold ml-1" target="_blank">Elaman</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <?php } else { ?>
      <div style="color: red; font-size:24px;" class="col-12 my-4 text-center">
        Пожалуйста, <a href="/signin.php">авторизуйтесь</a> или <a href="/signup.php">зарегистрируйтесь</a>
      </div>
  <?php } ?>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <!-- Argon JS -->
  <script src="assets/js/argon.js?v=1.2.0"></script>
</body>

</html>