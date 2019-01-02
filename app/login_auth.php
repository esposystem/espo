<?php

/*	include("config.inc.php");
	Encabezado();

	if(empty($redirect))
	$redirect = "./";

	echo sha1("1234");
*/


	include("lib/db_sqlsrv_2.inc");

	define('SQLSRV_DATABASENAME','CSJ_SIEJECUCION_ADAV1');
	define('SQLSRV_HOSTNAME','184.168.47.15');
	define('SQLSRV_PASSWORD','t2tb123wperA');
	define('SQLSRV_USERNAME','csj_ada_v1');
	
	$db = new sqlsrv();

	switch($_GET[action]){

		case 'Iniciar':
		
		//echo "LOGIN $action";
		//	$login = antiinjection($login);
		//	$clave = antiinjection($clave);

		//	echo "select * from Empleado Where User = '$login' AND Password = password('$clave') AND Autorizado = 'S'";
		
			$param = array($login);
			// Where Usuario = ? AND Autorizado = 'S'
			
		//	$userqry = db_query($dblink,"select * from Usuario ",$param);

			$db->query("select * from Usuario ");
			
		//	$limpiaqry = db_query("delete from Sesion where DATE_ADD(Inicio, INTERVAL 30 MINUTE)<now()");
					
		//	echo "NUM ".db_num_rows($userqry);
	
			//print_r($db);
		
			if ($db->num_rows()!= 0){

				$datos_user_obj = $db->fetch_object($userqry);
				
				
				//print_r($datos_user_obj);
				
				
				/*
				$db_query_permisos = db_query("SELECT P.Permiso,M.NombreModulo 
													FROM Modulo M,Permisos P 
													WHERE P.IdModulo = M.IdModulo 
														AND P.IdPerfil = '$datos_user_obj->IdPerfil' " );
							
				$Array_Permisos = array();
				
				while($r_permiso = db_fetch_object($db_query_permisos))
						$Array_Permisos[$r_permiso->NombreModulo] = $r_permiso->Permiso;
					*/	
				
				
				/*$db_query_permisos = db_query($dblink,"SELECT GP.IDGrupo,GP.IDPerfil,PO.IDModulo,PO.IDOperacion,MO.Operacion,M.Modulo,M.Posicion
								FROM SI_CF_GRUPOUSUARIO GU, SI_CF_GRUPOPERFIL GP, SI_CF_PERFILOPER PO, SI_CF_MODULOOPER MO, SI_CF_MODULO M
								WHERE GP.IDGrupo = GU.IDGrupo
								AND GP.IDPerfil = PO.IDPerfil
								AND MO.IDModulo = PO.IDModulo
								AND MO.IDOperacion = PO.IDOperacion
								AND M.IDModulo = MO.IDModulo
								AND GU.IDEmpleado = '$datos_user_obj->IDHojaVida'
								GROUP BY PO.IDModulo,PO.IDOperacion
								ORDER BY PO.IDModulo,M.Posicion
							 " );
				*/						
						
				$db_query_permisos = $db->query("SELECT PO.IDModulo,PO.IDOperacion,MO.Operacion,M.Modulo,M.Posicion
								FROM SI_CF_GRUPOUSUARIO GU, SI_CF_GRUPOPERFIL GP, SI_CF_PERFILOPER PO, SI_CF_MODULOOPER MO, SI_CF_MODULO M
								WHERE GP.IDGrupo = GU.IDGrupo
								AND GP.IDPerfil = PO.IDPerfil
								AND MO.IDModulo = PO.IDModulo
								AND MO.IDOperacion = PO.IDOperacion
								AND M.IDModulo = MO.IDModulo
								AND GU.IDEmpleado = '$datos_user_obj->IDHojaVida'
								GROUP BY PO.IDModulo,PO.IDOperacion,MO.Operacion,M.Modulo,M.Posicion
								ORDER BY PO.IDModulo,M.Posicion");

									
				$Array_Permisos = array();
				$Array_Modulos = array();

				//exit;
				while($r_permiso = $db->fetch_array($db_query_permisos)){
					
					print_r($r_permiso);
					//$Array_Permisos[$r_permiso->IDModulo][$r_permiso->IDOperacion] = array($r_permiso->Modulo,$r_permiso->Operacion);
					//if(!array_key_exists($r_permiso->Modulo,$Array_Permisos))
						$Array_Permisos[$r_permiso[Modulo]][$r_permiso[Operacion]] = $r_permiso[IDModulo];
						$Array_Modulos[$r_permiso[IDModulo]] = $r_permiso[Modulo];
						
					//	db_query("DELETE FROM SI_CF_MODULOMENU WHERE IDEmpleado = '$datos_user_obj->IDEmpleado' ");
						
					
					//	get_Modulos($r_permiso->IDModulo,$array_ModUser);
					
					//print_r($array_ModUser);
					
					//	$array_ModUser = array_reverse($array_ModUser,true);
					
						foreach($array_ModUser  AS $key2 => $value2){
							$qry_mod = $db->query("SELECT * FROM SI_CF_MODULO WHERE IDModulo = '$key2' ");
							
							$r_mod = $db->fetch_object($qry_mod);
							
							$db->query("INSERT IGNORE INTO SI_CF_MODULOMENU VALUES('$datos_user_obj->IDHojaVida','$r_mod->IDModulo','$r_mod->IDPadre','$r_mod->Nombre','$r_mod->Posicion','$r_mod->Dependiente','$r_mod->Modulo','','') ");
						}
				}
				
					
				//if($datos_user_obj->Nivel != 0 && $datos_user_obj->IDBodega == 0){
			
				//	echo $ERROR="Verifique nombre de usuario y clave y bodega asignada !!";
				//	header("Location: login.php?ERROR=$ERROR");		
				//	exit;
			
				//}											
	
				$Usuario=array("Nivel"=>$datos_user_obj->Nivel,
							"IDPerfil"=>$datos_user_obj->IdPerfil,
							"IDBodega"=>$datos_user_obj->IDBodega,
							"IDUsuario"=>$datos_user_obj->IDHojaVida,
							"Cedula"=>$datos_user_obj->Cedula,
							"Nombre"=>$datos_user_obj->PrimerNombre." ".$datos_user_obj->SegundoNombre." ".$datos_user_obj->PrimerApellido." ".$datos_user_obj->SegundoApellido,
							"User"=>$login,"flag"=>"TRUE",
							"IDBodega"=>$datos_user_obj->IDBodega,
							"IDCiudad"=>$datos_user_obj->IDCiudad,
							"Permisos"=>$Array_Permisos,
							"Modulos"=>$Array_Modulos);
				
			
				$usuariosave = addslashes(serialize($Usuario));

				$newsesion =md5(uniqid(date("Y-m-d",time())));

				$fecha = date("Y-m-d H-i-s",time());

				$guardarqry = $db->query("insert into Sesion values ('$newsesion','$datos_user_obj->IDHojaVida',getdate(),'$usuariosave')");

				setcookie("COOKIE_SESION",$newsesion);
				
				print_r($_COOKIE);
				
				//setcookie("COOKIE_SESION",$newsesion,time() + 6000, '/SITCOM/FenixV1');
					//echo "<script>alert('OK');</script>";

				
				//header("Location: $redirect");
				
				echo 'true';//'{"success":true}';
				
					
			}//if ($pass!=$userdata->password)
			else
				//echo "select * from TH_HV Where User = '$login' AND Password = password('$clave') AND Autorizado = 'S'";
				
				echo 'false';//'{"error":true}';
				
				//$ERROR="Verifique nombre de usuario y clave";
				
				

		break;//Case 'Iniciar'

		case 'LogOut':

				setcookie("$COOKIE_SESION"); //Independiente se libera el cookie

				$borrarqry = db_query("delete from Sesion where IDSesion='$COOKIE_SESION'");

				$err=1;

				$ERROR="Sesion terminada correctamente";

				header("Location: login.php");
				
		break; //case 'Logout'

	}//switch($action)



	
?>