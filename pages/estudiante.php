<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (!isset($sesion_usuario)) {
    mensajeError("No has iniciado sesión.",'inicio');
    goto error;
}
#chequea si tiene permisos necesarios para acceder aca.
if($permisos_usuario["estudiante"]!=1){
    mensajeError("No tienes permisos para entrar aqui.",'inicio');
    goto error;
    }
include("menuEstudiantes.html");
#salida para los errores.
error:
?>

