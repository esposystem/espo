<?php

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(0);

session_start();
  
///  NO OLVIDAD define ('K_PATH_IMAGES', 'C:\inetpub\vhosts\ada2.sistemafenix.co\httpdocs\resources\images\\'); en tcpdf/config/tcpdf_config.php

define ( 'BASE_PATH', dirname ( __FILE__ ) . DIRECTORY_SEPARATOR  ); // . '..' . DIRECTORY_SEPARATOR
define ('BASE_DIR','/' );
//C:\inetpub\wwwroot\CSJ

//define ( 'URL_DOMAIN', 'http://ada3.sistemafenix.co/' );
define ( 'URL_DOMAIN', 'http://esposystem.azurewebsites.net/' );
define ( 'LIB_PATH', BASE_PATH . 'lib' . DIRECTORY_SEPARATOR );
define ( 'MODEL_PATH', BASE_PATH . 'model' . DIRECTORY_SEPARATOR );

define ( 'CONTROLLER_PATH', BASE_PATH . 'controller' . DIRECTORY_SEPARATOR );

define ('DEFAULT_ROUTE_METHOD', 'view');

define ('DEFAULT_ROUTE', '/usuario');

define('ROUTER_DEFAULT_CONTROLLER', 'home');
define('ROUTER_DEFAULT_ACTION', 'index');

require_once LIB_PATH . 'APPUtil.inc.php';
require_once LIB_PATH . 'APPCal.class.php';
require_once LIB_PATH . 'Config.class.php';
require_once LIB_PATH . 'APPDbo.class.php'; //PDO con singleton
require_once LIB_PATH . 'APPSession.class.php'; 
require_once LIB_PATH . 'RouterNew.php';
require_once LIB_PATH . 'APPNet.inc.php';
require_once LIB_PATH . 'View.php';

//print_r(get_declared_classes() );

use Lib\Config;
 //   require 'config.php'; //Archivo con configuraciones.

/*********************  CONFIG **********************/

$config = Config::singleton();
 
$config->set('appName', 'Sistema ESPO');

$config->set('controllersFolder', 'controller' . DIRECTORY_SEPARATOR);
$config->set('modelsFolder', 'model' . DIRECTORY_SEPARATOR);
$config->set('viewsFolder', 'view' . DIRECTORY_SEPARATOR);
$config->set('jeasiUIFolder', BASE_DIR.'/resources/jquery-easyui-1.4.2/');
$config->set('bootstrapFolder', BASE_DIR.'/resources/bootstrap/');

$config->set('jqueryFolder', BASE_DIR.'/resources/jquery/');
$config->set('jsFolder', BASE_DIR.'/resources/js/');
$config->set('DIR_PT', BASE_PATH.'..\files\\PT\\');
$config->set('DIR_PT_DOCS','C:\\inetpub\\wwwroot\\CSJ\\files\PT\\' );//BASE_PATH.'..\files\\PTDOCS\\');

$config->set('DIR_GS_RP_DOCS','C:\\inetpub\\wwwroot\\CSJ\\files\GS_RP_DOCS\\' );//BASE_PATH.'..\files\\PTDOCS\\');

//$config->set('DIR_GS_RP_DOCS', 'C:\inetpub\vhosts\ada2.sistemafenix.co\httpdocs\files\\GS_RP_DOCS\\');


$config->set('DIR_PR_FM_IMG', BASE_PATH.'\uploaddir\\img_fm\\');
$config->set('URL_PR_DM_IMG', '/uploaddir/img_fm/');
$config->set('DIR_FM_TMP', BASE_PATH.'\files\pdf_tmp\\'); // DIrectorio para el almacenamiento Temporal de los archivos vista previa de los PDF en PR_DM_FORMATO
$config->set('DIR_UPLOAD_TMP', BASE_PATH.'\files\TMP_UPLOAD\\'); // DIrectorio para el almacenamiento Temporal de los archivos vista previa de los PDF en PR_DM_FORMATO

$config->set('URL_FM_TMP', URL_DOMAIN.'/files/pdf_tmp/');
$config->set('CSS_FOLDER', BASE_DIR.'/resources/css/');

$config->set('bootstrapFolder', BASE_DIR.'/resources/bootstrap/');



$config->set('DIR_REPORTE', BASE_PATH.'\report\\');
$config->set('jsImgs', BASE_DIR.'/resources/images/');

$config->set('HORAS_HABILES', array('0' => array( "08:30", "12:00" ), '1' => array( "14:00", "17:00" ) ));

//C:/inetpub/vhosts/ada2.sistemafenix.co/httpdocs/uploaddir/info.php

//$config->set('DBHOST', '184.168.47.15');

//$config->set('DBHOST', '127.0.0.1');
//$config->set('DBNAME', 'CSJ_SIEJECUCION_ADAV1');
//$config->set('DBUSER', 'csj_ada_v1');
//$config->set('DBPASS', 'Ewe1#v10');
	$config->set('DBHOST', 'espo.database.windows.net');// 'WINSVR01\CONSEJO'
	$config->set('DBNAME', 'ESPO');
    $config->set('DBUSER', 'espo');
    $config->set('DBPASS', '3sp0Admin.');

$config->set('DATE_FORMAT', 'm/d/Y'); // Formato de fecha de los input date o calendar en el FORM
$config->set('DATETIME_FORMAT', 'Y-m-d\TH:i:s'); // Formato de fecha de los input date o calendar en el FORM
$config->set('DATETIME_SQLFORMAT', 'Y-m-d\TH:i:s');  // Formato de fecha para el almacenamiento en SQLSERVER
$config->set('DATE_SQLFORMAT', 'Y-m-d'); // Formato de fecha para el almacenamiento en SQLSERVER
$config->set('TIME_SQLFORMAT', 'H:i:s');
$config->set('DATE_LOGFORMAT', 'Ymd'); // FOrmato para nombres de archivos o registros de log

$config->set('TIME_SESSION', 45);


$config->set('GRID_NUMROWS', 20); // Multiplo de 10 Ej: 10 - 20 - 30

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