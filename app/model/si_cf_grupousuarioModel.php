<?php

namespace Model;

use Lib\APPDbo;

class si_cf_grupousuarioModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;
 
    private $FIELDS_UNIQUE = array("IDGRUPO"=>"",
				"IDUSUARIO"=>"");
    private $FIELDS_NOTNULL = array("IDGRUPO"=>"",
				"IDUSUARIO"=>"");
 
    private $IDGRUPO;
	private $IDUSUARIO;
	private $NOMBRE;
	private $USUARIOTRCR;
	private $FECHATRCR;
	private $USUARIOTRED;
	private $FECHATRED;

    private static $FIELD_NAMES=array(self::FIELD_IDGRUPO=>'IDGRUPO',
				self::FIELD_IDUSUARIO=>'IDUSUARIO',
				self::FIELD_NOMBRE=>'NOMBRE',
				self::FIELD_USUARIOTRCR=>'USUARIOTRCR',
				self::FIELD_FECHATRCR=>'FECHATRCR',
				self::FIELD_USUARIOTRED=>'USUARIOTRED',
				self::FIELD_FECHATRED=>'FECHATRED');

	const FIELD_IDGRUPO = 70563778;
	const FIELD_IDUSUARIO = 52766868;
	const FIELD_NOMBRE = 32116216;
	const FIELD_USUARIOTRCR = 41660485;
	const FIELD_FECHATRCR = 72874855;
	const FIELD_USUARIOTRED = 86606888;
	const FIELD_FECHATRED = 17055914;
      
    public function __construct()
    {
        $this->db = new APPDbo();
        $this->entityName = "SI_CF_GRUPOUSUARIO";
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
            
        return $this->db->CREATE($this->entityName,$fields,TRUE); 
    }

    public function getGrupo($IDGrupo){

        $this->db->query("SELECT GR.IDGRUPO,GR.IDUSUARIO,USUARIO.USUARIO,
			    CONCAT (USUARIO.PRIMERAPELLIDO,' ',USUARIO.SEGUNDOAPELLIDO,' ',USUARIO.PRIMERNOMBRE,' ',USUARIO.SEGUNDONOMBRE) AS NOMBRE
			    FROM SI_CF_GRUPOUSUARIO GR,USUARIO
			    WHERE GR.IDUSUARIO = USUARIO.IDUSUARIO
			    AND GR.IDGRUPO = '$IDGrupo' 
			    ORDER BY NOMBRE ");

		
		
        $arrayResp =  $this->db->fetch( "array" );
        return $arrayResp;
    }
     
        function getGruposUsr($idUsuario)
    {
   
    $arr = array();
    
       $this->db->query("SELECT IDGRUPO,NOMBRE,DESCRIPCION FROM SI_CF_GRUPO ORDER BY NOMBRE");
       
       $arrayGrupos =  $this->db->fetch( "array" );
    
   	foreach($arrayGrupos AS $grupo){
	    
	    $this->db->query("SELECT IDGRUPO FROM SI_CF_GRUPOUSUARIO WHERE IDUSUARIO = '$idUsuario' AND IDGRUPO = ".$grupo["IDGRUPO"]);
	       
	    $arrayGrupoUsuario =  $this->db->fetch( "array" );
    
	    $checked = false;
	
	    if(count($arrayGrupoUsuario) != 0)
		$checked = true;
	    
	    $arr[] = array(
		"IDGRUPO" => $grupo["IDGRUPO"],
		"NOMBRE" => $grupo["NOMBRE"],
		"DESCRIPCION" => $grupo["DESCRIPCION"],
		"checked" => $checked
	    );
	  
       }
       
	return $arr;
    }

    function setGruposUsr($idUsuario,$arrayGrupos)
    {
 
	$response = array();
	$this->db->query("DELETE FROM SI_CF_GRUPOUSUARIO WHERE IDUSUARIO = $idUsuario ");

	$response["msg"] = "Grupos de usuario Eliminados Correctamente";
	
   	foreach($arrayGrupos AS $idGrupo){
	 
	    $this->setIDGRUPO($idGrupo);
	    $this->setIDUSUARIO($idUsuario);
	    $this->setNOMBRE('');
          
	    $id = $this->insertRow();
	  
	      if($id){
		//$response["success"] = true;
		$response["msg"] = "Grupos de usuario actualizados Correctamente";
	    }  
       }
       
       return $response;
    }
    
    public function del($IDGrupo, $IDUsuario){

        $this->db->query("DELETE FROM SI_CF_GRUPOUSUARIO WHERE IDGRUPO = '$IDGrupo' AND IDUSUARIO = '$IDUsuario' ");

        return '{"success":true}';
    }

    public function add($IDGrupo, $IDUsuario, $Nombre){

        $this->db->query("INSERT IGNORE INTO SI_CF_GRUPOUSUARIO (IDGRUPO,IDUSUARIO,NOMBRE,USUARIOTRCR,FECHATRCR)
                      VALUES ('$IDGrupo','$IDUsuario','$Nombre','$this->getusuarioTrCr()','$this->getfechaTrCr()'");

        return '{"success":true}';
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
	    $mess = "";
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
         * set value for  NOMBRE
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
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
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getNOMBRE() {
                    return $this->NOMBRE;
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
		self::FIELD_IDUSUARIO=>$this->getIDUSUARIO(),
		self::FIELD_NOMBRE=>$this->getNOMBRE(),
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
		$this->setIDUSUARIO($result['IDUSUARIO']);
		$this->setNOMBRE($result['NOMBRE']);
		$this->setUSUARIOTRCR($result['USUARIOTRCR']);
		$this->setFECHATRCR($result['FECHATRCR']);
		$this->setUSUARIOTRED($result['USUARIOTRED']);
		$this->setFECHATRED($result['FECHATRED']);
		}

}
