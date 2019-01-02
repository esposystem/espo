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
			
			$('#IDPADRE').combotree({
						url: '/app/gs_dm_actividad/getTree',
						required: true,
						width:260
					    });
			
                    $('#dg').datagrid('enableFilter' ,[ {
				field:'IDPADRE',
				type:'combobox',
				options:{
					panelHeight:'160',
					loader : cloader,
					url:'/app/gs_dm_actividad/list',
					valueField: 'IDACTIVIDAD',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDPADRE');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDPADRE',
								op: 'join',
								value: value,
								param: 'IDACTIVIDAD'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'CLASEACTIVIDAD',
				type:'combobox',
				options:{
					panelHeight:'160',
					loader : cloader,
					url:'/app/gs_dm_claseactividad/list',
					valueField: 'IDCLASEACTIVIDAD',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'CLASEACTIVIDAD');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'CLASEACTIVIDAD',
								op: 'join',
								value: value,
								param: 'IDCLASEACTIVIDAD'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'PERIODO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'LS',  text:'LS' },{value:'DD',  text:'DD' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'PERIODO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'PERIODO',
									    op: 'equal',
									    value: value
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
				    } ]);    
                });   
                    
		function newRecord(){
			
			$('#IDPADRE').combotree('reload');
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			$('input[name="PERIODO"]').filter('[value=]').prop('checked', true);
			$('input[name="ESTADO"]').filter('[value=Activo]').prop('checked', true);
			url = '/app/gs_dm_actividad/create';
			
			
		}
		
		function editRecord(){
			$('#IDPADRE').combotree('reload');
			
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_dm_actividad/update/'+row.IDACTIVIDAD;
			}
		}
		function saveRecord(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					console.log($('#fm'));
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
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:810px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_dm_actividad/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="CODIGO" width="20" sortable="true">C&oacute;digo</th>
				<th field="ACTIVIDAD_PRE" width="50" sortable="true">Actividad Predecesora</th>
				<th field="NOMBRE" width="50" sortable="true">Nombre Actividad</th>
				<th field="CLASEACTIVIDAD" width="50" sortable="true">Clase</th>
				<th field="PERIODO" width="50" sortable="true">Periodo</th>
				<th field="ESTADO" width="20" sortable="true">Estado</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:355px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>C&oacute;digo</label>
				<input name="CODIGO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Actividad Predecesora</label>
				<!--<select class="easyui-combotree" name="IDPADRE" url="/app/gs_dm_actividad/getTree" name="IDPADRE" style="width:266px;"/>
				</select>-->
				<input id="IDPADRE" name="IDPADRE" value="">
					
					
			</div>
			
			<div class="fitem">
				<label>Nombre</label>
				<input name="NOMBRE" class="easyui-validatebox" validType="text"  required="true" style="width:196px;">
			</div>
			<div class="fitem">
				<label>Clase</label>
				<input id="ccb" class="easyui-combobox" name="IDCLASEACTIVIDAD" value="" required="true"
			    data-options="valueField: 'IDCLASEACTIVIDAD',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/gs_dm_claseactividad/list'" />
			</div>
			<div class="fitem">
				<label>Periodo &raquo; Lunes a S&aacute;bado o Domingo a Domingo </label>
				<input type="radio" id="PERIODO" class="easyui-validatebox" name="PERIODO" value="LS" >LS<input type="radio" id="PERIODO" class="easyui-validatebox" name="PERIODO" value="DD" >DD
			</div>
			<div class="fitem">
				<label>Estado</label>
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
