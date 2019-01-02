<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $config->get('appName')?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/icon.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/default/easyui.css"/>
	<script type="text/javascript" src="<?php echo $config->get('jqueryFolder')?>jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.easyui.min.js"></script>
		
	<script type="text/javascript">
		function sendform(){
		
			$.messager.progress({ title: 'Validando Usuario y Perfil',
				msg: 'Espere por favor',
				text:'Enviando Datos',
				interval : '80'
			});	
			$('#ff').form('submit',{
				url:'/app/login/auth',
				onSubmit: function(){
					
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
                                  
					$.messager.progress('close');
					
				//	console.log(result);
					
					if (result.success){
					//	alert("OK sess");
						document.location = "/app/home/view";
						
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
	<div id="dlg" class="easyui-dialog" style="width:400px;height:200px;padding:10px 30px;" title="<?php echo $config->get('appName')?>" buttons="#dlg-buttons">
		<h2>Control de Acceso</h2>
		<form id="ff" method="post">
			<table>
				<tr>
					<td>Usuario:</td>
					<td><input type="text" name="login" style="width:250px;" required="true"></td>
				</tr>
				<tr>
					<td>Clave:</td>
					<td><input type="password" name="clave" style="width:250px;"required="true"></td>
				</tr>
				
			</table>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="sendform()">Enviar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>