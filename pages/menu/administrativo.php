<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (!isset($sesion_usuario)) {
    mensajeError("No has iniciado sesión.",'inicio','Ir a Inicio');
    goto error;
}
#Permite que solamente administradores entren a este modulo.
if(!$permisos_usuario["administrativo"]==1){
    mensajeError("No tienes permiso para entrar a este módulo.",'inicio','Ir a Inicio');
    goto error;
}
#funciones comunes para menu de usuario
include 'funcionesMenu.php';
#chequeo si tiene permisos y muestro menus correspondiente
if($permisos_usuario["control_total"]==1){
    #menus asignados a esta categoria
    $array = array(
        'menuActualizaciones.html', 
        'menuConsultasyReportes.html',
        'menuProcesos.html',
        'menuProcesosCNU.html',
        'menuProcesosdeInscripciones.html',
        'menuUsuarios.html',
        );
        echo '<h4>Menú de administrador</h4>';
mostrarMenuUsuarios($array);
}
if($permisos_usuario["taquilla"]==1){
    #menus asignados a esta categoria
    $array = array(
        '', 
        '',
        '',
        '',
        '',
        '',
        );
        echo '<h4>Menú de Taquilla</h4>';
mostrarMenuUsuarios($array);
}
if($permisos_usuario["operador"]==1){
    #menus asignados a esta categoria
    $array = array(
        '', 
        '',
        '',
        '',
        '',
        '',
        );
        echo '<h4>Menú de Operador</h4>';
mostrarMenuUsuarios($array);
}
#salida para los errores.
error:
?>