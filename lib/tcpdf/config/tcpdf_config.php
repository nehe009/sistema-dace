<?php
#Define the following constant to ignore the default configuration file.
define ('K_TCPDF_EXTERNAL_CONFIG', true);

#Default images directory.
#By default it is automatically set but you can also set it as a fixed string to improve performances.
define ('K_PATH_IMAGES', 'images/');

#Default image logo used be the default Header() method.
#Please set here your own logo or an empty string to disable it.
define ('PDF_HEADER_LOGO', 'upta.png');

#Header logo image width in user units.
define ('PDF_HEADER_LOGO_WIDTH', 20);

#Cache directory for temporary files (full path).
define ('K_PATH_CACHE', sys_get_temp_dir().'/');

#Generic name for a blank image.
define ('K_BLANK_IMAGE', '_blank.png');

 # Page format. 
define ('PDF_PAGE_FORMAT', 'LETTER');

 # Page orientation (P=portrait, L=landscape). 
define ('PDF_PAGE_ORIENTATION', 'P');

 # Document creator. 
define ('PDF_CREATOR', 'TCPDF');

 # Document author. 
define ('PDF_AUTHOR', 'TCPDF');

 # Header title. 
define ('PDF_HEADER_TITLE', "REPÚBLICA BOLIVARIANA DE VENEZUELA");

 # Header description string. 
define ('PDF_HEADER_STRING', "MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN UNIVERSITARIA, CIENCIA Y TECNOLOGÍA\nUNIVERSIDAD POLITÉCNICA TERRITORIAL DEL ESTADO ARAGUA FEDERICO BRITO FIGUEROA\nLA VICTORIA - ESTADO ARAGUA\nDEPARTAMENTO DE ADMISIÓN Y CONTROL DE ESTUDIOS");

 # Document unit of measure [pt=point, mm=millimeter, cm=centimeter, in=inch]. 
define ('PDF_UNIT', 'mm');

 # Header margin. 
define ('PDF_MARGIN_HEADER', 10);

 # Footer margin. 
define ('PDF_MARGIN_FOOTER', 28);

 # Top margin. 
define ('PDF_MARGIN_TOP', 40);

 # Bottom margin. 
define ('PDF_MARGIN_BOTTOM', 30);

 # Left margin. 
define ('PDF_MARGIN_LEFT', 15);

 # Right margin. 
define ('PDF_MARGIN_RIGHT', 15);

 # Default main font name. 
define ('PDF_FONT_NAME_MAIN', 'helvetica');

 # Default main font size. 
define ('PDF_FONT_SIZE_MAIN', 9);

 # Default data font name. 
define ('PDF_FONT_NAME_DATA', 'helvetica');

 # Default data font size. 
define ('PDF_FONT_SIZE_DATA', 8);

 # Default monospaced font name. 
define ('PDF_FONT_MONOSPACED', 'helvetica');

 # Ratio used to adjust the conversion of pixels to user units. 
define ('PDF_IMAGE_SCALE_RATIO', 1.25);

 # Magnification factor for titles. 
define('HEAD_MAGNIFICATION', 1.1);

 # Height of cell respect font height.
define('K_CELL_HEIGHT_RATIO', 1.25);

 # Title magnification respect main font size. 
define('K_TITLE_MAGNIFICATION', 1.3);

 # Reduction factor for small font. 
define('K_SMALL_RATIO', 2/3);

 # Set to true to enable the special procedure used to avoid the overlappind of symbols on Thai language.
define('K_THAI_TOPCHARS', true);

 # If true allows to call TCPDF methods using HTML syntax
 # IMPORTANT: For security reason, disable this feature if you are printing user HTML content.
define('K_TCPDF_CALLS_IN_HTML', false);

# If true and PHP version is greater than 5, then the Error() method throw new exception instead of terminating the execution.
define('K_TCPDF_THROW_EXCEPTION_ERROR', false);

//--- Clase extendida para agregar marca de fecha y hora y codigo de barras ---//
class MYPDF extends TCPDF {
    // Page footer
	public function Footer() {
            // define barcode style
            $style = array(
                    'position' => '',
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
                    'fontsize' => 8,
                    'stretchtext' => 4
                    );
            $timestamp = date("d/m/Y h:m:s"); 
            if (empty($this->pagegroups)) { 
                $pagenumtxt = $this->l['w_page'].' '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(); 
                } else { 
                $pagenumtxt = $this->l['w_page'].' '.$this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias(); 
            }
            $this->Cell(0, 0, 'Fecha y hora del reporte: '.$timestamp, 'T', 0, 'C');
            
            $this->Cell(0, 0, $pagenumtxt, 'T', 0, 'R');
            $this->SetY(-25);
            $this->write1DBarcode('0123456789', 'C128', '', '', '', 18, 0.4, $style, 'N');
	}
}
//-----------------------------------------------------------------------------//
