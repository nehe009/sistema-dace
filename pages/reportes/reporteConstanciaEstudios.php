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
#librerias necesarias para generar documento en pdf
require_once('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/tcpdf_config.php');
require_once('lib/tcpdf/lang/spa.php');
//-------------------- Codigo para generar datos de reporte -------------------//
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
$pdf->SetTitle('Constancia de Estudios');
$pdf->SetSubject('Constancia de Estudios');
$pdf->SetKeywords('Constancia de Estudios');
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
        width: 30px;
        text-align: center; 
        vertical-align: middle;
	}
        p {
            font-size: 12pt;
        }
</style>

<p align="center"><h2>CONSTANCIA DE ESTUDIOS</h2></p><br>
<br><br>
<p align="justify"  fill="true" line-height: 200%;>Quien suscribe, Prof. <b></b>, Jefe del Departamento de Admisión y Control de Estudios <b>'.$nsede.'</b> de la <b>Universidad Politécnica Territorial del Estado Aragua "FEDERICO BRITO FIGUEROA", </b> hace constar por medio de la presente que el Ciudadano <u>nEHEMIAS EBEB VELASQUEZ VILLZANA</u>, Titular de la Cédula de Identidad Nº. <i></i>, es estudiante regular de esta universidad y actualmente cursa el  'trayecto.', período académico<i> '.periodo.'</i> en el  ''. régimen '' para optar al título de ''.</p>
<br>
<p align="justify"  fill="true" line-height: 200%;>Constancia que se expide a solicitud de la parte interesada en la Ciudad de La Victoria, '.$dia.' '.$mes.' de '.$anio.' </p>       

<br><br>         
EOD;
// Print text using writeHTML()
$pdf->writeHTML($html, true, false, true, false, '');
#auditoria para generacion de reporte.
auditoriaUsuarios($sesion_usuario['ced_usu'],'reporte general notas uc',$conn2);
// Close and output PDF document
// Limpio buffer de codigo html previo
ob_end_clean();
$pdf->Output($sesion_usuario["ced_usu"].'_reporte_general_notas_uc.pdf', 'I');
#salida para los errores.
error:
?>
