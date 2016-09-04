<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (!isset($sesion_usuario)) {
    mensajeError("No has iniciado sesión.",'inicio');
    goto error;
}
#Comprobamos si se a pulsado el boton OK
if(isset($_POST['ok'])){
    #extraigo variables POST
    extract($_POST);
    #chequea si los usuarios introducidos son correctos
    if($inputNewUser1!=$inputNewUser2){
        mensajeError("Los usuarios no coinciden.",null);
        goto error;
    }
    #chequea el usuario actual en la base de datos.
    $user=$conn->getRow("SELECT usuario FROM usuarios WHERE ced_usu='$sesion_usuario[ced_usu]'");
    if($user["usuario"]!= $inputNewUser){
        mensajeError("El usuario actual es incorrecto.",null);
        goto error;
    }
    #consulta de actualizacion de nueva clave
    $sql="UPDATE usuarios SET usuario='$inputNewUser1' WHERE ced_usu='$sesion_usuario[ced_usu]'";
    #inserto nueva clave en la base de datos.    
    if ($conn->Execute($sql) === false){ 
        mensajeError("El cambio de usuario ha fallado, contacte un administrador.",null);
        goto error;
       } else {
           #guardo auditoria.
           auditoriaUsuarios($sesion_usuario['ced_usu'],'cambio usuario',$conn);
           #envio notificacion de correo.
           enviarNotificacionCorreo($sesion_usuario['corr_usu'],'Notificacion DACE','Usted ha cambiado el usuario de su cuenta.');
           mensajeSuccess("El usuario se ha cambiado correctamente. Se recomienda cerrar y abrir la sesión nuevamente.",'inicio');
       }    
} else { #si no se pulso ok se muestra formulario de registro
    include("formCambiarUsuario.html");
    }
#salida para los errores.
error:
?>