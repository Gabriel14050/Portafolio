const formContainer = document.querySelector('.form');
const content = document.querySelector('.content');

function adjustFormPosition() {
    if (window.innerWidth <= 768) {
        content.appendChild(formContainer);
    } else {
        document.body.appendChild(formContainer);
    }
}

// Llamar a la función al cargar la página y al cambiar el tamaño de la ventana
adjustFormPosition();
window.addEventListener('resize', adjustFormPosition);
