<?php 
    // hiding the warnings
    error_reporting(0);
    // connecting database
    require "utils/bd.php";
    $data = $_POST;
    if(isset($data['do_search'])){
        $errors = array();
        if(empty($data['student_name'])){
            $errors[] = "Пустое поле";
        }
        if(empty($errors)){
            $students = R::find("users","firstname LIKE ? OR surname LIKE ?",array($data['student_name'] . "%", $data['student_name'] . "%"));
            $success = "success";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск ученика</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <?php if($_SESSION['user_info']->moderator){ ?> 
    <div class="col-12 row">
        <div class="col-4"></div>
        <div class="col-4 my-4 text-center">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div class="form-group">
                    <label for="Inputname1">Имя ученика</label>
                    <input type="text" class="form-control" id="Inputname1" name="student_name">
                </div>
                <button type="submit" name="do_search" class="btn btn-lg btn-success w-50">Поиск</button>
            </form>
            <?php
                if($success == "success"){
            ?>
                <div class="table-responsive my-5">
                    <table class="table align-items-center">
                    <tbody class="list">
                        <tr>
                            <th>Фамилия и имя</th>
                            <th>Класс</th>
                            <th></th>
                        </tr>                       
                        <?php 
                            foreach($students as $student){ ?>
                                <tr>
                                    <th>
                                        <div class="text-center">
                                            <?php echo $student->surname . " " . $student->firstname; ?>
                                        </div>
                                    </th>
                                    <td>
                                        <div class="text-center">
                                            <?php 
                                                echo $student->grade;
                                            ?>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="/new_message.php" method="post">
                                            <div class="row mx-auto justify-content-end">
                                                <input type="hidden" name="student_id" value="<?php echo $student->id; ?>">
                                                <button type="submit" name="send_student" class="btn btn-sm btn-info">Написать сообщение</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                    </table>
                </div>
                <?php }
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
        <div class="col-4"></div>
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