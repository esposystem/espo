<?php

namespace Model;

//require MODEL_PATH. 'gs_cf_parametroModel.php';
//require MODEL_PATH. 'si_cf_parametroModel.php';
//require MODEL_PATH. 'pt_cf_parametroModel.php';
//require MODEL_PATH. 'io_cf_parametroModel.php';

use Lib\APPDbo;

class sesionclienteModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;

 
    private $IDSESION;
	private $IDCLIENTE;
	private $INICIO;
	private $DATOS;

    private static $FIELD_NAMES=array(self::FIELD_IDSESION=>'IDSESION',
				self::FIELD_IDCLIENTE=>'IDCLIENTE',
				self::FIELD_INICIO=>'INICIO',
				self::FIELD_DATOS=>'DATOS');

	const FIELD_IDSESION = 19182743;
	const FIELD_IDCLIENTE = 80923941;
	const FIELD_INICIO = 17116859;
	const FIELD_DATOS = 22250860;
      
    public function __construct()
    {
        $this->db = new APPDbo();
	
        
	$this->entityName = "SESIONCLIENTE";
	$this->primaryKey = "IDSESION";
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
          
	return $this->db->CREATE($this->entityName,$fields,TRUE,FALSE);
	
    }

    public function getRow($id){
            
        $rowData = $this->db->READ($this->entityName,array( $this->getPrimaryKey()  =>$id));
            
	if(!empty($rowData[0]))
	    $this->assignByHash($rowData[0]); 
            
        return $rowData;
    }
        
    public function saveRow($id){
            
        $fields = $this->toHash();
            
        $this->db->UPDATE($this->entityName,$fields,array( $this->getPrimaryKey() =>$id),"",FALSE,FALSE);
            
        return $this->db->AFFECTED_ROWS;
        
    }
        
    public function deleteRow($id){
            
        $this->db->DELETE($this->entityName,array( $this->getPrimaryKey() =>$id));
     
        return $this->db->AFFECTED_ROWS;
        
    }
     
     public function deleteOld($timeSession){
            
	
	   $sql = "DELETE FROM ".$this->entityName." WHERE  DATEADD(minute,".$timeSession.",INICIO) < getdate()";
	   //exit;

        //$this->db->query($sql); descomentariar cuando la hora del server esté bien
     
     
       // return $this->db->AFFECTED_ROWS;
        
    }   

	    
	//    $limpiaqry = db_query("DELETE FROM ".$this->entityName." WHERE DATE_ADD(Inicio, INTERVAL 30 MINUTE)<now()");
	    
	
	/**
         * set value for  IDSESION
         *
         * type : varchar(40) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDSESION($idsesion) {
                    $this->IDSESION = $idsesion;
                    return $this;
            }

        /**
         * get value for IDSESION 
         *
         * type : varchar(40) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDSESION() {
                    return $this->IDSESION;
        } 
	

	/**
         * set value for  IDUSUARIO
         *
         * type : int(11) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDCLIENTE($idcliente) {
                    $this->IDCLIENTE = $idcliente;
                    return $this;
            }

        /**
         * get value for IDUSUARIO 
         *
         * type : int(11) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getIDCLIENTE() {
                    return $this->IDCLIENTE;
        } 
	

	/**
         * set value for  INICIO
         *
         * type : datetime , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setINICIO($inicio) {
                    $this->INICIO = $inicio;
                    return $this;
            }

        /**
         * get value for INICIO 
         *
         * type : datetime , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getINICIO() {
                    return $this->INICIO;
        } 
	

	/**
         * set value for  DATOS
         *
         * type : text , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setDATOS($datos) {
                    $this->DATOS = $datos;
                    return $this;
            }

        /**
         * get value for DATOS 
         *
         * type : text , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getDATOS() {
                    return $this->DATOS;
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
                return array(
		    self::FIELD_IDSESION=>$this->getIDSESION(),
		    self::FIELD_IDCLIENTE=>$this->getIDCLIENTE(),
		    self::FIELD_INICIO=>$this->getINICIO(),
		    self::FIELD_DATOS=>$this->getDATOS());
		}
        
        /**
	 * Assign values from hash where the indexes match the tables field names
	 *
	 * @param array $result
	 */
	
	public function assignByHash($result) {
		 $this->setIDSESION($result['IDSESION']);
                $this->setIDCLIENTE($result['IDCLIENTE']);
		$this->setINICIO($result['INICIO']);
		$this->setDATOS($result['DATOS']);
		}

}
