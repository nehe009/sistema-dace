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
    <th>Codigo (U.C)</th><th>Unidad Curricular</th><th>Nota Final</th><th>Nota PER</th><th>Período</th>
    </tr></thead>
    <tbody>';
#Muestro los datos en la tabla
foreach ($datos as &$fila) {
#muestro la informacion de cada cuenta
    $cod_fase=$fila["cod_mat"];
    $nom=$fila["nom_mat"];
    $n100=$fila["nota_final_100"];
    $n20=$fila["nota_final"]; 
    $per=$fila["periodo"];
echo '<tr><td>'.$cod_fase.'</td><td>'.$nom.'</td><td>'.$n20.' Pts</td><td></td><td>'.$per.'</td></tr>';
unset($fila);
}
#cierro la tabla
echo '</tbody></table></div>';
#salida para los errores.
error:
?>
