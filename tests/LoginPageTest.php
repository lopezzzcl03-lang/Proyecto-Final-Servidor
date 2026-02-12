<?php
// Pruebas automatizadas con PHPUnit.
namespace Tests;

class LoginPageTest extends BaseTestCase
{
    public function testShowsSuccessMessageWhenRegisteredParam(): void
    {
        $_GET['registered'] = '1';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $html = $this->renderFile(__DIR__ . '/../view/plantillas/login.php');

        $this->assertStringContainsString('Registro correcto', $html);
    }

    public function testShowsErrorOnInvalidCredentials(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SESSION['csrf_token'] = 'test-token';
        $_POST['csrf_token'] = 'test-token';
        $_POST['usuario'] = 'usuario';
        $_POST['password'] = 'badpass';

        $html = $this->renderFile(__DIR__ . '/../view/plantillas/login.php');

        $this->assertStringContainsString('Usuario o contrase', $html);
    }
}
