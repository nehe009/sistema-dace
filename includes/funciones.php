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


function mensajeError($mensaje, $link) {
    #Muestra mensaje de error
    echo '<div class="page-header">
        <div class="alert alert-danger" role="alert">
        <strong>Error:</strong> '.$mensaje.'        
        
        ';
    if ($link=="inicio"){
        echo '<a href="index.php">Ir a Inicio</a></div></div>';        
    }else{
        echo '<a href="'.$_SERVER['REQUEST_URI'].'">Volver Atrás</a></div></div>';
    }
}

?>