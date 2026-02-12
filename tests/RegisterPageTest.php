<?php
// Pruebas automatizadas con PHPUnit.
namespace Tests;

class RegisterPageTest extends BaseTestCase
{
    public function testInvalidUserAndPasswordShowsErrors(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SESSION['csrf_token'] = 'test-token';
        $_POST['csrf_token'] = 'test-token';
        $_POST['usuario'] = 'ab';
        $_POST['password'] = 'weak';
        $_POST['password_confirm'] = 'weak';

        $html = $this->renderFile(__DIR__ . '/../view/plantillas/register.php');

        $this->assertStringContainsString('El nombre debe tener', $html);
        $this->assertStringContainsString('La contrase', $html);
    }

    public function testPasswordMismatchShowsError(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SESSION['csrf_token'] = 'test-token';
        $_POST['csrf_token'] = 'test-token';
        $_POST['usuario'] = 'Juan';
        $_POST['password'] = 'Strong1!';
        $_POST['password_confirm'] = 'Strong1?';

        $html = $this->renderFile(__DIR__ . '/../view/plantillas/register.php');

        $this->assertStringContainsString('no coinciden', $html);
    }
}
