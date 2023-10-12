<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= SERVERURL ?>pagemanagephatuser" class="brand-link" style="text-align: center;">
    <span class="brand-text">GENTEAYUDA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= SERVERURL ?>build/f218f5ae3a799f68a2d79985e3c508ac/<?= $_SESSION["image"] ?? "f3d5e998d1f66b1fbf0e81550dffaf04.png" ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <?php ?>
        <a href="<?= SERVERURL ?>pagemanagephatuser/profile" class="d-block"><?= $_SESSION['nombre']; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-header">PANEL DE ADMINISTRACIÓN</li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-calendar"></i>
            <p>
              Eventos Sociales
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right"></span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/event-list" class="nav-link">
                <i class="fa fa-list-ul nav-icon"></i>
                <p>Ver Todos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/create-event" class="nav-link">
                <i class="fa fa-plus-circle nav-icon"></i>
                <p>Agregar</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa-solid fa-heart"></i>
            <p>
              Organizaciones
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/orglist" class="nav-link">
                <i class="fa fa-list-ul nav-icon"></i>
                <p>Ver publicadas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/registeredorg" class="nav-link">
                <i class="fa-solid fa-check nav-icon"></i>
                <p>Ver inscritas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/createorg" class="nav-link">
                <i class="fa fa-plus-circle nav-icon"></i>
                <p>Publicar</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-hands-helping"></i>
            <p>
              Solicitudes de ayuda
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/requestlist" class="nav-link">
                <i class="fa fa-list-ul nav-icon"></i>
                <p>Ver Todos</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fa fa-info-circle nav-icon"></i>

            <p>
              Status ORG
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/orgrequestlist" class="nav-link">
                <i class="fa fa-list-ul nav-icon"></i>
                <p>Ver Todos</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
          <i class="fa-solid fa-magnifying-glass nav-icon"></i>
            <p>
              Sugerencias y reclamos
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right"></span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/suggestion" class="nav-link">
              <i class="fa-solid fa-lightbulb nav-icon"></i>
                <p>Sugerencias</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/claim" class="nav-link">
              <i class="fa-solid fa-exclamation nav-icon"></i>
                <p>Reclamos</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-address-card"></i>
            <p>
              Tu Perfil
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right"></span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/profile" class="nav-link">
                <i class="fas fa-user-edit nav-icon"></i>
                <p>Cambiar datos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= SERVERURL ?>pagemanagephatuser/change" class="nav-link">
                <i class="fas fa-lock nav-icon"></i>
                <p>Cambiar contraseña</p>
              </a>
            </li>
          </ul>
        </li>
        <?php if ($_SESSION['nivel'] == 2) : ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Administradores
                <i class="right fas fa-angle-left"></i>
                <span class="right badge badge-danger"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= SERVERURL ?>pagemanagephatuser/adminlist" class="nav-link">
                  <i class="fa fa-list-ul nav-icon"></i>
                  <p>Ver Todos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= SERVERURL ?>pagemanagephatuser/createadmin" class="nav-link">
                  <i class="fa fa-plus-circle nav-icon"></i>
                  <p>Agregar</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>


      </ul>
      </li>

    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>