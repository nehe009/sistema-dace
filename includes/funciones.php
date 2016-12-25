<?php
#Funcion que inicia conexion con la base de datos.
function iniciarBD() {
    #Revisa y ejecuta conexion con la base de datos.
    global $conn;
    $conn = &ADONewConnection(db_engine);  
    @$conn->PConnect(db_host,db_user,db_password,db_database);# connect to MySQL
    $conn->setCharset('utf8');
    if (!$conn->isConnected()){ die("Problema con la BD");}
}
#funcion que genera mensaje de error
function mensajeError($mensaje, $url, $title=null) {
    #Muestra mensaje de error
    echo '<div class="page-header">
        <div class="alert alert-danger" role="alert">
        <strong>Error:</strong> '.$mensaje.' ';
    if ($url==null){
        echo '<a href="'.$_SERVER['REQUEST_URI'].'">Volver Atrás</a></div></div>';    
    }else{
        echo '<a href="index.php?page='.$url.'">'.$title.'</a></div></div>'; 
    }
}
#funcion que genera mensaje de exito
function mensajeSuccess($mensaje, $url, $title=null) {
    #Muestra mensaje
    echo '<div class="page-header">
        <div class="alert alert-success" role="alert">
        <strong>Listo:</strong> '.$mensaje.' ';
    if ($url==null){
        echo '<a href="'.$_SERVER['REQUEST_URI'].'">Volver Atrás</a></div></div>';    
    }else{
        echo '<a href="index.php?page='.$url.'">'.$title.'</a></div></div>'; 
    }
}
#funcion que genera codigos aleatorios, usados para contraseñas temporales
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
#funcion para obtener posible ip de un usuario conectado.
function obtenerIP(){
$ip = "";
    if ( $_SERVER [ 'HTTP_CLIENT_IP' ]) $ip = $_SERVER [ 'HTTP_CLIENT_IP' ];
    else if( $_SERVER [ 'HTTP_X_FORWARDED_FOR' ]) $ip = $_SERVER [ 'HTTP_X_FORWARDED_FOR' ];
    else if( $_SERVER [ 'HTTP_X_FORWARDED' ]) $ip = $_SERVER [ 'HTTP_X_FORWARDED' ];
    else if( $_SERVER [ 'HTTP_FORWARDED_FOR' ]) $ip = $_SERVER [ 'HTTP_FORWARDED_FOR' ];
    else if( $_SERVER [ 'HTTP_FORWARDED' ]) $ip = $_SERVER [ 'HTTP_FORWARDED' ];
    else if ( $_SERVER [ 'REMOTE_ADDR' ]) $ip = $_SERVER [ 'REMOTE_ADDR' ];
return $ip ;
}
#funcion que guarda auditoria de usuarios
function auditoriaUsuarios($cedula,$accion,$conn) {
    #direccion ip del visitante
    @$ip = obtenerIP();
    $navegador = getBrowser();
    $so = getPlatform();
    $sql="INSERT INTO `auditoria_usuarios` (id, cedula_usuario, ip, navegador, so, fecha, accion) VALUES ('NULL', '$cedula', '$ip', '$navegador', '$so', NOW(), '$accion')";
    #inserto registro en la base de datos.    
    if ($conn->Execute($sql) === false){
        mensajeError("Registro de auditoria ha fallado.", 'inicio');
    }
}
#funcion que envia notificaciones de correo.
function enviarNotificacionCorreo($correo,$asunto,$mensaje) {
    $mail = new PHPMailer;
    $mail->isSMTP();              // Set mailer to use SMTP
    $mail->SMTPDebug = 0;
    $mail->Host = mail_host;  // Specify SMTP servers
    $mail->SMTPAuth = true;             // Enable SMTP authentication
    $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
    $mail->Username = mail_user;         // SMTP username
    $mail->Password = mail_pass;         // SMTP password
    $mail->SMTPSecure = mail_encrypt;      // Enable TLS encryption, `ssl` also accepted
    $mail->Port = mail_port;             // TCP port to connect to
    $mail->setFrom(mail_from, "No responder");
    $mail->addAddress($correo);     // Add a recipient
    $mail->addReplyTo(mail_from, "No responder");
    $mail->Subject = $asunto;
    $mail->MsgHTML($mensaje);
    $mail->CharSet = 'UTF-8';
    #Envio el correo electronico.
    if(!$mail->Send()) {
        return false;
        } else {
            return true;
}
}
#funcion que revisa dominio
function chequeaURL() {
   if ($_SERVER['SERVER_NAME']!= site_url){ die("URL solicitada  no coincide con el nombre del Sitio Web");}
}
#funcion para detectar S.O de usuario.
function getPlatform(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($user_agent, 'Windows NT 10.0') !== FALSE)
			return "Windows 10";
		elseif(strpos($user_agent, 'Windows NT 6.3') !== FALSE)
			return "Windows 8.1";
		elseif(strpos($user_agent, 'Windows NT 6.2') !== FALSE)
			return "Windows 8";
		elseif(strpos($user_agent, 'Windows NT 6.1') !== FALSE)
			return "Windows 7";
		elseif(strpos($user_agent, 'Windows NT 6.0') !== FALSE)
			return "Windows Vista";
		elseif(strpos($user_agent, 'Windows NT 5.1') !== FALSE)
			return "Windows XP";
		elseif(strpos($user_agent, 'Windows NT 5.2') !== FALSE)
			return 'Windows 2003';
		elseif(strpos($user_agent, 'Windows NT 5.0') !== FALSE)
			return 'Windows 2000';
		elseif(strpos($user_agent, 'Windows ME') !== FALSE)
			return 'Windows ME';
		elseif(strpos($user_agent, 'Win98') !== FALSE)
			return 'Windows 98';
		elseif(strpos($user_agent, 'Win95') !== FALSE)
			return 'Windows 95';
		elseif(strpos($user_agent, 'WinNT4.0') !== FALSE)
			return 'Windows NT 4.0';
		elseif(strpos($user_agent, 'Windows Phone') !== FALSE)
			return 'Windows Phone';
		elseif(strpos($user_agent, 'Windows') !== FALSE)
			return 'Windows';
		elseif(strpos($user_agent, 'iPhone') !== FALSE)
			return 'iPhone';
		elseif(strpos($user_agent, 'iPad') !== FALSE)
			return 'iPad';
		elseif(strpos($user_agent, 'Debian') !== FALSE)
			return 'Debian';
		elseif(strpos($user_agent, 'Ubuntu') !== FALSE)
			return 'Ubuntu';
		elseif(strpos($user_agent, 'Slackware') !== FALSE)
			return 'Slackware';
		elseif(strpos($user_agent, 'Linux Mint') !== FALSE)
			return 'Linux Mint';
		elseif(strpos($user_agent, 'Gentoo') !== FALSE)
			return 'Gentoo';
		elseif(strpos($user_agent, 'Elementary OS') !== FALSE)
			return 'ELementary OS';
		elseif(strpos($user_agent, 'Fedora') !== FALSE)
			return 'Fedora';
		elseif(strpos($user_agent, 'Kubuntu') !== FALSE)
			return 'Kubuntu';
		elseif(strpos($user_agent, 'Linux') !== FALSE)
			return 'Linux';
		elseif(strpos($user_agent, 'FreeBSD') !== FALSE)
			return 'FreeBSD';
		elseif(strpos($user_agent, 'OpenBSD') !== FALSE)
			return 'OpenBSD';
		elseif(strpos($user_agent, 'NetBSD') !== FALSE)
			return 'NetBSD';
		elseif(strpos($user_agent, 'SunOS') !== FALSE)
			return 'Solaris';
		elseif(strpos($user_agent, 'BlackBerry') !== FALSE)
			return 'BlackBerry';
		elseif(strpos($user_agent, 'Android') !== FALSE)
			return 'Android';
		elseif(strpos($user_agent, 'Mobile') !== FALSE)
			return 'Firefox OS';
		elseif(strpos($user_agent, 'Mac OS X+') || strpos($user_agent, 'CFNetwork+') !== FALSE)
			return 'Mac OS X';
		elseif(strpos($user_agent, 'Macintosh') !== FALSE)
			return 'Mac OS Classic';
		elseif(strpos($user_agent, 'OS/2') !== FALSE)
			return 'OS/2';
		elseif(strpos($user_agent, 'BeOS') !== FALSE)
			return 'BeOS';
		elseif(strpos($user_agent, 'Nintendo') !== FALSE)
			return 'Nintendo';
		else
			return 'Unknown';
	}
#funcion para detectar navegador de usuario.
function getBrowser(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($user_agent, 'Maxthon') !== FALSE)
			return "Maxthon";
		elseif(strpos($user_agent, 'SeaMonkey') !== FALSE)
			return "SeaMonkey";
		elseif(strpos($user_agent, 'Vivaldi') !== FALSE)
			return "Vivaldi";
		elseif(strpos($user_agent, 'Arora') !== FALSE)
			return "Arora";
		elseif(strpos($user_agent, 'Avant Browser') !== FALSE)
			return "Avant Browser";
		elseif(strpos($user_agent, 'Beamrise') !== FALSE)
			return "Beamrise";
		elseif(strpos($user_agent, 'Epiphany') !== FALSE)
			return 'Epiphany';
		elseif(strpos($user_agent, 'Chromium') !== FALSE)
			return 'Chromium';
		elseif(strpos($user_agent, 'Iceweasel') !== FALSE)
			return 'Iceweasel';
		elseif(strpos($user_agent, 'Galeon') !== FALSE)
			return 'Galeon';
		elseif(strpos($user_agent, 'Edge') !== FALSE)
			return 'Microsoft Edge';
		elseif(strpos($user_agent, 'Trident') !== FALSE) //IE 11
			return 'Internet Explorer';
		elseif(strpos($user_agent, 'MSIE') !== FALSE)
			return 'Internet Explorer';
		elseif(strpos($user_agent, 'Opera Mini') !== FALSE)
			return "Opera Mini";
		elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
			return "Opera";
		elseif(strpos($user_agent, 'Firefox') !== FALSE)
			return 'Mozilla Firefox';
		elseif(strpos($user_agent, 'Chrome') !== FALSE)
			return 'Google Chrome';
		elseif(strpos($user_agent, 'Safari') !== FALSE)
			return "Safari";
		elseif(strpos($user_agent, 'iTunes') !== FALSE)
			return 'iTunes';
		elseif(strpos($user_agent, 'Konqueror') !== FALSE)
			return 'Konqueror';
		elseif(strpos($user_agent, 'Dillo') !== FALSE)
			return 'Dillo';
		elseif(strpos($user_agent, 'Netscape') !== FALSE)
			return 'Netscape';
		elseif(strpos($user_agent, 'Midori') !== FALSE)
			return 'Midori';
		elseif(strpos($user_agent, 'ELinks') !== FALSE)
			return 'ELinks';
		elseif(strpos($user_agent, 'Links') !== FALSE)
			return 'Links';
		elseif(strpos($user_agent, 'Lynx') !== FALSE)
			return 'Lynx';
		elseif(strpos($user_agent, 'w3m') !== FALSE)
			return 'w3m';
		else
			return 'Unknown';
	}
       
?>