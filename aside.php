


<aside id="aside"class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo caminhoURL; ?>index.php" class="brand-link">
    <img src="<?php echo caminhoURL; ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Ordem de Servac</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo caminhoURL; ?>meu_perfil/fotos/<?php echo $_SESSION["foto"] ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?php echo caminhoURL; ?>meu_perfil/" class="d-block"><?php echo $_SESSION["nome_usuario"]; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item ">
          <a href="<?php echo caminhoURL; ?>index.php" class="nav-link <?php echo $pagina_ativa == 'home' ? 'active' : ''; ?>">
            <i class="nav-icon  bi-house-fill"></i>
            <p>
              Página inicial
            </p>
          </a>
        </li>
        <!-- item Ordem de serviço -->
        <li class="nav-item">
          <a href="<?php echo caminhoURL; ?>ordens/" class="nav-link <?php echo $pagina_ativa == 'ordens' ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-wrench-adjustable-circle-fill"></i>
            <p>
              Ordens de Serviço
              <span class="right badge badge-warning"><?php echo $dados->total_os; ?></span>
            </p>
          </a>
        </li>
        <li class="nav-header">CONFIGURAÇÕES</li>
        <li class="nav-item">
          <a href="<?php echo caminhoURL; ?>clientes" class="nav-link <?php echo $pagina_ativa == 'clientes' ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-person-circle"></i>
            <p>
              Clientes
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo caminhoURL; ?>servicos" class="nav-link <?php echo $pagina_ativa == 'servicos' ? 'active' : ''; ?>">
            <i class="nav-icon bi-gear-wide-connected"></i>
            <p>
              Serviços
            </p>
          </a>
        </li>   
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>