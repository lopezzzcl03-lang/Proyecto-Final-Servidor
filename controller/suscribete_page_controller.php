<?php
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';

$errors = $_SESSION['suscribete_errors'] ?? null;
$success = $_SESSION['suscribete_success'] ?? null;
unset($_SESSION['suscribete_errors'], $_SESSION['suscribete_success']);
