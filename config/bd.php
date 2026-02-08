<?php
    // Conexión a una base de datos ya creada (no crea DB ni tablas)
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
        // En desarrollo puede ser útil mostrar el error; en producción loguearlo y mostrar un mensaje genérico
        die('Database connection error: ' . $e->getMessage());
    }

    /**
     * Inserta una receta en la tabla `recetas`.
     * @param string $nombre
     * @param string $ingredientes
     * @param string $instrucciones
     * @return int ID de la receta insertada
     * @throws PDOException
     */
    function insertReceta(string $nombre, string $ingredientes, string $instrucciones, ?string $imagen = null): int {
        global $pdo;
        // Si la columna `imagen` existe en la tabla, guardamos el nombre del fichero; si no, pasamos NULL
        // Se asume que la tabla `recetas` tiene la columna `imagen` (VARCHAR). Si no existe, actualizar la tabla.
        $stmt = $pdo->prepare('INSERT INTO recetas (nombre, ingredientes, instrucciones, imagen) VALUES (?, ?, ?, ?)');
        $stmt->execute([$nombre, $ingredientes, $instrucciones, $imagen]);
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