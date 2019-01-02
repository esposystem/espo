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
				field:'IDACTIVIDAD',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/gs_dm_actividad/list',
					valueField: 'IDACTIVIDAD',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDACTIVIDAD');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDACTIVIDAD',
								op: 'join',
								value: value,
								param: 'IDACTIVIDAD'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDESTABLECIMIENTO',
				type:'combobox',
				options:{
					panelHeight:'60',
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
					    field:'FUENTE',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Manual',  text:'Manual' },{value:'Automatica',  text:'Automatica' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'FUENTE');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'FUENTE',
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
			$('input[name="FUENTE"]').filter('[value=]').prop('checked', true);
			url = '/app/gs_reporteactividad/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_reporteactividad/update/'+row.IDREPORTE;
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
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_reporteactividad/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="NUMEROCERTIFICADO" width="50" sortable="true">Numero de Certifiado</th>
				<th field="IDACTIVIDAD" width="50" sortable="true">Codigo de la Actividad</th>
				<th field="NUMERODOCUMENTO" width="50" sortable="true">Numero de Documento del Condenado</th>
				<th field="IDESTABLECIMIENTO" width="50" sortable="true">Establecimiento Judicial</th>
				<th field="NUMEROHORAS" width="50" sortable="true">Numero de Documento del Condenado</th>
				<th field="ANIO" width="50" sortable="true">A&ntilde;o Reporte</th>
				<th field="MES" width="50" sortable="true">A&ntilde;o Reporte</th>
				<th field="FUENTE" width="50" sortable="true">Fuente de la Informaci&oacute;n </th>
				<th field="FILENAME" width="50" sortable="true">Archivo Digital Certificado</th>
				<th field="FILETYPE" width="50" sortable="true">Tipo de Archivo</th>
				<th field="FILESIZE" width="50" sortable="true">Tama&ntilde;o del Archivo</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:446px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Numero de Certifiado</label>
				<input name="NUMEROCERTIFICADO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Codigo de la Actividad</label>
				<input id="ccb" class="easyui-combobox" name="IDACTIVIDAD" value="" required="true"
			    data-options="valueField: 'IDACTIVIDAD',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/gs_dm_actividad/list'" />
			</div>
			<div class="fitem">
				<label>Numero de Documento del Condenado</label>
				<input name="NUMERODOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Establecimiento Judicial</label>
				<input id="ccb" class="easyui-combobox" name="IDESTABLECIMIENTO" value="" required="true"
			    data-options="valueField: 'IDESTABLECIMIENTO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/er_establecimiento/list'" />
			</div>
			<div class="fitem">
				<label>Numero de Documento del Condenado</label>
				<input name="NUMEROHORAS" precision="2" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>A&ntilde;o Reporte</label>
				<input name="ANIO" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>A&ntilde;o Reporte</label>
				<input name="MES" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Fuente de la Informaci&oacute;n </label>
				<input type="radio" id="FUENTE" class="easyui-validatebox" name="FUENTE" value="Manual" >Manual<input type="radio" id="FUENTE" class="easyui-validatebox" name="FUENTE" value="Automatica" >Automatica
			</div>
			<div class="fitem">
				<label>Archivo Digital Certificado</label>
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
