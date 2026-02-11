<?php require_once __DIR__ . '/../../config/base.php'; ?>
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

    if (!empty($nombre)) {
        $pdo->prepare('UPDATE usuarios SET nombre = ? WHERE id = ?')->execute([$nombre, $userId]);
        $message = 'Usuario actualizado';
    }
}

if ($action === 'update_receta') {
    $recetaId = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $ingredientes = $_POST['ingredientes'] ?? '';
    $instrucciones = $_POST['instrucciones'] ?? '';

    // Construir UPDATE dinámicamente con solo los campos no vacíos
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
    if (!empty($updates)) {
        $params[] = $recetaId;
        $sql = 'UPDATE recetas SET ' . implode(', ', $updates) . ' WHERE id = ?';
        $pdo->prepare($sql)->execute($params);
        $message = 'Receta actualizada';
    }
}

if ($action === 'update_suscripcion') {
    $correo = $_POST['correo'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $privacidad = isset($_POST['privacidad']) ? 1 : 0;

    // Construir UPDATE dinámicamente
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

if ($action === 'change_role') {
    $userId = $_POST['id'] ?? '';
    $newRole = $_POST['role'] ?? 'usuario';
    $pdo->prepare('UPDATE usuarios SET rol = ? WHERE id = ?')->execute([$newRole, $userId]);
    $message = 'Rol actualizado';
}

// Manejo sencillo de operaciones sobre la base de datos (solo para administradores)
function is_valid_name($name)
{
    return preg_match('/^[A-Za-z0-9_]+$/', $name);
}

if ($action === 'db_create_table') {
    $sql = trim($_POST['sql_create'] ?? '');
    if ($sql === '') {
        $message = 'Ingrese una sentencia SQL válida';
    } else {
        // Validar que sea un CREATE TABLE
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

<link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">

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
            <div class="col-12 d-flex justify-content-center px-2">
                <div class="bg-dark text-white rounded p-5 d-flex flex-column justify-content-center w-100">
                    <div class="row g-3 mb-5 d-flex justify-content-center">
                        <div class="col-md-2">
                            <div class="card text-center shadow">
                                <div class="card-body p-4">
                                    <h5 class="card-title fs-5">Usuarios</h5>
                                    <h2 class="card-text text-primary"><?= count($usuarios) ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card text-center shadow">
                                <div class="card-body p-4">
                                    <h5 class="card-title fs-5">Recetas</h5>
                                    <h2 class="card-text text-primary"><?= count($recetas) ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card text-center shadow">
                                <div class="card-body p-4">
                                    <h5 class="card-title fs-5">Suscripciones</h5>
                                    <h2 class="card-text text-primary"><?= count($suscripciones) ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-0">
                        <!-- Usamos col-md-2 para dejar más espacio horizontal entre nav y contenido -->
                        <div class="col-md-2">
                            <div class="nav flex-column nav-pills gap-3" id="adminTabs" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active mb-2 text-white fs-6 p-3" id="usuarios-tab" data-bs-toggle="pill" data-bs-target="#usuarios" type="button" role="tab">Usuarios</button>
                                <button class="nav-link mb-2 text-white fs-6 p-3" id="recetas-tab" data-bs-toggle="pill" data-bs-target="#recetas" type="button" role="tab">Recetas</button>
                                <button class="nav-link mb-2 text-white fs-6 p-3" id="suscripciones-tab" data-bs-toggle="pill" data-bs-target="#suscripciones" type="button" role="tab">Suscripciones</button>
                                <button class="nav-link mb-2 text-white fs-6 p-3" id="db-tab" data-bs-toggle="pill" data-bs-target="#database" type="button" role="tab">Base de datos</button>
                            </div>
                        </div>
                        <!-- Ajustamos a col-md-10 y añadimos padding-left para separar visualmente -->
                        <div class="col-md-10 ps-5">
                            <div class="tab-content" id="adminTabContent">
                                <!-- Tab Usuarios -->
                                <div class="tab-pane fade show active" id="usuarios" role="tabpanel">
                                    <h2 class="mb-4 fs-4 text-center">Gestión de Usuarios</h2>
                                    <div class="table-responsive d-flex justify-content-center">
                                        <table class="table table-striped">
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
                                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="prepareEditUser(<?= $user['id'] ?>, '<?= htmlspecialchars(addslashes($user['nombre'])) ?>')">Editar</button>
                                                            <button class="btn btn-warning btn-sm" onclick="changeRole(<?= $user['id'] ?>, '<?= $user['rol'] ?>')">Cambiar Rol</button>
                                                            <form method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar usuario?')">
                                                                <input type="hidden" name="action" value="delete_user">
                                                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
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
                                    <h2 class="mb-4 fs-4 text-center">Gestión de Recetas</h2>
                                    <div class="table-responsive d-flex justify-content-center">
                                        <table class="table table-striped">
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
                                                            <button class="btn btn-info btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#editRecetaModal" onclick="prepareEditReceta(<?= $receta['id'] ?>, '<?= htmlspecialchars(addslashes($receta['nombre'])) ?>', '<?= htmlspecialchars(addslashes($receta['ingredientes'])) ?>', '<?= htmlspecialchars(addslashes($receta['instrucciones'])) ?>')">Editar</button>
                                                            <form method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar receta?')">
                                                                <input type="hidden" name="action" value="delete_receta">
                                                                <input type="hidden" name="id" value="<?= $receta['id'] ?>">
                                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
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
                                    <h2 class="mb-4 fs-4 text-center">Gestión de Suscripciones</h2>
                                    <div class="table-responsive d-flex justify-content-center">
                                        <table class="table table-striped">
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
                                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editSuscripcionModal" onclick="prepareEditSuscripcion('<?= htmlspecialchars(addslashes($susc['nombre'])) ?>', '<?= htmlspecialchars($susc['correo']) ?>', <?= $susc['privacidad'] ? 1 : 0 ?>)">Editar</button>
                                                            <form method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar suscriptor?')">
                                                                <input type="hidden" name="action" value="delete_suscripcion">
                                                                <input type="hidden" name="correo" value="<?= htmlspecialchars($susc['correo']) ?>">
                                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
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
                                    <h2 class="mb-5 fs-4 text-center">Crear Tablas</h2>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-body p-4">
                                                    <h5 class="card-title fs-5 mb-4">Crear Nueva Tabla (SQL)</h5>
                                                    <form method="POST">
                                                        <input type="hidden" name="action" value="db_create_table">
                                                        <div class="mb-3">
                                                            <label for="sqlCreateTable" class="form-label">Sentencia SQL</label>
                                                            <textarea class="form-control" id="sqlCreateTable" name="sql_create" rows="8" placeholder="CREATE TABLE IF NOT EXISTS..." required></textarea>
                                                        </div>
                                                        <button class="btn btn-primary btn-lg" type="submit">Crear Tabla</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="formEditUser">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_usuario">
                    <input type="hidden" name="id" id="userId" value="">
                    <div class="mb-3">
                        <label for="editUserNombre" class="form-label">Nombre (opcional)</label>
                        <input type="text" class="form-control" id="editUserNombre" name="nombre" placeholder="Dejar vacío para no cambiar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Receta -->
<div class="modal fade" id="editRecetaModal" tabindex="-1" aria-labelledby="editRecetaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRecetaLabel">Editar Receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="formEditReceta">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_receta">
                    <input type="hidden" name="id" id="recetaId" value="">
                    <div class="mb-3">
                        <label for="editRecetaNombre" class="form-label">Nombre (opcional)</label>
                        <input type="text" class="form-control" id="editRecetaNombre" name="nombre" placeholder="Dejar vacío para no cambiar">
                    </div>
                    <div class="mb-3">
                        <label for="editRecetaIngredientes" class="form-label">Ingredientes (opcional)</label>
                        <textarea class="form-control" id="editRecetaIngredientes" name="ingredientes" rows="3" placeholder="Dejar vacío para no cambiar"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editRecetaInstrucciones" class="form-label">Instrucciones (opcional)</label>
                        <textarea class="form-control" id="editRecetaInstrucciones" name="instrucciones" rows="3" placeholder="Dejar vacío para no cambiar"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Suscripción -->
<div class="modal fade" id="editSuscripcionModal" tabindex="-1" aria-labelledby="editSuscripcionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSuscripcionLabel">Editar Suscripción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="formEditSuscripcion">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update_suscripcion">
                    <input type="hidden" name="correo" id="suscripcionCorreo" value="">
                    <div class="mb-3">
                        <label for="editSuscripcionNombre" class="form-label">Nombre (opcional)</label>
                        <input type="text" class="form-control" id="editSuscripcionNombre" name="nombre" placeholder="Dejar vacío para no cambiar">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="editSuscripcionPrivacidad" name="privacidad" value="1">
                            <label class="form-check-label" for="editSuscripcionPrivacidad">Acepta política de privacidad</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/public/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/public/js/Script.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>


