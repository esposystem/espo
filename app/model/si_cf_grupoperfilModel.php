<?php

namespace Model;

use Lib\APPDbo;

class si_cf_grupoperfilModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;
 
    private $FIELDS_UNIQUE = array("IDGRUPO"=>"",
				"IDPERFIL"=>"");
    private $FIELDS_NOTNULL = array("IDGRUPO"=>"",
				"IDPERFIL"=>"");
 
    private $IDGRUPO;
	private $IDPERFIL;
	private $USUARIOTRCR;
	private $FECHATRCR;
	private $USUARIOTRED;
	private $FECHATRED;

    private static $FIELD_NAMES=array(self::FIELD_IDGRUPO=>'IDGRUPO',
				self::FIELD_IDPERFIL=>'IDPERFIL',
				self::FIELD_USUARIOTRCR=>'USUARIOTRCR',
				self::FIELD_FECHATRCR=>'FECHATRCR',
				self::FIELD_USUARIOTRED=>'USUARIOTRED',
				self::FIELD_FECHATRED=>'FECHATRED');

	const FIELD_IDGRUPO = 31579635;
	const FIELD_IDPERFIL = 99631756;
	const FIELD_USUARIOTRCR = 67513996;
	const FIELD_FECHATRCR = 16593040;
	const FIELD_USUARIOTRED = 95461295;
	const FIELD_FECHATRED = 47673594;
      
    public function __construct()
    {
        $this->db = new APPDbo();
        $this->entityName = "SI_CF_GRUPOPERFIL";
	$this->primaryKey = "IDGRUPO";
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
            
        return $this->db->CREATE($this->entityName,$fields); 
    }
        
    public function getRow($id){
            
        $rowData = $this->db->READ($this->entityName,array( $this->getPrimaryKey()  =>$id));
            
        $this->assignByHash($rowData[0]); 
            
        return $rowData;
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
         * set value for  IDGRUPO
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDGRUPO($idgrupo) {
                    $this->IDGRUPO = $idgrupo;
                    return $this;
            }

        /**
         * get value for IDGRUPO 
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDGRUPO() {
                    return $this->IDGRUPO;
        } 
	

	/**
         * set value for  IDPERFIL
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDPERFIL($idperfil) {
                    $this->IDPERFIL = $idperfil;
                    return $this;
            }

        /**
         * get value for IDPERFIL 
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDPERFIL() {
                    return $this->IDPERFIL;
        } 
	

	/**
         * set value for  USUARIOTRCR
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
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
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getUSUARIOTRCR() {
                    return $this->USUARIOTRCR;
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
         * set value for  USUARIOTRED
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
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
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getUSUARIOTRED() {
                    return $this->USUARIOTRED;
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
                return array(		self::FIELD_IDGRUPO=>$this->getIDGRUPO(),
		self::FIELD_IDPERFIL=>$this->getIDPERFIL(),
		self::FIELD_USUARIOTRCR=>$this->getUSUARIOTRCR(),
		self::FIELD_FECHATRCR=>$this->getFECHATRCR(),
		self::FIELD_USUARIOTRED=>$this->getUSUARIOTRED(),
		self::FIELD_FECHATRED=>$this->getFECHATRED());
		}
        
        /**
	 * Assign values from hash where the indexes match the tables field names
	 *
	 * @param array $result
	 */
	
	public function assignByHash($result) {    
                		$this->setIDGRUPO($result['IDGRUPO']);
		$this->setIDPERFIL($result['IDPERFIL']);
		$this->setUSUARIOTRCR($result['USUARIOTRCR']);
		$this->setFECHATRCR($result['FECHATRCR']);
		$this->setUSUARIOTRED($result['USUARIOTRED']);
		$this->setFECHATRED($result['FECHATRED']);
		}

}
