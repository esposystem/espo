<?php

namespace Model;

use Lib\APPDbo;


class usuarioModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;
 
    private $FIELDS_UNIQUE = array(
                "NUMEROIDENTIFICACION"=>"N&uacute;mero de Identificacion",
                "EMAIL"=>"Email",
				"USUARIO"=>"");
    private $FIELDS_NOTNULL = array(
				"NUMEROIDENTIFICACION"=>"N&uacute;mero de Identificacion",
				"PRIMERNOMBRE"=>"Primer Nombre",
				"PRIMERAPELLIDO"=>"Primer Apellido",
				"EMAIL"=>"Email");
 
    private $IDUSUARIO;
	private $NUMEROIDENTIFICACION;
	private $PRIMERNOMBRE;
	private $SEGUNDONOMBRE;
	private $PRIMERAPELLIDO;
	private $SEGUNDOAPELLIDO;
	private $TELEFONO;
    private $USUARIO;
	private $EMAIL;
	private $PASSWORD;
	private $AUTORIZADO;
    private $ULTIMOINGRESO;
    private $VIGENCIA;
    private $ESTADO;
	private $FECHATRCR;
	private $USUARIOTRCR;
	private $FECHATRED;
	private $USUARIOTRED;

    private static $FIELD_NAMES=array(self::FIELD_IDUSUARIO=>'IDUSUARIO',
				self::FIELD_NUMEROIDENTIFICACION=>'NUMEROIDENTIFICACION',
				self::FIELD_PRIMERNOMBRE=>'PRIMERNOMBRE',
				self::FIELD_SEGUNDONOMBRE=>'SEGUNDONOMBRE',
				self::FIELD_PRIMERAPELLIDO=>'PRIMERAPELLIDO',
				self::FIELD_SEGUNDOAPELLIDO=>'SEGUNDOAPELLIDO',
				self::FIELD_TELEFONO=>'TELEFONO',
                self::FIELD_USUARIO=>'USUARIO',
				self::FIELD_EMAIL=>'EMAIL',
				self::FIELD_PASSWORD=>'PASSWORD',
                self::FIELD_AUTORIZADO=>'AUTORIZADO',
                self::FIELD_ULTIMOINGRESO=>'ULTIMOINGRESO',
                self::FIELD_VIGENCIA=>'VIGENCIA',
                self::FIELD_ESTADO=>'ESTADO',
				self::FIELD_FECHATRCR=>'FECHATRCR',
				self::FIELD_USUARIOTRCR=>'USUARIOTRCR',
				self::FIELD_FECHATRED=>'FECHATRED',
				self::FIELD_USUARIOTRED=>'USUARIOTRED');

	const FIELD_IDUSUARIO = 78652114;
	const FIELD_NUMEROIDENTIFICACION = 19333814;
	const FIELD_PRIMERNOMBRE = 30654985;
	const FIELD_SEGUNDONOMBRE = 54433872;
	const FIELD_PRIMERAPELLIDO = 85341829;
	const FIELD_SEGUNDOAPELLIDO = 16911457;
	const FIELD_TELEFONO = 18157072;
    const FIELD_USUARIO = 74784998;
	const FIELD_EMAIL = 10766490;
    const FIELD_PASSWORD = 99006928;
    const FIELD_AUTORIZADO = 688278823928;
    const FIELD_ULTIMOINGRESO = 23555526;
    const FIELD_VIGENCIA = 50437732;
	const FIELD_ESTADO = 82844121;
	const FIELD_FECHATRCR = 23555526;
	const FIELD_USUARIOTRCR = 45918636;
	const FIELD_FECHATRED = 22097447;
	const FIELD_USUARIOTRED = 82204654;
      
    public function __construct()
    {
        $this->db = new APPDbo();
        $this->entityName = "USUARIO";
        $this->primaryKey = "IDUSUARIO";
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
            
        $this->db->UPDATE($this->entityName,$fields,array( $this->getPrimaryKey() =>$id), 1);
            
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
         * set value for  IDUSUARIO
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDUSUARIO($idusuario) {
                    $this->IDUSUARIO = $idusuario;
                    return $this;
            }

        /**
         * get value for IDUSUARIO 
         *
         * type : int(11) , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDUSUARIO() {
                    return $this->IDUSUARIO;
        } 
	

	


    




    /**
         * set value for  NUMEROIDENTIFICACION
         *
         * type : varchar(30) , size:10 , default : , NULL : NO ,primary : UNI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setNUMEROIDENTIFICACION($numeroidentificacion) {
                    $this->NUMEROIDENTIFICACION = $numeroidentificacion;
                    return $this;
            }

        /**
         * get value for NUMEROIDENTIFICACION 
         *
         * type : varchar(30) , size:10 , default : , NULL : NO ,primary : UNI
         *
         * @return mixed
         */
        public function &getNUMEROIDENTIFICACION() {
                    return $this->NUMEROIDENTIFICACION;
        } 
    

	

    

	/**
         * set value for  PRIMERNOMBRE
         *
         * type : varchar(60) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setPRIMERNOMBRE($primernombre) {
                    $this->PRIMERNOMBRE = $primernombre;
                    return $this;
            }

        /**
         * get value for PRIMERNOMBRE 
         *
         * type : varchar(60) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getPRIMERNOMBRE() {
                    return $this->PRIMERNOMBRE;
        } 
	

	/**
         * set value for  SEGUNDONOMBRE
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setSEGUNDONOMBRE($segundonombre) {
                    $this->SEGUNDONOMBRE = $segundonombre;
                    return $this;
            }

        /**
         * get value for SEGUNDONOMBRE 
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getSEGUNDONOMBRE() {
                    return $this->SEGUNDONOMBRE;
        } 
	

	/**
         * set value for  PRIMERAPELLIDO
         *
         * type : varchar(60) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setPRIMERAPELLIDO($primerapellido) {
                    $this->PRIMERAPELLIDO = $primerapellido;
                    return $this;
            }

        /**
         * get value for PRIMERAPELLIDO 
         *
         * type : varchar(60) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getPRIMERAPELLIDO() {
                    return $this->PRIMERAPELLIDO;
        } 
	

	/**
         * set value for  SEGUNDOAPELLIDO
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setSEGUNDOAPELLIDO($segundoapellido) {
                    $this->SEGUNDOAPELLIDO = $segundoapellido;
                    return $this;
            }

        /**
         * get value for SEGUNDOAPELLIDO 
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getSEGUNDOAPELLIDO() {
                    return $this->SEGUNDOAPELLIDO;
        } 
	

	/**
         * set value for  TELEFONO
         *
         * type : varchar(30) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setTELEFONO($telefono) {
                    $this->TELEFONO = $telefono;
                    return $this;
            }

        /**
         * get value for TELEFONO 
         *
         * type : varchar(30) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getTELEFONO() {
                    return $this->TELEFONO;
        } 
	

	
	

	/**
         * set value for  EMAIL
         *
         * type : varchar(40) , size:10 , default : , NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setEMAIL($email) {
                    $this->EMAIL = $email;
                    return $this;
            }

        /**
         * get value for EMAIL 
         *
         * type : varchar(40) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getEMAIL() {
                    return $this->EMAIL;
        } 
	

	/**
         * set value for  USUARIO
         *
         * type : varchar(50) , size:10 , default : , NULL : YES ,primary : UNI
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setUSUARIO($usuario) {
                    $this->USUARIO = $usuario;
                    return $this;
            }

        /**
         * get value for USUARIO 
         *
         * type : varchar(50) , size:10 , default : , NULL : YES ,primary : UNI
         *
         * @return mixed
         */
        public function &getUSUARIO() {
                    return $this->USUARIO;
        } 
	

	/**
         * set value for  PASSWORD
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setPASSWORD($password) {
        
            if(!empty($password)){
                 $this->PASSWORD = sha1($password);
            }
		return $this;
	}
     //04/05/2016
    //Gonzalo J Perez
    //Cada vez que se actualiza un usuario cambia la clave
      public function &setPASSWORD2($password) {
        $this->PASSWORD = $password;
        return $this;
	}
        
        /**
         * get value for PASSWORD 
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getPASSWORD() {
                    return $this->PASSWORD;
        } 
	

	/**
         * set value for  ESTADO
         *
         * type : set('Activo','Inactivo') , size:10 , default : Activo, NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */


    /**
         * set value for  PASSWORD
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setAUTORIZADO($autorizado) {
        
            if(!empty($autorizado)){
                 $this->AUTORIZADO = $autorizado;
            }
            return $this;
        }
/**
         * get value for AUTORIZADO 
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getAUTORIZADO() {
                    return $this->AUTORIZADO;
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
         * set value for  VIGENCIA
         *
         * type : date , size:10 , default : 0000-00-00, NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setVIGENCIA($vigencia) {
                    $this->VIGENCIA = $vigencia;
                    return $this;
            }

        /**
         * get value for VIGENCIA 
         *
         * type : date , size:10 , default : 0000-00-00, NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getVIGENCIA() {
                    return $this->VIGENCIA;
        } 
	



    /**
         * set value for  ULTIMOINGRESO
         *
         * type : datetime , size:10 , default : 0000-00-00 00:00:00, NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setULTIMOINGRESO($ultimoingreso) {
                    $this->ULTIMOINGRESO = $ultimoingreso;
                    return $this;
            }

        /**
         * get value for ULTIMOINGRESO 
         *
         * type : datetime , size:10 , default : 0000-00-00 00:00:00, NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getULTIMOINGRESO() {
                    return $this->ULTIMOINGRESO;
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
                
                return array(
		    

		    self::FIELD_NUMEROIDENTIFICACION=>$this->getNUMEROIDENTIFICACION(),
		    
		    self::FIELD_PRIMERNOMBRE=>$this->getPRIMERNOMBRE(),
		    self::FIELD_SEGUNDONOMBRE=>$this->getSEGUNDONOMBRE(),
		    self::FIELD_PRIMERAPELLIDO=>$this->getPRIMERAPELLIDO(),
		    self::FIELD_SEGUNDOAPELLIDO=>$this->getSEGUNDOAPELLIDO(),
		    self::FIELD_TELEFONO=>$this->getTELEFONO(),
            self::FIELD_USUARIO=>$this->getUSUARIO(),

		    self::FIELD_EMAIL=>$this->getEMAIL(),
            self::FIELD_PASSWORD=>$this->getPASSWORD(),
            self::FIELD_AUTORIZADO=>$this->getAUTORIZADO(),
            self::FIELD_ULTIMOINGRESO=>$this->getULTIMOINGRESO(),
            self::FIELD_VIGENCIA=>$this->getVIGENCIA(),
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

            $this->setNUMEROIDENTIFICACION($result['NUMEROIDENTIFICACION']);
		    $this->setPRIMERNOMBRE($result['PRIMERNOMBRE']);
		    $this->setSEGUNDONOMBRE($result['SEGUNDONOMBRE']);
		    $this->setPRIMERAPELLIDO($result['PRIMERAPELLIDO']);
		    $this->setSEGUNDOAPELLIDO($result['SEGUNDOAPELLIDO']);
		    $this->setTELEFONO($result['TELEFONO']);
            $this->setUSUARIO($result['USUARIO']);
		    $this->setEMAIL($result['EMAIL']);
	    //	$this->setPASSWORD($result['PASSWORD']);
            $this->setAUTORIZADO($result['AUTORIZADO']);
            $this->setULTIMOINGRESO($result['ULTIMOINGRESO']);
            $this->setVIGENCIA($result['VIGENCIA']);
		    $this->setESTADO($result['ESTADO']);
		    $this->setFECHATRCR($result['FECHATRCR']);
		    $this->setUSUARIOTRCR($result['USUARIOTRCR']);
		    $this->setFECHATRED($result['FECHATRED']);
		    $this->setUSUARIOTRED($result['USUARIOTRED']);
		}

}
