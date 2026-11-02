const fmt = (n, d=2) => Number(n).toLocaleString('es-AR', {minimumFractionDigits:d, maximumFractionDigits:d});

/* ============================================================
  esto sube los partidos a supabase, mejor no tocarlo
  ============================================================ */

async function upsertPlayerSmart(externalId, name) {
  // 1) ¿ya existe alguien con este id? (es lo normal)
  if (externalId) {
    const { data: porId } = await db
      .from('players')
      .select('id')
      .eq('external_player_id', externalId)
      .maybeSingle();
    if (porId) return porId;
  }

  // 2) ¿hay alguien con este nombre que todavía no tiene id vinculado?
  //    puede ser un jugador viejo que recién aparece con el sistema nuevo
  const { data: porNombre } = await db
    .from('players')
    .select('id')
    .eq('name', name)
    .is('external_player_id', null)
    .maybeSingle();

  if (porNombre) {
    // lo encontramos por nombre y le guardamos el id para la próxima vez
    const { data: actualizado, error } = await db
      .from('players')
      .update({ external_player_id: externalId })
      .eq('id', porNombre.id)
      .select()
      .single();
    if (error) { console.error('Error vinculando ID:', error); return porNombre; }
    return actualizado;
  }

  // 3) no existe: es un jugador nuevo
  const { data: creado, error } = await db
    .from('players')
    .insert({ name, external_player_id: externalId })
    .select()
    .single();
  if (error) { console.error('Error creando jugador:', error); return null; }
  return creado;
}

async function procesarArchivo(file) {
  const contenido = await file.text();

  try {
    const partido = JSON.parse(contenido);

    const { data: existente } = await db
      .from('matches')
      .select('id')
      .eq('source_filename', file.name)
      .maybeSingle();

    if (existente) {
      console.warn(`${file.name} ya fue cargado antes, se salteó.`);
      return { ok: false, motivo: 'duplicado', archivo: file.name };
    }

    const todosLosJugadores = [
      ...partido.team1PlayerStats,
      ...partido.team2PlayerStats,
      ...partido.noTeamPlayerStats
    ];

    const filasParaInsertar = todosLosJugadores.map(jugador => {
  return {
    position: jugador.postion,
    team: jugador.team,
    passes: jugador.passes,
    key_passes: jugador.keyPasses,
    assists: jugador.assists,
    shots: jugador.shots,
    shots_on_target: jugador.shotsOnTarget,
    goals: jugador.goals,
    tackles: jugador.tackles,
    key_tackles: jugador.keyTackles,
    interceptions: jugador.interceptions,
    key_interceptions: jugador.keyInterceptions,
    possessions_lost: jugador.possessionsLost,
    gk_saves: jugador.gKSaves,
    gk_catches: jugador.gKCatches,
    score: jugador.score,
    _playerName: jugador.playerName,
    _playerId: jugador.playerId   // sirve para guardar el jugador con su id real
  };
});

    const { data: matchInsertado, error: errorMatch } = await db
      .from('matches')
      .insert({
        source_filename: file.name,
        team1_name: partido.team1Stats.teamName,
        team2_name: partido.team2Stats.teamName,
        season_id: await getCurrentSeasonId()
      })
      .select()
      .single();

    if (errorMatch) {
      console.error('Error insertando el partido:', errorMatch);
      return { ok: false, motivo: 'error_match', archivo: file.name };
    }

        const matchId = matchInsertado.id;
    const filasFinales = [];

    for (const fila of filasParaInsertar) {
      const jugadorDb = await upsertPlayerSmart(fila._playerId, fila._playerName);

      if (!jugadorDb) {
        console.error('Error con jugador:', fila._playerName);
        continue;
      }

      const { _playerName, _playerId, ...datosLimpios } = fila;
      filasFinales.push({
        ...datosLimpios,
        match_id: matchId,
        player_id: jugadorDb.id
      });
    }

    const { data: statsInsertadas, error: errorStats } = await db
      .from('match_player_stats')
      .insert(filasFinales)
      .select();

    if (errorStats) {
      console.error('Error insertando stats:', errorStats);
      return { ok: false, motivo: 'error_stats', archivo: file.name };
    }

    console.log(`${file.name}: ${statsInsertadas.length} jugadores insertados.`);
    return { ok: true, archivo: file.name, jugadores: statsInsertadas.length };

  } catch (error) {
    console.error('Archivo inválido:', file.name, error);
    return { ok: false, motivo: 'json_invalido', archivo: file.name };
  }
}

async function subirArchivos(files, onProgress) {
  const archivos = Array.from(files);
  const detalle = [];

  for (let i = 0; i < archivos.length; i++) {
    const file = archivos[i];
    const resultado = await procesarArchivo(file);
    detalle.push(resultado);

    if (onProgress) onProgress(i + 1, archivos.length, resultado);
  }

  const resumen = {
    exitosos: detalle.filter(r => r.ok).length,
    saltados: detalle.filter(r => !r.ok && r.motivo === 'duplicado').length,
    fallidos: detalle.filter(r => !r.ok && r.motivo !== 'duplicado').length,
    detalle
  };

  console.log('Resumen de carga:', resumen);
  return resumen;
}

/* =======================================================================================
  esto trae lo que acabamos de mandar a supabase
  ======================================================================================= */

async function getMatchData(seasonId = null) {
  const sid = seasonId || await getCurrentSeasonId();

  const { data: ratings, error } = await db
    .from('player_ratings')
    .select('*')
    .eq('season_id', sid);

  if (error) {
    console.error('Error trayendo ratings:', error);
    return { gk: [], fp: [] };
  }

  const gk = ratings
    .filter(r => r.primary_role === 'GK')
    .map(r => ({
      name: r.name, pj: r.pj, passes: r.avg_passes, tackles: r.avg_tackles,
      interceptions: r.avg_interceptions, possessionsLost: r.avg_possessions_lost,
      gKSaves: r.avg_gk_saves, gKCatches: r.avg_gk_catches, score: r.avg_score, rating: r.rating
    }))
    .sort((a, b) => b.score - a.score);

  const fp = ratings
    .filter(r => r.primary_role === 'FIELD')
    .map(r => ({
      name: r.name, pj: r.pj, passes: r.avg_passes,
      shots: r.avg_shots, shotsOnTarget: r.avg_shots_on_target, goals: r.avg_goals,
      tackles: r.avg_tackles, interceptions: r.avg_interceptions, possessionsLost: r.avg_possessions_lost,
      score: r.avg_score, rating: r.rating
    }))
    .sort((a, b) => b.score - a.score);

  return { gk, fp };
}

function renderGoalkeepers(gk) {
  const body = document.getElementById('gk-body');
  body.innerHTML = '';

  if (!gk.length) {
    body.innerHTML = `<tr class="state-row"><td colspan="9">Todavía no hay arqueros cargados.</td></tr>`;
    return;
  }

  gk.forEach(p => {
    const tr = document.createElement('tr');
    tr.className = 'top-row';
    tr.innerHTML = `
      <td><div class="player-cell"><span class="star">★</span><span class="player-name">${p.name}</span></div></td>
      <td>${p.pj}</td>
      <td>${fmt(p.passes)}</td>
      <td>${fmt(p.tackles)}</td>
      <td>${fmt(p.interceptions)}</td>
      <td>${fmt(p.possessionsLost)}</td>
      <td>${fmt(p.gKSaves)}</td>
      <td>${fmt(p.gKCatches)}</td>
      <td class="score-cell">${fmt(p.score)}</td>
    `;
    body.appendChild(tr);
  });
}

function renderFieldPlayers(fp) {
  const body = document.getElementById('fp-body');
  body.innerHTML = '';

  if (!fp.length) {
    body.innerHTML = `<tr class="state-row"><td colspan="10">Todavía no hay jugadores de campo cargados.</td></tr>`;
    return;
  }

  fp.forEach((p, i) => {
    const tr = document.createElement('tr');
    if (i === 0) tr.className = 'top-row';
    tr.innerHTML = `
      <td><div class="player-cell">${i === 0 ? '<span class="star">★</span>' : ''}<span class="player-name">${p.name}</span></div></td>
      <td>${p.pj}</td>
      <td>${fmt(p.passes)}</td>
      <td>${fmt(p.shots)}</td>
      <td>${fmt(p.shotsOnTarget)}</td>
      <td>${fmt(p.goals)}</td>
      <td>${fmt(p.tackles)}</td>
      <td>${fmt(p.interceptions)}</td>
      <td>${fmt(p.possessionsLost)}</td>
      <td class="score-cell">${fmt(p.score)}</td>
    `;
    body.appendChild(tr);
  });
}

function mostrarLogueado(logueado) {
  loginEmail.hidden = logueado;
  loginPassword.hidden = logueado;
  loginSubmit.hidden = logueado;
  loginError.hidden = true;
  uploadBtn.disabled = !logueado;
  document.getElementById('closeSeasonBtn').disabled = !logueado;  // botón de cerrar temporada
  sessionTag.hidden = !logueado;
}

async function init() {
  try {
    await cargarSelectorDeTemporadas();
    const { gk, fp } = await getMatchData();
    renderGoalkeepers(gk);
    renderFieldPlayers(fp);
  } catch (err) {
    document.getElementById('gk-body').innerHTML =
      `<tr class="state-row"><td colspan="9">No se pudieron cargar los datos.</td></tr>`;
    document.getElementById('fp-body').innerHTML =
      `<tr class="state-row"><td colspan="10">No se pudieron cargar los datos.</td></tr>`;
    console.error(err);
  }
  estaLogueado().then(mostrarLogueado);
}

init();

/* =======================================================================================
  esta parte sí se puede tocar, porque maneja los botones
  en lo posible dejá los nombres de las funciones y las clases como están
  ======================================================================================= */

const loginEmail = document.getElementById('loginEmail');
const loginPassword = document.getElementById('loginPassword');
const loginSubmit = document.getElementById('loginSubmit');
const loginError = document.getElementById('loginError');
const uploadBtn = document.getElementById('uploadBtn');
const sessionTag = document.getElementById('sessionTag');

loginSubmit.addEventListener('click', async () => {
  const email = loginEmail.value.trim();
  const password = loginPassword.value;

  if (!email || !password) {
    loginError.textContent = 'Completá los dos campos.';
    loginError.hidden = false;
    return;
  }

  const ok = await login(email, password);

  if (!ok) {
    loginError.textContent = 'Email o contraseña incorrectos.';
    loginError.hidden = false;
    return;
  }

  loginEmail.value = '';
  loginPassword.value = '';
  mostrarLogueado(true);
});

loginPassword.addEventListener('keydown', (e) => {
  if (e.key === 'Enter') loginSubmit.click();
});

uploadBtn.addEventListener('click', () => {
  document.getElementById('fileInput').click();
});

sessionTag.addEventListener('click', async () => {
  await logout();
  mostrarLogueado(false);
});

document.getElementById('fileInput').addEventListener('change', async (event) => {
  const status = document.getElementById('uploadStatus');
  const statusText = document.getElementById('uploadStatusText');
  const total = event.target.files.length;

  uploadBtn.disabled = true;
  status.hidden = false;
  statusText.textContent = `Subiendo 0/${total}...`;

  const resumen = await subirArchivos(event.target.files, (actual, tot, resultado) => {
    statusText.textContent = `Subiendo ${actual}/${tot}... (${resultado.archivo})`;
  });

  statusText.textContent = `:^) ${resumen.exitosos} cargados · ${resumen.saltados} ya existían · ${resumen.fallidos} con error`;

  setTimeout(() => { status.hidden = true; }, 6000);

  const { gk, fp } = await getMatchData();
  renderGoalkeepers(gk);
  renderFieldPlayers(fp);

  uploadBtn.disabled = false;
  event.target.value = '';
});

async function login(email, password) {
  const { error } = await db.auth.signInWithPassword({ email, password });
  if (error) {
    console.error('Error de login:', error.message);
    return false;
  }
  return true;
}

async function estaLogueado() {
  const { data: { session } } = await db.auth.getSession();
  return !!session;
}

async function logout() {
  await db.auth.signOut();
}

async function getCurrentSeasonId() {
  const { data } = await db.from('seasons').select('id').eq('is_current', true).single();
  return data ? data.id : null;
}

async function getSeasons() {
  const { data } = await db.from('seasons').select('*').order('started_at', { ascending: false });
  return data || [];
}

async function cerrarTemporada() {
  const { data: temporadas } = await db.from('seasons').select('name');

  // buscamos el número más alto y le sumamos uno.
  // así no se repite el nombre de una temporada.
  const numeros = (temporadas || [])
    .map(t => parseInt(String(t.name).replace(/\D/g, ''), 10))
    .filter(n => !isNaN(n));
  const siguienteNumero = numeros.length ? Math.max(...numeros) + 1 : 1;
  const nombreNueva = `Temporada ${siguienteNumero}`;

  const { data: actual } = await db.from('seasons').select('id').eq('is_current', true).single();

  if (actual) {
    const { error: errorCierre } = await db
      .from('seasons')
      .update({ is_current: false, ended_at: new Date().toISOString() })
      .eq('id', actual.id);

    if (errorCierre) {
      console.error('Error cerrando temporada:', errorCierre);
      return null;
    }
  }

  const { data: nueva, error: errorNueva } = await db
    .from('seasons')
    .insert({ name: nombreNueva, is_current: true })
    .select()
    .single();

  if (errorNueva) {
    console.error('Error creando temporada nueva:', errorNueva);
    return null;
  }

  return nueva;
}

document.getElementById('closeSeasonBtn').addEventListener('click', async () => {
  const confirmado = confirm('¿Seguro que querés cerrar la temporada? Se archiva todo lo actual y arranca una nueva, vacía.');
  if (!confirmado) return;

  const nueva = await cerrarTemporada();
  if (!nueva) {
    alert('Hubo un error cerrando la temporada.');
    return;
  }

  alert(`Temporada cerrada. Arrancó: ${nueva.name}`);

  await cargarSelectorDeTemporadas();
  const { gk, fp } = await getMatchData();
  renderGoalkeepers(gk);
  renderFieldPlayers(fp);
});

async function cargarSelectorDeTemporadas() {
  const temporadas = await getSeasons();
  const select = document.getElementById('seasonSelect');
  select.innerHTML = '<option value="">Viendo la temporada actual</option>';

  temporadas
    .filter(t => !t.is_current)
    .forEach(t => {
      const opt = document.createElement('option');
      opt.value = t.id;
      opt.textContent = t.name;
      select.appendChild(opt);
    });
}

document.getElementById('seasonSelect').addEventListener('change', async (event) => {
  const seasonId = event.target.value || null;
  const { gk, fp } = await getMatchData(seasonId);
  renderGoalkeepers(gk);
  renderFieldPlayers(fp);
});
