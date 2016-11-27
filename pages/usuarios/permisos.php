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
#Permite que solamente administradores con control total entren a este modulo.
if(!$permisos_usuario["control_total"]==1){
    mensajeError("No tienes permiso para entrar a este módulo.",'inicio','Ir a Inicio');
    goto error;
}
#Comprobamos si se a pulsado el boton OK
if(isset($_POST['ok'])){
    #extrae valor de la variable
    extract($_GET);
    #invierto arreglo post y elimino variable ok
    $array=array_reverse($_POST);
    array_shift($array);
    #borro permisos en la base de datos antes de aplicar los nuevos.
    $conn->getRow("UPDATE usuarios_permisos SET estudiante=0, activo=0, inactivo=0, graduado=0, profesor=0, evaluador=0, jefe_dpto=0, jefe_adm=0, administrativo=0, operador=0, taquilla=0, control_total=0 WHERE cedula_usuario='$id'");
    #Recorro elementos (permisos) para guardarlos en la base de datos.
    foreach ($array as $key => $value){
        $mykey=$key;
        $conn->getRow("UPDATE usuarios_permisos SET $mykey=1 WHERE cedula_usuario='$id'");
    }
    mensajeSuccess("Permisos asignados correctamente.", "usuarios.buscarUsuario","Atras");
} else {
    #chequeo si id existe y es numerica
    if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
        mensajeError("Usuario no valido.",'inicio','Ir a Inicio');
        goto error;
    }
    #extrae valor de la variable id
    extract($_GET);
    #consulta permisos de usuario
    $permisos=$conn->getRow("SELECT * FROM usuarios_permisos WHERE cedula_usuario='$id'");    
        if(empty($permisos)){
            mensajeError("Este usuario no tiene ningún permiso asignado.","usuarios.buscarUsuario","Atras");
            goto error;
        }
        #Extraigo permisos del arreglo de consulta para cargarlos en el formulario.
        extract($permisos);
        include("formPermisos.html"); 
}
#salida para los errores.
error:
?>