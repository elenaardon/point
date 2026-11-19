<?php
// ============================================================
//  includes/footer.php: parte de abajo que comparten todas las páginas
//  (franja de descarga, pie de página y scripts). Si la página definió
//  $extra_js, se carga ese archivo JavaScript adicional al final.
// ============================================================
?>
<div class="cta" id="descargar"><div class="w"><img class="ctalogo" src="assets/img/logo-2.png" alt="Logo Point"><h2>Cada punto cuenta. Empieza el tuyo.</h2><p>Descarga Point y registra tu próximo partido.</p><a class="btn" href="#">App Store</a> &nbsp; <a class="btn" href="#">Google Play</a></div></div>
<footer><div class="w ft"><img src="assets/img/logo-1.png" alt="Point"><span>© Point · Más que un deporte, una comunidad.</span><span>Privacidad · Términos · <a href="contacto.php">Contacto</a></span></div></footer>
<script src="js/main.js"></script>
<?php if (!empty($extra_js)): ?><script src="<?= e($extra_js) ?>"></script><?php endif; ?>
</body></html>
