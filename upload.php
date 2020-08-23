<?php 
    // hiding the warnings
    error_reporting(0);
    // connecting database
    require "utils/bd.php";
    $data = $_POST;
    $errors = array();
    $success = array();
    if(isset($data['do_upload'])){
        if(empty(trim($data['material_topic']))){
            $errors[] = "Не введено название материала";
        }
        if(empty($errors)){
            $total = count($_FILES["materials"]["name"]);
            $target_dir = "uploads/";
            $topic = R::findOne('materials', 'topic = ?', array($data['material_topic']));

            if($topic){
                $materials = $topic;
            } else{
                $materials = R::dispense("materials");
                $materials->topic = $data["material_topic"];
                R::store($materials);
            }

            for ($j=0; $j < $total; $j++){
                $target_file = $target_dir . basename($_FILES["materials"]["name"][$j]);
                $status = 1;
                // Check if file already exists
                if (file_exists($target_file)) {
                    $errors[] = "Файл с именем " . $_FILES["materials"]["name"][$j] . " уже существует";
                    $status = 0;
                }
                            
                if ($status == 1) {
                    if (move_uploaded_file($_FILES["materials"]["tmp_name"][$j], $target_file)) {                        
                        $files = R::dispense("files");
                        $files->topicId = $materials->id;
                        $files->files = $target_file;
                        $files->date = date("Y-m-d H:i:s");
                        $files->created_by = $_SESSION['user_info']->id;
                        if($_SESSION['user_info']->moderator){
                            $files->moderated = true;
                            $files->moderated_by = $_SESSION['user_info']->id;
                        } else {
                            $files->moderated = false;
                        }
                        R::store($files);
                        $success[] = "Файл ". basename( $_FILES["materials"]["name"][$j]). " загружен";
                    } else {
                        $errors[] = "Извините, произошла ошибка при загрузке вашего файла";
                    }
                }
            }  
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка материалов</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <?php if($_SESSION['user_info']){ ?>
    <div class="col-12 row my-4">
        <div class="col-4"></div>
        
        <div class="col-4 text-center">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="topicinput1">Название материала:</label><br>
                    <input type="text" class="w-50" name="material_topic" id="topicinput1">
                </div>
                <div class="form-group">
                    <label for="fileinput1">Выберите файлы:</label><br>
                    <input type="file" name="materials[]" id="fileinput1" multiple>
                </div>
                <button type="submit" name="do_upload" class="btn btn-lg btn-success w-50">Загрузить</button>
            </form>
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