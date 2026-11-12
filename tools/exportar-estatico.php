<?php
/* Convierte el sitio PHP en HTML puro dentro de la carpeta /dist,
   para subirlo a un hosting que NO ejecuta PHP (GitHub Pages, Cloudflare Pages, etc).

   Uso, desde la carpeta del proyecto:
       php tools/exportar-estatico.php

   Las páginas se generan con las mismas plantillas (includes/), así que
   cualquier cambio se hace UNA vez en PHP y se vuelve a exportar.
   Los links internos pasan de .php a .html automáticamente. */

$raiz = dirname(__DIR__);
$dist = $raiz . '/dist';
$paginas = ['index', 'tabla', 'jugadores', 'pso', 'contacto', 'usuarios', '404'];

/* Archivos que no se pudieron tocar (casi siempre porque otro programa los
   tiene abiertos: navegador, visor de fotos, vista previa del Explorador, OneDrive).
   No frenan la exportación: se avisa al final con un mensaje corto. */
$bloqueados = [];

function copiar_archivo(string $desde, string $hasta): void {
    global $bloqueados;
    for ($i = 0; $i < 3; $i++) {
        if (@copy($desde, $hasta)) return;
        usleep(300000);
    }
    $bloqueados[] = $hasta;
}

function borrar_ruta(string $ruta, bool $esCarpeta): void {
    global $bloqueados;
    for ($i = 0; $i < 3; $i++) {
        if ($esCarpeta ? (@rmdir($ruta) || !is_dir($ruta)) : (@unlink($ruta) || !file_exists($ruta))) return;
        usleep(300000);
    }
    /* una carpeta que no se vació ya está avisada por el archivo que la traba */
    if (!$esCarpeta) $bloqueados[] = $ruta;
}

function copiar_carpeta(string $desde, string $hasta): void {
    if (!is_dir($hasta)) mkdir($hasta, 0777, true);
    foreach (scandir($desde) as $f) {
        if ($f === '.' || $f === '..') continue;
        is_dir("$desde/$f") ? copiar_carpeta("$desde/$f", "$hasta/$f") : copiar_archivo("$desde/$f", "$hasta/$f");
    }
}

if (is_dir($dist)) {
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dist, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $f) {
        borrar_ruta($f->getPathname(), $f->isDir());
    }
} else {
    mkdir($dist, 0777, true);
}

foreach ($paginas as $p) {
    $html = shell_exec(escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg("$raiz/$p.php"));
    if ($html === null || $html === '') { fwrite(STDERR, "No se pudo generar $p.php\n"); exit(1); }
    $html = preg_replace('/href="(index|tabla|jugadores|pso|usuarios|contacto)\.php/', 'href="$1.html', $html);
    file_put_contents("$dist/$p.html", $html);
    echo "ok  $p.html\n";
}

copiar_carpeta("$raiz/js", "$dist/js");
copiar_carpeta("$raiz/images", "$dist/images");
copiar_archivo("$raiz/stylesheet.css", "$dist/stylesheet.css");
if ($bloqueados) {
    echo "\nAVISO: estos archivos estaban abiertos en otro programa y no se pudieron actualizar:\n";
    $n = fn($r) => str_replace('\\', '/', $r);
    foreach (array_unique(array_map(fn($b) => str_replace($n($dist), 'dist', $n($b)), $bloqueados)) as $b) echo "  - $b\n";
    echo "Cerrá lo que los tenga abiertos y volvé a correr exportar.bat.\n";
} else {
    echo "\nListo: subí el contenido de /dist a tu hosting.\n";
}
