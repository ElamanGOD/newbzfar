<?php 
    // hiding the warnings
    //error_reporting(0);
    // connecting database
    require "utils/bd.php";
    $data = $_POST;
    $errors = array();
    $success = array();
    if(isset($data['accept'])){
        $file = R::findOne("files", "id = ?", array($data['file_id']));
        $file->moderated = true;
        $file->moderated_by = $_SESSION['user_info']->id;
        R::store($file);
    }
    if(isset($data['decline'])){
        $file = R::findOne("files", "id = ?", array($data['file_id']));
        unlink($file->files);
        R::trash($file);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Модерация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <?php if($_SESSION['user_info']->moderator){ ?>
    <div class="col-12 row my-5">
    <div class="col-2"></div>
    <div class="col-8">
        <h2 class="text-center">Модерация материалов</h2>
        <?php 
            $unmoderated_files = R::find("files","moderated = ?",array(false));
            if($unmoderated_files){
        ?>
        <div class="table-responsive my-5 text-center">
            <table class="table align-items-center">
            <tbody class="list">
                <tr>
                    <th>Тема</th>
                    <th>Файл</th>
                    <th>Действия</th>
                </tr>   
        <?php 
            foreach($unmoderated_files as $file){ ?>
                    <tr>
                        <th>
                            <div class="text-center">
                                <?php
                                $topic = R::findOne("materials","id = ?",array($file->topic_id)); 
                                echo $topic->topic; ?>
                            </div>
                        </th>
                        <td>
                            <div class="text-center">
                                <a href="/<?php echo $file->files; ?>" download><?php echo $file->files; ?></a>
                            </div>
                        </td>
                        <td>
                            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                <div class="row mx-auto justify-content-center">
                                    <input type="hidden" name="file_id" value="<?php echo $file->id; ?>">
                                    <button type="submit" class="btn btn-sm btn-success mx-3" name="accept">Одобрить</button>
                                    <button type="submit" class="btn btn-sm btn-danger mx-3" name="decline">Отказать</button>
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
    <?php 
        } if(!empty($errors)){ ?>
                <div style="color: red; font-size:24px;" class="col-12 text-center">
                    <?php 
                        // showing errors one by one
                        echo array_shift($errors); 
                    ?>
                </div>
            <?php
        } if(!empty($success)){ ?>
            <div style="color: #68FF00; font-size:24px;" class="col-12 text-center">
                <?php 
                    for($i = 0; $i<count($success);$i++){
                        // showing success message
                        echo $success[$i] . "<br>"; 
                    }
                ?>
            </div>
        <?php
        }
    ?>
    </div>
    <div class="col-2"></div>
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