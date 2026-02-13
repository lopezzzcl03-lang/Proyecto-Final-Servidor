<?php
// Dependencias de URL base, sesion y funciones de autenticacion.
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';

// Cierra la sesion/autenticacion del usuario actual.
logoutUser();
// Redirige al inicio y detiene ejecucion.
header('Location: ' . BASE_URL . '/index.php');
exit;
