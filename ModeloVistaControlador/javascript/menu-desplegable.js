document.querySelector('.dropdown-btn').addEventListener('click', function () {
   const menu = document.querySelector('.menu .dropdown .contenido');
   const iconoMenu = document.querySelector('.menu .dropdown .icono-menu');
   const iconoClose = document.querySelector('.menu .dropdown .icono-close');
   if (menu) {
        const visibilidadMenu = menu.style.display === 'block';
        menu.style.display = visibilidadMenu ? 'none' : 'block';

        iconoMenu.style.display = visibilidadMenu ? 'block' : 'none';
        iconoClose.style.display = visibilidadMenu ? 'none' : 'block';
        
        
   }
});
