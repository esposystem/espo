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
				field:'IDDESPACHORADICA',
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
							 $('#dg').datagrid('removeFilterRule', 'IDDESPACHORADICA');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDDESPACHORADICA',
								op: 'join',
								value: value,
								param: 'IDDESPACHO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'DETENIDO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'DETENIDO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'DETENIDO',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
				field:'IDINSTANCIA',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/gs_dm_instancia/list',
					valueField: 'IDINSTANCIA',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDINSTANCIA');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDINSTANCIA',
								op: 'join',
								value: value,
								param: 'IDINSTANCIA'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'VIGENTE',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'VIGENTE');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'VIGENTE',
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
			$('input[name="DETENIDO"]').filter('[value=N]').prop('checked', true);
$('input[name="VIGENTE"]').filter('[value=N]').prop('checked', true);
			url = '/app/gs_ficha/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_ficha/update/'+row.NUMRADICADOPROC;
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
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:860px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_ficha/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="NUMRADICADOPROC" width="50" sortable="true">No Proceso</th>
				<th field="NUMDOCUMENTO" width="50" sortable="true">No de Documento</th>
				<th field="IDESTABLECIMIENTO" width="50" sortable="true">Establecimiento</th>
				<th field="IDDESPACHORADICA" width="50" sortable="true">Despacho Radica</th>
				<th field="DETENIDO" width="50" sortable="true">Detenido</th>
				<th field="VIGENTE" width="50" sortable="true">Proceso Vigente</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:654px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Numero de Proceso</label>
				<input name="NUMRADICADOPROC" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Numero de Documento</label>
				<input name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
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
				<label>Despacho Radica</label>
				<input id="ccb" class="easyui-combobox" name="IDDESPACHORADICA" value="" required="true"
			    data-options="valueField: 'IDDESPACHO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_despacho/list'" />
			</div>
			<div class="fitem">
				<label>Detenido</label>
				<input type="radio" id="DETENIDO" class="easyui-validatebox" name="DETENIDO" value="S" >S<input type="radio" id="DETENIDO" class="easyui-validatebox" name="DETENIDO" value="N" checked="checked">N
			</div>
			<div class="fitem">
				<label>Numero de Documento Apoderado</label>
				<input name="DOCREPRESENTANTE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Nombre del Apoderado</label>
				<input name="NOMBREREPRESENTANTE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Abogado o Funcionario Judicial</label>
				<input name="FUNCIONARIOABOGADO" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label>Entidad Funcionario</label>
				<input id="ccb" class="easyui-combobox" name="IDENTIDADFUNCIONARIO" value="" required="true"
			    data-options="valueField: 'IDENTIDAD',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pr_dm_entidad/list'" />
			</div>
			<div class="fitem">
				<label>Especialidad Despacho Funcionario</label>
				<input id="ccb" class="easyui-combobox" name="IDESPFUNCIONARIO" value="" required="true"
			    data-options="valueField: 'IDESPECIALIDAD',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pr_dm_especialidad/list'" />
			</div>
			<div class="fitem">
				<label>Despacho Funcionario</label>
				<input id="ccb" class="easyui-combobox" name="IDDESPFUNCIONARIO" value="" required="true"
			    data-options="valueField: 'IDDESPACHO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_despacho/list'" />
			</div>
			<div class="fitem">
				<label>Cargo del Funcionario</label>
				<input name="CARGOFUNCIONARIO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Sancion Disciplinaria CSJ</label>
				<input id="ccb" class="easyui-combobox" name="IDSANCION" value="" required="true"
			    data-options="valueField: 'IDSANCION',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/gs_dm_sanciondisciplina/list'" />
			</div>
			<div class="fitem">
				<label>Instancia Donde se Radica el Proceso</label>
				<input id="ccb" class="easyui-combobox" name="IDINSTANCIA" value="" required="true"
			    data-options="valueField: 'IDINSTANCIA',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/gs_dm_instancia/list'" />
			</div>
			<div class="fitem">
				<label>N&uacute;mero de Folios</label>
				<input name="FOLIOS" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>N&uacute;mero de Cuadernos</label>
				<input name="CUADERNOS" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Ciudad que Remite</label>
				<input id="ccb" class="easyui-combobox" name="IDCIUDADREMITE" value="" required="true"
			    data-options="valueField: 'IDCIUDAD',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pr_dm_ciudad/list'" />
			</div>
			<div class="fitem">
				<label>IDDESPACHOREMITE</label>
				<input name="IDDESPACHOREMITE" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Proceso Vigente</label>
				<input type="radio" id="VIGENTE" class="easyui-validatebox" name="VIGENTE" value="S" >S<input type="radio" id="VIGENTE" class="easyui-validatebox" name="VIGENTE" value="N" checked="checked">N
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
