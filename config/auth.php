<?php
require_once __DIR__ . '/base.php';
require_once __DIR__ . '/bd.php';
require_once __DIR__ . '/session_counter.php';

/**
 * Intenta autenticar un usuario por nombre y contrasena.
 * Devuelve true si el login fue exitoso y crea variables de sesion.
 */
function loginUser(string $username, string $password): bool {
    global $pdo;
    $stmt = $pdo->prepare('SELECT id, nombre, password, rol FROM usuarios WHERE nombre = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_rol'] = $user['rol'] ?? 'usuario';

        try {
            $count = addSessionUser($user['nombre']);
            $_SESSION['login_count'] = $count;
            error_log("[SessionCounter] Usuario '{$user['nombre']}' inicio sesion. Conteo: {$count}");
        } catch (Throwable $e) {
            error_log('[SessionCounter] Error al actualizar contador: ' . $e->getMessage());
        }

        return true;
    }

    return false;
}

function logoutUser(): void {
    // borrar cookie "remember" si la hubiese (placeholder)
    if (isset($_COOKIE['remember'])) {
        setcookie('remember', '', time() - 3600, '/');
    }

    // destruir sesion
    $_SESSION = [];
    session_unset();
    session_destroy();
}

function isLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}

function getCurrentUser(): ?string {
    return $_SESSION['user_name'] ?? null;
}

function requireAuth(): void {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/view/login.php');
        exit;
    }
}

function isAdmin(): bool {
    return ($_SESSION['user_rol'] ?? null) === 'admin';
}

function requireAdmin(): void {
    if (!isLoggedIn() || !isAdmin()) {
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
}
