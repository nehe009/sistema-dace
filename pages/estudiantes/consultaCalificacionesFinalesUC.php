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
#consulta de calificaciones del estudiante
$sql="SELECT * FROM notas_uc, uc WHERE notas_uc.ced_est='$sesion_usuario[ced_usu]' and notas_uc.cod_mat = uc.cod_mat ORDER BY  notas_uc.periodo, notas_uc.cod_mat";
#realizo consulta a la base de datos
$datos = $conn->getAll($sql);
#chequeo si la consulta obtuvo resultados
if(empty($datos)){
     mensajeError("Este usuario no tiene registros de calificaciones.", "inicio");
    goto error;
 }
#muestro cabecera de tabla de datos
echo '
<h4 align="center">Historial de Calificaciones Finales de Unidades Curriculares</h4>
<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed">
    <thead><tr>
    <th>Nro</th><th>Codigo (U.C)</th><th>Unidad Curricular</th><th>Nota Final</th><th>Nota PER</th><th>Período</th><th>Observaciones</th>
    </tr></thead>
    <tbody>';
#Muestro los datos en la tabla
$i=0;
$tabla = '';
foreach ($datos as &$fila) {
#muestro la informacion de cada cuenta
    $cod_fase=$fila["cod_mat"];
    $nom=$fila["nom_mat"];
    $n100=$fila["nota_final_100"];
    $n20=$fila["nota_final"]; 
    $per=$fila["periodo"];
    $obs=$fila["obs"];
    $i++;
$tabla .= '<tr><td>'.$i.'</td><td>'.$cod_fase.'</td><td>'.$nom.'</td><td>'.$n20.' Pts</td><td></td><td>'.$per.'</td><td>'.$obs.'</td></tr>';
unset($fila);
}
print_r($tabla);
#cierro la tabla
echo '</tbody></table></div>';
#codigo html para abrir reporte en pdf
echo '<div align="center"><a target="_blank" href="index.php?page=reportes.reporteCalificacionesFinalesUC" role="button" class="glyphicon glyphicon-print btn btn-lg btn-success" title="Imprimir reporte" > Imprimir</a></div><br>';
#salida para los errores.
error:
?>
