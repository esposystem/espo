<?php

error_reporting(E_ERROR);

session_start();
  
///  NO OLVIDAD define ('K_PATH_IMAGES', 'C:\inetpub\vhosts\ada2.sistemafenix.co\httpdocs\resources\images\\'); en tcpdf/config/tcpdf_config.php

define ( 'BASE_PATH', dirname ( __FILE__ ) . DIRECTORY_SEPARATOR  ); // . '..' . DIRECTORY_SEPARATOR

define ( 'LIB_PATH', BASE_PATH . 'lib' . DIRECTORY_SEPARATOR );
define ( 'MODEL_PATH', BASE_PATH . 'model' . DIRECTORY_SEPARATOR );

define ( 'CONTROLLER_PATH', BASE_PATH . 'controller' . DIRECTORY_SEPARATOR );

define ('DEFAULT_ROUTE_METHOD', 'view');

define ('DEFAULT_ROUTE', '/usuario');

define('ROUTER_DEFAULT_CONTROLLER', 'home');
define('ROUTER_DEFAULT_ACTION', 'index');

require_once LIB_PATH . 'APPUtil.inc.php';
require_once LIB_PATH . 'Config.class.php';
require_once LIB_PATH . 'APPDbo.class.php'; //PDO con singleton
require_once LIB_PATH . 'APPSession.class.php'; 
require_once LIB_PATH . 'RouterNew.php';

//print_r(get_declared_classes() );

use Lib\Config;
 //   require 'config.php'; //Archivo con configuraciones.

/*********************  CONFIG **********************/

$config = Config::singleton();
 

$config->set('appName', 'Sistema de Ejecucion de Penas');

$config->set('controllersFolder', 'controller' . DIRECTORY_SEPARATOR);
$config->set('modelsFolder', 'model' . DIRECTORY_SEPARATOR);
$config->set('viewsFolder', 'view' . DIRECTORY_SEPARATOR);
$config->set('jeasiUIFolder', '/MVC_CRUD_JEASY/resources/jquery-easyui-1.3.6/');
$config->set('jqueryFolder', '/MVC_CRUD_JEASY/resources/jquery/');
$config->set('jsFolder', '/MVC_CRUD_JEASY/resources/js/');
$config->set('DIR_PT_DOC', 'C:\inetpub\vhosts\ada2.sistemafenix.co\httpdocs\uploaddir\\');

$config->set('HORAS_HABILES', array('0' => array( "08:00", "12:00" ), '1' => array( "14:00", "17:00" ) ));

//C:/inetpub/vhosts/ada2.sistemafenix.co/httpdocs/uploaddir/info.php

//$config->set('DBHOST', '184.168.47.15');

$config->set('DBHOST', '127.0.0.1');

$config->set('DBNAME', 'CSJ_SIEJECUCION_ADAV1');
$config->set('DBUSER', 'csj_ada_v1');
$config->set('DBPASS', 't2tb123wperA');


$config->set('DATE_FORMAT', 'm/d/Y'); // Formato de fecha de los input date o calendar en el FORM
$config->set('DATETIME_FORMAT', 'Y-m-d\TH:i:s'); // Formato de fecha de los input date o calendar en el FORM
$config->set('DATETIME_SQLFORMAT', 'Y-m-d\TH:i:s');
$config->set('DATE_SQLFORMAT', 'Y-m-d');
$config->set('TIME_SQLFORMAT', 'H:i:s');
$config->set('DATE_LOGFORMAT', 'Ymd'); // FOrmato para nombres de archivos o registros de log

$config->set('GRID_NUMROWS', 10); // Multiplo de 10 Ej: 10 - 20 - 30

date_default_timezone_set('America/Bogota');

/******************************************************/

/******************************************************/

use Lib\Router;

/*
foreach(get_declared_classes() AS $r_class ){
    
    echo $r_class;
    print_r( get_class_methods($r_class));
    
}*/

 //  require 'lib\\Config.class.php'; //de configuracion
 


//$router = new Router(); // create router instance 
 
// singleton()
 $router = Router::singleton();
 
//$r->map('/app', array('controller' => 'home')); // main page will call controller "Home" with method "index()"
//$r->map('/login', array('controller' => 'auth', 'action' => 'login'));
//$r->map('/usuario', array('controller' => 'auth', 'action' => 'logout'));
//$r->map('/signup', array('controller' => 'auth', 'action' => 'signup'));
//$r->map('/profile/:action', array('controller' => 'profile')); // will call controller "Profile" with dynamic method ":action()"

$router->map('/login', array('controller' => 'login', 'action' => 'auth'));
$router->map('/home/:action', array('controller' => 'home','action' => 'view')); // define filters for the url parameters



$router->map('/app/:action/:id', array('controller' => 'usuario','action' => 'list'), array('id' => '[\d]{1,8}')); // define filters for the url parameters

$router->map('/usuario/:action/', array('controller' => 'usuario'), array('id' => '[\d]{1,8}')); // define filters for the url parameters
$router->map('/usuario/:action/', array('controller' => 'usuario','action' => 'list')); // define filters for the url parameters
$router->map('/usuario/:action/', array('controller' => 'usuario','action' => 'delete')); // define filters for the url parameters
$router->map('/usuario/:action/:id', array('controller' => 'usuario','action' => 'update'), array('id' => '[\d]{1,8}')); // define filters for the url parameters


/*__________________________________________________________*/
$router->map('/dj_centroservicios/:action/', array('controller' => 'dj_centroservicios','action' => 'list')); 
$router->map('/dj_centroservicios/:action/', array('controller' => 'dj_centroservicios','action' => 'delete')); 
$router->map('/dj_centroservicios/:action/:id', array('controller' => 'dj_centroservicios','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/dj_despacho/:action/', array('controller' => 'dj_despacho','action' => 'list')); 
$router->map('/dj_despacho/:action/', array('controller' => 'dj_despacho','action' => 'delete')); 
$router->map('/dj_despacho/:action/:id', array('controller' => 'dj_despacho','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/

/*__________________________________________________________*/
$router->map('/dj_dm_tiposala/:action/', array('controller' => 'dj_dm_tiposala','action' => 'list')); 
$router->map('/dj_dm_tiposala/:action/', array('controller' => 'dj_dm_tiposala','action' => 'delete')); 
$router->map('/dj_dm_tiposala/:action/:id', array('controller' => 'dj_dm_tiposala','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/er_dm_tipo/:action/', array('controller' => 'er_dm_tipo','action' => 'list')); 
$router->map('/er_dm_tipo/:action/', array('controller' => 'er_dm_tipo','action' => 'delete')); 
$router->map('/er_dm_tipo/:action/:id', array('controller' => 'er_dm_tipo','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/er_dm_tiposala/:action/', array('controller' => 'er_dm_tiposala','action' => 'list')); 
$router->map('/er_dm_tiposala/:action/', array('controller' => 'er_dm_tiposala','action' => 'delete')); 
$router->map('/er_dm_tiposala/:action/:id', array('controller' => 'er_dm_tiposala','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/er_establecimiento/:action/', array('controller' => 'er_establecimiento','action' => 'list')); 
$router->map('/er_establecimiento/:action/', array('controller' => 'er_establecimiento','action' => 'delete')); 
$router->map('/er_establecimiento/:action/:id', array('controller' => 'er_establecimiento','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/

 $router->map('/er_sala/:action/', array('controller' => 'er_sala','action' => 'list'));
 $router->map('/er_sala/:action/', array('controller' => 'er_sala','action' => 'delete'));
 $router->map('/er_sala/:action/:id', array('controller' => 'er_sala','action' => 'update'), array('id' => '[\d]{1,8}'));

 $router->map('/er_saladisp/:action/:id', array('controller' => 'er_saladisp','action' => 'list'), array('id' => '[\d]{1,8}'));
 
  $router->map('/er_saladisp/:action/:id', array('controller' => 'er_saladisp','action' => 'create'), array('id' => '[\d]{1,8}'));
//  $router->map('/er_saladisp/:action/:subact/:id', array('controller' => 'er_saladisp','action' => 'create'), array('id' => '[\d]{1,8}'));

 
/*__________________________________________________________*/
$router->map('/jz_dm_tipo/:action/', array('controller' => 'jz_dm_tipo','action' => 'list')); 
$router->map('/jz_dm_tipo/:action/:id', array('controller' => 'jz_dm_tipo','action' => 'update'), array('id' => '[\d]{1,8}'));

$router->map('/jz_dm_tipojuzgado/:action/', array('controller' => 'jz_dm_tipojuzgado','action' => 'list'));
$router->map('/jz_dm_tipojuzgado/:action/:id', array('controller' => 'jz_dm_tipojuzgado','action' => 'update'), array('id' => '[\d]{1,8}'));

/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/pr_dm_ciudad/:action/', array('controller' => 'pr_dm_ciudad','action' => 'list')); 
$router->map('/pr_dm_ciudad/:action/:id', array('controller' => 'pr_dm_ciudad','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/pr_dm_departamento/:action/', array('controller' => 'pr_dm_departamento','action' => 'list')); 
$router->map('/pr_dm_departamento/:action/:id', array('controller' => 'pr_dm_departamento','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/pt_dm_clase/:action/', array('controller' => 'pt_dm_clase','action' => 'list')); 
$router->map('/pt_dm_clase/:action/:id', array('controller' => 'pt_dm_clase','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/pt_dm_tipo/:action/', array('controller' => 'pt_dm_tipo','action' => 'list')); 
$router->map('/pt_dm_tipo/:action/:id', array('controller' => 'pt_dm_tipo','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/pt_dm_tipodoc/:action/', array('controller' => 'pt_dm_tipodoc','action' => 'list')); 
$router->map('/pt_dm_tipodoc/:action/:id', array('controller' => 'pt_dm_tipodoc','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/pt_dm_tipooficio/:action/', array('controller' => 'pt_dm_tipooficio','action' => 'list')); 
$router->map('/pt_dm_tipooficio/:action/:id', array('controller' => 'pt_dm_tipooficio','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/pt_dm_tiporequisito/:action/', array('controller' => 'pt_dm_tiporequisito','action' => 'list')); 
$router->map('/pt_dm_tiporequisito/:action/:id', array('controller' => 'pt_dm_tiporequisito','action' => 'update'), array('id' => '[\d]{1,8}'));

$router->map('/pt_peticion/:action/', array('controller' => 'pt_peticion','action' => 'list')); 
$router->map('/pt_peticion/:action/:id', array('controller' => 'pt_peticion','action' => 'update'), array('id' => '[\d]{1,8}')); 

$router->map('/pr_dm_estadocivil/:action/', array('controller' => 'pr_dm_estadocivil','action' => 'list')); 
$router->map('/pr_dm_estadocivil/:action/:id', array('controller' => 'pr_dm_estadocivil','action' => 'update'), array('id' => '[\d]{1,8}')); 


$router->map('/gs_ficha/:action/', array('controller' => 'gs_ficha','action' => 'valProcJXXI')); 
$router->map('/gs_ficha/:action/:id', array('controller' => 'gs_ficha','action' => 'update'), array('id' => '[\d]{1,8}')); 


/*__________________________________________________________*/

//$router->map('/pt_documento/:action/', array('controller' => 'pt_documento','action' => 'list'));
//$router->map('/pt_documento/:action/:id', array('controller' => 'pt_documento','action' => 'valida'), array('id' => '[\d]{1,8}'));

/*__________________________________________________________*/
$router->map('/si_log/:action/', array('controller' => 'si_log','action' => 'list')); 
$router->map('/si_log/:action/:id', array('controller' => 'si_log','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/
/*__________________________________________________________*/
$router->map('/usuario/:action/', array('controller' => 'usuario','action' => 'list')); 
$router->map('/usuario/:action/:id', array('controller' => 'usuario','action' => 'update'), array('id' => '[\d]{1,8}')); 
/*__________________________________________________________*/


$router->default_routes();
$router->execute();


?>