const listaOfertas = document.getElementById('lista-ofertas');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const ofertaWidth = document.querySelector('.estilo-oferta').offsetWidth + 20; // Ancho de cada oferta + gap
    let currentPosition = 0;

    nextBtn.addEventListener('click', () => {
        const maxScrollPosition = listaOfertas.scrollWidth - listaOfertas.clientWidth;
        if (currentPosition < maxScrollPosition) {
            currentPosition += ofertaWidth * 3;
            if (currentPosition > maxScrollPosition) {
                currentPosition = maxScrollPosition; // Limitar al final
            }
            listaOfertas.style.transform = `translateX(-${currentPosition}px)`;
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentPosition > 0) {
            currentPosition -= ofertaWidth * 3;
            if (currentPosition < 0) {
                currentPosition = 0; // Limitar al inicio
            }
            listaOfertas.style.transform = `translateX(-${currentPosition}px)`;
    }
});