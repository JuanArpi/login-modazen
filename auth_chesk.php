<?php
session_start();

function checkAuth() {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
    return $_SESSION['user'];
}

// Ejemplo de uso en otras páginas:
// $user = checkAuth(); // Esto redirigirá si no está autenticado
?>