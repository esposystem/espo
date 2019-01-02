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
				field:'IDTIPOOFICIO',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/gs_dm_tipooficio/list',
					valueField: 'IDTIPOOFICIO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDTIPOOFICIO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDTIPOOFICIO',
								op: 'join',
								value: value,
								param: 'IDTIPOOFICIO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDACTUACIONPROCESO',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/gs_actuacionproceso/list',
					valueField: 'IDACTUACIONPROCESO',  
					textField: 'IDACTUACION',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDACTUACIONPROCESO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDACTUACIONPROCESO',
								op: 'join',
								value: value,
								param: 'IDACTUACIONPROCESO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
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
					    field:'ESTADO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'PDTE JUEZ',  text:'PDTE JUEZ' },{value:'AUTORIZADO',  text:'AUTORIZADO' }],
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
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			$('input[name="ESTADO"]').filter('[value=]').prop('checked', true);
			url = '/app/gs_oficio/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_oficio/update/'+row.IDOFICIO;
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
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:780px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_oficio/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="IDTIPOOFICIO" width="50" sortable="true">Tipo de Oficio</th>
				<th field="FECHA" width="50" sortable="true">Fecha</th>
				<th field="FECHAVENCIMIENTO" width="50" sortable="true">Fecha Vencimiento</th>
				<th field="DESTINATARIO" width="50" sortable="true">Destinatario</th>
				<th field="EMAILDESTINATARIO" width="50" sortable="true">Email Destinatario</th>
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
				<label>Tipo de Oficio</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPOOFICIO" value="" 
			    data-options="valueField: 'IDTIPOOFICIO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/gs_dm_tipooficio/list'" />
			</div>
			<div class="fitem">
				<label>Actuacion Proceso</label>
				<input id="ccb" class="easyui-combobox" name="IDACTUACIONPROCESO" value="" 
			    data-options="valueField: 'IDACTUACIONPROCESO',  
                            textField: 'IDACTUACION', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/gs_actuacionproceso/list'" />
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
				<label>Audiencia</label>
				<input id="ccb" class="easyui-combobox" name="IDAUDIENCIA" value="" 
			    data-options="valueField: 'IDAUDIENCIA',  
                            textField: 'FECHAAUDIENCIA', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/ad_audiencia/list'" />
			</div>
			<div class="fitem">
				<label>Fecha</label>
				<input name="FECHA" class="easyui-datetimebox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Vencimiento</label>
				<input name="FECHAVENCIMIENTO" class="easyui-datetimebox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Destinatario</label>
				<input name="DESTINATARIO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Email Destinatario</label>
				<input name="EMAILDESTINATARIO" class="easyui-validatebox" validType="email"  required="true">
			</div>
			<div class="fitem">
				<label>Contenido</label>
				<textarea name="CONTENIDO"  required="true"style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Estado</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="PDTE JUEZ" >PDTE JUEZ<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="AUTORIZADO" >AUTORIZADO
			</div>
			<div class="fitem">
				<label>Descripci&oacute;n</label>
				<input name="FILENAME" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Tipo de Archivo</label>
				<input name="FILETYPE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Tama&ntilde;o del Archivo</label>
				<input name="FILESIZE" class="easyui-validatebox" validType="text"  required="true">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
