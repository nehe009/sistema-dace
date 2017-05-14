<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (!isset($sesion_usuario)) {
    mensajeError("No has iniciado sesión.",'inicio','Ir a Inicio');
    goto error;
}
#Comprobamos si se a pulsado el boton OK
if(isset($_POST['ok'])){
    #extraigo variables POST
    extract($_POST);
    #chequea si los correos introducidos son correctos
    if($inputEmail1!=$inputEmail2){
        mensajeError("Los correos no coinciden.",null);
        goto error;
    }
    #chequea el correo actual en la base de datos.
    $user=$conn2->getRow("SELECT corr_usu FROM usuarios WHERE ced_usu='$sesion_usuario[ced_usu]'");
    if($user["corr_usu"]!= $inputEmail){
        mensajeError("El correo actual es incorrecto.",null);
        goto error;
    }
    #chequea si el nuevo correo existe en la base de datos.
    if(!empty($conn2->getRow("SELECT corr_usu FROM usuarios WHERE corr_usu='$inputEmail1'"))){
        mensajeError("Este correo ya está registrado.",null);
        goto error;
    }
    #consulta de actualizacion de nuevo usuario
    $sql="UPDATE usuarios SET corr_usu='$inputEmail1' WHERE ced_usu='$sesion_usuario[ced_usu]'";
    #inserto nueva clave en la base de datos.    
    if ($conn2->Execute($sql) == false){ 
        mensajeError("El cambio de correo electrónico ha fallado, contacte un administrador.",null);
        goto error;
       } else {
           #guardo auditoria.
           auditoriaUsuarios($sesion_usuario['ced_usu'],'cambio correo',$conn2);
           #envio notificacion de correo.
           enviarNotificacionCorreo($inputEmail1,'Notificacion DACE','<p>Usted ha cambiado el correo electrónico de su cuenta.</p>');
           mensajeSuccess("El correo electrónico se ha cambiado correctamente.",'usuarios.perfil','Atras');
       }    
} else { #si no se pulso ok se muestra formulario de registro
    include("formCambiarCorreo.html");
    }
#salida para los errores.
error:
?>