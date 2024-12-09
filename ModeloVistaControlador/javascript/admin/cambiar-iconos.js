// Seleccionamos todos los botones con la clase "btn-enter"
const buttons = document.querySelectorAll(".btn-enter");

buttons.forEach(button => {
  const normal_icon = button.querySelector(".normal-icon"); // Icono normal dentro del botón
  const hover_icon = button.querySelector(".hover-icon"); // Icono hover dentro del botón

  // Verificamos si los iconos existen para evitar errores
  if (normal_icon && hover_icon) {
    // Inicialmente, mostramos el icono normal y ocultamos el hover
    normal_icon.classList.remove("hidden");
    hover_icon.classList.add("hidden");

    // Cambiar entre los iconos al hacer clic
    button.addEventListener("click", () => {
      // Usamos setTimeout para darle tiempo a la transición de colapso
      const panel = button.closest('.btn-toggle-nav').querySelector('.collapse');
      
      if (panel) {
        // Escuchamos el evento 'transitionend' para saber cuando termina la transición
        panel.addEventListener('transitionend', () => {
          if (panel.classList.contains('show')) {
            normal_icon.classList.remove("hidden");
            hover_icon.classList.add("hidden");
          } else {
            normal_icon.classList.add("hidden");
            hover_icon.classList.remove("hidden");
          }
        });
      }

      // Cambiar el icono directamente al hacer clic
      if (normal_icon.classList.contains("hidden")) {
        normal_icon.classList.remove("hidden");
        hover_icon.classList.add("hidden");
      } else {
        hover_icon.classList.remove("hidden");
        normal_icon.classList.add("hidden");
      }
    });
  }
});
