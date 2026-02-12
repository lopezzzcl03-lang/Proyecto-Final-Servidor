<?php
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';

if (!isLoggedIn()) {
    $_SESSION['receta_errors'] = ['Debes iniciar sesion o registrarte para compartir recetas.'];
    header('Location: ' . BASE_URL . '/view/plantillas/login.php');
    exit;
}

$errors = $_SESSION['receta_errors'] ?? null;
$success = $_SESSION['receta_success'] ?? null;
unset($_SESSION['receta_errors'], $_SESSION['receta_success']);
