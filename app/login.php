<?php
/*
session_start();

$newsesion =md5(uniqid(date("Y-m-d",time())));

				$fecha = date("Y-m-d H-i-s",time());

				setcookie("COOKIE_SESION",$newsesion, time() + 60*60*24*30, '/');
				
				print_r($_COOKIE);
				
				echo "login";
exit;
*/
require "config.inc.php";
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Control de Acceso</title>

	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/icon.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/default/easyui.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>demo/demo.css">
		<style>
		.fitem label {
			display: inline-block;
			width: 241px;
			}
		
		</style>
		<script type="text/javascript" src="<?php echo $config->get('jqueryFolder')?>jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.easyui.min.js"></script>
                
	<script type="text/javascript">
		function savereg(){
			$('#ff').form('submit',{
				url:'login_auth.php?action=Iniciar',
				success:function(data){
					
					console.log(data);
					
					if(data == 'true')
						document.location = "./";
					else
						$.messager.alert('Atenci&oacute;n','Usuario y Clave no son validos');
				}
			});
		}
	</script>
</head>
<body>
	
	
	<div id="dlg" class="easyui-dialog" style="width:400px;height:200px;padding:10px 30px;"
			title="<?php echo $config->get('appName')?>" buttons="#dlg-buttons">
		<h2>Control de Acceso</h2>
		<form id="ff" method="post">
			<table>
				<tr>
					<td>Usuario:</td>
					<td><input type="text" name="login" style="width:250px;"/></td>
				</tr>
				<tr>
					<td>Clave:</td>
					<td><input type="password" name="clave" style="width:250px;"/></td>
				</tr>
				
			</table>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="savereg()">Enviar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>