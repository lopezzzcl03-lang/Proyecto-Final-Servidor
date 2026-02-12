<?php require __DIR__ . '/../../controller/login_page_controller.php'; ?>
<link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">

<?php require_once __DIR__ . '/header.php'; ?>

<main class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="container" style="max-width: 400px;">
        <?php if (!empty($message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="card shadow">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4">Iniciar Sesion</h4>
                <form action="" method="POST">
                    <?= csrfField() ?>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Nombre de Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contrasena:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Contrasena" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">Entrar</button>
                    <p class="text-center small text-muted">No tienes cuenta? <a href="<?= BASE_URL ?>/view/plantillas/register.php">Registrate</a></p>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="<?= BASE_URL ?>/public/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>

