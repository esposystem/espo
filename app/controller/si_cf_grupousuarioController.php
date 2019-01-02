<?php

namespace Controller;

require_once MODEL_PATH . 'si_cf_grupousuarioModel.php';

use Model\si_cf_grupousuarioModel;
use Lib\View;
use Lib\APPNet;
use Lib\APPUtil;

class si_cf_grupousuarioController
{
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas"
        $this->view = new View();
        $this->model = new si_cf_grupousuarioModel();
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
        $this->view->show("si_cf_grupousuario", $view_data);
    }

    public function getGrupoAction()
    {
        $IDGrupo = APPNet::post('IDGrupo');
       
        $list =  $this->model->getGrupo($IDGrupo);

        echo  json_encode($list);
    }

    public function getGruposUsrAction()
    {
	$router = \Lib\Router::singleton();
        
        $idUsuario = $router->id;
	
        $list =  $this->model->getGruposUsr($idUsuario);
	

        echo  json_encode($list);
    }
    
    public function updateGruposAction()
    {
	$router = \Lib\Router::singleton();
        
	$idUsuario = $router->id;
		
	$gruposList = explode(",",APPNet::post('grupos'));
	
        $list =  $this->model->setGruposUsr($idUsuario,$gruposList);

        echo  json_encode($list);
    }
    
    public function delAction()
    {
        $IDGrupo = APPNet::post('IDGrupo');
        $IDUsuario = APPNet::post('IDUsuario');
       
        $list =  $this->model->del($IDGrupo, $IDUsuario);

        echo  json_encode($list);
    }

    public function addAction()
    {
        /*$IDGrupo = APPNet::post('IDGrupo');
        $IDUsuario = APPNet::post('IDUsuario');
        $Nombre = APPNet::post('Nombre');

        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
        $this->model->setfechaTrCr($fechaTr);
        $this->model->setusuarioTrCr('ADMIN');
       
        $list =  $this->model->add($IDGrupo, $IDUsuario, $Nombre);

        echo  json_encode($list);*/

    }
 
    public function createAction()
    {
           
        $config = \Lib\Config::singleton();
    
        $response = array();
           
        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
    
    
        	$this->model->setIDGRUPO(APPNet::post('IDGRUPO'));
	$this->model->setIDUSUARIO(APPNet::post('IDUSUARIO'));
	$this->model->setNOMBRE(APPNet::post('NOMBRE'));
        
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
    
    public function updateAction()
    {
        $config = \Lib\Config::singleton();
        $router = \Lib\Router::singleton();
        
        $id = $router->id;
    
        $response = array();
        
        $this->model->getRow($id);
       
        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
        
         	$this->model->setIDGRUPO(APPNet::post('IDGRUPO'));
	$this->model->setIDUSUARIO(APPNet::post('IDUSUARIO'));
	$this->model->setNOMBRE(APPNet::post('NOMBRE'));
        
        $this->model->setfechaTrEd($fechaTr);
        $this->model->setusuarioTrEd('ADMIN EDIT');
          
        $formValid = APPUtil::validate(APPNet::allPost(),$this->model->getNotNullFields());
	
	$isUniqueData = $this->model->isValidUnique($id);
	
	if($formValid["success"] && $isUniqueData["success"]){
	    
	     $affectedRows = $this->model->saveRow($id);
	    
	    if($affectedRows ){
		$response["success"] = true;
		$response["msg"] = "Registro $id Actualizado Correctamente";
	    }    
	    else
		$response["msg"] = "Error al actualizar registro";
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