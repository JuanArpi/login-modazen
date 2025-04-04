<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ModaZen - Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font: Raleway -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #535AAC;
            --light-bg: #EEEFF6;
            --dark-text: #222;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Raleway', sans-serif;
            letter-spacing: -0.04em;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(to top, rgba(83, 90, 172, 0.3), var(--light-bg)) fixed;
        }

        h1 {
            font-size: clamp(1.5rem, 4vw, 2rem);
            /* Mínimo 1.5rem, máximo 2rem */
            margin-bottom: 1rem;
        }

        p {
            font-size: 1rem;
            /* Tamaño fijo */
        }

        .main-container {
            height: 100vh;
            padding: 0.75rem !important;
            /* 12px en rem */
            box-sizing: border-box;
            /* Incluye padding en el ancho total */
            display: flex;
        }

        /* Columnas flex (sin grid) */
        .login-column {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        /* Columna 2 (imagen) - Ajusta la ruta de la imagen */
        .image-column {
            background-image: url('https://via.placeholder.com/800x1000/535AAC/EEEFF6?text=ModaZen');
            background-size: cover;
            background-position: center;
        }

        /* Contenedor del formulario */
        .login-container {
            max-width: 25rem;
        }

        /* Inputs sin labels y bordes solo al enfocar */
        .custom-input {
            background-color: var(--light-bg) !important;
            border: 2px solid transparent !important;
            /* Borde transparente del mismo grosor */
            border-radius: 1rem !important;
            padding: 1rem 0.75rem !important;
            color: var(--dark-text) !important;
            margin-bottom: 0.5rem;
            box-sizing: border-box !important;
            /* Esto soluciona el problema */
            transition: border-color 0.3s ease;
            /* Transición suave para el borde */
        }

        .custom-input:focus {
            border: 2px solid var(--primary) !important;
            /* Mismo grosor que el transparente */
            outline: none !important;
            box-shadow: none !important;
            /* No necesita transform ni otros ajustes */
        }

        .form-control:focus {
            box-shadow: none !important;
        }

        /* Botón */
        .custom-btn {
            background-color: var(--primary) !important;
            border-radius: 1rem !important;
            padding: 1rem !important;
            width: 100%;
            transition: transform 0.3s ease !important;
            margin-top: 1rem;
        }

        .custom-btn:hover {
            transform: scale(0.95) !important;
        }

        /* Contenedor del ojito personalizable */
        .password-toggle-container {
            position: relative;
        }

        .password-toggle {
            background: none;
            border: none;
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            padding: 0;
        }

        .svg-icon {
            width: 1.5rem;
            /* Ajusta el tamaño */
            height: 1.5rem;
            transition: opacity 0.3s ease;
        }

        .password-toggle:hover .svg-icon {
            opacity: 0.8;
        }

        .image-column {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
        }

        .image-container {
            width: 100%;
            height: 100%;
            border-radius: 1rem;
            /* 16px */
            overflow: hidden;
            /* Recorta el exceso */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Cubre el espacio sin deformarse */
            object-position: center;
            /* Enfoca el centro de la imagen */
        }

        /* Responsive: Cambio a vertical en móvil */
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
            }

            .image-column {
                padding-bottom: 0.75rem !important;
                /* 12px */
                height: auto !important;
            }

            .login-container {
                padding: 1.5rem 0.75rem !important;
                /* 24px arriba/abajo, 12px lados */
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('form').addEventListener('submit', async function(e) {
                e.preventDefault();

                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                try {
                    const response = await fetch('api/endpoints/login.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            email,
                            password
                        }),
                        credentials: 'include'
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.location.href = 'dashboard.php';
                    } else {
                        // Mostrar error al usuario
                        const errorElement = document.createElement('div');
                        errorElement.className = 'alert alert-danger mt-3';
                        errorElement.textContent = data.message;
                        document.querySelector('form').appendChild(errorElement);

                        // Eliminar el mensaje después de 5 segundos
                        setTimeout(() => errorElement.remove(), 5000);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error al conectar con el servidor');
                }
            });
        });
    </script>
</head>

<body>
    <div class="main-container">
        <!-- Columna 1 (formulario) -->
        <div class="login-column">
            <div class="login-container d-flex flex-column justify-content-center align-items-stretch">
                <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                    <img src="img/icon-login.svg" alt="Logo ModaZen" class="mb-4" style="width: 48px; height: auto;">
                    <!-- Título y subtítulo -->
                    <h1 class="text-center mb-3">Bienvenid@ de nuevo</h1>
                    <p class="text-center mb-4">Bienvenid@ de nuevo a ModaZen. Accede a tu cuenta para descubrir
                        nuestras
                        últimas colecciones.</p>
                </div>
                <form>
                    <!-- Input Correo (sin label) -->
                    <input type="email" class="form-control custom-input mb-3" id="email" placeholder="Correo electrónico">

                    <!-- Input Contraseña con ojito personalizable -->
                    <div class="password-toggle-container">
                        <input type="password" class="form-control custom-input" id="password" placeholder="Contraseña">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <img src="img/icon-eye-hide.svg" alt="Ver contraseña" id="toggle-icon" class="svg-icon">
                        </button>
                    </div>

                    <button type="submit" class="btn btn-primary custom-btn">Ingresar</button>
                </form>
                <div class="text-center mt-4">
                    <p class="text-muted">
                        ¿Aún no tienes cuenta?
                        <a href="register.php" class="text-decoration-none d-inline-flex align-items-center" style="color: var(--primary);">
                            Regístrate <i class="bi bi-arrow-right-short ms-1"></i>
                        </a>
                    </p>
                </div>
            </div>


        </div>

        <!-- Columna 2 (imagen) -->
        <div class="login-column image-column">
            <div class="image-container">
                <img src="img/image-5.png" alt="ModaZen" class="img-fluid">
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para el ojito -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');
            const isPassword = passwordInput.type === 'password';

            // Cambia el tipo de input
            passwordInput.type = isPassword ? 'text' : 'password';

            // Cambia el ícono SVG
            toggleIcon.src = isPassword ?
                'img/icon-eye.svg' :
                'img/icon-eye-hide.svg';
            toggleIcon.alt = isPassword ? 'Ocultar contraseña' : 'Ver contraseña';
        }
    </script>
</body>

</html>