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
				field:'IDAUDIENCIA',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/ad_audiencia/list',
					valueField: 'IDAUDIENCIA',  
					textField: 'FECHAAUDIENCIA',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDAUDIENCIA');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDAUDIENCIA',
								op: 'join',
								value: value,
								param: 'IDAUDIENCIA'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'SEXO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'M',  text:'M' },{value:'F',  text:'F' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'SEXO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'SEXO',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
				field:'IDCIUDAD',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pr_dm_ciudad/list',
					valueField: 'IDCIUDAD',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDCIUDAD');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDCIUDAD',
								op: 'join',
								value: value,
								param: 'IDCIUDAD'
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
			$('input[name="SEXO"]').filter('[value=]').prop('checked', true);
			url = '/app/ad_asistente/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/ad_asistente/update/'+row.IDASISTENTE;
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
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/ad_asistente/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="IDAUDIENCIA" width="50" sortable="true">Audiencia</th>
				<th field="NUMERODOCUMENTO" width="50" sortable="true">Numero de Documento</th>
				<th field="NOMBRE" width="50" sortable="true">Nombre del Asistente</th>
				<th field="APELLIDO" width="50" sortable="true">Apellido del Asistente</th>
				<th field="FECHANACIMIENTO" width="50" sortable="true">Fecha de Nacimiento</th>
				<th field="SEXO" width="50" sortable="true">Sexo</th>
				<th field="RELACION" width="50" sortable="true">Relaci&oacute;n con el Condenado</th>
				<th field="DIRECCION" width="50" sortable="true">Direcci&oacute;n</th>
				<th field="TELEFONO" width="50" sortable="true">Tel&eacute;fono</th>
				<th field="EMAIL" width="50" sortable="true">Email</th>
				<th field="IDCIUDAD" width="50" sortable="true">Ciudad</th>
				<th field="INTERVINIENTE" width="50" sortable="true">Sujeto Interviniente</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:472px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Audiencia</label>
				<input id="ccb" class="easyui-combobox" name="IDAUDIENCIA" value="" required="true"
			    data-options="valueField: 'IDAUDIENCIA',  
                            textField: 'FECHAAUDIENCIA', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/ad_audiencia/list'" />
			</div>
			<div class="fitem">
				<label>Numero de Documento</label>
				<input name="NUMERODOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Nombre del Asistente</label>
				<input name="NOMBRE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Apellido del Asistente</label>
				<input name="APELLIDO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Nacimiento</label>
				<input name="FECHANACIMIENTO" class="easyui-datebox textbox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Sexo</label>
				<input type="radio" id="SEXO" class="easyui-validatebox" name="SEXO" value="M" >M<input type="radio" id="SEXO" class="easyui-validatebox" name="SEXO" value="F" >F
			</div>
			<div class="fitem">
				<label>Relaci&oacute;n con el Condenado</label>
				<input name="RELACION" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Direcci&oacute;n</label>
				<input name="DIRECCION" class="easyui-validatebox" validType="text"  >
			</div>
			<div class="fitem">
				<label>Tel&eacute;fono</label>
				<input name="TELEFONO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Email</label>
				<input name="EMAIL" class="easyui-validatebox" validType="email"  required="true">
			</div>
			<div class="fitem">
				<label>Ciudad</label>
				<input id="ccb" class="easyui-combobox" name="IDCIUDAD" value="" required="true"
			    data-options="valueField: 'IDCIUDAD',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pr_dm_ciudad/list'" />
			</div>
			<div class="fitem">
				<label>Sujeto Interviniente</label>
				<input name="INTERVINIENTE" class="easyui-validatebox" required="true">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
