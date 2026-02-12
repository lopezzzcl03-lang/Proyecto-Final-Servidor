<?php
// Vista PHP: renderiza HTML usando variables del controlador.
require __DIR__ . '/../controller/agregar_recetas_page_controller.php'; ?>
<link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">

<?php require_once __DIR__ . '/plantillas/header.php'; ?>

<main class="py-5">
    <div class="container" style="max-width: 700px;">
        <h2 class="mb-4 text-center">Agregar Nueva Receta</h2>
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $err): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($err) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="card shadow">
            <div class="card-body p-4">
                <form action="<?= BASE_URL ?>/controller/agregar_receta_controller.php" method="POST" enctype="multipart/form-data">
                    <?= csrfField() ?>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Receta:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la receta" required>
                    </div>

                    <div class="mb-3">
                        <label for="ingredientes" class="form-label">Ingredientes:</label>
                        <textarea class="form-control" id="ingredientes" name="ingredientes" rows="4" placeholder="Lista de ingredientes (uno por linea)" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="instrucciones" class="form-label">Instrucciones:</label>
                        <textarea class="form-control" id="instrucciones" name="instrucciones" rows="5" placeholder="Pasos para preparar la receta" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoria:</label>
                        <select class="form-select" id="categoria" name="categoria" required>
                            <option value="">Selecciona una categoria</option>
                            <option value="Desayuno">Desayuno</option>
                            <option value="Comida">Comida</option>
                            <option value="Cena">Cena</option>
                            <option value="Postre">Postres</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen de la Receta:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/jpeg,image/png,image/gif,image/webp">
                        <small class="form-text text-muted">Formatos aceptados: JPG, PNG, GIF, WEBP (maximo 5MB)</small>
                    </div>

                    <button type="submit" class="btn btn-dark w-100">Agregar Receta</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="<?= BASE_URL ?>/public/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/plantillas/footer.php'; ?>

