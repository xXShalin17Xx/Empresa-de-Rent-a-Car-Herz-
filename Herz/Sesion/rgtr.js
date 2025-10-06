
  document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('container');
    const toggleBtn = document.getElementById('toggleBtn');
    const switchTitle = document.querySelector('.switch h2');
    const switchParagraph = document.querySelector('.switch p');

    let isRegisterMode = true; // Porque venimos desde register.php

    // Activar vista de registro al cargar
    container.classList.add('register-mode');
    if (toggleBtn) toggleBtn.textContent = 'Iniciar Sesión';
    if (switchTitle) switchTitle.textContent = '¿Ya tienes una cuenta? ¡Vamos por tu auto!';
    if (switchParagraph) switchParagraph.textContent = 'Inicia sesión para continuar con tu reserva';

    // Escuchar clic para cambiar entre modos
    toggleBtn.addEventListener('click', () => {
      isRegisterMode = !isRegisterMode;

      if (isRegisterMode) {
        container.classList.add('register-mode');
        toggleBtn.textContent = 'Iniciar Sesión';
        switchTitle.textContent = '¿Ya tienes una cuenta? ¡Vamos por tu auto!';
        switchParagraph.textContent = 'Inicia sesión para continuar con tu reserva';
      } else {
        container.classList.remove('register-mode');
        toggleBtn.textContent = 'Registrarse';
        switchTitle.textContent = '¿Nuevo por aquí?';
        switchParagraph.textContent = 'Crea una cuenta para comenzar a reservar tu próximo vehículo';
      }
    });
  });

