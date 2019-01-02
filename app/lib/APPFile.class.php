<?php
namespace Lib;
use \Lib\APPResources;

class APPFile
{	

	static $SEPARADOR = "_";
	
	static function write( $name , $content )
	{
		if( !is_writable( $name ) ) return false;
		
		if( file_exists( $name ) )
			$filep = @fopen( $name , 'a' );
		else
			$filep = @fopen( $name , 'w' );
			
		if( @fwrite( $filep , $content ) )
			return true;
		else
			return false;
		
		fclose( $filep );
	}
	
	static function delete( $name )
	{
		return unlink( $name );
	}
	
	static function getFileData( $archivo )
	{
		return pathinfo( $archivo );
	}
	
	static function getExtension( $archivo )
	{
		$pathinfo = pathinfo( $archivo );
	
		return $pathinfo["extension"];
	}

	static function getName( $archivo )
	{
		$pathinfo = pathinfo( $archivo );
	
		return $pathinfo["basename"];
	}
	
	static function getPathName( $archivo )
	{
		$pathinfo = pathinfo( $archivo );
	
		return $pathinfo["dirname"];
	}

	static function getSize( $file )
	{
	
		$size = filesize( $file );
	
		$sizes = Array(' Bytes', ' Kbs', ' Mbs', 'Gbs', 'Tbs', 'Pbs', 'Ebs');
	
		$ext = $sizes[0];
	
		for ( $i = 1 ; ($i < count( $sizes ) && $size >= 1024 ) ; $i++ )
		{
			$size = $size / 1024;
			$ext  = $sizes[ $i ];
		}
	
		clearstatcache();
	
		return round( $size , 2 ) . $ext;
	}
	
	static function isMIMEValid( $mimetype )
	{
		return in_array( $mimetype , APPResources::$mimeValidos );
	}
	
	static function isMIMEImageValid( $mimetype )
	{
		
		return in_array( $mimetype , APPResources::$mimeImagenValidos );
	}
	
	static function isMIMEDocValid( $mimetype )
	{
		return in_array( $mimetype , APPResources::$mimeDocsValidos );
	}
	
	static function isMIMEVideoValid( $mimetype )
	{
		return in_array( $mimetype , APPResources::$mimeVideoValidos );
	}
	
	static function isMIMEGraphValid( $mimetype )
	{
		return in_array( $mimetype , APPResources::$mimeGraficoValidos );
	}
	
	static function makeSure( $filename )
	{
		return preg_replace( "/([^a-z0-9\.])/i" , "_" , $filename );
	}
	
	public static function upload( $files_req , $destination , $validation = "ALL" )
	{
		$file_result = array();
		//datos del archivo a devolver
		$file_data = false;
		
		//flag de validacion
		$ismimevalid = false;
		
		//url temporal de destino para usar en el bucle
		$tmp_dest = "";
		
		if( !isset( $files_req[0] ) )
			$files[0] =  $files_req;
		else
			$files = $files_req;			
		
	
		foreach( $files as $nombre => $archivo )
		{
			switch( $validation )
			{
				case "IMAGE":
					$ismimevalid = self::isMIMEImageValid( $archivo['type'] );
				break;
				case "DOC":
					$ismimevalid = self::isMIMEDocValid( $archivo['type'] );
				break;
				case "VIDEO":
					$ismimevalid = self::isMIMEVideoValid( $archivo['type']);
				break;
				case "GRAPH":
					$ismimevalid = self::isMIMEGraphValid( $archivo['type'] );
				break;			
				default:
					$ismimevalid = self::isMIMEValid( $archivo['type'] );
				break;
			}			
			if( !$archivo['error'] && $ismimevalid )
			{
				
				$safename = self::makeSure( $archivo['name'] );
			
				$innername = self::makeInner($safename);
			
			//	echo "copiar ".$destination . $innername;
					
				if( move_uploaded_file( $archivo['tmp_name'] , $destination . $innername ) )
				{
					//if( !is_array( $file_result ) ) $file_result = array();
										
					$file_data = array( "name" => $safename, "innername" => $innername , "origname" => $archivo["name"] , "size" => $archivo["size"] , "type" => $archivo["type"] );
					
					if($validation == "IMAGE"){
						$imgdata = getimagesize($destination . $innername);
						$file_data["width"] = $imgdata[0];
						$file_data["height"] =  $imgdata[1];
					}
					
					$file_result[]  = $file_data;
				}else {		
					$file_result='fallocopy';
				}
					
			}
			else if($archivo['tmp_name']!=''){				
				$file_result='false';				
			}
		}	
		
			
		return $file_result;
	}
	
	static function makeInner( $filename )
	{
		$startwith = (string)rand(1001,9999);		
		return $startwith . APPFile::$SEPARADOR . $filename;
	}

	static function download( $file , $filename )
	{
		// BEGIN extra headers to resolve IE caching bug (JRP 9 Feb 2003)
		// [http://bugs.php.net/bug.php?id=16173]
		header("Pragma: ");
		header("Cache-Control: ");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		
		//	header("Cache-Control: no-store, no-cache, must-revalidate");  
		//HTTP/1.1
		//	header("Cache-Control: post-check=0, pre-check=0", false);
		// END extra headers to resolve IE caching bug
		
		header("Content-Length: ".filesize($filename)); 
		header("Content-Type: $file->FileType");
	 	header("Content-Disposition: attachment; filename={$file->File}"); 
	
		readfile( $filename );
		
		return true;
	}
	
	static function makeDir( $dir_name )
	{
		if( !mkdir( $dir_name , 0755 ) )
			return false;
		else
			chmod($dir_name,0757);
		
		return true;
	}
	
	/*** Valida el directorio de almacenamiento de archivo si no existe lo crea /aaaa/mm   a�o mes
	
	*****/
	
	
	static function valSaveDir($dirDoc,$dateStr){
		
		//$dateStr = (new \DateTime())->format('Ym');
		
		 $dirYear = substr($dateStr,0,4);
		 $dirMonth = substr($dateStr,5,2);
		
		if (!file_exists($dirDoc.'/'.$dirYear)) {
		    if(!mkdir($dirDoc.'/'.$dirYear, 0777, true)) {
			die('Fallo al crear las directorio '.$dirDoc.'/'.$dirYear);
		    }
		}
		
		if(!file_exists($dirDoc.'/'.$dirYear.'/'.$dirMonth)) { 
		     if(!mkdir($dirDoc.'/'.$dirYear.'/'.$dirMonth, 0777, true)) {
			die('Fallo al crear las directorio '.$dirDoc.'/'.$dirYear.'/'.$dirMonth);
		    }
		}
	
	
		return $dirYear.'/'.$dirMonth.'/';		
	}

	static function listDir( $dirname )
	{ 
		if( $dirname[ strlen( $dirname ) - 1 ] != "/" )
			$dirname.="/";
		
		$result_array = array();
		
		$mode = fileperms($dirname);
		
		if( ( $mode & 0x4000 ) == 0x4000 && ( $mode & 0x00004 ) == 0x00004)
		{ 
			chdir( $dirname ); 
			$handle = @opendir( $dirname) ;
		}
		
		if( isset( $handle ) )
		{
			while ( $file = readdir( $handle ) )
			{
				if( $file == '.' || $file == '..' ) 
					continue; 
				
				if( is_file( $dirname . $file ) ) 
					$result_array[] = $file;
			} 
			
			closedir( $handle );
		} 
		return $result_array;
	}
	
	// Genera un codigo HASH sha256 para los documentos de la Petici�n
	// Parametros : Fecha Hora Transacci�n aaaa-mm-dd hh:mm:ss
	
	static function createHash($fechaTr){
		
		$ano = substr($fechaTr,0,4);
		$mes = substr($fechaTr,5,2);
		$dia = substr($fechaTr,8,2);
	        $hash = substr(hash("sha256",uniqid($fechaTr)),0,6);
		
		return sprintf("%4s%02d%02d%6s",$ano,$mes,$dia,$hash);
		
	} // md5(uniqid($fechaTr))
	
	// Genera un codigo HASH sha256 para los archivos cargados en el sistema segun su contenido
	// Parametros : $path_file
	static function createHashFile($path_file){
	
		return hash_file('sha256', $path_file);
		
	} // md5(uniqid($fechaTr))
}
?>