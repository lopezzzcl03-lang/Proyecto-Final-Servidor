<?php require __DIR__ . '/../../controller/suscribete_page_controller.php'; ?>
<link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">

<?php require_once __DIR__ . '/header.php'; ?>

<main class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="container" style="max-width: 500px;">
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
                <h4 class="card-title text-center mb-4">Suscribete para recibir nuestras novedades</h4>
                <form action="<?= BASE_URL ?>/controller/suscripcion_controller.php" method="POST">
                    <?= csrfField() ?>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electronico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="privacidad" id="privacidad" required>
                        <label class="form-check-label" for="privacidad">
                            Acepto la politica de privacidad
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Suscribirse</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="<?= BASE_URL ?>/public/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>

