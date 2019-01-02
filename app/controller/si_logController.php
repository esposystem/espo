<?php

namespace Controller;

require_once MODEL_PATH . 'si_logModel.php';

use Model\si_logModel;
use Lib\View;
use Lib\APPNet;
use Lib\APPUtil;

class si_logController
{
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas"
        $this->view = new View();
        $this->model = new si_logModel();
    }
 
    public function listAction()
    {
        $page = APPNet::post('page');
        $rows = APPNet::post('rows');
        $sortBy = "Fecha";//APPNet::post('sort');
        $inOrder =  "DESC";// APPNet::post('order');
        $filterRules  = APPNet::getParam('filterRules');
        $array_filterRules=json_decode($filterRules);   
        $constrain='';
        foreach($array_filterRules as $obj){        
                $value=$obj->value;     
                if($obj->field=='Usuario' && $value!='')
                {            
                    $constrain = "USUARIO.PRIMERNOMBRE like '%$value%' OR USUARIO.SEGUNDONOMBRE like '%$value%' OR USUARIO.PRIMERAPELLIDO like '%$value%' OR USUARIO.SEGUNDOAPELLIDO like '%$value%' ";           
                }
                else if ($obj->field=='Fecha' && $value!=''){
                    $constrain = "  t.Fecha >CONVERT(datetime,'$value',120)";
                }
        }
        if($constrain==''){
                $constrain = APPUtil::filterFromJson($filterRules);    
        }     
        $response = array();       
        $fields = array('t.IDLog','t.Fecha','t.Transaccion','t.Operacion','t.DireccionIP','t.Tabla',
			'CONCAT (USUARIO.PRIMERAPELLIDO,\' \',USUARIO.SEGUNDOAPELLIDO,\' \',USUARIO.PRIMERNOMBRE) AS Usuario',
			'SI_CF_MODULO.NOMBRE AS Modulo',
			'SI_CF_MODULO.IDMODULO AS IDModulo');
	
        $join = array("LEFT JOIN USUARIO  ON USUARIO.IDUSUARIO = t.IDUSUARIO",
		      "LEFT JOIN SI_CF_MODULO  ON SI_CF_MODULO.IDMODULO = t.IDMODULO");
	
	
	
        $list =  $this->model->getRows($fields,$join,$constrain,$sortBy,$inOrder,$page,$rows);
     
        $response["total"] = $this->model->getTotalRows();
      
        $response["rows"] = $list;

        echo  json_encode($response);
    }
    
    public function viewAction()
    {
        $view_data = array("modDesc"=>"Log Del Sistema","opcDesc"=>""
                          );
        $this->view->show("si_log", $view_data);
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
    
    public function updateAction()
    {
        $config = \Lib\Config::singleton();
        $router = \Lib\Router::singleton();
        
        $id = $router->id;
    
        $response = array();
        
        $this->model->getRow($id);
       
        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
        
         	$this->model->setIDModulo(APPNet::post('IDModulo'));
	$this->model->setIDUsuario(APPNet::post('IDUsuario'));
	$this->model->setFecha(APPNet::post('Fecha'));
	$this->model->setTabla(APPNet::post('Tabla'));
	$this->model->setTransaccion(APPNet::post('Transaccion'));
	$this->model->setOperacion(APPNet::post('Operacion'));
	$this->model->setDireccionIP(APPNet::post('DireccionIP'));
        
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