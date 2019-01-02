<?php

namespace Controller;

require_once MODEL_PATH . 'si_cf_perfilModel.php';

use Model\si_cf_perfilModel;
use Lib\View;
use Lib\APPNet;
use Lib\APPUtil;

class si_cf_perfilController
{
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas"
        $this->view = new View();
        $this->model = new si_cf_perfilModel();
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
    $config = \Lib\Config::singleton();
    
    $response = array();
    $idPerfil = "";
     $response = $this->model->getTree(0,$idPerfil);
    
        echo  json_encode($response);
    }

    public function listAllWithAction()
    {
        
        $router = \Lib\Router::singleton();
        
        $params = $router->id;
        $paramsArray = explode('-', $params);

            $response = array();

        $response = $this->model->getTree($paramsArray[0], $paramsArray[1]);
    
        echo  json_encode($response);
    }

    public function updateOperAction(){
    
        //$id = APPNet::post('IDP');
        $router = \Lib\Router::singleton();
        $id = $router->id;
        $this->model->setIDPERFIL($id);
        $this->model->getRow($id);

        //print_r($this);
        
        //$targetPos = $this->model->getPOSICION();
        
        $this->model->updateOper(APPNet::post('isopr'));

        echo '{"success":true}';

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
        $view_data = array("modDesc"=>"Administraci&oacute;n de Perfiles","opcDesc"=>""
                          );
        $this->view->show("si_cf_perfil", $view_data);
    }
 
    public function createAction()
    {
           
        $config = \Lib\Config::singleton();
    
        $response = array();

        $Dependiente =  (APPNet::post('parentId')) ? 1 : 0;

        $id_padre =  (APPNet::post('parentId')) ? APPNet::post('parentId') : 0;
           
      //  $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
    
        	$this->model->setIDPADRE($id_padre);
	        $this->model->setNOMBRE('nuevo perfil');
	        $this->model->setPOSICION('ifnull(max(Posicion)+1, 1)');
	        $this->model->setDEPENDIENTE($Dependiente);
	//$this->model->setDESCRIPCION(APPNet::post('DESCRIPCION'));
        
        //$this->model->setfechaTrCr($fechaTr);

        //$this->model->setusuarioTrCr('ADMIN');

        $id = $this->model->insertRow();
        
        if($id ){
	    $response['id'] = $id;
	    $response['text'] = $this->model->getNOMBRE();
	    $response['checked'] = "false";
	    
	    $response["success"] = true;
	    $response["msg"] = "Perfil $id Creado Correctamente";
        }    
        else
	    $response["msg"] = "Error al crear nodo";
    
        echo  json_encode($response);
        
        /*$formValid = APPUtil::validate(APPNet::allPost(),$this->model->getNotNullFields());
	
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
	
        
        echo  json_encode($response);*/
    
    }
    
    public function updateAction()
    {
        $config = \Lib\Config::singleton();
     //   $router = \Lib\Router::singleton();
        
        $id = APPNet::post('id');
    
        $response = array();
       
	 if($id){
	  
	    $this->model->getRow($id);
	
	 
	    $this->model->setNOMBRE(APPNet::post('text'));
	
	    $isUniqueData = $this->model->isValidUnique();
	    
	    if($isUniqueData["success"]){
	    
		$affectedRows = $this->model->saveRow($id);
	       
		if($affectedRows ){
		   $response["success"] = true;
		   $response["msg"] = "Perfil $id Actualizado Correctamente";
		}    
		else
		   $response["msg"] = "Error al actualizar Perfil";
	    }
        }
	else
	    $response["msg"] = "Error al actualizar Perfil";
	
//	$this->model->setPOSICION(APPNet::post('POSICION'));
//	$this->model->setDEPENDIENTE(APPNet::post('DEPENDIENTE'));
//	$this->model->setDESCRIPCION(APPNet::post('DESCRIPCION'));
        
      //  $this->model->setfechaTrEd($fechaTr);
      //  $this->model->setusuarioTrEd('ADMIN EDIT');
          
    /*    $formValid = APPUtil::validate(APPNet::allPost(),$this->model->getNotNullFields());
	
	$isUniqueData = $this->model->isValidUnique($id);
	
	if($formValid["success"] && $isUniqueData["success"]){
	    
	     $affectedRows = $this->model->saveRow($id);
	    
	    if($affectedRows ){
		$response["success"] = true;
		$response["msg"] = "Perfil $id Actualizado Correctamente";
	    }    
	    else
		$response["msg"] = "Error al actualizar registro";
	}
	else
	    $response["msg"] = $formValid["msg"].$isUniqueData["msg"];
	*/
    
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