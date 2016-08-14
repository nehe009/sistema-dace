<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (isset($sesion_usuario)) {
    mensajeError("Ya has iniciado sesión.",'inicio');
    goto error;
}
#Comprobamos si se a pulsado el boton OK
if(isset($_POST['ok'])){
    #extraigo variables POST
    extract($_POST);        
    #chequeo si el Captcha esta correcto.
    if(isset($_SESSION['security_code_login']) && !empty($_SESSION['security_code_login']) && $_POST['inputCaptcha'] != $_SESSION['security_code_login']){
        mensajeError("Captcha incorrecto.",null);
        goto error;
    }    
    #convierte caracteres no compatibles
    $inputUser=htmlspecialchars($inputUser); 
    #calcula el hash de la clave introducida
    $inputPassword=sha1(md5($inputPassword));    
    #chequea si el usuario y la contraseña existen en la base de datos.
    $iduser=$conn->getRow("SELECT id, activo, bloqueo FROM usuarios WHERE usuario='$inputUser' AND cla_usu='$inputPassword'");
    if(empty($iduser)){
        mensajeError("Este usuario no está registrado.",null);
        goto error;
    }
    #chequeo si el usuario ha sido activado
    if($iduser["activo"]==0){
        mensajeError("Este usuario no está activado.",null);
        goto error;
    }
    #chequeo si el usuario esta bloqueado
    if($iduser["bloqueo"]==1){
        mensajeError("Este usuario está bloqueado.",null);
        goto error;
    } 
    #actualiza numero de sesion y fecha de ultimo acceso
    $conn->getRow("UPDATE usuarios SET num_sesion=num_sesion+1, fecha_ultimo_acceso=NOW() WHERE id='$iduser[id]'");
    #consulto datos de interes para generar la sesion
    $datos_usuario=$conn->getRow("SELECT id, usuario, ced_usu, num_sesion FROM usuarios WHERE id='$iduser[id]'");
    #consulta permisos de usuario
    $permisos_usuario=$conn->getRow("SELECT * FROM usuarios_permisos WHERE cedula_usuario='$datos_usuario[ced_usu]'");    
    #almaceno los datos del usuario en un objeto sesion.
    $_SESSION["sesion_usuario"]= $datos_usuario;
    #almaceno los permisos del usuario en un objeto sesion.
    $_SESSION["permisos_usuario"]= $permisos_usuario;
    #auditoria de usuarios
    auditoriaUsuarios($datos_usuario["ced_usu"],'inicio sesion');
    #Vuelve a la pagina principal
    header('Location: index.php');
   
} else { #si no se pulso ok se muestra formulario de registro
    include("formLogin.html");
    }
#salida para los errores.
error: 
?>
