<?php
http_response_code(404);
$pageTitle    = 'Página no encontrada (404) · Cancha Grande';
$pageDesc     = 'La página que buscás no existe o se movió. Volvé al inicio de Cancha Grande.';
$paginaActiva = '';
$usaSupabase  = false;
$paginaJs     = [];
$noIndex      = true;
/* El servidor puede mostrar esta página en cualquier URL (/a/b/c), así que
   los archivos (css, imágenes, js) se piden desde la raíz del sitio.
   EDITAR: si el sitio vive en una subcarpeta, poné acá esa carpeta (ej: '/mi-sitio/'). */
$baseHref     = '/';
require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/nav.php';
?>

<main id="contenido" class="wrap">
  <section class="error-404">
    <div class="error-404-copy">
      <span class="eyebrow">Error 404</span>
      <h1>Fuera de <span class="resalte">juego</span></h1>
      <p class="subtitle">
        La página que buscás no existe o cambió de lugar. Puede ser un link viejo
        o una dirección mal escrita.
      </p>
      <div class="hero-actions">
        <a class="btn btn-primary" href="index.php">Volver al inicio</a>
        <a class="btn btn-ghost" href="tabla.php">Ver la tabla</a>
        <a class="btn btn-ghost" href="contacto.php">Avisarnos del error</a>
      </div>
    </div>

    <div class="error-404-visual" aria-hidden="true">
      <span class="error-404-num">404</span>
      <span class="tarjeta-roja"></span>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
