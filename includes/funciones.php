<?php
function evitarEjecucionScript() {
 // Esta funcion evita que se ejecuten directamente desde el navegador de los script's que se encuentran en /pages
    $scriptname = pathinfo($_SERVER['PHP_SELF']);
    if($scriptname['basename'] != "index.php"){
    $uri = 'http://';
    $uri .= $_SERVER['HTTP_HOST'];
    header('Location: ../');
    exit;
    }
}

?>