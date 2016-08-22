<?php

function iniciarBD() {
    #Revisa y ejecuta conexion con la base de datos.
    global $conn;
    $conn = &ADONewConnection(db_engine);  
    @$conn->PConnect(db_host,db_user,db_password,db_database);# connect to MySQL
    if (!$conn->isConnected()){ die("Problema con la BD");}
}

function mensajeError($mensaje, $link) {
    #Muestra mensaje de error
    echo '<div class="page-header">
        <div class="alert alert-danger" role="alert">
        <strong>Error:</strong> '.$mensaje.' ';
    if ($link=="inicio"){
        echo '<a href="index.php"> Ir a Inicio</a></div></div>';        
    }else{
        echo '<a href="'.$_SERVER['REQUEST_URI'].'"> Volver Atrás</a></div></div>';
    }
}

function mensajeSuccess($mensaje, $link) {
    #Muestra mensaje
    echo '<div class="page-header">
        <div class="alert alert-success" role="alert">
        <strong>Listo:</strong> '.$mensaje.' ';
    if ($link=="inicio"){
        echo '<a href="index.php"> Ir a Inicio</a></div></div>';        
    }else{
        echo '<a href="'.$_SERVER['REQUEST_URI'].'"> Volver Atrás</a></div></div>';
    }
}

function generateCode($characters) {
/* list all possible characters, similar looking characters and vowels have been removed */
    $possible = '23456789bcdfghjkmnpqrstvwxyzBCDFGHJKMNPQRSTVWXYZ';
    $code = '';
    $i = 0;
    while ($i < $characters) { 
	$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
	$i++;
	}
	return $code;
}

function auditoriaUsuarios($cedula,$accion,$conn) {
    #direccion ip del visitante
    $ip = $_SERVER ['REMOTE_ADDR'];
    $sql="INSERT INTO `auditoria_usuarios` (id, cedula_usuario, ip, fecha, accion) VALUES ('NULL', '$cedula', '$ip', NOW(), '$accion')";
    #inserto registro en la base de datos.    
    if ($conn->Execute($sql) === false){
        mensajeError("Registro de auditoria ha fallado.", 'inicio');
    }
}

function enviarNotificacionCorreo($correo,$asunto,$mensaje) {
    $mail = new PHPMailer;
    $mail->isSMTP();              // Set mailer to use SMTP
    $mail->Host = 'mail_host';  // Specify SMTP servers
    $mail->SMTPAuth = true;             // Enable SMTP authentication
    $mail->Username = 'mail_user';         // SMTP username
    $mail->Password = 'mail_pass';         // SMTP password
    $mail->SMTPSecure = 'mail_encrypt';      // Enable TLS encryption, `ssl` also accepted
    $mail->Port = mail_port;             // TCP port to connect to
    $mail->setFrom(mail_from);
    $mail->addAddress($correo);     // Add a recipient
    $mail->addReplyTo(mail_from);
    $mail->isHTML(true);                 // Set email format to HTML
    $mail->Subject = $asunto;
    $mail->Body = $mensaje;
    #Envio el correo electronico.
    $check=$mail->send();    
    return $check;
 }
?>