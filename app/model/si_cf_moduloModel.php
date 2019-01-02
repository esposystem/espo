<?php

namespace Model;

use Lib\APPDbo;

class si_cf_moduloModel
{
    protected $db;
    
    private $totalRows;
    
    private $entityName;
 
    private $FIELDS_UNIQUE = array();
    private $FIELDS_NOTNULL = array("IDPADRE"=>"",
				"NOMBRE"=>"",
				"POSICION"=>"",
				"DEPENDIENTE"=>"");
 
    private $IDMODULO;
	private $IDPADRE;
	private $NOMBRE;
	private $POSICION;
	private $DEPENDIENTE;
	private $MODULO;
	private $COMPONENTE;
	private $DESCRIPCION;
	private $FILEMANUAL;
	private $ICONO;

    private static $FIELD_NAMES=array(self::FIELD_IDMODULO=>'IDMODULO',
				self::FIELD_IDPADRE=>'IDPADRE',
				self::FIELD_NOMBRE=>'NOMBRE',
				self::FIELD_POSICION=>'POSICION',
				self::FIELD_DEPENDIENTE=>'DEPENDIENTE',
				self::FIELD_MODULO=>'MODULO',
				self::FIELD_COMPONENTE=>'COMPONENTE',
				self::FIELD_DESCRIPCION=>'DESCRIPCION',
				self::FIELD_FILEMANUAL=>'FILEMANUAL',
				self::FIELD_ICONO=>'ICONO');

	const FIELD_IDMODULO = 43964575;
	const FIELD_IDPADRE = 51196971;
	const FIELD_NOMBRE = 67854089;
	const FIELD_POSICION = 26866880;
	const FIELD_DEPENDIENTE = 3552227;
	const FIELD_MODULO = 55966998;
	const FIELD_COMPONENTE = 1234324;
	const FIELD_DESCRIPCION = 68622916;
	const FIELD_FILEMANUAL = 58443540;
	const FIELD_ICONO = 3453535;
      
    public function __construct()
    {
        $this->db = new APPDbo();
        $this->entityName = "SI_CF_MODULO";
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
	
	$parentId = $this->getIDPADRE();
	$Dependiente = $this->getDEPENDIENTE();
	
	$this->db->query("INSERT INTO SI_CF_MODULO (NOMBRE,POSICION,IDPADRE,DEPENDIENTE)
					SELECT 'nuevo nodo', isnull(max(POSICION)+1, 1), $parentId, $Dependiente
					FROM SI_CF_MODULO
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
           
        $this->db->UPDATE($this->entityName,$fields,array( $this->getPrimaryKey() =>$id));
 
    
        return $this->db->AFFECTED_ROWS;
        
    }
    
    public function updateNombre($idModulo,$strNombre){
            
        
	$this->db->query("UPDATE SI_CF_MODULO
		            SET NOMBRE = '$strNombre'
			    WHERE IDMODULO = '$idModulo' ");
	
        return $this->db->AFFECTED_ROWS;
        
    }
      
      
    public function deleteRow($id){
            
	$response["success"] = true;
	
	$array_s = $this->getTreeChild($id,0,0);
		
	$preserved = array_reverse($array_s);

	foreach($preserved AS $IDModDel){
					
		$this->db->query("SELECT P.NOMBRE AS PERFIL,P.IDPERFIL
				    FROM SI_CF_PERFIL P, SI_CF_PERFILOPER PO
				    WHERE P.IDPERFIL = PO.IDPERFIL
					AND PO.IDMODULO = '$IDModDel'
					GROUP BY P.NOMBRE, P.IDPERFIL");
		
		$arrayPerfil =  $this->db->fetch( "array" );
		    
		    if(count($arrayPerfil) != 0){
	
			foreach($arrayPerfil AS $row)
				$msgPerfil .= $row['PERFIL']." / ";
					
			$msg = "Modulo tiene perfiles asociados : ".$msgPerfil;
				
			$response["msg"] = $msg;
			$response["success"] = false;
				
			return $response;
			
		    }else{
			
			$this->db->query("DELETE FROM SI_CF_MODULO WHERE IDModulo = '$IDModDel' ");
		
			$this->db->query("DELETE FROM SI_CF_MODULO WHERE IDPadre = '$IDModDel' ");
			
			$this->db->query("DELETE FROM SI_CF_PERFILOPER WHERE IDMODULO = '$IDModDel' ");		
		    }
			
	}
    
    return $response;

      //  $this->db->DELETE($this->entityName,array( $this->getPrimaryKey() =>$id));
            
      //  return $this->db->AFFECTED_ROWS;
        
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

    function getTree($rootid,$oper,$idperfil)
    {
	$arr = array();
     
	
       $this->db->query("SELECT * FROM SI_CF_MODULO WHERE IDPADRE='$rootid' ORDER BY POSICION");
       
       $arrayModulos =  $this->db->fetch( "array" );
	
	foreach($arrayModulos AS $row){
	    	
	$attributes = '';
	
		$array_op = array();
		$array_nodeop = array();
		$operacion = '';
		$node = array();

		
		if($oper){	
				  
				$this->db->query("SELECT * FROM SI_CF_MODULOOPER WHERE IDMODULO = '$row[IDMODULO]' ");
       
				$arrayModOper =  $this->db->fetch( "array" );
				 
				 foreach($arrayModOper AS $rowModOper){
				     
					$array_op[] = $rowModOper['OPERACION'];

					$array_nodeop['id'] = $rowModOper['IDMODULO']."_".$rowModOper['IDOPERACION'];
					$array_nodeop['text'] = "* ".$rowModOper['OPERACION'];
					$array_nodeop['isopr'] = 1;
					$array_nodeop['checked'] = false;
					if(!empty($idperfil)){
										
						$this->db->query("SELECT IDOPERACION FROM SI_CF_PERFILOPER
										WHERE IDPERFIL = '$idperfil'
										AND IDMODULO = '$rowModOper[IDMODULO]'
										AND IDOPERACION = '$rowModOper[IDOPERACION]' ");
						
						$r_perfil =  $this->db->fetch( "array" );
						
						if(count($r_perfil) != 0){
							
							$array_nodeop['checked'] = true;
						}
					}
						
					$node[] = $array_nodeop;
				
				}
				
				if(count($array_op) > 0)
					 $operacion = implode(",", $array_op);
				
		}
		
		if(count($array_op) > 0)
					$nodos = $node;//implode(",", $array_op);
		else
			$nodos = $this->getTree($row["IDMODULO"],$oper,$idperfil);
			
	$arr[] = array(
	   "id" => $row["IDMODULO"],
	  "text" => $row["NOMBRE"],
	  "Modulo"=> $row["MODULO"],
	  "COMPONENTE"=> $row["COMPONENTE"],
	  "attributes"=> $attributes,
	  "operacion" => $operacion,
	  "children" => $nodos
	);
	
   }
   return $arr;
}

  
    public function getModulos($IDModulo,&$array_modulos){

	$this->db->query("SELECT * FROM SI_CF_MODULO WHERE IDMODULO = '$IDModulo' ORDER BY POSICION");
	 
	$arrayData =  $this->db->fetch( "array" );
	$r_padre = $arrayData[0];
	 
	if( $r_padre['IDPADRE'] != 0 )
	{
	   // $array_modulos[ $r_padre['IDMODULO'] ] = $r_padre['NOMBRE'];
	    $array_modulos[ $r_padre['IDMODULO'] ] = $r_padre;
	
	
	    $this->getModulos( $r_padre['IDPADRE'],$array_modulos );
	}
	else{
		$this->db->query("SELECT * FROM SI_CF_MODULO WHERE IDMODULO = '$r_padre[IDMODULO]' ORDER BY POSICION ");
	 
		$r_padre =  $this->db->fetch( "array" );
	
		//$array_modulos[ $r_padre[0]["IDMODULO"] ] = $r_padre[0]['NOMBRE'];
		$array_modulos[ $r_padre[0]["IDMODULO"] ] = $r_padre[0];
	}

    }//end function

    public function listId()
    {
	$this->db->query("SELECT IDMODULO,COMPONENTE FROM SI_CF_MODULO ");
	 
	$arrayData =  $this->db->fetch( "array" );
	
	
	foreach($arrayData AS $r_modulo)
	    $response[$r_modulo['IDMODULO']] = $r_modulo['COMPONENTE'];
  
        return $response;
    }
    
    public function dndNodo($id,$targetId,$targetPos,$parentId,$point){
	
		//$this->model->dndNodo($id );
		
		if($point == "top"){
			
			$parentId = $this->getIDPADRE(); // getParent_node($_POST['targetId']);
			
			$this->getRow($targetId);
		    
			$this->setIDPADRE($parentId);
			
			//$this->saveRow();
			
			$this->db->query("UPDATE SI_CF_MODULO
					    SET IDPADRE = '$parentId'
					    WHERE IDMODULO = '$id' ");
			
				
			$this->db->query("UPDATE SI_CF_MODULO
					SET POSICION = POSICION + 1
					WHERE POSICION >= $targetPos AND IDPADRE = '$parentId' ");
			
			//$qry = setPos_node($_POST['id'],$targetPos);
			
			$this->db->query("UPDATE SI_CF_MODULO SET POSICION = '$targetPos' WHERE IDMODULO = '$id' ");
			
		}
		
		if($point == "bottom"){
			
			$this->db->query("UPDATE SI_CF_MODULO
					    SET Posicion = Posicion + 1
					    WHERE Posicion > $targetPos AND IDPadre = '$parentId' ");
			
			//$qry = setPos_node($_POST['id'],$targetPos + 1);
			
			$this->db->query("UPDATE SI_CF_MODULO SET POSICION = ($targetPos + 1),IDPADRE = '$parentId' WHERE IDMODULO = '$id' ");
			
			//$this->db->query("UPDATE  SI_CF_MODULO SET   WHERE IDModulo = '$id' ");
	
				
		}
		
		if($_POST['point'] == "append"){
		
		    $maxPos_node = $this->getMaxPos_node($id);
		    
		    //	setPos_node($_POST['id'],$maxPos_node($_POST['parentId']));
			
			$this->db->query("UPDATE SI_CF_MODULO SET POSICION = '$maxPos_node', IDPADRE = '$parentId' WHERE IDMODULO = '$id' ");
			
		}

    }
    
    
    function getMaxPos_node($id){
	
       $this->db->query("SELECT MAX(POSICION) AS POSICION FROM SI_CF_MODULO WHERE IDPADRE = '$id' ");
       
       $arrayPos =  $this->db->fetch( "array" );
       
	return $arrayPos['POSICION'];
    }

  //  function setPos_node($id,$pos){
//	$qry = "UPDATE SI_CF_MODULO SET Posicion = $pos WHERE IDModulo = $id ";
//	$rs = db_query("UPDATE SI_CF_MODULO SET Posicion = '$pos' WHERE IDModulo = '$id' ");
//	return ("UPDATE SI_CF_MODULO SET Posicion = $pos WHERE IDModulo = $id ");
  //  }

    function getTreeNodo($id = '',$oper = 0){
	
	$id = !empty($id) ? intval($id) : 0;

		$result = array();
		
		$this->db->query("SELECT * FROM SI_CF_MODULO WHERE IDPADRE = '$id' ORDER BY POSICION ");
		
		//while($row = db_fetch_array($rs)){
		
		 $arrayModulos =  $this->db->fetch( "array" );
		 
		 $num_nodes = count($arrayModulos);
	
	    foreach($arrayModulos AS $row){
	    	
			$node = array();
			$node['id'] = $row['IDMODULO'];
			$node['text'] = $row['NOMBRE'];
			$node['Modulo'] = $row['MODULO'];
			$node['COMPONENTE'] = $row["COMPONENTE"];
			$node['FILEMANUAL']= $row["FILEMANUAL"];
		       $node['DESCRIPCION'] = $row["DESCRIPCION"];
			$node['ICONO'] = $row["ICONO"];
		//if(!empty($row[Modulo]))
			$node['checked'] = true;
			
		if($this->has_child($row['IDMODULO']))	
			$node['state'] = 'closed'; //$row['Dependiente'] ?  'open' : 'closed' ;
		//else
		//	$node['stateSTR'] = has_child($id); 
			if(!empty($row['MODULO']))
				//$node['attributes'] = array("url"=>"modulo_fenix.php?mod=".$row['MODULO']);
			    $node['attributes'] = array("url"=>$row['MODULO'],"DESCRIPCION"=>$row['DESCRIPCION'],"FILEMANUAL"=>$row['FILEMANUAL']);
		
			if($oper){
				
				$this->db->query("SELECT * FROM SI_CF_MODULOOPER WHERE IDMODULO = '$row[IDMODULO]' ");
			
				$r_operaciones =  $this->db->fetch( "array" );
				 
				$array_op = array();
				
				foreach($r_operaciones AS $r)
					$array_op[] = $r['OPERACION'];
					
				if(count($array_op) > 0)
					$node['operacion'] = implode(",", $array_op);
				
			}
			
			array_push($result,$node);
		}
		//print_r($result);
		if($num_nodes > 0)
			return $result;
		else
			return $node;
	
    }

    function has_child($id){
	
	$this->db->query("SELECT count(*) AS NumNodos FROM SI_CF_MODULO WHERE IDPADRE = '$id' ");
	$row =  $this->db->fetch( "array" );
	
	return ($row[0]['NumNodos'] > 0) ? true : false;
    }
    
    public function updateOper($idModulo,$strOper){
	
		//$idModulo =   ;//$this->getIDMODULO();
		
		$this->db->query("DELETE FROM  SI_CF_MODULOOPER WHERE IDMODULO = ".$idModulo);
			
			if(isset($strOper)){
				
				$this->db->query("DELETE FROM SI_CF_MODULOOPER  WHERE IDMODULO = ".$idModulo);
	
				$array_op = explode(",",$strOper);
				
				$cont = 1;
				foreach($array_op AS $operacion){
					
					if(!empty($operacion))	
						$this->db->query("INSERT INTO SI_CF_MODULOOPER (IDMODULO,IDOPERACION,OPERACION)
								VALUES ('$idModulo',$cont,'$operacion') ");
	
					$cont ++;
				}
			}
		

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
         * set value for  COMPONENTE
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
    
	public function &setCOMPONENTE($componente) {
                    $this->COMPONENTE = $componente;
                    return $this;
            }

        /**
         * get value for COMPONENTE 
         *
         * type : varchar(120) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getCOMPONENTE() {
                    return $this->COMPONENTE;
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
         * set value for  ICONO
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @param mixed 
         * @return Model
         */
    
        public function &setICONO($icono) {
                    $this->ICONO = $icono;
                    return $this;
            }

        /**
         * get value for ICONO 
         *
         * type : varchar(60) , size:10 , default : , NULL : YES ,primary : 
         *
         * @return mixed
         */
        public function &getICONO() {
                    return $this->ICONO;
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
			self::FIELD_DEPENDIENTE=>$this->getDEPENDIENTE(),
			self::FIELD_MODULO=>$this->getMODULO(),
			self::FIELD_COMPONENTE=>$this->getCOMPONENTE(),
			self::FIELD_DESCRIPCION=>$this->getDESCRIPCION(),
			self::FIELD_FILEMANUAL=>$this->getFILEMANUAL(),
			self::FIELD_ICONO=>$this->getICONO());
		}
        
        /**
	 * Assign values from hash where the indexes match the tables field names
	 *
	 * @param array $result
	 */
	
	public function assignByHash($result) {
		//$this->setIDMODULO($result['IDMODULO']);
                $this->setIDPADRE($result['IDPADRE']);
		$this->setNOMBRE($result['NOMBRE']);
		$this->setPOSICION($result['POSICION']);
		$this->setDEPENDIENTE($result['DEPENDIENTE']);
		$this->setMODULO($result['MODULO']);
	    	$this->setCOMPONENTE($result['COMPONENTE']);
		$this->setDESCRIPCION($result['DESCRIPCION']);
		$this->setFILEMANUAL($result['FILEMANUAL']);
		$this->setICONO($result['ICONO']);
		}

}
