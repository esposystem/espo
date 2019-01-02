<?php

namespace Model;

use Lib\APPDbo;


class ciudadModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;
 
	private $IDCIUDAD;
    private $IDESTADO;
	private $NOMBRE;
    private $CODIGODANE;
    private $CODIGOSYS;
	private $FECHATRCR;
	private $USUARIOTRCR;
	private $FECHATRED;
    private $USUARIOTRED;
    private $IDREGIONAL;

private static $FIELD_NAMES=array(	self::FIELD_IDCIUDAD=>'IDCIUDAD',
    self::FIELD_IDESTADO=>'IDESTADO',
	self::FIELD_NOMBRE=>'NOMBRE',
    self::FIELD_CODIGODANE=>'CODIGODANE',
    self::FIELD_CODIGOSYS=>'CODIGOSYS',
	self::FIELD_FECHATRCR=>'FECHATRCR',
	self::FIELD_USUARIOTRCR=>'USUARIOTRCR',
	self::FIELD_FECHATRED=>'FECHATRED',
	self::FIELD_USUARIOTRED=>'USUARIOTRED',
    self::FIELD_IDREGIONAL=>'IDREGIONAL');

	const FIELD_IDCIUDAD = 28257462;
    const FIELD_IDESTADO = 82109076;
	const FIELD_NOMBRE = 55593535;
    const FIELD_CODIGODANE = 58287420;
    const FIELD_CODIGOSYS = 5828742345;
	const FIELD_FECHATRCR = 4986180;
	const FIELD_USUARIOTRCR = 11777012;
	const FIELD_FECHATRED = 50533291;
    const FIELD_USUARIOTRED = 94531798;
    const FIELD_IDREGIONAL = 9453173423498;
      
    public function __construct()
    {
        $this->db = new APPDbo();
        $this->entityName = "CIUDAD";
	$this->primaryKey = "IDCIUDAD";
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
            
            return $this->db->CREATE($this->entityName,$fields);;
        
        }
        
        public function getRow($id){
            
            $rowData = $this->db->READ($this->entityName,array( $this->getPrimaryKey()  =>$id));
            
            $this->assignByHash($rowData); 
            
            return $rowData;
        }
        
        public function saveRow($id){
            
            $fields = $this->toHash();
            
            $this->db->UPDATE($this->entityName,$fields,array( $this->getPrimaryKey() =>$id) ,1 );
            
            return $this->db->AFFECTED_ROWS;
        
        }
        
        
        public function deleteRow($id){
            
            $this->db->DELETE($this->entityName,array( $this->getPrimaryKey() =>$id));
            
            return $this->db->AFFECTED_ROWS;
        
        }
        
	
	/**
         * set value for  IDCIUDAD
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDCIUDAD($idciudad) {
                    $this->IDCIUDAD = $idciudad;
                    return $this;
            }

        /**
         * get value for IDCIUDAD 
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDCIUDAD() {
                    return $this->IDCIUDAD;
        } 
	

	/**
         * set value for  IDESTADO         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDESTADO($idestado) {
                    $this->IDESTADO = $idestado;
                    return $this;
            }

        /**
         * get value for IDESTADO
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getIDESTADO() {
                    return $this->IDESTADO;
        } 

       

	/**
         * set value for  NOMBRE
         *
         * type : varchar(200) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setNOMBRE($nombre) {
                    $this->NOMBRE = $nombre;
                    return $this;
            }

        /**
         * get value for NOMBRE 
         *
         * type : varchar(200) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getNOMBRE() {
                    return $this->NOMBRE;
        } 
	

	/**
         * set value for  CODIGO
         *
         * type : varchar(30) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setCODIGODANE($codigodane) {
                    $this->CODIGODANE = $codigodane;
                    return $this;
            }

        /**
         * get value for CODIGO 
         *
         * type : varchar(30) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getCODIGODANE() {
                    return $this->CODIGODANE;
        } 
	

	/**
         * set value for  ACTIVO
         *
         * type : set('SI','NO') , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setCODIGOSYS($codigosys) {
                    $this->CODIGOSYS = $codigosys;
                    return $this;
            }

        /**
         * get value for ACTIVO 
         *
         * type : set('SI','NO') , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getCODIGOSYS() {
                    return $this->CODIGOSYS;
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
    
        public function &setFECHATRED() {
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
         * get value for IDREGIONAL
         *
         * type : varchar(40) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getIDREGIONAL() {
                    return $this->IDREGIONAL;
        } 



        /**
         * set value for  USUARIOTRED
         *
         * type : varchar(40) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDREGIONAL($idregional) {
                    $this->IDREGIONAL = $idregional;
                    return $this;
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
                return array(		self::FIELD_IDESTADO=>$this->getIDESTADO(),
		self::FIELD_NOMBRE=>$this->getNOMBRE(),
		self::FIELD_CODIGODANE=>$this->getCODIGODANE(),
		self::FIELD_CODIGOSYS=>$this->getCODIGOSYS(),
		self::FIELD_FECHATRCR=>$this->getFECHATRCR(),
		self::FIELD_USUARIOTRCR=>$this->getUSUARIOTRCR(),
		self::FIELD_FECHATRED=>$this->getFECHATRED(),
		self::FIELD_USUARIOTRED=>$this->getUSUARIOTRED(),
        self::FIELD_IDREGIONAL=>$this->getIDREGIONAL());
		}
        
        /**
	 * Assign values from hash where the indexes match the tables field names
	 *
	 * @param array $result
	 */
	
	public function assignByHash($result) {    
                		$this->setIDESTADO($result['IDESTADO']);
		$this->setNOMBRE($result['NOMBRE']);
		$this->setCODIGODANE($result['CODIGODANE']);
		$this->setCODIGOSYS($result['CODIGOSYS']);
		$this->setFECHATRCR($result['FECHATRCR']);
		$this->setUSUARIOTRCR($result['USUARIOTRCR']);
		$this->setFECHATRED($result['FECHATRED']);
        $this->setUSUARIOTRED($result['USUARIOTRED']);
        $this->setIDREGIONAL($result['IDREGIONAL']);
		}
      
    
    
}
