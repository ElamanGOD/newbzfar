<?php require "head.php"; ?>
<body>
  <?php if($_SESSION['user_info']){ ?>
    <?php require "nav.php"; ?>
    <div class="container-fluid mt-4">
    
      <?php require "footer.php"; ?>
    </div>
  </div>
  <?php } else { ?>
      <?php require "not_logged.php"; ?>
  <?php } ?>
  <!-- Argon Scripts -->
  <!-- Core -->
  <?php require "scripts.php"; ?>
</body>

</html>