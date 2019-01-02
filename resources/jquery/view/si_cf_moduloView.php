<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $config->get('appName')?></title>	
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/icon.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/default/easyui.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>demo/demo.css">
	
		<script type="text/javascript" src="<?php echo $config->get('jqueryFolder')?>jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.easyui.min.js"></script>
			<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.etree.js"></script>
               
	<script type="text/javascript">
		$(function(){
			$('#tt').etree({
				url: '/app/si_cf_modulo/listAll',
				createUrl: '/app/si_cf_modulo/create',  
				updateUrl: '/app/si_cf_modulo/update',  
				destroyUrl: '/app/si_cf_modulo/delete',  
				dndUrl: '/app/si_cf_modulo/dragndrop'
				
			});
			
			// updateUrlOper : 'includes/tree_modulos.php?opt=update_oper'
		});
	</script>

</head>
<body>
	<h1>Modulos Fenix</h1>
	<div style="margin-bottom:10px">
		<a href="#" onclick="javascript:$('#tt').etree('create')" class="easyui-linkbutton">Crear Modulo</a>
		<a href="#" onclick="javascript:$('#tt').etree('destroy')" class="easyui-linkbutton">Eliminar</a>

	</div>
	<ul id="tt" checkbox="false" lines="true"></ul>
	
	
</body>
</html>