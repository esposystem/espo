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
                <script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>locale/easyui-lang-es.js"></script>
                <script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>datagrid-filter.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>viewUtils.js"></script>

	<script type="text/javascript">
		var url;
                
                $(function(){
			
			$('#tt').tree({
				onClick: function(node){
					$('#dg').datagrid({				
					      url: '/app/si_db/tableStruct/' + node.id
				      });
					  
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
		

	</script>
</head>

<body>
	<div class="easyui-panel" title="<?php echo $modDesc ?>" style="width:1100px;height:420px;padding:5px;">
        <div class="easyui-layout" data-options="fit:true">
            <div data-options="region:'west',split:true" style="width:230px;padding:5px">
                <ul id="tt" class="easyui-tree" url="/app/si_db/list">
		</ul>
            </div>
            <div data-options="region:'center'" style="width:100px;padding:5px">
			<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:1110px;height:424px"
			     data-options="pageSize: 20,remoteFilter:true,url:'/app/si_log/list'"
					 toolbar="#toolbar" pagination="true"
					 rownumbers="true" fitColumns="true" singleSelect="true">
				 <thead>
					<tr>
						<th field="COLUMN_NAME" width="50" sortable="true">Nombre Columna</th>
						<th field="DATA_TYPE" width="40" sortable="true">Tipo de Dato</th>
						<th field="CHARACTER_MAXIMUM_LENGTH" width="50" sortable="true">Longitud</th>
						<th field="IS_NULLABLE" width="40" sortable="true">Admite Null</th>
						<th field="COLUMN_DEFAULT" width="40" sortable="true">Default</th>
				</thead>
			 </table>
			 <div id="toolbar">
				 <a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Ver Detalle</a>
			 </div>
            </div>
            
        </div>
    </div>
	 
	<div id="dlg" class="easyui-dialog" style="width:560px;height:408px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>M&oacute;dulo</label>
				<input id="ccb" class="easyui-combobox" name="Modulo" value="" required="true"
			    data-options="valueField: 'IDModulo',  
                            textField: 'Nombre', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/si_cf_modulo/list'" />
			</div>
			<div class="fitem">
				<label>IDUsuario</label>
				<input name="IDUsuario" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Fecha</label>
				<input name="Fecha" readonly required="true" size="20" readonly readonly>
			</div>
			<div class="fitem">
				<label>Modulo</label>
				<input name="Modulo" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Transaccion</label>
				<input name="Transaccion" class="easyui-validatebox" validType="text"  required="true">
				<textarea name="Transaccion"  style="height: 60px;width:480px;" wrap="virtual" readonly=true></textarea>
			</div>
			<div class="fitem">
				<label>Operacion</label>
				<input name="Operacion" class="easyui-validatebox" validType="text"  readonly>

			</div>
			<div class="fitem">
				<label>DireccionIP</label>
				<input name="DireccionIP" class="easyui-validatebox" validType="text"  readonly>
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
	
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cerrar</a>
	</div>
</body>
</html>
