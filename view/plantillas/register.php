<?php require_once __DIR__ . '/../../config/base.php'; ?>
<?php
require_once __DIR__ . '/../../config/session.php';
require_once __DIR__ . '/../../config/auth.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Validación: nombre >=3 letras (solo letras)
    if (!preg_match('/^[A-Za-z]{3,}$/', $usuario)) {
        $errors[] = 'El nombre debe tener al menos 3 letras y solo contener letras (A-Z).';
    }

    // Contraseña: min 8, mayúscula, minúscula, número y símbolo
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/', $password)) {
        $errors[] = 'La contraseña debe tener al menos 8 caracteres y contener mayúsculas, minúsculas, números y un símbolo.';
    }

    if ($password !== $password_confirm) {
        $errors[] = 'Las contraseñas no coinciden.';
    }

    if (empty($errors)) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE nombre = ?');
        $stmt->execute([$usuario]);
        if ($stmt->fetch()) {
            $errors[] = 'El nombre de usuario ya existe, elige otro.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO usuarios (nombre, password) VALUES (?, ?)');
            $insert->execute([$usuario, $hash]);
            header('Location: ' . BASE_URL . '/view/plantillas/login.php?registered=1');
            exit;
        }
    }
}
?>
<link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">

<?php require_once __DIR__ . '/header.php'; ?>

<main class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="container" style="max-width: 450px;">
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $err): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?=htmlspecialchars($err)?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="card shadow">
            <div class="card-body p-4">
                <h4 class="card-title text-center mb-4">Registro</h4>
                <form action="<?= BASE_URL ?>/view/plantillas/register.php" method="POST">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Nombre de Usuario:</label>
                        <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario (solo letras, min 3)" required value="<?=htmlspecialchars($_POST['usuario'] ?? '')?>">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                        <small class="form-text text-muted">Mín. 8 caracteres, mayúsculas, minúsculas, números y símbolo</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmar Contraseña:</label>
                        <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Repite la contraseña" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">Registrarme</button>
                    <p class="text-center small text-muted">¿Ya tienes cuenta? <a href="<?= BASE_URL ?>/view/plantillas/login.php">Inicia sesión</a></p>
                </form>
            </div>
        </div>
    </div>
</main>

<script src="<?= BASE_URL ?>/public/js/bootstrap.bundle.min.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>


