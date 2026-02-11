<?php
namespace Tests;

class SuscribetePageTest extends BaseTestCase
{
    public function testShowsErrorsFromSession(): void
    {
        $_SESSION['suscribete_errors'] = ['Error de prueba'];

        $html = $this->renderFile(__DIR__ . '/../view/plantillas/suscribete.php');

        $this->assertStringContainsString('Error de prueba', $html);
        $this->assertArrayNotHasKey('suscribete_errors', $_SESSION);
    }

    public function testShowsSuccessFromSession(): void
    {
        $_SESSION['suscribete_success'] = 'Suscripcion OK';

        $html = $this->renderFile(__DIR__ . '/../view/plantillas/suscribete.php');

        $this->assertStringContainsString('Suscripcion OK', $html);
        $this->assertArrayNotHasKey('suscribete_success', $_SESSION);
    }
}
