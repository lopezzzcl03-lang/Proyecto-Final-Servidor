<?php
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/bd.php';

if (!isLoggedIn()) {
    $_SESSION['receta_errors'] = ['Debes iniciar sesion o registrarte para compartir una receta.'];
    header('Location: ' . BASE_URL . '/view/plantillas/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/view/agregar_recetas.php');
    exit;
}

if (!isValidCsrfToken($_POST['csrf_token'] ?? null)) {
    $_SESSION['receta_errors'] = ['Solicitud invalida. Recarga la pagina e intentalo de nuevo.'];
    header('Location: ' . BASE_URL . '/view/agregar_recetas.php');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$ingredientes = trim($_POST['ingredientes'] ?? '');
$instrucciones = trim($_POST['instrucciones'] ?? '');
$categoria = trim($_POST['categoria'] ?? '');

$errors = [];
if ($nombre === '') $errors[] = 'El nombre es obligatorio.';
if ($ingredientes === '') $errors[] = 'Los ingredientes son obligatorios.';
if ($instrucciones === '') $errors[] = 'Las instrucciones son obligatorias.';
if ($categoria === '') $errors[] = 'La categoria es obligatoria.';

if (!empty($errors)) {
    $_SESSION['receta_errors'] = $errors;
    header('Location: ' . BASE_URL . '/view/agregar_recetas.php');
    exit;
}

try {
    // Manejo de imagen subida (guardar en BD como BLOB)
    $imagenBlob = null;
    $mime = null;
    if (!empty($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tmpPath = $_FILES['imagen']['tmp_name'];
        $size = $_FILES['imagen']['size'];
        // Validaciones
        if ($size > 5 * 1024 * 1024) {
            throw new Exception('La imagen supera el tamano maximo permitido (5MB).');
        }
        $imgInfo = getimagesize($tmpPath);
        if ($imgInfo === false) {
            throw new Exception('El archivo subido no es una imagen valida.');
        }
        $mime = $imgInfo['mime'];
        switch ($mime) {
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
            case 'image/webp':
                break;
            default:
                throw new Exception('Formato de imagen no soportado.');
        }
        $imagenBlob = file_get_contents($tmpPath);
        if ($imagenBlob === false) {
            throw new Exception('No se pudo leer la imagen subida.');
        }
    }

    $id = insertReceta($nombre, $ingredientes, $instrucciones, $categoria, $imagenBlob, $mime);
    $_SESSION['receta_success'] = 'Receta agregada correctamente.';
    header('Location: ' . BASE_URL . '/view/recetas.php?added=1');
    exit;
} catch (Exception $e) {
    $_SESSION['receta_errors'] = ['Error al guardar la receta: ' . $e->getMessage()];
    header('Location: ' . BASE_URL . '/view/agregar_recetas.php');
    exit;
}
