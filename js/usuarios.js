const BUCKET_AVATARES = 'avatars';
const CLAVE_SESION_PERFIL = 'perfilActivo'; // lo que guardamos en localStorage: { id, username }

const escapar = (s) => String(s).replace(/[&<>"']/g, c => (
  {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]
));

function iniciales(nombre) {
  return String(nombre).trim().split(/\s+/).slice(0,2).map(p => p[0] || '').join('').toUpperCase();
}

function urlAvatar(path) {
  if (!path) return null;
  return `${SUPABASE_URL}/storage/v1/object/public/${BUCKET_AVATARES}/${path}`;
}

function pinValido(pin) {
  return /^[0-9]{6}$/.test(pin);
}

function mostrarFeedback(el, texto, esError = false) {
  el.textContent = texto;
  el.hidden = false;
  el.style.color = esError ? '#ff9d9d' : '';
}

/* ================================================================
   SESIÓN DEL PERFIL (no es Supabase Auth: es un login propio con PIN,
   guardado en este navegador. La clave NUNCA se guarda, solo se pide
   de nuevo cuando hace falta confirmar un cambio)
   ================================================================ */

function getPerfilActivo() {
  try { return JSON.parse(localStorage.getItem(CLAVE_SESION_PERFIL)); }
  catch { return null; }
}

function setPerfilActivo(perfil) {
  localStorage.setItem(CLAVE_SESION_PERFIL, JSON.stringify(perfil));
}

function limpiarPerfilActivo() {
  localStorage.removeItem(CLAVE_SESION_PERFIL);
}

function pintarEstadoSesion() {
  const perfil = getPerfilActivo();
  const anonimo = document.getElementById('perfilAnonimo');
  const logueado = document.getElementById('perfilLogueado');

  if (!perfil) {
    anonimo.hidden = false;
    logueado.hidden = true;
    return;
  }

  anonimo.hidden = true;
  logueado.hidden = false;
  document.getElementById('miNombre').textContent = perfil.username;

  const preview = document.getElementById('miAvatarPreview');
  const inicialesSpan = document.getElementById('miAvatarIniciales');
  preview.querySelector('img')?.remove();

  if (perfil.avatar_path) {
    const img = document.createElement('img');
    img.src = urlAvatar(perfil.avatar_path);
    img.alt = '';
    img.onerror = () => img.remove();
    preview.appendChild(img);
    inicialesSpan.style.opacity = '0';
  } else {
    inicialesSpan.style.opacity = '1';
  }
  inicialesSpan.textContent = iniciales(perfil.username);

  document.getElementById('editarPuesto').value = perfil.puesto || '';
}

/* ================================================================
   TABS CREAR / ENTRAR
   ================================================================ */

document.getElementById('profileTabs').addEventListener('click', (e) => {
  const chip = e.target.closest('.chip');
  if (!chip) return;
  document.querySelectorAll('#profileTabs .chip').forEach(c => c.classList.remove('active'));
  chip.classList.add('active');
  const esCrear = chip.dataset.tab === 'crear';
  document.getElementById('formCrear').hidden = !esCrear;
  document.getElementById('formEntrar').hidden = esCrear;
  document.getElementById('perfilFeedbackAnonimo').hidden = true;
});

/* ================================================================
   CREAR PERFIL
   ================================================================ */

document.getElementById('formCrear').addEventListener('submit', async (e) => {
  e.preventDefault();
  const feedback = document.getElementById('perfilFeedbackAnonimo');
  feedback.hidden = true;

  const username = document.getElementById('crearNombre').value.trim();
  const pin = document.getElementById('crearPin').value;
  const pinConfirma = document.getElementById('crearPinConfirma').value;
  const puesto = document.getElementById('crearPuesto').value || null;

  if (!pinValido(pin)) return mostrarFeedback(feedback, 'La clave tiene que ser de 6 números.', true);
  if (pin !== pinConfirma) return mostrarFeedback(feedback, 'Las dos claves no coinciden.', true);

  const btn = document.getElementById('crearBtn');
  btn.disabled = true;

  const { data, error } = await db.rpc('crear_perfil', {
    p_username: username,
    p_pin: pin,
    p_puesto: puesto
  });

  btn.disabled = false;

  if (error) { mostrarFeedback(feedback, error.message || 'No se pudo crear el perfil.', true); return; }

  const perfil = Array.isArray(data) ? data[0] : data;
  setPerfilActivo({ id: perfil.id, username: perfil.username, puesto: perfil.puesto, avatar_path: perfil.avatar_path });
  pintarEstadoSesion();
  cargarMiembros();
});

/* ================================================================
   INICIAR SESIÓN
   ================================================================ */

document.getElementById('formEntrar').addEventListener('submit', async (e) => {
  e.preventDefault();
  const feedback = document.getElementById('perfilFeedbackAnonimo');
  feedback.hidden = true;

  const username = document.getElementById('entrarNombre').value.trim();
  const pin = document.getElementById('entrarPin').value;

  const btn = document.getElementById('entrarBtn');
  btn.disabled = true;

  const { data, error } = await db.rpc('iniciar_sesion_perfil', {
    p_username: username,
    p_pin: pin
  });

  btn.disabled = false;

  if (error) { mostrarFeedback(feedback, 'Nombre o clave incorrectos.', true); return; }

  const perfil = Array.isArray(data) ? data[0] : data;
  setPerfilActivo({ id: perfil.id, username: perfil.username, puesto: perfil.puesto, avatar_path: perfil.avatar_path });
  document.getElementById('formEntrar').reset();
  pintarEstadoSesion();
});

/* ================================================================
   CERRAR SESIÓN
   ================================================================ */

document.getElementById('cerrarSesionPerfilBtn').addEventListener('click', () => {
  limpiarPerfilActivo();
  document.getElementById('formCrear').reset();
  document.getElementById('formEntrar').reset();
  document.getElementById('formEditar').reset();
  document.getElementById('perfilFeedbackLogueado').hidden = true;
  pintarEstadoSesion();
});

/* ================================================================
   EDITAR PERFIL (foto + puesto), pide la clave de nuevo para confirmar
   ================================================================ */

document.getElementById('formEditar').addEventListener('submit', async (e) => {
  e.preventDefault();
  const feedback = document.getElementById('perfilFeedbackLogueado');
  feedback.hidden = true;

  const perfil = getPerfilActivo();
  if (!perfil) return;

  const pin = document.getElementById('editarPin').value;
  if (!pinValido(pin)) return mostrarFeedback(feedback, 'La clave tiene que ser de 6 números.', true);

  const puesto = document.getElementById('editarPuesto').value || null;
  const archivo = document.getElementById('editarFoto').files[0];

  const btn = document.getElementById('editarBtn');
  btn.disabled = true;

  let avatarPath = null;

  try {
    if (archivo) {
      if (archivo.size > 3 * 1024 * 1024) throw new Error('La foto pesa más de 3MB.');

      const ext = (archivo.name.split('.').pop() || 'png').toLowerCase();
      avatarPath = `${perfil.id}-${Date.now()}.${ext}`;

      const { error: errorSubida } = await db.storage
        .from(BUCKET_AVATARES)
        .upload(avatarPath, archivo, { upsert: true, contentType: archivo.type });

      if (errorSubida) throw new Error('No se pudo subir la foto: ' + errorSubida.message);
    }

    const { data, error } = await db.rpc('editar_perfil', {
      p_id: perfil.id,
      p_pin: pin,
      p_puesto: puesto,
      p_avatar_path: avatarPath
    });

    if (error) throw new Error(error.message || 'Clave incorrecta.');

    const actualizado = Array.isArray(data) ? data[0] : data;
    setPerfilActivo({ id: actualizado.id, username: actualizado.username, puesto: actualizado.puesto, avatar_path: actualizado.avatar_path });

    document.getElementById('editarPin').value = '';
    document.getElementById('editarFoto').value = '';
    mostrarFeedback(feedback, 'Listo, se guardaron los cambios.');
    pintarEstadoSesion();
    cargarMiembros();
  } catch (err) {
    console.error(err);
    mostrarFeedback(feedback, err.message || 'Hubo un error guardando los cambios.', true);
  } finally {
    btn.disabled = false;
  }
});

/* ================================================================
   GRILLA DE MIEMBROS (pública, sale de Supabase)
   ================================================================ */

async function cargarMiembros() {
  const grid = document.getElementById('miembrosGrid');
  const { data, error } = await db.rpc('listar_perfiles');

  if (error) {
    console.error('Error cargando miembros:', error);
    grid.innerHTML = '<div class="cards-empty">No se pudieron cargar los miembros.</div>';
    return;
  }

  if (!data || !data.length) {
    grid.innerHTML = '<div class="cards-empty">Todavía no hay nadie con perfil. ¡Sé el primero!</div>';
    return;
  }

  grid.innerHTML = data.map(m => {
    const foto = urlAvatar(m.avatar_path);
    const avatarHtml = foto
      ? `<img src="${foto}" alt="" onerror="this.remove()">`
      : `<span>${escapar(iniciales(m.username))}</span>`;

    return `
      <article class="user-card">
        <div class="user-avatar">${avatarHtml}</div>
        <div class="user-meta">
          <span class="user-name">${escapar(m.username)}</span>
          <span class="user-role">${escapar(m.puesto || 'Sin puesto definido')}</span>
          <span class="badge badge-user">Miembro</span>
        </div>
      </article>
    `;
  }).join('');
}

pintarEstadoSesion();
cargarMiembros();
