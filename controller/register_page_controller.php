<?php
// Controlador: procesa la peticion y prepara datos para la vista.
require_once __DIR__ . '/../config/base.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';

// Si el usuario ya esta logueado, redirige al index. 
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isValidCsrfToken($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Solicitud invalida. Recarga la pagina e intentalo de nuevo.';
    } else {
        $usuario = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        // El nombre de usuario debe tener al menos 3 letras y solo contener letras (A-Z).
        if (!preg_match('/^[A-Za-z]{3,}$/', $usuario)) {
            $errors[] = 'El nombre debe tener al menos 3 letras y solo contener letras (A-Z).';
        }

        // La contrasena debe tener al menos 8 caracteres y contener mayusculas, minusculas, numeros y simbolos.
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/', $password)) {
            $errors[] = 'La contrasena debe tener al menos 8 caracteres y contener mayusculas, minusculas, numeros y un simbolo.';
        }

        if ($password !== $password_confirm) {
            $errors[] = 'Las contrasenas no coinciden.';
        }

        // Si no hay errores, intenta registrar al usuario.
        if (empty($errors)) {
            global $pdo;
            $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE nombre = ?');
            $stmt->execute([$usuario]);
            if ($stmt->fetch()) {
                $errors[] = 'El nombre de usuario ya existe, elige otro.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $insert = $pdo->prepare('INSERT INTO usuarios (nombre, password) VALUES (?, ?)');
                $insert->execute([$usuario, $hash]);
                if (loginUser($usuario, $password)) {
                    header('Location: ' . BASE_URL . '/index.php');
                    exit;
                }

                header('Location: ' . BASE_URL . '/view/plantillas/login.php?registered=1');
                exit;
            }
        }
    }
}
