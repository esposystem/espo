<?php
/**
 * Descripción : Clase creada para el consumo de WS SISIPEC
 * 
 * @author 
 */

require_once LIB_PATH. 'APPXML2array.class.php';
 
class WSDLHandler {
    //put your code here
    var $host;// = "http://190.25.187.165";
    var $wsdl;// = "/WSCSJ/service.asmx?WSDL";
    var $client;
    var $options;
    var $xml;
    var $results;

    public function __construct($host,$wsdl){
        
        $this->options = array( 
                'soap_version'=>SOAP_1_2, 
                'exceptions'=>true, 
                'trace'=>1, 
                'cache_wsdl'=>WSDL_CACHE_NONE,
		'features'=>SOAP_SINGLE_ELEMENT_ARRAYS
            );
        $this->host = $host;
	    $this->wsdl = $wsdl;
        $this->client = new SoapClient($this->host.$this->wsdl, $this->options);
        
       
    }

    /*
     * getNovedades : Obtiene novedades de Kactus en un rango de fechas, WS kactus retorna XML el metodo retorna un array con las novedades
     * $fechaIni string : formato mm/dd/aaaa 'FecInic'=>'01/01/2014'
     * $fechaFin string : formato mm/dd/aaaa 'FecFina'=>'01/20/2014'
     */
    public function getNovedades($fechaIni,$fechaFin){
        
        $this->results = $this->client->AusentismoDePersonal(array('FecInic'=>$fechaIni,'FecFina'=>$fechaFin));
	
       // print_r( $this->results);
	$this->xml = $this->results->AusentismoDePersonalResult->any;
        
        $this->cleanHeaderResult();
        
        $this->arrayResult = new assoc_array2xml();
	   
	$this->arrayData = $this->arrayResult->xml2array($this->xml,1,'open');
	
     //   print_r($this->arrayData);
        
        $this->arrayData = $this->arrayData['NewDataSet'];
       // print_r($this->arrayData['Table1']);
	// return  $this->arrayData['Table1'];
    
    
  //  $this->dataNovedades = $arrayData['NewDataSet'];
	
//	print_r($dataNovedades['Table1']);
	
        return $this->arrayData['Table1'];
    
    }
    public function cleanHeaderResult(){
          
	$this->xml = str_replace('<xs:schema xmlns="" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" id="NewDataSet">',"",$this->xml);
	$this->xml = str_replace('<xs:element name="NewDataSet" msdata:IsDataSet="true" msdata:MainDataTable="Table1" msdata:UseCurrentLocale="true">',"",$this->xml);
	$this->xml = str_replace('<xs:complexType><xs:choice minOccurs="0" maxOccurs="unbounded">',"",$this->xml);
	$this->xml = str_replace('<xs:element name="Table1"><xs:complexType><xs:sequence>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="Cedula" type="xs:int" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="Departamento" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="Cargo" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="Seccional" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="Despachos" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="UnidadEjecutora" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="NumeroContrato" type="xs:int" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="FechaInicialContrato" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="FechaVencimiento" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="Novedad" type="xs:string" minOccurs="0"/>',"",$this->xml);
	
	$this->xml = str_replace('<xs:element name="FechaInicialNovedad" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="FechaFinalNovedad" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="Apellido" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="Nombre" type="xs:string" minOccurs="0"/>',"",$this->xml);

	$this->xml = str_replace('<xs:element name="Direccion" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('<xs:element name="Ciudad" type="xs:string" minOccurs="0"/>',"",$this->xml);
	$this->xml = str_replace('</xs:sequence></xs:complexType>',"",$this->xml);
	$this->xml = str_replace('</xs:element></xs:choice>',"",$this->xml);
	//
	$this->xml = str_replace('</xs:complexType></xs:element></xs:schema>',"",$this->xml);
	$this->xml = str_replace('<diffgr:diffgram xmlns:msdata="urn:schemas-microsoft-com:xml-msdata" xmlns:diffgr="urn:schemas-microsoft-com:xml-diffgram-v1">',"",$this->xml);
	
       // return $results;
    }
}
?>