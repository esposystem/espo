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
						url: '/app/dj_despacho/getTree',
						required: true,
						width:260
			});
			
                    $('#dg').datagrid('enableFilter' ,[ {
				field:'CENTROSERVICIOS',
				type:'combobox',
				options:{
					panelHeight:'150',
					loader : cloader,
					url:'/app/dj_centroservicios/list',
					valueField: 'IDCENTROSERVICIOS',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'CENTROSERVICIOS');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'CENTROSERVICIOS',
								op: 'join',
								value: value,
								param: 'IDCENTROSERVICIOS'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'CIUDAD',
				type:'combobox',
				options:{
					panelHeight:'150',
					loader : cloader,
					url:'/app/pr_dm_ciudad/list',
					valueField: 'IDCIUDAD',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'CIUDAD');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'CIUDAD',
								op: 'join',
								value: value,
								param: 'IDCIUDAD'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'TIPOSALA',
				type:'combobox',
				options:{
					panelHeight:'150',
					loader : cloader,
					url:'/app/dj_dm_tiposala/list',
					valueField: 'IDTIPOSALA',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'TIPOSALA');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'TIPOSALA',
								op: 'join',
								value: value,
								param: 'IDTIPOSALA'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'TIPODESPACHO',
				type:'combobox',
				options:{
					panelHeight:'150',
					loader : cloader,
					url:'/app/dj_dm_tipo/list',
					valueField: 'IDTIPODESPACHO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'TIPODESPACHO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'TIPODESPACHO',
								op: 'join',
								value: value,
								param: 'IDTIPODESPACHO'
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
			$('input[name="ESTADO"]').filter('[value=Activo]').prop('checked', true);
			url = '/app/dj_despacho/create';
		}
		
		function editRecord(){
			
			$('#IDPADRE').combotree('reload');
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/dj_despacho/update/'+row.IDDESPACHO;
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
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:810px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/dj_despacho/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>	<th field="CODIGO" width="50" sortable="true">C&oacute;digo</th>
				<th field="NOMBRE" width="50" sortable="true">Nombre</th>
				<th field="TIPODESPACHO" width="50" sortable="true">Tipo</th>
				
    				<th field="CIUDAD" width="50" sortable="true">Ciudad</th>
				<th field="TIPOSALA" width="50" sortable="true">Tipo Sala Juez</th>
				<th field="ESTADO" width="50" sortable="true">Estado</th> </tr>
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
				<label>Despacho Predecesor</label>
				<!--<select class="easyui-combotree" name="IDPADRE" url="/app/gs_dm_actividad/getTree" name="IDPADRE" style="width:266px;"/>
				</select>-->
				<input id="IDPADRE" name="IDPADRE" value="">
					
					
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
				<label>Tipo Despacho</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPODESPACHO" value="" required="true"
			    data-options="valueField: 'IDTIPODESPACHO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_dm_tipo/list'" />
			</div>
			
			<div class="fitem">
				<label>Tipo Sala de Juez</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPOSALA" value="" required="true"
			    data-options="valueField: 'IDTIPOSALA',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_dm_tiposala/list'" />
			</div>
			<div class="fitem">
				<label>C&oacute;digo</label>
				<input name="CODIGO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Nombre</label>
				<input name="NOMBRE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Juez a Cargo </label>
				<input id="ccb" class="easyui-combobox" name="IDJUEZ" value=""
			    data-options="valueField: 'IDJUEZ',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/jz_juez/list'" />
			</div>
			<div class="fitem">
				<label>Juez Adjunto</label>
				<input id="ccb" class="easyui-combobox" name="IDJUEZADJUNTO" value=""
			    data-options="valueField: 'IDJUEZ',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/jz_juez/list'" />
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
				<label>Observaci&oacute;n</label>
				<textarea name="OBSERVACIONES"  style="height:60px;" wrap="virtual"></textarea>
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
