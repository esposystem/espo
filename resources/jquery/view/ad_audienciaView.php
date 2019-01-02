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
                    $('#dg').datagrid('enableFilter' ,[ {
				field:'IDESTADO',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/ad_dm_estado/list',
					valueField: 'IDESTADO',  
					textField: 'IDESTADO',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDESTADO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDESTADO',
								op: 'join',
								value: value,
								param: 'IDESTADO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDPETICION',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pt_peticion/list',
					valueField: 'IDPETICION',  
					textField: 'IDPETICION',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDPETICION');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDPETICION',
								op: 'join',
								value: value,
								param: 'IDPETICION'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDDESPACHO',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/dj_despacho/list',
					valueField: 'IDDESPACHO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDDESPACHO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDDESPACHO',
								op: 'join',
								value: value,
								param: 'IDDESPACHO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDJUEZ',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/jz_juez/list',
					valueField: 'IDJUEZ',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDJUEZ');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDJUEZ',
								op: 'join',
								value: value,
								param: 'IDJUEZ'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDSALA',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/er_sala/list',
					valueField: 'IDSALA',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDSALA');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDSALA',
								op: 'join',
								value: value,
								param: 'IDSALA'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDSALACSJ',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/dj_sala/list',
					valueField: 'IDSALA',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDSALACSJ');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDSALACSJ',
								op: 'join',
								value: value,
								param: 'IDSALA'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			} ]);    
                });   
                    
		function newRecord(){
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			
			url = '/app/ad_audiencia/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/ad_audiencia/update/'+row.IDAUDIENCIA;
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
	<h2><?php echo $modDesc ?></h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Haga click en los botones de la barra de herramientas de la grilla para realizar las operaciones.</div>
	</div>
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:700px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/ad_audiencia/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="IDESTADO" width="50" sortable="true">Estado</th>
				<th field="IDPETICION" width="50" sortable="true">Petici&oacute;n</th>
				<th field="IDDESPACHO" width="50" sortable="true">Despacho Radica</th>
				<th field="IDJUEZ" width="50" sortable="true">Juez</th>
				<th field="IDSALA" width="50" sortable="true">Sala Centro Reclusi&oacute;n</th>
				<th field="IDSALACSJ" width="50" sortable="true">Sala Centro Centro de Servicios Judiciales</th>
				<th field="FECHAAUDIENCIA" width="50" sortable="true">FECHAAUDIENCIA</th>
				<th field="HORAAUDIENCIA" width="50" sortable="true">HORAAUDIENCIA</th>
				<th field="NUMDOCUMENTO" width="50" sortable="true">Numero de Documento</th>
				<th field="NUMRADICADOPROC" width="50" sortable="true">Numero de Proceso</th>
				<th field="CONCEDIDA" width="50" sortable="true">Concedida</th>
				<th field="CONSIDERACIONES" width="50" sortable="true">Consideraciones</th>
				<th field="FUNDLEGALES" width="50" sortable="true">Fundamentos Legales</th>
				<th field="DECISION" width="50" sortable="true">Decision</th>
				<th field="OBSERVACIONES" width="50" sortable="true">Observaciones</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:550px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Estado</label>
				<input id="ccb" class="easyui-combobox" name="IDESTADO" value="" required="true"
			    data-options="valueField: 'IDESTADO',  
                            textField: 'IDESTADO', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/ad_dm_estado/list'" />
			</div>
			<div class="fitem">
				<label>Petici&oacute;n</label>
				<input id="ccb" class="easyui-combobox" name="IDPETICION" value="" required="true"
			    data-options="valueField: 'IDPETICION',  
                            textField: 'IDPETICION', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pt_peticion/list'" />
			</div>
			<div class="fitem">
				<label>Despacho Radica</label>
				<input id="ccb" class="easyui-combobox" name="IDDESPACHO" value="" required="true"
			    data-options="valueField: 'IDDESPACHO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_despacho/list'" />
			</div>
			<div class="fitem">
				<label>Juez</label>
				<input id="ccb" class="easyui-combobox" name="IDJUEZ" value="" required="true"
			    data-options="valueField: 'IDJUEZ',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/jz_juez/list'" />
			</div>
			<div class="fitem">
				<label>Sala Centro Reclusi&oacute;n</label>
				<input id="ccb" class="easyui-combobox" name="IDSALA" value="" required="true"
			    data-options="valueField: 'IDSALA',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/er_sala/list'" />
			</div>
			<div class="fitem">
				<label>Sala Centro Centro de Servicios Judiciales</label>
				<input id="ccb" class="easyui-combobox" name="IDSALACSJ" value="" required="true"
			    data-options="valueField: 'IDSALA',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_sala/list'" />
			</div>
			<div class="fitem">
				<label>FECHAAUDIENCIA</label>
				<input name="FECHAAUDIENCIA" class="easyui-datebox textbox" readonly >
			</div>
			<div class="fitem">
				<label>HORAAUDIENCIA</label>
				<input name="HORAAUDIENCIA" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Numero de Documento</label>
				<input name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Numero de Proceso</label>
				<input name="NUMRADICADOPROC" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Concedida</label>
				<input name="CONCEDIDA" class="easyui-validatebox" >
			</div>
			<div class="fitem">
				<label>Consideraciones</label>
				<textarea name="CONSIDERACIONES"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Fundamentos Legales</label>
				<textarea name="FUNDLEGALES"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Decision</label>
				<textarea name="DECISION"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Observaciones</label>
				<textarea name="OBSERVACIONES"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
