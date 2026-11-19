<?php
// ============================================================
//  raqueta.php: buscador de palas y "Mi raqueta".
//  - $_GET: ?q=texto busca una pala y ?pala=ID muestra su ficha.
//  - $_POST: guardar como mi pala, agregar/quitar favoritos y agregar una pala nueva.
//    Estas tres acciones requieren SESIÓN iniciada (si no hay, se manda al login).
//  - Tablas que usa: palas, marcas, favoritos y usuarios.
// ============================================================
require __DIR__ . '/includes/init.php';
$titulo='Mi raqueta'; $slug='raqueta';
$pdo = db();
// Usuario con sesión iniciada (o null si el visitante no inició sesión)
$user = usuario_actual();

// ---- $_POST: guardar la pala como "mi pala" ----
// Zona segura: si no hay sesión, se redirige al login. Lo mismo pasa en las otras dos acciones.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && post('accion') === 'guardar_pala') {
    if (!$user) { header('Location: progresa.php?tab=login&necesita=1'); exit; }
    $idPala = (int)post('id_pala');
    // Se comprueba que la pala exista antes de guardarla
    $ok = $pdo->prepare('SELECT 1 FROM palas WHERE id_pala = ?');
    $ok->execute([$idPala]);
    if ($ok->fetchColumn()) {
        // Se guarda la pala elegida en el usuario que tiene la sesión iniciada
        $pdo->prepare('UPDATE usuarios SET id_pala_actual = ? WHERE id_usuario = ?')->execute([$idPala, $user['id']]);
        header('Location: raqueta.php?pala=' . $idPala . '&guardada=1'); exit;
    }
    header('Location: raqueta.php'); exit;
}

// ---- $_POST: agregar / quitar de favoritos ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && post('accion') === 'favorito') {
    if (!$user) { header('Location: progresa.php?tab=login&necesita=1'); exit; }
    $idPala = (int)post('id_pala');
    // Funciona como un interruptor: si ya era favorita se elimina; si no, se agrega
    $ya = $pdo->prepare('SELECT id_favorito FROM favoritos WHERE id_usuario = ? AND id_pala = ?');
    $ya->execute([$user['id'], $idPala]);
    if ($ya->fetchColumn()) {
        $pdo->prepare('DELETE FROM favoritos WHERE id_usuario = ? AND id_pala = ?')->execute([$user['id'], $idPala]);
    } else {
        $existe = $pdo->prepare('SELECT 1 FROM palas WHERE id_pala = ?');
        $existe->execute([$idPala]);
        if ($existe->fetchColumn()) {
            $pdo->prepare('INSERT INTO favoritos (id_usuario, id_pala) VALUES (?, ?)')->execute([$user['id'], $idPala]);
        }
    }
    header('Location: raqueta.php?pala=' . $idPala); exit;
}

// ---- $_POST: agregar una pala que no está en la lista (así el buscador sirve para cualquier pala) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && post('accion') === 'agregar_pala') {
    if (!$user) { header('Location: progresa.php?tab=login&necesita=1'); exit; }
    // Se limita el largo del texto para que quepa en las columnas de la base de datos
    $marca  = mb_substr(post('marca'), 0, 60);
    $modelo = mb_substr(post('modelo'), 0, 80);
    if ($marca === '' || $modelo === '') { header('Location: raqueta.php?q=' . urlencode($modelo) . '&faltan=1'); exit; }
    $m = $pdo->prepare('SELECT id_marca FROM marcas WHERE nombre = ?');          // ¿ya existe la marca?
    $m->execute([$marca]);
    $idMarca = $m->fetchColumn();
    if (!$idMarca) {
        $pdo->prepare('INSERT INTO marcas (nombre) VALUES (?)')->execute([$marca]);
        $idMarca = $pdo->lastInsertId();
    }
    $p = $pdo->prepare('SELECT id_pala FROM palas WHERE id_marca = ? AND modelo = ?');   // ¿ya existe el modelo?
    $p->execute([$idMarca, $modelo]);
    $idPala = $p->fetchColumn();
    if (!$idPala) {
        $pdo->prepare('INSERT INTO palas (id_marca, modelo) VALUES (?, ?)')->execute([$idMarca, $modelo]);
        $idPala = $pdo->lastInsertId();
    }
    header('Location: raqueta.php?pala=' . (int)$idPala . '&agregada=1'); exit;
}

// ---- $_GET: ?pala=ID (botones) o ?q=texto (buscador) ----
// Consulta base que se reutiliza: une cada pala con su marca
const SQL_PALA = 'SELECT p.*, m.nombre AS marca FROM palas p JOIN marcas m ON m.id_marca = p.id_marca';
$sel = null;
$resultados = [];
$texto = trim((string)($_GET['q'] ?? ''));
if (isset($_GET['pala'])) {
    $st = $pdo->prepare(SQL_PALA . ' WHERE p.id_pala = ?');
    $st->execute([(int)$_GET['pala']]);
    $sel = $st->fetch() ?: null;
} elseif ($texto !== '') {
    // Cada palabra escrita debe aparecer en "marca modelo" (ej. "bull wonder" encuentra Bullpadel Wonder 2026)
    $palabras = array_slice(preg_split('/\s+/u', $texto, -1, PREG_SPLIT_NO_EMPTY), 0, 5);
    $cond = implode(' AND ', array_fill(0, count($palabras), "CONCAT(m.nombre, ' ', p.modelo) LIKE ?"));
    $st = $pdo->prepare(SQL_PALA . ' WHERE ' . $cond . ' ORDER BY (p.imagen IS NULL), m.nombre, p.modelo LIMIT 12');
    $st->execute(array_map(fn($w) => '%' . $w . '%', $palabras));
    $resultados = $st->fetchAll();
    $sel = $resultados[0] ?? null;
} else {
    $sel = $pdo->query(SQL_PALA . " WHERE p.modelo = 'Wonder 2026' LIMIT 1")->fetch() ?: null;
}
// Todas las palas: alimentan la lista desplegable del buscador y los botones
$todas = $pdo->query(SQL_PALA . ' ORDER BY m.nombre, p.modelo')->fetchAll();

$lista  = ($texto !== '' && $resultados) ? $resultados : $todas;   // chips: resultados de la búsqueda o todas las palas
$nombre = $sel ? $sel['marca'] . ' ' . $sel['modelo'] : ($texto !== '' ? $texto : 'Tu pala');
$img    = ($sel && $sel['imagen']) ? $sel['imagen'] : 'assets/img/raqueta-generica.svg';
$bg     = ($sel && $sel['color_fondo']) ? $sel['color_fondo'] : '#ffffff';
$nivel  = ($sel && $sel['nivel']) ? $sel['nivel'] : 'Sin nivel';
$peso   = ($sel && $sel['peso_g'])      ? $sel['peso_g'] . ' g' : '—';
$bal    = ($sel && $sel['balance_cm'])  ? rtrim(rtrim(number_format((float)$sel['balance_cm'], 1, ',', ''), '0'), ',') . ' cm' : '—';
$tam    = ($sel && $sel['tamano_cm2'])  ? $sel['tamano_cm2'] . ' cm²' : '—';

// ¿La pala que se está viendo es la que el usuario guardó como suya? (solo si hay sesión)
$esMia = false;
if ($user && $sel) {
    $q = $pdo->prepare('SELECT id_pala_actual FROM usuarios WHERE id_usuario = ?');
    $q->execute([$user['id']]);
    $esMia = ((int)$q->fetchColumn() === (int)$sel['id_pala']);
}
// ¿La pala que se está viendo está en sus favoritas? (solo si hay sesión)
$esFav = false;
if ($user && $sel) {
    $q = $pdo->prepare('SELECT 1 FROM favoritos WHERE id_usuario = ? AND id_pala = ?');
    $q->execute([$user['id'], $sel['id_pala']]);
    $esFav = (bool)$q->fetchColumn();
}
require __DIR__ . '/includes/header.php';
?>
<section class="page"><div class="w"><div class="head"><h2>Tu raqueta.</h2><p>Elige o escribe cuál es tu pala y Point te muestra su ficha, tus estadísticas con ella y cómo cuidarla.</p></div>
<div class="rq"><div class="rqform">
<?php if (isset($_GET['guardada'])): ?><div class="alert ok">¡Listo! Guardamos esta pala como tu raqueta.</div><?php endif; ?>
<?php if (isset($_GET['agregada'])): ?><div class="alert ok">¡Pala agregada a Point! Ya puedes guardarla como tu raqueta.</div><?php endif; ?>
<?php if (isset($_GET['faltan'])): ?><div class="alert err">Escribe la marca y el modelo para agregar la pala.</div><?php endif; ?>
<?php if ($texto !== '' && !$sel): ?><div class="alert info">No encontramos «<?= e($texto) ?>» en nuestra lista. Te mostramos una imagen genérica.</div>
<?php if ($user): ?><form method="post" action="raqueta.php" style="margin-bottom:20px"><input type="hidden" name="accion" value="agregar_pala"><label for="marca">¿Es una pala nueva? Agrégala a Point</label>
<input id="marca" class="fld" name="marca" maxlength="60" placeholder="Marca (ej. Bullpadel)" required style="margin-bottom:8px">
<input class="fld" name="modelo" maxlength="80" placeholder="Modelo" value="<?= e($texto) ?>" required>
<p style="margin-top:12px"><button class="btn" style="background:var(--blue);color:#fff" type="submit">Agregar pala</button></p></form>
<?php else: ?><p class="note" style="margin:0 0 16px">Para agregarla a Point, <a href="progresa.php?tab=login">inicia sesión</a>.</p><?php endif; ?>
<?php endif; ?>
<form method="get" action="raqueta.php"><label for="pala">Selecciona o escribe tu pala</label><p>Empieza a escribir y elige de la lista, o escribe el modelo que usas.</p>
<input id="pala" class="fld" name="q" list="palas" placeholder="Ej. Bullpadel Wonder 2026" autocomplete="off" value="<?= e($texto) ?>">
<datalist id="palas"><?php foreach ($todas as $p): ?><option value="<?= e($p['marca'] . ' ' . $p['modelo']) ?>"><?php endforeach; ?></datalist>
<p style="margin-top:14px"><button class="btn" style="background:var(--blue);color:#fff" type="submit">Buscar pala</button></p></form>
<div class="chips">
<?php foreach ($lista as $p): ?><a class="chip<?= ($sel && $sel['id_pala'] == $p['id_pala']) ? ' on' : '' ?>" href="raqueta.php?pala=<?= (int)$p['id_pala'] ?>"><?= e($p['marca'] . ' ' . $p['modelo']) ?></a><?php endforeach; ?>
</div>
<!-- Botones "Guardar como mi pala" y "Favoritos": cada uno envía un formulario POST (requieren sesión) -->
<?php if ($sel): ?>
<?php if ($esMia): ?><p class="note"><strong>Esta es tu pala actual.</strong></p>
<?php else: ?><form method="post" action="raqueta.php" style="margin-top:20px"><input type="hidden" name="accion" value="guardar_pala"><input type="hidden" name="id_pala" value="<?= (int)$sel['id_pala'] ?>"><button class="btn" style="background:var(--lime);color:var(--ink)" type="submit">Guardar como mi pala</button>
<?php if (!$user): ?><p class="note">Necesitas <a href="progresa.php?tab=login">iniciar sesión</a> para guardarla.</p><?php endif; ?></form><?php endif; ?>
<form method="post" action="raqueta.php" style="margin-top:12px"><input type="hidden" name="accion" value="favorito"><input type="hidden" name="id_pala" value="<?= (int)$sel['id_pala'] ?>"><button class="btn" style="background:none;border:1.5px solid var(--line);color:var(--txt)" type="submit"><?= $esFav ? '★ Quitar de favoritos' : '☆ Agregar a favoritos' ?></button></form>
<?php endif; ?>
<p class="note"><a href="https://www.google.com/search?tbm=isch&amp;q=<?= urlencode($nombre . ' pala pádel') ?>" target="_blank" rel="noopener" style="color:var(--pad);font-weight:600">Ver más fotos de <?= e($nombre) ?> ↗</a></p>
<p class="note">Las palas que ves vienen de la base de datos. Busca cualquier modelo: si no está, puedes agregarlo.</p></div>
<div class="rqphone" aria-live="polite"><div class="rqtop"><span aria-hidden="true">←</span><b>Tu raqueta</b></div>
<div class="rqcard"><div class="rqhead"><b><?= e($nombre) ?></b><span class="badge"><?= e($nivel) ?></span></div>
<div class="rqimg" style="background:<?= e($bg) ?>"><img src="<?= e($img) ?>" alt="<?= e($nombre) ?>"></div>
<div class="spec"><span>Peso<b><?= e($peso) ?></b></span><span>Balance<b><?= e($bal) ?></b></span><span>Tamiz/Tamaño<b><?= e($tam) ?></b></span></div></div>
<div class="rqlist"><details><summary>Estadísticas</summary><p>Golpes, potencia y regularidad registrados con esta pala.</p></details><details><summary>En qué destaca</summary><p>Un resumen de las fortalezas de tu pala según tu estilo de juego.</p></details><details><summary>Punto dulce</summary><p>Dónde impactas más la pelota en la cara de la raqueta.</p></details><details><summary>Bandeja</summary><p>Cómo rinde tu pala en bandejas y golpes defensivos.</p></details><details><summary>Salud de la raqueta</summary><p>Desgaste de superficie y estado general de tu pala.</p></details><details><summary>Perfiles compatibles</summary><p>Jugadores de tu nivel que usan una pala parecida.</p></details></div></div></div></div></section>
<section style="background:var(--card);border-top:1px solid var(--line)" class="page"><div class="w">
<div class="head rv"><div><span class="kicker">Mis estadísticas</span><h2>Tus números,<br>más específicos.</h2></div><p>Desde Mi raqueta también entras a tus estadísticas detalladas. Los valores son de ejemplo.</p></div>
<div class="g3">
<div class="card hv rv"><small style="color:var(--mut)">Golpes con esta pala</small><h3 style="font-size:44px;margin:6px 0 0"><span data-count="1482">1.482</span></h3><p>+12% que el mes pasado</p></div>
<div class="card hv rv"><small style="color:var(--mut)">Impactos en el punto dulce</small><h3 style="font-size:44px;margin:6px 0 0"><span data-count="68" data-suf="%">68%</span></h3><p>Dónde pegas más en la cara de la pala</p></div>
<div class="card hv rv"><small style="color:var(--mut)">Velocidad promedio</small><h3 style="font-size:44px;margin:6px 0 0"><span data-count="87" data-suf=" km/h">87 km/h</span></h3><p>Drive, revés, bandeja y volea</p></div>
</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
