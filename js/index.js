/* ---------- intro, una sola vez por sesión ---------- */
const introOverlay = document.getElementById('introOverlay');
const cerrarIntro = () => introOverlay.classList.add('intro-overlay-hidden');

let intoYaVista = false;
try { intoYaVista = sessionStorage.getItem('introVista') === '1'; } catch (e) {}

if (intoYaVista) {
  introOverlay.remove();
} else {
  try { sessionStorage.setItem('introVista', '1'); } catch (e) {}
  setTimeout(cerrarIntro, 5000);
  introOverlay.addEventListener('click', cerrarIntro);
  introOverlay.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') cerrarIntro();
  });
}

/* ---------- números rápidos, vienen de supabase ---------- */
async function cargarNumeros() {
  try {
    const { data: temporada } = await db
      .from('seasons').select('id, name').eq('is_current', true).single();

    if (temporada) {
      document.getElementById('statTemporada').textContent =
        (temporada.name || '').replace(/\D/g, '') || '0';
    }

    const { count: partidos } = await db
      .from('matches').select('id', { count: 'exact', head: true })
      .eq('season_id', temporada ? temporada.id : null);

    const { count: jugadores } = await db
      .from('players').select('id', { count: 'exact', head: true });

    document.getElementById('statPartidos').textContent = partidos ?? '—';
    document.getElementById('statJugadores').textContent = jugadores ?? '—';
  } catch (err) {
    console.error('No se pudieron cargar los números:', err);
  }
}

cargarNumeros();
