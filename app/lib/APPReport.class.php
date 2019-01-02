<?
//namespace Lib;

require_once LIB_PATH.'APPPHPExcel.inc.php';

class APPReport {
	
	function export2xls($DB_TBLName,$sql=""){
	
		$now_date = date('m-d-Y H:i');
		
		$result = db_query($sql);
		
		$title = "Datos Tabla $DB_TBLName Fecha $now_date";
		
		$file_type = "vnd.ms-excel";
		$file_ending = "xls";
		
		header("Content-Type: application/$file_type");
		header("Content-Disposition: attachment; filename=$DB_TBLName.$file_ending");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo("$title\n");
		
		//define separator (defines columns in excel & tabs in word)
		$sep = "\t"; //tabbed character
		
		//start of printing column names as names of MySQL fields
		for ($i = 0; $i < db_num_fields($result); $i++) {
			echo db_field_name($result,$i) . "\t";
		}
		print("\n");
		//end of printing column names
		
		//start while loop to get data
		
		    while($row = db_fetch_row($result))
		    {
			//set_time_limit(60); // HaRa
			$schema_insert = "";
			for($j=0; $j < db_num_fields($result);$j++)
			{
			    if(!isset($row[$j]))
				$schema_insert .= "NULL".$sep;
			    elseif ($row[$j] != "")
				$schema_insert .= "$row[$j]".$sep;
			    else
				$schema_insert .= "".$sep;
			}
			$schema_insert = str_replace($sep."$", "", $schema_insert);
				//this corrects output in excel when table fields contain \n or \r
				//these two characters are now replaced with a space
				$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
			$schema_insert .= "\t";
			print(trim($schema_insert));
			print "\n";
		    }
	
	} // End function
	
	function exportPHPXLS($colname, $datos, $nombreArchivo = 'exportar',$file,$download=""){ 
	
	//echo "exportPHPXLS";
		/*$rutaXLSLib = 'PHPExcel.php'; 
		
		if(is_readable($rutaXLSLib)){ 
			require_once $rutaXLSLib; 
		} 
		else{
			echo 'Error de librer’a PHPExcel'; 
			exit; 
		}*/
	
	//print_r(get_declared_classes() );
	
		$objPHPExcel = new \PHPExcel();   
		
		$objPHPExcel->getProperties()
			->setCreator("EJECURED")
			->setTitle($nombreArchivo)
			->setSubject("Datos ".$nombreArchivo)
			->setDescription("GeneradoPHPExcel");
		
		
		$objPHPExcel->setActiveSheetIndex(0);
		
		//Imprimo los t’tulos de cada columna
		$rowCount = 1;
		
		$column = 'A';
		
		foreach ($colname as $valor){ 
			$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, trim($valor)); 
			$column++;	 
		}   
		
		//Imprimo los datos en cada columan por fila
		
		$rowCount = 2;
		
		//print_r($datos);
	
		
		for($i=0; $i< count($datos); $i++){
		
			$column = 'A';
			
			foreach($datos[$i] as $valor){
			
				//echo $valor;
				
				if (!isset($valor)){
					$valor = NULL;
				}
				elseif($valor != ""){ 
					$valor = strip_tags($valor); 
				} else {
					$valor = '';
				}   
				
				$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $valor); 
				
				$column++;
			 }
			 
			$rowCount++;
			
		}   //Salida por pantalla del archivo (ver mas opciones en la documentaci—n de la librer’a) 
	
		$objPHPExcel->getActiveSheet()->setTitle($nombreArchivo); 
		
		//header('Content-Type: application/vnd.ms-excel'); 
		//header('Content-Disposition: attachment;filename="exportar.xls"'); 
		//header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		$objWriter->save($file);
		
		return;	
	}
	
	function exportSQL_PHPXLS($reportTitle, $sqlArray, $fileName = 'exportar',$filePath,$download){ 
	
		$rutaXLSLib = 'PHPExcel.php'; 
		
		if(is_readable($rutaXLSLib)){ 
			require_once $rutaXLSLib; 
		} 
		else{
			echo 'Error de librer’a PHPExcel'; 
			exit; 
		}
		
		$reportTitle = "Reporte -  $reportTitle Fecha ".date('m-d-Y H:i');
		
		$objPHPExcel = new PHPExcel();   
		
		$objPHPExcel->getProperties()
			->setCreator("FENIX")
			->setLastModifiedBy("FENIX Fabiosan")
			->setTitle($reportTitle)
			->setSubject("Ejemplo 1")
			->setDescription("Documento generado con PHPExcel");
		
		$sheetIndex = 0;
		
	
		foreach($sqlArray AS $tablename => $sql){
			
			$result = db_query($sql);
		
			 $objPHPExcel->createSheet($sheetIndex);
			$objPHPExcel->setActiveSheetIndex($sheetIndex);
			$objPHPExcel->getActiveSheet()->setTitle($tablename); 
			
			//Imprimo los t’tulos de cada columna
			$rowCount = 1;
			$column = 0;
			
			$sheetData = array();
			
			for ($i = 0; $i < db_num_fields($result); $i++) {
				
				$sheetData[0][$i] = trim(db_field_name($result,$i));
				
			//	$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, trim(db_field_name($result,$i))); 
				
			//	$column++;	
			}
			
			$rowCount = 1;
			
			 while($row = db_fetch_array($result,MYSQL_NUM)){
				
				$sheetData[$rowCount] = $row;
				
				
				//$column = 'A';
				
				// $strfield = preg_replace("/\r\n|\n\r|\n|\r/", " ", $row[$j]);
				
				//$row_data = array_map("clear_string",$row_data);
					
				//for($j=0; $j < db_num_fields($result);$j++){
				
					//$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $strfield); 
					
				//	$column++;	
				//}
				
				$rowCount++;	
			} // end while
			
			$objPHPExcel->getActiveSheet()->fromArray($sheetData);
				
			unset($sheetData);
				
			//	echo "CREADA HOJA : $sheetIndex FILAS : $rowCount COLUMNA : $column";
				
			$sheetIndex++;
			
		} // foreach sql
		
		//echo $filePath;
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
	//	ob_end_clean();
	  //      ob_start();
				
		if($download){
			
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$fileName");
			header("Pragma: no-cache");
			header("Expires: 0");
			
			$filePath = 'php://output';
		}
		
		
		
		$objWriter->save($filePath);   
	
		return;	
	}

}