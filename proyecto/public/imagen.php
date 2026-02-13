<?php
require_once __DIR__ . '/../config/bd.php';

// Validar ID
if (!isset($_GET['id'])) {
    http_response_code(400);
    die('ID no proporcionado.');
}

$id = intval($_GET['id']);

// Consulta preparada para obtener la imagen
$stmt = $pdo->prepare('SELECT imagen, mime FROM recetas WHERE id = ?');
$stmt->execute([$id]);
$result = $stmt->fetch();

if (!$result || empty($result['imagen'])) {
    http_response_code(404);
    die('Imagen no encontrada.');
}

$imageData = $result['imagen'];
$mimeType = $result['mime'] ?? null;

if (empty($mimeType)) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_buffer($finfo, $imageData);
    finfo_close($finfo);
}

header('Content-Type: ' . $mimeType);
header('Content-Length: ' . strlen($imageData));
header('Cache-Control: public, max-age=3600');

echo $imageData;
exit;
?>
