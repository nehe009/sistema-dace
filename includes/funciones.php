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


function mensajeError($mensaje) {
    #Muestra mensaje de error
    echo '<div class="page-header">
        <div class="alert alert-danger" role="alert">
        <strong>Error:</strong> '.$mensaje.'        
        <a href="'.$_SERVER['REQUEST_URI'].'">Atrás</a></div></div>
        ';
}

?>