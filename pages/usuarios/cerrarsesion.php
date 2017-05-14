<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si la sesion ya esta cerrada
if (!isset($sesion_usuario)) {
    mensajeError("Ya has cerrado sesión.",'inicio','Ir a Inicio');
    goto error;
}
#Procedimiento para eliminar sesion
unset($_SESSION["sesion_usuario"]);
unset($_SESSION["permisos_usuario"]);
session_unset();
session_destroy();
#auditoria para cierre de sesion.
auditoriaUsuarios($sesion_usuario['ced_usu'],'cerro sesion',$conn2);
#desactivo bandera de usuario online
$conn2->Execute("UPDATE usuarios SET online=0 WHERE ced_usu='$sesion_usuario[ced_usu]'");
header("Location: index.php");
error:
?>