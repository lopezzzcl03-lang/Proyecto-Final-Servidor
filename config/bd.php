<?php
// Conexion a una base de datos ya creada (no crea DB ni tablas)
$appEnv = getenv('APP_ENV') ?: '';

if ($appEnv === 'testing') {
    $pdo = new PDO('sqlite::memory:', null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} else {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'recetas_db';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        // En desarrollo puede ser util mostrar el error; en produccion loguearlo y mostrar un mensaje generico
        die('Database connection error: ' . $e->getMessage());
    }
}

/**
 * Inserta una receta en la tabla `recetas`.
 * @param string $nombre
 * @param string $ingredientes
 * @param string $instrucciones
 * @param string $categoria
 * @param string|null $imagen
 * @param string|null $mime
 * @return int ID de la receta insertada
 * @throws PDOException
 */
function insertReceta(string $nombre, string $ingredientes, string $instrucciones, string $categoria, ?string $imagen = null, ?string $mime = null): int {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO recetas (nombre, ingredientes, instrucciones, categoria, imagen, mime) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$nombre, $ingredientes, $instrucciones, $categoria, $imagen, $mime]);
    return (int)$pdo->lastInsertId();
}

/**
 * Inserta una receta en la tabla `recetas`.
 * @param string $nombre
 * @param string $correo
 * @param boolean $privacidad
 * @throws PDOException
 */
function insertSuscripcion(string $nombre, string $correo, bool $privacidad): int {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO suscripciones (nombre, correo, privacidad) VALUES (?, ?, ?)');
    $stmt->execute([$nombre, $correo, $privacidad]);
    return (int)$pdo->lastInsertId();
}
?>
