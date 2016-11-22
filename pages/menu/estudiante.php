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
#funciones comunes para menu de usuario
include 'funcionesMenu.php';
#chequeo si tiene permisos y muestro menus correspondiente
if($permisos_usuario["activo"]==1){
    #menus asignados a esta categoria
    $array = array(
        'menuConsultasEstudiantiles.html', 
        );
        echo '<h4></h4>';
mostrarMenuUsuarios($array);
}
if($permisos_usuario["inactivo"]==1){
    #menus asignados a esta categoria
    $array = array(
        '', 
        '',
        '',
        '',
        '',
        '',
        );
        echo '<h4>Menú de Estudiante Inactivo</h4>';
mostrarMenuUsuarios($array);
}
if($permisos_usuario["graduado"]==1){
    #menus asignados a esta categoria
    $array = array(
        '', 
        '',
        '',
        '',
        '',
        '',
        );
        echo '<h4>Menú de Estudiante Graduado</h4>';
mostrarMenuUsuarios($array);
}
#salida para los errores.
error:
?>