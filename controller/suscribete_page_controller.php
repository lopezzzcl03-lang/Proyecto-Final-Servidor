<?php
// Incluye constantes globales (BASE_URL) y manejo de sesion.
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';

// Operador ?? : si no existe la clave en sesion, usa null.
$errors = $_SESSION['suscribete_errors'] ?? null;
$success = $_SESSION['suscribete_success'] ?? null;
// unset() limpia mensajes flash para que no se repitan en la siguiente carga.
unset($_SESSION['suscribete_errors'], $_SESSION['suscribete_success']);
