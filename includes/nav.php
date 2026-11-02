<?php
if (!isset($pageTitle)) { http_response_code(403); exit; }
$items = [
  'index'     => ['index.php',     'Inicio'],
  'tabla'     => ['tabla.php',     'Tabla'],
  'jugadores' => ['jugadores.php', 'Jugadores'],
  'pso'       => ['pso.php',       'Qué es PSO'],
  'usuarios'  => ['usuarios.php',  'Usuarios'],
  'contacto'  => ['contacto.php',  'Contacto'],
];
?>
<!-- ===== navbar, igual en todas las páginas ===== -->
<nav class="navbar" id="top" aria-label="Navegación principal">
  <div class="navbar-brand">
    <a class="brand-title" href="index.php">Cancha Grande</a>
    <span class="brand-sub">Pro Soccer Online · Comunidad</span>
  </div>
  <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="navMenu">Menú</button>
  <div class="nav-menu" id="navMenu">
<?php foreach ($items as $clave => [$url, $texto]): ?>
    <a href="<?= $url ?>"<?= ($clave === ($paginaActiva ?? '')) ? ' class="active" aria-current="page"' : '' ?>><?= $texto ?></a>
<?php endforeach; ?>
  </div>
</nav>
