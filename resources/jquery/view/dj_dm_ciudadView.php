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
		
		//var dataDepto = loadAjaxData('/app/dj_dm_departamento/list','');
                
	//	console.log('depto' + dataDepto)
		function loadAjaxData(urlJson,param){
				
				console.log("loadAjaxData");
			
				//var opts = $(this).combobox('options');
				//console.log(opts);
					if (!urlJson) return false;
					$.ajax({
						type: 'post',
						url: urlJson,
						data: param,
						dataType: 'json',
						success: function(data){
						
							console.log('consultaok' + data);

							if (data.rows){
								return data.rows;
							//	console.log(data);
							//	success(data.rows);  // used the data.rows array to fill combobox list
							} else {
								return data;
								//success(data);
							}
						},
						error: function(){
							error.apply(this, arguments);
						}
				
				});
		} // end loadAjaxData

		
                $(function(){
                //    $('#dg').datagrid({ remoteFilter:true});        // ,url:'/app/pr_dm_ciudad/list' 
                    $('#dg').datagrid('enableFilter',[{
				field:'ACTIVO',
				type:'combobox',
				options:{
					panelHeight:'auto',
					data:[{value:'',text:'Todos'},{value:'SI',text:'SI'},{value:'NO',text:'NO'}],
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'ACTIVO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'ACTIVO',
								op: 'equal',
								value: value
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'DEPARTAMENTO',
				type:'combobox',
				options:{
					panelHeight:'auto',
					loader : cloader,
					url:'/app/dj_dm_departamento/list',
					valueField: 'IDDEPARTAMENTO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'DEPARTAMENTO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'DEPARTAMENTO',
								op: 'join',
								value: value,
								param: 'IDDEPARTAMENTO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			}]);
                   
                });   
                    
		function newUser(){
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			url = '/app/pr_dm_ciudad/create';
		}
		
		function editUser(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#ccb').combobox('reload');
				$('#fm').form('load',row);
				url = '/app/pr_dm_ciudad/update/'+row.IDCIUDAD;
			}
		}
		function saveUser(){
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
							msg: result.msg,
							icon: 'info'
						});
                                                
						$('#dlg').dialog('close');	// close the dialog
						$('#dg').datagrid('reload');	// reload the user data
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg,
							icon: 'error'
						});
					}
				}
			});
		}

		function removeUser(){
			var row = $('#dg').datagrid('getSelected');
                        
			if (row){
                            
				$.messager.confirm('Confirmac&oacute;n','Esta seguro de eliminar este registro ? ' + row.IDCIUDAD ,function(r){
					if (r){
						$.post('/app/pr_dm_ciudad/delete',{id:row.IDCIUDAD},function(result){
							if (result.success){
                                                                 $.messager.show({
                                                                        title: 'Confirmaci&oacute;n',
                                                                        msg: result.msg,
									icon: 'info'
                                                                });
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg,
									icon: 'error'
								});
							}
						},'json');
					}
				});
			}
		}

	</script>
</head>

<body>
	<h2><?php echo $modDesc ?></h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Haga click en los botones de la barra de herramientas de la grilla para realizar la operaciones.</div>
	</div>
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:780px;height:394px" 
			toolbar="#toolbar" pagination="true" data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?> ,remoteFilter:true,url:'/app/pr_dm_ciudad/list'"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="DEPARTAMENTO" width="70" sortable="true">Departamento</th>
				<th field="NOMBRE" width="50" sortable="true">Nombre</th>
				<th field="CODIGO" width="50" sortable="true">C&oacute;digo</th>
				<th field="ACTIVO" width="50" sortable="true">Activo</th>
				<th field="FECHA" width="50" sortable="true">Fecha</th>
				<th field="FECHAHORA" width="120" sortable="true">FechaHora</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Crear</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeUser()">Eliminar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:355px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Departamento</label>
				
                           
				<input id="ccb" class="easyui-combobox" name="IDDEPARTAMENTO" value="" required="true"
			    data-options="valueField: 'IDDEPARTAMENTO',  
                            textField: 'NOMBRE',
			    width:280,
			    panelHeight:'auto',
			    loader: cloader,
                            url: '/app/dj_dm_departamento/list'" />
			</div>
			<div class="fitem">
				<label>Nombre</label>
				<input name="NOMBRE" class="easyui-validatebox" >
			</div>
			<div class="fitem">
				<label>C&oacute;digo</label>
				<input name="CODIGO" class="easyui-validatebox" >
			</div>
		<!--	<div class="fitem">
				<label>Activo</label>
				<select name="ACTIVO" class="easyui-combobox" data-options="panelHeight:'auto'"><option value="SI">SI</option><option value="NO">NO</option></select>
			</div>-->
			<div class="fitem">
				<label>Activo</label>
				<input type="radio" class="easyui-validatebox" name="ACTIVO" value="SI">Si

				<input type="radio" class="easyui-validatebox" name="ACTIVO" value="NO"  data-options="validType:'requireRadio[\'input:radio[name=ACTIVO]\', \'Activo\']'">No
				
			</div>
			<div class="fitem">
				<label>Fecha</label>
				<input name="FECHA" class="easyui-datebox textbox" required="true">
			</div>
			<div class="fitem">
				<label>FechaHora</label>
				<input name="FECHAHORA" class="easyui-datetimebox" required="true">
			</div>
			<div class="fitem">
				<label>REMOTE</label>
				<input class="easyui-validatebox" name="USUARIO" delay="500" validType="remote['/app/usuario/validate','user']" />
			</div>
			

		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
        
</body>
</html>
