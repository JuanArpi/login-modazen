<?php
require_once __DIR__.'/config/database.php';

class AuthAPI {
    private $db;
    
    public function __construct() {
        $this->db = getDBConnection();
        $this->initSession();
    }
    
    private function initSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 86400,
                'path' => '/',
                'domain' => $_SERVER['HTTP_HOST'],
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            session_start();
        }
    }
    
    public function registrar($nombre, $email, $password) {
        // Validaciones mejoradas
        $nombre = trim($nombre);
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
        
        if (empty($nombre) || strlen($nombre) > 100) {
            return ['success' => false, 'message' => 'Nombre inválido (máx. 100 caracteres)'];
        }
        
        if (!$email) {
            return ['success' => false, 'message' => 'Email no válido'];
        }
        
        if (strlen($password) < 8) {
            return ['success' => false, 'message' => 'La contraseña debe tener al menos 8 caracteres'];
        }
        
        try {
            // Verificar email único
            $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'message' => 'El email ya está registrado'];
            }
            
            // Hash seguro
            $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            
            // Insertar usuario
            $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $email, $passwordHash]);
            
            return ['success' => true, 'message' => 'Registro exitoso. Redirigiendo...'];
            
        } catch (PDOException $e) {
            error_log('Error en registro: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error en el servidor'];
        }
    }
    
    public function iniciarSesion($email, $password) {
        $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
        
        if (!$email || empty($password)) {
            return ['success' => false, 'message' => 'Credenciales inválidas'];
        }
        
        try {
            $stmt = $this->db->prepare("SELECT id, nombre, email, password FROM usuarios WHERE email = ? AND activo = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if (!$user || !password_verify($password, $user['password'])) {
                return ['success' => false, 'message' => 'Credenciales incorrectas'];
            }
            
            // Regenerar ID de sesión para prevenir fixation
            session_regenerate_id(true);
            
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nombre' => $user['nombre'],
                'email' => $user['email']
            ];
            
            return ['success' => true, 'user' => $_SESSION['user']];
            
        } catch (PDOException $e) {
            error_log('Error en login: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error en el servidor'];
        }
    }
    
    public function cerrarSesion() {
        $_SESSION = [];
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        return ['success' => true];
    }
    
    public function verificarSesion() {
        return [
            'is_logged_in' => isset($_SESSION['user']),
            'user' => $_SESSION['user'] ?? null
        ];
    }
}

// Configuración CORS y headers
header("Access-Control-Allow-Origin: http://localhost/modazen");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
?>