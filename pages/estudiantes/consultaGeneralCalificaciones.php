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
$sql="SELECT * FROM calificaciones WHERE ced_est='$sesion_usuario[ced_usu]' ORDER BY calificaciones.per_ins DESC, calificaciones.cod_uca";
#realizo consulta a la base de datos
$datos = $conn->getAll($sql);
#chequeo si la consulta obtuvo resultados
if(empty($datos)){
     mensajeError("Este usuario no tiene registros de calificaciones.", "inicio");
    goto error;
 }
#muestro cabecera de tabla de datos
echo '
<h4 align="center">Historial de Fases de Unidades Curriculares</h4>
<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed">
    <thead><tr>
    <th>Codigo (U.C)</th><th>Fase de la Unidad Curricular</th><th>Logro Obtenido</th><th>Período</th><th>Obs.</th>
    </tr></thead>
    <tbody>';
#Muestro los datos en la tabla
foreach ($datos as &$fila) {
    #muestro la informacion de cada cuenta
    $per=$fila["per_ins"];
    $cod_fase=$fila["cod_uca"];
    $cargauc=$fila["cod_carga"];
    $faseuc=substr($cargauc,13,1);
    $periodo=substr($per,0,4);    
    if ($periodo<=2013){
	$sqluc = "SELECT * FROM curriculares WHERE curriculares.cod_uc='$cod_fase'";
        $listauc=$conn->getRow($sqluc);	
	$nom=$listauc["nom_uc"];
        $cod=$listauc["cod_uc"];
	}else{
		$mat=substr($cod_fase,0,7);
		$sqluc = "SELECT * FROM uc WHERE cod_mat='$mat'";
        	$listauc=$conn->getRow($sqluc);
		$nom=$listauc["nom_mat"];
                $cod=$listauc["cod_mat"];
        }    
    if ($faseuc=='-'){$nom=$nom." FASE ".substr($cargauc,14,1);} 
    else {$nom=$nom." FASE ".$faseuc; }
    $per=$per.$faseuc;    
    $n100=$fila["n100"]; 
    $obs=$fila["obs"];
echo '<tr><td>'.$cod_fase.'</td><td>'.$nom.'</td><td>'.$n100.' %</td><td>'.$per.'</td><td>'.$obs.'</td></tr>';
unset($fila);
}
#cierro la tabla
echo '</tbody></table></div>';
#salida para los errores.
error:
?>