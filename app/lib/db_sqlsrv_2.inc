<?php
/**
 * @author Bimal Poudel
 * @copyright since 2006, Bimal Poudel
 * @support https://www.odesk.com/o/profiles/users/_~~657b70cc7f2c616a/
 * @contact http://www.sanjaal.com
 * @company Sanjaal Corps
 */

/**
 * SQLSRV basic class
 * @package Databases
 */
class sqlsrv
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

	/**
	 * Constructor
	 * <br>Connects to the database with the assigned server details.
	 * <br>Reuses the connection resources if possible.
	 */
	public function __construct()
	{
		if(!defined('SQLSRV_CONNECTION'))
		{
			#$config_file = dirname(__FILE__) . '/config.sqlsrv.inc.php';
			#if(!is_file($config_file))
			#{
		#		die('Missing SQLSRV configuration file');
		#	}
		#	require_once($config_file);
			# config.sqlsrv.inc.php
			if(!function_exists('sqlsrv_connect'))
			{
				die('Install SQLSRV library first.');
			}
			if(
				!defined('SQLSRV_DATABASENAME') ||
				!defined('SQLSRV_HOSTNAME') ||
				!defined('SQLSRV_PASSWORD') ||
				!defined('SQLSRV_USERNAME')
			)
			{
				die('SQLSRV connection parameters not defined correctly');
			}

			$this->CONNECTION = sqlsrv_connect(SQLSRV_HOSTNAME, array(
				'UID' => SQLSRV_USERNAME,
				'PWD' => SQLSRV_PASSWORD,
				'Database' => SQLSRV_DATABASENAME,
			)) or die(sqlsrv_errors());
			define('SQLSRV_CONNECTION', $this->CONNECTION);
		}
		else
		{
			# Reuse the connection
			$this->CONNECTION = SQLSRV_CONNECTION;
		}
	} # __construct()

	/**
	 * Attempt to run any kind of database queries
	 * @param string $query Valid SQL to hit
	 * @return boolean Success / Failure  status while making a query
	 */
	public function query($sql = '')
	{
		$success = false;
		
		//echo " EL QUERY ".$sql;
		
		if($sql == '')
		{
			stopper::message('Query is empty. Cannot do SQL action.', false);

			return ($success);
		}

		# Temporarily treat the bad sql
		#$sql = preg_replace('/[\r|\n]+/is', ' ', $sql);
		$sql = str_replace('\\r', ' ', $sql);
		$sql = str_replace('\\n', ' ', $sql);

		$meta = array();
		$this->__RESET_VARIABLES();

		if($this->RESULTSET = sqlsrv_query($this->CONNECTION, $sql,array(), array("Scrollable"=>"buffered")))
		{
			$success = true;
		}
		else
		{
			print_r(sqlsrv_errors());
			debug_print_backtrace();
			die($sql);
			$success = false;
		}

		return ($success);
	} # query()

	
	public function num_rows() {
		
	//	echo "FILAS ".sqlsrv_num_rows($this->RESULTSET);
		return  sqlsrv_num_rows($this->RESULTSET);
	    
	}
	
	public function fetch_object() {
		
		return  sqlsrv_fetch_object($this->RESULTSET);
	    
	}
	
	public function fetch_array() {
		
		return  sqlsrv_fetch_array($this->RESULTSET);
	    
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
			$row_data = sqlsrv_fetch_array($this->RESULTSET, SQLSRV_FETCH_ASSOC) or $success = false;
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
	} # __RESET_VARIABLES();


	/**
	 * Gives the to_array() result directly from SQL.
	 */
	public function arrays($sql_full_string = '')
	{
		$this->toggle_update_meta(false);

		$array = array();
		if(!empty($sql_full_string)) # By mistake, SQL can be empty
		{
			$this->query($sql_full_string);
			while($this->next_record())
			{
				$array[] = $this->row_data;
			}
		}
		$this->toggle_update_meta(); # Leave it as original
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
		if(empty($index_column) || empty($value_column))
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
				$array[$this->row_data[$index_column]] = $this->row_data[$value_column];
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

	/**
	 * Convert a table name's id into its value, based on its primary key
	 */
	public function get_table_value($table = '', $column_name = '', $primary_key = '', $pk_id = 0, $is_unsafe = true)
	{
		/**
		 * When considering unsafe entries, make them integers by adding zero.
		 * For safe columns, pass it as <false> to keep as it is. Especially, working with unique keys and varchar type columns.
		 */
		if($is_unsafe == true)
		{
			$pk_id += 0;
		}

		$sql = "
				SELECT
					{$column_name} v
				FROM {$table} t
				WHERE
					t.{$primary_key}='{$pk_id}' -- Quoted? Case Based.
				;";
		$value = $this->row($sql);
		if(!isset($value['v']))
		{
			$value = array(
				'v' => null
			);
		}

		return $value['v'];
	}

	/**
	 * Terminates any existing connections and data.
	 * @link http://social.msdn.microsoft.com/Forums/en-US/sqldriverforphp/thread/92d10699-c0cb-4b97-ab99-b2a7f975afce
	 */
	public function __destruct()
	{
		# Error: Do not actually close the connection.
		#sqlsrv_close($this->CONNECTION);
	} # __desctruct()

	/**
	 * Tries to get last insert ID.
	 */
	public function insert_id()
	{
		$insert = $this->row("SELECT ISNULL(@@IDENTITY, 0) insert_id;");

		return $insert['insert_id'];
	}

	/**
	 * Switch to a new database
	 */
	public function database($database = 'test')
	{
		return null;
	}

	# For copatibility only
	public function affected_rows()
	{
		sqlsrv_rows_affected($this->CONNECTION);
	}
} # class mysql
?>