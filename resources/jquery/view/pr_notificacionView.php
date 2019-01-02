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
				field:'IDTIPONOTIFICACION',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pr_tiponotificacion/list',
					valueField: 'IDTIPONOTIFICACION',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDTIPONOTIFICACION');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDTIPONOTIFICACION',
								op: 'join',
								value: value,
								param: 'IDTIPONOTIFICACION'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDUSUARIO',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/usuario/list',
					valueField: 'IDUSUARIO',  
					textField: 'USUARIO',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDUSUARIO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDUSUARIO',
								op: 'join',
								value: value,
								param: 'IDUSUARIO'
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
						    data:[{value:'',text:'Todos'},{value:'Pendiente',  text:'Pendiente' },{value:'Leido',  text:'Leido' },{value:'Eliminado',  text:'Eliminado' }],
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
					    field:'PRIORIDAD',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Alta',  text:'Alta' },{value:'Media',  text:'Media' },{value:'Baja',  text:'Baja' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'PRIORIDAD');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'PRIORIDAD',
									    op: 'equal',
									    value: value
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
			} ]);    
                });   
                    
		function newRecord(){
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			$('input[name="ESTADO"]').filter('[value=]').prop('checked', true);
$('input[name="PRIORIDAD"]').filter('[value=]').prop('checked', true);
			url = '/app/pr_notificacion/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/pr_notificacion/update/'+row.IDNOTIFICACION;
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
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/pr_notificacion/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="IDTIPONOTIFICACION" width="50" sortable="true">Tipo de Notificaci&oacute;n</th>
				<th field="IDUSUARIO" width="50" sortable="true">Usuario</th>
				<th field="TITULO" width="50" sortable="true">T&iacute;tulo</th>
				<th field="MENSAJE" width="50" sortable="true">Mensaje</th>
				<th field="ESTADO" width="50" sortable="true">Estado</th>
				<th field="PRIORIDAD" width="50" sortable="true">Prioridad</th>
				<th field="NUMDOCUMENTO" width="50" sortable="true">Numero de Documento</th>
				<th field="NUMRADICADOPROC" width="50" sortable="true">Numero de Proceso</th>
				<th field="IDPETICION" width="50" sortable="true">Petici&oacute;n</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:394px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Tipo de Notificaci&oacute;n</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPONOTIFICACION" value="" required="true"
			    data-options="valueField: 'IDTIPONOTIFICACION',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pr_tiponotificacion/list'" />
			</div>
			<div class="fitem">
				<label>Usuario</label>
				<input id="ccb" class="easyui-combobox" name="IDUSUARIO" value="" required="true"
			    data-options="valueField: 'IDUSUARIO',  
                            textField: 'USUARIO', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/usuario/list'" />
			</div>
			<div class="fitem">
				<label>T&iacute;tulo</label>
				<input name="TITULO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Mensaje</label>
				<input name="MENSAJE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Estado</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Pendiente" >Pendiente<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Leido" >Leido<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Eliminado" >Eliminado
			</div>
			<div class="fitem">
				<label>Prioridad</label>
				<input type="radio" id="PRIORIDAD" class="easyui-validatebox" name="PRIORIDAD" value="Alta" >Alta<input type="radio" id="PRIORIDAD" class="easyui-validatebox" name="PRIORIDAD" value="Media" >Media<input type="radio" id="PRIORIDAD" class="easyui-validatebox" name="PRIORIDAD" value="Baja" >Baja
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
				<label>Petici&oacute;n</label>
				<input id="ccb" class="easyui-combobox" name="IDPETICION" value="" required="true"
			    data-options="valueField: 'IDPETICION',  
                            textField: 'IDPETICION', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pt_peticion/list'" />
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
