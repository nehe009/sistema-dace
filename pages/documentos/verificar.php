<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si se ha recibido variables por formulario
if (isset($_POST['ok'])){
    #chequeo si el codigo de reporte existe.
    $sql="SELECT * FROM reportes WHERE codigo_reporte ='$_POST[codigo]'";
    $datos_documento=$conn2->getRow($sql);
    if(empty($datos_documento)){
        mensajeError("Código de barras del documento incorrecto o invalido.",null);
        goto error;
    }
    $sql="SELECT nom_est, ape_est FROM estudiantes WHERE ced_est ='$datos_documento[cedula_usuario]'";
    $datos_usuario=$conn->getRow($sql);
    if(empty($datos_usuario)){
        mensajeError("Datos del documento incorrectos o invalidos.",null);
        goto error;
    }   
    echo '
    <center><h4 class="form-signin-heading">Datos de verificación del Documento</h4></center>
    <div class="table-responsive">
    <table class="table table-bordered table-hover table-condensed">
    <tr><th>Tipo de documento</th><td>'.$datos_documento['tipo_reporte'].'</td></tr>
    <tr><th>Código de Documento</th><td>'.$datos_documento['codigo_reporte'].'</td></tr>
    <tr><th>Cedula de Identidad</th><td>'.$datos_documento['cedula_usuario'].'</td></tr>
    <tr><th>Nombres del estudiante</th><td>'.$datos_usuario['nom_est'].'</td></tr>
    <tr><th>Apellidos del estudiante</th><td>'.$datos_usuario['ape_est'].'</td></tr>
    <tr><th>Fecha del Documento</th><td>'.$datos_documento['fecha_reporte'].'</td></tr>
    <tr><th>Estado</th><td>---------------</td></tr>
    </table></div>
';   
} else { 
    #muestra formulario para copiar el codigo.
    include("formVerificar.html");
    }
#salida para los errores.
error:  
?>