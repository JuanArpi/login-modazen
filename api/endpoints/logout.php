<?php
require_once __DIR__.'/../Rest.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

$auth = new AuthAPI();
$response = $auth->cerrarSesion();

http_response_code(200);
echo json_encode($response);
?>