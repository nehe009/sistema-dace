<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (isset($sesion_usuario)) {
    mensajeError("Ya has iniciado sesión.",'inicio','Ir a Inicio');
    goto error;
}
#Comprobamos si se a pulsado el boton OK
if(isset($_POST['ok'])){
    #extraigo variables POST
    extract($_POST);  
    #chequeo si el Captcha esta correcto.
    if(isset($_SESSION['security_code_recuperar']) && !empty($_SESSION['security_code_recuperar']) && $_POST['inputCaptcha'] != $_SESSION['security_code_recuperar']){
        mensajeError("Captcha incorrecto.",null);
        goto error;
    } 
    #chequeo si la cedula esta registrada en la bd de usuarios
    $datosUser=$conn->getRow("SELECT id, corr_usu FROM usuarios WHERE ced_usu=$inputCedula");
    if(empty($datosUser)){
        mensajeError("Esta cedula de identidad no se encuentra registrada.",null);
        goto error;
    }
#proceso de recuperacion de cuenta.
$inputEmail=$datosUser['corr_usu'];
    #generacion de clave de usuario temporal
    $clave = generateCode(8);
    #encriptacion de clave
    $clave_enc = sha1(md5($clave));
    #se prepara correo electronico a enviar.
    $asunto = 'Recuperación  de cuenta y acceso a sistema DACE';
    $cuerpo = '<p>Usted ha solicitado recuperar los datos de acceso a la Aplicación para la Gestión del Rendimiento Académico del DACE de la UPT Aragua.</p>'
            . '<p>Por favor acceda con el siguiente usuario y clave:</p>'
            . '<p>Usuario: '.$inputCedula.'</p>'
            . '<p>Clave: '.$clave.'</p>'
            . '<br>'
            . '<p>Gracias</p>';
    #envio el correo electronico.
    $check=enviarNotificacionCorreo($inputEmail,$asunto,$cuerpo);
    if($check==false) {
        mensajeError("Hemos tenido un problema para enviarte el correo de recuperacion.",null);
        goto error;
    }   
    #Preparo consulta de actualizacion de datos.
    $sql_recuperar="UPDATE usuarios SET usuario='$inputCedula', cla_usu='$clave_enc', inicio_sesion_fallidos=0 WHERE ced_usu='$inputCedula'";
    #actualizo el usuario y la contraseña nuevamente.    
    if ($conn->Execute($sql_recuperar) == false){ 
        mensajeError("La recuperacion de datos de usuario ha fallado, contacte un administrador.",'inicio','Ir a Inicio');
        goto error;
       } else {
            mensajeSuccess("Se ha enviado un correo electrónico a $inputEmail.",'inicio','Ir a Inicio');
        }
#auditoria de usuarios
auditoriaUsuarios($inputCedula,'recuperacion usuario',$conn);
} else { #si no se pulso ok se muestra formulario de registro
    include("formRecuperar.html");
    }
#salida para los errores.
error:
?>