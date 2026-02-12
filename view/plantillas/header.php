<?php
    require_once __DIR__ . '/../../config/base.php';
    require_once __DIR__ . '/../../config/session.php';
    require_once __DIR__ . '/../../config/auth.php';
?>
<link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/public/css/custom.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand ms-3" href="<?= BASE_URL ?>/index.php"><img src="<?= BASE_URL ?>/public/img/logo.png" alt="logo" class="img-fluid" style="max-height:60px;"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Centro: Recetas, Anadir recetas y Buscador -->
      <div class="d-flex flex-column flex-md-row align-items-start align-md-center gap-3 ms-auto justify-content-md-center">
        <ul class="navbar-nav mb-0">
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>/index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>/view/recetas.php">Recetas</a>
          </li>
          <li class="nav-item">
            <?php if (isLoggedIn()): ?>
              <a class="nav-link" href="<?= BASE_URL ?>/view/agregar_recetas.php">Anadir recetas</a>
            <?php else: ?>
              <a class="nav-link" href="<?= BASE_URL ?>/view/plantillas/login.php">Anadir recetas</a>
            <?php endif; ?>
          </li>
        </ul>
        
        <form class="d-none d-md-flex align-items-center" role="search" method="GET" action="<?= BASE_URL ?>/view/buscar.php">
          <input class="form-control me-2" 
           type="search" 
           name="q" 
           placeholder="Buscar"
           aria-label="Search">

            <button class="btn btn-outline-light" type="submit">
                <i class="bi bi-search fs-6"></i>
            </button>
        </form>

      </div>

      <!-- Derecha: Botones de usuario -->
      <div class="d-flex flex-column flex-md-row align-items-stretch align-md-center gap-2 ms-auto">
        <a href="<?= BASE_URL ?>/view/plantillas/suscribete.php" class="btn btn-outline-warning btn-sm">Suscribirse</a>
        <?php if (isLoggedIn()): ?>
            <?php if (isAdmin()): ?>
                <a href="<?= BASE_URL ?>/view/plantillas/admin.php" class="btn btn-danger btn-sm">Admin</a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/view/plantillas/logout.php" class="btn btn-outline-secondary btn-sm">Cerrar sesion</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/view/plantillas/register.php" class="btn btn-outline-primary btn-sm">Registrarse</a>
            <a href="<?= BASE_URL ?>/view/plantillas/login.php" class="btn btn-outline-success btn-sm">Iniciar sesion</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<?php
