const dropdownBtn = document.querySelector('.dropdown-btn');

if (dropdownBtn) { // Verificar que el elemento existe antes de añadir el event listener
    dropdownBtn.addEventListener('click', function () {
        const menu = document.querySelector('.menu .dropdown .contenido');
        const iconoMenu = document.querySelector('.menu .dropdown .icono-menu');
        const iconoClose = document.querySelector('.menu .dropdown .icono-close');
        
        if (menu) { // Verificar que el menú existe
            const visibilidadMenu = menu.style.display === 'block';
            menu.style.display = visibilidadMenu ? 'none' : 'block';

            iconoMenu.style.display = visibilidadMenu ? 'block' : 'none';
            iconoClose.style.display = visibilidadMenu ? 'none' : 'block';
        }
    });
} else {
    console.warn("El botón de desplegable no existe."); // Opcional: Mensaje en consola si no existe
}
