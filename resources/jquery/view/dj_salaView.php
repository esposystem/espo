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
				field:'DESPACHO',
				type:'combotree',
				options:{
					panelHeight:'160',
					loader : ctreeloader,
					width:180,
					url:'/app/dj_despacho/getTree',
					valueField: 'id',  
					textField: 'text',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'DESPACHO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'DESPACHO',
								op: 'join',
								value: value,
								param: 'IDDESPACHO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDTIPOSALA',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/dj_dm_tiposalaaudiencia/list',
					valueField: 'TIPOSALA',  
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
			
			$('#IDDESPACHO').combotree('reload');
				
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

			url = '/app/dj_sala/create';
		}
		
		function editRecord(){
			
			$('#IDDESPACHO').combotree('reload');
			
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				console.log(row);
				$('#fm').form('load',row);
				$('#tt').tabs('select',0);
				$('#tt').tabs('enableTab', 1);
				url = '/app/dj_sala/update/'+row.IDSALA;
				urlInsertDisp = '/app/dj_saladisp/create/'+row.IDSALA;
				
			}
		
			$('#fmdisp').form('load','/app/dj_saladisp/list/'+row.IDSALA);
			
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
						//$('#dlg').dialog('close');	// close the dialog
						if(index == 0) $('#dg').datagrid('reload');	// reload the user data
					} else {
						$.messager.show({
							title: 'Error',
							msg: results.msg
						});
					}
				}
			});
			
			//$('#tt').tabs({
			//	border:false,
			//	onSelect:function(title){alert(title+' is selected');}
			//});
			// data-options="onSelect:function(title){alert(title+' is selected');}";
			// data-options="onLoadError:function(data){alert(data)};"
			
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
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/dj_sala/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="DESPACHO" width="100" sortable="true">Despacho</th>
				<th field="TIPOSALA" width="50" sortable="true">Tipo de Sala</th>
				<th field="CODIGO" width="30" sortable="true">C&oacute;digo</th>
				<th field="NOMBRE" width="80" sortable="true">Nombre</th>
				<th field="ESTADO" width="50" sortable="true">Estado</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	
	
	<div id="dlg" class="easyui-dialog" style="width:690px;height:542px; padding: 0 10px 0 10px;" closed="true" buttons="#dlg-buttons" modal="true">
	
	 <div id="tt" class="easyui-tabs" style="width:660px;height:auto" >
		
		<div title="Datos de <?php echo $opcDesc; ?>" data-options="tools:'#p-tools'" style="padding: 0 0px 0 0px;">
		
			<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
				<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Despacho</label>
				<input id="IDDESPACHO" name="IDDESPACHO" value="">
			</div>
			
				
				
			<div class="fitem">
				<label>Tipo de Sala</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPOSALA" value="" required="true"
			    data-options="valueField: 'IDTIPOSALA',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_dm_tiposalaaudiencia/list'" />
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
				<label>Caracteristicas</label>
				<textarea name="CARACTERISTICAS"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
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
