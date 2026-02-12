<?php
// Carga configuraciones y funciones compartidas una sola vez.
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/bd.php';

// Protege la ruta: solo acepta envios por metodo POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // header() envia una cabecera HTTP para redirigir al navegador.
    header('Location: ' . BASE_URL . '/index.php');
    // exit detiene la ejecucion para evitar que continue el script.
    exit;
}

// Valida el token CSRF para prevenir envios maliciosos.
if (!isValidCsrfToken($_POST['csrf_token'] ?? null)) {
    // $_SESSION guarda mensajes temporales entre peticiones.
    $_SESSION['suscribete_errors'] = ['Solicitud invalida. Recarga la pagina e intentalo de nuevo.'];
    header('Location: ' . BASE_URL . '/view/plantillas/suscribete.php');
    exit;
}

// trim() elimina espacios al inicio y final; ?? define valor por defecto.
$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['email'] ?? '');
// isset() comprueba si el checkbox "privacidad" fue enviado.
$privacidad = isset($_POST['privacidad']);

// Acumula errores de validacion para mostrarlos al usuario.
$errors = [];
if ($nombre === '') $errors[] = 'El nombre es obligatorio.';
if ($correo === '') $errors[] = 'El correo es obligatorio.';
if ($privacidad === false) $errors[] = 'Debes aceptar la política de privacidad.';

// !empty() verifica si hay errores antes de guardar en base de datos.
if (!empty($errors)) {
    $_SESSION['suscribete_errors'] = $errors;
    header('Location: ' . BASE_URL . '/view/plantillas/suscribete.php');
    exit;
}

// try/catch captura excepciones para manejar fallos sin romper la aplicacion.
try {
    // Inserta la suscripcion en base de datos.
    $id = insertSuscripcion($nombre, $correo, $privacidad);
    $_SESSION['suscribete_success'] = 'Suscripción realizada correctamente.';
    header('Location: ' . BASE_URL . '/index.php?added=1');
    exit;
} catch (Exception $e) {
    // getMessage() devuelve el detalle tecnico del error capturado.
    $_SESSION['suscribete_errors'] = ['Error al guardar la suscripción: ' . $e->getMessage()];
    header('Location: ' . BASE_URL . '/view/plantillas/suscribete.php');
    exit;
}
