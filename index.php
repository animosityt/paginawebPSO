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
        En Cancha Grande juntamos los partidos que jugamos y usamos sus archivos para armar
        <b>promedios reales</b>: pases, goles, recuperaciones, atajadas y más.
        Así podés ver cómo viene cada uno con los números de las partidas, sin depender de opiniones o especulaciones.
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
      <figcaption>★ ★ ★ ★ ★</figcaption>
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
      Todo parte de los partidos que cargamos los admins. Con esos datos armamos la tabla y las cartas; también
      vas a encontrar una guía del juego y cómo ponerte en contacto con nosotros.
    </p>

    <div class="card-grid">
      <a class="info-card" href="tabla.php">
        <span class="icon">01</span>
        <h3>Tabla de promedios</h3>
        <p>Arqueros y jugadores de campo van por separado, porque no se los mide con las mismas estadísticas. Podés elegir la temporada actual o revisar las anteriores.</p>
        <span class="card-link">Ir a la tabla →</span>
      </a>

      <a class="info-card" href="jugadores.php">
        <span class="icon">02</span>
        <h3>Cartas de jugador</h3>
        <p>Una carta por jugador, con valoración y atributos calculados a partir de sus promedios de la temporada.</p>
        <span class="card-link">Ver cartas →</span>
      </a>

      <a class="info-card" href="pso.php">
        <span class="icon">03</span>
        <h3>Guía de PSO</h3>
        <p>Una guía para conocer Pro Soccer Online, entender sus estadísticas y saber cómo las usamos en el sitio.</p>
        <span class="card-link">Leer la guía →</span>
      </a>

      <a class="info-card" href="contacto.php">
        <span class="icon">04</span>
        <h3>Comunidad</h3>
        <p>Conocé quiénes estamos detrás del proyecto, cómo sumarte a los partidos y dónde avisarnos si encontrás un error.</p>
        <span class="card-link">Contacto →</span>
      </a>
    </div>
  </section>

  <!-- ===== cómo funciona ===== -->
  <section aria-labelledby="h-como-funciona">
    <h2 class="section-title" id="h-como-funciona">Cómo funciona</h2>
    <p class="section-lead">Así pasan las estadísticas del partido a la página.</p>

    <div class="steps">
      <div class="step">
        <div>
          <h3>Se juega el partido</h3>
          <p><!-- editar -->Jugamos en el server de Pro Soccer Online. Cuando termina el partido, el juego genera un archivo con las estadísticas de todos.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Se sube el archivo</h3>
          <p><!-- editar -->Los admins lo cargamos desde la página de la tabla. Si el archivo ya estaba, el sistema lo reconoce y evita cargar el partido dos veces.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Se calculan los promedios</h3>
          <p><!-- editar -->El juego identifica a cada jugador con un ID. Así, aunque cambie su nombre, sus partidos siguen apareciendo en el mismo historial.</p>
        </div>
      </div>
      <div class="step">
        <div>
          <h3>Se publica</h3>
          <p><!-- editar -->La tabla y las cartas se actualizan al cargar el partido. Cuando termina la temporada, queda guardada para consultarla más adelante.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== invitación final ===== -->
  <section class="cta-panel">
    <h2>¿Querés contactarnos?</h2>
    <p><!-- editar -->
      Nos organizamos por Discord. No hace falta ser un crack: alcanza con sumarse, jugar donde haga falta,
      no bardear a nadie y no desaparecer a los dos minutos.
      <br>La sala se crea dentro del juego con el nombre "lol" y la contraseña "lol".
    </p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="contacto.php">Contactarte</a>
      <a class="btn btn-ghost" href="tabla.php">Ver cómo vamos</a>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
