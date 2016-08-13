<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#Declaracion de variables
$profesor = '0';
$administrativo='0';
$estudiante='0';    
#Comprobamos si se a pulsado el boton OK
if(isset($_POST['ok'])){
    #extraigo variables POST
    extract($_POST);        
    #chequeo si el Captcha esta correcto.
    if(isset($_SESSION['security_code_login']) && !empty($_SESSION['security_code_login']) && $_POST['inputCaptcha'] != $_SESSION['security_code_login']){
        mensajeError("Captcha incorrecto.",null);
        goto error;
    }        
    #chequeo si la cedula se encuentre en la bd de estudiantes, profesores o administrativo.
    if(!empty($conn->getRow("SELECT id FROM estudiantes WHERE ced_est=$inputCedula"))){
        $estudiante=2048;
    } 
    if (!empty($conn->getRow("SELECT id FROM profesores WHERE ced_prof=$inputCedula"))) {
        $profesor=128;
    } 
    if (!empty($conn->getRow("SELECT id FROM administrativo WHERE ced_adm=$inputCedula"))) {
        $administrativo=8;        
    }    
    if($administrativo==0&&$profesor==0&&$estudiante==0) {
        mensajeError("No esta registrado en la institución.",null);
        goto error; 
    }   
    #chequeo si la cedula esta registrada en la bd de usuarios
    if(!empty($conn->getRow("SELECT id FROM usuarios WHERE ced_usu=$inputCedula"))){
        mensajeError("Esta cedula de identidad ya se encuentra registrada.",null);
        goto error;
    } 
    #chequeo si el email esta registrado en la bd de usuarios
    if(!empty($conn->getRow("SELECT id FROM usuarios WHERE corr_usu='$inputEmail'"))){
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
    #genero valor para tipo de usuario
    $tipousuario=($administrativo|$profesor|$estudiante);
    #preparo la consulta sql        
    $sql="INSERT INTO `usuarios` "
        . "(`id`, `usuario`, `cla_usu`, `niv_usu`, `corr_usu`, `pre_usu`, `res_usu`,"
        . " `ced_usu`, `pnf_usu`, `activo`, `sede`, `clave_activacion`, "
        . "`fecha_registro`, `fecha_activacion`, `fecha_ultimo_acceso`, "
        . "`num_sesion`, `bloqueo`, `inicio_sesion_fallidos`, `tipo_usuario`) "
        . "VALUES "
        . "(NULL, '$inputCedula', '$clave_enc', '', '$inputEmail', '', '', "
        . "'$inputCedula', '', '0', '', '$clave_act_enc', "
        . "NOW(), '', '', "
        . "'0', '0', '0', '$tipousuario')"; 

#se prepara correo electronico a enviar.
$mail = new PHPMailer;
$mail->isSMTP();              // Set mailer to use SMTP
$mail->Host = 'mail_host';  // Specify SMTP servers
$mail->SMTPAuth = true;             // Enable SMTP authentication
$mail->Username = 'mail_user';         // SMTP username
$mail->Password = 'mail_pass';         // SMTP password
$mail->SMTPSecure = 'mail_encrypt';      // Enable TLS encryption, `ssl` also accepted
$mail->Port = mail_port;             // TCP port to connect to
$mail->setFrom(mail_from);
$mail->addAddress($inputEmail);     // Add a recipient
$mail->addReplyTo(mail_from);
$mail->isHTML(true);                 // Set email format to HTML
$mail->Subject = 'Activación de cuenta y acceso a sistema DACE';
$cuerpo ="Ha sido registrado como usuario de la Aplicación para la Gestión del Rendimiento Académico del DACE de la UPT Aragua. Por favor acceda con el siguiente usuario y clave. gracias \n";
$cuerpo .= "Usuario: \n";
$cuerpo .=$inputCedula;
$cuerpo .= "\n Clave: \n";
$cuerpo .=$clave;
$cuerpo .="\n Enlace de activación: ";
$cuerpo .= "<a href='site_url/index.php?page=usuarios.activacion&amp;codigo=".$clave_act."'>ACTIVAR CUENTA</a> \n";
$cuerpo .="Por favor haga clik en el enlace indicado para activar su cuenta.";
$mail->Body = $cuerpo;
#envio el correo electronico.
    if(!$mail->send()) {
        mensajeError("Hemos tenido un problema para enviarte el correo de activación.",null);
        //goto error;
    }    
#inserto registro en la base de datos.    
    if ($conn->Execute($sql) === false){ 
        mensajeError("El registro ha fallado.",null);
       } else {
            mensajeSuccess("Para terminar el proceso de registro revise su correo electrónico.",'inicio');
        }
#auditoria de usuarios
auditoriaUsuarios($inputCedula,'reg user');
#salida para los errores.
error:
} else { #si no se pulso ok se muestra formulario de registro
    include("formRegistro.html");
    }
?>


