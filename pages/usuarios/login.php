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
    #chequea si el usuario existen en la base de datos.
    if(empty($conn2->getRow("SELECT id FROM usuarios WHERE usuario='$inputUser'"))){
        mensajeError("Este usuario no está registrado.",null);
        goto error;
    }
    #chequea si el usuario y la contraseña coinciden en la base de datos.
    $iduser=$conn2->getRow("SELECT id, activo, bloqueo, inicio_sesion_fallidos FROM usuarios WHERE usuario='$inputUser' AND cla_usu='$inputPassword'");
    if(empty($iduser)){
        #actualiza numero de sesion fallida
        $conn2->getRow("UPDATE usuarios SET inicio_sesion_fallidos=inicio_sesion_fallidos+1 WHERE usuario='$inputUser'");
        mensajeError("La contraseña es incorrecta.",null);
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
    #chequeo si el usuario ha superados el limite de inicios de sesion fallidos.
    if($iduser["inicio_sesion_fallidos"]>=3){
        mensajeError("Este usuario ha superado el límite de intento de sesiones fallidos.",'usuarios.recuperar','Recuperar datos de acceso');
        goto error;
    }
    #consulto datos de interes para generar la sesion de la tabla de usuarios
    $datos_usuario=$conn2->getRow("SELECT id, usuario, ced_usu, num_sesion, corr_usu FROM usuarios WHERE id='$iduser[id]'");
    #consulta si tiene permisos de usuario en la tabla de permisos
    $permisos_usuario=$conn2->getRow("SELECT * FROM usuarios_permisos WHERE cedula_usuario='$datos_usuario[ced_usu]'");    
    if(empty($permisos_usuario)){
        mensajeError("Este usuario no tiene permisos asignados.",null);
        goto error;
    }    
    #consulto el nombre y apellido de usuario y demas informacion de interes. 
    if($permisos_usuario["profesor"]==1){
       $datos_tabla=$conn->getRow("SELECT nom_prof as nombre, ape_prof as apellido FROM profesores WHERE ced_prof=$datos_usuario[ced_usu]");  
    }
    if($permisos_usuario["administrativo"]==1){
        $datos_tabla=$conn->getRow("SELECT nom_adm as nombre, ape_adm as apellido FROM administrativo WHERE ced_adm=$datos_usuario[ced_usu]");
    }
    if($permisos_usuario["estudiante"]==1){
        $datos_est=$conn->getRow("SELECT nom_est as nombre, ape_est as apellido FROM estudiantes WHERE ced_est=$datos_usuario[ced_usu]");
        $datos_est_sit=$conn->getRow("SELECT * FROM est_situacion WHERE ced_est=$datos_usuario[ced_usu]");
        $datos_tabla=array_merge($datos_est,$datos_est_sit);
    }
    $datos_finales =  array_merge($datos_usuario,$datos_tabla);
    #almaceno los datos del usuario en un objeto sesion.
    $_SESSION["sesion_usuario"] = $datos_finales;
    #almaceno los permisos del usuario en un objeto sesion.
    $_SESSION["permisos_usuario"] = $permisos_usuario;
    #actualiza numero de sesion, fecha de ultimo acceso y resetea intentos fallidos de inicio.
    $conn2->Execute("UPDATE usuarios SET num_sesion=num_sesion+1, fecha_ultimo_acceso=NOW(),inicio_sesion_fallidos=0, online=1 WHERE id='$iduser[id]'");
    #auditoria de usuarios
    auditoriaUsuarios($datos_usuario["ced_usu"],'inicio sesion',$conn2);
    #Vuelve a la pagina principal
    header('Location: index.php');   
} else { #si no se pulso ok se muestra formulario de registro
    include("formLogin.html");
    }
#salida para los errores.
error: 
?>
