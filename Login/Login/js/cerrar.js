// Este script se puede incluir en la página de inicio para cerrar sesión automáticamente al volver a la página

// Función para cerrar sesión al cargar la página de inicio
function cerrarSesion() {
    // Envía una solicitud GET al script de cierre de sesión
    fetch('controllers/cerrar_sesion.php')
    .then(response => {
        if (response.ok) {
            // Si la solicitud se realiza con éxito, redirige al usuario a la página de inicio
            window.location.href = 'index.php';
        } else {
            console.error('Error al cerrar sesión');
        }
    })
    .catch(error => {
        console.error('Error de red:', error);
    });
}

// Llama a la función para cerrar sesión cuando la página se cargue completamente
document.addEventListener('DOMContentLoaded', cerrarSesion);
