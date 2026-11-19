<?php
// ============================================================
//  logout.php: cierra la sesión del usuario.
// ============================================================
require __DIR__ . '/includes/init.php';   // inicia la sesión
$_SESSION = [];                           // borra los datos guardados (id y nombre)
session_destroy();                        // destruye la sesión
header('Location: progresa.php');         // vuelve a la página de login / registro
exit;
