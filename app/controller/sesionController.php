<?php

namespace Controller;

require_once MODEL_PATH . 'sesionModel.php';
require_once MODEL_PATH . 'usuarioModel.php';

//use Model\sesionModel;
//use Lib\View;
//use Lib\APPNet;
//use Lib\APPUtil;

class sesionController
{
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas"
        $this->view = new View();
        $this->model = new sesionModel();
    }
  
    public function createAction()
    {
           
        $config = \Lib\Config::singleton();
    
        $response = array();
        
	$docModel = new \Model\pt_documentoModel();
	$usuarioModel = new \Model\pt_documentoModel();
	
        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
    
    
        $this->model->setIDUSUARIO(APPNet::post('login'));
	$this->model->setINICIO(APPNet::post('clave'));
	 
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
        
         	$this->model->setIDUSUARIO(APPNet::post('IDUSUARIO'));
	$this->model->setINICIO(APPNet::post('INICIO'));
	$this->model->setDATOS(APPNet::post('DATOS'));
        
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