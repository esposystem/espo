<?php

namespace Controller;

require_once MODEL_PATH . 'si_cf_moduloModel.php';

use Model\si_cf_moduloModel;
use Lib\View;
use Lib\APPNet;
use Lib\APPUtil;

class si_cf_moduloController
{
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas"
        $this->view = new View();
        $this->model = new si_cf_moduloModel();
    }
 
    public function listAction()
    {
        $page = APPNet::post('page');
        $rows = APPNet::post('rows');
        $sortBy = "NOMBRE"; // APPNet::post('sort');
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
    
    public function getNodoAction()
    {
	//$config = \Lib\Config::singleton();
	$router = \Lib\Router::singleton();
	$oper = $router->id;
	 
        $response = array();

	$response = $this->model->getTreeNodo(APPNet::post('id'),$oper);
	
        echo  json_encode($response);
    }
    
   public function listAllAction()
    {
	
        $response = array();

	$response = $this->model->getTree(0,0,"");
	
        echo  json_encode($response);
    }

    public function listAllWithAction()
    {
	$router = \Lib\Router::singleton();
	
	$params = $router->id;
	$paramsArray = explode('-', $params);

        $response = array();

	$response = $this->model->getTree($paramsArray[0], $paramsArray[1], $paramsArray[2]);
	
        echo  json_encode($response);
    }
    
    public function viewAction()
    {
        $view_data = array("modDesc"=>"Modulos","opcDesc"=>""
                          );
        $this->view->show("si_cf_modulo", $view_data);
    }
 
    public function createAction()
    {
    
        $response = array();
       
	$Dependiente =	(APPNet::post('parentId')) ? 1 : 0;
	
	$this->model->setIDPADRE(APPNet::post('parentId'));
	$this->model->setNOMBRE('nuevo nodo');
	$this->model->setDEPENDIENTE($Dependiente);
           
	    $id = $this->model->insertRow();
	    
	    if($id ){
		$response['id'] = $id;
		$response['text'] = $this->model->getNOMBRE();
		$response['checked'] = "false";
		
		$response["success"] = true;
		$response["msg"] = "Nodo $id Creado Correctamente";
	    }    
	    else
		$response["msg"] = "Error al crear nodo";
	
        echo  json_encode($response);
    
    }
    
    public function updateAction()
    {
      
        $id = APPNet::post('id');
    
        $response = array();
        
 //       $this->model->getRow($id);
       
 //       $this->model->setIDPADRE(APPNet::post('parentId'));
//	$this->model->setNOMBRE(APPNet::post('text'));
//	$this->model->setPOSICION(APPNet::post('POSICION'));
//	$this->model->setDEPENDIENTE(APPNet::post('DEPENDIENTE'));
//	$this->model->setMODULO(APPNet::post('MODULO'));
//	$this->model->setDESCRIPCION(APPNet::post('DESCRIPCION'));
//	$this->model->setFILEMANUAL(APPNet::post('FILEMANUAL'));
          	    
	$affectedRows = $this->model->updateNombre($id,APPNet::post('text'));

	if($affectedRows ){
		$response["success"] = true;
		$response["msg"] = "Modulo $id Actualizado Correctamente";
	}    
	else
	    $response["msg"] = "Error al actualizar Modulo";
	
        echo  json_encode($response);
    
    }
    
    public function dragndropAction(){
	
		$id = APPNet::post('id');
		$this->model->getRow(APPNet::post('targetId'));
		
		$targetPos = $this->model->getPOSICION();
		
		$this->model->dndNodo($id, APPNet::post('targetId'), $targetPos, APPNet::post('parentId'), APPNet::post('point') );

		$node = array();
		$node['id'] = $id;
		$node['text'] = $_POST['text'];
		
		echo '{"success":true}';

    } 
    
    public function updateOperAction(){
	
		$idModulo = APPNet::post('IDM');
		
		$this->model->getRow($idModulo);
		$this->model->setMODULO(APPNet::post('modulo'));
		$this->model->setDESCRIPCION(APPNet::post('DESCRIPCION'));
		$this->model->setFILEMANUAL(APPNet::post('FILEMANUAL'));
		$this->model->setICONO(APPNet::post('ICONO'));
		$this->model->setCOMPONENTE(APPNet::post('COMPONENTE'));
		//print_r($this->model);
		
		$affectedRows = $this->model->saveRow($idModulo);
		
		$this->model->updateOper($idModulo,APPNet::post('op'));

	//	$node = array();
	//	$node['id'] = $idModulo;
	//	$node['text'] = $_POST['text'];
		
		echo '{"success":true}';

    }
    
    
    public function deleteAction(){
        
        $response = $this->model->deleteRow(APPNet::post('id'));
        
        if($response["success"])    
            $response["msg"] = "Nodo eliminado !!";
	
        
	 echo  json_encode($response);
       
    }

}