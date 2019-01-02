<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $config->get('appName')?></title>	
		
		<?php	echo Lib\APPUtil::headerView(); ?>
	
	<script type="text/javascript">
		var url;
                
                $(function(){
                    $('#dg').datagrid('enableFilter' ,[{
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
			$('#guardar').show(); 
			$('#editar').hide();

			$('#dlg').dialog({ 
				width: 650    
			});
			$('#dlg').dialog('open').dialog('setTitle','Crear Usuario');
			$('#fm').form('clear');
			
			//$('input[name="TIPOIDENTIFICACION"]').filter('[value=]').prop('checked', true);
            $('input[name="ESTADO"]').filter('[value=Activo]').prop('checked', true);
			url = '/app/usuario/create';
			
		}
		
		function editRecord(){	
			$('#guardar').hide(); 
			$('#editar').show();		
			var row = $('#dg').datagrid('getSelected');
			if (row){				
				//console.log(row);
				$('#IDUSUARIO').val(row.IDUSUARIO);
				$('#btnGrupos').linkbutton('enable');				
				//$('#PASSWORD').prop('required',"false");
				$('#PASSWORD_load').validatebox('disableValidation');
				$('#dgGrupos').datagrid('clearChecked');
				
				$('#dgGrupos').datagrid({
				    url: '/app/si_cf_grupousuario/getGruposUsr/' + row.IDUSUARIO
				});
				$('#dgGrupos').datagrid('reload');
				$('#dlg').dialog({ 
					width: 980    
				});

				$('#dlg').dialog('open').dialog('setTitle','Editar Usuario');
				$('#fm').form('load',row);
				url = '/app/usuario/update/'+row.IDUSUARIO;	
				//04/05/2016
				//Gonzalo J Perez
				//Cada vez que se actualiza un usuario cambia la clave				
				$('#PASSWORD_load_send').val($('#PASSWORD_load').val());				
				$('#PASSWORD_load').val('');			
			}
		}
		function saveRecord(){
				url = url;
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(results){
					var result = eval('('+results+')');
                                        
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

		function updateRecord2(){
				url = url;
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){					
					return $(this).form('validate');
				},
				success: function(results){
					var result = eval('('+results+')');
                                        
					if (result.success){
                                                
                         $.messager.show({
							title: 'Confirmaci&oacute;n',
							msg: result.msg
						});
                         updateGrupos()                       
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
		
		function checkRowGrid(val,row,index){
			
			if(row.checked)
				$('#dgGrupos').datagrid('checkRow',index);
			
			return row.DESCRIPCION;
		}
		
		function updateGrupos(){
			
			//var row = $('#dg').datagrid('getSelected');
			console.log(IDUSUARIO);
			console.log($('#IDUSUARIO').val());
			
			var nodesChecked = $('#dgGrupos').datagrid('getChecked');
			 
				//console.log(nodesChecked);
				
				var strGrupos = new Array();
				 
				var rowcount = nodesChecked.length;
				for(var i=0; i< rowcount; i++){
					//console.log(nodesChecked[i]);
				
					//if($('#tt').etree('isLeaf', nodesChecked[i].target))
					strGrupos.push(nodesChecked[i].IDGRUPO);
				}
				//console.log(strGrupos);
				$.ajax({
					url: '/app/si_cf_grupousuario/updateGrupos/' + $('#IDUSUARIO').val(),
					type: 'post',
					dataType: 'json',
					data: {
						grupos : strGrupos.join()
					},
					success: function(results){
						console.log(results);
						
						$.messager.show({
							title: 'Atencion',
							msg:results.msg
						});		
					}
				});
				
		}

	</script>
</head>

<body>
	
	
		
	<table id="dg" title="<?php echo $modDesc; ?>" class="easyui-datagrid" style=""    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/usuario/list'"
			toolbar="#toolbar" pagination="true" fit="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="NUMEROIDENTIFICACION" width="35" sortable="true">Identificaci&oacute;n</th>
				<th field="PRIMERNOMBRE" width="40" sortable="true">Primer Nombre</th>
				<th field="SEGUNDONOMBRE" width="40" sortable="true">Seg. Nombre</th>
				<th field="PRIMERAPELLIDO" width="40" sortable="true">Primer Apellido</th>
				<th field="SEGUNDOAPELLIDO" width="40" sortable="true">Seg. Apellido</th>
				<th field="USUARIO" width="40" sortable="true">Usuario</th>
			    <th field="ESTADO" width="30" sortable="true">Estado</th>
				<th field="VIGENCIA" width="34" sortable="true">Vigencia</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" title="Crear un nuevo usuario" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" title="Actualizar usuario y asociar a grupo(s)" iconCls="icon-edit" plain="true" onclick="editRecord()">Actualizar y asignar grupo</a>
	</div>
	
	<!--<div id="dlg" class="easyui-dialog" style="width:560px;height:510px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
	-->
	<div id="dlg" class="easyui-dialog" style="width:980px;height:440px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true" fit="false">
		
		<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'west',split:true" style="width:660px;padding:5px">
		<form id="fm" method="post" novalidate>
                         <input type="hidden" name="IDUSUARIO" id="IDUSUARIO">
			
			
			<div class="fitem_col3">
				<label>N&uacute;mero de Identificacion : </label>
				<input name="NUMEROIDENTIFICACION" class="easyui-validatebox textbox" validType="text" required="true">
			</div>
			<div style="clear:both;"/></div>
			
			<div class="fitem_col3">
				<label>Primer Nombre : </label>
				<input name="PRIMERNOMBRE" class="easyui-validatebox textbox" validType="text" required="true">
			</div>
			<div class="fitem_col3">
				<label>Segundo Nombre : </label>
				<input name="SEGUNDONOMBRE" class="easyui-validatebox textbox" validType="text" >
			</div>
			<div class="fitem_col3">
				<label>Primer Apellido : </label>
				<input name="PRIMERAPELLIDO" class="easyui-validatebox textbox" validType="text" required="true">
			</div>
			<div class="fitem_col3">
				<label>Segundo Apellido : </label>
				<input name="SEGUNDOAPELLIDO" class="easyui-validatebox textbox" validType="text" >
			</div>
			<div class="fitem_col3">
				<label>Tel&eacute;fono : </label>
				<input name="TELEFONO" class="easyui-validatebox textbox" validType="text" required="true">
			</div>
			
			<div class="fitem_col3">
				<label>Email : </label>
				<input name="EMAIL" class="easyui-validatebox textbox" validType="email" required="true">
			</div>
			<div style="clear:both;"/></div>
			<div class="fitem_col3">
				<label>Usuario : </label>
				<input name="USUARIO" class="easyui-validatebox textbox" validType="text" >
			</div>
			<div class="fitem_col3">
				<label>Clave : </label>				
				<input id="PASSWORD_load" name="PASSWORD" class="easyui-validatebox textbox" validType="text" >
				<input id="PASSWORD_load_send" type="hidden" name="PASSWORD_send" >
				<label><i><small>* Utilice este campo para cambiar su clave actual.</small></i></label>
			</div>
			<div style="clear:both;"/></div>
			<div style="clear:both;"/></div>
			<div class="fitem">
				<label>Estado : </label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Activo" checked="checked">Activo<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Inactivo" >Inactivo
			</div>
			<div style="clear:both;"/></div>
			<div style="clear:both;"/></div>
			<div class="fitem_col3">
				<label>Vigencia : </label>
				<input name="VIGENCIA" editable="false" class="easyui-datebox textbox" style="width: 160px;" required="true">
			</div>
					
		</form>
		</div>
		<div data-options="region:'center'" style="width:260px;">
				<table id="dgGrupos" class="easyui-datagrid" idField="IDGRUPO" style="width:250px;height:302px" toolbar="#toolbarGrupo"
				        data-options="CheckOnSelect:false,selectOnCheck:false" rownumbers="true" fit="true" fitColumns="true" singleSelect="false">
					<thead>
						<tr>
							<th data-options="field:'check',checkbox:true"></th>
							<th data-options="field:'DESCRIPCION',formatter:checkRowGrid" width="50">Grupo</th>
						</tr>
					</thead>
				</table>
		</div>
		<div style="clear:both;"/></div>
		<div style="clear:both;"/></div>
	</div>
	</div>
	<div id="toolbarGrupo">
		<a href="#" id="btnGrupos" class="easyui-linkbutton" iconCls="icon-user_group" plain="true" onclick="updateGrupos()">Asociar Usuario a Grupo(s)</a>
	</div>
	<div id="dlg-buttons">
		<a id="guardar" href="#" class="easyui-linkbutton " iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a id="editar" href="#" class="easyui-linkbutton  " iconCls="icon-ok" onclick="updateRecord2()">Actualizar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
