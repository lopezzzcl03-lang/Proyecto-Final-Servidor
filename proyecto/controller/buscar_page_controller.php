<?php
// Controlador: procesa la peticion y prepara datos para la vista.
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/bd.php';

$busqueda = $_GET['q'] ?? '';
$resultados = [];

if ($busqueda !== '') {
    $sql = 'SELECT * FROM recetas WHERE nombre LIKE :busqueda OR ingredientes LIKE :busqueda';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':busqueda' => '%' . $busqueda . '%']);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
