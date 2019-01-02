<?php

namespace Model;

use Lib\APPDbo;

class si_cf_perfilModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;
 
    private $FIELDS_UNIQUE = array("NOMBRE"=>"Nombre");
    private $FIELDS_NOTNULL = array("IDPADRE"=>"",
				"NOMBRE"=>"Nombre",
				"POSICION"=>"",
				"DEPENDIENTE"=>"");
 
    private $IDPERFIL;
	private $IDPADRE;
	private $NOMBRE;
	private $POSICION;
	private $DEPENDIENTE;

    private static $FIELD_NAMES=array(self::FIELD_IDPERFIL=>'IDPERFIL',
				self::FIELD_IDPADRE=>'IDPADRE',
				self::FIELD_NOMBRE=>'NOMBRE',
				self::FIELD_POSICION=>'POSICION',
				self::FIELD_DEPENDIENTE=>'DEPENDIENTE');

	const FIELD_IDPERFIL = 64576766;
	const FIELD_IDPADRE = 20261271;
	const FIELD_NOMBRE = 97434150;
	const FIELD_POSICION = 53169974;
	const FIELD_DEPENDIENTE = 99962615;
      
    public function __construct()
    {
        $this->db = new APPDbo();
        $this->entityName = "SI_CF_PERFIL";
	$this->primaryKey = "IDPERFIL";
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
            
	/*$fields = $this->toHash();
            
        return $this->db->CREATE($this->entityName,$fields); */
        $fields = $this->toHash();
        
        $parentId = $this->getIDPADRE();
        $Dependiente = $this->getDEPENDIENTE();
        
        // INSERT INTO SI_CF_PERFIL (IDPADRE , NOMBRE , POSICION , DEPENDIENTE  , FECHATRCR , USUARIOTRCR) VALUES
        
        $this->db->query("INSERT INTO SI_CF_PERFIL (NOMBRE,POSICION,IDPADRE,DEPENDIENTE)
                        SELECT 'nuevo nodo', isnull(max(POSICION)+1, 1), $parentId, $Dependiente
                        FROM SI_CF_PERFIL
                        WHERE IDPADRE = '$parentId'
                ");
        
        return $this->db->lastInsertId();
    }
        
    public function getRow($id){
            
        $rowData = $this->db->READ($this->entityName,array( $this->getPrimaryKey()  =>$id));
         
	 
        $this->assignByHash($rowData[0]); 
            
        return $rowData;
    }
        
    public function saveRow($id){
            
        $fields = $this->toHash();
        
        $this->db->UPDATE($this->entityName,$fields,array( $this->getPrimaryKey() =>$id),"",TRUE,FALSE);
     
        return $this->db->AFFECTED_ROWS;
        
    }
        
    public function deleteRow($id){
            
        $this->db->DELETE($this->entityName,array( $this->getPrimaryKey() =>$id));
            
        return $this->db->AFFECTED_ROWS;
        
    }

    function getTreeChild($rootid,$oper,$idperfil)
    {
       $arr = array();
    
       $arr[]  = $rootid;
       
    $this->db->query("SELECT IDMODULO FROM SI_CF_MODULO WHERE IDPADRE = '$rootid' ORDER BY POSICION ");
       
    $arrayMod =  $this->db->fetch( "array" );
    
    foreach($arrayMod AS $row){
                    
     //  while ($row = db_fetch_array($result)) {
            
        $arr[]  = $row["IDMODULO"];
        
        $nodos = $this->getTreeChild($row["IDMODULO"],$oper,$idperfil);
        
        if(count($nodos > 0))
            $arr = array_merge($arr,$nodos);
        
       }
       
       return array_unique($arr);
    
    }

    function getTree($rootid,$idgrupo)
    {
   
	$arr = array();
    
       $this->db->query("SELECT * FROM SI_CF_PERFIL WHERE IDPADRE='$rootid' ORDER BY POSICION");
       
       $arrayPerfiles =  $this->db->fetch( "array" );
    
   	foreach($arrayPerfiles AS $row){
	
	  //  $arr[]  = $rootid;
	    
	    $this->db->query("SELECT IDGRUPO FROM SI_CF_GRUPOPERFIL WHERE IDGRUPO = '$idgrupo' AND IDPERFIL = '$row[IDPERFIL]'");
	       
	    $arrayMod =  $this->db->fetch( "array" );
    
	    $checked = false;
	
	    if(count($arrayMod) != 0)
		$checked = true;
	
	    $nodos = $this->getTree($row["IDPERFIL"],$idgrupo);
		
	    
	    $arr[] = array(
		"id" => $row["IDPERFIL"],
		"text" => $row["NOMBRE"],
		"checked" => $checked,
		"children" => $nodos
	    );
	  
       }
       
   return $arr;
}

    public function updateOper($strOper){
    
        $idPerfil = $this->getIDPERFIL();
        //print_r($strOper);    
    
                $this->db->query("DELETE FROM  SI_CF_PERFILOPER WHERE IDPERFIL = ".$idPerfil);
            
            if(isset($strOper)){
                
                //$this->db->query("DELETE FROM SI_CF_PERFILOPER  WHERE IDPERFIL = ".$idPerfil);
    
                $array_op = explode(",",$strOper);
                
                $cont = 1;
                foreach($array_op AS $operacion){
                    
		    $mod_oper = explode("_",$operacion);
		    
		  //  list($IDM,$IDOP) = explode("_",$operacion);
		    
                    if(!empty($mod_oper[1])){
                        $this->db->query("INSERT INTO SI_CF_PERFILOPER (IDPERFIL,IDMODULO, IDOPERACION)
                                VALUES ('$idPerfil',".$mod_oper[0].",'".$mod_oper[1]."') ");
                    } 

                        
    
                    $cont ++;
                }
            }
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
         * set value for  IDPERFIL
         *
         * type : int(10) unsigned , size:10 , default : , NULL : NO ,primary : PRI
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
         * type : int(10) unsigned , size:10 , default : , NULL : NO ,primary : PRI
         *
         * @return mixed
         */
        public function &getIDPERFIL() {
                    return $this->IDPERFIL;
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
		
		self::FIELD_IDPADRE=>$this->getIDPADRE(),
		self::FIELD_NOMBRE=>$this->getNOMBRE(),
		self::FIELD_POSICION=>$this->getPOSICION(),
		self::FIELD_DEPENDIENTE=>$this->getDEPENDIENTE());
		}
        
        /**
	 * Assign values from hash where the indexes match the tables field names
	 *
	 * @param array $result
	 */
	
	public function assignByHash($result) {
	    
                $this->setIDPADRE($result['IDPADRE']);
		$this->setNOMBRE($result['NOMBRE']);
		$this->setPOSICION($result['POSICION']);
		$this->setDEPENDIENTE($result['DEPENDIENTE']);
		}

}
