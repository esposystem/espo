<?php
class APPSession
{
	//tiempo limite de la sesion
	var $_limit;
	
	public $userData;
	
	public $sesionActiva;
	
	
	//constructor
//	function APPSession( $msgerror , $session_limit = 40 )
   function APPSession( $session_limit = 40 )
	{
		$this->_limit = $session_limit;
	}
	
	function crear( $idusuario , $datos )
	{
		session_start(); 
		
		$date = new DateTime("now");
		$now = $date->format("Y-m-d\TH:i:s");
			
		$id = md5( uniqid( $fecha ) );
		
		$campos = array( "IDSesion" => $id , "IDUsuario" => $idusuario , "Inicio" => $now , "Datos" => $datos );
		
		$dbo = new APPDbo();
		
		//print_r($dbo);
		
		//$guardarqry = $dbo->insert( $campos , "Sesion" , "IDSession" );
		
		$IDNew = $dbo->CREATE("Sesion",$campos);
		
		$_SESSION["APP_SESION"] = $id; 
		
		if( $_SESSION["APP_SESION"] )
			return true;
		return false;
	}

	
	function verificar()
	{
		session_start(); 
		
		print_r(get_declared_classes() );
	//	print_r($_COOKIE);
		
		$defaultdata = array( "flag" => false );
		
	//	$variable_session = $_SESSION["APP_SESION"];
	
	
		//Primero verificar que el cookie este activo
		if ( !$_COOKIE["APP_SESION"] )
			$this->sesionActiva = false;
		else
		{
			//$this->clean();
			
			$dbo = new Lib\APPDbo();
			
			$sessiondata = $dbo->fetchAll( "Sesion" , "Datos" , "IDSesion = '" . $_SESSION["APP_SESION"] . "'" ,"array");
			
			
			if( !$sessiondata ){
				$this->sesionActiva  = false;

				//return "XS";//expiro la sesion
			}
			else
			{
				//print_r($sessiondata);
				
				
				$defaultdata  = unserialize( stripslashes( $sessiondata[Datos] ) );
			
				//print_r($defaultdata);
				
				//print_r($sessiondata);
				
				
				$this->userData = $defaultdata;
				
				$this->sesionActiva = true;
				
				
				//print_r($defaultdata);
				
				//Actualizo la sesio a la hora de la transaccion
				
				$date = new DateTime("now");
				$now = $date->format("Y-m-d\TH:i:s");
		
				//$dbo->query( "UPDATE Sesion SET Inicio = NOW() WHERE IDSesion='" . $variable_session . "'" );
				
				$fields = array("Inicio"=>$now);
				
				$constrain = array("IDSesion"=>$variable_session);
				
				$dbo->UPDATE("Sesion",$fields,$constrain );
				
			//	print_r($sessiondata);
			
			
			//	return $defaultdata;
			}
		}
		
	}
	
	function clean()
	{
		$dbo =& APPDB::get();
		return $dbo->query( "DELETE FROM Sesion WHERE DATE_ADD( Inicio, INTERVAL " . $this->_limit . " MINUTE ) < NOW()" );
	}
	
	function eliminar()
	{
		session_start(); 
		
		$variable_session = $_SESSION["APP_SESION"];
		
		session_destroy(); 
		
		$dbo =& APPDB::get();
		
		return $dbo->deleteById( "Sesion" , "IDSesion" , $variable_session );
	}
}

?>
