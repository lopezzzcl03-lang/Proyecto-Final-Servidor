<?php
require_once __DIR__ . '/../config/bd.php';

$id = $_GET['id'] ?? null;
if (!$id) { http_response_code(400); exit('ID no proporcionado'); }

$stmt = $pdo->prepare("SELECT imagen, mime FROM recetas WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data || !$data['imagen']) {
    header("Content-Type: image/jpeg");
    readfile(__DIR__ . "/img/default.jpg");
    exit;
}

// Detectar tipo automáticamente si MIME es incorrecto
$mime = $data['mime'];
if ($mime === 'img' || !$mime) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->buffer($data['imagen']);
}

header("Content-Type: " . $mime);
echo $data['imagen'];
?>