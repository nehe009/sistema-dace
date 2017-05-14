<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (isset($sesion_usuario)) {
    mensajeError("Ya has iniciado sesión.",'inicio','Ir a Inicio');
    goto error;
}
#Declaracion de variables
$profesor = '0';
$administrativo='0';
$estudiante='0';    
#Comprobamos si se a pulsado el boton OK
if(isset($_POST['ok'])){
    #extraigo variables POST
    extract($_POST);        
    #chequeo si el Captcha esta correcto.
    if(isset($_SESSION['security_code_register']) && !empty($_SESSION['security_code_register']) && $_POST['inputCaptcha'] != $_SESSION['security_code_register']){
        mensajeError("Captcha incorrecto.",null);
        goto error;
    }        
    #chequeo si la cedula se encuentre en la bd de estudiantes, profesores o administrativo.
    if(!empty($conn->getRow("SELECT id FROM estudiantes WHERE ced_est=$inputCedula"))){
        $estudiante=1;
    } 
    if (!empty($conn->getRow("SELECT id FROM profesores WHERE ced_prof=$inputCedula"))) {
        $profesor=1;
    } 
    if (!empty($conn->getRow("SELECT id FROM administrativo WHERE ced_adm=$inputCedula"))) {
        $administrativo=1;        
    }    
    if($administrativo==0&&$profesor==0&&$estudiante==0) {
        mensajeError("No esta registrado en la institución.",null);
        goto error; 
    }   
    #chequeo si la cedula esta registrada en la bd de usuarios
    if(!empty($conn2->getRow("SELECT id FROM usuarios WHERE ced_usu=$inputCedula"))){
        mensajeError("Esta cedula de identidad ya se encuentra registrada.",null);
        goto error;
    } 
    #chequeo si el email esta registrado en la bd de usuarios
    if(!empty($conn2->getRow("SELECT id FROM usuarios WHERE corr_usu='$inputEmail'"))){
        mensajeError("Este correo electrónico ya se encuentra registrado.",null);
        goto error;
    }       
    #generacion de clave de usuario temporal
    $clave = generateCode(8);
    #encriptacion de clave
    $clave_enc = sha1(md5($clave));
    #generacion de clave de activacion
    $clave_act = generateCode(8);
    $clave_act .= $inputCedula;
    $clave_act = md5($clave_act);
    #encriptacion de clave de activacion
    $clave_act_enc = dechex(crc32($clave_act));
    #preparo la consulta sql para usuarios        
    $sql_usuario="INSERT INTO `usuarios` "
        . "(`id`, `usuario`, `cla_usu`, `niv_usu`, `corr_usu`, `pre_usu`, `res_usu`,"
        . " `ced_usu`, `pnf_usu`, `activo`, `sede`, `clave_activacion`, "
        . "`fecha_registro`, `fecha_activacion`, `fecha_ultimo_acceso`, "
        . "`num_sesion`, `bloqueo`, `inicio_sesion_fallidos`) "
        . "VALUES "
        . "(NULL, '$inputCedula', '$clave_enc', '', '$inputEmail', '', '', "
        . "'$inputCedula', '', '0', '', '$clave_act_enc', "
        . "NOW(), '', '', "
        . "'0', '0', '0')"; 
    #preparo la consulta sql para permisos
    $sql_permisos="INSERT INTO `usuarios_permisos` (`id`, `cedula_usuario`, `estudiante`, `activo`, `inactivo`, `graduado`, `profesor`, `evaluador`, `jefe_dpto`, `jefe_adm`, `administrativo`, `operador`, `taquilla`, `control_total`) VALUES (NULL, '$inputCedula', b'$estudiante', b'$estudiante', b'0', b'0', b'$profesor', b'$profesor', b'0', b'0', b'$administrativo', b'0', b'0', b'0')";
#se prepara correo electronico a enviar.
$asunto = 'Activación de cuenta y acceso a sistema DACE';
$cuerpo = '<p>Ha sido registrado como usuario de la Aplicación para la Gestión del Rendimiento Académico del DACE de la UPT Aragua.</p>'
        . '<p>Por favor acceda con el siguiente usuario y clave:</p>'
        . '<p>Usuario: '.$inputCedula.'</p>'
        . '<p>Clave: '.$clave.'</p>'
        . '<p>Codigo de activación: '.$clave_act.'</p>'
        . '<p>Enlace de activación: <a href="'.site_url.'/index.php?page=usuarios.activacion&amp;codigo='.$clave_act.'">ACTIVAR CUENTA</a></p>'
        . '<p>Por favor haga clik en el enlace indicado para activar su cuenta.</p>';
#envio el correo electronico.
$check=enviarNotificacionCorreo($inputEmail,$asunto,$cuerpo);
    if($check==false) {
        mensajeError("Hemos tenido un problema para enviarte el correo de activación.",null);
        goto error;
    }    
#inserto registro de usuario en la base de datos.    
    if ($conn2->Execute($sql_usuario) == false){ 
        mensajeError("El registro de usuario ha fallado.",null);
        goto error;
       }
#inserto registro de permisos en la base de datos.    
    if ($conn2->Execute($sql_permisos) == false){ 
        mensajeError("El registro de permisos de usuario ha fallado, contacte un administrador.",null);
        goto error;
       } else {
            mensajeSuccess("Para terminar el proceso de registro revise su correo electrónico.",'usuarios.activacion','Activar cuenta');
        }
#auditoria de usuarios
auditoriaUsuarios($inputCedula,'registro usuario',$conn2);
} else { #si no se pulso ok se muestra formulario de registro
    include("formRegistro.html");
    }
#salida para los errores.
error:
?>


