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
				    } ]);   
                });   
                    
		function newRecord(){
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			$('input[name="SEXO"]').filter('[value=]').prop('checked', true);
			url = '/app/gs_cbiografica/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_cbiografica/update/'+row.NUMEROINTERNO;
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
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:800px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_cbiografica/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="NUMEROINTERNO" width="50" sortable="true">No Interno</th>
				<th field="IDESTABLECIMIENTO" width="50" sortable="true">Est. Reclusi&oacute;n</th>
				<th field="NOMBRES" width="50" sortable="true">Nombres</th>
				<th field="APELLIDOS" width="50" sortable="true">Apellidos</th>
				<th field="NUMDOCUMENTO" width="50" sortable="true">No Documento</th>
				<th field="TARJETADATILAR" width="50" sortable="true">Tarjeta Dactilar</th>
				<th field="SEXO" width="50" sortable="true">Sexo</th>
				
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:516px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>No Interno</label>
				<input name="NUMEROINTERNO" class="easyui-validatebox" validType="text"  required="true">
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
				<label>Nombres</label>
				<input name="NOMBRES" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Apellidos</label>
				<input name="APELLIDOS" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Numero de Documento</label>
				<input name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Tarjeta Dactilar</label>
				<input name="TARJETADATILAR" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Tipo de Documento</label>
				<input name="TIPODOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Lugar de Expedici&oacute;n de Documento</label>
				<input name="EXPEDICIONDOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Pais de Nacimiento</label>
				<input name="PAISNACIMIENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Departamento de Nacimiento</label>
				<input name="DEPARTAMENTONACIMIENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Ciudad de Nacimiento</label>
				<input name="CIUDADNACIMIENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Sexo</label>
				<input type="radio" id="SEXO" class="easyui-validatebox" name="SEXO" value="M" >M<input type="radio" id="SEXO" class="easyui-validatebox" name="SEXO" value="F" >F
			</div>
			<div class="fitem">
				<label>Estado Civil</label>
				<input name="ESTADOCIVIL" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Conyugue</label>
				<input name="CONYUGUE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>No de Hijos</label>
				<input name="NUMEROHIJOS" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Nombre Madre</label>
				<input name="NOMBREMADRE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Nombre Padre</label>
				<input name="NOMBREPADRE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Direcci&oacute;n Residencia</label>
				<input name="DIRECCIONRESIDENCIA" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Barrio de Residencia</label>
				<input name="BARRIORESIDENCIA" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Departamento de Residencia</label>
				<input name="DEPARTAMENTORESIDENCIA" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Municipio de Residencia</label>
				<input name="MUNICIPIORESIDENCIA" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>N&uacute;mero de Ingresos</label>
				<input name="NUMEROINGRESOS" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Ingreso</label>
				<input name="FECHAINGRESO" class="easyui-datebox textbox" >
			</div>
			<div class="fitem">
				<label>Fecha de Captura</label>
				<input name="FECHACAPTURA" class="easyui-datebox textbox" >
			</div>
			<div class="fitem">
				<label>Estado de Ingresos</label>
				<input name="ESTADOINGRESO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Observaciones</label>
				<textarea name="OBSERVACIONES"  required="true"style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Alias</label>
				<input name="ALIAS" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Apodo</label>
				<input name="APODO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>N&uacute;mero de Caso</label>
				<input name="NUMEROCASO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>N&uacute;mero de Proceso</label>
				<input name="NUMEROPROCESO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Situaci&oacute;n Jur&iacute;dica</label>
				<input name="SITUACIONJURIDICA" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Autoridad a Cargo</label>
				<input name="AUTORIDADACARGO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Disposici&oacute;n</label>
				<input name="DISPOSICION" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Disposici&oacute;n</label>
				<input name="FECHA" class="easyui-datebox textbox" >
			</div>
			<div class="fitem">
				<label>Etapa</label>
				<input name="ETAPA" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Instancia</label>
				<input name="INSTANCIA" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>N&uacute;mero de Acta</label>
				<input name="NUMEROACTA" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Acta</label>
				<input name="FECHAACTA" class="easyui-datebox textbox" >
			</div>
			<div class="fitem">
				<label>Ubicaci&oacute;n</label>
				<input name="UBICACION" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Pabell&oacute;n</label>
				<input name="PABELLON" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Pasillo</label>
				<input name="PASILLO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Celda</label>
				<input name="CELDA" class="easyui-validatebox" validType="text"  required="true">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
