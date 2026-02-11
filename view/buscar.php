<?php require_once __DIR__ . '/../config/base.php'; ?>
<?php
require_once __DIR__ . '/../config/bd.php';

$busqueda = $_GET['q'] ?? '';
$resultados = [];

if (!empty($busqueda)) {
    $sql = "SELECT * FROM recetas
            WHERE nombre LIKE :busqueda
            OR ingredientes LIKE :busqueda";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':busqueda' => '%' . $busqueda . '%'
    ]);

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">
<?php require_once __DIR__ . '/plantillas/header.php'; ?>

<div class="container-fluid py-5">
    <?php if (!empty($busqueda)): ?>
        <h4 class="mt-4">Resultados para: <strong><?= htmlspecialchars($busqueda) ?></strong></h4>

        <?php if (empty($resultados)): ?>
            <p>No se encontraron recetas.</p>
        <?php else: ?>
            <ul class="list-group mt-3">
                <?php foreach ($resultados as $receta): ?>
                    <li class="list-group-item">
                        <h5><?= htmlspecialchars($receta['nombre']) ?></h5>
                        <p><?= htmlspecialchars($receta['ingredientes']) ?></p>
                        <p><strong>Categoría:</strong> <?= htmlspecialchars($receta['categoria']) ?></p>
                        <div class="mb-3">
                            <a href="<?= BASE_URL ?>/view/ver.php?id=<?= $receta['id'] ?>" class="btn btn-outline-dark btn-sm">Ver receta</a>
                        </div>
                    </li>

                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="<?= BASE_URL ?>/public/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/plantillas/footer.php'; ?>
