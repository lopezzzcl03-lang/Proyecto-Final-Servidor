<?php
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/bd.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit('No se proporciono un ID valido.');
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM recetas WHERE id = ?');
$stmt->execute([$id]);
$receta = $stmt->fetch();

if (!$receta) {
    http_response_code(404);
    exit('La receta no existe.');
}
