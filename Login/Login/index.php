<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <!-- Enlaza tu archivo CSS aquí -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/demas.css">
    <!-- Incluye tu archivo JavaScript aquí si es necesario -->
    <script src="js/login.js"></script>
    
</head>

<body>
    <div class="main">
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">Sistemas y Gestión de Datos</h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="#">Inicio </a></li>
                </ul>
            </div>
            
        </div>
        <div style="padding-top: 30%;" class="content">
           
            

            <div class="form">
                <h2>Iniciar sesión</h2>
                <form action="login.php" method="post">
                    Usuario: <input type="text" name="usuario"><br>
                    Contraseña: <input type="password" name="contrasena"><br>
                    <input type="submit" value="Iniciar sesión">
                </form>

                <p class="link">¿No tienes una cuenta?<br>
                    <a href="registrarse.php">Regístrate aquí</a>
                </p>
                <p class="liw">Inicia sesión con:</p>

                <div class="icons">
                    <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-google"></ion-icon></a>
                    <a href="#"><ion-icon name="logo-skype"></ion-icon></a>
                </div>
            </div>
        </div>

      
       
        

       

    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script> <!-- Incluye Ionicons para los iconos -->
</body>
<footer>
            <p>&copy; 2024 Sistemas y Gestión de Datos - Todos los derechos reservados</p>
        </footer>
    </div>

</html>
