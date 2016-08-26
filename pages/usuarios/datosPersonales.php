<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (!isset($sesion_usuario)) {
    mensajeError("No has iniciado sesión.",'inicio');
    goto error;    
} 

#Comprobamos si se a pulsado el boton OK
if(isset($_POST['ok'])){


} else {
    include("formDatosPersonales.html");
}
error:
?>
