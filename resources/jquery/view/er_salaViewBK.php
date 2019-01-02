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
                 //   $('#dg').datagrid({ remoteFilter:true,url:'/app/er_sala/list' });       
                    $('#dg').datagrid('enableFilter' ,[ {
				field:'IDESTABLECIMIENTO',
				type:'combobox',
				options:{
					panelHeight:'150',
					loader : cloader,
					url:'/app/er_establecimiento/list',
					valueField: 'IDESTABLECIMIENTO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDESTABLECIMIENTO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDESTABLECIMIENTO',
								op: 'join',
								value: value,
								param: 'IDESTABLECIMIENTO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDTIPOSALA',
				type:'combobox',
				options:{
					panelHeight:'150',
					loader : cloader,
					url:'/app/er_dm_tiposala/list',
					valueField: 'IDTIPOSALA',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDTIPOSALA');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDTIPOSALA',
								op: 'join',
								value: value,
								param: 'IDTIPOSALA'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
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
				    },{
					    field:'ACTIVODIA1',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Activo',  text:'Activo' },{value:'Inactivo',  text:'Inactivo' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'ACTIVODIA1');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'ACTIVODIA1',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'ACTIVODIA2',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Activo',  text:'Activo' },{value:'Inactivo',  text:'Inactivo' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'ACTIVODIA2');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'ACTIVODIA2',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'ACTIVODIA3',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Activo',  text:'Activo' },{value:'Inactivo',  text:'Inactivo' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'ACTIVODIA3');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'ACTIVODIA3',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'ACTIVODIA4',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Activo',  text:'Activo' },{value:'Inactivo',  text:'Inactivo' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'ACTIVODIA4');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'ACTIVODIA4',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'ACTIVODIA5',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Activo',  text:'Activo' },{value:'Inactivo',  text:'Inactivo' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'ACTIVODIA5');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'ACTIVODIA5',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'ACTIVODIA6',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Activo',  text:'Activo' },{value:'Inactivo',  text:'Inactivo' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'ACTIVODIA6');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'ACTIVODIA6',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'ACTIVODIA0',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Activo',  text:'Activo' },{value:'Inactivo',  text:'Inactivo' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'ACTIVODIA0');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'ACTIVODIA0',
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
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			$('input[name="ESTADO"]').filter('[value=Activo]').prop('checked', true);
$('input[name="ACTIVODIA1"]').filter('[value=Inactivo]').prop('checked', true);
$('input[name="ACTIVODIA2"]').filter('[value=Inactivo]').prop('checked', true);
$('input[name="ACTIVODIA3"]').filter('[value=Inactivo]').prop('checked', true);
$('input[name="ACTIVODIA4"]').filter('[value=Inactivo]').prop('checked', true);
$('input[name="ACTIVODIA5"]').filter('[value=Inactivo]').prop('checked', true);
$('input[name="ACTIVODIA6"]').filter('[value=Inactivo]').prop('checked', true);
$('input[name="ACTIVODIA0"]').filter('[value=Inactivo]').prop('checked', true);
			url = '/app/er_sala/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/er_sala/update/'+row.IDSALA;
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
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/er_sala/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="IDESTABLECIMIENTO" width="50" sortable="true">Establecimiento de Reclusi&oacute;n</th>
				<th field="IDTIPOSALA" width="50" sortable="true">Tipo de Sala</th>
				<th field="CODIGO" width="50" sortable="true">C&oacute;digo</th>
				<th field="NOMBRE" width="50" sortable="true">Nombre</th>
				<th field="CARACTERISTICAS" width="50" sortable="true">Caracteristicas</th>
				<th field="ESTADO" width="50" sortable="true">Estado</th>
				<th field="ACTIVODIA1" width="50" sortable="true">Lunes</th>
				<th field="DESDEDIA1" width="50" sortable="true">Desde</th>
				<th field="HASTADIA1" width="50" sortable="true">Hasta</th>
				<th field="ACTIVODIA2" width="50" sortable="true">Martes</th>
				<th field="DESDEDIA2" width="50" sortable="true">Martes</th>
				<th field="HASTADIA2" width="50" sortable="true">Hasta</th>
				<th field="ACTIVODIA3" width="50" sortable="true">Miercoles</th>
				<th field="DESDEDIA3" width="50" sortable="true">Desde</th>
				<th field="HASTADIA3" width="50" sortable="true">Hasta</th>
				<th field="ACTIVODIA4" width="50" sortable="true">Jueves</th>
				<th field="DESDEDIA4" width="50" sortable="true">Desde</th>
				<th field="HASTADIA4" width="50" sortable="true">Hasta</th>
				<th field="ACTIVODIA5" width="50" sortable="true">Viernes</th>
				<th field="DESDEDIA5" width="50" sortable="true">Desde</th>
				<th field="HASTADIA5" width="50" sortable="true">Hasta</th>
				<th field="ACTIVODIA6" width="50" sortable="true">Sabado</th>
				<th field="DESDEDIA6" width="50" sortable="true">Desde</th>
				<th field="HASTADIA6" width="50" sortable="true">Hasta</th>
				<th field="ACTIVODIA0" width="50" sortable="true">Domingo</th>
				<th field="DESDEDIA0" width="50" sortable="true">Desde</th>
				<th field="HASTADIA0" width="50" sortable="true">Hasta</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:862px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Establecimiento de Reclusi&oacute;n</label>
				<input id="ccb" class="easyui-combobox" name="IDESTABLECIMIENTO" value="" required="true"
			    data-options="valueField: 'IDESTABLECIMIENTO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/er_establecimiento/list'" />
			</div>
			<div class="fitem">
				<label>Tipo de Sala</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPOSALA" value="" required="true"
			    data-options="valueField: 'IDTIPOSALA',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/er_dm_tiposala/list'" />
			</div>
			<div class="fitem">
				<label>C&oacute;digo</label>
				<input name="CODIGO" class="easyui-validatebox" validType="text"  >
			</div>
			<div class="fitem">
				<label>Nombre</label>
				<input name="NOMBRE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Caracteristicas</label>
				<textarea name="CARACTERISTICAS"  style="height:60px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Estado</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Activo" checked="checked">Activo<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Inactivo" >Inactivo
			</div>
			<div class="fitem">
				<label>Lunes</label>
				<input type="radio" id="ACTIVODIA1" class="easyui-validatebox" name="ACTIVODIA1" value="Activo" >Activo<input type="radio" id="ACTIVODIA1" class="easyui-validatebox" name="ACTIVODIA1" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem">
				<label>Desde</label>
				<input name="DESDEDIA1" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Hasta</label>
				<input name="HASTADIA1" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Martes</label>
				<input type="radio" id="ACTIVODIA2" class="easyui-validatebox" name="ACTIVODIA2" value="Activo" >Activo<input type="radio" id="ACTIVODIA2" class="easyui-validatebox" name="ACTIVODIA2" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem">
				<label>Martes</label>
				<input name="DESDEDIA2" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Hasta</label>
				<input name="HASTADIA2" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Miercoles</label>
				<input type="radio" id="ACTIVODIA3" class="easyui-validatebox" name="ACTIVODIA3" value="Activo" >Activo<input type="radio" id="ACTIVODIA3" class="easyui-validatebox" name="ACTIVODIA3" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem">
				<label>Desde</label>
				<input name="DESDEDIA3" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Hasta</label>
				<input name="HASTADIA3" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Jueves</label>
				<input type="radio" id="ACTIVODIA4" class="easyui-validatebox" name="ACTIVODIA4" value="Activo" >Activo<input type="radio" id="ACTIVODIA4" class="easyui-validatebox" name="ACTIVODIA4" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem">
				<label>Desde</label>
				<input name="DESDEDIA4" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Hasta</label>
				<input name="HASTADIA4" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Viernes</label>
				<input type="radio" id="ACTIVODIA5" class="easyui-validatebox" name="ACTIVODIA5" value="Activo" >Activo<input type="radio" id="ACTIVODIA5" class="easyui-validatebox" name="ACTIVODIA5" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem">
				<label>Desde</label>
				<input name="DESDEDIA5" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Hasta</label>
				<input name="HASTADIA5" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Sabado</label>
				<input type="radio" id="ACTIVODIA6" class="easyui-validatebox" name="ACTIVODIA6" value="Activo" >Activo<input type="radio" id="ACTIVODIA6" class="easyui-validatebox" name="ACTIVODIA6" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem">
				<label>Desde</label>
				<input name="DESDEDIA6" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Hasta</label>
				<input name="HASTADIA6" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Domingo</label>
				<input type="radio" id="ACTIVODIA0" class="easyui-validatebox" name="ACTIVODIA0" value="Activo" >Activo<input type="radio" id="ACTIVODIA0" class="easyui-validatebox" name="ACTIVODIA0" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem">
				<label>Desde</label>
				<input name="DESDEDIA0" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
			<div class="fitem">
				<label>Hasta</label>
				<input name="HASTADIA0" class="easyui-timespinner" readonly  data-options="min:'08:30',showSeconds:false">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
