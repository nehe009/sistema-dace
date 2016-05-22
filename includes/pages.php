<?php
if (!isset($_GET['page'])) {
    include("pages/inicio.php");
    } else {
        if (file_exists("pages/".$_GET['page'].".php")) {
            include("pages/".$_GET['page'].".php");
            } else {
                include("includes/url_incorrecta.php");
            }
                                
    }
?>