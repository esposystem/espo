<?php

namespace Model;

use Lib\APPDbo;

class io_cf_parametroModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;
 
    private $FIELDS_UNIQUE = array("IDPARAMETRO"=>"Nombre del Par&aacute;metro");
    private $FIELDS_NOTNULL = array("IDPARAMETRO"=>"Nombre del Par&aacute;metro",
				"VALOR"=>"Valor del Par&aacute;metro");
 
    private $IDPARAMETRO;
	private $VALOR;
	private $DESCRIPCION;
	private $ESTADO;
	private $FECHATRCR;
	private $USUARIOTRCR;
	private $FECHATRED;
	private $USUARIOTRED;

    private static $FIELD_NAMES=array(self::FIELD_IDPARAMETRO=>'IDPARAMETRO',
				self::FIELD_VALOR=>'VALOR',
				self::FIELD_DESCRIPCION=>'DESCRIPCION',
				self::FIELD_ESTADO=>'ESTADO',
				self::FIELD_FECHATRCR=>'FECHATRCR',
				self::FIELD_USUARIOTRCR=>'USUARIOTRCR',
				self::FIELD_FECHATRED=>'FECHATRED',
				self::FIELD_USUARIOTRED=>'USUARIOTRED');

	const FIELD_IDPARAMETRO = 35693414;
	const FIELD_VALOR = 78299325;
	const FIELD_DESCRIPCION = 26474802;
	const FIELD_ESTADO = 82592097;
	const FIELD_FECHATRCR = 23714043;
	const FIELD_USUARIOTRCR = 69787840;
	const FIELD_FECHATRED = 46520273;
	const FIELD_USUARIOTRED = 96864445;
      
    public function __construct()
    {
        $this->db = new APPDbo();
        $this->entityName = "IO_CF_PARAMETRO";
	$this->primaryKey = "IDPARAMETRO";
    }
    
    public function getEntityName(){
        return  $this->entityName;
    }
    
    public function getPrimaryKey(){
        return  (string) $this->primaryKey;
    }
    
    public function getTotalRows(){
        return  $this->totalRows;
    }
    
    public function getRows($fields = array(),$join = array(),$constrain = '',$sortBy='' , $inOrder='' , $page = 0 , $rows = 0)
    {
            
        $this->db->setLimitsResult($page,$rows);
     
        $response = $this->db->fetchAll($this->entityName,$fields,$join,$constrain,$sortBy,$inOrder,"array");
        
        $this->totalRows = $this->db->COUNT($this->entityName,$constrain);
        
        return $response;
    
    }
    
    public function insertRow(){
            
	$fields = $this->toHash();
            
        return $this->db->CREATE($this->entityName,$fields,TRUE); 
    }
        
    public function getRow($id){
            
        $rowData = $this->db->READ($this->entityName,array( $this->getPrimaryKey()  =>$id));
            
        $this->assignByHash($rowData[0]); 
            
        return $rowData;
    }
        
    public function getArrayParam($constrain = '')
    {
	$arrayParam  = array();
	
        $response = $this->db->fetchAll($this->entityName,array('IDPARAMETRO','VALOR'));
        
        foreach($response AS $field)
		$arrayParam[$field['IDPARAMETRO']] = $field['VALOR'];
	
        return $arrayParam;
    
    }
    
    public function saveRow($id){
            
        $fields = $this->toHash();
            
        $this->db->UPDATE($this->entityName,$fields,array( $this->getPrimaryKey() =>$id));
            
        return $this->db->AFFECTED_ROWS;
        
    }
        
    public function deleteRow($id){
            
        $this->db->DELETE($this->entityName,array( $this->getPrimaryKey() =>$id));
            
        return $this->db->AFFECTED_ROWS;
        
    }
        
    public function isValidUnique($id=NULL){

	    $result = array();
	    
	    $result["success"] = true;
	    
	    foreach($this->FIELDS_UNIQUE as $field => $fieldDesc){
		
		$upperValue = strtoupper($this->{$field});
		
		$strfield = "UPPER($field)";
		
		$constrain = array( " $strfield = '$upperValue' " );
		
		$isUnique = $this->db->fieldUnique($this->entityName,$constrain);
		
		if( ( !$isUnique["success"] && $id != $isUnique["row"][0][$this->primaryKey]) || count($isUnique["row"]) > 1){
    
		    $mess .= "El " . $fieldDesc . " : ".$this->{$field}." ya existe en el sistema !!";
		    
		    $result["success"] = false;
		    $result["msg"] = $mess;
		    
		    return $result;
		}
	    }
	    
	    return $result;
    }
	
    public function getNotNullFields(){
	    return $this->FIELDS_NOTNULL;
    }
	
    public function getUniqueFields(){
	    return $this->FIELDS_UNIQUE;
    }
	
	
	/**
         * set value for  IDPARAMETRO
         *
         * type : varchar(20) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDPARAMETRO($idparametro) {
                    $this->IDPARAMETRO = $idparametro;
                    return $this;
            }

        /**
         * get value for IDPARAMETRO 
         *
         * type : varchar(20) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDPARAMETRO() {
                    return $this->IDPARAMETRO;
        } 
	

	/**
         * set value for  VALOR
         *
         * type : varchar(40) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setVALOR($valor) {
                    $this->VALOR = $valor;
                    return $this;
            }

        /**
         * get value for VALOR 
         *
         * type : varchar(40) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getVALOR() {
                    return $this->VALOR;
        } 
	

	/**
         * set value for  DESCRIPCION
         *
         * type : text , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setDESCRIPCION($descripcion) {
                    $this->DESCRIPCION = $descripcion;
                    return $this;
            }

        /**
         * get value for DESCRIPCION 
         *
         * type : text , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getDESCRIPCION() {
                    return $this->DESCRIPCION;
        } 
	

	/**
         * set value for  ESTADO
         *
         * type : set('Activo','Inactivo') , size:10 , default : Activo, NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setESTADO($estado) {
                    $this->ESTADO = $estado;
                    return $this;
            }

        /**
         * get value for ESTADO 
         *
         * type : set('Activo','Inactivo') , size:10 , default : Activo, NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getESTADO() {
                    return $this->ESTADO;
        } 
	

	/**
         * set value for  FECHATRCR
         *
         * type : datetime , size:10 , default : 0000-00-00 00:00:00, NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setFECHATRCR($fechatrcr) {
                    $this->FECHATRCR = $fechatrcr;
                    return $this;
            }

        /**
         * get value for FECHATRCR 
         *
         * type : datetime , size:10 , default : 0000-00-00 00:00:00, NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getFECHATRCR() {
                    return $this->FECHATRCR;
        } 
	

	/**
         * set value for  USUARIOTRCR
         *
         * type : varchar(40) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setUSUARIOTRCR($usuariotrcr) {
                    $this->USUARIOTRCR = $usuariotrcr;
                    return $this;
            }

        /**
         * get value for USUARIOTRCR 
         *
         * type : varchar(40) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getUSUARIOTRCR() {
                    return $this->USUARIOTRCR;
        } 
	

	/**
         * set value for  FECHATRED
         *
         * type : datetime , size:10 , default : 0000-00-00 00:00:00, NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setFECHATRED($fechatred) {
                    $this->FECHATRED = $fechatred;
                    return $this;
            }

        /**
         * get value for FECHATRED 
         *
         * type : datetime , size:10 , default : 0000-00-00 00:00:00, NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getFECHATRED() {
                    return $this->FECHATRED;
        } 
	

	/**
         * set value for  USUARIOTRED
         *
         * type : varchar(40) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setUSUARIOTRED($usuariotred) {
                    $this->USUARIOTRED = $usuariotred;
                    return $this;
            }

        /**
         * get value for USUARIOTRED 
         *
         * type : varchar(40) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getUSUARIOTRED() {
                    return $this->USUARIOTRED;
        } 
	
	
   /**
	 * return hash with the field name as index and the field value as value.
	 *
	 * @return array
	 */
	public function toHash() {
		$array=$this->toArray();
               
		$hash=array();
		foreach ($array as $fieldId=>$value) {
                    
			$hash[self::$FIELD_NAMES[$fieldId]] = $value;
		}
		return $hash;
	}

	/**
	 * return array with the field id as index and the field value as value.
	 *
	 * @return array
	 */
	 
	public function toArray() {    
                return array(		self::FIELD_IDPARAMETRO=>$this->getIDPARAMETRO(),
		self::FIELD_VALOR=>$this->getVALOR(),
		self::FIELD_DESCRIPCION=>$this->getDESCRIPCION(),
		self::FIELD_ESTADO=>$this->getESTADO(),
		self::FIELD_FECHATRCR=>$this->getFECHATRCR(),
		self::FIELD_USUARIOTRCR=>$this->getUSUARIOTRCR(),
		self::FIELD_FECHATRED=>$this->getFECHATRED(),
		self::FIELD_USUARIOTRED=>$this->getUSUARIOTRED());
		}
        
        /**
	 * Assign values from hash where the indexes match the tables field names
	 *
	 * @param array $result
	 */
	
	public function assignByHash($result) {    
                		$this->setIDPARAMETRO($result['IDPARAMETRO']);
		$this->setVALOR($result['VALOR']);
		$this->setDESCRIPCION($result['DESCRIPCION']);
		$this->setESTADO($result['ESTADO']);
		$this->setFECHATRCR($result['FECHATRCR']);
		$this->setUSUARIOTRCR($result['USUARIOTRCR']);
		$this->setFECHATRED($result['FECHATRED']);
		$this->setUSUARIOTRED($result['USUARIOTRED']);
		}

}
