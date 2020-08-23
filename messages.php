<?php 
    // hiding the warnings
    //error_reporting(0);
    // connecting database
    require "utils/bd.php";
    $data = $_POST;
    $used = array();
    $errors = array();
    $messages = R::find("messages","sender_Id = ? OR receiver_Id = ?", array($_SESSION['user_info']->id, $_SESSION['user_info']->id));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сообщения</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <?php if($_SESSION['user_info']){ ?>
    <div class="col-12 row my-5">
        <div class="col-5 text-center my-1">
            <h2>Диалоги:</h2>
            <?php 
            if($messages){
                foreach($messages as $message){
                    for($i=0;$i=count($used);$i++){
                        if(($message->sender_id == $used[$i]) || ($message->receiver_id == $used[$i])){
                            $used_contact = "used";
                        }
                    }
                    if($used_contact != "used"){
                        if($message->sender_id == $_SESSION['user_info']->id){
                            $contacter = R::findOne("users","id = ?",array($message->receiver_id));
                            $used[] = $message->receiver_id;
                        }  else {
                            $contacter = R::findOne("users","id = ?",array($message->sender_id));
                            $used[] = $message->sender_id;
                        }
                    }
            ?>
            <div class="col-12 row">
                <?php if($contacter){ ?>
                <div class="col-9 my-2">
                    <h3>
                        <?php echo $contacter->surname . " " . $contacter->firstname; ?>
                    </h3>
                    <h4>
                        <?php echo $contacter->grade . " класс"; ?> 
                    </h4>
                </div>
                <div class="col-3">
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <input type="hidden" name="contactId" value="<?php echo $contacter->id; ?>">
                        <button class="btn btn-lg btn-success" type="submit" name="open_messages">Открыть диалог</button>
                    </form>
                </div>
                <?php } ?>
            </div>
            <?php 
                }
            } else { ?>
                <h2>У вас нет доступных диалогов</h2>
            <?php } ?>
        </div>

        <div class="col-7 text-center">
            
        </div>
        <?php 
        if(!empty($errors)){ ?>
            <div style="color: red; font-size:24px;" class="col-12 text-center">
                <?php 
                    // showing errors one by one
                    echo array_shift($errors); 
                ?>
            </div>
        <?php
        }
        ?>
    </div>
    <?php } else { ?>
        <div style="color: red; font-size:24px;" class="col-12 my-4 text-center">
                Пожалуйста, <a href="/signin.php">авторизуйтесь</a> или <a href="/signup.php">зарегистрируйтесь</a>
        </div>
    <?php } ?>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>