<?php
// ============================================================
//  index.php: página de inicio. Presenta la app y el simulador de golpe
//  (js/sim.js). No tiene formularios ni consultas a la base de datos.
// ============================================================
$titulo='Donde cada partido cuenta'; $slug='index';   // título y opción del menú
$extra_js='js/sim.js';                                // script extra: simulador de golpe
require __DIR__ . '/includes/header.php';
?>
<header class="hero"><div class="w g"><div>
<img class="herologo" src="assets/img/logo-1.png" alt="Logo Point"><h1>Donde cada partido cuenta.</h1>
<p>Point es la app de pádel, gratis para jugadores, que reúne tus partidos, estadísticas y canchas en un solo lugar. Reserva, juega y mejora.</p>
<div class="btns"><a class="btn" href="#descargar">Descargar gratis</a><a class="btn o" href="app.php">Ver cómo funciona</a></div></div>
<div class="phone"><div class="scr"><b>Hola, Martina</b><small>¿Listo para tu próximo partido?</small>
<div class="mini"><span><small>Tu nivel</small><br><b style="font-size:16px">Intermedio +</b></span><span style="color:#0066FF;font:600 20px Outfit,sans-serif">3.5</span></div>
<div class="mini" style="background:#0066FF;color:#fff;justify-content:center;font-weight:600">Registrar partido</div>
<div class="mini"><span>Partidos<br><b>12</b></span><span>Horas<br><b>24.5</b></span><span>Calorías<br><b>3.420</b></span></div>
<div class="mini" style="display:block"><small>Ritmo cardíaco</small><b>142 lpm</b><div class="bar"><i style="width:68%"></i></div></div></div></div></div></header>

<div class="strip" id="stats"><div class="w">
<div><b data-count="5">5</b><span>secciones: Inicio, Live Match, Play, Mi raqueta y Perfil</span></div>
<div><b>$0</b><span>para los jugadores: la app es 100% gratis</span></div>
<div><b data-count="1482">1.482</b><span>golpes registrados por jugador</span></div>
<div><b data-count="142" data-suf=" lpm">142 lpm</b><span>ritmo cardíaco en tiempo real</span></div></div></div>

<section id="app"><div class="w"><div class="head rv"><h2>Conecta. Juega. Progresa.</h2><p>No es solo una app para llevar tu tracking: pone a las personas en el centro.</p></div>
<div class="tri">
<a class="f rv" href="play.php#partidos-abiertos"><div class="ic">1</div><div><h3>Conecta</h3><p>Encuentra partidos abiertos y canchas libres cerca de ti, únete a clubes y arma el partido.</p></div></a>
<a class="f rv" href="livematch.php"><div class="ic">2</div><div><h3>Juega</h3><p>Reserva canchas, clases y americanos, y registra el marcador en vivo.</p></div></a>
<a class="f rv" href="raqueta.php"><div class="ic">3</div><div><h3>Progresa</h3><p>Mira tu evolución, las estadísticas de tu pala y tus números más específicos.</p></div></a></div></div></section>

<section style="background:var(--card);border-top:1px solid var(--line)"><div class="w">
<div class="head rv"><div><span class="kicker">Dentro de la app</span><h2>Cinco secciones.<br>Todo el pádel.</h2></div><p>La barra inferior de Point tiene solo lo que necesitas, siempre a un toque.</p></div>
<div class="g5">
<a class="card rv" href="app.php"><div class="ico"><?= tab_icono('inicio') ?></div><h3>Inicio</h3><p>Tu resumen: nivel, partidos, horas, calorías y lo que viene.</p><span class="go">Ver →</span></a>
<a class="card rv" href="livematch.php"><div class="ico"><?= tab_icono('live') ?></div><h3>Live Match</h3><p>Inicia el partido, lleva el puntaje y mira tus estadísticas en vivo.</p><span class="go">Ver →</span></a>
<a class="card rv" href="play.php"><div class="ico"><?= tab_icono('play') ?></div><h3>Play</h3><p>Reserva canchas, clases y americanos; encuentra partidos y torneos.</p><span class="go">Ver →</span></a>
<a class="card rv" href="raqueta.php"><div class="ico"><?= tab_icono('raqueta') ?></div><h3>Mi raqueta</h3><p>Las estadísticas de tu pala y tus números más específicos.</p><span class="go">Ver →</span></a>
<a class="card rv" href="perfil.php"><div class="ico"><?= tab_icono('perfil') ?></div><h3>Perfil</h3><p>Tus datos básicos, privacidad y configuración.</p><span class="go">Ver →</span></a>
</div></div></section>

<section class="sim" id="probala"><div class="w split">
<div><span class="kicker">Pruébala</span><h2 class="rv">Un golpe. Todas las estadísticas.</h2>
<p class="lead rv" style="margin-top:20px">Así registra Point cada golpe de tu partido: velocidad, tipo de golpe y si pegaste en el punto dulce de tu pala. Elige un golpe y simúlalo.</p>
<div class="simstats">
<div><b id="sGolpes">0</b><small>golpes</small></div>
<div><b id="sVel">0</b><small>km/h último golpe</small></div>
<div><b id="sHr">118</b><small>lpm ritmo cardíaco</small></div>
<div><b id="sDulce">0%</b><small>en el punto dulce</small></div></div>
<div class="simbtns" id="simShots">
<button class="chip on" data-shot="drive" type="button">Drive</button>
<button class="chip" data-shot="reves" type="button">Revés</button>
<button class="chip" data-shot="bandeja" type="button">Bandeja</button>
<button class="chip" data-shot="volea" type="button">Volea</button>
<button class="btn" id="simGo" type="button" style="border:0;cursor:pointer">Simular golpe</button></div>
<p class="hint">Mueve el mouse (o el dedo) sobre la cancha para mover la raqueta, o toca la cancha para pegarle a la pelota.</p></div>
<div class="simstage" id="simStage" aria-label="Simulación de un golpe de pádel">
<svg viewBox="0 0 400 500" role="img" aria-label="Raqueta de pádel y pelota">
<defs>
<pattern id="holes" width="16" height="16" patternUnits="userSpaceOnUse"><circle cx="8" cy="8" r="3" fill="#C6FF3D" fill-opacity=".55"/></pattern>
<radialGradient id="hg"><stop offset="0" stop-color="#C6FF3D" stop-opacity=".9"/><stop offset="1" stop-color="#C6FF3D" stop-opacity="0"/></radialGradient>
</defs>
<rect x="18" y="18" width="364" height="464" rx="16" fill="none" stroke="#fff" stroke-opacity=".5" stroke-width="3"/>
<path d="M18 170H382M200 170V482" stroke="#fff" stroke-opacity=".35" stroke-width="3" fill="none"/>
<g id="heat"></g>
<g id="rk" transform="rotate(0 200 450)">
<rect x="190" y="292" width="20" height="170" rx="10" fill="#0B0F14"/>
<rect x="190" y="360" width="20" height="8" fill="#C6FF3D"/><rect x="190" y="384" width="20" height="8" fill="#C6FF3D"/><rect x="190" y="408" width="20" height="8" fill="#C6FF3D"/>
<path d="M176 262 200 312 224 262Z" fill="#0B2D6B"/>
<ellipse cx="200" cy="190" rx="74" ry="94" fill="#0B2D6B" stroke="#C6FF3D" stroke-width="8"/>
<ellipse cx="200" cy="190" rx="62" ry="82" fill="#0052CC"/>
<ellipse cx="200" cy="190" rx="62" ry="82" fill="url(#holes)"/>
<circle cx="200" cy="175" r="24" fill="none" stroke="#fff" stroke-opacity=".8" stroke-width="2" stroke-dasharray="5 5"/>
<circle id="imp" cx="200" cy="175" r="7" fill="#fff" opacity="0"/>
</g>
<circle id="ball" cx="-60" cy="-60" r="12" fill="#C6FF3D" stroke="#fff" stroke-width="2"/>
<text id="tagt" x="200" y="60" text-anchor="middle" fill="#fff" font-family="Outfit,sans-serif" font-size="28" font-weight="700" opacity="0"></text>
</svg></div></div></section>

<section><div class="w"><div class="head rv"><div><span class="kicker">Play</span><h2>Todo lo que puedes<br>hacer en la cancha.</h2></div><p>Desde reservar hasta jugar un torneo, sin salir de la app.</p></div>
<div class="g3">
<a class="card rv" href="play.php#reservar-cancha"><div class="ico">01</div><h3>Reservar cancha</h3><p>Elige club, día y horario, y paga con Apple Pay o tarjeta.</p></a>
<a class="card rv" href="play.php#clases"><div class="ico">02</div><h3>Clases</h3><p>Anótate en clases de tu nivel y mira los cupos disponibles.</p></a>
<a class="card rv" href="play.php#americanos"><div class="ico">03</div><h3>Americanos</h3><p>Súmate a un americano; los jugadores eligen el formato.</p></a>
<a class="card rv" href="play.php#partidos-abiertos"><div class="ico">04</div><h3>Partidos abiertos</h3><p>Encuentra partidos a los que les falta un jugador de tu nivel.</p></a>
<a class="card rv" href="play.php#torneos"><div class="ico">05</div><h3>Torneos</h3><p>Inscríbete por categoría y sigue tus fases: grupos, octavos y cuartos.</p></a>
<a class="card rv" href="play.php#canchas-abiertas"><div class="ico">06</div><h3>Canchas abiertas</h3><p>Mira qué canchas están libres ahora cerca de ti.</p></a>
</div></div></section>

<section class="dark"><div class="w split">
<div><span class="kicker">Para clubes</span><h2 class="rv">¿Tienes un club? Súmalo a Point.</h2>
<p class="lead rv" style="margin-top:20px">Los jugadores no pagan nada. Los clubes se suscriben para que sus socios reserven canchas y jueguen americanos y torneos desde la app.</p>
<p style="margin-top:28px"><a class="btn" href="planes.php">Ver planes para clubes</a></p></div>
<div class="g2"><div class="card nv rv"><span class="kicker" style="color:var(--lime)">Básico</span><h3 style="font-size:36px;margin:0">USD 200</h3><p style="margin-top:10px">Reserva de canchas desde la app e imágenes de tu club.</p></div>
<div class="card rv" style="background:var(--lime);color:var(--ink);border:0"><span class="kicker" style="color:var(--ink)">Completo</span><h3 style="font-size:36px;margin:0">USD 300</h3><p style="margin-top:10px;color:#1f2a10">Todo lo del Básico, más sesión de fotos para coaches, publicidad por notificaciones, americanos y torneos automáticos.</p></div></div>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
