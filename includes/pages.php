<?php
if (!isset($_GET['page'])) {
    include("pages/inicio.php");
    } else {        
        $pagina = str_replace(".","/",$_GET['page']);        
        if (file_exists("pages/".$pagina.".php")) {
            include("pages/".$pagina.".php");
            } else {
                include("includes/url_incorrecta.php");
            }                   
    }
?>