<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $config->get('appName')?></title>	
		
		<?php	echo Lib\APPUtil::headerView(); ?>

	<script type="text/javascript">
		var url;
                
                $(function(){
                   $('#dg').datagrid('enableFilter' ,[ {
					    field:'ESTADO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Activo',  text:'Activo' },{value:'Inactivo',  text:'Inactivo' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'ESTADO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'ESTADO',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    } ]);   
                });   
                    
		function newRecord(){
			$('#dlg').dialog('open').dialog('setTitle','Crear <?php echo $opcDesc; ?>');
			$('#fm').form('clear');
			$('input[name="ESTADO"]').filter('[value=Activo]').prop('checked', true);
			url = '/app/si_cf_parametro/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar <?php echo $opcDesc; ?>');
				$('#fm').form('load',row);
				url = '/app/si_cf_parametro/update/'+row.IDPARAMETRO;
			}
		}
		function saveRecord(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
                                        
					if (result.success){
                                                
                                                $.messager.show({
							title: 'Confirmaci&oacute;n',
							msg: result.msg
						});
                                                
						$('#dlg').dialog('close');	// close the dialog
						$('#dg').datagrid('reload');	// reload the user data
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
				}
			});
		}	
	</script>
</head>

<body>
<table id="dg" title="<?php echo $modDesc; ?>" fit="true" class="easyui-datagrid" style="height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/si_cf_parametro/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    					<th field="IDPARAMETRO" width="20" sortable="true">Nombre </th>
				<th field="VALOR" width="20" sortable="true">Valor </th>
				<th field="DESCRIPCION" width="50" sortable="true">Descripci&oacute;n</th>
				<th field="ESTADO" width="10" sortable="true">Estado</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:298px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Nombre:</label>
				<input name="IDPARAMETRO" class="easyui-validatebox textbox" validType="text" size="60" required="true">
			</div>
			<div class="fitem">
				<label>Valor prueba:</label>
				<input name="VALOR" class="easyui-validatebox textbox lowercase" validType="text"  size="60" required="true">
			</div>
			<div class="fitem">
				Descripci&oacute;n:<br>
				<textarea name="DESCRIPCION"  style="height: 40px;width:380px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Estado:  </label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Activo" checked="checked">Activo<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Inactivo" >Inactivo
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
