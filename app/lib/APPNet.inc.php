<?php

namespace Lib;

use Lib\APPUtil;

class APPNet
{
	static function IP()
	{
		$ip = "";
		
		if( getenv( "HTTP_CLIENT_IP" ) )	
			$ip = getenv( "HTTP_CLIENT_IP" );
		else
			if( getenv( "HTTP_X_FORWARDED_FOR" ) )
				$ip = getenv( "HTTP_X_FORWARDED_FOR" );
			else
				$ip = getenv( "REMOTE_ADDR" );
		return $ip;
	}
	
	static function req( $variable ) 
	{
		
		if( isset( $_POST[ $variable ] ) )
				return self::post( $variable );
		else
			if( isset( $_GET[ $variable ] ) )
				return self::get( $variable );
			else
				return false;		
	}
	
	static function getParam( $variable ) 
	{
		
		if( isset( $_POST[ $variable ] ) )
				return $_POST[ $variable ];
		else
			if( isset( $_GET[ $variable ] ) )
				return $_GET[ $variable ];
			else
				return false;		
	}
	static function reqInt( $variable )
	{
		return intVal( self::req( $variable ) );
	}
	
	static function get( $variable ) 
	{		
		if( isset( $_GET[ $variable ] ) )
			return self::clear( $_GET[ $variable ] );
		else
			return false;		
	}
	
	static function post( $variable,$clean=true ) 
	{
		
		if( isset( $_POST[ $variable ] ) )
			//return $_POST[ $variable ];
			//return self::clear( $_POST[ $variable ] );
			if($clean)
				return APPUtil::antiInjection( $_POST[ $variable ] );
			else
				return  $_POST[ $variable ];
		
		else
			return false;		
	}
	
	public static function allPost()
	{
		
		if( isset( $_POST ) ){
			foreach( $_POST as $key => $value ){
				//$response[ $key ] = self::antiInjection2(  $value );
				
				$_POST[ $key ] = APPUtil::antiInjection(  $value );
				//print_r(APPUtil);
			}
			return $_POST;
		}
		else
			return false;		
	}
	
	function clear( $vardata ) 
	{
	
		$quickexpr = "&[A-Za-z]+\;";
		
		if( is_array( $vardata ) )
		{
			foreach( $vardata as $key => $value )
				$vardata[ $key ] = self::clear(  $value );
		}
		else
		{
			if( !ereg( $quickexpr , $vardata ) )
				$vardata = htmlentities( $vardata );
			
			if( !get_magic_quotes_gpc() )
				$vardata = addslashes( $vardata );
		}

		return $vardata;		
	}
	
}
?>