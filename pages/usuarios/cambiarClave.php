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
    #chequea si las contraseñas introducidas son correctas
    if($inputNewPassword1!=$inputNewPassword2){
        mensajeError("Las contraseñas no coinciden.",null);
        goto error;
    }
    #calcula el hash de la clave nueva
    $nueva_clave=sha1(md5($inputNewPassword1));
    #chequea la contraseña actual en la base de datos.
    $clave=sha1(md5($inputPassword));
    $clave_user=$conn->getRow("SELECT cla_usu FROM usuarios WHERE ced_usu='$sesion_usuario[ced_usu]'");
    if($clave_user["cla_usu"]!= $clave){
        mensajeError("La contraseña actual es incorrecta.",null);
        goto error;
    }
    #consulta de acrualizacion de nueva clave
    $sql="UPDATE usuarios SET cla_usu='$nueva_clave' WHERE ced_usu='$sesion_usuario[ced_usu]'";
    #inserto nueva clave en la base de datos.    
    if ($conn->Execute($sql) === false){ 
        mensajeError("El cambio de contraseña ha fallado, contacte un administrador.",null);
        goto error;
       } else {
           auditoriaUsuarios($sesion_usuario['ced_usu'],'cambio clave');
           mensajeSuccess("La contraseña se ha cambiado correctamente.",'inicio');
       }    
} else { #si no se pulso ok se muestra formulario de registro
    include("formCambiarClave.html");
    }
#salida para los errores.
error:
?>
