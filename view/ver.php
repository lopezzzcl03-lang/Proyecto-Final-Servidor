<?php require __DIR__ . '/../controller/ver_page_controller.php'; ?>
<?php require_once __DIR__ . '/plantillas/header.php'; ?>
<link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <a href="<?= BASE_URL ?>/view/recetas.php" class="btn btn-secondary mb-4">Volver</a>

    <div class="card shadow">
        <img
            src="<?= BASE_URL ?>/public/imagen.php?id=<?= $receta['id'] ?>"
            alt="Imagen de <?= htmlspecialchars($receta['nombre']) ?>"
            class="card-img-top img-fluid"
            style="height:40vh; max-height:400px; object-fit:cover;">

        <div class="card-body p-5">
            <h1 class="card-title mb-4"><?= htmlspecialchars($receta['nombre']) ?></h1>

            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">Ingredientes</h4>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($receta['ingredientes'])) ?></p>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">Instrucciones</h4>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($receta['instrucciones'])) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/public/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/plantillas/footer.php'; ?>

