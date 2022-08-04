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
<?php require "head.php"; ?>

<body>
  <?php if($_SESSION['user_info']->moderator){ ?>
    <?php require "nav.php"; ?>
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
      <div class="col-12 text-center">
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
              <?php // outputting user info ?>
              <th scope="row"><?php echo $user->id; ?></th>
              <td><?php echo $user->firstname; ?></td>
              <td><?php echo $user->surname; ?></td>
              <td><?php echo $user->grade; ?></td>
              <td><?php echo $user->email; ?></td>
              <td>
              <?php // outputting forms to give and remove moderator permissions ?>
              <?php if($user->moderator){ ?>
                <form action="admin.php" method="post">
                  <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                  <button class="btn btn-sm btn-danger" type="submit" name="remove_moderator">Убрать модераторство</button>
                </form>
              <?php } else { ?>
                <form action="admin.php" method="post">
                  <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                  <button class="btn btn-sm btn-success" type="submit" name="do_moderator">Сделать модератором</button>
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
      </div>
      </div>
      <?php require "footer.php"; ?>
    </div>
  </div>
  <?php } else { ?>
      <?php require "not_logged.php"; ?>
  <?php } ?>
  <!-- Argon Scripts -->
  <!-- Core -->
  <?php require "scripts.php"; ?>
</body>

</html>