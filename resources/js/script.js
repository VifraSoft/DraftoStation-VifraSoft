document.addEventListener('DOMContentLoaded', () => {
  const playButton = document.querySelector('#Jugar button');
  const mensaje = document.getElementById('mensaje');

  playButton.addEventListener('click', () => {
    // Mostrar el alert
    mensaje.classList.remove('d-none');
    // Cambiar texto del botón
    playButton.textContent = '¡Partida iniciada!';
    playButton.disabled = true;
  });
});