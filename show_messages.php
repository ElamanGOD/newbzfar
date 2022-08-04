<?php 
  // connecting database
    require "utils/bd.php";
    // declaring variables
    $errors = array();
    $data = $_POST;
    // checking if user is trying to open dialogue
    if(!isset($data['open_messages'])){
        // error message
        $errors[] = "Извините, но вы не выбрали диалог";
    }
    // checking if user selected right contacter
    if(!isset($data['contact_id'])){
        // error message
        $errors[] = "Извините, выбранный собеседник не был найден";
    }
    // checking if errors aren't found
    if(empty($errors)){
        // finding contacter info
        $user = R::findOne("users","id = ?",array($data['contact_id']));
        // checking if user is found
        if($user){
            // finding messages of the dialogue
            $messages = R::find("messages","(receiver_id = ? AND sender_id = ?) OR (receiver_id = ? AND sender_id = ?) ORDER BY dateandtime",array($_SESSION['user_info']->id, $user->id , $user->id ,$_SESSION['user_info']->id));
            // checking if messages are found
            if($messages){
                // loop to put readed sign on every message
                foreach($messages as $message){
                    $message->is_readed = true;
                    R::store($message);
                }
            }
        }
    }

    // checking if user is tring to send a message
    if(isset($data['send_new_message'])){
        // checking emptiness of message
        if(empty(trim($data['message_text']))){
            // error message
            $errors[] = "Не введен текст сообщения";
        }
        // checking if errors aren't found
        if(empty($errors)){
            $message = R::dispense("messages");
            $message->sender_id = $_SESSION['user_info']->id;
            $message->receiver_id = $data['receiver_id'];
            $message->message_text = $data['message_text'];
            $message->dateandtime = date("Y-m-d H:i:s");
            $message->is_readed = false;
            R::store($message);
            //redirecting to main page
            header('Location: /messages.php');   
            die();
        }
    }
?>

<?php require "head.php"; ?>
<body>
  <?php if($_SESSION['user_info']){ ?>
    <?php require "nav.php"; ?>
    <div class="container-fluid row mt-4">
        <?php 
            // checking if errors aren't found
            if(empty($errors)){ 
        ?>
            <div class="col-9 bg-white">
                <?php // outputting user info ?>
                <h2 class="text-center">Выбранный собеседник:</h2>
                <h3 class="text-center">
                    <?php echo $user->surname . " " . $user->firstname; ?>
                </h3>
                <h4 class="text-center">
                    <?php echo $user->grade . " класс"; ?> 
                </h4>
                <?php 
                    // loop to output messages one-by-one
                    foreach($messages as $message){ 
                ?>
                <div class="clearfix">
                    <?php // checking who is the sender to show messages on correct side ?>
                    <div class="<?php if($message->sender_id == $_SESSION['user_info']->id){ echo "float-right"; } elseif ($message->sender_id == $user->id){ echo "float-left"; } ?>">
                        <?php // outputting message date, sender and text ?>
                        <h6><?php if($message->sender_id == $_SESSION['user_info']->id){ echo $_SESSION['user_info']->surname . " " . $_SESSION['user_info']->firstname; } elseif ($message->sender_id == $user->id){ echo $user->surname . " " . $user->firstname; } ?></h6>
                        <h6><?php echo $message->dateandtime; ?></h6>
                        <p class="bg-primary border-dark text-white rounded p-2" style="font-size: 0.8em;"><?php echo $message->message_text; ?></p>
                    </div>
                </div>
                <?php 
                    } 
                ?>
            </div>
            <div class="col-3 text-center">
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <input type="hidden" name="receiver_id" value="<?php echo $user->id; ?>">
                    <div class="form-group">
                        <label for="Inputtext1">Текст сообщения</label>
                        <textarea type="text" rows="10" class="form-control" id="Inputtext1" name="message_text"></textarea>
                    </div>
                    <button type="submit" name="send_new_message" class="btn btn-lg btn-primary">Отправить</button>
                </form>
            </div>  
        <?php } ?>      
        <?php
            // checking if there are no message 
            if(!empty($errors)){ ?>
                <div style="color: red; font-size:24px;" class="col-12 my-2 text-center">
                    <?php 
                        // showing errors one by one
                        echo array_shift($errors); 
                    ?>
                </div>
        <?php
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
