<?php

// Añadir la carpeta raiz de la aplicación a los sitios para buscar inclusiones
// También el directorio superior, solo por si acaso
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']
                                    . PATH_SEPARATOR . '..');

require 'libs/common.php';
safe_session_start();
