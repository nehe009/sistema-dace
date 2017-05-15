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
require_once('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/tcpdf_config.php');
require_once('lib/tcpdf/lang/spa.php');
//-------------------- Codigo para generar datos de reporte -------------------//
#consulta de calificaciones del estudiante
$sql="SELECT * FROM calificaciones WHERE ced_est='$sesion_usuario[ced_usu]' ORDER BY calificaciones.per_ins DESC, calificaciones.cod_uca";
#realizo consulta a la base de datos
$datos = $conn->getAll($sql);
#chequeo si la consulta obtuvo resultados
if(empty($datos)){
     mensajeError("Este usuario no tiene registros de calificaciones.", "inicio");
    goto error;
 }
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
#variable de turno de estudio
if ($sesion_usuario[turno]==1){$turno="DIURNO";} else{$turno="NOCTURNO";}
#variable de sede de estudio
if ($sesion_usuario[sede]=='LV'){$sede="LA VICTORIA";} elseif ($sesion_usuario[sede]=='MY'){$sede="MARACAY";}else{$sede="BARBACOAS";}
//-----------------------------------------------------------------------------//
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('DACE');
$pdf->SetTitle('Reporte general de calificaciones');
$pdf->SetSubject('Reporte general de calificaciones');
$pdf->SetKeywords('Reporte general de calificaciones');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
$pdf->setLanguageArray($l);
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 8, '', true);
// Add a page
$pdf->AddPage();
// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
// Set some content to print
$html = <<<EOD

 <style>
	.col1 {
        width: 75px;
        text-align: center; 
        vertical-align: middle;
	}
        .col2 {
        width: 370px;
        text-align: center; 
        vertical-align: middle;
	}
        .col3 {
        width: 80px;
        text-align: center; 
        vertical-align: middle;
	}
        .col4 {
        width: 60px;
        text-align: center; 
        vertical-align: middle;
	}
        .col5 {
        width: 75px;
        text-align: center; 
        vertical-align: middle;
	}        
        th {
            font-weight: bold;
        }
</style>
<table border="0">
<tr align="center" valign="middle"><td width="660px"><b>HISTORIAL DE FASES DE UNIDADES CURRICULARES </b></td></tr>
<tr align="center" valign="middle"><td width="660px"></td></tr>
<tr align="left" valign="middle"><td width="411px"><b>ESTUDIANTE: </b>$sesion_usuario[nombre] $sesion_usuario[apellido]</td><td width="150px"></td></tr>
        <tr align="left" valign="middle"><td width="411px"><b>CEDULA DE IDENTIDAD: </b> $sesion_usuario[ced_usu]</td><td width="150px"></td></tr>
<tr align="left" valign="middle"><td width="411px"><b>PROGRAMA: </b>$sesion_usuario[pnf]</td><td width="150px"></td></tr>
<tr align="left" valign="middle"><td width="411px"><b>SEDE: </b>$sede</td><td width="150px"></td></tr>
<tr align="left" valign="middle"><td width="411px"><b>TURNO: </b>$turno</td><td width="150px"></td></tr>
</table>
<br><br>
<table border="1" >
<thead><tr><th class="col1">Codigo (U.C)</th><th class="col2">Fase de la Unidad Curricular</th><th class="col3">Logro Obtenido</th><th class="col4">Período</th><th class="col5">Observaciones</th></tr></thead>
<tbody>'$tabla'</tbody>
</table>
<br><br>         
<b>La informaci&oacute;n suministrada en este reporte, es s&oacute;lo de las Fases de las Unidades Curriculares.</b> 
<br>
<b>Observaciones = "A" ó "I": indica calificaciòn modificada con ACTA, "CV": Convalidaciones, "EQ": Equivalencias, "TR": Traslados </b> 
<br><br> 
<b>NOTA: Este reporte es s&oacute;lo para fines informativos.</b>
EOD;
// Print text using writeHTML()
$pdf->writeHTML($html, true, false, true, false, '');
#auditoria para generacion de reporte.
auditoriaUsuarios($sesion_usuario['ced_usu'],'reporte general calificaciones',$conn2);
// Close and output PDF document
// Limpio buffer de codigo html previo
ob_end_clean();
$pdf->Output($sesion_usuario["ced_usu"].'_reporte_general_calificaciones.pdf', 'I');
#salida para los errores.
error:
?>