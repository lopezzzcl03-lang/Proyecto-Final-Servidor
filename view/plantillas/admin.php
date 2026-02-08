<?php
    require_once __DIR__ . '/../../config/session.php';
    require_once __DIR__ . '/../../config/auth.php';
    require_once __DIR__ . '/../../config/bd.php';
    require_once __DIR__ . '/header.php';
    
    requireAdmin();
    
    $action = $_POST['action'] ?? '';
    $message = '';
    
    if ($action === 'delete_user') {
        $userId = $_POST['id'] ?? '';
        $pdo->prepare('DELETE FROM usuarios WHERE id = ?')->execute([$userId]);
        $message = 'Usuario eliminado';
    }
    
    if ($action === 'delete_receta') {
        $recetaId = $_POST['id'] ?? '';
        $pdo->prepare('DELETE FROM recetas WHERE id = ?')->execute([$recetaId]);
        $message = 'Receta eliminada';
    }
    
    if ($action === 'delete_suscripcion') {
        $correo = $_POST['correo'] ?? '';
        $pdo->prepare('DELETE FROM suscripciones WHERE correo = ?')->execute([$correo]);
        $message = 'Suscriptor eliminado';
    }
    
    if ($action === 'update_usuario') {
        $userId = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $pdo->prepare('UPDATE usuarios SET nombre = ? WHERE id = ?')->execute([$nombre, $userId]);
        $message = 'Usuario actualizado';
    }
    
    if ($action === 'update_receta') {
        $recetaId = $_POST['id'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $ingredientes = $_POST['ingredientes'] ?? '';
        $instrucciones = $_POST['instrucciones'] ?? '';
        $pdo->prepare('UPDATE recetas SET nombre = ?, ingredientes = ?, instrucciones = ? WHERE id = ?')->execute([$nombre, $ingredientes, $instrucciones, $recetaId]);
        $message = 'Receta actualizada';
    }
    
    if ($action === 'update_suscripcion') {
        $correo = $_POST['correo'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $privacidad = isset($_POST['privacidad']) ? 1 : 0;
        $pdo->prepare('UPDATE suscripciones SET nombre = ?, privacidad = ? WHERE correo = ?')->execute([$nombre, $privacidad, $correo]);
        $message = 'Suscriptor actualizado';
    }

    if ($action === 'change_role') {
        $userId = $_POST['id'] ?? '';
        $newRole = $_POST['role'] ?? 'usuario';
        $pdo->prepare('UPDATE usuarios SET rol = ? WHERE id = ?')->execute([$newRole, $userId]);
        $message = 'Rol actualizado';
    }

    // Manejo sencillo de operaciones sobre la base de datos (solo para administradores)
    function is_valid_name($name) {
        return preg_match('/^[A-Za-z0-9_]+$/', $name);
    }

    if ($action === 'db_create_table') {
        $table = $_POST['table'] ?? '';
        $columns_raw = $_POST['columns'] ?? '';
        if (!is_valid_name($table) || trim($columns_raw) === '') {
            $message = 'Nombre de tabla o columnas inválidas';
        } else {
            $cols = array_filter(array_map('trim', explode(';', $columns_raw)));
            $defs = [];
            foreach ($cols as $c) {
                $parts = explode(':', $c, 2);
                if (count($parts) !== 2) { continue; }
                $colName = trim($parts[0]);
                $colType = trim($parts[1]);
                if (!is_valid_name($colName) || preg_match('/;|--|\/\*/', $colType)) { continue; }
                $defs[] = "`$colName` $colType";
            }
            if (empty($defs)) {
                $message = 'Definición de columnas inválida';
            } else {
                try {
                    $sql = "CREATE TABLE IF NOT EXISTS `$table` (" . implode(', ', $defs) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                    $pdo->exec($sql);
                    $message = 'Tabla creada o ya existente';
                } catch (PDOException $e) {
                    $message = 'Error al crear tabla: ' . $e->getMessage();
                }
            }
        }
    }

    if ($action === 'db_add_column') {
        $table = $_POST['table'] ?? '';
        $col = $_POST['column'] ?? '';
        $type = $_POST['type'] ?? '';
        if (!is_valid_name($table) || !is_valid_name($col) || preg_match('/;|--|\/\*/', $type)) {
            $message = 'Datos inválidos para añadir columna';
        } else {
            try {
                $sql = "ALTER TABLE `$table` ADD COLUMN `$col` $type";
                $pdo->exec($sql);
                $message = 'Columna añadida';
            } catch (PDOException $e) {
                $message = 'Error al añadir columna: ' . $e->getMessage();
            }
        }
    }

    if ($action === 'db_run_sql') {
        $sql = trim($_POST['sql'] ?? '');
        if ($sql === '' || strpos($sql, ';') !== false || !preg_match('/^(CREATE|ALTER|DROP)\s/i', $sql)) {
            $message = 'Sentencia SQL no permitida o inválida';
        } else {
            try {
                $pdo->exec($sql);
                $message = 'Sentencia ejecutada correctamente';
            } catch (PDOException $e) {
                $message = 'Error al ejecutar SQL: ' . $e->getMessage();
            }
        }
    }
    
    // Obtener datos
    $usuarios = $pdo->query('SELECT id, nombre, password, rol, created_at FROM usuarios ORDER BY id DESC')->fetchAll();
    $recetas = $pdo->query('SELECT id, nombre, ingredientes, instrucciones FROM recetas ORDER BY id DESC')->fetchAll();
    
    // Obtener suscripciones
    try {
        $suscripciones = $pdo->query('SELECT nombre, correo, privacidad FROM suscripciones')->fetchAll();
    } catch (PDOException $e) {
        $suscripciones = [];
    }
?>

<link href="/FinalPhP/public/css/bootstrap.min.css" rel="stylesheet">


<main class="py-5">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1>Panel de Administración</h1>
                <p class="text-muted">Bienvenido, <?= htmlspecialchars(getCurrentUser()) ?></p>
            </div>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <!-- Estadísticas -->
         <!-- Vertical layout: left nav, right content (envolviendo todo en fondo oscuro) -->
         <div class="row mb-4">
            <div class="col-12">
                <div class="bg-dark text-white rounded p-1" style="min-height:220px;">
                    <div class="row g-1 mb-1  d-flex justify-content-center">
                        <div class="col-md-2">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Usuarios</h5>
                                    <h3 class="card-text text-primary"><?= count($usuarios) ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Recetas</h5>
                                    <h3 class="card-text text-primary"><?= count($recetas) ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Suscripciones</h5>
                                    <h3 class="card-text text-primary"><?= count($suscripciones) ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="row g-0">
                        <div class="col-md-3">
                            <div class="nav flex-column nav-pills gap-1" id="adminTabs" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active mb-1 text-white" id="usuarios-tab" data-bs-toggle="pill" data-bs-target="#usuarios" type="button" role="tab">👥 Usuarios</button>
                        <button class="nav-link mb-1 text-white" id="recetas-tab" data-bs-toggle="pill" data-bs-target="#recetas" type="button" role="tab">📖 Recetas</button>
                        <button class="nav-link mb-1 text-white" id="suscripciones-tab" data-bs-toggle="pill" data-bs-target="#suscripciones" type="button" role="tab">📧 Suscripciones</button>
                        <button class="nav-link mb-1 text-white" id="db-tab" data-bs-toggle="pill" data-bs-target="#database" type="button" role="tab">🛠️ Base de datos</button>
                    </div>
                </div>
                <div class="col-md-9">
                <div class="tab-content" id="adminTabContent">
            <!-- Tab Usuarios -->
            <div class="tab-pane fade show active" id="usuarios" role="tabpanel">
                <h2 class="mb-2 fs-5">Gestión de Usuarios</h2>
                <div class="table-responsive g-0">
                    <table class="table table-striped table-sm small fs-6">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Rol</th>
                                <th>Creado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['nombre']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $user['rol'] === 'admin' ? 'danger' : 'secondary' ?>">
                                        <?= htmlspecialchars($user['rol']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($user['created_at'] ?? 'N/A') ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="editUsuario(<?= $user['id'] ?>, '<?= htmlspecialchars($user['nombre']) ?>')">Editar</button>
                                    <button class="btn btn-sm btn-warning" onclick="changeRole(<?= $user['id'] ?>, '<?= $user['rol'] ?>')">Cambiar Rol</button>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar usuario?')">
                                        <input type="hidden" name="action" value="delete_user">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Tab Recetas -->
            <div class="tab-pane fade" id="recetas" role="tabpanel">
            <h2 class="mb-2 fs-5">Gestión de Recetas</h2>
                <div class="table-responsive g-0">
                    <table class="table table-striped table-sm small fs-6">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Ingredientes</th>
                                <th>Instrucciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recetas as $receta): ?>
                            <tr>
                                <td><?= htmlspecialchars($receta['id']) ?></td>
                                <td><?= htmlspecialchars($receta['nombre']) ?></td>
                                <td><?= htmlspecialchars(substr($receta['ingredientes'], 0, 50)) . (strlen($receta['ingredientes']) > 50 ? '...' : '') ?></td>
                                <td><?= htmlspecialchars(substr($receta['instrucciones'], 0, 50)) . (strlen($receta['instrucciones']) > 50 ? '...' : '') ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="editReceta(<?= $receta['id'] ?>, '<?= htmlspecialchars(addslashes($receta['nombre'])) ?>')">Editar</button>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar receta?')">
                                        <input type="hidden" name="action" value="delete_receta">
                                        <input type="hidden" name="id" value="<?= $receta['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab Suscripciones -->
            <div class="tab-pane fade" id="suscripciones" role="tabpanel">
                <h2 class="mb-2 fs-5">Gestión de Suscripciones</h2>
                <div class="table-responsive g-0">
                    <table class="table table-striped table-sm small fs-6">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Privacidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($suscripciones as $susc): ?>
                            <tr>
                                <td><?= htmlspecialchars($susc['nombre']) ?></td>
                                <td><?= htmlspecialchars($susc['correo']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $susc['privacidad'] ? 'success' : 'secondary' ?>">
                                        <?= $susc['privacidad'] ? 'Aceptada' : 'No aceptada' ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="editSuscripcion('<?= htmlspecialchars(addslashes($susc['nombre'])) ?>', '<?= htmlspecialchars($susc['correo']) ?>', <?= $susc['privacidad'] ? 1 : 0 ?>)">Editar</button>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar suscriptor?')">
                                        <input type="hidden" name="action" value="delete_suscripcion">
                                        <input type="hidden" name="correo" value="<?= htmlspecialchars($susc['correo']) ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Tab Database -->
            <div class="tab-pane fade" id="database" role="tabpanel">
                <h2 class="mb-2 fs-5">Herramientas de Base de Datos</h2>
                <p class="text-muted">Formatea columnas como: <code>id:INT PRIMARY KEY AUTO_INCREMENT;name:VARCHAR(255)</code></p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-2">
                            <div class="card-body p-2">
                                <h5 class="card-title fs-6">Crear tabla</h5>
                                <form method="POST">
                                    <input type="hidden" name="action" value="db_create_table">
                                    <div class="mb-2">
                                        <label class="form-label">Nombre tabla</label>
                                        <input class="form-control" name="table" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Columnas (separadas por ; )</label>
                                        <input class="form-control" name="columns" placeholder="id:INT PRIMARY KEY AUTO_INCREMENT;name:VARCHAR(255)" required>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Crear</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-2">
                            <div class="card-body p-2">
                                <h5 class="card-title fs-6">Añadir columna</h5>
                                <form method="POST">
                                    <input type="hidden" name="action" value="db_add_column">
                                    <div class="mb-2">
                                        <label class="form-label">Tabla</label>
                                        <input class="form-control" name="table" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Nombre columna</label>
                                        <input class="form-control" name="column" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Tipo (ej: VARCHAR(255), INT)</label>
                                        <input class="form-control" name="type" required>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Añadir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-2">
                        <h5 class="card-title fs-6">Ejecutar sentencia SQL (CREATE / ALTER / DROP)</h5>
                        <form method="POST">
                            <input type="hidden" name="action" value="db_run_sql">
                            <div class="mb-2">
                                <label class="form-label">SQL</label>
                                <textarea class="form-control" name="sql" rows="3" placeholder="CREATE TABLE ejemplo (...)" required></textarea>
                            </div>
                            <button class="btn btn-danger" type="submit">Ejecutar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="/FinalPhP/public/js/bootstrap.bundle.min.js"></script>
<script src="/FinalPhP/public/js/Script.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>
