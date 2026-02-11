<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->resetGlobals();
        $this->ensureSchema();
    }

    protected function resetGlobals(): void
    {
        $_GET = [];
        $_POST = [];
        $_SESSION = [];
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    protected function ensureSchema(): void
    {
        global $pdo;
        if (!$pdo) {
            if (!extension_loaded('pdo_sqlite')) {
                $this->markTestSkipped('Habilita pdo_sqlite en tu php.ini para ejecutar los tests.');
            }
            $pdo = new \PDO('sqlite::memory:', null, null, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
        }
        $pdo->exec('CREATE TABLE IF NOT EXISTS usuarios (id INTEGER PRIMARY KEY AUTOINCREMENT, nombre TEXT UNIQUE, password TEXT, rol TEXT)');
        $pdo->exec('CREATE TABLE IF NOT EXISTS suscripciones (id INTEGER PRIMARY KEY AUTOINCREMENT, nombre TEXT, correo TEXT, privacidad INTEGER)');
        $pdo->exec('DELETE FROM usuarios');
        $pdo->exec('DELETE FROM suscripciones');
    }

    protected function renderFile(string $path): string
    {
        ob_start();
        include $path;
        return ob_get_clean();
    }
}
