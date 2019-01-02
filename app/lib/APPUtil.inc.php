<?php

namespace Lib;

class APPUtil
{
	
	public static  $antiInjectionStr;
	/*
	function varsLOG( $frm , $usuario , $table , $key , $id , $do )
	{
		$usuario = SIMUser::get("Nombre");
		$table = SIMReg::get("table");
		$key = SIMReg::get("key");
		$id = SIMNet::reqInt("id");
		$do = SIMNet::get( "action" );
		
		
		$dbo =& SIMDB::get();
		$qry = $dbo->query( "SELECT UsuarioTrCr , FechaTrCr , UsuarioTrEd , FechaTrEd FROM " . $table . " WHERE " . $key . " = '" . $id . "'" );
		$r = $dbo->object( $qry );
		
		$now = date( "Y-m-j h:i:s" );
		
		if( $do == "edit" )
		{
			$frm['UsuarioTrEd'] = $usuario;
			$frm['FechaTrEd'] = $now;
			$frm['UsuarioTrCr'] = $r->UsuarioTrCr;
			$frm['FechaTrCr'] = $r->FechaTrCr;	
		}
		else
		{
			$frm['UsuarioTrCr'] = $usuario;
			$frm['FechaTrCr'] = $now;
			$frm['UsuarioTrEd'] = $r->UsuarioTrEd;
			$frm['FechaTrEd'] = $r->FechaTrEd;
		}
		
		return $frm;
	}
	*/
	
	static function validate( $frm , $arr_valida )
	{
		//echo "UTIL validate";
		
		$errorMsg = "";
		$errorList = array();
		$arrayFields = $arr_valida;
	
		foreach( $arrayFields as $field => $text)
		{
			
			$value = $frm[ $field ];
	
			if ( trim( $frm[ $field ] ) == "" )
				$errorList[] = array( "field" => $field, "value" => $value , "msg" => $text );
		}
				
		if( count( $errorList ) > 0 )
		{
			$mess = "Debe Ingresar  : ";
			
			foreach( $errorList as $item ) 
				$mess .= " " . $item['msg'] . " ";
			
			$mess .= " <br>Por favor corrija e intente de nuevo. ";
			
			$result["success"] = false;
			$result["msg"] = $mess;
			
			return $result;
		}
		else
			$result["success"] = true;
		
		return $result;
	
	}
	
	static function filterFromJson($filterRules){
		
		$filter = '';
		
		 $filterRules = json_decode($filterRules,true);

		 //print_r($filterRules);
      
		 if(is_array($filterRules)){
			foreach($filterRules as $rule){
			       if (!empty($rule['value'])){
					
					switch ($rule['op']){
						case 'equal' :
							 
							if( $rule['field'] == "FECHA" )
							{
								$cond[] = "( FORMAT( t.".$rule['field'].", 'yyyy-MM-dd'  ) = '".$rule['value']."' )";
							}
							else
							{
								$cond[] = "(t.".$rule['field']." = '".$rule['value']."' )";
							}
							



						break;
						case 'contains' :
							$cond[] = " (t.".$rule['field']." like '%".$rule['value']."%')";
						break;
						case 'beginwith' :
							$cond[] = " (t.".$rule['field']." like '".$rule['value']."%')";
						break;
						case 'endwith' :
							$cond[] = " (t.".$rule['field']." like '%".$rule['value']."')";
						break;
						case 'in' :
							$cond[] = " (t.".$rule['field']." IN (".$rule['value'].") )";
						break;
						case 'less' :
							 $cond[] = "(t.".$rule['field']." < ".$rule['value']." )";
						break;
						case 'lessorequal' :
							 $cond[] = "(t.".$rule['field']." <= ".$rule['value']." )";
						break;
						case 'greaterorequal' :
							 $cond[] = "(t.".$rule['field']." >= ".$rule['value']." )";
						break;
						case 'greater' :
							 $cond[] = "(t.".$rule['field']." > ".$rule['value']." )";
						break;
						case 'notequal' :
							 $cond[] = "(t.".$rule['field']." <> ".$rule['value']." )";
						break;
						case 'join' :
							 $cond[] = "(t.".$rule['param']." = '".$rule['value']."' )";
						break;
				
					}
				       
			       }
		       }
		       if(!empty($cond))
			       $filter = implode(" AND ",$cond);
		}
		
		return $filter;
		
	}
	
	static function filterFromJsonJoin($filterRules){
		
		$filter = '';
		
		 $filterRules = json_decode($filterRules,true);
     
		 if(is_array($filterRules)){
			foreach($filterRules as $rule){
			       if (!empty($rule['value'])){
					
					switch ($rule['op']){
						case 'equal' :
							 $cond[] = "(".$rule['field']." = '".$rule['value']."' )";
						break;
						case 'contains' :
							
							if(empty($rule['param']))
								$cond[] = " (".$rule['field']." like '%".$rule['value']."%')";	
							else
								$cond[] = "(".$rule['param']." like '%".$rule['value']."%' )";
							
						break;
						case 'beginwith' :
							$cond[] = " (".$rule['field']." like '".$rule['value']."%')";
						break;
						case 'endwith' :
							$cond[] = " (".$rule['field']." like '%".$rule['value']."')";
						break;
						case 'less' :
							 $cond[] = "(".$rule['field']." < ".$rule['value']." )";
						break;
						case 'lessorequal' :
							 $cond[] = "(".$rule['field']." <= ".$rule['value']." )";
						break;
						case 'greaterorequal' :
							 $cond[] = "(".$rule['field']." >= ".$rule['value']." )";
						break;
						case 'greater' :
							 $cond[] = "(".$rule['field']." > ".$rule['value']." )";
						break;
						case 'notequal' :
							 $cond[] = "(".$rule['field']." <> ".$rule['value']." )";
						break;
						case 'join' :
							 $cond[] = "(".$rule['param']." = '".$rule['value']."' )";
						break;
						case 'betweenDate' :
							list($fechaIni,$fechaFin) = explode("_",$rule['value']);
							
							$cond[] = "(".$rule['field']." >=  '$fechaIni' AND ".$rule['field']." <= '$fechaFin'  )";
							
							//$cond[] = "(".$rule['field']." BETWEEN  '$fechaIni' AND '$fechaFin'  )";
						break;
						case 'betweenDateT' :
							list($fechaIni,$fechaFin) = explode("_",$rule['value']);
							$fechaIni  = "$fechaIni 00:00:00";
							$fechaFin  = "$fechaFin 23:59:59";
							$cond[] = "(".$rule['field']." >=  '$fechaIni' AND ".$rule['field']." <= '$fechaFin' )";
						break;
					}
				       
				       
				 //      if($v=="FechaInicio")
				//			array_push($where_array," Traslado.Fecha >= CONCAT('$FechaInicio','00:00:00')");
				//		elseif($v=="FechaFin")
				//			array_push($where_array," Traslado.Fecha <= CONCAT('$FechaFin','23:59:59')");
							
			       }
		       }
		       if(!empty($cond))
			       $filter = implode(" AND ",$cond);
		}
		
		return $filter;
		
	}
	
	public static function antiInjection($str) {
		// $banchars = array ("*",";", "--","\n","\r");
	         $banchars = array ("*", "--","\n","\r");
	        
		//$banwords = array ("key_column_usage","UNION"," or "," OR "," Or "," oR "," and ", " AND "," aNd "," aND "," AnD ","group_concat","table_name");
	        $banwords = array ("key_column_usage","UNION","group_concat","table_name");
	      //  if ( eregi ( "[a-zA-Z0-9]+", $str ) ) {
		if(preg_match('/'."[a-zA-Z0-9]+".'/i',$str)) {	
	                $str = str_ireplace ( $banchars, '', ( $str ) );
	                $str = str_ireplace ( $banwords, '', ( $str ) );
	        } else {
	                $str = NULL;
	        }
	        $str = trim($str);
	        $str = strip_tags($str);
	        $str = stripslashes($str);
	        $str = addslashes($str);
	        $str = htmlspecialchars($str);
	
		return $str;
	
	}
	
	public static function cache( $type = "text/html" )
	{
		header( "Content-type: " . $type );
		header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );             
		header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" ); 
		header( "Cache-Control: no-cache, must-revalidate" );           
		header( "Pragma: no-cache" );
		return true;                                   
	}
	
	 /*
	*    $dataFields array() : Arreglo Datos de la consulta para ser reemplazados en el template del BODY del formato.
	*/
       
       public static function parseTemplate($dataFields,$htmlBody){
	   
	   $htmlBodyParsing = '';
	    foreach($dataFields as $field => $value){
	       
		$htmlBody = str_replace('['.$field.']',$value,$htmlBody);
	   }
	  
	  return $htmlBody;
	
       }
	
	
	public static function clearStrNumeric($string){
	  
	  return preg_replace('/[^0-9]/', '', $string);
	
       }

        public static function headerView(){
	
		$config = Config::singleton();
		
		$header = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>'.$config->get('appName').'</title>	
		<link rel="stylesheet" type="text/css" href="'.$config->get('jeasiUIFolder').'themes/icon.css"/>
		<link rel="stylesheet" type="text/css" href="'.$config->get('jeasiUIFolder').'themes/ui-sunny/easyui.css"/>
		<link rel="stylesheet" type="text/css" href="'.$config->get('jeasiUIFolder').'demo/demo.css">
		<link rel="stylesheet" type="text/css" href="'.$config->get('CSS_FOLDER').'fenix.css"/>
		<script type="text/javascript" src="'.$config->get('jqueryFolder').'jquery.min.js"></script>
		<script type="text/javascript" src="'.$config->get('jeasiUIFolder').'jquery.easyui.min.js"></script>
                <script type="text/javascript" src="'.$config->get('jeasiUIFolder').'locale/easyui-lang-es.js"></script>
                <script type="text/javascript" src="'.$config->get('jeasiUIFolder').'datagrid-filter.js"></script>
		<script type="text/javascript" src="'.$config->get('jsFolder').'viewUtils.js"></script>';
	
	return $header;
	
       }
	
	public static function date_diff($start,$end){
		
		 $uts['start']      =    strtotime( $start );
		 $uts['end']        =    strtotime( $end );
	    if( $uts['start']!==-1 && $uts['end']!==-1 )
	    {
	     //   if( $uts['end'] >= $uts['start'] )
	       // {
	            $diff    =    $uts['end'] - $uts['start'];
	            if( $days=intval((floor($diff/86400))) )
	                $diff = $diff % 86400;
	            if( $hours=intval((floor($diff/3600))) )
	                $diff = $diff % 3600;
	            if( $minutes=intval((floor($diff/60))) )
	                $diff = $diff % 60;
	            $diff    =    intval( $diff );            
	            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
	       // }
	      //  else
	       // {
	       //     trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
	       // }
	    }
	    else
	    {
	        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
	    }
	    return( false );
		
	}
	
/*END */
}
?>