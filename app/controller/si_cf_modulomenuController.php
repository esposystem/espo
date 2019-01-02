<?php

namespace Controller;

require_once MODEL_PATH . 'si_cf_modulomenuModel.php';

use Model\si_cf_modulomenuModel;
use Lib\View;
use Lib\APPNet;
use Lib\APPUtil;

class si_cf_modulomenuController
{
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas"
        $this->view = new View();
        $this->model = new si_cf_modulomenuModel();
    }
 
    public function listAction()
    {
	$config = \Lib\Config::singleton();
	
	$userData = $config->get('SESSION_DATA');
	
	$idUsuario = $userData["IDUSUARIO"];
        
        $response = array();

	$response = $this->model->getTreePerfil(0,$idUsuario);
	
        echo  json_encode($response);
    }

    public function viewAction() 
    {
        $view_data = array("modDesc"=>"","opcDesc"=>""
                          );
        $this->view->show("si_cf_modulomenu", $view_data);
    }
 


}