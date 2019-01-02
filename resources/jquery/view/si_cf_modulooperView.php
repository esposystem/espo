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
		<!--	<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.etree.js"></script>
               -->
	<script type="text/javascript">
		$(function(){
			
			$('#tt').treegrid({
				//url: 'includes/tree_modulos.php?opt=list&oper=1',
				url: '/app/si_cf_modulo/getNodo/1',
				//createUrl: 'includes/tree_modulos.php?opt=add',  
				//updateUrl: 'includes/tree_modulos.php?opt=edit',  
				//destroyUrl: 'includes/tree_modulos.php?opt=del',  
				//dndUrl: 'includes/tree_modulos.php?opt=dnd',
				
				onDblClickCell: function(index,field,value){	
					var node = $('#tt').treegrid('getSelected');
					if (node){
						$('#tt').treegrid('beginEdit',node.id);
					}
				}
			
			});
			
			
			$('#tt').treegrid('expandAll');
		});
	</script>
		
	<script>
		
		function expandAll(){
			var node = $('#tt').treegrid('getSelected');
			if (node){
				$('#tt').treegrid('expandAll', node.code);
			} else {
				$('#tt').treegrid('expandAll');
			}
		}
		
		
		function editNode(){
			
			var node = $('#tt').treegrid('getSelected');
			if (node){
				$('#tt').treegrid('beginEdit',node.id);
			}
		}
		function saveNode(){
			
			
			var node = $('#tt').treegrid('getSelected');
			if (node){
				$('#tt').treegrid('endEdit',node.id);
				
				//var row = $('#tt').treegrid('getSelected');
				
//				alert(node.Modulo)
console.log(node);
				$.ajax({
						//url: 'includes/tree_modulos.php?opt=modulo',
						url: '/app/si_cf_modulo/updateOper',
						type:'post',
						data:{
							IDM:node.id,
							modulo: node.Modulo,
							op : node.operacion,
							Desc : node.Descripcion,
							File : node.FileManual
						},
						dataType:'json',
						success:function(){
							$.messager.show({
								title: 'Atencion',
								msg:'Modulo actualizado'
							});
						}
					});
				
			}
		}
		function cancelNode(){
			var node = $('#tt').treegrid('getSelected');
			if (node){
				$('#tt').treegrid('cancelEdit',node.id);
			}
		}
	</script>
</head>
<body>
	<h2><?php echo $modDesc ?></h2>
	
	<div style="margin:10px 0">
		<a href="javascript:void(0)" onclick="expandAll()" class="easyui-linkbutton">Expandir</a>

		<a href="javascript:void(0)" onclick="editNode()" class="easyui-linkbutton">Editar</a>
		<a href="javascript:void(0)" onclick="saveNode()" class="easyui-linkbutton">Guardar</a>
		<a href="javascript:void(0)" onclick="cancelNode()" class="easyui-linkbutton">Cancelar</a>
	</div>
	
	<table id="tt" class="easyui-treegrid" style="width:1100px;height:400px"
			data-options="idField:'id',treeField:'text',
					rownumbers:true,pagination:false,fitColumns:false,autoRowHeight:false">
		<thead>
			<tr>
				<th data-options="field:'text'" rowspan="2" width="250">Modulos</th>
				<th data-options="field:'Componente'" rowspan="2" width="250">Componente</th>
				<th data-options="field:'Modulo',editor:'text'" width="180">URL</th>
				<th data-options="field:'operacion',editor:'text'" width="180">Operaciones</th>
				<th data-options="field:'Desc',editor:'text'" width="180">Descripcion</th>
				<th data-options="field:'File',editor:'text'" width="120">Manual</th>
	
			</tr>
		</thead>
	</table>
	
</body>
</html>