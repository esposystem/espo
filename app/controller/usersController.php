<?php

//namespace FenixV1\adminBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Symfony\Component\HttpFoundation\Response;
//use Doctrine\ORM\Tools\Pagination\Paginator;
//use FenixV1\adminBundle\Entity\Arp;

//use model\users;

/**
 * Arp controller.
 *
 * @Route("/Arp",defaults={"_format" = "json"})
 */
class usersController //extends Controller
{
    /**
     * Lists all Arp entities.
     *
     * @Route("/", name="arp")
     * @Method("GET")
     */
    public function listAction()
    {
      /*  $request = $this->getRequest();
        
        $limit = $request->get("limit");
        $start = $request->get("start");
        
        $em = $this->getDoctrine()->getEntityManager();

        $query = $em->createQuery('SELECT a FROM adminBundle:Arp a')
                   ->setFirstResult($start)
                   ->setMaxResults($limit);
    
        $paginator = new Paginator($query);
           
        $results = $query->getArrayResult();
                    
        $data = array("sucess"=> "true",
                 "message"=> "Loaded data",
                 "total"=>$paginator->count(),
                 "data"=>$results);
     
        $response = new Response(json_encode($data));
        
        return $response;
  */
      
      $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'lastname';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
	
	
	$offset = ($page-1)*$rows;
	$result = array();

	include 'conn.php';
	
	$rs = mysql_query("select count(*) from users");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	
	
	//$rs = mysql_query("select * from users limit $offset,$rows");
	
	$sql = "select * from users order by $sort $order limit $offset,$rows";
	
	$rs = mysql_query($sql);
	
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$response["rows"] = $items;

	return json_encode($response);
        
    }

    /**
     * Creates a new Arp entity.
     *
     * @Route("/create", name="arp_create")
     * @Method("post")
     */
   
    public function createAction()
    {
        $entity  = new Arp();
        $request = $this->getRequest();
        $cookies = $request->cookies; 

        $content = json_decode($request->getContent(), true);
        $data = $content["data"];
 
        $em = $this->getDoctrine()->getEntityManager();
        
        $entity->setNombre($data["nombre"]);
        
        $entity->setUsuariotrcr($cookies->get('username'));
        $entity->setFechatrcr(new \DateTime("now"));
           
        $em->persist($entity);
        $em->flush();
    
        $response_data["success"]= "true";
        $response_data["message"]= "Registro Creado";
      
        $response = new Response(json_encode($response_data));
        
        return $response;
    }

    /**
     * Edits an existing $entidad entity.
     *
     * @Route("/update", name="arp_update")
     * @Method("POST")
     */
    public function updateAction()
    {
        
        $request = $this->getRequest();
        $cookies = $request->cookies; 
    
        $content = json_decode($request->getContent(), true);
        $data = $content["data"];
        
        $id = $data["id"];
        
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('adminBundle:Arp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Arp entity.');
        }

        $request = $this->getRequest();

        $content = json_decode($request->getContent(), true);
        
        $data = $content["data"];
        $entity->setNombre($data["nombre"]);
        
        $entity->setUsuariotred($cookies->get('username'));
        $entity->setFechatred(new \DateTime("now"));
           
        $em->persist($entity);
        $em->flush();
        
        $response_data["success"]= "true";
        $response_data["message"]= "Registro Actualizado";
      
        $response = new Response(json_encode($response_data));
        
        return $response;
         
    }

    /**
     * Deletes a Arp entity.
     *
     * @Route("/delete", name="arp_delete")
     * @Method("post")
     */
    public function deleteAction()
    {
         $request = $this->getRequest();
    
        
        $content = json_decode($request->getContent(), true);
        $data = $content["data"];
        
        $id = $data["id"];

            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('adminBundle:Arp')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Arp entity.');
            }

            $em->remove($entity);
            $em->flush();
        

        $response_data["success"]= "true";
        $response_data["message"]= "Registro Eliminado";
      
      
        $response = new Response(json_encode($response_data));
        
        return $response;
        
    }
    
    /**
     * Export a Arp entity.
     *
     * @Route("/export", name="arp_export")
     * @Method("get")
     */
    
    public function exportAction(){
        
        // ask the service for a Excel5
        $xls_service =  $this->get('xls.service_xls5');
        // or $this->get('xls.service_pdf');
        // or create your own is easy just modify services.yml

        // create the object see http://phpexcel.codeplex.com documentation
        $xls_service->excelObj->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                            ->setTitle("Office 2005 XLSX Test Document")
                            ->setSubject("Office 2005 XLSX Test Document")
                            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
                            ->setKeywords("office 2005 openxml php")
                            ->setCategory("Test result file");
        $xls_service->excelObj->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Hello')
                    ->setCellValue('B2', 'world!');
        $xls_service->excelObj->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $xls_service->excelObj->setActiveSheetIndex(0);

        //create the response
        $response = $xls_service->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=stdream2.xls');

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;  
        
    }

}