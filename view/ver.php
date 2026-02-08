<?php
require_once __DIR__ . '/../config/bd.php';
require_once __DIR__ . '/plantillas/header.php';

// VALIDAR ID
if (!isset($_GET['id'])) {
    die("No se proporcionó un ID válido.");
}

$id = intval($_GET['id']);

// CONSULTA PREPARADA (seguridad)
$stmt = $pdo->prepare("SELECT * FROM recetas WHERE id = ?");
$stmt->execute([$id]);
$receta = $stmt->fetch();

if (!$receta) {
    die("La receta no existe.");
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($receta['nombre']) ?></title>
    <link href="/FinalPhP/public/css/bootstrap.min.css" rel="stylesheet">
</head>


<div class="container py-5">
    <a href="/FinalPhP/view/recetas.php" class="btn btn-secondary mb-4">← Volver</a>

    <div class="card shadow">
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

<script src="/FinalPhP/public/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/plantillas/footer.php'; ?>
