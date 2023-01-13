<?php

define("ITEMS_POR_PAGINA", 10);
// Necesario para pasarlo a los prepared statement de mysqli
$ITEMS_POR_PAGINA = ITEMS_POR_PAGINA;

function gen_pagination(int $numero_pagina, int $total_items) {
    $total_paginas = ceil($total_items / ITEMS_POR_PAGINA);
    $offset = $numero_pagina - 1;
    $rango_inicio = $offset * ITEMS_POR_PAGINA + 1;
    $rango_fin    = $rango_inicio + ITEMS_POR_PAGINA - 1;

    // Si es la ultima pagina, ajustar el contador de elementos
    if ($numero_pagina == $total_paginas) {
        $rango_fin = $rango_inicio + ($total_items % ITEMS_POR_PAGINA) - 1;
    }

    // Si no hay items, mostramos un mensaje alternativo
    if ($total_items == 0) {
        return <<<HTML
        <div class='pagination'>
            <p class='pagination-info'>
            Página 0 de 0<br>
            (Items 0-0 de 0 total)
            </p>
        </div>
        HTML;
    }

    $pagina_siguiente = $numero_pagina + 1;
    $pagina_anterior = $numero_pagina - 1;

    $anterior_hidden = null;
    if ($numero_pagina <= 1) {
        $anterior_hidden = "pagination-hidden";
    }
    

    $siguiente_hidden = null;
    if ($numero_pagina >= $total_paginas) {
        $siguiente_hidden = "pagination-hidden";
    }

    // Preparar las secciones del paginador

    $boton_anterior = <<<HTML
    <a class='pagination-button $anterior_hidden' href='?pagina=$pagina_anterior'>
        <span class='fa fa-fw fa-chevron-left'></span>
        <span>Página anterior</span>
    </a>
    HTML;

    $info_paginacion = <<<HTML
    <p class='pagination-info'>
        Página $numero_pagina de $total_paginas<br>
        (Items $rango_inicio-$rango_fin de $total_items total)
    </p>
    HTML;

    $boton_siguiente = <<<HTML
    <a class='pagination-button $siguiente_hidden' href='?pagina=$pagina_siguiente'>
        <span>Página siguiente</span>
        <span class='fa fa-fw fa-chevron-right'></span>
    </a>
    HTML;

    // Construir el resultado final

    $paginacion = <<<HTML
    <div class="pagination">
    HTML;

    $paginacion .= $boton_anterior;
    $paginacion .= $info_paginacion;
    $paginacion .= $boton_siguiente;

    $paginacion .= <<<HTML
    </div>
    HTML;


    return $paginacion;
}
