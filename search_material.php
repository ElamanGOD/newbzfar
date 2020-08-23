<?php 
    // hiding the warnings
    //error_reporting(0);
    // connecting database
    require "utils/bd.php";
    $data = $_POST;
    $errors = array();
    if(isset($data['do_searchmat'])){
        if(empty(trim($data['search_text']))){
            $errors[] = "Введите запрос для поиска";
        }
        if(empty($errors)){
            $materials = R::find("materials","topic LIKE ?", array($data['search_text'] . "%" ));
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск материалов</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <?php if($_SESSION['user_info']){ ?>
    <div class="col-12 row my-5">
        <div class="col-4"></div>
        <div class="col-4 text-center">
            <h2>Поиск материалов</h2>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div class="form-group">
                    <label for="searchinput1">Введите название материала</label>
                    <input type="text" id="searchinput1" class="form-control" name="search_text">
                </div>
                <button type="submit" name="do_searchmat" class="btn btn-lg w-50 btn-primary">Поиск</button>
            </form>
            <?php 
                if($materials){ 
                    foreach($materials as $material){ ?>
                    <div class="my-4 border p-2">
                        <h3><?php echo $material->topic; ?></h3>
                        <?php 
                            $files = R::find("files","topic_id = ? AND moderated = ?",array($material->id , true));
                            if($files){
                                foreach($files as $file){
                            ?>
                                    <a href="/<?php echo $file->files; ?>" download><?php echo $file->files; ?></a><br>
                    <?php 
                                }
                            } else { ?>
                                <h5>Материалы по данной теме не были найдены</h5>
                            <?php } ?>
                        </div>    
                <?php    
                    } 
                }
                ?>
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