<?php
    require_once __DIR__ . '/../../config/session.php';
    require_once __DIR__ . '/../../config/auth.php';
?>
<link href="/FinalPhP/public/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand ms-3" href="/FinalPhP/index.php"><img src="/FinalPhP/public/img/logo.png" alt="logo" height="60"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Centro: Recetas, Añadir recetas y Buscador -->
      <div class="mx-auto d-flex align-items-center gap-3">
        <ul class="navbar-nav mb-0">
          <li class="nav-item">
            <a class="nav-link" href="/FinalPhP/view/recetas.php">Recetas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/FinalPhP/view/agregar_recetas.php">Añadir recetas</a>
          </li>
        </ul>
        
        <form class="d-flex align-items-center" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
          <button class="btn btn-outline-light" type="submit"><i class="bi bi-search fs-6"></i></button>
        </form>
      </div>

      <!-- Derecha: Botones de usuario -->
      <div class="d-flex align-items-center gap-2 me-2">
        <a href="/FinalPhP/view/plantillas/suscribete.php" class="btn btn-outline-warning btn-sm">Suscribirse</a>
        <?php if (isLoggedIn()): ?>
            <?php if (isAdmin()): ?>
                <a href="/FinalPhP/view/plantillas/admin.php" class="btn btn-danger btn-sm">Admin</a>
            <?php endif; ?>
            <a href="/FinalPhP/view/plantillas/logout.php" class="btn btn-outline-secondary btn-sm">Cerrar sesión</a>
        <?php else: ?>
            <a href="/FinalPhP/view/plantillas/register.php" class="btn btn-outline-primary btn-sm">Registrarse</a>
            <a href="/FinalPhP/view/plantillas/login.php" class="btn btn-outline-success btn-sm">Iniciar sesión</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>