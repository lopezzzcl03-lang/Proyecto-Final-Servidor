<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/bd.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /FinalPhP/view/agregar_recetas.php');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$ingredientes = trim($_POST['ingredientes'] ?? '');
$instrucciones = trim($_POST['instrucciones'] ?? '');

$errors = [];
if ($nombre === '') $errors[] = 'El nombre es obligatorio.';
if ($ingredientes === '') $errors[] = 'Los ingredientes son obligatorios.';
if ($instrucciones === '') $errors[] = 'Las instrucciones son obligatorias.';

if (!empty($errors)) {
    $_SESSION['receta_errors'] = $errors;
    header('Location: /FinalPhP/view/agregar_recetas.php');
    exit;
}

try {
    // Manejo de imagen subida
    $imagenFilename = null;
    if (!empty($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $_FILES['imagen']['tmp_name'];
        $size = $_FILES['imagen']['size'];
        // Validaciones
        if ($size > 5 * 1024 * 1024) {
            throw new Exception('La imagen supera el tamaño máximo permitido (5MB).');
        }
        $imgInfo = getimagesize($tmpPath);
        if ($imgInfo === false) {
            throw new Exception('El archivo subido no es una imagen válida.');
        }
        $mime = $imgInfo['mime'];
        $ext = null;
        switch ($mime) {
            case 'image/jpeg': $ext = 'jpg'; break;
            case 'image/png': $ext = 'png'; break;
            case 'image/gif': $ext = 'gif'; break;
            default: throw new Exception('Formato de imagen no soportado.');
        }
        $imagenFilename = bin2hex(random_bytes(8)) . '.' . $ext;
        $destPath = __DIR__ . '/../public/img/' . $imagenFilename;
        if (!move_uploaded_file($tmpPath, $destPath)) {
            throw new Exception('Error al mover la imagen subida.');
        }
    }

    $id = insertReceta($nombre, $ingredientes, $instrucciones, $imagenFilename);
    $_SESSION['receta_success'] = 'Receta agregada correctamente.';
    header('Location: /FinalPhP/view/recetas.php?added=1');
    exit;
} catch (Exception $e) {
    $_SESSION['receta_errors'] = ['Error al guardar la receta: ' . $e->getMessage()];
    header('Location: /FinalPhP/view/agregar_recetas.php');
    exit;
}
