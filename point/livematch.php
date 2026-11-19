<?php
// ============================================================
//  livematch.php: explica la función Live Match con pantallas de ejemplo.
//  $titulo = título de la pestaña; $slug = opción resaltada en el menú.
// ============================================================
$titulo='Live Match'; $slug='livematch'; require __DIR__ . '/includes/header.php'; ?>
<section class="dark page"><div class="w split">
<div><span class="kicker">Live Match</span><h2 class="rv">Tu partido, punto por punto.</h2>
<p class="lead rv" style="margin-top:20px">Inicia el partido, lleva el puntaje y mira tus estadísticas mientras juegas. Point está pensado para dobles, que es como se juega el pádel.</p>
<ul class="checks rv"><li>Marcador con puntos, games y sets, y quién saca</li><li>Ritmo cardíaco y golpes en tiempo real</li><li>Mapa de calor de tu movimiento en la cancha</li><li>Resumen y tarjeta de resultado para compartir</li></ul></div>
<div class="rv"><?php phone_start('Live Match','live'); ?>
<span class="live">EN VIVO</span> <small>· 00:42:18</small>
<div class="sc" style="margin-top:10px"><div><small>Nosotros</small><b>4</b></div><div><span class="vs">SET 2</span><small>1 – 0</small></div><div><small>Ellos</small><b>2</b></div></div>
<div class="mini"><span><small>Puntos</small><br><b style="font-size:18px">30 – 15</b></span><span style="color:#0066FF;font-weight:600">Saca Martina</span></div>
<div class="mini" style="display:block"><small>Ritmo cardíaco</small> <b style="display:inline;font-size:14px;float:right">138 lpm</b><div class="bar"><i style="width:64%"></i></div></div>
<div class="row" style="margin-top:10px"><span class="cta-m b gr" style="margin:0">+ Punto nuestro</span><span class="cta-m o gr" style="margin:0">+ Rival</span></div>
<?php phone_end('live'); ?></div>
</div></section>

<section class="page"><div class="w">
<div class="head rv"><div><span class="kicker">Paso a paso</span><h2>Así se vive un partido.</h2></div><p>De la reserva al resumen, en cuatro pantallas.</p></div>
<div class="flow">

<div class="rv"><?php phone_start('Nuevo partido','live'); ?>
<h4>Dobles</h4><small>Elige tu pareja y a los rivales</small>
<div class="mini"><span class="row"><span class="av">M</span> Martina (tú)</span><small>Drive</small></div>
<div class="mini"><span class="row"><span class="av l">L</span> Luca F.</span><small>Revés</small></div>
<div class="mini"><span class="row"><span class="av">S</span> Sofi R.</span><small>Drive</small></div>
<div class="mini"><span class="row"><span class="av">J</span> Juan P.</span><small>Revés</small></div>
<div class="mini"><span>Cancha</span><b style="font-size:13px">Club Demo Palermo · 3</b></div>
<span class="cta-m">Empezar partido</span>
<?php phone_end('live'); ?><div class="cap"><b>1. Inicia el partido</b><span>Elige pareja, rivales y lado de juego.</span></div></div>

<div class="rv"><?php phone_start('Marcador','live'); ?>
<span class="live">EN VIVO</span>
<div class="sc" style="margin-top:10px"><div><small>Nosotros</small><b>40</b></div><div><span class="vs">GAME 7</span></div><div><small>Ellos</small><b>30</b></div></div>
<div class="mini"><span>Set 1</span><b style="font-size:14px">6 – 4</b></div>
<div class="mini"><span>Set 2</span><b style="font-size:14px">3 – 3</b></div>
<div class="row" style="margin-top:12px"><span class="cta-m b gr" style="margin:0">+ Nosotros</span><span class="cta-m o gr" style="margin:0">+ Ellos</span></div>
<div class="mini" style="justify-content:center;color:#5b6b85">Deshacer último punto</div>
<?php phone_end('live'); ?><div class="cap"><b>2. Lleva el puntaje</b><span>Carga cada punto desde la app o el Apple Watch.</span></div></div>

<div class="rv"><?php phone_start('En vivo','live'); ?>
<h4>Tus golpes</h4>
<div class="mini"><span>Drive</span><span>42%</span></div><div class="bar"><i style="width:42%"></i></div>
<div class="mini"><span>Revés</span><span>28%</span></div><div class="bar"><i style="width:28%"></i></div>
<div class="mini"><span>Bandeja</span><span>18%</span></div><div class="bar"><i style="width:18%"></i></div>
<div class="mini"><span>Volea</span><span>12%</span></div><div class="bar"><i style="width:12%"></i></div>
<div class="court sm"></div>
<?php phone_end('live'); ?><div class="cap"><b>3. Mira tus números</b><span>Golpes, ritmo cardíaco y mapa de calor mientras juegas.</span></div></div>

<div class="rv"><?php phone_start('Resumen','live'); ?>
<div class="sc"><div><small>Nosotros</small><b>2</b></div><div><span class="vs">GANAMOS</span><small>6-4 · 3-6 · 6-3</small></div><div><small>Ellos</small><b>1</b></div></div>
<div class="g2" style="gap:6px;margin-top:8px"><div class="mini" style="display:block;margin:0"><small>Duración</small><br><b style="font-size:15px">1 h 32</b></div><div class="mini" style="display:block;margin:0"><small>Calorías</small><br><b style="font-size:15px">640</b></div></div>
<div class="mini"><span>Puntos ganados</span><b style="font-size:14px">54%</b></div>
<div class="court sm"></div>
<span class="cta-m">Compartir tarjeta</span>
<?php phone_end('live'); ?><div class="cap"><b>4. Comparte tu resultado</b><span>Tarjeta con resultado, calorías y mapa de calor.</span></div></div>

</div></div></section>

<section style="background:var(--card);border-top:1px solid var(--line)"><div class="w">
<div class="head rv"><h2>Con reloj, con celular<br>o con el token.</h2><p>Tú eliges cómo registrar. Los puntos los cargas tú; el resto lo registra el token automáticamente.</p></div>
<div class="g3">
<div class="card hv rv"><div class="ico">01</div><h3>Apple Watch</h3><p>Carga puntos desde la muñeca y abre la cámara con un botón.</p></div>
<div class="card hv rv"><div class="ico">02</div><h3>Celular</h3><p>Anota los puntos en la app al terminar el partido.</p></div>
<a class="card nv rv" href="token.php"><div class="ico">03</div><h3>Token Point</h3><p>Registra todas tus estadísticas sin necesidad de reloj.</p><span class="go" style="color:var(--lime)">Conocer el token →</span></a>
</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
