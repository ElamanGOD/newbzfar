<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="/index.php">
          <h1>BZFAR</h1>
        </a>
      </div>
      <div class="navbar-inner">
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/upload.php"){ echo "active"; } ?>" href="/upload.php">
                <i class="ni ni-cloud-upload-96 text-primary"></i>
                  <span class="nav-link-text">Загрузить материал</span>
              </a>
            </li>
            <?php if($_SESSION['user_info']->moderator){ ?>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/moderate_material.php"){ echo "active"; } ?>" href="/moderate_material.php">
                <i class="ni ni-check-bold text-primary"></i>
                  <span class="nav-link-text">Модерация материала</span>
              </a>
            </li>
            <?php } ?>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/search_material.php"){ echo "active"; } ?>" href="/search_material.php">
                <i class="fas fa-search text-primary"></i>
                  <span class="nav-link-text">Поиск материалов</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/messages.php"){ echo "active"; } ?>" href="/messages.php">
                <i class="ni ni-send text-primary"></i>
                  <span class="nav-link-text">Сообщения</span>
              </a>
            </li>
            <?php if($_SESSION['user_info']->moderator){ ?>
            <li class="nav-item">
              <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/admin.php"){ echo "active"; } ?>" href="/admin.php">
                <i class="fas fa-plus text-primary"></i>
                  <span class="nav-link-text">Управление модераторами</span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <div class="main-content" id="panel">
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold"><?php echo $_SESSION['user_info']->surname . " " . $_SESSION['user_info']->firstname; ?></span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right">
                <a href="/logout.php" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Выйти</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>