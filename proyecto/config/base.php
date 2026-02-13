<?php
// Configuracion compartida de la aplicacion.
if (!defined('BASE_URL')) {
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : '';
    $projectRoot = realpath(__DIR__ . '/..');
    $baseUrl = '';

    if ($docRoot && $projectRoot && strpos($projectRoot, $docRoot) === 0) {
        $baseUrl = substr($projectRoot, strlen($docRoot));
    }

    $baseUrl = rtrim(str_replace('\\', '/', $baseUrl), '/');
    define('BASE_URL', $baseUrl);
}
