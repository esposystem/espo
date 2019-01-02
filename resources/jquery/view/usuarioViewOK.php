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
	<script type="text/javascript">
		var url;
                
                $(function(){
                    $('#dg').datagrid({ remoteFilter:true,url:'/app/usuario/list' });
                     
                    $('#dg').datagrid('enableFilter');
                 
                 //   $('#dg').datagrid('resize');
                   
                });   
                    
		function newUser(){
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			url = '/app/usuario/create';
		}
		function editUser(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/usuario/update/'+row.IDUsuario;
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
                                        
                                        console.log(result);
                                        
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
		function removeUser(){
			var row = $('#dg').datagrid('getSelected');
                        
			if (row){
                            
				$.messager.confirm('Confirmac&oacute;n','Esta seguro de eliminar este registro ? ' + row.IDUsuario ,function(r){
					if (r){
						$.post('/app/usuario/delete',{id:row.IDUsuario},function(result){
							if (result.success){
                                                                 $.messager.show({
                                                                        title: 'Confirmaci&oacute;n',
                                                                        msg: result.msg
                                                                });
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
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
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:700px;height:394px" 
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="IDUsuario" width="50" sortable="true">IDUsuario</th>
				<th field="numeroDocumento" width="50" sortable="true">Documento</th>
				<th field="FechaExpDocumento" width="50" sortable="true">FechaExpDocumento</th>
				<th field="primerNombre" width="50" sortable="true">Nombre</th>
				<th field="primerApellido" width="50" sortable="true">PrimerApellido</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Crear</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeUser()">Eliminar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:320px;padding:10px 20px"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                         <div class="fitem">
				<label>Tipo De Documento:</label>
				      <select class="easyui-combobox" name="idTipoDocumento">
                                            <option value="1">Cedula</option>
                                            <option value="2">PAsaporte</option>
                                            <option value="3">Cedula Extranjeria</option>
                                            <option value="4">Tarjeta Identidad</option>
                                    </select>
			</div>
			<div class="fitem">
				<label>N&uacute;mero Documento :</label>
				<input name="numeroDocumento" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label>FechaExpDocumento :</label>
				<input name="FechaExpDocumento" class="easyui-datebox textbox" required="true">
			</div>
			<div class="fitem">
				<label>primerNombre:</label>
				<input name="primerNombre" required="true">
			</div>
                        <div class="fitem">
				<label>segundoNombre:</label>
				<input name="segundoNombre">
			</div>
			<div class="fitem">
				<label>primerApellido:</label>
				<input name="primerApellido" class="easyui-validatebox" required="true">
			</div>
                        <div class="fitem">
				<label>segundoApellido:</label>
				<input name="segundoApellido" class="easyui-validatebox" >
			</div>
                         <div class="fitem">
				<label>Email:</label>
				<input name="email" class="easyui-validatebox" validType="email">
			</div>
                        <div class="fitem">
				<label>usuario:</label>
				<input name="usuario" class="easyui-validatebox" data-options="required:true,validType:'length[6,10]'">
			</div>
                        <div class="fitem">
				<label>Clave :</label>
				<input name="Password" class="easyui-validatebox">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
        
</body>
</html>