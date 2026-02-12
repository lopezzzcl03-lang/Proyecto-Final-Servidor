<?php require __DIR__ . '/../../controller/register_page_controller.php'; ?>
<link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">

<?php require_once __DIR__ . '/header.php'; ?>

<main class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="container" style="max-width: 450px;">
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $err): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($err) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="card shadow">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4">Registro</h4>
                <form action="<?= BASE_URL ?>/view/plantillas/register.php" method="POST">
                    <?= csrfField() ?>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Nombre de Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario (solo letras, min 3)" required value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contrasena:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Contrasena" required>
                        <small class="form-text text-muted">Min. 8 caracteres, mayusculas, minusculas, numeros y simbolo</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmar Contrasena:</label>
                        <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Repite la contrasena" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">Registrarme</button>
                    <p class="text-center small text-muted">Ya tienes cuenta? <a href="<?= BASE_URL ?>/view/plantillas/login.php">Inicia sesion</a></p>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="<?= BASE_URL ?>/public/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>

