<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (!isset($sesion_usuario)) {
    mensajeError("No has iniciado sesión.",'inicio');
    goto error;
} else {
    include("perfil.html");
    if($permisos_usuario["estudiante"]==1){include("perfilEstudiante.html");}
}
error:
?>

