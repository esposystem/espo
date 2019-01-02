<?php

namespace Lib;

class frontController 
{
    static function main()
    {
        
     //    print_r($_REQUEST);
         
     //  echo "FRONT ";
        
        //Incluimos algunas clases:
        
        $router = Router::singleton();
        $config = Config::singleton();
        
//  print_r($router);
 //print_r($config);
       //Mini motor de plantillas
 
       
        
        //Con el objetivo de no repetir nombre de clases, nuestros controladores
        //terminar‡n todos en Controller. Por ej, la clase controladora Items, ser‡ ItemsController
 
        //Formamos el nombre del Controlador o en su defecto, tomamos que es el IndexController
        

//$router->id; // if parameter :id presents
//$router->params; // array(...)
//$router->route_matched; // true

        if(!empty( $router->controller) && $router->route_found )
        
            $controllerName = $router->controller . 'Controller';
              
        else{
            echo "Acceso Denegado";
            exit;
        }
            //      $controllerName = "appController";
 
        //Lo mismo sucede con las acciones, si no hay acci—n, tomamos index como acci—n
        if(! empty($router->action))
              $actionName = $router->action."Action";
        else
              $actionName = "view";
 
         $controllerPath = $config->get('controllersFolder') . $controllerName . '.php';
 
        //Incluimos el archivo que contiene nuestra clase controladora solicitada
        if(is_file($controllerPath))
              require $controllerPath;
        else
              die('El controlador no existe - 404 not found');
        
     //print_r(get_declared_classes() );

        
        // "Si no existe la clase que buscamos y su acci—n, mostramos un error 404";
         
         
     //  echo " EXISTE : $controllerName . '->' . $actionName";
        
        $controllerName = "controller\\".$controllerName;
        
    //     if(class_exists($controllerName))
     //        echo "CLARO Q EXISTE";
      //   else
       //      echo "CLARO QUE NO";
            
         //    echo " EXISTE : $controllerName . '->' $actionName  ";
             
        if (is_callable(array($controllerName, $actionName)) == false)
        {
            // Eliminar mensaje en productivo
            
            echo " Acceso Denegado : $controllerName . '->' . $actionName";
            
          //  trigger_error ($controllerName . '->' . $actionName . '` no existe', E_USER_NOTICE);
            return false;
        }
        
        
     // echo "  //Si todo esta bien, creamos una instancia del controlador y llamamos a la acci—n";
        $controller = new $controllerName();
        $controller->$actionName();
    }
}
