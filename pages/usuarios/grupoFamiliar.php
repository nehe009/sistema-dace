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
    #si el registro es nuevo lo crea, si ya existe lo modifica
    if(empty($conn->getRow("SELECT * FROM grupo_familiar WHERE cedula_estudiante='$sesion_usuario[ced_usu]' AND id='$id'"))){
        $conn->Execute("INSERT INTO grupo_familiar (`id`, `cedula_estudiante`, `cedula_familiar`, `nombres_familiar`,`apellidos_familiar`, `parentesco_familiar`, `fecha_nacimiento_familiar`, `sexo_familiar`, `estudios_familiar`, `ocupacion_familiar`) VALUES (NULL, '$sesion_usuario[ced_usu]', '$cedula_familiar', '$nombres_familiar', '$apellidos_familiar', '$parentesco_familiar', '$fecha_nacimiento_familiar', '$sexo_familiar', '$estudios_familiar', '$ocupacion_familiar')");
    }else{
        $conn->Execute("UPDATE grupo_familiar SET `cedula_familiar`='$cedula_familiar', `nombres_familiar`='$nombres_familiar', `apellidos_familiar`='$apellidos_familiar', `parentesco_familiar`='$parentesco_familiar', `fecha_nacimiento_familiar`='$fecha_nacimiento_familiar', `sexo_familiar`='$sexo_familiar', `estudios_familiar`='$estudios_familiar', `ocupacion_familiar`='$ocupacion_familiar' WHERE cedula_estudiante='$sesion_usuario[ced_usu]' AND id='$id'");
    }
    auditoriaUsuarios($sesion_usuario['ced_usu'],'actualizar grupo familiar',$conn);
header("Location: index.php?page=usuarios.grupoFamiliar");    
}
#consulto si ha existen familiares en la tabla
$datos = $conn->getAll("SELECT * FROM grupo_familiar WHERE cedula_estudiante='$sesion_usuario[ced_usu]'");
if(empty($datos)){
        mensajeError("No tienes familiares registrados en el sistema.", "inicio");
    } else {
        echo '
            <center><h4 class="form-signin-heading">Lista de familares registrados en el sistema</h4></center><br>
            <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed">
            <thead>
            <tr><th>Acciones</th><th>Cedula</th><th>Nombres</th><th>Apellidos</th><th>Parentesco</th><th>Fecha de Nacimiento</th><th>Sexo</th><th>Grado académico</th><th>Ocupación u oficio</th></tr>
            </thead>
            <tbody>';
        foreach ($datos as &$familiares) {
            #muestro la informacion de cada familiar
            echo '<tr><td><a class="glyphicon glyphicon-pencil" title="Editar" href="index.php?page=usuarios.grupoFamiliar&amp;accion=1&amp;id='.$familiares["id"].'"></a>&nbsp;<a class="glyphicon glyphicon-remove" title="Eliminar" href="index.php?page=usuarios.grupoFamiliar&amp;accion=2&amp;id='.$familiares["id"].'"></a></td><td>'.$familiares["cedula_familiar"].'</td><td>'.$familiares["nombres_familiar"].'</td><td>'.$familiares["apellidos_familiar"].'</td><td>'.$familiares["parentesco_familiar"].'</td><td>'.$familiares["fecha_nacimiento_familiar"].'</td><td>'.$familiares["sexo_familiar"].'</td><td>'.$familiares["estudios_familiar"].'</td><td>'.$familiares["ocupacion_familiar"].'</td></tr>';   
            unset($familiares);   
        }     
        echo '</tbody></table></div>';
}
#controla acciones de modificacion y eliminacion de registro de familiar
if(isset($_GET['accion']) && $_GET['accion']=='1' && is_numeric($_GET['id'])){
    #opcion para editar registro de familiar
    $datosfamiliares=$conn->getRow("SELECT * FROM grupo_familiar WHERE cedula_estudiante='$sesion_usuario[ced_usu]' AND id='$_GET[id]'");
} elseif (isset($_GET['accion']) and $_GET['accion']=='2' && is_numeric($_GET['id'])) {
    $conn->getRow("DELETE FROM grupo_familiar WHERE cedula_estudiante='$sesion_usuario[ced_usu]' AND id='$_GET[id]'");
    header("Location: index.php?page=usuarios.grupoFamiliar"); 
} else {
    #carga plantilla con campos vacios
    $datosfamiliares=array('id'=>'','cedula_familiar'=>'','nombres_familiar'=>'','apellidos_familiar'=>'','parentesco_familiar'=>'','fecha_nacimiento_familiar'=>'','sexo_familiar'=>'','estudios_familiar'=>'','ocupacion_familiar'=>'',);
}
#carga plantilla
extract($datosfamiliares);
include("formGrupoFamiliar.html");
error:
?>
