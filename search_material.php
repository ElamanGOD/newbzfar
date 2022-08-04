<?php 
    // hiding the warnings
    //error_reporting(0);
    // connecting database
    require "utils/bd.php";
    // declaring variables
    $data = $_GET;
    $errors = array();
    $data_post = $_POST;
    // check if user is trying to delete the material
    if(isset($data_post['delete_file'])){
        // fiding the file in table
        $file = R::findOne("files","id = ?",array($data_post['file_id']));
        // checking if the material is found in table
        if($file){
            // deleting the material
            unlink($file->files);
            // deleting the record in table
            R::trash($file);
        }
    }
    // check if user searched for materials
    if(isset($data['do_searchmat'])){
        // checking if input is empty
        if(empty(trim($data['search_text']))){
            $errors[] = "Введите запрос для поиска";
        }
        // checking if there is no errors
        if(empty($errors)){
            //$materials = R::find("materials","topic LIKE ?", array($data['search_text'] . "%" ));
            // variable to contain search text
            $search_text = $data['search_text'];
            // query from 2 tables
            $materials = R::getAll("SELECT materials.topic, files.files, files.id FROM materials, files WHERE files.topic_id = materials.id AND files.moderated = 1 AND materials.topic LIKE '" . $search_text . "%';");
        }
    }
?>
<?php require "head.php"; ?>
<body>
  <?php if($_SESSION['user_info']){ ?>
  <?php require "nav.php"; ?>
    <div class="container-fluid mt-4">
        <div class="col-12 row my-5">
            <div class="col-4"></div>
            <div class="col-4 text-center">
                <h1>Поиск материалов</h1>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="get">
                    <div class="form-group">
                        <input type="text" id="searchinput1" class="form-control" name="search_text">
                    </div>
                    <button type="submit" name="do_searchmat" class="btn btn-lg w-50 btn-primary">Поиск</button>
                </form>
                <?php 
                    // check if materials are found
                    if($materials){ 
                        // loop to output materials one-by-one
                        foreach($materials as $material){ ?>
                        <div class="my-4 border p-2">
                            <?php // outputting materials ?>
                            <h3><?php echo $material['topic']; ?></h3>
                            <a href="/<?php echo $material['files']; ?>" download><?php echo $material['files']; ?></a><br>
                            <?php 
                                // check if user is moderator
                                if($_SESSION['user_info']->moderator){ 
                                    // outputting the form to delete a material
                            ?>
                              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" name="file_id" value="<?php echo $material['id']; ?>">
                                <button type="submit" name="delete_file" class="btn btn-sm btn-danger my-2">Удалить</button>
                              </form>
                            <?php 
                                } 
                            ?>
                        </div>    
                    <?php    
                        } 
                    } 
                    // output if materials are not found
                    else { ?>
                        <div class="my-4 border p-2">
                            <h3>Тема не была найдена</h3>
                        </div>  
                    <?php 
                    }
                    ?>
                    <?php 
                    // check if error messages are found
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
            </div>
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