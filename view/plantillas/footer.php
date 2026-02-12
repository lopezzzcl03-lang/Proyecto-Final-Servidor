<?php
require_once __DIR__ . '/../../config/base.php';
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../config/auth.php';
?>
<link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">

<footer class="bg-dark text-light pt-4 pb-3 mt-5">
  <div class="container">
    <div class="row">

      <!-- Columna 1 -->
      <div class="col-md-4 mb-3">
        <img src="<?= BASE_URL ?>/public/img/logo.png" alt="Logo" class="mb-2 img-fluid" style="max-width: 150px;">
        <p class="small">Tu web de recetas con ingredientes faciles y deliciosos.</p>
      </div>

      <!-- Columna 2 -->
      <div class="col-md-2 mb-3">
        <ul class="list-unstyled small">
          <li><a href="<?= BASE_URL ?>/index.php" class="text-light text-decoration-none">Inicio</a></li>
          <li><a href="<?= BASE_URL ?>/view/recetas.php" class="text-light text-decoration-none">Recetas</a></li>
          <?php if (isLoggedIn()): ?>
            <li><a href="<?= BASE_URL ?>/view/agregar_recetas.php" class="text-light text-decoration-none">Anadir Receta</a></li>
          <?php else: ?>
            <li><a href="<?= BASE_URL ?>/view/plantillas/login.php" class="text-light text-decoration-none">Anadir Receta</a></li>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Columna 3 -->
      <div class="col-md-3 mb-3">
        <ul class="list-unstyled small">
          <li>Email: recetalia@recetas.com</li>
          <li>Tel: +34 600 000 000</li>
        </ul>
      </div>

      <!-- Columna 4 -->
      <div class="col-md-3 mb-3">
        <h6 class="fw-bold">Siguenos</h6>
        <a href="#" class="text-light me-2"><i class="bi bi-facebook"></i></a>
        <a href="#" class="text-light me-2"><i class="bi bi-instagram"></i></a>
        <a href="#" class="text-light"><i class="bi bi-twitter"></i></a>
      </div>

    </div>

    <div class="text-center small mt-3 border-top pt-3">
      2026 Recealia. Todos los derechos reservados.
    </div>
  </div>
</footer>

<script src="<?= BASE_URL ?>/public/js/bootstrap.bundle.min.js"></script>
