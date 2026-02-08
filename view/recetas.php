<link href="/FinalPhP/public/css/bootstrap.min.css" rel="stylesheet">

<?php require_once __DIR__ . '/plantillas/header.php'; ?>

<?php
    require_once __DIR__ . '/../config/session.php';
    require_once __DIR__ . '/../config/bd.php';

    // CONSULTA optimizada (NO trae el BLOB)
    $stmt = $pdo->query("SELECT id, nombre, ingredientes FROM recetas");
    $recetas = $stmt->fetchAll();
?>

<body>

<div class="container py-5">
  <h1 class="mb-5 text-center">Recetas</h1>

  <div class="row g-4">

    <?php foreach ($recetas as $receta): ?>

        <div class="col-md-4 col-sm-6">
        <div class="card h-100 shadow-sm">

          <!-- Imagen cargada desde la BD mediante imagen.php -->
          <img 
            src="/FinalPhP/public/imagen.php?id=<?= $receta['id'] ?>"
            alt="Imagen de <?= htmlspecialchars($receta['nombre']) ?>" 
            class="card-img-top" 
            style="height:180px; object-fit:cover;" 
            loading="lazy">

          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($receta['nombre']) ?></h5>
            <p class="card-text text-muted" style="min-height: 100px; overflow-y: auto;">
              <?= nl2br(htmlspecialchars(substr($receta['ingredientes'], 0, 150))) ?>...
            </p>
            <a href="ver.php?id=<?= $receta['id'] ?>" class="btn btn-primary btn-sm">
              Ver receta completa
            </a>
          </div>

        </div>
      </div>

    <?php endforeach; ?>

  </div>

  <!-- PAGINACIÓN -->
  <?php if ($totalPages > 1): ?>
  <nav aria-label="Paginación" class="mt-5">
    <ul class="pagination justify-content-center">
      <?php if ($page > 1): ?>
        <li class="page-item">
          <a class="page-link" href="?page=1">Primera</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="?page=<?= $page - 1 ?>">Anterior</a>
        </li>
      <?php endif; ?>

      <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <?php if ($page < $totalPages): ?>
        <li class="page-item">
          <a class="page-link" href="?page=<?= $page + 1 ?>">Siguiente</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="?page=<?= $totalPages ?>">Última</a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
  <?php endif; ?>

</div>

<script src="/FinalPhP/public/js/bootstrap.bundle.min.js"></script>
</body>

<?php require_once __DIR__ . '/plantillas/footer.php'; ?>




