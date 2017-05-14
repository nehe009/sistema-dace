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
    if(!isset($inputEstadoNacimiento)){$inputEstadoNacimiento='';}
    if(!isset($inputCiudadNacimiento)){$inputCiudadNacimiento='';}
    #consulta de actualizacion de datos
    $sql="UPDATE estudiantes SET ape_est='$inputApellidos', nom_est='$inputNombres', fecha_nac='$inputFechaNacimiento', nac_est='$inputNacionalidad', sexo='$inputSexo', edo_civil='$inputEstadoCivil', afrodes='$inputAfrodescendiente', telf_est='$inputTelefono', pais='$inputPaisNacimiento', edo_nac='$inputEstadoNacimiento', lugarn='$inputCiudadNacimiento', estado_direccion='$inputEstadoHabitacion', mun_direccion='$inputMunicipioHabitacion', parroquia_direccion='$inputParroquiaHabitacion', ciuh='$inputCiudadHabitacion', dir_est='$inputDireccion' WHERE ced_est='$sesion_usuario[ced_usu]'";
    #inserto datos en la base de datos.    
    if ($conn->Execute($sql) == false){ 
        mensajeError("Actualizacion de datos fallida, contacte un administrador.",null);
        goto error;
       } else {
           #guardo auditoria.
           auditoriaUsuarios($sesion_usuario['ced_usu'],'actualizar datos',$conn2);
           mensajeSuccess("Los datos se han actualizado correctamente.",'usuarios.perfil','Atras');
       }
} else {
    #consulto datos de la tabla estudiantes para cargarlos en el formulario.
    $datosestudiantes=$conn->getRow("SELECT * FROM estudiantes WHERE ced_est='$sesion_usuario[ced_usu]'");
    extract($datosestudiantes);
    $nombrepaisnacimiento = $conn2->getOne("SELECT pais FROM localidad_paises WHERE id_pais='$pais'");
    $nombreestadonacimiento = $conn2->getOne("SELECT estado FROM localidad_estados WHERE id_estado='$edo_nac'");
    $nombreciudadnacimiento = $conn2->getOne("SELECT ciudad FROM localidad_ciudades WHERE id_ciudad='$lugarn'");
    $estadohabitacion = $conn2->getOne("SELECT estado FROM localidad_estados WHERE id_estado='$estado_direccion'");
    $municipiohabitacion = $conn2->getOne("SELECT municipio FROM localidad_municipios WHERE id_municipio='$mun_direccion'");
    $parroquiahabitacion = $conn2->getOne("SELECT parroquia FROM localidad_parroquias WHERE id_parroquia='$parroquia_direccion'");
    $ciudadhabitacion = $conn2->getOne("SELECT ciudad FROM localidad_ciudades WHERE id_ciudad='$ciuh'");
    include("formDatosPersonalesEst.html");
}
error:
?>
