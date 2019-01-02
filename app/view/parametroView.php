<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $config->get('appName')?></title>	
		
		
		<?php	echo Lib\APPUtil::headerView(); ?>
	
		<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>ckeditor/ckeditor.js"></script>
		<script src="<?php echo $config->get('jsFolder')?>/ckeditor/adapters/jquery.js"></script>
		
                
                
	        
		
		
	<script type="text/javascript">


		$( document ).ready( function() {
			
			CKEDITOR.replace( 'TERMINOS', { height: '332px', width: '650px',toolbar : [
							    ['Cut','Copy','Paste'],
							    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
							    ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-'],
							    ['Styles','Format','Font','FontSize','Source','Maximize']
							]
						    });

		});


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
                //    $('#dg').datagrid({ remoteFilter:true});        // ,url:'/app/pr_dm_parametro/list' 
                    $('#dg').datagrid();

                   


                   
                });   
                    
		
		
		function editUser(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar <?php echo $opcDesc; ?>');
				$('#ccb').combobox('reload');
				$('#fm').form('load',row);
				url = '/app/parametro/update/'+row.IDPARAMETRO;
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

		

	</script>
</head>

<body>
	<h2><?php echo $modDesc ?></h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Haga click en los botones de la barra de herramientas de la grilla para realizar la operaciones.</div>
	</div>
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:100%;height:394px" 
			toolbar="#toolbar" pagination="true" data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?> ,remoteFilter:true,url:'/app/parametro/list'"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="EMAILCONTACTO" width="25%" sortable="true">Email Contacto</th>
    			<th field="EMAILENVIOS" width="25%" sortable="true">Email Envios</th>
				<th field="IVA" width="25%" sortable="true">IVA</th>
				<th field="VLRDECLARADO" width="25%" sortable="true">Porcentaje Vlr Declarado</th>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:355px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<form id="fm" method="post" novalidate>
                        
			
			<div class="fitem">
				<label>Nombre : </label>
				<input name="EMAILADMIN" class="easyui-validatebox" >
			</div>
			



			<div class="fitem">
				<label>Email Administrador : </label>
				<input name="EMAILADMIN" class="easyui-validatebox" >
			</div>


			<div class="fitem">
				<label>Email Contacto : </label>
				<input name="EMAILCONTACTO" class="easyui-validatebox" >
			</div>
			<div class="fitem">
				<label>Email Envíos : </label>
				<input name="EMAILENVIOS" class="easyui-validatebox" >
			</div>
			<div class="fitem">
				<label>Texto Terminos y Condiciones : </label>
				<textarea name="TERMINOS" class="easyui-validatebox" cols="50" rows="10" ></textarea>
			</div>
			<div class="fitem">
				<label>Texto Mercancía Prohibida : </label>
				<textarea name="MERCANCIA" class="easyui-validatebox"  cols="50" rows="10" ></textarea>
			</div>
			<div class="fitem">
				<label>Porcentaje IVA : </label>
				<input name="IVA" class="easyui-validatebox" >
			</div>
			<div class="fitem">
				<label>Porcentaje Vlr Declarado : </label>
				<input name="VLRDECLARADO" class="easyui-validatebox" >
			</div>
			<div class="fitem">
				<label>Porcentaje Sr. Pack: </label>
				<input name="SRPACK" class="easyui-validatebox" >
			</div>
			<div class="fitem">
				<label>Tipos de Envío : </label>
				<input name="TIPOSENVIO" class="easyui-validatebox" >
			</div>
			<div style="clear:both;"></div>
			<div class="fitem">
				<label>Tipos de Documento : </label>
				<input name="TIPOSDOCUMENTO" class="easyui-validatebox" >
			</div>
			<div style="clear:both;"></div>
			<div class="fitem">
				<label>Señor Pack Activo Para Recogida ? : </label>
				<input type="radio" id="SRPACKACTIVO" class="easyui-validatebox " name="SRPACKACTIVO" value="S" >Si
				<input type="radio" id="SRPACKACTIVO" class="easyui-validatebox " name="SRPACKACTIVO" value="N">No
			</div>
			<div style="clear:both;"></div>
			<div class="fitem">
				<label>Código Google Analitycs : </label>
				<textarea name="GOOGLEANALITYCS" class="easyui-validatebox" ></textarea>
			</div>
			<div style="clear:both;"></div>
			<div class="fitem">
				<label>Fecha Inicio Mantenimiento : </label>
				<input name="FECHAINICIOMANTENIMIENTO" class="easyui-validatebox datebox" >
			</div>
			<div style="clear:both;"></div>
			<div class="fitem">
				<label>Fecha de Fin Mantenimiento : </label>
				<input name="FECHAFINMANTENIMIENTO" class="easyui-validatebox datebox" >
			</div>
			<div class="fitem">
				<label>Servicio Destacado : </label>
				<input type="radio" id="SERVICIODESTACADO" class="easyui-validatebox " name="SERVICIODESTACADO" value="BARATO" >El más Barato
				<input type="radio" id="SERVICIODESTACADO" class="easyui-validatebox " name="SERVICIODESTACADO" value="DURACION">El más Rápido
				<input type="radio" id="SERVICIODESTACADO" class="easyui-validatebox " name="SERVICIODESTACADO" value="PARAMETRO">El Destacado
			</div>


			<div class="fitem">
				<label>Número de Contrato : </label>
				<input name="NUMEROCONTRATO" class="easyui-validatebox datebox" >
			</div>

			<div class="fitem">
				<label>Código Sucursal : </label>
				<input name="CODIGOSUCURSAL" class="easyui-validatebox datebox" >
			</div>


			<div class="fitem">
				<label>Forma de Pago : </label>
				<input name="FORMAPAGO" class="easyui-validatebox datebox" >
			</div>

			<div style="clear:both;"></div>
		
			

		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
        
</body>
</html>
