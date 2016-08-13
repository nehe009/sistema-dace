<?php
if (!defined("ROOT_INDEX")){ die("");}
if (isset($_GET['codigo'])){
    $idval= dechex(crc32($_GET['codigo']));
    #chequeo si el codigo de activacion existe.
    if(empty($conn->getRow("SELECT id FROM usuarios WHERE clave_activacion = '$idval'"))){
        mensajeError("Código de activación incorrecto.",'inicio');
        goto error;
    }
    #chequeo si el codigo ya ha sido activado
    if(!empty($conn->getRow("SELECT id FROM usuarios WHERE clave_activacion = '$idval' AND activo=1"))){
        mensajeError("Este código ya se ha activado.",'inicio');
        goto error;
    }
    #actualizo registro en la base de datos.  
    $sql="UPDATE usuarios SET activo=1, fecha_activacion=NOW() WHERE clave_activacion='$idval'";
    if ($conn->Execute($sql) === false){ 
        mensajeError("La activación ha fallado.",'inicio');
        } else {
            mensajeSuccess("El proceso de registro se ha completado exitosamente.",'inicio');
        }    
#salida para los errores.
error:      
}
?>



