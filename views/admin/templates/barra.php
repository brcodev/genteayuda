<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= SERVERURL ?>pagemanagephatuser" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-sm-inline-block info-d">
          <div class="nav-link" ><?= "Último acceso: " . date("d-m-Y H:i", strtotime($_SESSION['last_lg']))."hrs"; ?></div>
        </li>
      </ul>
     
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <form action="<?= SERVERURL ?>pagemanagephatuser/logout" id="admin-logout" method="post">
          <li class="breadcrumb-item active">
            <input type="hidden" name="csrf" value="<?= $_SESSION['token'] ?>">
            <input class="btn btn-block btn-info btn-flat" type="submit" value="Cerrar Sesión">
          </li>
        </form>
      </ul>
    </nav>
    <div class="nav-link info-d-mob" ><?= "Último acceso: " . date("d-m-Y H:i", strtotime($_SESSION['last_lg']))."hrs"; ?></div>