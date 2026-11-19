<?php
// ============================================================
//  preguntas.php: preguntas frecuentes, leídas de la tabla `faqs`.
// ============================================================
$titulo='Preguntas'; $slug='preguntas';
require __DIR__ . '/includes/header.php';
// Se leen las preguntas de la BD en el orden indicado por la columna `orden`
$faqs = db()->query('SELECT pregunta, respuesta FROM faqs ORDER BY orden')->fetchAll();
?>
<section class="page" id="faq"><div class="w" style="max-width:820px"><h2 style="margin-bottom:32px">Preguntas frecuentes</h2>
<?php foreach ($faqs as $f): ?>
<details><summary><?= e($f['pregunta']) ?></summary><p><?= e($f['respuesta']) ?></p></details>
<?php endforeach; ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
