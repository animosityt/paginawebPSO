<?php
$pageTitle    = 'Tabla de promedios · Arqueros y jugadores de campo · Cancha Grande';
$pageDesc     = 'Promedios por partido de arqueros y jugadores de campo de la comunidad de Pro Soccer Online: pases, tiros, goles, tackles, intercepciones, atajadas y score, por temporada.';
$paginaActiva = 'tabla';
$usaSupabase  = true;
$paginaJs     = ['tabla'];
require __DIR__ . '/includes/head.php';
?>
<?php require __DIR__ . '/includes/nav.php'; ?>

<!-- ===== barra de admin: login + carga de partidos ===== -->
<aside class="admin-bar" aria-label="Panel de administración">
  <span class="admin-bar-label">Panel de administración</span>

  <div class="navbar-right">
    <div class="nav-login">
      <div class="nav-login-fields">
        <input type="email" id="loginEmail" placeholder="Email" autocomplete="username">
        <input type="password" id="loginPassword" placeholder="Contraseña" autocomplete="current-password">
      </div>
      <button class="login-submit" id="loginSubmit">Entrar</button>
      <span class="login-error" id="loginError" hidden></span>
    </div>

    <div class="nav-actions">
      <input type="file" id="fileInput" multiple accept=".txt" style="display:none">
      <button class="btn-upload" id="uploadBtn" disabled>Subir partido</button>
      <button class="btn-upload" id="closeSeasonBtn" disabled>Cerrar temporada</button>
      <span class="upload-status" id="uploadStatus" hidden>
        <span class="spinner"></span>
        <span id="uploadStatusText"></span>
      </span>
      <span class="session-tag" id="sessionTag" hidden>Cerrar sesión</span>
    </div>
  </div>
</aside>

<main id="contenido" class="wrap">


  <div class="cabecera">
    <header>
      <h1>Tabla de<br>Promedios</h1>
    </header>
    <figure class="pizarra-trofeo">
      <span class="cinta cinta-a"></span><span class="cinta cinta-b"></span>
      <div class="trofeo-hero">
        <div class="trofeo">
          <img class="trofeo-glow" src="images/trofeo.svg" alt="" aria-hidden="true">
          <img class="trofeo-base" src="images/trofeo.svg" alt="Trofeo UEFA Champions League">
          <span class="trofeo-glint"></span>
          <span class="spark s1"></span><span class="spark s2"></span><span class="spark s3"></span>
        </div>
      </div>
      <figcaption>            ★ ★ ★ ★ ★            </figcaption>
    </figure>
  </div>

  <div class="methodology">
    <h2>Sobre la valoración</h2>
    <p>Los arqueros tienen su propia tabla porque en el juego su desempeño es diferente al de los jugadores de campo, supuestamente consiguen un x1.2 mas de puntos por el multiplicador
      añadido en las stats de capturas y atajadas.</p>
  </div>

  <div class="methodology season-picker" id="seasonPicker">
    <h2>Temporadas anteriores</h2>
    <select id="seasonSelect">
      <option value="">Viendo la temporada actual</option>
    </select>
  </div>

  <section class="block goalkeeper-block">
    <div class="block-head">
      <div class="block-title">
        <h2>Arqueros</h2>
      </div>
    </div>
    <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th>Jugador</th>
            <th>Partidos</th>
            <th>Pases</th>
            <th>Tackles</th>
            <th>Intercep.</th>
            <th>Poses. Perd.</th>
            <th>Atajadas</th>
            <th>Capturas</th>
            <th>Score</th>
          </tr>
        </thead>
        <tbody id="gk-body">
          <tr class="state-row"><td colspan="9"><span class="spinner"></span>Cargando arqueros…</td></tr>
        </tbody>
      </table>
    </div>
  </section>

  <section class="block">
    <div class="block-head">
      <div class="block-title">
        <h2>Jugadores de Campo</h2>
      </div>
    </div>
    <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th>Jugador</th>
            <th>Partidos</th>
            <th>Pases</th>
            <th>Tiros</th>
            <th>Tiros al Arco</th>
            <th>Goles</th>
            <th>Tackles</th>
            <th>Intercep.</th>
            <th>Poses. Perd.</th>
            <th>Score</th>
          </tr>
        </thead>
        <tbody id="fp-body">
          <tr class="state-row"><td colspan="10"><span class="spinner"></span>Cargando jugadores de campo…</td></tr>
        </tbody>
      </table>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
