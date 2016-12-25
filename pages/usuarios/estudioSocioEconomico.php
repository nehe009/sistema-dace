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
    
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    #extraigo variables POST
    extract($_POST);
    #Reviso arrays de grupo familiar.
    if($inputGrupoFamiliar>0){
        for ($i = 0; $i <= $inputGrupoFamiliar-1; $i++) {
            echo $cedula_familiar[$i];
            if(empty($conn->getRow("SELECT * FROM grupo_familiar WHERE cedula_estudiante='$sesion_usuario[ced_usu]' AND cedula_familiar='$cedula_familiar[$i]'"))){
                $conn->Execute("INSERT INTO grupo_familiar (`id`, `cedula_estudiante`, `cedula_familiar`, `nombres_apellidos_familiar`, `parentesco_familiar`, `fecha_nacimiento_familiar`, `sexo_familiar`, `estudios_familiar`, `ocupacion_familiar`) VALUES (NULL, '$sesion_usuario[ced_usu]', '$cedula_familiar[$i]', '$nombres_apellidos_familiar[$i]', '$parentesco_familiar[$i]', '$fecha_nacimiento_familiar[$i]', '$sexo_familiar[$i]', '$estudios_familiar[$i]', '$ocupacion_familiar[$i]')");
            }else{
                $conn->Execute("UPDATE grupo_familiar SET , `nombres_apellidos_familiar`='$nombres_apellidos_familiar[$i]', `parentesco_familiar`='$parentesco_familiar[$i]', `fecha_nacimiento_familiar`='$fecha_nacimiento_familiar[$i]', `sexo_familiar`='$sexo_familiar[$i]', `estudios_familiar`='$estudios_familiar[$i]', `ocupacion_familiar`='$ocupacion_familiar[$i]') VALUES (NULL, '$sesion_usuario[ced_usu]', '$cedula_familiar[$i]', '$nombres_apellidos_familiar[$i]', '$parentesco_familiar[$i]', '$fecha_nacimiento_familiar[$i]', '$sexo_familiar[$i]', '$estudios_familiar[$i]', '$ocupacion_familiar[$i]')");
            } 
            
        }
    }
    #consulta de actualizacion de datos
    $sql="UPDATE estudio_socioeconomico SET trabajo='$inputTrabaja', empresa='$inputEmpresa', direccion='$inputEmpresaDireccion', telefono='$inputEmpresaTelefono', cargo='$inputEmpresaCargo', departamento='$inputEmpresaDepartamento', disca_est='$inputDiscapacidad', tipo_disc='$inputTipoDiscapacidad',ingreso_mensual='$inputSueldoMensual', ingreso_mensual_familiar='$inputIngresoFamiliarMensual', tenencia_vivienda='$inputTenenciaVivienda', condiciones_vivienda='$inputCondicionesVivienda' WHERE cedula_estudiante='$sesion_usuario[ced_usu]'";
    #inserto datos en la base de datos.    
    $conn->Execute($sql);
    #guardo auditoria.
    auditoriaUsuarios($sesion_usuario['ced_usu'],'actualizar estudio socioeconomico',$conn);
    mensajeSuccess("Los datos se han actualizado correctamente.",'usuarios.perfil','Atras');
} else {
    #consulto datos de la tabla estudiantes para cargarlos en el formulario.
    #chequeo si este usuario tiene datos guardados en la tabla estudio_socioeconomico, si no, creo el registro en dicha tabla
    if(empty($conn->getRow("SELECT * FROM estudio_socioeconomico WHERE ced_est='$sesion_usuario[ced_usu]'"))){ 
        $conn->Execute("INSERT INTO `estudio_socioeconomico` (`id`, `cedula_estudiante`, `trabajo`, `empresa`, `direccion`, `telefono`, `cargo`, `departamento`, `ingreso_mensual`, `ingreso_mensual_familiar`, `tenencia_vivienda`, `condiciones_vivienda`, `disca_est`, `tipo_disc`) VALUES (NULL, '$sesion_usuario[ced_usu]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)");
    }     
    $estudiosocioeconomico=$conn->getRow("SELECT * FROM estudio_socioeconomico WHERE cedula_estudiante='$sesion_usuario[ced_usu]'");
    extract($estudiosocioeconomico);
    include("formEstudioSocioEconomico.html");
}
error:
?>
