<?php
/*
 * Clase de Conexion con Oracle por medio de libreria ori8
 * Autor: Giovanny QUIntero
 * Fecha: 23-Enero-2015
 * Modificado: 
 */
namespace Lib;

//use Lib\APPDbo;

class APPOracle
{
	var $error;
	var $conn = null; 
	
	// método constructor	
	public function __construct() // odbc_conn()
	{
			
	}
	
	/*
         *  método de probar conexión
         */
	public function open_conn($dsn, $user, $pwd)
	{
		/*$dsn = "Driver={SQL Server}; Server=WINDLP710JC5UU\SQLSERVER2008; Database=consejo;";
                $usuario = "sa";
                $clave = "ADAsa1102";*/
             $this->conn= oci_connect($user,$pwd, $dsn);
            if(!is_resource($this->conn)){
                $e = oci_error();
                $this->error = trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
               return false;

                    $this->conn = oci_pconnect($this->user,$this->pwd, $this->dns);
                    oci_execute($this->conn, "SET NAMES 'UTF8'");
                    oci_execute($this->conn, "SET client_encoding='UTF-8'");
            }
            if(is_resource($this->conn))
            {
               return true;
            }
            else{
               $e = oci_error();
                $this->error = trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
               return false;
            }
	}
	
	// fecha a ligação existente com a base de dados
	public function close_conn()
	{
		return oci_close($this->conn);
	}
	

	/*
	
	
        Attempt to config DSN directly

	function dnsConf()
	{
	$conf  = "DRIVER=Microsoft Access Driver (*.mdb);";
	$conf .= "{$this->dbRoot}";
        $conf .= "UserCommitSync=Yes;";
        $conf .= "Threads=3;";
        $conf .= "SafeTransactions=0;";
        $conf .= "PageTimeout=5;";
	$conf .= "MaxScanRows=8;";
	$conf .= "MaxBufferSize=2048;";
	$conf .= "DriverId=281;";
	$conf .= "DefaultDir=C:/Programas/Ficheiros comuns/ODBC/Data Sources";
    return $conf;
    
    echo gettype($conf);
   }
   
   */	
		

	
	/**
	 *  executa um pedido à base de dados
	 *
	 * @param clausula $sql
	 * @return resource query ou bool false
	 */
   public function exec_query($sql)
   {
   	if(!empty($sql)){
            $stid = oci_parse($this->conn, $sql);
            $query = oci_execute($stid) or die("DATABASE QUERY ERROR ". oci_error());
            return $stid;
            //echo gettype($stid);
   	  } 
          else{ 
            $this->close_conn();
            return false;
        }
   }
   
   /**
    * Forma como o resultado é apresentado
    *
    * @param resource       $query
    * @param marker         $marker
    * @param number of rows $row_number
    * @param array          $arr_data
    * @return array/object/bool/int
    */
   public function fetch_data($query,$marker=0,$row_number=NULL,$arr_data=NULL)
   {
   	switch($marker){
  	 case 0:
            $line = oci_fetch_array($query,$row_number);	
   	 break;
  	 case 1:
            $line = oci_fetch_object($query);
   	 break;
  	 case 2:
            if($res_id==NULL)
                print "Parameter $ res_id is needed";
            else 
                $line = oci_fetch_row($query);
         break;
  	 case 3:
            //$line = odbc_fetch_into($query,$arr_data);	
  	 default:
            return false;
   	  }
   	return $line;
   }
   
    
   /**
    * Fornece o numero de colunas 
    *
    * @param resource $query
    * @return int
    */
   
   public function num_rows($query)
   {
   	$num = oci_num_rows($query);
   	if($num > 0)
            return $num;
   	else 
            return false;
   }
   
   /**
    * Fornece o numero de campos 
    *
    * @param resource $query
    * @return int
    */
   public function num_fields($query)
   {
        $fields = oci_num_fields($query);
        if($fields > 0)
            return $fields;
        else 
           return false;
   }

   /**
    * Rollback a transaction
    * 
    * @param  none
    * @return bool
    */
   public function rollback()
   {
        if(is_resource($this->conn))
            return oci_rollback($this->conn);
        else 
            return false;   		
   }
   
   
    /**
     * Commit an ODBC transaction
     * 
     * @param  none
     * @return bool
     */
   public function commit()
   {
        if(is_resource($this->conn))
            return oci_commit($this->conn);
        else 
            return false;   		
   }
   
  
   /**
    * encerra todas as ligações ODBC existentes
    *  
    * @param none
    * @return  void
    */
   public function unset_conn()
   {
   	return oci_close($this->conn);
   }
  
  /**
   * Fornece informação sobre a BD actual
   *
   * @param  int  $fecth_type
   * @return array [db info]
   */

  /*public function db_info($fetch_type=1)
  {
	$info = odbc_data_source($this->conn,$fetch_type);
       
       foreach($info as $data)
       {
	    $temp[] = $data;
    
       }
       return $temp;
   }*/

   /**
    * Prepara e executa um pedido SQL
    *
    * @param sql clausule $query
    * @return resource 
    */
   
   /*public function Prepare($query)
   {
   	if(!empty($query) && is_resource($this->conn)){
  
		$preExec = odbc_do($this->conn,$query);
	}
 
	if(is_resource($preExec))
		return 	$preExec; 
	else 
		return false;
   }*/
  
  /*public function go_next($query)
  {
	if(is_resource($query)){
	$next = odbc_next_result($query);
	}
	return $next;
 }*/
 
 
 /**
  * Devolve o nome do cursor para o recurso forcecido
  *
  * @param resource $query
  * @return string [cursor_name]
  */
 /*function get_cursor($query)
 {
 	if(!empty($query) && is_resource($query))
 		
 		return odbc_cursor($query);
 		
 	else 
		return false;
 	
 }*/
 
 /**
  * Permite manipular colunas longas
  *
  * @param resource $query
  * @param int $length
  * @return bool
  */
 
 /*public function handle_columns($query,$length,$mode)
 {
 	if(is_resource($query)&& is_int($length)){
     
		switch($mode)
		{
			case 'len':
			$_mode =  odbc_longreadlen($query,$length);
			break;
			case 'bin':
			$_mode =  odbc_binmode($query,$length);
			break;
			default: 
			return false;	
		} 
		return $_mode;
 	}
 }*/
 
 /**
  * Permite obter informações  acerca dos campos da tabela
  *
  * @param  resource $query
  * @param  mix $value
  * @param  string $mode
  * @return mix [$handle]
  */
 
 public function handle_fields($query,$value,$mode)
 {
   switch($mode){
 
   	case 'len':
   	//$handle = odbc_field_len($query,$value);	
   	break;
   	case 'name':
            $handle = oci_field_name($query,$value);
   	break;
   	case 'num':
   	//$handle = odbc_field_num($query,$value);
   	break;
   	case 'pres':
            $handle = oci_field_precision($query,$value);
        break;
   	case 'scale':
            $handle = oci_field_scale($query,$value);
   	break;
   	case 'type':
            $handle = oci_field_type($query,$value);
        break;
   	default:
            return false;						
   }
   return $handle; 
 }
 
 
 
  /**
    * Permite inserir os dados na tabela
    *
    * @param  array $fields
    * @return resource $insert
    */
   public function Insert ($fields)
   {
        if(is_array($fields))
        {
         foreach($fields as $rows => $values){
         $arrRows[] = "".$rows."";
         $arrValues[]= "'".$values."'";
         }
         $strRows = implode(", ", $arrRows);

         $strValues = implode(", ", $arrValues);
        }
         $query =  "INSERT INTO ".$this->table."($strRows) VALUES ($strValues);";

         $insert = $this->exec_query($query);

         if($insert){
           echo "Data inserted successfully !";
           }
         return $insert; 
    
    }
    
    /**
     * Executa clausulas personalizadas 
     * de actualização da base de dados
     * 
     * @param  array $set
     * @param  array $where
     * @param  int $marker
     * @return resource [update] $res
     */
    
    public function Update($set,$where=NULL,$marker)
    {
    	foreach($set  as $data => $info)
    	{
            $_data[] = $data." = "."'{$info}'";
    	}
        $strRows = implode(",",$_data);
       
       switch($marker)
       {
            case 0:
            $update = "UPDATE $this->table SET	{$strRows}"; 	
            break;
            case 1:
            foreach($where  as $rows => $_info)
            {
                $Rowsinfo[] = $rows."="."'{$_info}'";
            }
            $strWhere = implode(",", $Rowsinfo);
            $update = "UPDATE $this->table SET {$strRows} WHERE {$strWhere}"; 	
            break;
            default:
            return false;		
       }
       $res = $this->exec_query($update);
       if(is_resource($res)){
        return $res;
       }
    }
    
    
    /**
     * Apaga os campos indicados pela clausula sql
     *
     * @param  pos where clausule $sql
     * @return resource [delete]
     */
    
    /*public function delete($sql)
    {
     if(!empty($sql)){
        $query = "DELETE FROM ".$this->table." WHERE ".$sql;	
        $del = self::Prepare($query);
     }	
     return $del;
    	
    }*/
    
    
    
/**
 * Permite obter os resultados da tabela
 *
 * @param   string  $sql
 * @param   array    $rows
 * @param   int      $row_num
 * @return  array    [results]
 */

    public function  results($sql)
    {
            $count = 0;
            $data = array();
            $res =  self::exec_query($sql);
             while ($row = @oci_fetch_array($res)) {
                $data[$count] = array_map("utf8_encode", $row);;
                $count++;
             }
             @oci_free_statement($res);
          return $data;
    }
  
  
  /**
   * Apaga a tabela informada 
   *
   * @return resource [$query]
   */
  
  public function DropTable($table)
  {
   return self::exec_query("DROP TABLE {$table}");
  }
  
  //{{ Perquisar acerca destes métodos e implementálos
  /*
   function Create_Table($values)
   {
     foreach($values as $Rows => $Type)
     {
            $arrfields[] = $Rows;
    		$dataType[]  = $Type;
    		$arrValues[] = "".$Rows." ".$Type."";
     }
 

    $table = $values["TABLE"];
    $arr_rows = implode(", ",$arrfields);
    $fields = substr($arr_rows,10,strlen($arr_rows));
    $strFields = implode(", ",$arrValues); 
    $Fields = substr($strFields,strlen($table)+7,strlen($strFields));

     #if($this->Check_Table($table)!=true){
     $gen_table = $this->Exec_Query("CREATE TABLE ".$table." (".$Fields.")");
     #}

     return $gen_table;
    }
    
   
  
 
    
     function Check_Table($table)
      {
       $result = $this->exec_query("SELECT name FROM odbc_master WHERE type='table' AND name='".$table."'");
       if(odbc_conn::num_rows($result) > 0){
       return true;
       }
      }

      
   */
//}}}

   
      /**
       * Tipo de dados suportado
       *
       * @return resource [#int]
       */
      
    /*public function DataType()
     {
      return odbc_gettypeinfo($this->conn);
     	
     }*/
     
  } // end of class

?>