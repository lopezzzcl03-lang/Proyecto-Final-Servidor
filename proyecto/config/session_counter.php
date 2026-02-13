<?php
/**
 * Registro de inicios de sesion en la tabla `sesiones`.
 * Soporta el esquema actual: id, Nombre, conteo.
 */

function getSesionesColumns(): array {
    global $pdo;
    static $cache = null;

    if ($cache !== null) {
        return $cache;
    }

    $cache = ['id' => null, 'user' => null, 'count' => null];

    try {
        $rows = $pdo->query('SHOW COLUMNS FROM sesiones')->fetchAll();
        if (!$rows) {
            return $cache;
        }

        $actualByLower = [];
        foreach ($rows as $row) {
            $actual = (string)($row['Field'] ?? '');
            if ($actual !== '') {
                $actualByLower[strtolower($actual)] = $actual;
            }
        }

        foreach (['id'] as $candidate) {
            if (isset($actualByLower[$candidate])) {
                $cache['id'] = $actualByLower[$candidate];
                break;
            }
        }
        foreach (['nombre', 'nombre_usuario', 'usuario', 'username', 'user_name'] as $candidate) {
            if (isset($actualByLower[$candidate])) {
                $cache['user'] = $actualByLower[$candidate];
                break;
            }
        }
        foreach (['conteo', 'contador', 'veces', 'total', 'login_count'] as $candidate) {
            if (isset($actualByLower[$candidate])) {
                $cache['count'] = $actualByLower[$candidate];
                break;
            }
        }
    } catch (Throwable $e) {
        error_log('[SessionCounter] No se pudo leer la tabla sesiones: ' . $e->getMessage());
    }

    return $cache;
}

function getNextSesionId(): int {
    global $pdo;

    try {
        $stmt = $pdo->query('SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM sesiones');
        return (int)($stmt->fetch()['next_id'] ?? 1);
    } catch (Throwable $e) {
        error_log('[SessionCounter] Error calculando el siguiente id: ' . $e->getMessage());
        return 1;
    }
}

/**
 * Registra un inicio de sesion para un usuario y devuelve su conteo acumulado.
 */
function addSessionUser(string $username): int {
    global $pdo;

    $columns = getSesionesColumns();
    $idCol = $columns['id'];
    $userCol = $columns['user'];
    $countCol = $columns['count'];

    if ($idCol === null || $userCol === null || $countCol === null) {
        error_log('[SessionCounter] Faltan columnas requeridas en sesiones (id, Nombre, conteo).');
        return 0;
    }

    try {
        $select = $pdo->prepare("SELECT `$idCol` AS id, `$countCol` AS c FROM sesiones WHERE `$userCol` = ? ORDER BY `$idCol` DESC LIMIT 1");
        $select->execute([$username]);
        $row = $select->fetch();

        if ($row) {
            $newCount = ((int)$row['c']) + 1;
            $update = $pdo->prepare("UPDATE sesiones SET `$countCol` = ? WHERE `$idCol` = ?");
            $update->execute([$newCount, (int)$row['id']]);
            return $newCount;
        }

        $newId = getNextSesionId();
        $insert = $pdo->prepare("INSERT INTO sesiones (`$idCol`, `$userCol`, `$countCol`) VALUES (?, ?, 1)");
        $insert->execute([$newId, $username]);
        return 1;
    } catch (Throwable $e) {
        error_log('[SessionCounter] Error al registrar login: ' . $e->getMessage());
        return 0;
    }
}

/**
 * Devuelve el conteo de logins de un usuario.
 */
function getSessionCount(?string $username = null): int {
    global $pdo;

    if ($username === null) {
        $username = $_SESSION['user_name'] ?? null;
    }
    if ($username === null || $username === '') {
        return 0;
    }

    $columns = getSesionesColumns();
    $userCol = $columns['user'];
    $countCol = $columns['count'];
    if ($userCol === null || $countCol === null) {
        return 0;
    }

    try {
        $stmt = $pdo->prepare("SELECT COALESCE(SUM(`$countCol`), 0) AS c FROM sesiones WHERE `$userCol` = ?");
        $stmt->execute([$username]);
        return (int)($stmt->fetch()['c'] ?? 0);
    } catch (Throwable $e) {
        error_log('[SessionCounter] Error al obtener conteo: ' . $e->getMessage());
        return 0;
    }
}
