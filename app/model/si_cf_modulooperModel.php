<?php

namespace Model;

use Lib\APPDbo;

class si_cf_modulooperModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;
 
    private $FIELDS_UNIQUE = array("IDMODULO"=>"",
				"IDOPERACION"=>"");
    private $FIELDS_NOTNULL = array("IDMODULO"=>"",
				"IDOPERACION"=>"",
				"OPERACION"=>"");
 
    private $IDMODULO;
	private $IDOPERACION;
	private $OPERACION;
	private $DESCRIPCION;

    private static $FIELD_NAMES=array(self::FIELD_IDMODULO=>'IDMODULO',
				self::FIELD_IDOPERACION=>'IDOPERACION',
				self::FIELD_OPERACION=>'OPERACION',
				self::FIELD_DESCRIPCION=>'DESCRIPCION');

	const FIELD_IDMODULO = 99662916;
	const FIELD_IDOPERACION = 74944942;
	const FIELD_OPERACION = 54971846;
	const FIELD_DESCRIPCION = 67176913;
      
    public function __construct()
    {
        $this->db = new APPDbo();
        $this->entityName = "SI_CF_MODULOOPER";
	$this->primaryKey = "IDMODULO";
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
         * set value for  IDMODULO
         *
         * type : int(10) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDMODULO($idmodulo) {
                    $this->IDMODULO = $idmodulo;
                    return $this;
            }

        /**
         * get value for IDMODULO 
         *
         * type : int(10) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDMODULO() {
                    return $this->IDMODULO;
        } 
	

	/**
         * set value for  IDOPERACION
         *
         * type : int(10) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDOPERACION($idoperacion) {
                    $this->IDOPERACION = $idoperacion;
                    return $this;
            }

        /**
         * get value for IDOPERACION 
         *
         * type : int(10) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDOPERACION() {
                    return $this->IDOPERACION;
        } 
	

	/**
         * set value for  OPERACION
         *
         * type : varchar(30) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setOPERACION($operacion) {
                    $this->OPERACION = $operacion;
                    return $this;
            }

        /**
         * get value for OPERACION 
         *
         * type : varchar(30) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getOPERACION() {
                    return $this->OPERACION;
        } 
	

	/**
         * set value for  DESCRIPCION
         *
         * type : varchar(120) , size:10 , default : , NULL : YES ,primary : 
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
         * type : varchar(120) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getDESCRIPCION() {
                    return $this->DESCRIPCION;
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
                return array(		self::FIELD_IDMODULO=>$this->getIDMODULO(),
		self::FIELD_IDOPERACION=>$this->getIDOPERACION(),
		self::FIELD_OPERACION=>$this->getOPERACION(),
		self::FIELD_DESCRIPCION=>$this->getDESCRIPCION());
		}
        
        /**
	 * Assign values from hash where the indexes match the tables field names
	 *
	 * @param array $result
	 */
	
	public function assignByHash($result) {    
                		$this->setIDMODULO($result['IDMODULO']);
		$this->setIDOPERACION($result['IDOPERACION']);
		$this->setOPERACION($result['OPERACION']);
		$this->setDESCRIPCION($result['DESCRIPCION']);
		}

}
