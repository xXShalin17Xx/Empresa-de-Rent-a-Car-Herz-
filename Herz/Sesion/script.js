  const container = document.getElementById('container');
  const toggleBtn = document.getElementById('toggleBtn');

  let isRegisterMode = false;
  

  toggleBtn.addEventListener('click', () => {
    isRegisterMode = !isRegisterMode;
    if (isRegisterMode) {
      container.classList.add('register-mode');
      toggleBtn.textContent = 'Iniciar Sesión';
      document.querySelector('.switch h2').textContent = '¿Ya tienes una cuenta? ¡Vamos por tu auto!';
      document.querySelector('.switch p').textContent = 'Inicia sesión para continuar con tu reserva';
    } else {
      container.classList.remove('register-mode');
      toggleBtn.textContent = 'Registrarse';
      document.querySelector('.switch h2').textContent = '¿Nuevo por aquí?';
      document.querySelector('.switch p').textContent = 'Crea una cuenta para comenzar a reservar tu próximo vehículo';
    }
  });