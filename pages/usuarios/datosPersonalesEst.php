<?php
#Evita ejecucion individual del script.
if (!defined("ROOT_INDEX")){ die("");}
#chequea si ya inicio sesion
if (!isset($sesion_usuario)) {
    mensajeError("No has iniciado sesión.",'inicio','Ir a Inicio');
    goto error;    
}
#Permite que solamente estudiantes entren a este modulo.
if(!$permisos_usuario["estudiante"]==1){
    mensajeError("No tienes permiso para entrar a este módulo.",'inicio','Ir a Inicio');
    goto error;  
}
#Comprobamos si se a pulsado el boton OK
if(isset($_POST['ok'])){
    #extraigo variables POST
    extract($_POST);
    
    echo $inputCedula;


} else {
    #consulto datos de la tabla estudiantes para cargarlos en el formulario.
    $datosestudiantes=$conn->getRow("SELECT * FROM estudiantes WHERE ced_est='$sesion_usuario[ced_usu]'");
    $est_datos=$conn->getRow("SELECT * FROM est_datos WHERE ced_est='$sesion_usuario[ced_usu]'");
    $datosestudiantes=array_merge($datosestudiantes, $est_datos);
    echo '<pre>';
    print_r($datosestudiantes);
    echo '</pre>';
    #cargo la plantilla d formularios html, convierto a array y luego a string
    $template = implode("", file('pages\usuarios\formDatosPersonalesEst.html'));
    #muestro plantilla sustituyendo los datos de la bd
    mostrarTemplate($template, $datosestudiantes);
}
error:
?>
