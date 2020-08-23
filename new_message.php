<?php 
    // hiding the warnings
    //error_reporting(0);
    // connecting database
    require "utils/bd.php";
    $data = $_POST;
    $errors = array();
    if(isset($data['send_student'])){
        if(empty($data['student_id'])){
            $errors[] = "Не выбран пользователь";
        }
        if(empty($errors)){
            $student = R::findOne("users","id = ?",array($data['student_id']));
            if($student){
                $success = "student_find";
            } else {
                $errors[] = "Пользователь не найден";
            }
        }
    }
    if(isset($data['send_new_message'])){
        if(empty(trim($data['message_text']))){
            $errors[] = "Не введен текст сообщения";
        }
        if(empty($errors)){
            $message = R::dispense("messages");
            $message->sender_id = $_SESSION['user_info']->id;
            $message->receiver_id = $data['receiverId'];
            $message->message_text = $data['message_text'];
            $message->dateandtime = date("Y-m-d H:i:s");
            R::store($message);
            //redirecting to main page
            header('Location: /index.php');   
            die();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Написать сообщение</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <?php if($_SESSION['user_info']->moderator){ ?>
    <div class="col-12 row my-5">
        <?php 
        if($success == "student_find"){ ?>
        <div class="col-5 text-center my-1">
            <h2>Выбранный ученик:</h2>
            <h3>
                <?php echo $student->surname . " " . $student->firstname; ?>
            </h3>
            <h4>
                <?php echo $student->grade . " класс"; ?> 
            </h4>
        </div>

        <div class="col-7 text-center">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <input type="hidden" name="receiverId" value="<?php echo $student->id; ?>">
                <div class="form-group">
                    <label for="Inputtext1">Текст сообщения</label>
                    <textarea type="text" rows="10" class="form-control" id="Inputtext1" name="message_text"></textarea>
                </div>
                <button type="submit" name="send_new_message" class="btn btn-lg btn-primary">Отправить</button>
            </form>
        </div>
        <?php 
        }
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