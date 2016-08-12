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
        <strong>Error:</strong> '.$mensaje.' ';
    if ($link=="inicio"){
        echo '<a href="index.php"> Ir a Inicio</a></div></div>';        
    }else{
        echo '<a href="'.$_SERVER['REQUEST_URI'].'"> Volver Atrás</a></div></div>';
    }
}

function mensajeSuccess($mensaje, $link) {
    #Muestra mensaje de error
    echo '<div class="page-header">
        <div class="alert alert-success" role="alert">
        <strong>Listo:</strong> '.$mensaje.' ';
    if ($link=="inicio"){
        echo '<a href="index.php"> Ir a Inicio</a></div></div>';        
    }else{
        echo '<a href="'.$_SERVER['REQUEST_URI'].'"> Volver Atrás</a></div></div>';
    }
}

function generateCode($characters) {
/* list all possible characters, similar looking characters and vowels have been removed */
    $possible = '23456789bcdfghjkmnpqrstvwxyzBCDFGHJKMNPQRSTVWXYZ';
    $code = '';
    $i = 0;
    while ($i < $characters) { 
	$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
	$i++;
	}
	return $code;
}

?>