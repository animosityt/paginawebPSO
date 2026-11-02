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

function copiar_carpeta(string $desde, string $hasta): void {
    if (!is_dir($hasta)) mkdir($hasta, 0777, true);
    foreach (scandir($desde) as $f) {
        if ($f === '.' || $f === '..') continue;
        is_dir("$desde/$f") ? copiar_carpeta("$desde/$f", "$hasta/$f") : copy("$desde/$f", "$hasta/$f");
    }
}

if (is_dir($dist)) {
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dist, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $f) {
        $f->isDir() ? rmdir($f->getPathname()) : unlink($f->getPathname());
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
copy("$raiz/stylesheet.css", "$dist/stylesheet.css");
echo "\nListo: subí el contenido de /dist a tu hosting.\n";
