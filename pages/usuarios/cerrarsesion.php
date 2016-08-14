<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#Procedimiento para eliminar sesion
unset($_SESSION["sesion_usuario"]);
session_unset();
session_destroy();
header("Location: index.php");
?>