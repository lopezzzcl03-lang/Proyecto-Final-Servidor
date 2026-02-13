<?php
// Controlador: procesa la peticion y prepara datos para la vista.
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/bd.php';

requireAdmin();

$action = $_POST['action'] ?? '';
$message = '';

// Valida el token CSRF para prevenir envios maliciosos.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isValidCsrfToken($_POST['csrf_token'] ?? null)) {
    $message = 'Token CSRF invalido. Recarga la pagina e intentalo de nuevo.';
    $action = '';
}

// Eliminar usuario por id, que es el identificador unico en esta tabla.
if ($action === 'delete_user') {
    $userId = $_POST['id'] ?? '';
    $pdo->prepare('DELETE FROM usuarios WHERE id = ?')->execute([$userId]);
    $message = 'Usuario eliminado';
}

// Eliminar receta por id, que es el identificador unico en esta tabla.
if ($action === 'delete_receta') {
    $recetaId = $_POST['id'] ?? '';
    $pdo->prepare('DELETE FROM recetas WHERE id = ?')->execute([$recetaId]);
    $message = 'Receta eliminada';
}

// Eliminar suscripcion por correo, que es el identificador unico en esta tabla.
if ($action === 'delete_suscripcion') {
    $correo = $_POST['correo'] ?? '';
    $pdo->prepare('DELETE FROM suscripciones WHERE correo = ?')->execute([$correo]);
    $message = 'Suscriptor eliminado';
}

// Actualizar usuario: solo el nombre es editable desde el panel admin.
if ($action === 'update_usuario') {
    $userId = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';

    if (!empty($nombre)) {
        $pdo->prepare('UPDATE usuarios SET nombre = ? WHERE id = ?')->execute([$nombre, $userId]);
        $message = 'Usuario actualizado';
    }
}

// Actualizar receta: permite modificar nombre, ingredientes e instrucciones.
if ($action === 'update_receta') {
    $recetaId = (int)($_POST['id'] ?? 0);
    $nombre = $_POST['nombre'] ?? '';
    $ingredientes = $_POST['ingredientes'] ?? '';
    $instrucciones = $_POST['instrucciones'] ?? '';

    if ($recetaId <= 0) {
        $message = 'Receta invalida.';
    }

    $updates = [];
    $params = [];
    if (!empty($nombre)) {
        $updates[] = 'nombre = ?';
        $params[] = $nombre;
    }
    if (!empty($ingredientes)) {
        $updates[] = 'ingredientes = ?';
        $params[] = $ingredientes;
    }
    if (!empty($instrucciones)) {
        $updates[] = 'instrucciones = ?';
        $params[] = $instrucciones;
    }
    if (!empty($updates) && $recetaId > 0) {
        $params[] = $recetaId;
        $sql = 'UPDATE recetas SET ' . implode(', ', $updates) . ' WHERE id = ?';
        $pdo->prepare($sql)->execute($params);
        $message = 'Receta actualizada';
    }
}

// Actualizar suscripcion: permite modificar nombre y privacidad, pero no el correo que es el identificador unico.
if ($action === 'update_suscripcion') {
    $correo = $_POST['correo'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $privacidad = isset($_POST['privacidad']) ? 1 : 0;

    $updates = [];
    $params = [];
    if (!empty($nombre)) {
        $updates[] = 'nombre = ?';
        $params[] = $nombre;
    }
    $updates[] = 'privacidad = ?';
    $params[] = $privacidad;

    if (!empty($updates)) {
        $params[] = $correo;
        $sql = 'UPDATE suscripciones SET ' . implode(', ', $updates) . ' WHERE correo = ?';
        $pdo->prepare($sql)->execute($params);
        $message = 'Suscriptor actualizado';
    }
}

// Cambiar rol de usuario: alterna entre "admin" y "usuario" para controlar permisos.
if ($action === 'change_role') {
    $userId = $_POST['id'] ?? '';
    $newRole = $_POST['role'] ?? 'usuario';
    $pdo->prepare('UPDATE usuarios SET rol = ? WHERE id = ?')->execute([$newRole, $userId]);
    $message = 'Rol actualizado';
}

// Crear tabla en base de datos: solo permite sentencias CREATE TABLE para evitar modificaciones peligrosas.
if ($action === 'db_create_table') {
    $sql = trim($_POST['sql_create'] ?? '');
    if ($sql === '') {
        $message = 'Ingrese una sentencia SQL valida';
    } else {
        if (!preg_match('/^CREATE\s+TABLE/i', $sql)) {
            $message = 'Solo se permiten sentencias CREATE TABLE';
        } else {
            try {
                $pdo->exec($sql);
                $message = 'Tabla creada correctamente';
            } catch (PDOException $e) {
                $message = 'Error al crear tabla: ' . $e->getMessage();
            }
        }
    }
}

// Consulta usuarios, recetas y suscripciones para mostrar en el panel admin.
$usuarios = $pdo->query('SELECT id, nombre, password, rol, created_at FROM usuarios ORDER BY id DESC')->fetchAll();
$recetas = $pdo->query('SELECT id, nombre, ingredientes, instrucciones FROM recetas ORDER BY id DESC')->fetchAll();

try {
    $suscripciones = $pdo->query('SELECT nombre, correo, privacidad FROM suscripciones')->fetchAll();
} catch (PDOException $e) {
    $suscripciones = [];
}
