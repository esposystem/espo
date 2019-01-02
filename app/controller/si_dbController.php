<?php

namespace Controller;

require_once LIB_PATH.'APPReport.class.php';
 
//require_once LIB_PATH.'APPReport.class.php';

use Lib\APPDbo;
use Lib\View;
use Lib\APPNet;
//use Lib\APPReport;

class si_dbController
{
    protected $db;
    
    function __construct()
    {
	
	$this->db = new APPDbo();
        $this->view = new View();
    }
 
    public function listAction()
    {
	$r_table = $this->db->getTableList();
	
	$cont = 0;
	
	foreach($r_table AS $tableName){
	    $response[] = array(
			"id" => $tableName["name"],
		       "text" => $tableName["name"]
			 );
	}
	
        echo  json_encode($response);
    }
    
    public function tableStructAction()
    {
	$router = \Lib\Router::singleton();
        
        $table = $router->id;
	
	$r_table = $this->db->ColumnInfo($table);
	
	//print_r($r_table);
	
	$cont = 0;
	
	/*foreach($r_table AS $tableName){
	    $response[] = array(
			"id" => $tableName["name"],
		       "text" => $tableName["name"]
			 );
	}*/
	
	$response["total"] = count($r_table);
      
        $response["rows"] = $r_table;

        echo  json_encode($response);
	
    }
    
    public function exportAction()
    {
	
	$router = \Lib\Router::singleton();
        
	$tableName = $router->id;
	
	//print_r(get_declared_classes() );
	
	$fieldList = explode(",",APPNet::post('isopr'));
	
	if(count($fieldList) > 0){
	    
	    $config = \Lib\Config::singleton();
	    
	    $DIR_REPORTE = $config->get('DIR_REPORTE');	

	    $userData = $config->get('SESSION_DATA');
	    
	    $filename = $tableName.$userData['USUARIO'].".xls";
	    
	    $list = $this->db->fetchAll($tableName,$fieldList,"","","","","array");
      
	   // print_r($list);
	    \APPReport::exportPHPXLS($fieldList, $list,'exportar',$DIR_REPORTE.$filename,TRUE);
	
	    $response["success"] = TRUE;
	    $response["msg"] = '<a href="/app/si_db/download/'.$filename.'" >Click aqui para descargar Archivo</a>';
					
	}
	else
	    $response["success"] = FALSE;
	
      //  $response["campos"] = TRUE;
	
        echo  json_encode($response);
       
    }
    
    public function downloadAction()
    {
        $config = \Lib\Config::singleton();
        $router = \Lib\Router::singleton();
	
	$DIR_REPORTE = $config->get('DIR_REPORTE');	
        
	//$dataFile = $this->model->getFields(array('t.CODIGOHASH'),$router->id);
	
	$fileName = $router->id;
	$filePath = $DIR_REPORTE.$fileName;
	
	
	header("Pragma: ");
	header("Cache-Control: ");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	
	header("Content-Length: ".filesize($filePath));  // filesize($file)
	header("Content-Type: application/pdf");
	
       	header("Content-Disposition: attachment; filename=".$fileName.""); 

	readfile($filePath);
   
    }

    
    public function viewAction()
    {
        $view_data = array("modDesc"=>"Base de Datos","opcDesc"=>""
                          );
        $this->view->show("si_db", $view_data);
    }
 
    public function createAction()
    {
           
        $config = \Lib\Config::singleton();
    
        $response = array();
           
        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
    
        $this->model->setIDModulo(APPNet::post('IDModulo'));
	$this->model->setIDUsuario(APPNet::post('IDUsuario'));
	$this->model->setFecha(APPNet::post('Fecha'));
	$this->model->setTabla(APPNet::post('Tabla'));
	$this->model->setTransaccion(APPNet::post('Transaccion'));
	$this->model->setOperacion(APPNet::post('Operacion'));
	$this->model->setDireccionIP(APPNet::post('DireccionIP'));
        
        $this->model->setfechaTrCr($fechaTr);
        $this->model->setusuarioTrCr('ADMIN');
        
        $formValid = APPUtil::validate(APPNet::allPost(),$this->model->getNotNullFields());
	
	$isUniqueData = $this->model->isValidUnique();
	
	if($formValid["success"] && $isUniqueData["success"]){
	    
	    $id = $this->model->insertRow();
	    
	    if($id ){
		$response["success"] = true;
		$response["msg"] = "Registro $id Creado Correctamente";
	    }    
	    else
		$response["msg"] = "Error al crear registro";
	}
	else
	    $response["msg"] = $formValid["msg"].$isUniqueData["msg"];
	
        
        echo  json_encode($response);
    
    }
        
    public function deleteAction(){
        
         $numAffected = $this->model->deleteRow(APPNet::post('id'));
        
        if($numAffected){
            $response["success"] = true;
            $response["msg"] = " $numAffected Registro(s) Eliminado Correctamente";
        }    
        else
            $response["msg"] = "Error al crear registro";
        
        echo  json_encode($response);
        
    }

}