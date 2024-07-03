<?php
$servidor = "localhost";
$usuario_db = "";
$password_db = "";
$base_datos = "";

// Conexión a la base de datos
$conexion = mysqli_connect($servidor, $usuario_db, $password_db, $base_datos);

if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}
?>