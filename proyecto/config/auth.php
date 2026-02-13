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
        $isHttps =
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_rol'] = $user['rol'] ?? 'usuario';

        // Cookie visible en DevTools para identificar usuario autenticado.
        if (PHP_VERSION_ID >= 70300) {
            setcookie('user_name', $user['nombre'], [
                'expires' => 0,
                'path' => '/',
                'secure' => $isHttps,
                'httponly' => false,
                'samesite' => 'Lax'
            ]);
        } else {
            setcookie('user_name', $user['nombre'], 0, '/', '', $isHttps, false);
        }

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
    $isHttps =
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    // Borrar cookie "remember" si existe.
    if (isset($_COOKIE['remember'])) {
        setcookie('remember', '', time() - 3600, '/', '', $isHttps, true);
    }

    // Borrar cookie con nombre de usuario.
    if (PHP_VERSION_ID >= 70300) {
        setcookie('user_name', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => $isHttps,
            'httponly' => false,
            'samesite' => 'Lax'
        ]);
    } else {
        setcookie('user_name', '', time() - 3600, '/', '', $isHttps, false);
    }

    // Limpiar y destruir sesion.
    $_SESSION = [];
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
    }

    // Borrar cookie de sesion (PHPSESSID).
    $params = session_get_cookie_params();
    if (PHP_VERSION_ID >= 70300) {
        setcookie(session_name(), '', [
            'expires' => time() - 3600,
            'path' => $params['path'] ?: '/',
            'domain' => $params['domain'] ?? '',
            'secure' => (bool)($params['secure'] ?? $isHttps),
            'httponly' => (bool)($params['httponly'] ?? true),
            'samesite' => $params['samesite'] ?? 'Lax'
        ]);
    } else {
        setcookie(
            session_name(),
            '',
            time() - 3600,
            $params['path'] ?: '/',
            $params['domain'] ?? '',
            (bool)($params['secure'] ?? $isHttps),
            (bool)($params['httponly'] ?? true)
        );
    }
}

function isLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}

function getCurrentUser(): ?string {
    return $_SESSION['user_name'] ?? null;
}

function requireAuth(): void {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . '/view/plantillas/login.php');
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
