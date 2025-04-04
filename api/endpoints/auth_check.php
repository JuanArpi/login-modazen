<?php
require_once __DIR__.'/../Rest.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

$auth = new AuthAPI();
$response = $auth->verificarSesion();

http_response_code(200);
echo json_encode($response);
?>