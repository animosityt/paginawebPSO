<?php
/* Cabecera común. Cada página define antes: $pageTitle, $pageDesc, $paginaActiva, $usaSupabase, $paginaJs.
   Opcionales: $noIndex (true) y $baseHref (p. ej. '/', solo lo usa 404.php). */
if (!isset($pageTitle)) { http_response_code(403); exit; }
$e = fn($s) => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if (!empty($baseHref)): ?>
<base href="<?= $e($baseHref) ?>">
<?php endif; ?>
<title><?= $e($pageTitle) ?></title>
<meta name="description" content="<?= $e($pageDesc ?? '') ?>">
<?php if (!empty($noIndex)): ?>
<meta name="robots" content="noindex">
<?php endif; ?>
<link rel="icon" type="image/svg+xml" href="images/trofeo.svg">
<link rel="stylesheet" href="stylesheet.css">
</head>

<body>
<a class="skip-link" href="#contenido">Saltar al contenido</a>
