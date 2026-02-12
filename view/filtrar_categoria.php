<?php require __DIR__ . '/../controller/filtrar_categoria_page_controller.php'; ?>
<?php require_once __DIR__ . '/plantillas/header.php'; ?>

<div class="container py-5">
    <h1 class="mb-5 text-center">Recetas de <?= htmlspecialchars($categoria) ?></h1>

    <div class="row g-4">
        <?php foreach ($recetas as $receta): ?>
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($receta['nombre']) ?></h5>
                        <p class="card-text text-muted" style="min-height: 100px; overflow-y: auto;">
                            <?= nl2br(htmlspecialchars(substr($receta['ingredientes'], 0, 150))) ?>...
                        </p>
                        <p class="card-text text-muted"><strong>Categoria:</strong> <?= htmlspecialchars($receta['categoria']) ?></p>
                        <a href="ver.php?id=<?= $receta['id'] ?>" class="btn btn-dark btn-sm">Ver receta completa</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/plantillas/footer.php'; ?>

