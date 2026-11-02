<?php
$pageTitle    = 'Cancha Grande · Estadísticas de Pro Soccer Online';
$pageDesc     = 'Estadísticas, promedios y valoraciones de la comunidad de Pro Soccer Online.';
$paginaActiva = 'index';
$usaSupabase  = true;
$paginaJs     = ['index'];
require __DIR__ . '/includes/head.php';
?>
<!-- ===== intro, aparece una vez por sesión ===== -->
<div class="intro-overlay" id="introOverlay" role="button" tabindex="0" aria-label="Saltar introducción">
  <div class="trofeo-hero intro-trophy">
    <div class="trofeo">
      <img class="trofeo-glow" src="images/trofeo.svg" alt="" aria-hidden="true">
      <img class="trofeo-base" src="images/trofeo.svg" alt="" aria-hidden="true">
      <span class="trofeo-glint"></span>
      <span class="spark s1"></span><span class="spark s2"></span><span class="spark s3"></span>
    </div>
  </div>
  <span class="intro-skip">Click para entrar</span>
</div>

<!-- ===== navbar, igual en todas las páginas ===== -->

<?php require __DIR__ . '/includes/nav.php'; ?>

<main id="contenido" class="wrap">


  <!-- ===== portada ===== -->
  <section class="hero">
    <div class="hero-copy">
      <span class="eyebrow">Temporada en curso</span>
      <!-- editar: título y bajada de la página principal -->
      <h1>La casa de las<br><span class="resalte">estadísticas</span> de PSO</h1>
      <p class="subtitle">
        Cancha Grande junta los partidos que hacemos, los procesa y devuelve
        <b>promedios reales</b>: quién pasa, quién define, quién recupera y quién ataja.
        Nada de opiniones de Discord y especulaciones sin fundamento: números sacados de los archivos de cada partido.
      </p>
      <div class="hero-actions">
        <a class="btn btn-primary" href="tabla.php">Ver la tabla</a>
        <a class="btn btn-ghost" href="jugadores.php">Cartas de jugador</a>
        <a class="btn btn-ghost" href="pso.php">¿Qué es Pro Soccer Online?</a>
      </div>
    </div>

    <div class="hero-visual">
      <figure class="pizarra-trofeo">
      <span class="cinta cinta-a"></span><span class="cinta cinta-b"></span>
      <div class="trofeo-hero">
        <div class="trofeo">
          <img class="trofeo-glow" src="images/trofeo.svg" alt="" aria-hidden="true">
          <img class="trofeo-base" src="images/trofeo.svg" alt="Trofeo de la Champions">
          <span class="trofeo-glint"></span>
          <span class="spark s1"></span><span class="spark s2"></span><span class="spark s3"></span>
        </div>
      </div>
      <figcaption>[ Trofeo de la Champions ]</figcaption>
    </figure>
    </div>
  </section>

  <!-- ===== números rápidos ===== -->
  <!-- editar: estos valores se pueden cambiar a mano -->
  <div class="stat-strip">
    <div class="stat-box">
      <span class="stat-num" id="statJugadores">—</span>
      <span class="stat-label">Jugadores</span>
    </div>
    <div class="stat-box">
      <span class="stat-num" id="statPartidos">—</span>
      <span class="stat-label">Partidos cargados</span>
    </div>
    <div class="stat-box">
      <span class="stat-num" id="statTemporada">—</span>
      <span class="stat-label">Temporada actual</span>
    </div>
    <div class="stat-box">
      <span class="stat-num">100%</span>
      <span class="stat-label">Datos del juego</span>
    </div>
  </div>

  <!-- ===== qué hay acá ===== -->
  <section aria-labelledby="h-que-vas-a-encontrar">
    <h2 class="section-title" id="h-que-vas-a-encontrar">Qué vas a encontrar</h2>
    <p class="section-lead">
      <!-- editar: descripción corta de las secciones -->
      Cada sección del sitio arranca del mismo lugar: los partidos que subimos los dos admins.
      De ahí salen los promedios, las cartas y todo lo otro.
    </p>

    <div class="card-grid">
      <article class="info-card">
        <span class="icon">01</span>
        <h3>Tabla de promedios</h3>
        <p>Arqueros y jugadores de campo, separados porque su puntaje no se mide igual aunque CASI igual. Se puede mirar la temporada actual o cualquiera de las anteriores.</p>
        <a class="card-link" href="tabla.php">Ir a la tabla →</a>
      </article>

      <article class="info-card">
        <span class="icon">02</span>
        <h3>Cartas de jugador</h3>
        <p>Cartas tipo FIFA: una carta por jugador, con la valoración y los atributos calculados a partir de sus promedios reales de la temporada.</p>
        <a class="card-link" href="jugadores.php">Ver cartas →</a>
      </article>

      <article class="info-card">
        <span class="icon">03</span>
        <h3>Guía de PSO</h3>
        <p>Qué es Pro Soccer Online, cómo se juega, qué significan las estadísticas del juego y por qué las usamos como las usamos.</p>
        <a class="card-link" href="pso.php">Leer la guía →</a>
      </article>

      <article class="info-card">
        <span class="icon">04</span>
        <h3>Comunidad</h3>
        <p>Quiénes están detrás del proyecto, cómo aplicar para sumarte a los partidos y a dónde escribir si encontraste un error en los datos.</p>
        <a class="card-link" href="contacto.php">Contacto →</a>
      </article>
    </div>
  </section>

  <!-- ===== cómo funciona ===== -->
  <section aria-labelledby="h-como-funciona">
    <h2 class="section-title" id="h-como-funciona">Cómo funciona</h2>
    <p class="section-lead">De la partida a la tabla, en cuatro pasos.</p>

    <div class="steps">
      <div class="step">
        <div>
          <h3>Se juega el partido</h3>
          <p><!-- editar -->Partido del server en Pro Soccer Online. Al terminar, el juego por si solo genera un archivo con las estadísticas de todos los jugadores.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Se sube el archivo</h3>
          <p><!-- editar -->Los admins cargamos ese archivo desde la página de la tabla. Si ya estaba cargado, el sistema lo saltea solo: no se duplica nada.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Se calculan los promedios</h3>
          <p><!-- editar -->Cada jugador queda identificado por su ID del juego, así que aunque se cambie el nombre, el historial sigue siendo suyo.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Se publica</h3>
          <p><!-- editar -->La tabla y las cartas se actualizan en el momento. Al cerrar la temporada, todo queda archivado y consultable desde el selector.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== invitación final ===== -->
  <section class="cta-panel">
    <h2>¿Querés contactarnos?</h2>
    <p><!-- editar -->
      Los partidos los jugamos nosotros en nuestro Discord. No hace falta ser un dios: hace falta aparecer,
      jugar en el puesto que te toque, no bardear a los demas y no abandonar a los dos minutos.
      <br>La sala siempre se hostea adentro del juego con nombre "lol" y contraseña "lol".
    </p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="contacto.php">Contactarte</a>
      <a class="btn btn-ghost" href="tabla.php">Ver cómo vamos</a>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
