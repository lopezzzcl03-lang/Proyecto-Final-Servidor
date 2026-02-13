<?php
// Carga configuracion global, sesion y utilidades de autenticacion.
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';

// Variables para mostrar mensajes en la vista.
$message = '';
$success = '';

// Si viene ?registered=1 por URL, muestra confirmacion de registro.
if (isset($_GET['registered']) && $_GET['registered'] == '1') {
    $success = 'Registro correcto. Ahora puedes iniciar sesion.';
}

// Solo procesa login cuando el formulario llega por POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valida token CSRF para prevenir envios no autorizados.
    if (!isValidCsrfToken($_POST['csrf_token'] ?? null)) {
        $message = 'Solicitud invalida. Recarga la pagina e intentalo de nuevo.';
    } else {
        // trim() limpia espacios en usuario; password se recibe tal cual.
        $usuario = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';
        // loginUser() devuelve true si credenciales son validas.
        if (loginUser($usuario, $password)) {
            // Redireccion post-login.
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
        // Mensaje generico para no revelar que dato fallo.
        $message = 'Usuario o contrasena incorrectos';
    }
}
