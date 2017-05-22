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
$periodo= date('Y');
#chequea si el periodo actual esta aperturado.
$sql="SELECT ano FROM anos WHERE ano='$periodo'";
if(empty($conn->getRow($sql))){
    mensajeError("Este periodo académico no ha sido aperturado.",'inicio','Ir a Inicio');
    goto error;
}
#chequea si el estudiante esta inscrito en el periodo actual.
$sql="SELECT 
est_situacion.id
FROM est_situacion, inscripciones 
WHERE est_situacion.ced_est = inscripciones.ced_est
AND inscripciones.per_ins = '$periodo'
AND est_situacion.ced_est = '$sesion_usuario[ced_usu]'
AND est_situacion.status='AC'";
if(empty($conn->getRow($sql))){
    mensajeError("No estas inscrito en este periodo académico.",'inicio','Ir a Inicio');
    goto error;
}
echo '
<div class="list-group">
    <a target="_blank" href="index.php?page=reportes.reporteConstanciaEstudios" class="list-group-item active">
        <h4 class="list-group-item-heading">Constancia de estudios en Formato Digital</h4>
        <p class="list-group-item-text">Esta opción le genera una constancia de estudios en formato PDF, la cual se encuentra firma digitalmente y cuya veracidad puede ser comprobada directamente por el SISCE. Esta constancia puede ser impresa por usted mismo y entregada a los organismos que la pidan como requisito para trámites legales.</p>
    </a>
    <a href="#" class="list-group-item">
        <h4 class="list-group-item-heading">Constancia de estudios Tradicional</h4>
        <p class="list-group-item-text">Esta opción le genera una constancia de estudios de forma tradicional, la cual deberá buscar en el DACE en las fechas señalas. La cantidad de constancias emitidas por esta opción es limitada, por lo tanto has buen uso de ellas.</p>
    </a>
</div>';
#salida para los errores.
error:
?>