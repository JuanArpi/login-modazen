<?php
// Configuración segura de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'modazen');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDBConnection() {
    static $db = null;
    
    if ($db === null) {
        try {
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4';
            $db = new PDO($dsn, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            error_log('Error de conexión: ' . $e->getMessage());
            die(json_encode(['success' => false, 'message' => 'Error de conexión con la base de datos']));
        }
    }
    
    return $db;
}
?>