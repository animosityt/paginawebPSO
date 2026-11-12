<?php
$pageTitle    = 'Contacto · Cancha Grande';
$pageDesc     = 'Cómo contactar a Cancha Grande: Discord, Instagram y un formulario para sumarte a los partidos, avisar de un dato mal cargado o proponer algo para el sitio.';
$paginaActiva = 'contacto';
$usaSupabase  = false;
$paginaJs     = ['contacto'];
require __DIR__ . '/includes/head.php';
?>
<?php require __DIR__ . '/includes/nav.php'; ?>

<main id="contenido" class="wrap">


  <header>
    <span class="eyebrow">Estamos del otro lado</span>
    <h1>Contacto</h1>
    <p class="subtitle">
      ¿Querés sumarte a un partido, avisarnos de un dato o acercar una idea para el sitio?
      Escribinos por <b>Discord</b>, que suele ser lo más rápido.
    </p>
  </header>

  <div class="contact-layout">

    <div class="contact-card">
      <h2>Dónde encontrarnos</h2>
      <!-- EDITAR: reemplazá por tus datos reales -->
      <ul class="contact-list">
        <li>
          <span class="k">Discord · Animosity</span>
          <span class="v">animossiity</span>
        </li>
        <li>
          <span class="k">Discord · Aitor</span>
          <span class="v">aitor_rex</span>
        </li>
        <li>
          <span class="k">Instagram</span>
          <span class="v">
            <a href="https://instagram.com/aniimossity">@aniimossity</a> ·
            <a href="https://instagram.com/aitor.pez">@aitor.pez</a>
          </span>
        </li>
        <li>
          <span class="k">Horarios de partido</span>
          <span class="v">Jugamos casi todos los días, si hay gente en el voice chat. Los partidos que cuentan son a las 22:00 (ARG).<br><br>
          Cerca de las 19:10 solemos jugar en cancha chica; esos partidos no entran en las estadísticas.</span>
        </li>
      </ul>
    </div>

    <div class="contact-card">
      <h2>Escribinos</h2>
      <!-- Este formulario manda el mensaje directo a Formspree (sin abrir el mail del visitante).
           EDITAR: si cambiamos de cuenta de Formspree, actualizá la URL del atributo action de abajo. -->
      <form class="form-grid" id="contactForm" action="https://formspree.io/f/xnpqrglk" method="POST">
        <label>
          Tu nombre
          <input type="text" id="fNombre" name="name" required placeholder="Cómo te decimos">
        </label>

        <label>
          Tu mail o usuario de Discord
          <input type="text" id="fContacto" name="email" required placeholder="Para poder responderte">
        </label>

        <label>
          Motivo
          <select id="fMotivo" name="motivo">
            <option>Quiero sumarme a los partidos</option>
            <option>Hay un dato mal cargado</option>
            <option>Propuesta o idea para el sitio</option>
            <option>Otra cosa</option>
          </select>
        </label>

        <label>
          Mensaje
          <textarea id="fMensaje" name="message" required placeholder="Contanos…"></textarea>
        </label>

        <!-- trampa para bots: invisible para una persona, pero un bot la suele completar.
             Formspree descarta el envío solo si esto llega con contenido. No la borres ni la muestres. -->
        <input type="text" name="_gotcha" style="display:none" tabindex="-1" autocomplete="off">

        <button type="submit" class="btn btn-primary" style="justify-content:center" id="formSubmitBtn">Enviar</button>
        <p class="form-note">
          Te vamos a responder por el mail o Discord que nos dejes.
        </p>
        <p class="form-feedback" id="formFeedback" hidden></p>
      </form>
    </div>

  </div>

  <section aria-labelledby="h-antes-de-escribir">
    <h2 class="section-title" id="h-antes-de-escribir">Antes de escribir</h2>
    <p class="section-lead">Antes de escribirnos, fijate si tu duda está acá.</p>

    <div class="card-grid">
      <article class="info-card">
        <span class="icon">01</span>
        <h3>No aparezco en la tabla</h3>
        <p>Primero fijate si ya cargamos tu partido. Si cambiaste tu nombre en el juego, pasanos el anterior y el nuevo para juntar tu historial.</p>
        <a class="card-link" href="tabla.php">Revisar la tabla →</a>
      </article>

      <article class="info-card">
        <span class="icon">02</span>
        <h3>Mi valoración está mal</h3>
        <p>La valoración sale de tus promedios por partido y se compara con los del resto de la temporada. En la página de cartas contamos cómo se calcula.</p>
        <a class="card-link" href="jugadores.php">Cómo se calcula →</a>
      </article>

      <article class="info-card">
        <span class="icon">03</span>
        <h3>Nunca jugué a PSO</h3>
        <p>No pasa nada. Pegale una mirada a la guía para familiarizarte con los controles y los puestos antes de jugar.</p>
        <a class="card-link" href="pso.php">Leer la guía →</a>
      </article>
    </div>
  </section>

  <section class="cta-panel">
    <h2>¿Querés ayudar con el proyecto?</h2>
    <p><!-- EDITAR -->
      El sitio es abierto y siempre hay algo para hacer. Si te interesa el diseño, los datos o el desarrollo, escribinos y vemos cómo podés dar una mano.
    </p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="https://github.com/animosityt">Ver el código</a>
      <a class="btn btn-ghost" href="usuarios.php">Ver el equipo</a>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
