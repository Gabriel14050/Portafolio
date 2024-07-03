<?php
require_once 'conexion.php';
session_start(); // Iniciar la sesión

// Verificar si se recibieron los datos del formulario para iniciar sesión
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    // Obtener datos del formulario
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

    // Consulta para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contrasena='$contrasena'";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_assoc($resultado);
        $_SESSION['usuario'] = $fila['usuario']; // Almacenar el nombre de usuario en la sesión

        if ($fila['rol'] == 'admin') {
            header("Location: admin.php"); 
        } else {
            header("Location: usuario.php"); 
        }
        exit(); 
    } // En login.php
    else {
        echo "<script>alert('Credenciales incorrectas'); window.location.href = 'index.php';</script>";
        exit();
    }
    
    

    mysqli_close($conexion);
} 
// Verificar si se recibió la solicitud de cerrar sesión

?>