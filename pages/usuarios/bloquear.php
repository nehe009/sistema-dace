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
#chequeo si id existe y es numerica
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    #extrae valor de la variable
    extract($_GET);
    #validar usuarios antes de eliminar
    if($sesion_usuario['ced_usu']==$id){
        mensajeError("No puedes bloquear este usuario.", "usuarios.buscarUsuario","Atras");
        goto error;
    }
    #consulta para bloquear usuario
    $consulta=$conn2->getRow("UPDATE usuarios SET bloqueo=1 WHERE ced_usu='$id'");
        if(empty($consulta)){
           auditoriaUsuarios($sesion_usuario['ced_usu'],'bloquear usuario '.$id.'',$conn2);
           mensajeSuccess("Usuario bloqueado correctamente.", "usuarios.buscarUsuario","Atras");
        } else {
            mensajeError("No se ha podido bloquear al usuario.", "usuarios.buscarUsuario","Atras");
        }
    } else {
    mensajeError("Usuario no valido.",'inicio','Ir a Inicio');
    goto error;
}

#salida para los errores.
error:
?>