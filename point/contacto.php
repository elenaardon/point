<?php
// ============================================================
//  contacto.php: formulario de contacto (método POST).
//  Valida los datos y los guarda en la tabla `contactos`. No requiere sesión.
// ============================================================
require __DIR__ . '/includes/init.php';
$titulo='Contacto'; $slug='contacto';
$error = null;   // mensaje de error para mostrar en el formulario
// Datos del formulario; se vuelven a mostrar en los campos si hay un error
$datos = ['nombre'=>'','email'=>'','asunto'=>'','mensaje'=>''];

// ---- $_POST: guardar el mensaje en la tabla `contactos` ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se leen los 4 campos del formulario y se validan uno por uno
    foreach ($datos as $k => $v) { $datos[$k] = post($k); }
    if ($datos['nombre'] === '')                                   $error = 'Escribe tu nombre.';
    elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL))   $error = 'Escribe un correo válido.';
    elseif ($datos['asunto'] === '')                               $error = 'Escribe el asunto.';
    elseif (mb_strlen($datos['mensaje']) < 10)                     $error = 'El mensaje debe tener al menos 10 caracteres.';
    else {
        // Datos válidos: se guarda el mensaje en la BD (consulta preparada) y se redirige
        // con ?enviado=1 para mostrar el aviso de "Gracias".
        db()->prepare('INSERT INTO contactos (nombre, email, asunto, mensaje) VALUES (?, ?, ?, ?)')
            ->execute([$datos['nombre'], $datos['email'], $datos['asunto'], $datos['mensaje']]);
        header('Location: contacto.php?enviado=1'); exit;
    }
}
require __DIR__ . '/includes/header.php';
?>
<section class="page"><div class="w" style="max-width:640px"><div class="head"><h2>Contacto.</h2><p>¿Dudas, ideas o comentarios? Escríbenos y te respondemos.</p></div>
<div class="authbox">
<!-- Aviso de éxito (llega por $_GET['enviado']) o de error de validación -->
<?php if (isset($_GET['enviado'])): ?><div class="alert ok">¡Gracias! Recibimos tu mensaje.</div><?php endif; ?>
<?php if ($error): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
<!-- Formulario: envía nombre, correo, asunto y mensaje por POST a esta misma página -->
<form method="post" action="contacto.php">
<label>Nombre<input class="fld" name="nombre" maxlength="100" required value="<?= e($datos['nombre']) ?>"></label>
<label>Correo<input class="fld" name="email" type="email" maxlength="150" required value="<?= e($datos['email']) ?>"></label>
<label>Asunto<input class="fld" name="asunto" maxlength="100" required value="<?= e($datos['asunto']) ?>"></label>
<label>Mensaje<textarea class="fld" name="mensaje" rows="5" required><?= e($datos['mensaje']) ?></textarea></label>
<button class="btn" style="background:var(--blue);color:#fff" type="submit">Enviar mensaje</button>
</form></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
