<?php

namespace Controller;

require_once MODEL_PATH . 'usuarioModel.php';

use Model\usuarioModel;
use Lib\View;
use Lib\APPNet;
use Lib\APPUtil;

class usuarioController
{
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas"
        $this->view = new View();
        $this->model = new usuarioModel();
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
        $view_data = array("modDesc"=>"Configuraci&oacute;n de Sistema &raquo; Usuario","opcDesc"=>"Usuario");
        $this->view->show("usuario", $view_data);
    }
 
    public function createAction()
    {
           
        $config = \Lib\Config::singleton();
    
        $response = array();
           
        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
    
    	$this->model->setNUMEROIDENTIFICACION(APPNet::post('NUMEROIDENTIFICACION'));
    	$this->model->setPRIMERNOMBRE(APPNet::post('PRIMERNOMBRE'));
    	$this->model->setSEGUNDONOMBRE(APPNet::post('SEGUNDONOMBRE'));
    	$this->model->setPRIMERAPELLIDO(APPNet::post('PRIMERAPELLIDO'));
    	$this->model->setSEGUNDOAPELLIDO(APPNet::post('SEGUNDOAPELLIDO'));
    	$this->model->setTELEFONO(APPNet::post('TELEFONO'));
        $this->model->setUSUARIO(APPNet::post('USUARIO'));
    	$this->model->setEMAIL(APPNet::post('EMAIL'));
        $this->model->setPASSWORD(APPNet::post('PASSWORD'));
        $this->model->setAUTORIZADO("S");
        $this->model->setULTIMOINGRESO(APPNet::post('ULTIMOINGRESO'));
        $this->model->setVIGENCIA(APPNet::post('VIGENCIA'));
    	$this->model->setESTADO(ucfirst(strtolower(APPNet::post('ESTADO'))));
        
        $this->model->setfechaTrCr($fechaTr);
        $this->model->setusuarioTrCr('ADMIN');

        $this->model->setfechaTrEd($fechaTr);
        $this->model->setusuarioTrEd('ADMIN');
        
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
        
	$this->model->setNUMEROIDENTIFICACION(APPNet::post('NUMEROIDENTIFICACION'));
	$this->model->setPRIMERNOMBRE(APPNet::post('PRIMERNOMBRE'));
	$this->model->setSEGUNDONOMBRE(APPNet::post('SEGUNDONOMBRE'));
	$this->model->setPRIMERAPELLIDO(APPNet::post('PRIMERAPELLIDO'));
	$this->model->setSEGUNDOAPELLIDO(APPNet::post('SEGUNDOAPELLIDO'));
	$this->model->setTELEFONO(APPNet::post('TELEFONO'));

    $this->model->setUSUARIO(APPNet::post('USUARIO'));
	$this->model->setEMAIL(APPNet::post('EMAIL'));
    //04/05/2016
    //Gonzalo J Perez
    //Cada vez que se actualiza un usuario cambia la clave
    $PASSWORD=APPNet::post('PASSWORD');
    $PASSWORD_old=APPNet::post('PASSWORD_send');
    if(!empty($PASSWORD)){
        $this->model->setPASSWORD($PASSWORD);
    }
    else{
        $this->model->setPASSWORD2($PASSWORD_old);
    }

    $this->model->setAUTORIZADO(APPNet::post('AUTORIZADO'));
    $this->model->setULTIMOINGRESO(APPNet::post('ULTIMOINGRESO'));

	
    $this->model->setVIGENCIA(APPNet::post('VIGENCIA'));
	$this->model->setESTADO(ucfirst(strtolower(APPNet::post('ESTADO'))));
        
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