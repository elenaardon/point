<?php
// ============================================================
//  includes/header.php: parte de arriba que comparten todas las páginas
//  (<head>, barra de navegación y menú). Cada página define antes de
//  incluirlo: $titulo (título de la pestaña) y $slug (opción resaltada del menú).
// ============================================================
require_once __DIR__ . '/init.php';
require_once __DIR__ . '/ui.php';
$titulo = $titulo ?? 'Point';
$slug   = $slug   ?? '';

// Opciones del menú hamburguesa: archivo => texto
$menu = [
    'index' => 'Inicio', 'app' => 'La app', 'livematch' => 'Live Match', 'play' => 'Play',
    'raqueta' => 'Mi raqueta', 'perfil' => 'Perfil', 'token' => 'Token', 'planes' => 'Clubes',
    'progresa' => 'Progresa', 'preguntas' => 'Preguntas', 'contacto' => 'Contacto',
];
?><!DOCTYPE html>
<html lang="es"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= e($titulo) ?> – Point</title>
<script>document.documentElement.classList.add('js')</script>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/styles.css"></head><body>
<nav><div class="w"><a class="logo" href="index.php"><img src="assets/img/logo-1.png" alt="Point" height="38"><span>point</span></a><span class="sp"></span><a class="btn dl" href="index.php#descargar">Descargar</a>
<button class="burger" aria-label="Abrir menú" aria-expanded="false" aria-controls="menu"><i></i><i></i><i></i></button></div>
<div id="menu" class="menu"><div class="w">
<!-- El menú se genera recorriendo el arreglo $menu (archivo => texto) -->
<?php foreach ($menu as $archivo => $texto): ?><a href="<?= e($archivo) ?>.php"<?= $slug === $archivo ? ' class="cur"' : '' ?>><?= e($texto) ?></a>
<?php endforeach; ?>
</div></div></nav>
