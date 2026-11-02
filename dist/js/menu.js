/* ---------- menú mobile, va en todas las páginas ---------- */
const navToggle = document.getElementById('navToggle');
const navMenu = document.getElementById('navMenu');
navToggle.addEventListener('click', () => {
  const abierto = navMenu.classList.toggle('open');
  navToggle.setAttribute('aria-expanded', abierto);
});
