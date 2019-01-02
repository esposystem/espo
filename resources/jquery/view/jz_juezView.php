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
		var url,urlInsertDisp;
                
                $(function(){
			
			$('#IDDESPACHO').combotree({
						url: '/app/dj_despacho/getTree',
						required: true,
						width:260
			});
			
                    $('#dg').datagrid('enableFilter' ,[ {
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
				field:'TIPOJUEZ',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/jz_dm_tipo/list',
					valueField: 'IDTIPOJUEZ',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'TIPOJUEZ');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'TIPOJUEZ',
								op: 'join',
								value: value,
								param: 'IDTIPOJUEZ'
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
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			
			$('#fmdisp').form('clear');
			$('#tt').tabs('select',0);
			$('#tt').tabs('disableTab', 1);
			$('input[name="ESTADO"]').filter('[value=Activo]').prop('checked', true);
			$('input[name="ACTIVODIA1"]').filter('[value=Inactivo]').prop('checked', true);
			$('input[name="ACTIVODIA2"]').filter('[value=Inactivo]').prop('checked', true);
			$('input[name="ACTIVODIA3"]').filter('[value=Inactivo]').prop('checked', true);
			$('input[name="ACTIVODIA4"]').filter('[value=Inactivo]').prop('checked', true);
			$('input[name="ACTIVODIA5"]').filter('[value=Inactivo]').prop('checked', true);
			$('input[name="ACTIVODIA6"]').filter('[value=Inactivo]').prop('checked', true);
			$('input[name="ACTIVODIA0"]').filter('[value=Inactivo]').prop('checked', true);

			url = '/app/jz_juez/create';
		}
		
		
		function editRecord(){
		
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				console.log(row);
				$('#fm').form('load',row);
				$('#tt').tabs('select',0);
				$('#tt').tabs('enableTab', 1);
				url = '/app/jz_juez/update/'+row.IDJUEZ;
				urlInsertDisp = '/app/jz_disponibilidad/create/'+row.IDJUEZ;
				
			}
		
			$('#fmdisp').form('load','/app/jz_disponibilidad/list/'+row.IDJUEZ);
			
		}
		
		function saveRecord(){
			
			console.log($('#fm'));
			
			var tab = $('#tt').tabs('getSelected');
			var index = $('#tt').tabs('getTabIndex',tab);
			
			if(index == 0){
				formSelected = $('#fm');
				url = url;
				console.log(url);
			}
			if(index == 1){
				url = urlInsertDisp;
				formSelected = $('#fmdisp');
			}
		
			formSelected.form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					
					var results = eval('(' + result + ')');
                                        
					if (results.success){
                                                
                                                $.messager.show({
							title: 'Confirmaci&oacute;n',
							msg: results.msg
						});
                                                
						if(index == 0) $('#tt').tabs('enableTab', 1);
						if(index == 0) $('#dg').datagrid('reload');	// reload the user data
					} else {
						$.messager.show({
							title: 'Error',
							msg: results.msg
						});
					}
				}
			});
			
		}
		function saveRecord1(){
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
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:840px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/jz_juez/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="CIUDAD" width="50" sortable="true">Ciudad</th>
				<th field="TIPOJUEZ" width="50" sortable="true">Tipo de Juez</th>
				<th field="CODIGO" width="30" sortable="true">C&oacute;digo</th>
				<th field="NUMEROIDENTIFICACION" width="50" sortable="true">Identificaci&oacute;n</th>
				<th field="PRIMERNOMBRE" width="50" sortable="true">Primer Nombre</th>
				<th field="SEGUNDONOMBRE" width="50" sortable="true">Segundo Nombre</th>
				<th field="PRIMERAPELLIDO" width="50" sortable="true">Primer Apellido</th>
				<th field="SEGUNDOAPELLIDO" width="50" sortable="true">Segundo Apellido</th>
				<th field="ESTADO" width="50" sortable="true">Estado</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	
	
		<div id="dlg" class="easyui-dialog" style="width:810px;height:500px; padding: 0 10px 0 10px;" closed="true" buttons="#dlg-buttons" modal="true">
	
	 <div id="tt" class="easyui-tabs" style="width:660px;height:auto" >
		
		<div title="Datos de <?php echo $opcDesc; ?>" data-options="tools:'#p-tools'" style="padding: 0 0px 0 0px;">
		
			<div class="ftitle"></div>
					<form id="fm" method="post" novalidate>
                        
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
				<label>Tipo de Juez</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPOJUEZ" value="" required="true"
			    data-options="valueField: 'IDTIPOJUEZ',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/jz_dm_tipo/list'" />
			</div>
			<div class="fitem">
				<label>C&oacute;digo</label>
				<input name="CODIGO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Tipo de Identificaci&oacute;n</label>
				<input type="radio" id="TIPOIDENTIFICACION" class="easyui-validatebox" name="TIPOIDENTIFICACION" value="Cedula Ciudadania" >Cedula Ciudadania<input type="radio" id="TIPOIDENTIFICACION" class="easyui-validatebox" name="TIPOIDENTIFICACION" value="Cedula Extranjeria" >Cedula Extranjeria<input type="radio" id="TIPOIDENTIFICACION" class="easyui-validatebox" name="TIPOIDENTIFICACION" value="Pasaporte" >Pasaporte
			</div>
			<div class="fitem">
				<label>N&uacute;mero de Identificaci&oacute;n</label>
				<input name="NUMEROIDENTIFICACION" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Tarjeta Profesional</label>
				<input name="TARJPROF" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Primer Nombre</label>
				<input name="PRIMERNOMBRE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Segundo Nombre</label>
				<input name="SEGUNDONOMBRE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Primer Apellido</label>
				<input name="PRIMERAPELLIDO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Segundo Apellido</label>
				<input name="SEGUNDOAPELLIDO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Tel&eacute;fono</label>
				<input name="TELEFONO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>N&uacute;mero Celular</label>
				<input name="CELULAR" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Email</label>
				<input name="EMAIL" class="easyui-validatebox" validType="email"  required="true">
			</div>
			<div class="fitem">
				<label>Despacho</label>
			<!--	<input id="ccb" class="easyui-combobox" name="IDDESPACHO" value="" required="true"
			    data-options="valueField: 'IDDESPACHO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/jz_dm_juzgado/list'" />-->
			    <input id="IDDESPACHO" name="IDDESPACHO" value="">
				
			</div>
			<div class="fitem">
				<label>Tipo Contrato</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPOCONTRATO" value="" required="true"
			    data-options="valueField: 'IDTIPO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/jz_dm_tipocontrato/list'" />
			</div>
			<div class="fitem">
				<label>FECINICONTRATO</label>
				<input name="FECINICONTRATO" class="easyui-datebox textbox">
			</div>
			<div class="fitem">
				<label>FECFICCONTRATO</label>
				<input name="FECFICCONTRATO" class="easyui-datebox textbox">
			</div>
			<div class="fitem">
				<label>Tipo Novedad</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPONOVEDAD" value=""
			    data-options="valueField: 'IDTIPO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/jz_dm_tiponovedad/list'" />
			</div>
			<div class="fitem">
				<label>OTRANOVEDAD</label>
				<input name="OTRANOVEDAD" class="easyui-validatebox" validType="text"  >
			</div>
			<div class="fitem">
				<label>Observaciones</label>
				<textarea name="OBSERVACIONES"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Estado</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Activo" checked="checked">Activo<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Inactivo" >Inactivo
			</div>
		</form>
		</div>
		 
	 
	 
	<div title="Disponibilidad" style="padding:10px">
		<form id="fmdisp" method="post" novalidate>
		<fieldset>
			
		 <legend>Horarios</legend>
			<div class="fitem" style="background-color:#F4F4F4;">
				<label>Lunes</label>
				<input type="radio" id="ACTIVODIA1" class="easyui-validatebox" name="ACTIVODIA1" value="Activo" >Activo
				<input type="radio" id="ACTIVODIA1" class="easyui-validatebox" name="ACTIVODIA1" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem" style="background-color:#F4F4F4;">
			<label></label>
				<label>Desde
				<input name="DESDEDIA1" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
				<label>Hasta
				<input name="HASTADIA1" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
			</div>
			
			<div class="fitem" >
				<label>Martes</label>
				<input type="radio" id="ACTIVODIA2" class="easyui-validatebox" name="ACTIVODIA2" value="Activo" >Activo
				<input type="radio" id="ACTIVODIA2" class="easyui-validatebox" name="ACTIVODIA2" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem">
			<label></label>
				<label>Desde
				<input name="DESDEDIA2" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
				<label>Hasta
				<input name="HASTADIA2" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
			</div>
			
			<div class="fitem" style="background-color:#F4F4F4;">
				<label>Miercoles</label>
				<input type="radio" id="ACTIVODIA3" class="easyui-validatebox" name="ACTIVODIA3" value="Activo" >Activo
				<input type="radio" id="ACTIVODIA3" class="easyui-validatebox" name="ACTIVODIA3" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem" style="background-color:#F4F4F4;">
			<label></label>
				<label>Desde
				<input name="DESDEDIA3" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
				<label>Hasta
				<input name="HASTADIA3" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
			</div>
			
			<div class="fitem">
				<label>Jueves</label>
				<input type="radio" id="ACTIVODIA4" class="easyui-validatebox" name="ACTIVODIA4" value="Activo" >Activo
				<input type="radio" id="ACTIVODIA4" class="easyui-validatebox" name="ACTIVODIA4" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem">
			<label></label>
				<label>Desde
				<input name="DESDEDIA4" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
				<label>Hasta
				<input name="HASTADIA4" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
			</div>
			
			
			<div class="fitem" style="background-color:#F4F4F4;">
				<label>Viernes</label>
				<input type="radio" id="ACTIVODIA5" class="easyui-validatebox" name="ACTIVODIA5" value="Activo" >Activo
				<input type="radio" id="ACTIVODIA5" class="easyui-validatebox" name="ACTIVODIA5" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem" style="background-color:#F4F4F4;">
			<label></label>
				<label>Desde
				<input name="DESDEDIA5" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
				<label>Hasta
				<input name="HASTADIA5" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
			</div>
			
			
			<div class="fitem">
				<label>Sabado</label>
				<input type="radio" id="ACTIVODIA6" class="easyui-validatebox" name="ACTIVODIA6" value="Activo" >Activo
				<input type="radio" id="ACTIVODIA6" class="easyui-validatebox" name="ACTIVODIA6" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem">
			<label></label>
				<label>Desde
				<input name="DESDEDIA6" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
				<label>Hasta
				<input name="HASTADIA6" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
			</div>
			
			
			<div class="fitem" style="background-color:#F4F4F4;">
				<label>Domingo</label>
				<input type="radio" id="ACTIVODIA0" class="easyui-validatebox" name="ACTIVODIA0" value="Activo" >Activo
				<input type="radio" id="ACTIVODIA0" class="easyui-validatebox" name="ACTIVODIA0" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem" style="background-color:#F4F4F4;">
			<label></label>
				<label>Desde
				<input name="DESDEDIA0" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
				<label>Hasta
				<input name="HASTADIA0" class="easyui-timespinner" data-options="min:'08:30',showSeconds:false">
				</label>
			</div>
			
		</fieldset>
	    </form>
        </div>
    
	</div>
	
	</div>
	
	
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cerrar</a>
	</div>
	
	
</body>
</html>
