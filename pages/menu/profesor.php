<br>
<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (!isset($sesion_usuario)) {
    mensajeError("No has iniciado sesión.",'inicio','Ir a Inicio');
    goto error;
}
#Permite que solamente profesores entren a este modulo.
if(!$permisos_usuario["profesor"]==1){
    mensajeError("No tienes permiso para entrar a este módulo.",'inicio','Ir a Inicio');
    goto error;
}
#funciones comunes para menu de usuario
include 'funcionesMenu.php';
#chequeo si tiene permisos de evaluador
if($permisos_usuario["evaluador"]==1){
    #menus asignados a esta categoria
    $array = array(
        'menuRegistrodeCalificaciones.html',
        'menuRectificacioneInclusiondeCalificaciones.html',
        'menuReportes.html', 
        'menuAsistencia.html'
        );
mostrarMenuUsuarios($array);
}
if($permisos_usuario["jefe_dpto"]==1){
    #menus asignados a esta categoria
    $array = array(
        '', 
        'menuRegistrodeCalificaciones.html',
        '',
        '',
        'menuAsistencia.html',
        '',
        );
        echo '<h4>Menú de Jefe de Departamento/h4>';
mostrarMenuUsuarios($array);
}
if($permisos_usuario["jefe_adm"]==1){
    #menus asignados a esta categoria
    $array = array(
        '', 
        '',
        '',
        '',
        '',
        '',
        );
        echo '<h4>Menú de Jefe Administrativo</h4>';
mostrarMenuUsuarios($array);
}
#salida para los errores.
error:
?>