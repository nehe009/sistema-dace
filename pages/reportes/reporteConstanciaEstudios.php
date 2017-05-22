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
//-------------------- Codigo para generar datos de reporte -------------------//
#periodo actual academico
$periodo= date('Y');
#fecha de generacion de contancia
$fecha=date('d-m-Y');
#consulta datos necesarios para la constancia de estudios.
$sql="SELECT 
departamentos.nombre AS nombre_pnf, 
est_situacion.turno, 
sedes.nom_sede, 
titulos.titulo, 
trayectos.nom_tray,
jefe_dace.ape_nom AS jefe_dace
FROM est_situacion, departamentos, inscripciones, sedes, titulos, trayectos, jefe_dace 
WHERE est_situacion.ced_est = inscripciones.ced_est
AND departamentos.codigo = est_situacion.pnf
AND est_situacion.sede = sedes.cod_sede
AND est_situacion.titulo = titulos.id
AND inscripciones.per_ins = '$periodo'
AND est_situacion.ced_est = '$sesion_usuario[ced_usu]'
AND est_situacion.status='AC'
AND trayectos.cod_tray=substr(cod_uc,5,1)
AND jefe_dace.sede=est_situacion.sede
AND jefe_dace.status='AC'
GROUP BY inscripciones.ced_est, inscripciones.per_ins order by substr(cod_uc,5,1) desc";
$datos=$conn->getRow($sql);
if(empty($datos)){
    mensajeError("No cumples los requisitos para solicitar la constancia de estudios.",'inicio','Ir a Inicio');
    goto error;
}
#variable de turno de estudio
if ($sesion_usuario[turno]==1){$turno="DIURNO";} else{$turno="NOCTURNO";}
#genera codigo y guarda datos del reporte en base de datos
$codigo=generarCodigoReporte($sesion_usuario[ced_usu],'CONSTANCIA DE ESTUDIOS',$conn2);
//-----------------------------------------------------------------------------//
#librerias necesarias para generar documento en pdf
require_once('lib/tcpdf/tcpdf.php');
require_once('lib/tcpdf/config/tcpdf_config.php');
require_once('lib/tcpdf/lang/spa.php');
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
<p align="justify"  fill="true" line-height: 200%;>Quien suscribe, Prof. <b>$datos[jefe_dace]</b>, Jefe del Departamento de Admisión y Control de Estudios <b>$datos[nom_sede]</b> de la <b>Universidad Politécnica Territorial del Estado Aragua "FEDERICO BRITO FIGUEROA", </b> hace constar por medio de la presente que el Ciudadano <u>$sesion_usuario[apellido], $sesion_usuario[nombre]</u>, Titular de la Cédula de Identidad Nº. <b>$sesion_usuario[ced_usu]</b>, es estudiante regular de esta universidad y actualmente cursa el $datos[nom_tray], período académico <b>$periodo</b> en el $datos[nombre_pnf] regimen $turno para optar al título de $datos[titulo].</p>
<br>
<p align="justify"  fill="true" line-height: 200%;>Constancia electrónica que se expide a solicitud de la parte interesada mediante el Sistema Integral de Control de Estudios (SICE) en la siguiente fecha: $fecha, la cual es válida por el año: $periodo.</p>       
<br><br><br><br>
<p align="center">
<b>_________________________________</b><br>
<b>PROF. $datos[jefe_dace]<br>
Jefe del Dpto. de Admisión y Control de Estudios de <br>$datos[nom_sede]</b></p>
<br><br><br>
<p align="justify" style="line-height:12px; font-size:12px;"><b>Nota: </b>Este documento contiene un código de barra único que certifica la veracidad del mismo, este código puede verificarse en la página web del Sistema Integral de Control de Estudios (SICE), dirigiéndose a la página web http://sice.upta.edu.ve/.</p>
<br><br>
EOD;
$pdf->Image('images/upta_fondo.png', 45, 70, 120, 100, '', '', '', false, 200, '', false, false, 0);
// Print text using writeHTML()
$pdf->writeHTML($html, true, false, true, false, '');
//estilo del codigo de barra
$style = array(
                    'position' => 'C',
                    'align' => 'C',
                    'stretch' => false,
                    'fitwidth' => true,
                    'cellfitalign' => '',
                    'border' => false,
                    'padding' => 0,
                    'fgcolor' => array(0,0,0),
                    'bgcolor' => false,
                    'text' => true,
                    'font' => 'helvetica',
                    'fontsize' => 10,
                    'stretchtext' => 4
                    );
$pdf->Ln(3);
//Codigo de barra centrado
$pdf->write1DBarcode($codigo, 'C128', '', '', '', 15, 0.4, $style, 'N');
#auditoria para generacion de reporte.
auditoriaUsuarios($sesion_usuario['ced_usu'],'constancia estudios',$conn2);
// Limpio buffer de codigo html previo
ob_end_clean();
// Close and output PDF document
$pdf->Output($sesion_usuario["ced_usu"].'_constancia_estudios.pdf', 'I');
#salida para los errores.
error:
?>
