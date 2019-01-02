<?php
//error_reporting(E_ALL);

//echo "INDEX";

require_once 'config.inc.php';

//require "controller/loginController.php";

    $controllerPath = $config->get('controllersFolder') . 'loginController.php';
 
        //Incluimos el archivo que contiene nuestra clase controladora solicitada
        if(is_file($controllerPath))
              require $controllerPath;
              
	/*	header( "Content-type: " . $type );
		header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );             
		header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" ); 
		header( "Cache-Control: no-cache, must-revalidate" );           
		header( "Pragma: no-cache" );
*/
         
//print_r($router);

/**************                 **************/

   // session_start();
    
  //  Lib\APPUtil::cache();
    
  //  $appSession = new APPSession( SESSION_LIMIT );
//print_r(get_declared_classes() );

    $appSession = new Controller\loginController();
    	
    //    print_r($_COOKIE);
         
//	print_r($appSession);
	
	//print_r($datos);
	//exit;
	
        if($router->controller == "login"){
          //  print_r($_COOKIE);
            $actionName = $router->action."Action";
            $appSession->$actionName();
            exit;
        }
	elseif( $router->controller != "login")
	{
            
            $appSession->checkAction();
            
       //  print_r( $appSession);
           // exit;
           
           if( !$appSession->sesionActiva) { 
               // include($config->get('viewsFolder')."loginView.php");
               
               echo "<script>window.top.location.href='".URL_DOMAIN."/app/login/view';</script>";
              //  $appSession->viewAction();
              
		//header( "location: /app/login/view" . $datos );
                exit;
           }
          // print_r( $appSession);
            $config->set('IDSESION',$appSession->IDSESION);
            $config->set('SESSION_ON',$appSession->sesionActiva);
            $config->set('SESSION_DATA',$appSession->userData);
            $config->set('MODULO_SELEC',$router->controller);
         	
	    $idModulo = array_search($router->controller,$appSession->userData['MODULOS']);
            
            $config->set('IDMODULO_SELEC',$idModulo);
                
	}
       
require_once LIB_PATH . 'frontController.php'; //PDO con singleton
//require_once LIB_PATH . 'View.php';


require_once LIB_PATH . 'APPFile.class.php';
require_once LIB_PATH . 'APPCal.class.php';
require_once LIB_PATH . 'APPResources.class.php'; 
//require_once MODEL_PATH . 'usuarioModel.php'; 
//require_once MODEL_PATH . 'pt_dm_tipooficioModel.php';
//require_once MODEL_PATH . 'ad_dm_tiposalasjuecesModel.php';
//require_once MODEL_PATH . 'dj_centroserviciosModel.php';
//require_once MODEL_PATH . 'pt_dm_claseModel.php';

//print_r(get_declared_classes() );

//require_once MODEL_PATH . 'category.php';


use Lib\frontController;
/*********************************/


frontController::main();
   
?>