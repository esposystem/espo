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
			
			$('#IDDESPACHO').combotree({
						url: '/app/dj_despacho/getTree',
						required: true,
						width:260
			});
			
			$('#dg').datagrid('enableFilter' ,[ {
				field:'DESPACHO',
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
			$('input[name="ESTADO"]').filter('[value=Activo]').prop('checked', true);
			url = '/app/dj_directorio_jxxi/create';
		}
		
		function editRecord(){
			$('#IDDESPACHO').combotree('reload');
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/dj_directorio_jxxi/update/'+row.IDDIRECTORIO;
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
		
		function validConn(IDCONN){
			
			$.messager.progress({ title: 'Validar Conexi&oacute;n',
						msg: 'Espere por favor',
						text:'Enviando Datos',
						interval : '80'
					});
			param = '';
			
			loadAjaxData('/app/dj_directorio_jxxi/validConn/' + IDCONN,param,function(result) {
				
				$.messager.progress('close');
				if (result.success)
					$.messager.alert('Confirmaci&oacute;n',result.msg,'info');
				else 
					$.messager.alert('Warning',result.msg,'warning');
				
			}); // end loadajaxdata 
			
		}
		
		function formatAccion(value,row,index){
				var e = '<a href="javascript:void(0)" onclick="validConn('+ row.IDDIRECTORIO +')">Validar</a> ';
				return e;
		}	
		
	</script>
</head>

<body>
	<h2><?php echo $modDesc ?></h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Haga click en los botones de la barra de herramientas de la grilla para realizar las operaciones.</div>
	</div>
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:820px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/dj_directorio_jxxi/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="CODIGO" width="30" sortable="true">C&oacute;digo</th>
				<th field="NOMBRE" width="50" sortable="true">Nombre</th>
				<th field="SERVERNAME" width="50" sortable="true">Nombre Servidor</th>
				<th field="IPSERVER" width="50" sortable="true">IP  Servidor</th>
				<th field="PORT" width="50" sortable="true">Puerto</th>
				<th field="BASEDATOS" width="50" sortable="true"> Base de Datos</th>
				<th field="CONEXION" width="40" data-options='formatter:formatAccion'> Conexi&oacute;n </th>
				
				
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:500px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Despacho</label>
			<!--	<input id="ccb" class="easyui-combobox" name="IDDESPACHO" value="" required="true"
			    data-options="valueField: 'IDDESPACHO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_despacho/list'" />-->
			    
			    <input id="IDDESPACHO" name="IDDESPACHO" value="">
				
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
				<label>Nombre Servidor</label>
				<input name="SERVERNAME" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>IP  Servidor</label>
				<input name="IPSERVER" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Puerto</label>
				<input name="PORT" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Driver</label>
				<input name="DRIVER" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Nombre Base de Datos</label>
				<input name="BASEDATOS" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Archivo Base de dtos (DatabaseFile)</label>
				<input name="DATABASE_FILE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Usuario Lectura Base de Datos</label>
				<input name="USUARIOLECTURA" class="easyui-validatebox" validType="text"  >
			</div>
			<div class="fitem">
				<label>Password Lectura Base de Datos</label>
				<input name="PASSWORDLECTURA" class="easyui-validatebox" validType="text"  >
			</div>
			<div class="fitem">
				<label>String Adicional</label>
				<textarea name="STRING_ADICIONAL"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Observaciones</label>
				<textarea name="OBSERVACIONES"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Estado</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Activo" checked="checked">Activo<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Inactivo" >Inactivo
			</div>
			<div class="fitem">
				<label>Ruta Log</label>
				<input name="LOGFILE" class="easyui-validatebox" validType="text"  >
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
