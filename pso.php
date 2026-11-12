<?php
$pageTitle    = 'Qué es Pro Soccer Online · Guía para nuevos · Cancha Grande';
$pageDesc     = 'Guía rápida de Pro Soccer Online: qué es, cómo se juega y qué significan sus estadísticas.';
$paginaActiva = 'pso';
$usaSupabase  = false;
$paginaJs     = [];
require __DIR__ . '/includes/head.php';
?>
<?php require __DIR__ . '/includes/nav.php'; ?>

<main id="contenido" class="wrap">


  <header>
    <span class="eyebrow">Guía para nuevos</span>
    <h1>¿Qué es Pro<br>Soccer Online?</h1>
    <p class="subtitle">
      <!-- editar: bajada con tus palabras -->
      Es un juego de fútbol en el que cada persona controla <b>un solo jugador</b>.
      No manejás a todo el equipo: te ocupás del tuyo y coordinás con los demás.
    </p>
  </header>

  <div class="pill-row">
    <!-- editar: datos duros del juego -->
    <span class="pill">PC</span>
    <span class="pill">Multijugador online</span>
    <span class="pill">Cámara en tercera persona</span>
    <span class="pill">Partidos de club</span>
    <span class="pill">Estadísticas por partido</span>
  </div>

  <article class="article">
    <h2>La idea básica</h2>
    <p><!-- editar -->
      En muchos juegos de fútbol controlás al que tiene la pelota y vas cambiando de jugador. En Pro Soccer
      Online elegís <b>uno</b> y jugás con ese durante todo el partido. Aunque la pelota esté lejos, te toca
      moverte, ofrecerte para recibir o marcar a alguien.
    </p>
    <p><!-- editar -->
      Acá no alcanza con esperar la pelota: moverse bien y hablarse entre compañeros importa tanto como
      definir una jugada. Es un juego de equipo, incluso cuando no estás tocando la pelota.
    </p>

    <h3>Qué se necesita para jugar</h3>
    <ul>
      <li><!-- editar -->Una PC que lo aguante y el juego instalado.</li>
      <li>Micrófono. No hace falta que hables mucho, pero escuchar ayuda.</li>
      <li>Estar en el Discord de la comunidad para enterarte de los partidos.</li>
      <li>Paciencia los primeros partidos: el control se siente raro hasta que te acostumbrás.</li>
    </ul>

    <h3>Los puestos</h3>
    <p><!-- editar -->
      Están los puestos de siempre: arquero, defensa, mediocampo y delantera. Antes de cada partido nos
      repartimos y, salvo que haya un cambio, cada uno se queda en su puesto. Los arqueros tienen su propia
      tabla porque sus estadísticas son distintas a las del resto.
    </p>
  </article>

  <section aria-labelledby="h-las-estadisticas-del-juego">
    <h2 class="section-title" id="h-las-estadisticas-del-juego">Las estadísticas del juego</h2>
    <p class="section-lead">
      Al terminar cada partido, el juego guarda un archivo con las estadísticas de cada jugador. Con esos
      datos armamos la tabla y las cartas.
    </p>

    <div class="glossary">
      <div>
        <b>Pases</b>
        <p>Cuántos pases completaste. Sirve para hacerse una idea de cuánto participaste en el juego.</p>
      </div>
      <div>
        <b>Tiros / Tiros al arco</b>
        <p>Cuántas veces pateaste y cuántos tiros fueron al arco. La diferencia da una idea de tu puntería.</p>
      </div>
      <div>
        <b>Goles</b>
        <p>Los goles que hiciste. Cuentan para la carta, pero no son lo único: por ejemplo, un central no tiene por qué convertir.</p>
      </div>
      <div>
        <b>Tackles</b>
        <p>Los quites limpios que hiciste. Es una estadística que suele sumar para defensores y mediocampistas que ayudan a marcar.</p>
      </div>
      <div>
        <b>Intercepciones</b>
        <p>Pelotas que cortaste antes de que llegaran a destino. También cuentan esas jugadas en las que anticipaste el pase.</p>
      </div>
      <div>
        <b>Posesiones perdidas</b>
        <p>Las veces que perdiste la pelota. Acá <b>menos es mejor</b>, y así lo tenemos en cuenta al calcular los promedios.</p>
      </div>
      <div>
        <b>Atajadas</b>
        <p>Solo para arqueros: tiros al arco que pudieron detener, con las manos o con los pies.</p>
      </div>
      <div>
        <b>Capturas</b>
        <p>Solo para arqueros: pelotas que retuvieron sin dar rebote.</p>
      </div>
      <div>
        <b>Score</b>
        <p>El puntaje que calcula el juego a partir de esas estadísticas. Lo usamos como base para sacar el promedio.</p>
      </div>
    </div>
  </section>

  <section aria-labelledby="h-preguntas-frecuentes">
    <h2 class="section-title" id="h-preguntas-frecuentes">Preguntas frecuentes</h2>
    <p class="section-lead">Algunas dudas que suelen aparecer por Discord.</p>

    <div class="faq">
      <details open>
        <summary>¿Se puede jugar sin saber nada?</summary>
        <p><!-- editar -->Sí, claro. Todos empezamos sin conocerlo. Solo te pedimos que, si empezás un partido, te quedes hasta el final.</p>
      </details>
      <details>
        <summary>¿Cómo entro a un partido?</summary>
        <p><!-- editar -->Avisamos el horario por Discord. Confirmás si venís, te contamos qué puesto y equipo te toca, y ya estás.</p>
      </details>
      <details>
        <summary>¿Por qué no aparezco en la tabla?</summary>
        <p><!-- editar -->Puede ser que todavía no hayamos cargado un partido tuyo o que hayas cambiado tu nombre en el juego. Si es lo segundo, avisá y unificamos el historial.</p>
      </details>
      <details>
        <summary>¿Qué pasa cuando se cierra una temporada?</summary>
        <p>Los promedios quedan guardados y podés volver a verlos desde el selector. La temporada nueva arranca de cero.</p>
      </details>
      <details>
        <summary>¿Se pueden borrar o corregir partidos?</summary>
        <p><!-- editar -->Sí, pero solo puede hacerlo la administración. Si ves un partido mal cargado, escribinos y lo revisamos.</p>
      </details>
    </div>
  </section>

  <section class="cta-panel">
    <h2>¿Te dieron ganas de jugar?</h2>
    <p>Escribinos y te contamos cuándo es el próximo partido y cómo sumarte.</p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="contacto.php">Quiero entrar</a>
      <a class="btn btn-ghost" href="tabla.php">Ver la tabla</a>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
