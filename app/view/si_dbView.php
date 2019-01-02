<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $config->get('appName')?></title>	
		
		<?php	echo Lib\APPUtil::headerView(); ?>

	<script type="text/javascript">
		var url,tabla;
                
                $(function(){
			
			$('#tt').tree({
				onClick: function(node){
					$('#dg').datagrid({				
					      url: '/app/si_db/tableStruct/' + node.id
				      });
					tabla = node.id;
					$('#dg').datagrid('reload');  // alert node text property when clicked
				}
			});
		
                });   
                
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Ver Detalle');
				$('#fm').form('load',row);
				url = '/app/si_log/update/'+row.IDLog;
			}
		}
		
		function exportData(){
			
			var param = {};
			var row = $('#dg').datagrid('getSelected');
			
			if (!row){
				
				$.messager.alert('Atenci&oacute;n','Debe seleccionar los campos de la tabla !!','error');
			}else{
				$.messager.progress({ title: 'Generando Datos',
						msg: 'Espere por favor',
						text:'Enviando Datos',
						interval : '80'
					});
				
				var stroper = new Array();
				 
				var nodesChecked = $('#dg').datagrid('getChecked');
				var rowcount = nodesChecked.length;
				
				for(var i=0; i<rowcount; i++)
					stroper.push(nodesChecked[i].COLUMN_NAME);
				
				param["isopr"] = stroper.join();
				
				loadAjaxData('/app/si_db/export/' + tabla,param,function(result) {
					
					$.messager.progress('close');
					
					if (result.success)
						$.messager.alert('Confirmaci&oacute;n',result.msg,'info');
					else 
						$.messager.alert('Warning',result.msg,'warning');
					
				}); // end loadajaxdata
				
			} // end else
		}
		function exportData2(){
			
			var row = $('#dg').datagrid('getSelected');
			
			console.log(row);
			
			if (!row){
				
				$.messager.alert('Atenci&oacute;n','Debe seleccionar los campos de la tabla !!','error');
			}else{
				
				$.messager.progress({ title: 'Generando Datos',
						msg: 'Espere por favor',
						text:'Enviando Datos',
						interval : '80'
					});
				
				var nodesChecked = $('#dg').datagrid('getChecked');
			 
			 //console.log(row);
				console.log(nodesChecked);
				
				var stroper = new Array();
				 
				var rowcount = nodesChecked.length;
				for(var i=0; i<rowcount; i++){
					//console.log(nodesChecked[i].id);
				
					//if(nodesChecked[i].id.indexOf('_') == 1){
							stroper.push(nodesChecked[i].COLUMN_NAME);
					//console.log(nodesChecked[i].id);
					//}
				}
				//console.log(stroper);
				$.ajax({
					url: '/app/si_db/export/' + tabla,
					type: 'post',
					dataType: 'json',
					data: {
						isopr : stroper.join()
					},
					success: function(){
						
					//	'<a href="/app/pt_peticion/download/'+ tabla'" >
					// Click aqui para descargar Archivo</a>
					 
					 $.messager.progress('close');
				if (result.success)
					$.messager.alert('Confirmaci&oacute;n',result.msg,'info');
				else 
					$.messager.alert('Warning',result.msg,'warning');
					

						$.messager.alert('Confirmaci&oacute;n','Generando Archivo de Datos !!','info');
								
					}
				});
			}	
		}

	</script>
</head>

<body>
	<div class="easyui-panel" title="<?php echo $modDesc ?>" style="width:1100px;height:480px;padding:5px;">
		<div class="easyui-layout" data-options="fit:true">
		    <div data-options="region:'west',split:true" style="width:230px;padding:5px">
			<ul id="tt" class="easyui-tree" url="/app/si_db/list">
			</ul>
		    </div>
		    <div data-options="region:'center'" style="width:100px;padding:5px">
				<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:830px;height:400px"
				     data-options="url:''"
						 toolbar="#toolbar" pagination="false"
						 rownumbers="true" fitColumns="true" singleSelect="false">
					 <thead>
						<tr>   <th data-options="field:'ck',checkbox:true"></th>
							<th field="COLUMN_NAME" width="30" sortable="true">Nombre Columna</th>
							<th field="DATA_TYPE" width="30" sortable="true">Tipo de Dato</th>
							<th field="CHARACTER_MAXIMUM_LENGTH" width="20" sortable="true">Longitud</th>
							<th field="IS_NULLABLE" width="30" sortable="true">Admite Null</th>
							<th field="COLUMN_DEFAULT" width="30" sortable="true">Default</th>
					</thead>
				 </table>
				 <div id="toolbar">
					 <a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="exportData()">Exportar Datos</a>
				 </div>
		    </div>
		</div>
	</div>
	 
	<div id="dlg" class="easyui-dialog" style="width:560px;height:408px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>M&oacute;dulo : </label>
				<input id="ccb" class="easyui-combobox" name="Modulo" value="" required="true"
			    data-options="valueField: 'IDModulo',  
                            textField: 'Nombre', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/si_cf_modulo/list'" />
			</div>
			<div class="fitem">
				<label>IDUsuario : </label>
				<input name="IDUsuario" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Fecha : </label>
				<input name="Fecha" readonly required="true" size="20" readonly readonly>
			</div>
			<div class="fitem">
				<label>Modulo : </label>
				<input name="Modulo" class="easyui-validatebox textbox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Transaccion : </label>
				<input name="Transaccion" class="easyui-validatebox textbox" validType="text"  required="true">
				<textarea name="Transaccion"  style="height: 60px;width:480px;" wrap="virtual" readonly=true></textarea>
			</div>
			<div class="fitem">
				<label>Operacion : </label>
				<input name="Operacion" class="easyui-validatebox textbox" validType="text"  readonly>

			</div>
			<div class="fitem">
				<label>DireccionIP : </label>
				<input name="DireccionIP" class="easyui-validatebox textbox" validType="text"  readonly>
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
	
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cerrar</a>
	</div>
</body>
</html>
