<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (isset($sesion_usuario)) {
    mensajeError("Ya has iniciado sesión.",'inicio','Ir a Inicio');
    goto error;
}
#chequea si se ha recibido variables por get o por formulario
if (isset($_GET['codigo'])||isset($_POST['ok'])){
    #Si ha recibido variables por formulario la escribe.
    if(isset($_POST['ok'])){ 
        $idval= dechex(crc32($_POST['codigo']));
       } else {
        $idval= dechex(crc32($_GET['codigo']));  
       }    
    #chequeo si el codigo de activacion existe.
    if(empty($conn->getRow("SELECT id FROM usuarios WHERE clave_activacion = '$idval'"))){
        mensajeError("Código de activación incorrecto.",null);
        goto error;
    }
    #chequeo si el codigo ya ha sido activado
    if(!empty($conn->getRow("SELECT id FROM usuarios WHERE clave_activacion = '$idval' AND activo=1"))){
        mensajeError("Este código ya se ha activado.",null);
        goto error;
    }
    #actualizo registro en la base de datos.  
    $sql="UPDATE usuarios SET activo=1, fecha_activacion=NOW() WHERE clave_activacion='$idval'";
    if ($conn->Execute($sql) === false){ 
        mensajeError("La activación ha fallado.",'inicio','Ir a Inicio');
        } else {
            mensajeSuccess("El proceso de registro se ha completado exitosamente.",'inicio','Ir a Inicio');
        }      
} else { #si no recibe nada por get muestra formulario para copiar el codigo.
    include("formActivacion.html");
    }
#salida para los errores.
error:  
?>



