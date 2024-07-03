<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/reg.css">
    <link rel="stylesheet" href="css/demas.css">
    <script src="js/login.js"></script>
</head>
<body>
    <div class="main">
        <div style="padding-top: 400px;" class="content">
            <div class="form">
                <h2>Regístrate.</h2>
                <form action="controllers/registrarse_usuario.php" method="post">
                    Usuario: <input type="text" name="usuario" required><br>
                    Contraseña: <input type="password" name="contrasena" required><br>
                    <input type="submit" value="Registrarse" >
                </form>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    <footer>
        <p>&copy; 2024 Sistemas y Gestión de Datos - Todos los derechos reservados</p>
    </footer>
</body>
</html>
