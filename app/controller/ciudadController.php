<?php

namespace Controller;


require_once MODEL_PATH . 'ciudadModel.php';

use Model\ciudadModel;
use Lib\View;
use Lib\APPNet;
use Lib\APPUtil;

class ciudadController
{
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas"
        $this->view = new View();
        $this->model = new ciudadModel();
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
        
	$fields = array('t.IDCIUDAD',
            't.CODIGODANE',
            't.CODIGOSYS',
			't.NOMBRE',
			'ESTADO.NOMBRE AS ESTADO',
			'ESTADO.IDESTADO',
            'REGIONAL.NOMBRE AS REGIONAL',
            'REGIONAL.IDREGIONAL');
	
    $join[] = "INNER JOIN ESTADO ON ESTADO.IDESTADO = t.IDESTADO";
    $join[] = "INNER JOIN REGIONAL ON REGIONAL.IDREGIONAL = t.IDREGIONAL";

        if( empty( $sortBy ) )
            $sortBy = "NOMBRE";
	
        $list =  $this->model->getRows($fields,$join,$constrain,$sortBy,$inOrder,$page,$rows);
     
        $response["total"] = $this->model->getTotalRows();
      
        ($response["total"] == 1)? $response["rows"][] = $list : $response["rows"] = $list;

        echo  json_encode($response);
    }


    public function listAutocompleteAction()
    {
        

        $router = \Lib\Router::singleton();
        
        $id = $router->id;
     
        $response = array();
        
        $fields = array('t.IDCIUDAD',
                't.CODIGODANE',
                't.CODIGOSYS',
                't.NOMBRE',
                'ESTADO.NOMBRE AS ESTADO',
            'ESTADO.IDESTADO');
        
        $join[] = "INNER JOIN ESTADO ON ESTADO.IDESTADO = t.IDESTADO";

        $constrain = " t.IDESTADO = '" . $id . "' ";
    
        $list =  $this->model->getRows($fields,$join,$constrain,"NOMBRE",$inOrder,$page,$rows);
     

        foreach( $list as $key_ciudad => $datos_ciudad ){

            $array_ciudad["IDCIUDAD"] = $datos_ciudad["IDCIUDAD"];
            $array_ciudad["NOMBRE"] = $datos_ciudad["NOMBRE"];

            array_push($response, $array_ciudad);

        }//end for


        echo  json_encode($response);
    }
    
    public function viewAction()
    {
        $view_data = array("modDesc"=>"Parametros Sistema &raquo; Ciudad","opcDesc"=>"Ciudad"
                          );
        $this->view->show("ciudad", $view_data);
    }
 
    public function createAction()
    {
           
        $config = \Lib\Config::singleton();
    
        $response = array();
       
     //   $FechaExpDocumento = \DateTime::createFromFormat($config->get('DATE_FORMAT'), APPNet::post('FechaExpDocumento'));
    
    //    $fechaExpSQLStr = $FechaExpDocumento->format($config->get('DATE_SQLFORMAT'));
    //    $this->model->setFechaExpDocumento($fechaExpSQLStr);
    
        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
    
    
            $this->model->setIDESTADO(APPNet::post('IDESTADO'));
        	$this->model->setNOMBRE(APPNet::post('NOMBRE'));
            $this->model->setCODIGODANE(APPNet::post('CODIGODANE'));
            $this->model->setCODIGOSYS(APPNet::post('CODIGOSYS'));
            $this->model->setIDREGIONAL(APPNet::post('IDREGIONAL'));
        
        $this->model->setfechaTrCr($fechaTr);
        $this->model->setusuarioTrCr('ADMIN');
        
        $id = $this->model->insertRow();
        
        if($id ){
            $response["success"] = true;
            $response["msg"] = "Registro $id Creado Correctamente";
        }    
        else
            $response["msg"] = "Error al crear registro";
        
        echo  json_encode($response);
    
    }
    
    public function updateAction()
    {
        $config = \Lib\Config::singleton();
        $router = \Lib\Router::singleton();
        
        $id = $router->id;
    
        $response = array();
        
        $this->model->getRow($id);
       
    //    $FechaExpDocumento = \DateTime::createFromFormat($config->get('DATE_FORMAT'), APPNet::post('FechaExpDocumento'));
    
    //    $fechaExpSQLStr = $FechaExpDocumento->format($config->get('DATE_SQLFORMAT'));
    
    //    $this->model->setFechaExpDocumento($fechaExpSQLStr);
    
        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
        
            $this->model->setIDESTADO(APPNet::post('IDESTADO'));
	$this->model->setNOMBRE(APPNet::post('NOMBRE'));
    $this->model->setCODIGODANE(APPNet::post('CODIGODANE'));
    $this->model->setCODIGOSYS(APPNet::post('CODIGOSYS'));
        
        $this->model->setfechaTrEd($fechaTr);
        $this->model->setusuarioTrEd('ADMIN EDIT');
        $this->model->setIDREGIONAL(APPNet::post('IDREGIONAL'));
      
        $affectedRows = $this->model->saveRow($id);
        
        if($affectedRows ){
            $response["success"] = true;
            $response["msg"] = "Registro $id Actualizado Correctamente";
        }    
        else
            $response["msg"] = "Error al actualizar registro";
        
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