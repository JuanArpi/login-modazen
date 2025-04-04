<?php
require_once __DIR__.'/../Rest.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Método no permitido']));
}

$data = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Datos JSON inválidos']));
}

$auth = new AuthAPI();
$response = $auth->iniciarSesion($data['email'] ?? '', $data['password'] ?? '');

http_response_code($response['success'] ? 200 : 401);
echo json_encode($response);
?>