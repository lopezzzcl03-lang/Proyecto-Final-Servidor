<?php
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/bd.php';

$stmt = $pdo->query('SELECT id, nombre, ingredientes, categoria FROM recetas');
$recetas = $stmt->fetchAll();
