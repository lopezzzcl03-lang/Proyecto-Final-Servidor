# 🔐 Sistema de Roles - Guía Simple

## Lo que necesitas hacer en MySQL

### 1. Agregar columna `rol` a la tabla usuarios

Ejecuta esto en PhpMyAdmin en la pestaña SQL:

```sql
ALTER TABLE `usuarios` ADD COLUMN `rol` VARCHAR(20) NOT NULL DEFAULT 'usuario' AFTER `password`;
```

### 2. Crear usuario admin

Copia esta contraseña hasheada (admin/admin):

```sql
INSERT INTO `usuarios` (`nombre`, `password`, `rol`) 
VALUES ('admin', '$2y$10$YIjlrBHW/6vAFR1CJNZo5eKI8J6QYRbLJXyeOO5iANYe5gP6MvBUG', 'admin');
```

### 3. Convertir un usuario existente a admin

Si ya tienes un usuario y quieres hacerlo admin:

```sql
UPDATE `usuarios` SET `rol` = 'admin' WHERE `nombre` = 'nombreusuario';
```

---

## ¿Listo?

1. ✅ Abre PhpMyAdmin
2. ✅ Selecciona tu BD `recetas_db`
3. ✅ Ve a la pestaña SQL
4. ✅ Ejecuta los 2 comandos SQL anteriores
5. ✅ Haz login con: **admin / admin**
6. ✅ Verás el botón 🔐 Admin en la esquina superior derecha

---

## Archivos modificados

- `config/auth.php` - Añadidas funciones: `isAdmin()` y `requireAdmin()`
- `view/header.php` - Agregado botón admin
- `view/admin.php` - Panel de admin (nuevo)

---

## Funciones disponibles en PHP

```php
isAdmin()           // true si es admin, false si no
requireAdmin()      // Redirige si no es admin
```

Úsalas así:

```php
<?php
require_once 'config/auth.php';

if (isAdmin()) {
    // Mostrar contenido solo para admins
}

requireAdmin();  // Proteger una página
?>
```

---

## ¿Cambiar la contraseña del admin?

Si quieres cambiar la contraseña, genera un nuevo hash en PHP:

```php
<?php
echo password_hash('nueva_contraseña', PASSWORD_BCRYPT);
?>
```

Luego ejecuta en SQL:

```sql
UPDATE `usuarios` SET `password` = 'EL_HASH_QUE_GENERASTE' WHERE `nombre` = 'admin';
```
