<?php

namespace Controller;

require_once MODEL_PATH . 'sesionModel.php';
require_once MODEL_PATH . 'usuarioModel.php';
require_once MODEL_PATH . 'si_cf_modulomenuModel.php';
use Lib\APPNet;
use Lib\View;
use Lib\APPUtil;

class loginController
{
    //tiempo limite de la sesion
	var $_limit;
	public $userData;
	private static $instance;
	public $sesionActiva;
	public $IDSESION;
	
    function __construct()
    {
        $this->view = new View();
        $this->model = new \Model\sesionModel();
		$this->usuarioModel = new \Model\usuarioModel();
		$this->modmenuModel = new \Model\si_cf_modulomenuModel();
    }
  
    public static function singleton()
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
 
        return self::$instance;
    }
    
    public function authAction()
    {

    	session_start();
	
        $response = array();
        
        $config = \Lib\Config::singleton();
	           
        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
	
	
    	$constrain = " t.USUARIO = '".APPNet::post('login')."' AND t.PASSWORD = '".sha1(APPNet::post('clave'))."'";
	$fields = array('t.*');
	
        $result_usuario =  $this->usuarioModel->getRows($fields,array(),$constrain);

	if(!empty($result_usuario[0])){
	     $dateDif = APPUTIL::date_diff(date('Y-m-d'),$result_usuario[0]['VIGENCIA']);
	    if($dateDif['days'] < 0){
		
			$response["msg"] = "Usuario no esta vigente, contacte al administrador !!";	
    
			echo  json_encode($response);
			exit;
	    }
	    
	    /*
	    $arraySI_CF_Param = $this->model->si_cf_paramModel->getArrayParam("ESTADO = 'Activo'" );
	    $arrayPT_CF_Param = $this->model->pt_cf_paramModel->getArrayParam("ESTADO = 'Activo'" );
	    $arrayGS_CF_Param = $this->model->gs_cf_paramModel->getArrayParam("ESTADO = 'Activo'" );
	    $arrayIO_CF_Param = $this->model->io_cf_paramModel->getArrayParam("ESTADO = 'Activo'" );
	    */
	   
	    $arrayPerModulos = $this->modmenuModel->setMenuPerfil($result_usuario[0]['IDUSUARIO']);
	  
	    $userData=array("IDUSUARIO"=>$result_usuario[0]['IDUSUARIO'],
			    "CODIGO"=>$result_usuario[0]['CODIGO'],
			    "NUMEROIDENTIFICACION"=>$result_usuario[0]['NUMEROIDENTIFICACION'],
			    "NOMBRE"=>$result_usuario[0]['PRIMERNOMBRE']." ".$result_usuario[0]['SEGUNDONOMBRE']." ".$result_usuario[0]['PRIMERAPELLIDO']." ".$result_usuario[0]['SEGUNDOAPELLIDO'],
			    "USUARIO"=>$result_usuario[0]['USUARIO'],
			    "flag"=>"TRUE",
			    "PERMISOS"=>$arrayPerModulos[0],
			    "MODULOS"=>$arrayPerModulos[1],
			    "GRUPOS"=>$arrayPerModulos[2]
			//    "MANUALES"=>$arrayPerModulos[3],
			  /*  "SI_CF_PARAM"=>$arraySI_CF_Param,
			    "PT_CF_PARAM"=>$arrayPT_CF_Param,
			    "GS_CF_PARAM"=>$arrayGS_CF_Param,
			    "IO_CF_PARAM"=>$arrayIO_CF_Param*/);
		
	     
	    $usuariosave = addslashes(serialize($userData));
			    
	    $newsesion = md5(uniqid(date("Y-m-d",time())));
			    
	    $this->model->setIDSESION($newsesion);
	    $this->model->setIDUSUARIO($result_usuario[0]['IDUSUARIO']);
	    $this->model->setINICIO($fechaTr);
	    $this->model->setDATOS($usuariosave);
	    
	    $config->set('IDSESION',$newsesion);
	    $config->set('SESSION_ON',TRUE);
	    $config->set('SESSION_DATA',$userData);

			
	    $id = $this->model->insertRow();
		
		if($id ){
		    
		    
		    $_SESSION["APP_SESION"] = $newsesion; // '/','ada3.sistemafenix.co'
		    //setcookie('APP_SESION',$newsesion,0,'/'); // '/','ada3.sistemafenix.co'
		  
		    $response["success"] = true;
		    $response["msg"] = "Sesion Creada";
		}    
		else
		    $response["msg"] = "Error al crear registro";
	    
	    }
	    else 
		$response["msg"] = "Verifique el usuario o la clave !!";
	
	    echo  json_encode($response);
    
    }
    
    public function outAction(){

    session_start();
       
	$numAffected = $this->model->deleteRow($_SESSION["APP_SESION"]);
        
	$_SESSION["APP_SESION"] = ""; // '/','ada3.sistemafenix.co'
	//setcookie("APP_SESION");
	
	$this->viewAction();
   
    }

    public function viewAction()
    {
	$this->view->show("login", "");
    }
    
    public function checkAction()
    {

    	session_start();
	    $config = \Lib\Config::singleton();



		$this->model->deleteOld($config->get('TIME_SESSION')); //descomentariar cuando la hora del server esté bien
		
		$defaultdata = array( "flag" => false );
	
		//Primero verificar que el cookie este activo
		if ( empty($_SESSION["APP_SESION"]) )
			$this->sesionActiva = false;
		else
		{
			
			$sessiondata = $this->model->getRow($_SESSION["APP_SESION"]);
			
			if( !$sessiondata ){
				$this->sesionActiva  = false;

			}
			else
			{
				$defaultdata  = unserialize( stripslashes( $this->model->getDATOS() ) );
			
				$this->IDSESION = $_SESSION["APP_SESIONCLIENTE"];
				$this->userData = $defaultdata;


				$this->sesionActiva = true;
			
				$fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));
				    
				$this->model->setINICIO($fechaTr);
				
				$affectedRows = $this->model->saveRow($_SESSION["APP_SESION"]);
	
			}
		}
		
	}
	
}