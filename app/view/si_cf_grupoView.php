<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Fenix :: Grupo</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/icon.css">
	<?php	echo Lib\APPUtil::headerView(); ?>
	
	
	<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.edatagrid.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.etree.js"></script>

		<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.portal.js"></script>
		<style type="text/css">
		.title{
			font-size:16px;
			font-weight:bold;
			padding:10px 5px;
			background:#eee;
			overflow:hidden;
		//	border-bottom:0px solid #ccc;
		}
		.t-list{
			padding:5px;
		}
	</style>
	<script type="text/javascript">
		
		$(function(){
			$('#pp').portal({
				border:false,
				fit:true
			});
		//	add();
		});
		
		$(function(){
			$('#dg').edatagrid({
				url: '/app/si_cf_grupo/list',
				saveUrl: '/app/si_cf_grupo/create',
				updateUrl: '/app/si_cf_grupo/update',
				destroyUrl: '/app/si_cf_grupo/delete'
			});
		});
		
		function selectPerfilOper(){
			
			var row = $('#dg').edatagrid('getSelected');
					//puedes acceder a cualquier valor de los de la tabla
			
			if (!row){
				
				$.messager.alert('Atenci&oacute;n','Debe seleccionar un Perfil !!','error');
			}else{
				console.log(row);
			//	alert(row.id);
				$('#tt').etree({				
				 	url: '/app/si_cf_perfil/listAllWith/0-' + row.IDGRUPO,
					updateUrlOper : '/app/si_cf_perfil/updateOper'
			});
				
				$('#tt').etree('reload');

			}	
		}
		
		function updatePerfilOper(){
			
			var row = $('#dg').edatagrid('getSelected');
					//puedes acceder a cualquier valor de los de la tabla
			
			if (!row){
				
				$.messager.alert('Atenci&oacute;n','Debe seleccionar un Perfil !!','error');
			}else{
			//	alert(row.id);
				
				var nodesChecked = $('#tt').etree('getChecked');
			 
				console.log(nodesChecked);
				
				var stroper = new Array();
				 
				var rowcount = nodesChecked.length;
				for(var i=0; i<rowcount; i++){
					console.log(nodesChecked[i]);
				
					if($('#tt').etree('isLeaf', nodesChecked[i].target))

					//if(nodesChecked[i].id.indexOf('_') == 1)
							stroper.push(nodesChecked[i].id);
				}
				console.log(stroper);
				console.log(row);
				$.ajax({
					url: '/app/si_cf_grupo/updateOper/' + row.IDGRUPO,
					type: 'post',
					dataType: 'json',
					data: {
						isopr : stroper.join()
					},
					success: function(){
						console.log("CREADO GRUPO");
						
						$.messager.show({
							title: 'Atencion',
							msg:'Operaciones actualizadas'
						});		
					}
				});
			}	
		}
		
	</script>
	
	<script type="text/javascript">
		$(function(){
			$('#tt').etree({
				//url: 'includes/tree_perfiles.php?opt=listAll&oper=0',
				updateUrlOper : 'includes/tree_perfiles.php?opt=update_Gperfil'
			});
			
			
		});
	</script>
	
</head>

<body>
	<div class="easyui-panel" title="<?php echo $modDesc ?>" style="width:800px;height:480px;padding:5px;">
	
	<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'west',split:true" style="width:395px;padding:5px">
			<table id="dg" idField="IDGRUPO" title="Grupo" style="width:380px;height:400px" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
					<thead>
						<tr>
							<th field="NOMBRE" width="50" editor="{type:'validatebox',options:{required:true}}">Nombre</th>
							<th field="DESCRIPCION" width="50" editor="{type:'validatebox',options:{required:true}}">Descripcion</th>
						</tr>
					</thead>
				</table>
				<div id="toolbar">
					<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">Nuevo</a>
					<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:$('#dg').edatagrid('destroyRow')">Eliminar</a>
					<a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Guardar</a>
					<a href="#" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancelar</a>
					<a href="#" class="easyui-linkbutton" iconCls="icon-tip" plain="true" onclick="selectPerfilOper()">Perfiles</a>
			
				</div>
		</div>
		<div data-options="region:'center'" style="width:260px;padding:5px">
				<div title="Perfiles" style="margin-bottom:10px;margin-right:5px;width:250px;height:402px">
					<a href="#" onclick="updatePerfilOper()" class="easyui-linkbutton">Guardar Perfiles</a>
					<ul id="tt" checkbox="true"  lines="true"></ul>	
				</div>
		</div>
	</div>
	</div>
	
</body>



</html>