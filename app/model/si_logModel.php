<?php

namespace Model;

use Lib\APPDbo;

class si_logModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;
 
    private $FIELDS_UNIQUE = array();
    private $FIELDS_NOTNULL = array("IDUsuario"=>"",
				"Fecha"=>"",
				"Modulo"=>"",
				"Transaccion"=>"",
				"Operacion"=>"",
				"DireccionIP"=>"");
 
    private $IDLog;
	private $IDModulo;
	private $IDUsuario;
	private $Fecha;
	private $Modulo;
	private $Transaccion;
	private $Operacion;
	private $DireccionIP;

    private static $FIELD_NAMES=array(self::FIELD_IDLOG=>'IDLog',
				self::FIELD_IDMODULO=>'IDModulo',
				self::FIELD_IDUSUARIO=>'IDUsuario',
				self::FIELD_FECHA=>'Fecha',
				self::FIELD_TABLA=>'Tabla',
				self::FIELD_TRANSACCION=>'Transaccion',
				self::FIELD_OPERACION=>'Operacion',
				self::FIELD_DIRECCIONIP=>'DireccionIP');

	const FIELD_IDLOG = 81620954;
	const FIELD_IDMODULO = 24360583;
	const FIELD_IDUSUARIO = 61368264;
	const FIELD_FECHA = 99481274;
	const FIELD_TABLA = 85038191;
	const FIELD_TRANSACCION = 33544075;
	const FIELD_OPERACION = 9237226;
	const FIELD_DIRECCIONIP = 48117088;
      
    public function __construct()
    {
        $this->db = new APPDbo();
        $this->entityName = "SI_LOG";
	$this->primaryKey = "IDLog";
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
         * set value for  IDLog
         *
         * type : bigint(20) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDLog($idlog) {
                    $this->IDLog = $idlog;
                    return $this;
            }

        /**
         * get value for IDLog 
         *
         * type : bigint(20) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDLog() {
                    return $this->IDLog;
        } 
	

	/**
         * set value for  IDModulo
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDModulo($idmodulo) {
                    $this->IDModulo = $idmodulo;
                    return $this;
            }

        /**
         * get value for IDModulo 
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getIDModulo() {
                    return $this->IDModulo;
        } 
	

	/**
         * set value for  IDUsuario
         *
         * type : int(11) , size:10 , default : 0, NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDUsuario($idusuario) {
                    $this->IDUsuario = $idusuario;
                    return $this;
            }

        /**
         * get value for IDUsuario 
         *
         * type : int(11) , size:10 , default : 0, NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getIDUsuario() {
                    return $this->IDUsuario;
        } 
	

	/**
         * set value for  Fecha
         *
         * type : datetime , size:10 , default : 0000-00-00 00:00:00, NULL : NO ,primary : MUL
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setFecha($fecha) {
                    $this->Fecha = $fecha;
                    return $this;
            }

        /**
         * get value for Fecha 
         *
         * type : datetime , size:10 , default : 0000-00-00 00:00:00, NULL : NO ,primary : MUL
         *
         * @return mixed
         */
        public function &getFecha() {
                    return $this->Fecha;
        } 
	

	/**
         * set value for  Tabla
         *
         * type : varchar(160) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setTabla($tabla) {
                    $this->Tabla = $tabla;
                    return $this;
            }

        /**
         * get value for Tabla 
         *
         * type : varchar(160) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getTabla() {
                    return $this->Tabla;
        } 
	

	/**
         * set value for  Transaccion
         *
         * type : varchar(160) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setTransaccion($transaccion) {
                    $this->Transaccion = $transaccion;
                    return $this;
            }

        /**
         * get value for Transaccion 
         *
         * type : varchar(160) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getTransaccion() {
                    return $this->Transaccion;
        } 
	

	/**
         * set value for  Operacion
         *
         * type : text , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setOperacion($operacion) {
                    $this->Operacion = $operacion;
                    return $this;
            }

        /**
         * get value for Operacion 
         *
         * type : text , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getOperacion() {
                    return $this->Operacion;
        } 
	

	/**
         * set value for  DireccionIP
         *
         * type : varchar(160) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setDireccionIP($direccionip) {
                    $this->DireccionIP = $direccionip;
                    return $this;
            }

        /**
         * get value for DireccionIP 
         *
         * type : varchar(160) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getDireccionIP() {
                    return $this->DireccionIP;
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
                return array(		self::FIELD_IDMODULO=>$this->getIDModulo(),
		self::FIELD_IDUSUARIO=>$this->getIDUsuario(),
		self::FIELD_FECHA=>$this->getFecha(),
		self::FIELD_TABLA=>$this->getTabla(),
		self::FIELD_TRANSACCION=>$this->getTransaccion(),
		self::FIELD_OPERACION=>$this->getOperacion(),
		self::FIELD_DIRECCIONIP=>$this->getDireccionIP());
		}
        
        /**
	 * Assign values from hash where the indexes match the tables field names
	 *
	 * @param array $result
	 */
	
	public function assignByHash($result) {    
                		$this->setIDModulo($result['IDModulo']);
		$this->setIDUsuario($result['IDUsuario']);
		$this->setFecha($result['Fecha']);
		$this->setTabla($result['Tabla']);
		$this->setTransaccion($result['Transaccion']);
		$this->setOperacion($result['Operacion']);
		$this->setDireccionIP($result['DireccionIP']);
		}

}
