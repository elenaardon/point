<?php
// ============================================================
//  progresa.php: crear cuenta, iniciar sesión y panel privado del usuario.
//  - Tiene dos formularios (método POST): registro y login.
//  - Usa sesiones de PHP ($_SESSION): al iniciar sesión se guardan el id y
//    el nombre del usuario. Con sesión se muestra la ZONA SEGURA (panel).
//  - Tablas que usa: usuarios, planes, palas, marcas y favoritos.
// ============================================================
require __DIR__ . '/includes/init.php';
$titulo='Progresa'; $slug='progresa';   // título de la pestaña y opción del menú
// Conexión a la base de datos (función db() de includes/init.php)
$pdo = db();
// Mensaje de error que se mostrará en el formulario (null = no hay error)
$error = null;
// $tab decide qué pestaña se ve: 'registro' (por defecto) o 'login'.
// Viene de $_POST['accion'] al enviar un formulario, o de $_GET['tab'] por el enlace ?tab=login
$tab = (($_POST['accion'] ?? $_GET['tab'] ?? '') === 'login' || ($_GET['tab'] ?? '') === 'login') ? 'login' : 'registro';

// Esto solo se ejecuta cuando el usuario envió un formulario (método POST).
// Cada formulario manda un campo oculto 'accion' para saber cuál fue.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = post('accion');

    if ($accion === 'registro') {                         // ---- CREAR CUENTA ----
        $tab = 'registro';
        // Se leen los datos del formulario (post() les quita los espacios sobrantes)
        $nombre = post('nombre'); $email = strtolower(post('email')); $pass = (string)($_POST['pass'] ?? '');
        // Validaciones en el servidor: nombre, correo válido, contraseña de 8+ caracteres y términos
        if ($nombre === '')                                   $error = 'Escribe tu nombre.';
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))   $error = 'Escribe un correo válido.';
        elseif (strlen($pass) < 8)                            $error = 'La contraseña debe tener al menos 8 caracteres.';
        elseif (empty($_POST['terms']))                       $error = 'Debes aceptar los términos.';
        else {
            // Se revisa que el correo no esté ya registrado (en la BD el email es UNIQUE)
            $existe = $pdo->prepare('SELECT 1 FROM usuarios WHERE email = ?');
            $existe->execute([$email]);
            if ($existe->fetchColumn()) { $error = 'Ese correo ya está registrado. Inicia sesión.'; }
            else {
                // Se guarda el usuario nuevo con el plan 1 (Jugadores). La contraseña se cifra con
                // password_hash(): nunca se guarda en texto plano. Los ? son una consulta preparada
                // (evita la inyección SQL).
                $pdo->prepare('INSERT INTO usuarios (nombre, email, password_hash, id_plan) VALUES (?, ?, ?, 1)')
                    ->execute([$nombre, $email, password_hash($pass, PASSWORD_DEFAULT)]);
                // Se inicia sesión con la cuenta recién creada: se cambia el ID de sesión (más seguro)
                // y se guardan el id y el nombre del usuario en $_SESSION.
                session_regenerate_id(true);
                $_SESSION['id_usuario'] = (int)$pdo->lastInsertId();
                $_SESSION['nombre'] = $nombre;
                // Se redirige para que, si se recarga la página, el formulario no se envíe otra vez
                header('Location: progresa.php?registro=ok'); exit;
            }
        }
    } elseif ($accion === 'login') {                      // ---- INICIAR SESIÓN ----
        $tab = 'login';
        $email = strtolower(post('email')); $pass = (string)($_POST['pass'] ?? '');
        // Se busca al usuario por su correo
        $st = $pdo->prepare('SELECT id_usuario, nombre, password_hash FROM usuarios WHERE email = ?');
        $st->execute([$email]);
        $u = $st->fetch();
        // password_verify() compara la contraseña escrita con el hash guardado en la base de datos.
        // Si coincide, se crea la sesión (se guardan id y nombre en $_SESSION).
        if ($u && password_verify($pass, $u['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['id_usuario'] = (int)$u['id_usuario'];
            $_SESSION['nombre'] = $u['nombre'];
            header('Location: progresa.php?login=ok'); exit;
        }
        // Si no coincidió, se muestra un error (sin decir cuál de los dos datos falló)
        $error = 'Correo o contraseña incorrectos.';
    }
}

// ---- ZONA SEGURA ----
// usuario_actual() devuelve los datos guardados en la sesión, o null si no hay sesión.
// Solo si hay sesión se consultan los datos privados del usuario (plan, pala y favoritas).
$user = usuario_actual();
$perfil = null;
if ($user) {
    $st = $pdo->prepare("SELECT u.nombre, u.email, u.fecha_registro, pl.nombre AS plan, CONCAT(m.nombre, ' ', pa.modelo) AS pala
        FROM usuarios u
        JOIN planes pl ON pl.id_plan = u.id_plan
        LEFT JOIN palas pa ON pa.id_pala = u.id_pala_actual
        LEFT JOIN marcas m ON m.id_marca = pa.id_marca
        WHERE u.id_usuario = ?");
    $st->execute([$user['id']]);
    $perfil = $st->fetch();
}
// Palas favoritas del usuario (tabla favoritos unida con palas y marcas)
$favs = [];
if ($user) {
    $st = $pdo->prepare("SELECT CONCAT(m.nombre, ' ', pa.modelo) AS pala FROM favoritos f
        JOIN palas pa ON pa.id_pala = f.id_pala
        JOIN marcas m ON m.id_marca = pa.id_marca
        WHERE f.id_usuario = ? ORDER BY f.fecha_agregado DESC");
    $st->execute([$user['id']]);
    $favs = $st->fetchAll(PDO::FETCH_COLUMN);
}
require __DIR__ . '/includes/header.php';
?>
<section class="page"><div class="w auth"><div><div class="ic" style="color:var(--blue)">3</div><h2 style="margin-top:20px">Progresa.</h2><p style="margin-top:20px;color:var(--mut)">Mira tu evolución, compara partidos y cumple objetivos y logros para seguir mejorando.</p>
<ul class="split-list" style="list-style:none;padding:0;margin:28px 0 0;display:grid;gap:14px"><li>Evolución de tu nivel partido a partido</li><li>Objetivos, rachas y logros</li><li>Comparación entre partidos</li></ul></div>
<div class="authbox">
<!-- ZONA SEGURA: este panel solo se ve con sesión iniciada. Sin sesión se muestran los formularios (más abajo). -->
<?php if ($perfil): ?>
<?php if (isset($_GET['registro'])): ?><div class="alert ok">¡Cuenta creada! Ya puedes empezar a seguir tu progreso.</div><?php endif; ?>
<?php if (isset($_GET['login'])): ?><div class="alert ok">¡Bienvenido de vuelta!</div><?php endif; ?>
<div class="hello"><h3>Hola, <?= e($perfil['nombre']) ?></h3><a href="logout.php">Cerrar sesión</a></div>
<div class="mini"><span><small>Correo</small><br><b style="font-size:16px"><?= e($perfil['email']) ?></b></span></div>
<div class="mini"><span><small>Plan</small><br><b style="font-size:16px"><?= e($perfil['plan']) ?></b></span></div>
<div class="mini"><span><small>Tu pala</small><br><b style="font-size:16px"><?= e($perfil['pala'] ?? 'Aún no la eliges') ?></b></span><a href="raqueta.php" style="color:#0066FF">Cambiar</a></div>
<div class="mini"><span><small>Palas favoritas</small><br><b style="font-size:16px"><?= $favs ? e(implode(', ', $favs)) : 'Aún no tienes favoritas' ?></b></span></div>
<?php else: ?>
<!-- SIN SESIÓN: pestañas "Crear cuenta" e "Iniciar sesión" -->
<h3 style="margin-bottom:6px">Regístrate para seguir tu progreso y cumplir tus objetivos</h3><p style="color:var(--mut);margin-bottom:20px;font-size:15px">Crea tu cuenta gratis o inicia sesión si ya tienes una.</p>
<?php if (isset($_GET['necesita'])): ?><div class="alert info">Inicia sesión para guardar tu pala.</div><?php endif; ?>
<?php if ($error): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
<div class="tabs" role="tablist"><button type="button" role="tab" id="t-reg" aria-selected="<?= $tab === 'registro' ? 'true' : 'false' ?>" aria-controls="f-reg">Crear cuenta</button><button type="button" role="tab" id="t-log" aria-selected="<?= $tab === 'login' ? 'true' : 'false' ?>" aria-controls="f-log">Iniciar sesión</button></div>
<!-- Formulario de registro: envía nombre, correo, contraseña y términos por POST a esta misma página -->
<form id="f-reg" method="post" action="progresa.php" <?= $tab === 'registro' ? '' : 'hidden' ?>><input type="hidden" name="accion" value="registro">
<label>Nombre<input class="fld" name="nombre" autocomplete="name" placeholder="Martina" required value="<?= e($tab === 'registro' ? post('nombre') : '') ?>"></label>
<label>Correo<input class="fld" name="email" type="email" autocomplete="email" placeholder="tu@correo.com" required value="<?= e($tab === 'registro' ? post('email') : '') ?>"></label>
<label>Contraseña<input class="fld" name="pass" type="password" autocomplete="new-password" placeholder="Mínimo 8 caracteres" minlength="8" required></label>
<label class="chk"><input type="checkbox" name="terms" value="1" required> Acepto los términos y la política de privacidad</label>
<button class="btn" style="background:var(--blue);color:#fff" type="submit">Crear cuenta</button></form>
<!-- Formulario de login: envía correo y contraseña por POST a esta misma página -->
<form id="f-log" method="post" action="progresa.php" <?= $tab === 'login' ? '' : 'hidden' ?>><input type="hidden" name="accion" value="login">
<label>Correo<input class="fld" name="email" type="email" autocomplete="email" placeholder="tu@correo.com" required value="<?= e($tab === 'login' ? post('email') : '') ?>"></label>
<label>Contraseña<input class="fld" name="pass" type="password" autocomplete="current-password" required></label>
<button class="btn" style="background:var(--blue);color:#fff" type="submit">Iniciar sesión</button></form>
<?php endif; ?>
</div></div></section>
<?php
// js/tabs.js: cambia entre las pestañas "Crear cuenta" e "Iniciar sesión"
$extra_js = 'js/tabs.js';
require __DIR__ . '/includes/footer.php';
?>
