<?php 
    // hiding the warnings
    //error_reporting(0);
    // connecting database
    require "utils/bd.php";
    // declaring variables
    $data = $_POST;
    $errors = array();
    $success = array();
    // check if user accepted the material
    if(isset($data['accept'])){
        // finding the material
        $file = R::findOne("files", "id = ?", array($data['file_id']));
        // changing moderated status
        $file->moderated = true;
        // inputting what user moderated material
        $file->moderated_by = $_SESSION['user_info']->id;
        // saving the record
        R::store($file);
    }
    // check if user declienced the material
    if(isset($data['decline'])){
        // finding the material
        $file = R::findOne("files", "id = ?", array($data['file_id']));
        // deleting the material
        unlink($file->files);
        // deleting record from table
        R::trash($file);
    }
?>

<?php require "head.php"; ?>

<body>
  <?php if($_SESSION['user_info']->moderator){ ?>
  <?php require "nav.php"; ?>
    <div class="container-fluid mt-4">
        <div class="col-12 row my-5">
        <div class="col-2"></div>
        <div class="col-8">
            <h2 class="text-center">Модерация материалов</h2>
            <?php 
                // finding unmoderated files
                $unmoderated_files = R::find("files","moderated = ?",array(false));
                // check if unmoderated files are found
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
                // showing unmoderated materials one-by-one
                foreach($unmoderated_files as $file){ ?>
                        <tr>
                            <th>
                                <div class="text-center">
                                    <?php
                                    // finding the topic of material
                                    $topic = R::findOne("materials","id = ?",array($file->topic_id)); 
                                    // outputting the topic
                                    echo $topic->topic; ?>
                                </div>
                            </th>
                            <td>
                                <div class="text-center">
                                    <!-- outputting link to download the file -->
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
                    <div style="color: red; font-size:24px;" class="col-12 my-2 text-center">
                        <?php 
                            // showing errors one by one
                            echo array_shift($errors); 
                        ?>
                    </div>
                <?php
            } if(!empty($success)){ ?>
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
        </div>
        <div class="col-2"></div>
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