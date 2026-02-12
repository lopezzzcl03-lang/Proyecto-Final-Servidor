<?php
// Pruebas automatizadas con PHPUnit.
putenv('APP_ENV=testing');

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/bd.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/TestCase.php';