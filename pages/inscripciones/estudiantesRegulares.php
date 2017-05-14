<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (!isset($sesion_usuario)) {
    mensajeError("No has iniciado sesión.",'inicio','Ir a Inicio');
    goto error;
}
#Permite que solamente estudiantes entren a este modulo.
if(!$permisos_usuario["estudiante"]==1){
    mensajeError("No tienes permiso para entrar a este módulo.",'inicio','Ir a Inicio');
    goto error;
}
if(isset($_POST['ok'])){
    
} else {

    include("formEstudiantesRegulares.html");
}





#salida para los errores.
error:
?>
