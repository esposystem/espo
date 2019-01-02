<?php



namespace Controller;



require_once MODEL_PATH . 'parametroModel.php';



use Model\parametroModel;

use Lib\View;

use Lib\APPNet;

use Lib\APPUtil;



class parametroController

{

    function __construct()

    {

        //Creamos una instancia de nuestro mini motor de plantillas"

        $this->view = new View();

        $this->model = new parametroModel();

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

        $view_data = array("modDesc"=>"Parametro","opcDesc"=>"Parametro"

                          );

        $this->view->show("parametro", $view_data);

    }

 

    public function createAction()

    {

           

        $config = \Lib\Config::singleton();

    

        $response = array();

           

        $fechaTr = (new \DateTime())->format($config->get('DATETIME_SQLFORMAT'));

    

    

        	$this->model->setIDPARAMETRO(APPNet::post('IDPARAMETRO'));
	$this->model->setEMAILADMIN(APPNet::post('EMAILADMIN'));
	$this->model->setEMAILCONTACTO(APPNet::post('EMAILCONTACTO'));
	$this->model->setEMAILENVIOS(APPNet::post('EMAILENVIOS'));
	$this->model->setTERMINOS(APPNet::post('TERMINOS'));
	$this->model->setMERCANCIA(APPNet::post('MERCANCIA'));
	$this->model->setIVA(APPNet::post('IVA'));
	$this->model->setVLRDECLARADO(APPNet::post('VLRDECLARADO'));
	$this->model->setSRPACK(APPNet::post('SRPACK'));
	$this->model->setTIPOSENVIO(APPNet::post('TIPOSENVIO'));
	$this->model->setTIPOSDOCUMENTO(APPNet::post('TIPOSDOCUMENTO'));
	$this->model->setSRPACKACTIVO(APPNet::post('SRPACKACTIVO'));
	$this->model->setGOOGLEANALITYCS(APPNet::post('GOOGLEANALITYCS'));
	$this->model->setFECHAINICIOMANTENIMIENTO(APPNet::post('FECHAINICIOMANTENIMIENTO'));
	$this->model->setFECHAFINMANTENIMIENTO(APPNet::post('FECHAFINMANTENIMIENTO'));
	$this->model->setSERVICIODESTACADO(APPNet::post('SERVICIODESTACADO'));

	$this->model->setNUMEROCONTRATO(APPNet::post('NUMEROCONTRATO'));
	$this->model->setCODIGOSUCURSAL(APPNet::post('CODIGOSUCURSAL'));
	$this->model->setFORMAPAGO(APPNet::post('FORMAPAGO'));
        

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

       

        $fechaTr = date("Y-m-d");

        

         	$this->model->setIDPARAMETRO(APPNet::post('IDPARAMETRO'));
	$this->model->setEMAILADMIN(APPNet::post('EMAILADMIN'));
	$this->model->setEMAILCONTACTO(APPNet::post('EMAILCONTACTO'));
	$this->model->setEMAILENVIOS(APPNet::post('EMAILENVIOS'));
	$this->model->setTERMINOS(APPNet::post('TERMINOS'));
	$this->model->setMERCANCIA(APPNet::post('MERCANCIA'));
	$this->model->setIVA(APPNet::post('IVA'));
	$this->model->setVLRDECLARADO(APPNet::post('VLRDECLARADO'));
	$this->model->setSRPACK(APPNet::post('SRPACK'));
	$this->model->setTIPOSENVIO(APPNet::post('TIPOSENVIO'));
	$this->model->setTIPOSDOCUMENTO(APPNet::post('TIPOSDOCUMENTO'));
	$this->model->setSRPACKACTIVO(APPNet::post('SRPACKACTIVO'));
	$this->model->setGOOGLEANALITYCS(APPNet::post('GOOGLEANALITYCS'));
	$this->model->setFECHAINICIOMANTENIMIENTO(APPNet::post('FECHAINICIOMANTENIMIENTO'));
	$this->model->setFECHAFINMANTENIMIENTO(APPNet::post('FECHAFINMANTENIMIENTO'));
	$this->model->setSERVICIODESTACADO(APPNet::post('SERVICIODESTACADO'));

	$this->model->setNUMEROCONTRATO(APPNet::post('NUMEROCONTRATO'));
	$this->model->setCODIGOSUCURSAL(APPNet::post('CODIGOSUCURSAL'));
	$this->model->setFORMAPAGO(APPNet::post('FORMAPAGO'));

        $this->model->setfechaTrCr($fechaTr);
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