<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $config->get('appName')?></title>	
		
		
		<?php	echo Lib\APPUtil::headerView(); ?>
	
		
		
                
                
	        
		
		
	<script type="text/javascript">
		var url;
		
                
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
				field:'ESTADO',
				type:'combobox',
				options:{
					panelHeight:'auto',
					loader : cloader,
					url:'/app/estado/list',
					valueField: 'IDESTADO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'ESTADO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'ESTADO',
								op: 'join',
								value: value,
								param: 'IDESTADO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},

			{
				field:'REGIONAL',
				type:'combobox',
				options:{
					panelHeight:'auto',
					loader : cloader,
					url:'/app/regional/list',
					valueField: 'IDREGIONAL',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'REGIONAL');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'REGIONAL',
								op: 'join',
								value: value,
								param: 'IDREGIONAL'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},


			{
				field:'PAIS',
				type:'combobox',
				options:{
					panelHeight:'auto',
					loader : cloader,
					url:'/app/pais/list',
					valueField: 'IDPAIS',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'PAIS');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'PAIS',
								op: 'join',
								value: value,
								param: 'IDPAIS'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			}



			]);
                   
                });   
                    
		function newUser(){
			$('#dlg').dialog('open').dialog('setTitle','Crear <?php echo $opcDesc; ?>');
			$('#fm').form('clear');
			url = '/app/ciudad/create';
		}
		
		function editUser(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar <?php echo $opcDesc; ?>');
				$('#ccb').combobox('reload');
				$('#fm').form('load',row);
				url = '/app/ciudad/update/'+row.IDCIUDAD;
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
						$.post('/app/ciudad/delete',{id:row.IDCIUDAD},function(result){
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
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:100%;height:394px" 
			toolbar="#toolbar" pagination="true" data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?> ,remoteFilter:true,url:'/app/ciudad/list'"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="REGIONAL" width="25%" sortable="true">Regional</th>
    				<th field="ESTADO" width="25%" sortable="true">Departamento</th>
				<th field="NOMBRE" width="25%" sortable="true">Nombre</th>
				<th field="CODIGOSYS" width="25%" sortable="true">C&oacute;digo Sistema</th>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Crear</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeUser()">Eliminar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:355px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>País : </label>
				
                           
				<input id="ccb" class="easyui-combobox" name="IDPAIS" value="" required="true"
			    data-options="valueField: 'IDPAIS',  
                            textField: 'NOMBRE',
			    width:280,
			    panelHeight:'auto',
			    loader: cloader,
                            url: '/app/pais/list'" />
			</div>

			<div class="fitem">
				<label>Regional : </label>
				
                           
				<input id="ccb" class="easyui-combobox" name="IDREGIONAL" value="" required="true"
			    data-options="valueField: 'IDREGIONAL',  
                            textField: 'NOMBRE',
			    width:280,
			    panelHeight:'auto',
			    loader: cloader,
                            url: '/app/regional/list'" />
			</div>


			<div class="fitem">
				<label>Departamento : </label>
				
                           
				<input id="ccb" class="easyui-combobox" name="IDESTADO" value="" required="true"
			    data-options="valueField: 'IDESTADO',  
                            textField: 'NOMBRE',
			    width:280,
			    panelHeight:'auto',
			    loader: cloader,
                            url: '/app/estado/list'" />
			</div>
			<div class="fitem">
				<label>Nombre : </label>
				<input name="NOMBRE" class="easyui-validatebox" >
			</div>
			<div class="fitem">
				<label>C&oacute;digo Dane : </label>
				<input name="CODIGODANE" class="easyui-validatebox" >
			</div>

			<div class="fitem">
				<label>C&oacute;digo Sistema : </label>
				<input name="CODIGOSYS" class="easyui-validatebox" >
			</div>
		
			

		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
        
</body>
</html>
