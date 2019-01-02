<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<?php	echo Lib\APPUtil::headerView(); ?>
	
	<script type="text/javascript">
		$(function(){
			
		
			$('#tt').treegrid({url: '/app/si_cf_modulo/getNodo/1',
						idField:'id',
						treeField:'text',
					columns:[[
						{title:'Modulo',field:'text',width:250},
						{title:'Componente',field:'COMPONENTE',editor:'text',width:250},
						{title:'URL',field:'Modulo',editor:'text',width:180},
						{title:'Operaciones',field:'operacion',editor:'text',width:180},
						{title:'Icono',field:'ICONO',editor:'text',width:180},
						{title:'Descripcion',field:'DESCRIPCION',editor:'text',width:120},
						{title:'Manual',field:'FILEMANUAL',editor:'text',width:180}
					  ]],
					
					onDblClickCell: function(index,field,value){
							var node = $('#tt').treegrid('getSelected');
							if (node){
								$('#tt').treegrid('beginEdit',node.id);
							}
						}

			});
			
			$('#tt').treegrid('reload');
		
			//$('#tt').treegrid();
			
			//$('#tt').treegrid('expandAll');
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
				
				$.ajax({
						url: '/app/si_cf_modulo/updateOper',
						type:'post',
						data:{
							IDM:node.id,
							modulo: node.Modulo,
							op : node.operacion,
							DESCRIPCION : node.DESCRIPCION,
							FILEMANUAL : node.FILEMANUAL,
							ICONO : node.ICONO,
							COMPONENTE : node.COMPONENTE
							
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
	<table id="tt" style="width:700px;height:400px" title="<?php echo $modDesc; ?>" fit="true" toolbar="#toolbar"></table>
	
	<div id="toolbar">
		<a href="javascript:void(0)" onclick="expandAll()" class="easyui-linkbutton">Expandir</a>

		<a href="javascript:void(0)" onclick="editNode()" class="easyui-linkbutton">Editar</a>
		<a href="javascript:void(0)" onclick="saveNode()" class="easyui-linkbutton">Guardar</a>
		<a href="javascript:void(0)" onclick="cancelNode()" class="easyui-linkbutton">Cancelar</a>
	</div>
	
</body>
</html>