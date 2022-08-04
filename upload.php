<?php 
    // hiding the warnings
    error_reporting(0);
    // connecting database
    require "utils/bd.php";
    // declaring variables
    $data = $_POST;
    $errors = array();
    $success = array();
    // checking if user pressed the button
    if(isset($data['do_upload'])){
        // cheking emptiness of topic name
        if(empty(trim($data['material_topic']))){
            $errors[] = "Не введено название материала";
        }
        // checking if there's no errors
        if(empty($errors)){
            // variaables to upload materials
            $total = count($_FILES["materials"]["name"]);
            $target_dir = "uploads/";
            $topic = R::findOne('materials', 'topic = ?', array($data['material_topic']));

            // cheking if topic with same name exists
            if($topic){
                $materials = $topic;
            } else{
                $materials = R::dispense("materials");
                $materials->topic = $data["material_topic"];
                R::store($materials);
            }

            // loop to upload several materials
            for ($j=0; $j < $total; $j++){
                // variable to contain the path of file
                $target_file = $target_dir . basename($_FILES["materials"]["name"][$j]);
                // variable to check is everything ok
                $status = 1;
                // check if file already exists
                if (file_exists($target_file)) {
                    $errors[] = "Файл с именем " . $_FILES["materials"]["name"][$j] . " уже существует";
                    $status = 0;
                }
                // check is there no errors       
                if ($status == 1) {
                    // checking is everything with the upload of file
                    if (move_uploaded_file($_FILES["materials"]["tmp_name"][$j], $target_file)) {    
                        // creating new record in files table                    
                        $files = R::dispense("files");
                        $files->topicId = $materials->id;
                        $files->files = $target_file;
                        $files->date = date("Y-m-d H:i:s");
                        $files->created_by = $_SESSION['user_info']->id;
                        // checking if user is moderator
                        if($_SESSION['user_info']->moderator){
                            $files->moderated = true;
                            $files->moderated_by = $_SESSION['user_info']->id;
                        } else {
                            $files->moderated = false;
                        }
                        // stroing record
                        R::store($files);
                        // filling array with success message
                        $success[] = "Файл ". basename( $_FILES["materials"]["name"][$j]). " загружен";
                    } else {
                        // filling array with error message
                        $errors[] = "Извините, произошла ошибка при загрузке вашего файла";
                    }
                }
            }  
        } 
    }
?>
<?php require "head.php"; ?>

<body>
  <?php if($_SESSION['user_info']){ ?>
  <?php require "nav.php"; ?>
    <div class="container-fluid mt-4">
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
            // checking if there's error messages
            if(!empty($errors)){ ?>
                <div style="color: red; font-size:24px;" class="col-12 my-2 text-center">
                    <?php 
                        // showing errors one by one
                        echo array_shift($errors); 
                    ?>
                </div>
            <?php
            } 
            // checking if there's success messages
            if(!empty($success)){ ?>
                <div style="color: #68FF00; font-size:24px;" class="col-12 my-2 text-center">
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
      <?php require "footer.php"; ?>
    </div>
  </div>
  <?php } else { ?>
      <?php require "not_logged.php"; ?>
  <?php } ?>
  <?php require "scripts.php"; ?>
</body>

</html>