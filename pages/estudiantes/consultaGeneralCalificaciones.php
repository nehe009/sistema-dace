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
    <th class="col1">Codigo (U.C)</th><th class="col2">Fase de la Unidad Curricular</th><th class="col3">Logro Obtenido</th><th class="col4">Período</th><th class="col5">Observaciones</th>
    </tr></thead>
    <tbody>';
#Muestro los datos en la tabla
$tabla = '';
foreach ($datos as &$fila) {
    #muestro la informacion de cada materia
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
    } else {
		$mat=substr($cod_fase,0,7);
		$sqluc = "SELECT * FROM uc WHERE cod_mat='$mat'";
        	$listauc=$conn->getRow($sqluc);
		$nom=$listauc["nom_mat"];
                $cod=$listauc["cod_mat"];                
                if ($faseuc == '-'){
                    $nom = $nom.' FASE '.substr($cargauc,14,1);        
                } else {
                    $nom = $nom.' FASE '.$faseuc;       
                }
                $per=$per.$faseuc; 
    }
    $n100=$fila["n100"]; 
    $obs=$fila["obs"];
$tabla .= '<tr><td class="col1">'.$cod_fase.'</td><td class="col2">'.$nom.'</td><td class="col3">'.$n100.' %</td><td class="col4">'.$per.'</td><td class="col5">'.$obs.'</td></tr>';
unset($fila);
}
print_r($tabla);
#cierro la tabla
echo '</tbody></table></div>';
    #codigo html para abrir ventana modal para confirmar impresion de reporte
    echo '
        <div align="center"><a target="_blank" href="index.php?page=reportes.reporteGeneralCalificacionesEstudiante" role="button" class="glyphicon glyphicon-print btn btn-lg btn-success" title="Imprimir reporte" > Imprimir</a></div><br>';
#salida para los errores.
error:
?>