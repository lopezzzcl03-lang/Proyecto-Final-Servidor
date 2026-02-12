<?php
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';

$message = '';
$success = '';

if (isset($_GET['registered']) && $_GET['registered'] == '1') {
    $success = 'Registro correcto. Ahora puedes iniciar sesion.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isValidCsrfToken($_POST['csrf_token'] ?? null)) {
        $message = 'Solicitud invalida. Recarga la pagina e intentalo de nuevo.';
    } else {
        $usuario = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';
        if (loginUser($usuario, $password)) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
        $message = 'Usuario o contrasena incorrectos';
    }
}
