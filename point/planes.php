<?php
// ============================================================
//  planes.php: planes para jugadores y para clubes.
//  Lee las tablas `planes` y `plan_beneficios` de la base de datos.
// ============================================================
$titulo='Clubes'; $slug='planes';
require __DIR__ . '/includes/header.php';
// Todos los planes (Jugadores, Club Básico y Club Completo)
$planes = db()->query('SELECT * FROM planes ORDER BY id_plan')->fetchAll();
// Consulta preparada de los beneficios de un plan; se ejecuta dentro del foreach con el id de cada plan
$st = db()->prepare('SELECT texto FROM plan_beneficios WHERE id_plan = ? ORDER BY orden');
?>
<section class="page" style="background:var(--card)" id="planes"><div class="w">
<div class="head rv"><div><span class="kicker">Planes</span><h2>Gratis para jugadores.<br>Un plan para cada club.</h2></div><p>Los jugadores no pagan nada. Los clubes se suscriben para ofrecer reservas, americanos y torneos desde Point.</p></div>
<div class="plans three">
<?php foreach ($planes as $p): $st->execute([$p['id_plan']]); ?>
<div class="pl rv<?= $p['destacado'] ? ' x' : '' ?>">
<?php if ($p['destacado']): ?><span class="tagp">Más completo</span><?php endif; ?>
<h3><?= e($p['nombre']) ?></h3><small><?= (int)$p['id_plan'] === 1 ? 'Para jugadores' : 'Para clubes' ?></small><b><?= e($p['precio_texto']) ?></b><ul>
<?php foreach ($st->fetchAll() as $b): ?><li><?= e($b['texto']) ?></li><?php endforeach; ?>
</ul></div>
<?php endforeach; ?>
</div>

<?php
// Pantallas clave de la app que ve el jugador con cada plan: [archivo, título, descripción]
$pantallas = [
  'Club Básico · USD 200' => [
    ['club-reservar-lista','Elige tu club','Tu club aparece con las imágenes de sus canchas.'],
    ['club-reservar-horarios','Escoge el horario','Horarios libres del día para reservar.'],
    ['club-reserva-lista','Reserva lista','Confirmación e invitación a los jugadores.'],
  ],
  'Club Completo · USD 300' => [
    ['club-notificacion-cancha-abierta','Publicidad en notificaciones','Tu club le avisa a los jugadores cuándo hay cancha abierta.'],
    ['club-americano','Americanos','Rondas, canchas y carga del resultado.'],
    ['club-llave-torneo','Llave del torneo','La llave avanza sola al cargar el resultado.'],
  ],
];
?>
<?php foreach ($pantallas as $titulo_plan => $lista): ?>
<div class="head rv" style="margin-top:56px"><div><span class="kicker">Lo que ven tus jugadores</span><h2 style="font-size:30px"><?= e($titulo_plan) ?></h2></div></div>
<div class="flow clubscreens">
<?php foreach ($lista as [$img, $t, $d]): ?>
<div class="rv"><img class="shot" src="assets/img/app/<?= e($img) ?>.webp" alt="<?= e($t) ?>" loading="lazy"><div class="cap" style="color:var(--ink)"><b><?= e($t) ?></b><span style="color:var(--mut)"><?= e($d) ?></span></div></div>
<?php endforeach; ?>
</div>
<?php endforeach; ?>
<p style="margin-top:40px"><a class="btn" style="background:var(--blue);color:#fff" href="contacto.php">Quiero sumar mi club</a></p>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
