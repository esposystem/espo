<?php

namespace Model;

use Lib\APPDbo;

require_once MODEL_PATH . 'si_cf_moduloModel.php';

class si_cf_modulomenuModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;
 
    private $FIELDS_UNIQUE = array("IDUSUARIO"=>"",
				"IDMODULO"=>"");
    private $FIELDS_NOTNULL = array("IDUSUARIO"=>"",
				"IDMODULO"=>"",
				"IDPADRE"=>"",
				"NOMBRE"=>"",
				"POSICION"=>"",
				"DEPENDIENTE"=>"");
 
    private $IDUSUARIO;
	private $IDMODULO;
	private $IDPADRE;
	private $NOMBRE;
	private $POSICION;
	private $DEPENDIENTE;
	private $MODULO;
	private $DESCRIPCION;
	private $FILEMANUAL;

    private static $FIELD_NAMES=array(self::FIELD_IDUSUARIO=>'IDUSUARIO',
				self::FIELD_IDMODULO=>'IDMODULO',
				self::FIELD_IDPADRE=>'IDPADRE',
				self::FIELD_NOMBRE=>'NOMBRE',
				self::FIELD_POSICION=>'POSICION',
				self::FIELD_DEPENDIENTE=>'DEPENDIENTE',
				self::FIELD_MODULO=>'MODULO',
				self::FIELD_DESCRIPCION=>'DESCRIPCION',
				self::FIELD_FILEMANUAL=>'FILEMANUAL');

	const FIELD_IDUSUARIO = 42469649;
	const FIELD_IDMODULO = 65706456;
	const FIELD_IDPADRE = 82002075;
	const FIELD_NOMBRE = 6021908;
	const FIELD_POSICION = 62625075;
	const FIELD_DEPENDIENTE = 90018228;
	const FIELD_MODULO = 94231045;
	const FIELD_DESCRIPCION = 43465307;
	const FIELD_FILEMANUAL = 55340089;
      
    public function __construct()
    {
        $this->db = new APPDbo();
        $this->entityName = "SI_CF_MODULOMENU";
	$this->primaryKey = "IDUSUARIO";
	$this->moduloModel = new \Model\si_cf_moduloModel();
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
	
    public function getNotNullFields(){
	    return $this->FIELDS_NOTNULL;
    }
	
    public function getUniqueFields(){
	    return $this->FIELDS_UNIQUE;
    }
	
    public function setMenuPerfil($idUsuario){
	
	$this->db->query(" DELETE FROM SI_CF_MODULOMENU WHERE IDUSUARIO = '$idUsuario' ");
	
	//print_r($resultModulos);
	
	$this->db->query("SELECT PO.IDMODULO,PO.IDOPERACION,MO.OPERACION,M.MODULO,M.POSICION,GP.IDGRUPO
					   	FROM SI_CF_GRUPOUSUARIO GU, SI_CF_GRUPOPERFIL GP, SI_CF_PERFILOPER PO, SI_CF_MODULOOPER MO, SI_CF_MODULO M
			      			WHERE GP.IDGRUPO = GU.IDGRUPO
				    		AND GP.IDPERFIL = PO.IDPERFIL
						AND MO.IDMODULO = PO.IDMODULO
						AND MO.IDOPERACION = PO.IDOperacion
						AND M.IDMODULO = MO.IDMODULO
						AND GU.IDUSUARIO = '$idUsuario'
						GROUP BY PO.IDMODULO,PO.IDOPERACION,MO.OPERACION,M.MODULO,M.POSICION,GP.IDGRUPO
						ORDER BY M.POSICION");
	 	 
	$resultPermisos =  $this->db->fetch( "array" );
	 
	$arrayPermisos = array();
	$arrayModulos = array();
	$arrayGrupos = array();
	$arrayModManual = array();
	
	$arrayIDModulos = $this->moduloModel->listId();
	
	foreach($resultPermisos as $r_permiso){
					
		$arrayPermisos[$r_permiso["MODULO"]][$r_permiso["OPERACION"]] = $r_permiso["IDMODULO"];
		$arrayModulos[$r_permiso["IDMODULO"]] = $arrayIDModulos[$r_permiso["IDMODULO"]];
		$arrayGrupos[$r_permiso["IDGRUPO"]] = $r_permiso["IDGRUPO"];
						
		$this->moduloModel->getModulos($r_permiso["IDMODULO"],$array_ModUser);
					
		
		foreach($array_ModUser  AS $key2 => $r_mod){
			
	    	 
		 if(!empty($r_mod['FILEMANUAL']))
			$arrayModManual[$r_mod['IDMODULO']] = $r_mod['FILEMANUAL'];
			
		  	$this->db->query("INSERT INTO SI_CF_MODULOMENU
					    VALUES($idUsuario,".$r_mod['IDMODULO'].",
					    ".$r_mod['IDPADRE'].",
					    '".$r_mod['NOMBRE']."',
					    ".$r_mod['POSICION'].",
					    '".$r_mod['DEPENDIENTE']."',
					    '".$r_mod['MODULO']."','".$r_mod['DESCRIPCION']."','".$r_mod['FILEMANUAL']."')
					");
		}
	}
	return array($arrayPermisos,$arrayModulos,$arrayGrupos,$arrayModManual);
    }
    
    function getTreePerfil($rootid,$IDUsuario)
    {
       
	$arr = array();
       
	$this->db->query("SELECT * FROM SI_CF_MODULOMENU
			WHERE IDPADRE = '$rootid'
			AND IDUSUARIO = '$IDUsuario'
			ORDER BY POSICION");
	 	 
	$arrayPermisos =  $this->db->fetch( "array" );
	
	foreach($arrayPermisos AS $row){
	    
	    $attributes = '';
	    if(!empty($row['MODULO']))
			  //  $attributes = array("url"=>"indexnew.php?mod=".$row['Modulo']);
		    $attributes = array("url"=>$row['MODULO'],"DESCRIPCION"=>$row['DESCRIPCION'],"FILEMANUAL"=>$row['FILEMANUAL']);
	    
	    	    $nodos = $this->getTreePerfil($row["IDMODULO"],$IDUsuario);
		
		    $arr[] = array(
				    "id" => $row["IDMODULO"],
				   "text" => $row["NOMBRE"],
				   "attributes"=> $attributes,
				   "children" => $nodos,
				 );
		    
       }
       
       return $arr;
    }

    
	/**
         * set value for  IDUSUARIO
         *
         * type : int(10) unsigned , size:10 , default : , NULL : NO ,primary : PRI
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
         * type : int(10) unsigned , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDUSUARIO() {
                    return $this->IDUSUARIO;
        } 
	

	/**
         * set value for  IDMODULO
         *
         * type : int(10) unsigned , size:10 , default : , NULL : NO ,primary : PRI
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
         * type : int(10) unsigned , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDMODULO() {
                    return $this->IDMODULO;
        } 
	

	/**
         * set value for  IDPADRE
         *
         * type : int(10) unsigned , size:10 , default : 0, NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setIDPADRE($idpadre) {
                    $this->IDPADRE = $idpadre;
                    return $this;
            }

        /**
         * get value for IDPADRE 
         *
         * type : int(10) unsigned , size:10 , default : 0, NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getIDPADRE() {
                    return $this->IDPADRE;
        } 
	

	/**
         * set value for  NOMBRE
         *
         * type : varchar(45) , size:10 , default : , NULL : NO ,primary : 
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
         * type : varchar(45) , size:10 , default : , NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getNOMBRE() {
                    return $this->NOMBRE;
        } 
	

	/**
         * set value for  POSICION
         *
         * type : int(10) unsigned , size:10 , default : 0, NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setPOSICION($posicion) {
                    $this->POSICION = $posicion;
                    return $this;
            }

        /**
         * get value for POSICION 
         *
         * type : int(10) unsigned , size:10 , default : 0, NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getPOSICION() {
                    return $this->POSICION;
        } 
	

	/**
         * set value for  DEPENDIENTE
         *
         * type : binary(1) , size:10 , default : 0, NULL : NO ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setDEPENDIENTE($dependiente) {
                    $this->DEPENDIENTE = $dependiente;
                    return $this;
            }

        /**
         * get value for DEPENDIENTE 
         *
         * type : binary(1) , size:10 , default : 0, NULL : NO ,primary : 
         *
         * @return mixed
         */
        public function &getDEPENDIENTE() {
                    return $this->DEPENDIENTE;
        } 
	

	/**
         * set value for  MODULO
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setMODULO($modulo) {
                    $this->MODULO = $modulo;
                    return $this;
            }

        /**
         * get value for MODULO 
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getMODULO() {
                    return $this->MODULO;
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
         * set value for  FILEMANUAL
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setFILEMANUAL($filemanual) {
                    $this->FILEMANUAL = $filemanual;
                    return $this;
            }

        /**
         * get value for FILEMANUAL 
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getFILEMANUAL() {
                    return $this->FILEMANUAL;
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
                return array(		self::FIELD_IDUSUARIO=>$this->getIDUSUARIO(),
		self::FIELD_IDMODULO=>$this->getIDMODULO(),
		self::FIELD_IDPADRE=>$this->getIDPADRE(),
		self::FIELD_NOMBRE=>$this->getNOMBRE(),
		self::FIELD_POSICION=>$this->getPOSICION(),
		self::FIELD_DEPENDIENTE=>$this->getDEPENDIENTE(),
		self::FIELD_MODULO=>$this->getMODULO(),
		self::FIELD_DESCRIPCION=>$this->getDESCRIPCION(),
		self::FIELD_FILEMANUAL=>$this->getFILEMANUAL());
		}
        
        /**
	 * Assign values from hash where the indexes match the tables field names
	 *
	 * @param array $result
	 */
	
	public function assignByHash($result) {    
                		$this->setIDUSUARIO($result['IDUSUARIO']);
		$this->setIDMODULO($result['IDMODULO']);
		$this->setIDPADRE($result['IDPADRE']);
		$this->setNOMBRE($result['NOMBRE']);
		$this->setPOSICION($result['POSICION']);
		$this->setDEPENDIENTE($result['DEPENDIENTE']);
		$this->setMODULO($result['MODULO']);
		$this->setDESCRIPCION($result['DESCRIPCION']);
		$this->setFILEMANUAL($result['FILEMANUAL']);
		}

}
