<?php
    // ConfiguraciÃ³n segura de sesiÃ³n (inclÃºyelo antes de cualquier salida)
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        ini_set('session.cookie_secure', 1);
    }
    // Ajuste SameSite (PHP < 7.3 workaround si hace falta)
    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params([
            'httponly' => true,
            'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
            'samesite' => 'Lax'
        ]);
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
