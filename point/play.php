<?php
// ============================================================
//  Play: reservar canchas, clases, americanos, partidos abiertos, torneos y canchas abiertas.
//  El buscador de clubes usa $_GET['q'] y consulta la tabla `clubes` (MySQL).
// ============================================================
require_once __DIR__ . '/includes/init.php';
$titulo = 'Play'; $slug = 'play'; $extra_js = 'js/play.js';

// Texto que se escribió en el buscador de clubes (llega por $_GET). Si está vacío, se muestran todos.
$q = trim((string)($_GET['q'] ?? ''));
if ($q !== '') {
    // Búsqueda con LIKE en nombre, ciudad y país (consulta preparada)
    $st = db()->prepare("SELECT * FROM clubes WHERE CONCAT(nombre, ' ', ciudad, ' ', pais) LIKE ? ORDER BY pais, nombre");
    $st->execute(['%' . $q . '%']);
} else {
    $st = db()->query('SELECT * FROM clubes ORDER BY pais, nombre');
}
// Lista de clubes que se dibuja más abajo en la tabla
$clubes = $st->fetchAll();

require __DIR__ . '/includes/header.php';
?>
<section class="page"><div class="w">
<div class="head rv"><div><span class="kicker">Play</span><h2>Reserva, anótate<br>y a jugar.</h2></div><p>Todo lo que pasa antes de pisar la cancha, en una sola sección de la app.</p></div>
<div class="ptabs" role="tablist">
<a class="chip on" href="#reservar-cancha" data-tab="reservar-cancha">Reservar cancha</a>
<a class="chip" href="#clases" data-tab="clases">Clases</a>
<a class="chip" href="#americanos" data-tab="americanos">Americanos</a>
<a class="chip" href="#partidos-abiertos" data-tab="partidos-abiertos">Partidos abiertos</a>
<a class="chip" href="#torneos" data-tab="torneos">Torneos</a>
<a class="chip" href="#canchas-abiertas" data-tab="canchas-abiertas">Canchas abiertas</a></div>

<!-- ===== 1. RESERVAR CANCHA ===== -->
<div class="pp" id="reservar-cancha">
<div><h3>Reserva tu cancha en segundos.</h3><p class="lead">Elige el club, el día y el horario. Pagas desde la app, sin llamadas ni mensajes.</p>
<ol class="steps"><li><b>Elige tu club</b><span>Los clubes cercanos aparecen primero.</span></li><li><b>Escoge día y horario</b><span>Los horarios ocupados se ven tachados.</span></li><li><b>Selecciona la cancha</b><span>Mira cuáles están libres en ese horario.</span></li><li><b>Paga y listo</b><span>Con Apple Pay o con tarjeta.</span></li></ol></div>
<div class="two">
<div><?php phone_start('Reservar','play'); ?><h4>Club Demo Palermo</h4><small>2,4 km · 6 canchas</small>
<div style="margin-top:10px"><span class="pi">Lun 16</span><span class="pi on">Mar 17</span><span class="pi">Mié 18</span><span class="pi">Jue 19</span></div>
<div class="slots"><span class="off">17:00</span><span>18:30</span><span class="on">20:00</span><span>21:30</span><span class="off">23:00</span><span>00:30</span></div>
<div class="mini"><span>Cancha 3 · 90 min</span><b style="font-size:13px">$ 24.000</b></div>
<span class="cta-m b">Continuar</span><?php phone_end('play'); ?></div>
<div><?php phone_start('Pago','play'); ?><h4>Resumen</h4>
<div class="mini"><span>Mar 17 · 20:00</span><small>90 min</small></div>
<div class="mini"><span>Cancha 3</span><small>Club Demo Palermo</small></div>
<div class="mini"><b style="font-size:13px">Total</b><b style="font-size:14px">$ 24.000</b></div>
<h4 style="margin-top:14px">Método de pago</h4>
<div class="mini" style="border-color:#0066FF"><span>Apple Pay</span><span>●</span></div>
<div class="mini"><span>Visa •••• 4242</span><span>○</span></div>
<span class="cta-m">Pagar</span><?php phone_end('play'); ?></div></div></div>

<!-- ===== 2. CLASES ===== -->
<div class="pp" id="clases">
<div><h3>Clases de tu nivel, a un toque.</h3><p class="lead">Encuentra clases en los clubes de Point, mira cuántos lugares quedan y reserva el tuyo.</p>
<ol class="steps"><li><b>Filtra por nivel</b><span>Iniciación, intermedio o avanzado.</span></li><li><b>Mira profe, horario y cupos</b><span>Sabes cuántos lugares quedan antes de reservar.</span></li><li><b>Reserva tu lugar</b><span>La clase queda en tu agenda de la app.</span></li></ol></div>
<div class="two">
<div><?php phone_start('Clases','play'); ?><div><span class="pi on">Todas</span><span class="pi">Iniciación</span><span class="pi">Intermedio</span></div>
<div class="mini" style="display:block"><b style="font-size:13px">Iniciación</b><br><small>Prof. Ana · Mar 18:00</small><div class="bar"><i style="width:75%"></i></div><small>2 lugares libres</small></div>
<div class="mini" style="display:block"><b style="font-size:13px">Intermedio</b><br><small>Prof. Diego · Jue 19:30</small><div class="bar"><i style="width:50%"></i></div><small>4 lugares libres</small></div>
<div class="mini" style="display:block"><b style="font-size:13px">Avanzado</b><br><small>Prof. Ana · Sáb 10:00</small><div class="bar"><i style="width:100%"></i></div><small>Completa</small></div>
<?php phone_end('play'); ?></div>
<div><?php phone_start('Clase','play'); ?><h4>Intermedio</h4><small>Club Demo Palermo · Cancha 2</small>
<div class="mini"><span class="row"><span class="av">D</span> Prof. Diego</span><small>Jue 19:30</small></div>
<div class="mini"><span>Duración</span><b style="font-size:13px">60 min</b></div>
<div class="mini"><span>Cupos</span><b style="font-size:13px">4 de 8</b></div>
<span class="cta-m">Reservar lugar</span><?php phone_end('play'); ?></div></div></div>

<!-- ===== 3. AMERICANOS ===== -->
<div class="pp" id="americanos">
<div><h3>Americanos entre amigos y rivales.</h3><p class="lead">Súmate a un americano del club. La app propone dos formatos y los jugadores eligen cuál jugar.</p>
<ol class="steps"><li><b>Elige un americano</b><span>Mira fecha, hora y cuántos jugadores faltan.</span></li><li><b>Anótate</b><span>Tu lugar queda reservado.</span></li><li><b>Voten el formato</b><span>Los jugadores eligen entre las dos opciones que ofrece la app.</span></li></ol></div>
<div class="two">
<div><?php phone_start('Americanos','play'); ?>
<div class="mini" style="display:block"><b style="font-size:13px">Americano de jueves</b><br><small>Jue 20:00 · Club Demo Palermo</small><div class="bar"><i style="width:75%"></i></div><small>12 de 16 jugadores</small></div>
<div class="mini" style="display:block"><b style="font-size:13px">Americano mixto</b><br><small>Sáb 17:00 · Club Demo Belgrano</small><div class="bar"><i style="width:37%"></i></div><small>6 de 16 jugadores</small></div>
<span class="cta-m b">Anotarme</span><?php phone_end('play'); ?></div>
<div><?php phone_start('Formato','play'); ?><h4>Elijan el formato</h4><small>Vota cada jugador</small>
<div class="mini" style="display:block;border-color:#0066FF"><b style="font-size:13px">Opción A · Parejas rotativas</b><div class="bar"><i style="width:68%"></i></div><small>8 votos</small></div>
<div class="mini" style="display:block"><b style="font-size:13px">Opción B · Parejas fijas</b><div class="bar"><i style="width:32%"></i></div><small>4 votos</small></div>
<span class="cta-m">Confirmar voto</span><?php phone_end('play'); ?></div></div></div>

<!-- ===== 4. PARTIDOS ABIERTOS ===== -->
<div class="pp" id="partidos-abiertos">
<div><h3>Siempre hay un partido esperándote.</h3><p class="lead">Encuentra partidos a los que les falta un jugador de tu nivel y únete sin armar grupos.</p>
<ol class="steps"><li><b>Filtra por nivel y horario</b><span>Solo ves partidos que van con tu juego.</span></li><li><b>Mira quién juega</b><span>Y qué lado necesitan: drive o revés.</span></li><li><b>Únete</b><span>Y habla con el grupo desde el chat del partido.</span></li></ol></div>
<div class="two">
<div><?php phone_start('Partidos abiertos','play'); ?>
<div class="mini" style="display:block"><b style="font-size:13px">Jue 19:30 · Nivel 3.5</b><br><small>Club Demo Palermo</small><br><small>3 de 4 · Busca revés</small></div>
<div class="mini" style="display:block"><b style="font-size:13px">Vie 21:00 · Nivel 3.0</b><br><small>Club Demo Belgrano</small><br><small>2 de 4 · Busca drive</small></div>
<div class="mini" style="display:block"><b style="font-size:13px">Sáb 10:00 · Nivel 4.0</b><br><small>Club Demo Palermo</small><br><small>3 de 4 · Busca cualquier lado</small></div>
<?php phone_end('play'); ?></div>
<div><?php phone_start('Partido','play'); ?><h4>Jue 19:30 · Cancha 3</h4><small>Club Demo Palermo</small>
<div class="row" style="margin:14px 0"><span class="av">J</span><span class="av l">S</span><span class="av">L</span><span class="av" style="background:none;border:2px dashed #0066FF;color:#0066FF">?</span></div>
<div class="mini"><span>Falta</span><b style="font-size:13px">Revés</b></div>
<div class="mini"><span>Nivel</span><b style="font-size:13px">3.5</b></div>
<span class="cta-m b">Unirme al partido</span><?php phone_end('play'); ?></div></div></div>

<!-- ===== 5. TORNEOS ===== -->
<div class="pp" id="torneos">
<div><h3>Compite por categoría.</h3><p class="lead">Inscríbete en torneos de tu club y sigue cada fase desde la app.</p>
<ol class="steps"><li><b>Elige un torneo</b><span>Mira categorías, fechas y premios.</span></li><li><b>Inscríbete</b><span>El club aprueba tu inscripción por categoría.</span></li><li><b>Sigue tus fases</b><span>Grupos, octavos y cuartos, con tu próximo partido siempre a la vista.</span></li></ol></div>
<div class="two">
<div><?php phone_start('Torneo','play'); ?><h4>Copa Point</h4><small>Club Demo Palermo · Sáb 22</small>
<div style="margin-top:10px"><span class="pi">5ª</span><span class="pi on">4ª</span><span class="pi">3ª</span></div>
<div class="mini"><span>Tu inscripción</span><b style="font-size:12px;color:#d97706">Pendiente de aprobación</b></div>
<div class="mini"><span>Parejas</span><b style="font-size:13px">14 / 16</b></div>
<span class="cta-m b">Inscribirme</span><?php phone_end('play'); ?></div>
<div><?php phone_start('Fases','play'); ?><div class="br"><div><h5>Grupos</h5><b>Tú · 2-0</b></div><div><h5>Octavos</h5>—</div><div><h5>Cuartos</h5>—</div></div>
<div class="br"><div class="me">Martina / Luca</div><div>Pareja B</div><div>Pareja C</div></div>
<div class="bub">Próximo partido · 18:30<br><small style="color:#1f2a10">vs Juan / Sofi · Cancha 2</small></div>
<?php phone_end('play'); ?></div></div></div>

<!-- ===== 6. CANCHAS ABIERTAS ===== -->
<div class="pp" id="canchas-abiertas">
<div><h3>¿Quieres jugar ya? Mira qué hay libre.</h3><p class="lead">Las canchas libres ahora cerca de ti, listas para reservar con un toque.</p>
<ol class="steps"><li><b>Activa tu ubicación</b><span>Point muestra los clubes cercanos.</span></li><li><b>Mira lo libre ahora</b><span>Cancha, horario y hasta cuándo está disponible.</span></li><li><b>Reserva en un toque</b><span>Y avisa a tus amigos para que lleguen.</span></li></ol></div>
<div class="two"><div><?php phone_start('Canchas abiertas','play'); ?>
<div style="height:120px;border-radius:14px;background:#dbe9ff;position:relative;overflow:hidden"><i style="position:absolute;left:22%;top:30%;width:14px;height:14px;border-radius:50%;background:#0066FF;box-shadow:0 0 0 6px #0066ff33"></i><i style="position:absolute;left:62%;top:52%;width:14px;height:14px;border-radius:50%;background:#0066FF;box-shadow:0 0 0 6px #0066ff33"></i><i style="position:absolute;left:44%;top:70%;width:14px;height:14px;border-radius:50%;background:#C6FF3D;border:2px solid #0B2D6B"></i></div>
<div class="mini"><span>Cancha 2 · Club Demo Palermo</span><b style="font-size:12px;color:#16a34a">Libre ahora</b></div>
<div class="mini"><span>Cancha 5 · Club Demo Belgrano</span><small>Libre 19:00</small></div>
<span class="cta-m b">Reservar</span><?php phone_end('play'); ?></div></div></div>

</div></section>

<!-- ===== BUSCADOR DE CLUBES (consulta MySQL con $_GET) ===== -->
<section id="clubes" style="background:var(--card);border-top:1px solid var(--line)" class="page"><div class="w">
<div class="head"><div><span class="kicker">Clubes en Point</span><h2>Encuentra tu club.</h2></div><p>Busca por nombre, ciudad o país. Estamos empezando en Argentina, El Salvador y Guatemala.</p></div>
<form class="buscador" method="get" action="play.php#clubes"><input class="fld" name="q" value="<?= e($q) ?>" placeholder="Ej. Buenos Aires, El Salvador, Palermo…" aria-label="Buscar club"><button class="btn" type="submit">Buscar</button></form>
<?php if (!$clubes): ?><div class="alert info">No encontramos clubes para «<?= e($q) ?>». Prueba con otra ciudad o país.</div>
<?php else: ?><div class="tw"><table class="tbl"><tr><th>Club</th><th>Ciudad</th><th>País</th><th>Canchas</th><th>Ofrece</th></tr>
<?php foreach ($clubes as $c): ?><tr><td><b><?= e($c['nombre']) ?></b></td><td><?= e($c['ciudad']) ?></td><td><?= e($c['pais']) ?></td><td><?= (int)$c['canchas'] ?></td><td><?= e($c['ofrece']) ?></td></tr>
<?php endforeach; ?></table></div><?php endif; ?>
<p class="note">Clubes de ejemplo para la demo. ¿Tienes un club? <a href="planes.php" style="color:var(--pad);font-weight:600">Mira los planes para clubes</a>.</p>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
