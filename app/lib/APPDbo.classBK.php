<?php
/**
 * @author Fabio Sanchez
 * @copyright since 2008
 * @company 
 */

/**
 * SQLSRV basic class
 * @package Databases
 */
namespace Lib;

//use Lib\APPDbo;
  
class APPDbo 
{
	/**
	 * @param RESOURCE Database resultset
	 */
	private $RESULTSET;

	/**
	 * @param RESOURCE SQLSRV connection resource
	 */
	private $CONNECTION;

	/**
	 * @param integer Number of rows affected by last {@link function query} attempt.
	 */
	public $ROWS = 0;

	public $AFFECTED_ROWS = 0;
	/**
	 * @param array List of columns retrived on the last {@link query} attempt.
	 */
	public $FIELDS = array();

	/**
	 * @param integer Number columns retrived on the last {@link query} attempt.
	 */
	public $FIELDS_COUNTER = 0;

	/**
	 * @param object Metadata of each columns ({@link FIELDS}) retrived.
	 */
	public $META_DATA;

	/**
	 * @param array Association of columns and values of one row.
	 * @see sqlsrv::next_record()
	 */
	public $row_data;
	
	/**
	 * Allows to update meta or not. Boolean
	 */
	private $UPDATE_META = true;
	
	public $SQL_STRING;
	/*
	* @param   integer  $limit   The maximum affected rows to set.
	 * @param   integer  $offset  The affected row offset to set.
	*/
	public $limit = 0;
	
	public $offset = 0;
	
	
	protected $ColumnInfoCache = array();
	  
	private $DBNAME = '';
	private $DBHOST = '';
	private $DBPASS = '';
	private $DBUSER = '';
	
	/**
	 * Constructor
	 * <br>Connects to the database with the assigned server details.
	 * <br>Reuses the connection resources if possible.
	 */
	public function __construct()
	{
		
		$config = Config::singleton();
		
		$this->DBNAME = $config->get('DBNAME');
		$this->DBHOST = $config->get('DBHOST');
		$this->DBPASS = $config->get('DBPASS');
		$this->DBUSER = $config->get('DBUSER');
		
		if(!defined('SQLSRV_CONNECTION'))
		{
		
			if(!function_exists('sqlsrv_connect'))
			{
				die('Install SQLSRV library first.');
			}
			
			if(
				!$this->DBNAME ||
				!$this->DBHOST ||
				!$this->DBPASS ||
				!$this->DBUSER
			)
			{
				die('SQLSRV parametros de conexion no estan definidos correctamente');
			}
			$paramConn = array(
				'UID' => $this->DBUSER,
				'PWD' => $this->DBPASS,
				'Database' => $this->DBNAME,
				'ReturnDatesAsStrings'=> true,
				'CharacterSet'=>'UTF-8');
				
			if(!$this->CONNECTION = sqlsrv_connect($this->DBHOST, $paramConn)){
				$errosStr = sqlsrv_errors();
				echo $errosStr[0]['message'];
				die();
				
			}
				//die( print_r( sqlsrv_errors(), true));
			
			//or die(sqlsrv_errors());
			
			//print_r(sqlsrv_errors());
			//debug_print_backtrace();
			define('SQLSRV_CONNECTION', $this->CONNECTION);
			
			//print_r($this);
		}
		else
		{
			# Reuse the connection
			$this->CONNECTION = SQLSRV_CONNECTION;
		}
		
	} # __construct()

	/*function &get()
	{
		if( !self::$CONNECTION )
		{
			echo "NEW CON";
			self::$CONNECTION = & new SIMDB();
			return self::$CONNECTION;
		}
		else{
			echo "CONN EXIST";
			return self::$CONNECTION;
		}
	}*/
	
	/**
	 * Ejecuta un query
	 * $sql string sentencia SQL
	 * @param string array valores a ser pasados a la sentencia SQL  --- INSERT INTO Table_1 (id, data) VALUES (?, ?) --- $params = array(1, "some data");
	 * $limit numero de registros a retornar
	 * $offset a partir de que registro del $this->RESULTSET
	 * @return boolean Success / Failure  status 
	 */
	public function query($sql = '',$params = array(),$Scrollable=FALSE)
	{
		$success = false;
		
		// print_r(get_declared_classes());
		
		
		if($sql == '')
		{
			echo 'Query is empty. Cannot do SQL action';
			return ($success);
		}

		    
		if($Scrollable)
			$opc_conn = array("Scrollable"=>"buffered");
		else
			$opc_conn = array("Scrollable"=>SQLSRV_CURSOR_KEYSET);
			
			
		# Temporarily treat the bad sql
		#$sql = preg_replace('/[\r|\n]+/is', ' ', $sql);
		$sql = str_replace('\\r', ' ', $sql);
		$sql = str_replace('\\n', ' ', $sql);

		
		
		if  ($this->limit > 0 && $this->offset > 0)
		{
			 $this->SQL_STRING = $this->limit($sql);
		}else{
			//$query = 
			$this->SQL_STRING = str_replace('FROM_SUBQUERY', 'FROM', $sql);
			
		}
		
		
		$this->__RESET_VARIABLES();
		
		//echo "la conex".$this->CONNECTION;
		//echo "elq eury ".$this->SQL_STRING;
		
		if($this->RESULTSET = sqlsrv_query($this->CONNECTION, $this->SQL_STRING,$params, $opc_conn))
		{
			$this->lastNumRows();
			$this->affected_rows();
			$success = true;
			
		}
		else
		{
			echo "ERROR QUERY : ".$this->SQL_STRING;
			print_r(sqlsrv_errors());
			debug_print_backtrace();
			die($sql);
			$success = false;
		}

		//print_r($this);
		
		return ($success);
	} # query()
	
	
	public function insertFicha($sql = '')
	{
		
		$this->query($sql);
		
			
	}
	/**
	 * Ejecuta un query
	 * $sql string sentencia SQL
	 * @param string array valores a ser pasados a la sentencia SQL  --- INSERT INTO Table_1 (id, data) VALUES (?, ?) --- $params = array(1, "some data");
	 * $limit numero de registros a retornar
	 * $offset a partir de que registro del $this->RESULTSET
	 * @return boolean Success / Failure  status 
	 */
	public function insertLOG($sql = '',$params = array(),$operacion = "",$IDModulo,$Tabla)
	{
		$success = false;
		
		$config = \Lib\Config::singleton();
		
		$userData = $config->get('SESSION_DATA');
	
		if($sql == '')
		{
			stopper::message('Query is empty. Cannot do SQL action.', false);
			return ($success);
		}

		$opc_conn = array("Scrollable"=>SQLSRV_CURSOR_KEYSET);
			
			
		# Temporarily treat the bad sql
		#$sql = preg_replace('/[\r|\n]+/is', ' ', $sql);
		$sql = str_replace('\\r', ' ', $sql);
		$sql = str_replace('\\n', ' ', $sql);
		$sql = str_replace("'", ' ', $sql);
	
		
		$transaccion = $sql.implode(" | ",$params);
		
		$sqlLog = "INSERT INTO SI_LOG (IDModulo,IDUsuario,Fecha,Tabla,Transaccion,Operacion,DireccionIP)
				VALUES('$IDModulo','".$userData['IDUSUARIO']."',getdate(),'$Tabla',
					'$transaccion','$operacion','".APPNet::IP()."')";
		
		
		if(sqlsrv_query($this->CONNECTION, $sqlLog))
		{
		//	echo " last ".$this->lastNumRows();
		//	echo " affed ".$this->affected_rows();
			$success = true;
			
		}
		else
		{
			echo "ERROR QUERY : ".$this->SQL_STRING;
			print_r(sqlsrv_errors());
			debug_print_backtrace();
			die($sql);
			$success = false;
		}

		//print_r($this);
		
		return ($success);
	} # query()
	
	public function setLimitsResult($page = 0,$rows = 0){
		
		$config = Config::singleton();
		
		$page = isset( $page) ? intval($page) : 1;
		$numrows = isset( $rows) ? intval( $rows) : $config->get('GRID_NUMROWS');
		//echo "getros";
		$limit = ($page == 1 ) ? 1 :  ($page-1)*$numrows + 1;
		
		$offset = ($page)*$numrows;

		
		$this->limit = $limit;
		$this->offset  = $offset;
		
	//	$this->offset  = $offset;
	}
      
      public function setMaxResult($offset){
		
		//$this->limit = $limit;
		
	}
	
	/**
	 * Method to wrap an SQL statement to provide a LIMIT and OFFSET behavior for scrolling through a result set.
	 *
	 * @param   string   $query   The SQL statement to process.
	 * @param   integer  $limit   The maximum affected rows to set.
	 * @param   integer  $offset  The affected row offset to set.
	 *
	 * @return  string   The processed SQL statement.
	 *
	 */
	
	protected function limit($query)
	{
		if ($this->limit == 0 && $this->offset == 0)
		{
			$query = str_replace('FROM_SUBQUERY', 'FROM', $query);
			
			return $query;
		}

		$orderBy = stristr($query, 'ORDER BY');

		if (is_null($orderBy) || empty($orderBy))
		{
			$orderBy = 'ORDER BY (select 0)';
		}

		$query = str_ireplace($orderBy, '', $query);

		$rowNumberText = ', ROW_NUMBER() OVER (' . $orderBy . ') AS RowNumber FROM ';

		/*******/
		//echo $numfrom = substr_count($query,'FROM');
		
		//if ($numfrom == 1)
			$query = preg_replace('/\sFROM\s/i', $rowNumberText, $query, 1);
		//elseif($numfrom == 2)
		//	$query = preg_replace('/\s\sFROM\s\s/i', $rowNumberText, $query, 1);
		
		$query = str_replace('FROM_SUBQUERY', 'FROM', $query);
		
		/********/
		//$query = preg_replace('/\sFROM\s/i', $rowNumberText, $query, 1);
		$query = 'SELECT * FROM (' . $query . ') _myResults WHERE RowNumber BETWEEN ' . $this->limit . ' AND ' . $this->offset ;

		return $query;
	}

	
	public function lastNumRows() {
		
		$this->ROWS = sqlsrv_num_rows($this->RESULTSET);
		 
	}
	
	public function fetch_object() {
		return  sqlsrv_fetch_object($this->RESULTSET);
	}
	
	public function fetch_array($fetchType = SQLSRV_FETCH_BOTH) {
	
		return  sqlsrv_fetch_array($this->RESULTSET,$fetchType);
	    
	}
  
	/**
	 * Get a first record of a query
	 * @param $sql string; if missing, loops through itself.
	 * @return array
	 */
	public function row($sql = '#')
	{
		$row = array();
		if(!empty($sql) && $sql != '#')
		{
			/**
			 * Do a fresh query for a start over.
			 */
			$this->query($sql);
		}

		/**
		 * Once, loop through the result set and send the first data out.
		 * Assumes that the query was just performed.
		 */
		if($this->next_record())
		{
			$row = $this->row_data;
		}

		return ($row);
	} # row()

	/**
	 * Seek one record, if available.
	 * <br>Sets an association of the database columns and values selected.
	 * @return boolean Was seeking to next record possible?
	 */
	public function next_record()
	{
		
		$success = true;
		if(is_bool($this->RESULTSET))
		{
			$this->row_data = array();

			return false;
		} # Resultset should be a resource.
		if(!$this->RESULTSET)
		{
			$this->row_data = array();

			return false;
		}
		$this->row_data = array();
		
		if(sqlsrv_has_rows($this->RESULTSET))
		{
		
			$row_data = $this->fetch_array(SQLSRV_FETCH_ASSOC) or $success = false;
			if(is_array($row_data) && $success == true)
			{
				$this->row_data = $row_data;
			}
		}

		return ($success);
	} # next_record()

	/**
	 * Reset all the internal variables to null.
	 * @access private
	 */
	private function __RESET_VARIABLES()
	{
		$this->ROWS = 0;
		$this->FIELDS = array();
		$this->FIELDS_COUNTER = 0;
		$this->META_DATA = array();
		$this->row_data = array();
		$this->limit = 0;
		$this->offset = 0;
		
	} # __RESET_VARIABLES();

	
	/**
	 * Method to check and see if a field exists in a table.
	 *
	 * @param   string  $table  The table in which to verify the field.
	 * @param   string  $field  The field to verify.
	 *
	 * @return  boolean  True if the field exists in the table.
	 *
	 */
	public function fieldUnique($Table,$Constraint = NULL, $Field = '',$value = '')
	{
		$result = array();
		 
	//	print_r($Constraint);
		
		if( empty($Field) )
		    $SQL = "SELECT * FROM $Table ";
		else
		    $SQL = "SELECT {$Field} FROM $Table ";
	
		// $ConstraintParams = array();
		if( !empty($Constraint) )
		{
			$strConstrain = implode(" AND ",$Constraint);
			
		   // $Constraint = $this->ToPrepared($Table,$Constraint,'AND');
		    $SQL .= " WHERE {$strConstrain} ";
		}
	
	//print_r($Constraint);
	//echo $SQL;
		
		$this->query($SQL);
	
		//$query = "SELECT {$field} FROM $table  WHERE  UPPER($field) = '$upperValue' ";
		
		$this->query($SQL);
		
		$this->lastNumRows();
		
		if (!$this->ROWS)
		{
			 $result["success"] = true;
		}
		else
		{
			$result["success"] = false;
			//= $this->to_array();
		    $result["row"] = $this->fetch( "array" );
		    
			//return false;
		}
		
		return $result;
	
	}
	

	/**
	 * Gives the to_array() result directly from SQL.
	 */
	public function arrays($sql_full_string = '')
	{
		//$this->toggle_update_meta(false);

		$array = array();
		if(!empty($sql_full_string)) # By mistake, SQL can be empty
		{
			$this->query($sql_full_string);
			while($this->next_record())
			{
				$array[] = $this->row_data;
			}
		}
		//$this->toggle_update_meta(); # Leave it as original
		return $array;
	} # arrays();

	/**
	 * Move the query result into an array
	 * Constraint - a query should have been done already!
	 * @return array Array of the query result.
	 */
	public function to_array($nested_array = true)
	{
		#$RESULTSET = $this->RESULTSET; # Bakcup, for safety
		$array = array();
		#stopper::debug($this, true);
		while($this->next_record())
		{
			$array[] = ($this->FIELDS_COUNTER == 1 && $nested_array == false) ? $this->row_data[$this->FIELDS[0]] : $this->row_data;
		}
		#stopper::debug($array, true);
		#$this->RESULTSET = $RESULTSET; # restore
		return $array;
	} # to_array();


	/**
	 * Move the query result into an associative array.
	 * Suggestion: SELECT ONLY TWO COLUMNS ONLY!
	 * Constraint - a query should have been done already!
	 * @return array Associative array of indices and vlaues.
	 */
	public function to_association($index_column = '', $value_column = '')
	{
		$index_column = trim($index_column);
		$value_column = trim($value_column);
		if(empty($index_column) ) // || empty($value_column)
		{
			echo('Empty index or value column to create an association');

			return (array());
		}

		$array = array();
		while($this->next_record())
		{
			# This is poor way, because we are alrady inside a loop.
			# However, it will prevet a user receving error messages.
			# Performance issues will be another part, we won't draw much data per loop.
			#if(isset($this->row_data[$value_column]))
			{
				$array[$this->row_data[$index_column]] = $this->row_data;
			}
			#else
			{
				# Rather this, raise some error notifications
				#$array[$this->row_data[$index_column]]='';
			}
		}

		return ($array);
	} # to_association()

	/**
	 * Extract only one column in an array!
	 * If value repleats, array will contain repeated value in its own.
	 * Similar to TO_ARRAY() but takes only one column instead of all columns available
	 */
	public function to_columnar_array($index_column = '')
	{
		$RESULTSET = $this->RESULTSET; # Bakcup, for safety
		$array = array();
		while($this->next_record())
		{
			$array[] = $this->row_data[$index_column];
		}
		$this->RESULTSET = $RESULTSET; # restore
		return ($array);
	} # to_columnar_array()

	
	public function fetchAll( $table , $column_names = array('t.*'),$join = array(),$condition = '' ,$sortBy = '',$inOrder = '', $type = "array",$groupBy = '' )
	{    
		
		$column_name = implode(",",$column_names);
		$joinCond = implode(" ",$join);
		
		$sql = " SELECT
				{$column_name}
				FROM {$table} t
				$joinCond
			";
		
		if(!empty($condition))
			$sql .= "WHERE $condition ";
			
		if(!empty($groupBy))
			$sql .= "GROUP BY $groupBy ";
			
		if(!empty($sortBy))
			$sql .= ($sortBy != "NEWID()")? "ORDER BY t.$sortBy " : "ORDER BY $sortBy ";
				 
				
		if(!empty($inOrder))
			$sql .= "$inOrder ";
		
		$this->query($sql);
		
		$this->lastNumRows();
		
		
		return $this->fetch( $type );
	}
	
	/**
	 * Convert a table name's id into its value, based on its primary key
	 */
	
	function fetch($type = "array" )
	{
		
		if( $this->ROWS <= 0 )
			return array();
		
		
		if( $type == "array" )
		{
			if( $this->ROWS > 1 )
			{
				$resultado = array();
				
				while( $r = $this->fetch_array(SQLSRV_FETCH_ASSOC) )
					$resultado[] = $r; //array_map('utf8_encode',$r); //  $r;
			}
			else{
				$r = array($this->fetch_array(SQLSRV_FETCH_ASSOC));
				//print_r($r);
				$resultado[] = $r[0]; //array_map('utf8_encode',$r[0]);
				//$resultado
				//print_r($resultado);
			}
		}
		else
		{
			if( $this->ROWS > 1 )
			{
				while($r = $this->fetch_object() )
					$resultado[] = $r;
			}
			else
			{
				$resultado = new stdClass;
				$resultado = $this->fetch_object();
			}
		}
		
		return $resultado;	
	}
	
	  /*** Implement CRUDC ***/

    /**
     * INSERT a row into a table.
     *
     * @param string $Table The table to insert into.
     * @param array $Values Column names/values for the SET clause.
     * @throws Exception CREATE Error: (includes the error code of the first error)
     * @retval integer The identity value of the inserted row.
     * @retval boolean TRUE if the query was executed but did not create an identity value.
     */
    public function CREATE( $Table,$Values,$withKey = NULL,$withLog = TRUE)
    {
	$config = \Lib\Config::singleton();
	$idModulo = $config->get('IDMODULO_SELEC');
	
	if($withLog){
			
		$userData = $config->get('SESSION_DATA');
		
		$fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
		
		$Values['FECHATRCR'] = $fechaTr;
		$Values['USUARIOTRCR'] = $userData['USUARIO'];
	}
		
	$CP = $this->ToPrepared($Table,$Values,',',TRUE);

	if(empty($CP[1]))
		return false;
	
	$SQL = "INSERT INTO $Table ({$CP[1]}) VALUES ({$CP[2]}); SELECT SCOPE_IDENTITY();"; // 

	$this->query($SQL,$CP[0]);
	
	if(!$withKey)
		$newID =  $this->lastInsertId();
	else
		$newID = $this->AFFECTED_ROWS;
		
	$this->insertLOG($SQL,$CP[0],"INSERT",$idModulo,$Table);
	
	return $newID;
    }
    
    /**
     * SELECT rows from a table.
     *
     * @param string $Table The table to select from.
     * @param array $Constraint Column name/values that are 'AND' together and used as the WHERE constraint.
     * @param array $Columns Column names or column names/alias to SELECT.
     * @param array $OrderBy Column names/directions (TRUE = ASC, FALSE = DESC).
     * @throws Exception READ Error: (includes the error code of the first error)
     * @retval array An array of rows, each an associative array, or an empty array.
     *
     * @note An empty constraint is allowed - all rows can be SELECT'd.
     * @note This uses client buffered cursors.
     */
    
    public function READ( $Table,$Constraint = NULL,$Columns = NULL,$OrderBy = NULL )
    {
        if( empty($Columns) )
            $SQL = "SELECT * FROM $Table ";
        else
            $SQL = 'SELECT '.SQL::ToColumnList($Columns)." FROM $Table ";

        $ConstraintParams = array();
        if( !empty($Constraint) )
        {
            $Constraint = $this->ToPrepared($Table,$Constraint,'AND');
            $SQL .= " WHERE {$Constraint[1]} ";
        }
	
	 if( empty($Constraint[0]) )
		return false;
	
	$this->query($SQL,$Constraint[0]);
	
	
      //  if( ($R = sqlsrv_query($this->DB,$SQL,empty($Constraint[0])?array():$Constraint,array('Scrollable'=>'buffered'))) === FALSE )
      //  {
      //      throw new Exception("\${$this->WiredAs}::READ Error: ".$this->LastErrors());
      //  }
      //  else
      //  {
      //      $Rows = array();
      //      while( ($Row = $this->fetch_array("SQLSRV_FETCH_ASSOC")) !== NULL )
      //          $Rows[] = $Row;

      //      return $Rows;
      //  }
      	
	$this->lastNumRows();	
		
	return $this->fetch( "array" );
	
    }
    
    /**
     * UPDATE rows in a table.
     *
     * @param string $Table The table to update.
     * @param array $Values Column names/values for the SET clause.
     * @param array $Constraint Column name/values that are 'AND' together and used as the WHERE constraint.
     * @throws Exception UPDATE Error: (includes the error code of the first error)
     * @throws Exception UPDATE Empty constraint not allowed.
     * @retval integer The number of affected rows.
     *
     * @note An empty constraint is not allowed.
     */
    public function UPDATE( $Table,$Values,$Constraint,$withKey = NULL,$logTr = TRUE,$withLog = TRUE )
    {
	
        $Constraints = $this->ToPrepared($Table,$Constraint,'AND');
	
	//print_r($Constraint);
	
	$config = \Lib\Config::singleton();
		
	if($withLog){
		
		$userData = $config->get('SESSION_DATA');
		
		$fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
		
		$Values['FECHATRED'] = $fechaTr;
		$Values['USUARIOTRED'] = $userData['USUARIO'];
		
	}
	
        if( empty($Constraints[0]) )
		return false;
	

	if($withKey){
		foreach($Values as $field => $value){
		    if( $field != 'FECHATRCR' &&  $field != 'USUARIOTRCR')	
			$strFields[] = "$field = '$value'";
		}
		
		foreach($Constraint as $fieldConst => $valueConst){
		  	$strConstraint[] = "$fieldConst = '$valueConst'";
		}
		
		$strFields =  implode(",",$strFields);
		
		$SQL = "UPDATE ".$Table." SET $strFields "." WHERE ".implode("AND",$strConstraint);
		
		$logParam = array();
		
		$this->query($SQL);
	}
	else{
		$Values = $this->ToPrepared($Table,$Values);
	
		$SQL = "UPDATE $Table SET {$Values[1]} WHERE {$Constraints[1]}";
	
		$this->query($SQL,array_merge($Values[0],$Constraints[0]));
		
		$logParam = array_merge($Values[0],$Constraints[0]);
		
	}
	
		$this->affected_rows();
		
		if($logTr && $Table != "SESION"){
			$idModulo = $config->get('IDMODULO_SELEC');
			$this->insertLOG($SQL,$logParam,"UPDATE",$idModulo,$Table);
		}

    }
    
     /**
     * DELETE rows from a table.
     *
     * @param string $Table The table to delete from.
     * @param array $Constraint Column name/values that are 'AND' together and used as the WHERE constraint.
     * @throws Exception DELETE Error: (includes the error code of the first error)
     * @throws Exception DELETE Empty constraint not allowed.
     * @retval integer The number of affected rows.
     *
     * @note An empty constraint is not allowed.
     */
    public function DELETE( $Table,$Constraint )
    {
        $Constraint = $this->ToPrepared($Table,$Constraint,'AND');
	
	 if( empty($Constraint[0]) )
		return false;
	

        //if( empty($Constraint[0]) )
        //    throw new Exception('\${$this->WiredAs}::DELETE Empty constraint not allowed.');

        $SQL = "DELETE FROM $Table WHERE {$Constraint[1]}";

	$this->insertLOG($SQL,"","DELETE",'1',$Table);
	
	$this->query($SQL,$Constraint[0]);
	
	//echo "affected ".sqlsrv_rows_affected($this->RESULTSET);
	
        //if( isset($_SERVER[$this->DebugToken]) )
        //    $this->DebugCRUDC('DELETE',$Table,$SQL);

       // if( ($R = sqlsrv_query($this->DB,$SQL,$Constraint[0])) === FALSE )
       //     throw new Exception("\${$this->WiredAs}::DELETE Error: ".$this->LastErrors());
       // else
        //    return sqlsrv_rows_affected($R);
	 $this->affected_rows();
	 

    }


     /**
     * COUNT rows in a table.
     *
     * @param string $Table The table to count rows in.
     * @param array $Constraint Column name/values that are 'AND' together and used as the WHERE constraint.
     * @throws Exception COUNT Error: (includes the error code of the first error)
     * @retval integer The count of rows.
     * @retval NULL The count could not be determined.
     *
     * @note An empty constraint is allowed - all rows can be COUNT'd.
     */
    public function COUNT( $Table,$Constraint = NULL )
    {
        $SQL = "SELECT COUNT(*) AS NumRows FROM $Table t";

        if( !empty($Constraint) )
        {
          //  $Constraint = $this->ToPrepared($Table,$Constraint,'AND');
	  //   $SQL .= " WHERE {$Constraint[1]}";
	      $SQL .= " WHERE {$Constraint}";
        }

    //   $this->query($SQL,array_merge($Values[0],empty($Constraint[0])?array():$Constraint));
    
	   $this->query($SQL);
	
    //    if( ($R = sqlsrv_query($this->DB,$SQL,empty($Constraint[0])?array():$Constraint,array('Scrollable'=>'buffered'))) === FALSE )
    //    {
    //        throw new Exception("\${$this->WiredAs}::COUNT Error: ".$this->LastErrors());
    //    }
    //    else
    //    {
		$rowQuery = $this->fetch_array();
		
		return (int) $rowQuery['NumRows'];
	
//            return sqlsrv_fetch_array($R,SQLSRV_FETCH_NUMERIC)[0];
    //    }
    }
    
    /**
     * Convert an array of column names/values to an array suitable for prepared statements.
     *
     * ToPrepared() forms a three element numerically indexed array:
     *  - 0: Array of value parameters.
     *  - 1: Column names and placeholders (for WHERE constraints) or column names
     *       (for INSERT) each separated by $Separator.
     *  - 2: Placeholders (?) separated by commas or an empty string.
     *
     * To correctly form the first element, the table's column types are read.
     * Currently, only a type of varbinary is mapped to it's corresponding SQL
     * type (binary stream) to support file uploads.
     *
     * The contents of the second and third elements are determined by the
     * $TwoStrings parameter.  The third element is populated only if $TwoStrings = TRUE.
     *
     * If a value is prefixed with a pipe (|) it is considered a function
     * and is untouched and not included in the parameter array.
     *
     * A PHP value of NULL is translated to a SQL value of NULL.
     *
     * @param string $Table The table to prepare for.
     * @param array $Src An associative array of column names/values.
     * @param string $Separator Separator between each pair or a comma by default.
     * @param boolean $TwoStrings TRUE to populate two strings; one of column names
     *        and one of placeholders.
     * @retval array Three element numeric array as described.
     *
     * @note Any non-string column names are silently skipped if $TwoStrings = FALSE.
     * @note An empty first or second element of the returned array indicates no constraint
     *       and should be checked for.
     *
     * @todo Shouldn't $Separator always be a comma for the third element?
     */
    public function ToPrepared( $Table,$Src,$Separator = ',',$TwoStrings = FALSE )
    {
        // Parameters, column/placeholders or columns, placeholders or empty
	
        $Ret = array(array(),'','');
        $i = 0;
        $Separator = " $Separator ";
       // $CI = $this->ColumnInfo($Table);
	
        foreach( $Src as $K => $V )
        {
		
	//	if(!isset($CI[$K]))
	//		continue;
		
            if( is_string($K) === TRUE )
            {
                // function
                if( !is_object($V) && isset($V{0}) && $V{0} === '|' )
                {
                    if( $TwoStrings )
                    {
                        $Ret[1] .= ($i>0?$Separator:'').$K;
                        $Ret[2] .= ($i++>0?$Separator:'').substr($V,1);
                    }
                    else
                    {
                        $Ret[1] .= ($i++>0?$Separator:'')."{$K}=".substr($V,1);
                    }
                }
                else
                {
                    if( $TwoStrings )
                    {
                        $Ret[1] .= ($i>0?$Separator:'').$K;
                        $Ret[2] .= ($i++>0?$Separator:'').($V===NULL?'NULL':'?');
                    }
                    else
                    {
                        $Ret[1] .= ($i++>0?$Separator:'')."{$K}=".($V===NULL?'NULL':'?');
                    }

		 //   echo " RETORNA ".$K;
		  //   print_r($Ret);
		 // print_r($CI);
		  
                   $Ret[0][] = $V; //$this->ToParamType($V,isset($CI[$K])?$CI[$K]['DATA_TYPE']:'');
		   
		 //   print_r($Ret);
                }
            }
        }
	
	//echo "CAMPOS ";
	//print_r($Ret);
        return $Ret;
    }

    /**
     * Form a SQL Server parameter type based on a column type.
     *
     * The following column types are currently supported:
     *  - varbinary: binary stream (for file uploads).
     *
     * Other column types are left alone and will be cast by SQL
     * Server using it's default behavior.
     *
     * @param scalar $Value The value of the column to be typed.
     * @param string $Type The type to convert to (currently only varbinary).
     * @retval array Properly formed SQL server parameter for binary stream.
     * @retval scalar $Value is returned without change.
     */
     public function ToParamType( $Value,$Type = '' )
    {
        if( $Type === 'varbinary' )
            return array($Value,SQLSRV_PARAM_IN,SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY),SQLSRV_SQLTYPE_VARBINARY('max'));
        else
            return $Value;
    }
    
     /**
     * Collect column name, type and length information for a table.
     *
     * @param string $Table The table to collect column information for.
     * @throws Exception ColumnInfo Error:
     * @retval array Information for each column in a table.
     *
     * @note This caches the column information between calls.
     */
    public function ColumnInfo( $Table )
    {
	
        if( isset($this->ColumnInfoCache[$Table]) )
            return $this->ColumnInfoCache[$Table];

	 $SQL = "SELECT COLUMN_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,IS_NULLABLE,COLUMN_DEFAULT
                  FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME= '$Table'";
		  

      //  $R = sqlsrv_query($this->DB,$SQL,array($Table));
	$this->query($SQL,array($Table));
	
	$this->lastNumRows();
	
	//echo "FILAS".$this->num_rows();
        //if( $R === FALSE )
        //{
         //   throw new Exception("\${$this->WiredAs}::ColumnInfo Error: ".$this->LastErrors());
        //}
        //else
        
	if($this->ROWS > 0){
            $Info = array();
           // while( ($Row = sqlsrv_fetch_array($R,SQLSRV_FETCH_NUMERIC)) !== NULL )
           //     $Info[$Row[0]] = $Row;
		
	//	$Info = $this->to_association("COLUMN_NAME");
		
	//	print_r($Info);

        //    return ($this->ColumnInfoCache[$Table] = $Info);
		    return $this->fetch( "array" );
        
	}
    }
    
	/**
	 * Method to get an array of all tables in the database.
	 *
	 * @return  array  An array of all the tables in the database.
	 *
	 * @throws  RuntimeException
	 */
	public function getTableList()
	{
		
		$this->query('SELECT name FROM ' . $this->DBNAME . '.sys.Tables WHERE type = \'U\' ORDER BY name;');
		
		return $this->fetch( "array" );
	}
	
	/**
	 * Terminates any existing connections and data.
	 * @link http://social.msdn.microsoft.com/Forums/en-US/sqldriverforphp/thread/92d10699-c0cb-4b97-ab99-b2a7f975afce
	 */
	public function __destruct()
	{
		# Error: Do not actually close the connection.
		//sqlsrv_free_stmt($this->RESULTSET);
		sqlsrv_close($this->CONNECTION);
	} # __desctruct()
	
	public function closeConn()
	{
		# Error: Do not actually close the connection.
		//sqlsrv_free_stmt($this->RESULTSET);
		sqlsrv_close($this->CONNECTION);
	} # __desctruct()
	
	/**
	 * Tries to get last insert ID.
	 */
	public function lastInsertId()
	{
		//$insert = $this->row("SELECT ISNULL(@@IDENTITY, 0) insert_id;");
		$this->query("SELECT ISNULL(@@IDENTITY, 0) insert_id;");
		$insert = $this->fetch_array();
		
		return (int) $insert['insert_id'];
	}

	# For copatibility only
	public function affected_rows()
	{
	//	echo "affected ".sqlsrv_rows_affected($this->RESULTSET);
		$this->AFFECTED_ROWS = sqlsrv_num_rows($this->RESULTSET);
	//	return $this;
	
	//	return sqlsrv_rows_affected($this->RESULTSET);
	}
} # class mysql
?>