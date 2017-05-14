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
    $sql="UPDATE estudio_socioeconomico SET trabajo='$inputTrabaja', empresa='$inputEmpresa', direccion='$inputEmpresaDireccion', telefono='$inputEmpresaTelefono', cargo='$inputEmpresaCargo', departamento='$inputEmpresaDepartamento', disca_est='$inputDiscapacidad', tipo_disc='$inputTipoDiscapacidad',ingreso_mensual='$inputSueldoMensual', ingreso_mensual_familiar='$inputIngresoFamiliarMensual', tenencia_vivienda='$inputTenenciaVivienda', condiciones_vivienda='$inputCondicionesVivienda' WHERE cedula_estudiante='$sesion_usuario[ced_usu]'";
    #inserto datos en la base de datos.    
    $conn2->Execute($sql);
    #guardo auditoria.
    auditoriaUsuarios($sesion_usuario['ced_usu'],'actualizar estudio socioeconomico',$conn2);
    mensajeSuccess("Los datos se han actualizado correctamente.",'usuarios.perfil','Atras');
} else {
    #consulto datos de la tabla estudiantes para cargarlos en el formulario.
    #chequeo si este usuario tiene datos guardados en la tabla estudio_socioeconomico, si no, creo el registro en dicha tabla
    if(empty($conn2->getRow("SELECT * FROM estudio_socioeconomico WHERE ced_est='$sesion_usuario[ced_usu]'"))){ 
        $conn2->Execute("INSERT INTO `estudio_socioeconomico` (`id`, `cedula_estudiante`, `trabajo`, `empresa`, `direccion`, `telefono`, `cargo`, `departamento`, `ingreso_mensual`, `ingreso_mensual_familiar`, `tenencia_vivienda`, `condiciones_vivienda`, `disca_est`, `tipo_disc`) VALUES (NULL, '$sesion_usuario[ced_usu]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
    }     
    $estudiosocioeconomico=$conn2->getRow("SELECT * FROM estudio_socioeconomico WHERE cedula_estudiante='$sesion_usuario[ced_usu]'");
    extract($estudiosocioeconomico);
    include("formEstudioSocioEconomico.html");
}
error:
?>
