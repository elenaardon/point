
<?php
// ============================================================
//  includes/ui.php: funciones que dibujan el marco de celular y los
//  íconos que se usan en las pantallas de ejemplo de la app.
// ============================================================

/** Devuelve el ícono (SVG) de una sección de la app: inicio, live, play, raqueta o perfil. */
function tab_icono(string $k): string {
    // Dibujo de cada ícono (trazos SVG)
    $p = [
        'inicio'  => '<path d="M3 11 12 3l9 8v10h-6v-6H9v6H3z"/>',
        'live'    => '<circle cx="12" cy="12" r="9"/><path d="M10 8v8l6-4z"/>',
        'play'    => '<circle cx="12" cy="12" r="9"/><path d="M3.5 9c5 3 12 3 17 0M3.5 15c5-3 12-3 17 0"/>',
        'raqueta' => '<ellipse cx="12" cy="9" rx="6" ry="7"/><path d="M12 16v6"/>',
        'perfil'  => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1-6 15-6 16 0"/>',
    ];

    return '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($p[$k] ?? '') . '</svg>';
}

/** Abre el marco de un celular de ejemplo con su título. Se cierra con phone_end(). */
function phone_start(string $titulo, string $active = ''): void {
    echo '<div class="ph"><div class="ph-top"><b>' . e($titulo) . '</b><span class="ph-dot"></span></div><div class="ph-bd">';
}

/** Cierra el marco del celular y dibuja la barra inferior; $active marca la sección activa. */
function phone_end(string $active = ''): void {
    $items = [
        'inicio' => 'Inicio',
        'live' => 'Live',
        'play' => 'Play',
        'raqueta' => 'Raqueta',
        'perfil' => 'Perfil'
    ];

    echo '</div>';

    if ($active !== '') {
        echo '<div class="ph-tabs">';

        foreach ($items as $k => $t) {
            echo '<span' . ($k === $active ? ' class="on"' : '') . '>' . tab_icono($k) . $t . '</span>';
        }

        echo '</div>';
    }

    echo '</div>';
}

