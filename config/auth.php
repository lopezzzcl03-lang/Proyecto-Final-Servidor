<?php
require_once __DIR__ . '/bd.php';

/**
 * Intenta autenticar un usuario por nombre y contraseña.
 * Devuelve true si el login fue exitoso y crea variables de sesión.
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
        return true;
    }
    return false;
}

function logoutUser(): void {
    // borrar cookie "remember" si la hubiese (placeholder)
    if (isset($_COOKIE['remember'])) {
        setcookie('remember', '', time() - 3600, '/');
    }

    // destruir sesión
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
        header('Location: /FinalPhP/view/login.php');
        exit;
    }
}

function isAdmin(): bool {
    return ($_SESSION['user_rol'] ?? null) === 'admin';
}

function requireAdmin(): void {
    if (!isLoggedIn() || !isAdmin()) {
        header('Location: /FinalPhP/index.php');
        exit;
    }
}
