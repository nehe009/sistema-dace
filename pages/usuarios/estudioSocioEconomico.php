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
    #consulta de actualizacion de datos
    $sql1="UPDATE estudiantes SET disca_est='$inputDiscapacidad', tipo_disc='$inputTipoDiscapacidad' WHERE ced_est='$sesion_usuario[ced_usu]'";
    $sql2="UPDATE est_datos SET trabajo='$inputTrabaja', empresa='$inputEmpresa', direccion='$inputEmpresaDireccion', telefono='$inputEmpresaTelefono', cargo='$inputEmpresaCargo', departamento='$inputEmpresaDepartamento' WHERE ced_est='$sesion_usuario[ced_usu]'";
    #inserto datos en la base de datos.    
    $conn->Execute($sql1);
    $conn->Execute($sql2);
    #guardo auditoria.
    auditoriaUsuarios($sesion_usuario['ced_usu'],'actualizar estudio socioeconomico',$conn);
    mensajeSuccess("Los datos se han actualizado correctamente. Se recomienda cerrar y abrir la sesión nuevamente.",'usuarios.cerrarsesion','Cerrar sesión');
} else {
    #consulto datos de la tabla estudiantes para cargarlos en el formulario.
    $datos1=$conn->getRow("SELECT * FROM estudiantes WHERE ced_est='$sesion_usuario[ced_usu]'");
    #chequeo si este usuario tiene datos guardados en la tabla est_datos, si no, creo el registro en dicha tabla
    if (empty($conn->getRow("SELECT * FROM est_datos WHERE ced_est='$sesion_usuario[ced_usu]'"))){ 
        $conn->Execute("INSERT INTO est_datos (`id`, `ced_est`, `instituto`, `tipo_plantel`, `ubicacion`, `titulo_obtenido`, `fecha_grado`, `promedio`, `pos_asig`, `trabajo`, `empresa`, `direccion`, `telefono`, `cargo`, `departamento`) VALUES (NULL, '$sesion_usuario[ced_usu]', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL)");
    }     
    $datos2=$conn->getRow("SELECT * FROM est_datos WHERE ced_est='$sesion_usuario[ced_usu]'");
    $estudiosocioecomico=array_merge($datos1,$datos2);
    extract($estudiosocioecomico);
    include("formEstudioSocioEconomico.html");
}
error:
?>
