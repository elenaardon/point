<?php
// ============================================================
//  app.php: recorrido pantalla por pantalla de la app (secciones de ejemplo).
//  $titulo = título de la pestaña; $slug = opción resaltada en el menú.
// ============================================================
$titulo='La app'; $slug='app'; require __DIR__ . '/includes/header.php'; ?>
<section class="dark page"><div class="w">
<div class="head rv"><div><span class="kicker">La app</span><h2>Pantalla por pantalla.</h2></div><p style="color:#cfdcff">La barra inferior de Point tiene cinco secciones. Este es un recorrido por cada una.</p></div>
<div class="flow">

<div class="rv"><?php phone_start('Inicio','inicio'); ?>
<h4>Hola, Martina</h4><small>¿Listo para tu próximo partido?</small>
<div class="bub">Próximo partido · Jue 19:30<br><small style="color:#1f2a10">Club Demo Palermo · Cancha 3</small></div>
<div class="mini"><span><small>Tu nivel</small><br><b style="font-size:15px">Intermedio +</b></span><span style="color:#0066FF;font:600 20px Outfit,sans-serif">3.5</span></div>
<div class="mini"><span>Partidos<br><b>12</b></span><span>Horas<br><b>24.5</b></span><span>Calorías<br><b>3.420</b></span></div>
<span class="cta-m b">Registrar partido</span>
<?php phone_end('inicio'); ?><div class="cap"><b>Inicio</b><span>Tu resumen y lo que viene.</span></div></div>

<div class="rv"><?php phone_start('Live Match','live'); ?>
<span class="live">EN VIVO</span>
<div class="sc" style="margin-top:10px"><div><small>Nosotros</small><b>4</b></div><div><span class="vs">SET 2</span><small>1 – 0</small></div><div><small>Ellos</small><b>2</b></div></div>
<div class="mini"><span>Ritmo cardíaco</span><b style="font-size:14px">138 lpm</b></div>
<div class="court sm"></div>
<?php phone_end('live'); ?><div class="cap"><b>Live Match</b><span>Inicia, puntúa y mira tus estadísticas en vivo.</span><a class="go" style="color:var(--lime);font-weight:600" href="livematch.php">Ver más →</a></div></div>

<div class="rv"><?php phone_start('Play','play'); ?>
<div class="mini"><span>Reservar cancha</span><span>›</span></div>
<div class="mini"><span>Clases</span><span>›</span></div>
<div class="mini"><span>Americanos</span><span>›</span></div>
<div class="mini"><span>Partidos abiertos</span><span>›</span></div>
<div class="mini"><span>Torneos</span><span>›</span></div>
<div class="mini"><span>Canchas abiertas</span><span>›</span></div>
<?php phone_end('play'); ?><div class="cap"><b>Play</b><span>Reserva, anótate y encuentra con quién jugar.</span><a class="go" style="color:var(--lime);font-weight:600" href="play.php">Ver más →</a></div></div>

<div class="rv"><?php phone_start('Mi raqueta','raqueta'); ?>
<div class="row"><h4 class="gr">Bullpadel Wonder 2026</h4><span class="pi on" style="margin:0">Avanzado</span></div>
<div style="background:#fff;border-radius:12px;padding:8px;margin:10px 0;text-align:center"><img src="assets/img/palas/bullpadel-wonder-2026.webp" alt="Bullpadel Wonder 2026" style="height:120px;width:auto"></div>
<div class="mini"><span>Punto dulce</span><b style="font-size:13px">68%</b></div>
<div class="mini"><span>Mis estadísticas</span><span>›</span></div>
<?php phone_end('raqueta'); ?><div class="cap"><b>Mi raqueta</b><span>Estadísticas de tu pala y tus números más específicos.</span><a class="go" style="color:var(--lime);font-weight:600" href="raqueta.php">Ver más →</a></div></div>

<div class="rv"><?php phone_start('Perfil','perfil'); ?>
<div class="row"><span class="av" style="width:48px;height:48px;font-size:18px">M</span><div><h4>Martina S.</h4><small>Nivel 3.5 · Drive</small></div></div>
<div class="mini"><span>Editar perfil</span><span>›</span></div>
<div class="mini"><span>Privacidad</span><span>›</span></div>
<div class="mini"><span>Configuración</span><span>›</span></div>
<div class="mini"><span>Ayuda y soporte</span><span>›</span></div>
<?php phone_end('perfil'); ?><div class="cap"><b>Perfil</b><span>Tus datos, privacidad y configuración.</span><a class="go" style="color:var(--lime);font-weight:600" href="perfil.php">Ver más →</a></div></div>

</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
