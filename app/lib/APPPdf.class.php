<?php

require_once LIB_PATH.'mpdf/mpdf.php';
require_once MODEL_PATH . 'pr_dm_formatoModel.php';

class APPPdf {

    public $appName;
    public $dirDoc;
    public $dataFields;
    public $pdfFileName;
    public $htmlHeader;
    public $htmlFooter;
    public $htmlBody;
    public $PDF_PAGE_ORIENTATION;
    public $PDF_PAGE_FORMAT;
    public $NOMBRE;
    public $ASUNTO;
    public $KEYWORDS;
    public $hash;
    
    /*
     * Construcción de clase para la creación de PDF desde un formato base PR_FM_FORMATO 
     * Parametros :
     *   $idFormat int : ID Formato 
     *   $dirDocs string : Directorio para el armacenamiento fwrite
     *   $pdfFileName string : Nombre del archivo sin extesión.
     *   $hash string : cadena hash para la firma del pdf
     */
    
    public function __construct($idFormat,$dirDocs,$pdfFileName,$hash)
    {
        $pdfModel = new \Model\pr_dm_formatoModel();
	$config = \Lib\Config::singleton();
        
	$pdfParam = $pdfModel->getRow($idFormat);
  
        $this->dirDoc = $dirDocs;
        $this->appName = $config->get('appName');
        $this->pdfFileName = $pdfFileName;
        $this->data = $dataFields;
        $this->htmlHeader = $pdfParam[0]["HEADER"];
        $this->htmlFooter = $pdfParam[0]["FOOTER"];
        $this->htmlBody = $pdfParam[0]["BODY"];
        $this->PDF_PAGE_ORIENTATION = $pdfParam[0]['PDF_PAGE_ORIENTATION'];
        $this->PDF_PAGE_FORMAT = $pdfParam[0]['PDF_PAGE_FORMAT'];
        $this->NOMBRE = $pdfParam[0]['NOMBRE'];
        $this->ASUNTO = $pdfParam[0]['ASUNTO'];
        $this->KEYWORDS = $pdfParam[0]['KEYWORDS'];
        $this->MARGIN_TOP = $pdfParam[0]['MARGIN_TOP'];
        $this->hash = $hash;
        
    }
    
    /*
     *    $dataFields array() : Arreglo Datos de la consulta para ser reemplazados en el template del BODY del formato.
     */
    
    public function parseTemplate($dataFields){
        
         foreach($dataFields as $field => $value){
            
             $this->htmlBody = str_replace('['.$field.']',$value,$this->htmlBody);
        }
       
    }
    
    public function makePDF($html)
    {

	$pageFormat = ($this->PDF_PAGE_ORIENTATION == 'L') ? $this->PDF_PAGE_FORMAT .'-'.$this->PDF_PAGE_ORIENTATION :  $this->PDF_PAGE_FORMAT ;
		     
	$pdf=new \mPDF('',$pageFormat,'','',15,15,20,20,5,5);
		       
	$pdf->pagenumPrefix = 'P&aacute;gina No ';
	$pdf->nbpgPrefix = ' de ';
			
        $pdf->SetCreator($this->appName);
        $pdf->SetAuthor($this->appName);
        $pdf->SetTitle($this->NOMBRE);
        $pdf->SetSubject($this->ASUNTO);
        $pdf->SetKeywords($this->KEYWORDS);
	$pdf->SetHash($this->hash);
        
	$html_body = '<style>
		body {
		 font-family: sans-serif;
		}
		@page {
		 margin-top: 2.0cm;
		// margin-bottom: 2.0cm;
		 margin-left: 2.3cm;
		 margin-right: 1.7cm;
		 margin-header: 8mm;
		 margin-footer: 8mm;
		 footer: html_myHTMLFooter;
		  background: #ffffff url(../resources/images/fm_marcagua_csj.jpg) no-repeat center-center;
		}
		@page :first {
		 margin-top: '.$this->MARGIN_TOP.'cm;
		// margin-bottom: 2cm;
		 header: html_myHTMLHeader;
		 footer: _blank;
		// resetpagenum: 1;
		footer: html_myHTMLFooter;
		// background-gradient: linear #FFFFFF #FFFF44 0 0.5 1 0.5;
		 background: #ffffff url(../resources/images/fm_marcagua_csj.jpg) no-repeat center-center;
		}
		//@page letterhead {
		// margin-top: 2.0cm;
		// margin-bottom: 2.0cm;
		// margin-left: 2.3cm;
		// margin-right: 1.7cm;
		// margin-header: 8mm;
		// margin-footer: 8mm;
		// footer: html_myHTMLFooter;
		// background-color:#ffffff;
		//}
		//@page letterhead :first {
		// margin-top: 6.5cm;
		// margin-bottom: 2cm;
		// header: html_myHTMLHeader;
		// footer: _blank;
		// resetpagenum: 1;
		//}
		.gradient {
		 border:0.1mm solid #220044;
		 background-color: #f0f2ff;
		 background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
		}
		.rounded {
		 border:0.1mm solid #220044;
		 background-color: #f0f2ff;
		 background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
		 border-radius: 2mm;
		 background-clip: border-box;
		}
		</style>
		<body>
		';
		   
        		   // <div style="clear: both; margin-top: 1cm; text-align: right;"></div>
	            
	 $html_body .= '<!--mpdf
			<htmlpageheader name="myHTMLHeader">
                        
                        '.$this->htmlHeader.'
                        
			</htmlpageheader>
			<htmlpagefooter name="myHTMLFooter">
				'.$this->htmlFooter.'
			    <table width="100%" style="border-top: 0.1mm solid #000000; vertical-align: top; font-size: 9pt; color: #000055;">
				<tr>
				    <td width="75%" align="left">'.$this->appName.' :: Generado el :(d&iacute;a-mes-a&ntilde;o) {DATE d-m-Y} a las {DATE H:i:s}</td>
				    <td width="25%" align="right"> {PAGENO} {nbpg} </td>
				    </tr>
			    </table>
			</htmlpagefooter>
		       mpdf-->';
	
	$html_body .= $this->htmlBody;
        
	$pdf->writeHTML($html_body);
	 
	$pdf->Output($this->dirDoc.$this->pdfFileName.'.pdf', 'F');
		
	//return $docPT_NAME;
    }
    
}
