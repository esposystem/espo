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
				field:'Modulo',
				type:'combobox',
				options:{
					panelHeight:'180',
					loader : cloader,
					url:'/app/si_cf_modulo/list',
					valueField: 'IDMODULO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'Modulo');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'Modulo',
								op: 'join',
								value: value,
								param: 'IDModulo'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			} ]);
                   
                });   
                
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Ver Detalle');
				$('#fm').form('load',row);
				url = '/app/si_log/update/'+row.IDLog;
			}
		}
		

	</script>
</head>

<body>
<table id="dg" title="<?php echo $modDesc; ?>" fit="true" class="easyui-datagrid" style="width:980px;height:424px"
	    
	    data-options="pageSize: 20,remoteFilter:true,url:'/app/si_log/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="Modulo" width="50" sortable="true">M&oacute;dulo</th>
				<th field="Tabla" width="40" sortable="true">Tabla</th>
				<th field="Usuario" width="50" sortable="true">Usuario</th>
				<th field="Fecha" width="40" sortable="true">Fecha (aaa-dd-mm)</th>
				<th field="Operacion" width="20" sortable="true">Operaci&oacute;n</th>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Ver Detalle</a>
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
				<label>Módulo : </label>
				<input name="Modulo" class="easyui-validatebox textbox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Transacción : </label>
				<input name="Transaccion" class="easyui-validatebox textbox" validType="text"  required="true">
				<textarea name="Transaccion"  style="height: 60px;width:480px;" wrap="virtual" readonly=true></textarea>
			</div>
			<div class="fitem">
				<label>Operación : </label>
				<input name="Operacion" class="easyui-validatebox textbox" validType="text"  readonly>

			</div>
			<div class="fitem">
				<label>Dirección IP : </label>
				<input name="DireccionIP" class="easyui-validatebox textbox" validType="text"  readonly>
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
	
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cerrar</a>
	</div>
</body>
</html>
