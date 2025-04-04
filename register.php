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
    <title>ModaZen - Registro</title>
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

        body {
            font-family: 'Raleway', sans-serif;
            letter-spacing: -0.04em;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(to top, rgba(83, 90, 172, 0.3), var(--light-bg)) fixed;
        }

        .main-container {
            height: 100vh;
            padding: 0.75rem;
            display: flex;
        }

        /* Columnas flex */
        .login-column {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        /* Contenedor del formulario */
        .login-container {
            max-width: 25rem;
        }

        /* Inputs */
        .custom-input {
            background-color: var(--light-bg) !important;
            border: 2px solid transparent !important;
            border-radius: 1rem !important;
            color: var(--dark-text) !important;
            margin-bottom: 0.5rem;
            box-sizing: border-box !important;
            padding: 1rem 0.75rem !important;
            transition: all 0.3s ease;
            width: 100%;
        }

        .custom-input:focus {
            border: 2px solid var(--primary) !important;
            outline: none !important;
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
            border: none;
        }

        .custom-btn:hover {
            transform: scale(0.95) !important;
        }

        /* Contenedor del ojito */
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
            height: 1.5rem;
            transition: opacity 0.3s ease;
        }

        .password-toggle:hover .svg-icon {
            opacity: 0.8;
        }

        /* Columna de imagen */
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
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
            }

            .image-column {
                height: 40%;
                order: 2;
            }
        }

        /* Títulos */
        h1 {
            font-size: clamp(1.5rem, 4vw, 2rem);
            margin-bottom: 1rem;
        }

        p {
            font-size: 1rem;
        }
    </style>
    <!-- Tus meta tags y estilos existentes -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = {
                nombre: document.getElementById('fullname').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };
            
            // Validación básica del frontend
            if (formData.password !== document.getElementById('confirmPassword').value) {
                alert('Las contraseñas no coinciden');
                return;
            }
            
            try {
                const response = await fetch('api/endpoints/register.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Registro exitoso. Serás redirigido para iniciar sesión.');
                    window.location.href = 'login.php';
                } else {
                    alert('Error: ' + data.message);
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
    <div class="main-container container-fluid">
        <!-- Columna 2 (imagen) -->
        <div class="login-column image-column">
            <div class="image-container">
                <img src="img/image 6.png" alt="ModaZen" class="img-fluid">
            </div>
        </div>

        <!-- Columna 1 (formulario) -->
        <div class="login-column">
            <div class="login-container d-flex flex-column justify-content-center align-items-stretch">
                <div class="d-flex flex-column justify-content-center align-items-center mb-4">
                    <img src="img/icon-login.svg" alt="Logo ModaZen" class="mb-4" style="width: 48px; height: auto;">
                    <h1 class="text-center mb-3">Únete a nosotros</h1>
                    <p class="text-center mb-4">Crea tu cuenta y disfruta de ropa cómoda y estilosa para yoga, entrenamiento y cada día.</p>
                </div>

                <form id="registerForm" class="needs-validation" novalidate>
                    <!-- Nombre completo -->
                    <div class="mb-3">
                        <label for="fullname" class="form-label visually-hidden">Nombre completo</label>
                        <input type="text" class="form-control custom-input" id="fullname" placeholder="Nombre completo" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tu nombre completo
                        </div>
                    </div>

                    <!-- Correo electrónico -->
                    <div class="mb-3">
                        <label for="email" class="form-label visually-hidden">Correo electrónico</label>
                        <input type="email" class="form-control custom-input" id="email" placeholder="Correo electrónico" required>
                        <div class="invalid-feedback">
                            Por favor ingresa un correo válido
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label visually-hidden">Contraseña</label>
                        <input type="password" class="form-control custom-input pe-5" id="password" placeholder="Contraseña" required>
                        <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y" onclick="togglePassword('password', 'toggle-icon-password')">
                            <img src="img/icon-eye-hide.svg" alt="Mostrar contraseña" id="toggle-icon-password" class="svg-icon">
                        </button>
                        <div class="invalid-feedback">
                            Por favor ingresa una contraseña
                        </div>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="mb-3 position-relative">
                        <label for="confirmPassword" class="form-label visually-hidden">Confirmar contraseña</label>
                        <input type="password" class="form-control custom-input pe-5" id="confirmPassword" placeholder="Confirmar contraseña" required>
                        <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y" onclick="togglePassword('confirmPassword', 'toggle-icon-confirm')">
                            <img src="img/icon-eye-hide.svg" alt="Mostrar contraseña" id="toggle-icon-confirm" class="svg-icon">
                        </button>
                        <div id="passwordMatchError" class="text-danger small mt-1 d-none">
                            Las contraseñas no coinciden
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary custom-btn py-3">Registrar</button>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <p class="text-muted">
                        ¿Ya tienes cuenta?
                        <a href="login.php" class="text-decoration-none d-inline-flex align-items-center" style="color: var(--primary);">
                            Inicia sesión <i class="bi bi-arrow-right-short ms-1"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>


    </div>

    <!-- Bootstrap JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para los ojitos -->
    <script>
        // Función para mostrar/ocultar contraseña
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isPassword = input.type === 'password';

            input.type = isPassword ? 'text' : 'password';
            icon.src = isPassword ? 'img/icon-eye.svg' : 'img/icon-eye-hide.svg';
            icon.alt = isPassword ? 'Ocultar contraseña' : 'Ver contraseña';
        }

        // Validación de coincidencia de contraseñas
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const errorElement = document.getElementById('passwordMatchError');

            if (password !== confirmPassword) {
                e.preventDefault(); // Evita el envío del formulario
                errorElement.style.display = 'block';
                document.getElementById('confirmPassword').focus();
            } else {
                errorElement.style.display = 'none';
                // Aquí puedes agregar lógica adicional para enviar el formulario
            }
        });

        // Validación en tiempo real
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const errorElement = document.getElementById('passwordMatchError');

            if (confirmPassword.length > 0 && password !== confirmPassword) {
                errorElement.style.display = 'block';
            } else {
                errorElement.style.display = 'none';
            }
        });
    </script>
</body>

</html>