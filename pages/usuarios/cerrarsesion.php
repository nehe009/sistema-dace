<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si la sesion esta cerrada
if (!isset($sesion_usuario)) {
    mensajeError("Ya has cerrado sesión.",'inicio');
    goto error;
}
#Procedimiento para eliminar sesion
unset($_SESSION["sesion_usuario"]);
session_unset();
session_destroy();
#auditoria para cierre de sesion.
auditoriaUsuarios($sesion_usuario['ced_usu'],'cerro sesion',$conn);
header("Location: index.php");
error:
?>