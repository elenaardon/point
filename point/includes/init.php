<?php
// ============================================================
//  includes/init.php: archivo base del sitio.
//  Todas las páginas lo cargan (directa o indirectamente) y aquí se hace:
//    1) iniciar la sesión de PHP,  2) conectar a la base de datos (PDO),
//    3) definir funciones de ayuda: db(), e(), usuario_actual() y post().
// ============================================================
// Se incluye al inicio de cada página: sesión + conexión + funciones útiles.
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ui.php';
// Se inicia la sesión (si todavía no está iniciada). Gracias a esto todas las
// páginas pueden leer y guardar datos en $_SESSION (por ejemplo, quién inició sesión).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** Conexión PDO a MySQL (una sola vez por petición). */
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        // Cadena de conexión con los datos de includes/config.php
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        // ERRMODE_EXCEPTION: si una consulta falla, PHP lanza una excepción en vez de ignorar el error
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

/** Escapa texto antes de imprimirlo en HTML (evita XSS). */
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/**
 * Devuelve ['id'=>..,'nombre'=>..] del usuario con sesión o null.
 * Es la función que usan las páginas para saber si el visitante inició sesión
 * (si devuelve null, no hay sesión y no puede entrar a la zona segura).
 */
function usuario_actual(): ?array {
    return isset($_SESSION['id_usuario'])
        ? ['id' => (int)$_SESSION['id_usuario'], 'nombre' => $_SESSION['nombre'] ?? '']
        : null;
}

/** Lee un valor de $_POST ya recortado. */
function post(string $k): string { return trim((string)($_POST[$k] ?? '')); }

// Si ocurre un error (por ejemplo MySQL apagado), se muestra este mensaje amigable
// en lugar de la pantalla de error de PHP.
set_exception_handler(function (Throwable $ex) {
    http_response_code(500);
    echo '<!DOCTYPE html><meta charset="utf-8"><body style="font-family:sans-serif;max-width:640px;margin:60px auto;padding:0 20px">';
    echo '<h1>No se pudo conectar con la base de datos</h1>';
    echo '<p>Revisa que MySQL esté encendido en XAMPP, que hayas importado <code>database/point_db.sql</code> y que los datos de <code>includes/config.php</code> sean correctos.</p>';
    if (MOSTRAR_ERRORES) { echo '<pre style="background:#f3f4f6;padding:12px;white-space:pre-wrap">' . htmlspecialchars($ex->getMessage()) . '</pre>'; }
    echo '</body>';
});
