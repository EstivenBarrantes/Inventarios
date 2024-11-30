<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!--CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper">
        <div class="title">Registro</div>
        <form action="InicioSesion/registrarse.php" method="POST">
            <div class="field">
                <input type="text" id="username" name="username" placeholder="Ingresa tu usuario" required>
                <label for="username">Nombre de usuario</label>
            </div>
            <div class="field">
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                <label for="password">Contraseña</label>
            </div>
            <div class="field">
                <select id="role_id" name="role_id" required>
                    <option value="1">Admin</option>
                    <option value="2">Boton de prueba</option>
                    <option value="3">Usuario</option>
                </select>
                <label for="role_id">Rol</label>
            </div>
            <div class="field">
                <input type="submit" value="Registrar">
            </div>
            <div class="signup-link">
                ¿Ya tienes cuenta? <a href="index.php">Iniciar sesión</a>
            </div>
        </form>
    </div>

    <!-- Validación de contraseña -->
    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;

            if (password.length < 8) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Contraseña inválida',
                    text: 'La contraseña debe tener al menos 8 caracteres.',
                });
            }
        });
    </script>
</body>

</html>