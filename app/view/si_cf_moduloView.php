<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<?php	echo Lib\APPUtil::headerView(); ?> 
		
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
	
	<div class="easyui-panel" title="<?php echo $modDesc ?>" data-options="iconCls:'icon-save',fit:true">
		<div id="toolbar">
		<a href="#" onclick="javascript:$('#tt').etree('create')" class="easyui-linkbutton">Crear Modulo</a>
		<a href="#" onclick="javascript:$('#tt').etree('destroy')" class="easyui-linkbutton">Eliminar</a>

	</div>
		<ul id="tt" checkbox="false" lines="true"></ul>
	</div>
	
	
	
</body>
</html>