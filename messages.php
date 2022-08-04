<?php 
  // hiding the warnings
  // error_reporting(0);
  // connecting database
  require "utils/bd.php";
  // variable for user input
  $data = $_POST;
?>
<?php require "head.php"; ?>
<body>
  <?php if($_SESSION['user_info']){ ?>
    <?php require "nav.php"; ?>
    <div class="container-fluid mt-4">
    <?php 
      // finding all char users
      $chat_users = R::find("users","id != ?",array($_SESSION['user_info']->id));
    ?>
          <h2>Диалоги:</h2>
          <?php
            // checking if chat users are found 
            if($chat_users){
              // using loop to show chat users one-by-one
              foreach($chat_users as $user){
          ?>
          <div class="col-12 row">
              <?php 
                // checking if user is found
                if($user){ 
              ?>
                <div class="col-11 my-2">
                    <h3>
                    <?php
                      // finding unread message 
                      $unread_message = R::find("messages","sender_id = ? AND receiver_id = ? AND is_readed = ?",array($user->id, $_SESSION['user_info']->id, false));
                      // showing unread if unread message is found
                      if($unread_message){
                    ?>
                      <span class="text-success" style="font-size:10px;">unread</span>
                    <?php 
                      }
                    ?>
                    <?php // displaying user information ?>
                    <?php echo $user->surname . " " . $user->firstname; ?>
                    </h3>
                    <h5>
                        <?php echo $user->grade . " класс"; ?> 
                    </h5>
                </div>
                <div class="col-1 my-2 px-5">
                    <form action="/show_messages.php" method="post">
                        <input type="hidden" name="contact_id" value="<?php echo $user->id; ?>">
                        <button class="btn btn-lg btn-success" type="submit" name="open_messages">Открыть диалог</button>
                    </form>
                </div>
              <?php } ?>
          </div>
          <?php 
            }
          } 
          ?>
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
