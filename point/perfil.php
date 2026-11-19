<?php
// ============================================================
//  perfil.php: pantallas de ejemplo del perfil de la app (perfil, privacidad, ajustes).
//  $titulo = título de la pestaña; $slug = opción resaltada en el menú.
// ============================================================
$titulo='Perfil'; $slug='perfil'; require __DIR__ . '/includes/header.php'; ?>
<section class="page"><div class="w">
<div class="head rv"><div><span class="kicker">Perfil</span><h2>Tú, en la cancha.<br>Y tú, en control.</h2></div><p>Tus datos básicos, cómo juegas y qué quieres compartir.</p></div>
<div class="flow">

<div class="rv"><?php phone_start('Perfil','perfil'); ?>
<div class="row"><span class="av" style="width:52px;height:52px;font-size:20px">M</span><div><h4>Martina S.</h4><small>Intermedio + · Nivel 3.5</small></div></div>
<div class="mini"><span>Lado de juego</span><b style="font-size:13px">Drive</b></div>
<h4 style="margin-top:14px">Parejas habituales</h4>
<div class="mini"><span class="row"><span class="av l">L</span> Luca F.</span><small>Revés</small></div>
<div class="mini"><span class="row"><span class="av">S</span> Sofi R.</span><small>Drive</small></div>
<h4 style="margin-top:14px">Partidos pasados</h4>
<div class="mini"><span>vs Juan P. / Sofi R.</span><b style="font-size:13px;color:#16a34a">Ganado</b></div>
<?php phone_end('perfil'); ?><div class="cap"><b>Tu perfil</b><span>Nivel, lado de juego, parejas habituales y partidos pasados.</span></div></div>

<div class="rv"><?php phone_start('Editar perfil','perfil'); ?>
<small>Nombre</small><div class="mini" style="margin-top:2px">Martina S.</div>
<small style="display:block;margin-top:10px">Nivel</small><div class="mini" style="margin-top:2px"><span>Intermedio +</span><span>▾</span></div>
<small style="display:block;margin-top:10px">Lado que juegas</small>
<div style="margin-top:4px"><span class="pi on">Drive</span><span class="pi">Revés</span><span class="pi">Ambos</span></div>
<small style="display:block;margin-top:10px">Dispositivos</small>
<div class="mini"><span>Token Point</span><small>Conectado</small></div>
<div class="mini"><span>Apple Watch</span><small>Conectado</small></div>
<span class="cta-m b">Guardar cambios</span>
<?php phone_end('perfil'); ?><div class="cap"><b>Editar perfil</b><span>Cambia tus datos, tu lado de juego y tus dispositivos.</span></div></div>

<div class="rv"><?php phone_start('Privacidad','perfil'); ?>
<h4>¿Quién ve tu actividad?</h4>
<div class="mini"><span>Perfil público</span><i class="tg on"></i></div>
<div class="mini"><span>Mostrar mis estadísticas</span><i class="tg"></i></div>
<div class="mini"><span>Aparecer en partidos abiertos</span><i class="tg on"></i></div>
<div class="mini"><span>Recibir invitaciones</span><i class="tg on"></i></div>
<p style="margin-top:14px;color:#5b6b85">Puedes cambiar entre perfil privado y público cuando quieras.</p>
<?php phone_end('perfil'); ?><div class="cap"><b>Privacidad</b><span>Tú decides qué se ve y quién puede invitarte.</span></div></div>

<div class="rv"><?php phone_start('Configuración','perfil'); ?>
<div class="mini"><span>Preferencias de la app</span><span>›</span></div>
<small style="display:block;margin:2px 4px 0">Idioma · Unidades · Apariencia</small>
<div class="mini"><span>Ayuda y soporte</span><span>›</span></div>
<small style="display:block;margin:2px 4px 0">Preguntas frecuentes · Contacto</small>
<div class="mini"><span>Información legal</span><span>›</span></div>
<small style="display:block;margin:2px 4px 0">Términos, condiciones y políticas</small>
<div class="mini" style="justify-content:center;font-weight:600">Cerrar sesión</div>
<div class="mini" style="justify-content:center;font-weight:600;color:#e11d48">Eliminar cuenta</div>
<?php phone_end('perfil'); ?><div class="cap"><b>Configuración</b><span>Preferencias, ayuda, información legal y tu cuenta.</span></div></div>

</div></div></section>

<section class="dark page"><div class="w" style="text-align:center"><h2 class="rv">Crea tu cuenta gratis.</h2>
<p class="lead rv" style="margin:20px auto 28px">Regístrate para seguir tu progreso y cumplir tus objetivos.</p>
<a class="btn" href="progresa.php">Crear cuenta</a></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
