<?php
// Carga configuracion base y conexion a base de datos ($pdo).
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/bd.php';

// Verifica que llegue el parametro id por URL (query string).
if (!isset($_GET['id'])) {
    // HTTP 400: peticion invalida por falta de datos.
    http_response_code(400);
    exit('No se proporciono un ID valido.');
}

// (int) convierte a entero para evitar valores no numericos.
$id = (int)$_GET['id'];
// Consulta preparada: evita inyeccion SQL usando placeholders (?).
$stmt = $pdo->prepare('SELECT * FROM recetas WHERE id = ?');
// execute() enlaza valores y ejecuta la consulta.
$stmt->execute([$id]);
// fetch() obtiene una fila de resultado (o false si no existe).
$receta = $stmt->fetch();

if (!$receta) {
    // HTTP 404: el recurso solicitado no fue encontrado.
    http_response_code(404);
    exit('La receta no existe.');
}
