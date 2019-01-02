<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $config->get('appName')?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/icon.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>demo/demo.css">
	<script type="text/javascript" src="<?php echo $config->get('jqueryFolder')?>jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.easyui.min.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.portal.js"></script>
	<!--<script type="text/javascript" src="<?php //echo $config->get('jeasiUIFolder')?>jquery.edatagrid.js"></script>-->
	<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.etree.js"></script>
	<link rel="stylesheet" type="text/css" href="jeasyui/portal.css">
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
	
	
	<script>
		$(function(){
			$('#pp').portal({
				border:false,
				fit:true
			});
		//	add();
		});
		
		function selectPerfilOper(){
			
			var node = $('#tt').etree('getSelected');
					//puedes acceder a cualquier valor de los de la tabla
			
			if (!node){
				
				$.messager.alert('Atenci&oacute;n','Debe seleccionar un Perfil !!','error');
			}else{
				
				if($('#tt').etree('isLeaf', node.target)){
			      //	console.log(node);
			      //	alert(row.id);
				      $('#ttOperacion').etree({				
					      url: '/app/si_cf_modulo/listAllWith/0-1-' + node.id,
					      updateUrlOper : '/app/si_cf_perfil/updateOper'
				      });
				      
				      $('#ttOperacion').etree('reload');
			      }
			}	
		}
		
		function updatePerfilOper(){
			
			//var row = $('#dg').edatagrid('getSelected');
			
			var row = $('#tt').etree('getSelected');

					//puedes acceder a cualquier valor de los de la tabla
			
			if (!row){
				
				$.messager.alert('Atenci&oacute;n','Debe seleccionar un Perfil !!','error');
			}else{
			//	alert(row.id);
				
				var nodesChecked = $('#ttOperacion').etree('getChecked');
			 
			 //console.log(row);
				console.log(nodesChecked);
				
				var stroper = new Array();
				 
				var rowcount = nodesChecked.length;
				for(var i=0; i<rowcount; i++){
					//console.log(nodesChecked[i].id);
				
					//if(nodesChecked[i].id.indexOf('_') == 1){
							stroper.push(nodesChecked[i].id);
					//console.log(nodesChecked[i].id);
					//}
				}
				//console.log(stroper);
				$.ajax({
					url: '/app/si_cf_perfil/updateOper/' + row.id,
					type: 'post',
					dataType: 'json',
					data: {
						isopr : stroper.join()
					},
					success: function(){
						
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
				url: '/app/si_cf_perfil/listAll',
				createUrl: '/app/si_cf_perfil/create',  
				updateUrl: '/app/si_cf_perfil/update',  
				destroyUrl: '/app/si_cf_perfil/delete',  
				dndUrl: '/app/si_cf_perfil/dragndrop',
				//updateUrlOper : 'includes/tree_perfiles.php?opt=update_oper'
			});
			
			
		});
	</script>
	
</head>
<body>
	<div class="easyui-panel" title="<?php echo $modDesc ?>" style="width:800px;height:480px;padding:5px;">
		<div class="easyui-layout" data-options="fit:true">
			<div data-options="region:'west',split:true" style="width:395px;padding:5px">
				<div id="p" class="easyui-panel" style="width:380px;height:400px;"
						data-options="title:'Perfil',iconCls:'icon-save',toolbar:'#toolbar'">
					<div id="toolbar">
						<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#tt').etree('create')">Nuevo</a>
						<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:$('#tt').etree('destroy')">Eliminar</a>
						<a href="#" class="easyui-linkbutton" iconCls="icon-tip" plain="true" onclick="selectPerfilOper()">Operaciones</a>
					</div>
						<ul id="tt" checkbox="false" lines="true"></ul>
				</div>
			</div>
			<div data-options="region:'center'" style="width:260px;padding:5px">
					<div title="Modulos y Operaciones" style="margin-bottom:10px;margin-right:100px;width:300px;height:402px">
						<a href="#" onclick="updatePerfilOper()" class="easyui-linkbutton">Guardar Operaciones</a>
						<ul id="ttOperacion" checkbox="true"  lines="true"></ul>	
					</div>
			</div>
		</div>
	</div>
	
</body>
</html>