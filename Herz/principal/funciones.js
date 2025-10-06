document.addEventListener('DOMContentLoaded', function () {
  const slides = Array.from(document.querySelectorAll('.slide'));
  const btnPrev = document.getElementById('btn-prev');
  const btnNext = document.getElementById('btn-next');
  const dotsContainer = document.getElementById('carousel-dots');
  const descriptionEl = document.getElementById('descripcion-texto');
  

  let visibleSlides = slides.filter(s => !s.classList.contains('hidden'));
  let currentIndex = 0;
  let autoplayTimer = null;
  const AUTOPLAY_INTERVAL = 4000;

  function updateVisibleSlides() {
    visibleSlides = slides.filter(s => !s.classList.contains('hidden'));
    if (visibleSlides.length === 0) {
      currentIndex = 0;
      renderDots();
      render();
      return;
    }
    if (currentIndex >= visibleSlides.length) currentIndex = 0;
    renderDots();
    render();
  }

  function render() {
    slides.forEach(s => s.classList.remove('active'));
    if (visibleSlides.length === 0) return;
    const activeSlide = visibleSlides[currentIndex];
    activeSlide.classList.add('active');

    
    const descripcion = activeSlide.dataset.descripcion || "(Descripción no disponible)";
    descriptionEl.textContent = descripcion;

    updateDotsActive(currentIndex);
  }

  function next() {
    if (visibleSlides.length === 0) return;
    currentIndex = (currentIndex + 1) % visibleSlides.length;
    render();
  }

  function prev() {
    if (visibleSlides.length === 0) return;
    currentIndex = (currentIndex - 1 + visibleSlides.length) % visibleSlides.length;
    render();
  }

  function startAutoplay() {
    stopAutoplay();
    autoplayTimer = setInterval(next, AUTOPLAY_INTERVAL);
  }
  function stopAutoplay() {
    if (autoplayTimer) { clearInterval(autoplayTimer); autoplayTimer = null; }
  }

  function renderDots() {
    dotsContainer.innerHTML = '';
    for (let i = 0; i < visibleSlides.length; i++) {
      const btn = document.createElement('button');
      btn.setAttribute('aria-label', 'Ir al slide ' + (i + 1));
      if (i === currentIndex) btn.classList.add('active');
      btn.addEventListener('click', () => {
        currentIndex = i;
        render();
        startAutoplay();
      });
      dotsContainer.appendChild(btn);
    }
  }

  function updateDotsActive(i) {
    const dots = Array.from(dotsContainer.children);
    dots.forEach(d => d.classList.remove('active'));
    if (dots[i]) dots[i].classList.add('active');
  }

  btnNext.addEventListener('click', () => { next(); startAutoplay(); });
  btnPrev.addEventListener('click', () => { prev(); startAutoplay(); });

  const carouselEl = document.getElementById('carousel');
  carouselEl.addEventListener('mouseenter', stopAutoplay);
  carouselEl.addEventListener('mouseleave', startAutoplay);

  updateVisibleSlides();
  startAutoplay();

  window.filtrar = function (tipoRaw) {
    const tipo = String(tipoRaw || 'all').toLowerCase();
    const key = tipo.replace(/\s+/g, '');
    slides.forEach(s => {
      const sType = (s.dataset.type || '').toLowerCase();
      if (key === 'all' || key === '') {
        s.classList.remove('hidden');
      } else {
        (sType === key) ? s.classList.remove('hidden') : s.classList.add('hidden');
      }
    });
    currentIndex = 0;
    updateVisibleSlides();
  };
});
