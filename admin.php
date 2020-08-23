<?php 
    // hiding the warnings
    error_reporting(0);
    // connecting database
    require "utils/bd.php";
    // checking if the user is moderator
    if($_SESSION['user_info']->moderator) {
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
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Админ панель</title>
  </head>
  <body>
    <div class="col-12 my-4 text-center">
    <?php 
      // checking if everything is ok outputing the message
      if($success){
        echo "<span style='font-size:36px; color: green;'>Successful</span>";
      }
    ?>
    <h1 class="text-center py-3">Админ панель</h1>
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
              <form action="admin.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                <button class="btn btn-sm btn-info" type="submit" name="do_moderator">Moderator</button>
              </form>
            </td>
          </tr>
        <?php
          }
        } 
        ?>
      </tbody>
    </table>
    <a href="index.php">Главная страница</a>
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
<?php 
} else {
    // if user is not moderator redirecting to main page
    header('Location: /index.php');   
    die();
}
?>