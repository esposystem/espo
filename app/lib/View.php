<?php

namespace Lib;

//require_once CONTROLLER_PATH . 'loginController.php';

//use Controller\loginController;

class View
{
    function __construct()
    {
    }
 
    public function show($name, $vars = array())
    {
      
        //Traemos una instancia de nuestra clase de configuracion.
        
      //  echo "en la vista";
      //   print_r(get_declared_classes() );
          
        $config = Config::singleton();
        
       // print_r($config);
        
     //   $appSession = loginController::singleton();
        
      //  $appSession->checkAction();
            
      //    print_r( $appSession);
           // exit;
           if( !$config->get('SESSION_ON')) { 
                include($config->get('viewsFolder')."loginView.php");   
		//header( "location: /app/login/view" . $datos );
                exit;
           }
        
        $vars["userData"] = $config->get('SESSION_DATA');
        
        //Armamos la ruta a la plantilla
        $path = $config->get('viewsFolder') . $name."View.php";
 
        //Si no existe el fichero en cuestion, mostramos un 404
        if (file_exists($path) == false)
        {
            trigger_error ('Vista `' . $path . '` No Existe.', E_USER_NOTICE);
            return false;
        }
 
        //Si hay variables para asignar, las pasamos una a una.
       
        if(is_array($vars))
        {
            foreach ($vars as $key => $value)
                $$key = $value;

        }
 
        //Finalmente, incluimos la plantilla.
        include($path);
    }



    public function showFront($name, $vars = array())
    {
      
        //Traemos una instancia de nuestra clase de configuracion.
        
      //  echo "en la vista";
      //   print_r(get_declared_classes() );
          
        $config = Config::singleton();
        
       
        
        //$vars["userData"] = $config->get('SESSION_DATA');
        
        
        //Armamos la ruta a la plantilla
        $path = $config->get('viewsFolder') . $name."View.php";
 
        //Si no existe el fichero en cuestion, mostramos un 404
        if (file_exists($path) == false)
        {
            trigger_error ('Vista `' . $path . '` No Existe.', E_USER_NOTICE);
            return false;
        }
 
        //Si hay variables para asignar, las pasamos una a una.
       
        if(is_array($vars))
        {
            foreach ($vars as $key => $value)
                $$key = $value;

        }
 
        //Finalmente, incluimos la plantilla.
        include($path);
    }//end function


    
}
/*
 El uso es bastante sencillo:
 $vista = new View();
 $vista->show('listado.php', array("nombre" => "Juan"));
*/
