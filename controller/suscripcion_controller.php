<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/bd.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /FinalPhP/view/suscribete.php');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['email'] ?? '');
$privacidad = isset($_POST['privacidad']);

$errors = [];
if ($nombre === '') $errors[] = 'El nombre es obligatorio.';
if ($correo === '') $errors[] = 'El correo es obligatorio.';
if ($privacidad === false) $errors[] = 'Debes aceptar la política de privacidad.';

if (!empty($errors)) {
    $_SESSION['suscribete_errors'] = $errors;
    header('Location: /FinalPhP/view/suscribete.php');
    exit;
}

try {
    $id = insertSuscripcion($nombre, $correo, $privacidad);
    $_SESSION['suscribete_success'] = 'Suscripción realizada correctamente.';
    header('Location: /FinalPhP/view/suscribete.php?added=1');
    exit;
} catch (Exception $e) {
    $_SESSION['suscribete_errors'] = ['Error al guardar la suscripción: ' . $e->getMessage()];
    header('Location: /FinalPhP/view/suscribete.php');
    exit;
}