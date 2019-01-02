<?php

namespace Controller;

use Lib\View;

class homeTabController
{
    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas"
        $this->view = new View();
    }
 
    public function viewAction()
    {
	
        $view_data = array("modDesc"=>"","opcDesc"=>"");
        $this->view->show("home", $view_data);
    }
    
     public function dashboardAction()
    {
	
        $view_data = array("modDesc"=>"","opcDesc"=>"");
        $this->view->show("dashboard", $view_data);
    }
 
}