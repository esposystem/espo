<?php

namespace Controller;

require_once MODEL_PATH . 'io_cf_parametroModel.php';

use Model\io_cf_parametroModel;
use Lib\View;
use Lib\APPNet;
use Lib\APPUtil;

class io_cf_parametroController
{
    function __construct()
    {
        $this->view = new View();
        $this->model = new io_cf_parametroModel();
    }
 
    public function listAction()
    {
        $page = APPNet::post('page');
        $rows = APPNet::post('rows');
        $sortBy = APPNet::post('sort');
        $inOrder = APPNet::post('order');
        $filterRules  = APPNet::getParam('filterRules');
       
        $constrain = APPUtil::filterFromJson($filterRules);
        
        $response = array();
        
        $fields = array('t.*');
        $join = array();
        $list =  $this->model->getRows($fields,$join,$constrain,$sortBy,$inOrder,$page,$rows);
     
        $response["total"] = $this->model->getTotalRows();
      
        $response["rows"] = $list;

        echo  json_encode($response);
    }
    
    public function viewAction()
    {
        $view_data = array("modDesc"=>"","opcDesc"=>""
                          );
        $this->view->show("io_cf_parametro", $view_data);
    }
 
    public function createAction()
    {
           
        $config = \Lib\Config::singleton();
    
        $response = array();
    
        $this->model->setIDPARAMETRO(APPNet::post('IDPARAMETRO'));
	$this->model->setVALOR(APPNet::post('VALOR'));
	$this->model->setDESCRIPCION(APPNet::post('DESCRIPCION'));
	$this->model->setESTADO(ucfirst(strtolower(APPNet::post('ESTADO'))));
        
        $formValid = APPUtil::validate(APPNet::allPost(),$this->model->getNotNullFields());
	
	$isUniqueData = $this->model->isValidUnique();
	
	if($formValid["success"] && $isUniqueData["success"]){
	    
	    $id = $this->model->insertRow();
	    
	    if($id ){
		$response["success"] = true;
		$response["msg"] = " $id Creado Correctamente";
	    }    
	    else
		$response["msg"] = "Error al crear registro";
	}
	else
	    $response["msg"] = $formValid["msg"].$isUniqueData["msg"];
	
        
        echo  json_encode($response);
    
    }
    
    public function updateAction()
    {
        $config = \Lib\Config::singleton();
        $router = \Lib\Router::singleton();
        
        $id = $router->id;
    
        $response = array();
        
        $this->model->getRow($id);
         
         	$this->model->setIDPARAMETRO(APPNet::post('IDPARAMETRO'));
	$this->model->setVALOR(APPNet::post('VALOR'));
	$this->model->setDESCRIPCION(APPNet::post('DESCRIPCION'));
	$this->model->setESTADO(ucfirst(strtolower(APPNet::post('ESTADO'))));
            
        $formValid = APPUtil::validate(APPNet::allPost(),$this->model->getNotNullFields());
	
	$isUniqueData = $this->model->isValidUnique($id);
	
	if($formValid["success"] && $isUniqueData["success"]){
	    
	     $affectedRows = $this->model->saveRow($id);
	    
	    if($affectedRows ){
		$response["success"] = true;
		$response["msg"] = " $id Actualizado Correctamente";
	    }    
	    else
		$response["msg"] = "Error al actualizar ";
	}
	else
	    $response["msg"] = $formValid["msg"].$isUniqueData["msg"];
	
        echo  json_encode($response);
    
    }
    
}