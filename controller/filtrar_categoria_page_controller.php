<?php
// Controlador: procesa la peticion y prepara datos para la vista.
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/bd.php';

$categoria = $_GET['categoria'] ?? null;
if (!$categoria) {
    http_response_code(400);
    exit('Categoria no especificada.');
}

$stmt = $pdo->prepare('SELECT id, nombre, ingredientes, categoria FROM recetas WHERE categoria = ?');
$stmt->execute([$categoria]);
$recetas = $stmt->fetchAll();
