const contactForm = document.getElementById('contactForm');
const formFeedback = document.getElementById('formFeedback');
const formSubmitBtn = document.getElementById('formSubmitBtn');
const formTextoOriginal = formSubmitBtn.textContent;

/* ----------------------------------------------------------------
   ENFRIAMIENTO ANTI-SPAM: después de mandar un mensaje, el botón
   queda bloqueado este tiempo (en segundos) antes de poder mandar
   otro. Se guarda en localStorage así sobrevive a un F5.
   EDITAR: cambiá este número si querés más o menos tiempo.
   ---------------------------------------------------------------- */
const ENFRIAMIENTO_SEG = 60;
const CLAVE_ENFRIAMIENTO = 'contactoUltimoEnvio';

let temporizadorEnfriamiento = null;

function segundosRestantes() {
  const ultimo = Number(localStorage.getItem(CLAVE_ENFRIAMIENTO)) || 0;
  const pasaron = (Date.now() - ultimo) / 1000;
  return Math.max(0, Math.ceil(ENFRIAMIENTO_SEG - pasaron));
}

function actualizarBotonEnfriamiento() {
  const restantes = segundosRestantes();

  if (restantes <= 0) {
    clearInterval(temporizadorEnfriamiento);
    temporizadorEnfriamiento = null;
    formSubmitBtn.disabled = false;
    formSubmitBtn.textContent = formTextoOriginal;
    return;
  }

  formSubmitBtn.disabled = true;
  formSubmitBtn.textContent = `Esperá ${restantes}s…`;
}

function iniciarEnfriamiento() {
  localStorage.setItem(CLAVE_ENFRIAMIENTO, String(Date.now()));
  actualizarBotonEnfriamiento();
  if (!temporizadorEnfriamiento) {
    temporizadorEnfriamiento = setInterval(actualizarBotonEnfriamiento, 1000);
  }
}

// si ya venía enfriándose de antes (por ejemplo, recargaron la página), seguimos desde ahí
if (segundosRestantes() > 0) {
  actualizarBotonEnfriamiento();
  temporizadorEnfriamiento = setInterval(actualizarBotonEnfriamiento, 1000);
}

contactForm.addEventListener('submit', async (e) => {
  e.preventDefault();

  if (segundosRestantes() > 0) return; // por si tocan Enter mientras está bloqueado

  formSubmitBtn.disabled = true;
  formFeedback.hidden = true;

  try {
    const respuesta = await fetch(contactForm.action, {
      method: 'POST',
      body: new FormData(contactForm),
      headers: { 'Accept': 'application/json' }
    });

    if (!respuesta.ok) throw new Error('Formspree respondió con error');

    formFeedback.textContent = '¡Listo! Recibimos tu mensaje, te respondemos pronto.';
    formFeedback.hidden = false;
    contactForm.reset();
    iniciarEnfriamiento();
  } catch (err) {
    console.error('Error enviando el formulario:', err);
    formFeedback.textContent = 'Hubo un problema enviando el mensaje. Probá de nuevo o escribinos directo por Discord.';
    formFeedback.hidden = false;
    formSubmitBtn.disabled = false;
  }
});
