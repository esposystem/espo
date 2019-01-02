<html>
<head>
	<?php	echo Lib\APPUtil::headerView(); ?>
	<script>
		
		$(function(){
			
			$('#cg').combogrid({
				panelWidth:480,
				url: '/app/usuario/list',
				idField:'IDUSUARIO',
				textField:'PRIMERNOMBRE',
				mode:'remote',
				fitColumns:true,
				rownumbers:true,
				columns:[[
					{field:'IDUSUARIO',title:'ID',width:60},
					{field:'PRIMERNOMBRE',title:'PRIMERNOMBRE',align:'right',width:210},
					{field:'PRIMERAPELLIDO',title:'PRIMERAPELLIDO',align:'right',width:210},
				]],
			
			});
			
			$('#cc').combobox({ 
				url:'/app/si_cf_grupo/listJson',  
				valueField:'IDGRUPO',  
				textField:'NOMBRE',
				mode:'remote',
				onSelect: function(rec){
				
					$('#tt').datagrid('load',{  
						IDGrupo: rec.IDGRUPO
					    });
					
				    }
			});
			
			$('#tt').datagrid({
				title:'Usuarios asignados a grupo',
				iconCls:'icon-edit',
				width:690,
				height:320,
				singleSelect:true,
				pagination:true,
				rownumbers:true,
				fitColumns:true,
				fit:true,
				idField:'itemid',
				
				url:'/app/si_cf_grupousuario/getGrupo',

				destroyUrl: 'SI_CF_GRUPOUSUARIO/get_users.php',
				columns:[[
					{field:'IDUSUARIO',title:'Usuario ID',width:120},
					
					{field:'NOMBRE',title:'Nombre',width:300,
					
						editor:{
							type:'combobox',
							options:{
							    valueField:'IDUSUARIO',
							    textField:'NOMBRE',
							    url:'/app/si_cf_grupousuario/del',
							    mode:'remote',
							    required:true
							}
						}
					},
					{field:'IDGRUPO',title:'IDGrupo',align:'right',width:120},

					{field:'action',title:'Acci&oacute;n',width:70,align:'center',
						formatter: function(value,row,index){
							if (!row.editing){
								var d = '<a href="#" onclick="deleterow('+index+')">Eliminar</a>';
								return d;
							}
						}
					}
				]],
			});
		});
		
		
		function insertUser(){
			
			var row = $('#cg').combogrid('grid').datagrid('getSelected');
					//puedes acceder a cualquier valor de los de la tabla
			var IDG = $('#cc').combobox('getValue');
			console.log(row);
			console.log(IDG);
			var Nombre = row.PRIMERNOMBRE;
			
			if(row.SEGUNDONOMBRE)
				Nombre = Nombre + ' ' + row.SEGUNDONOMBRE;

			if(row.PRIMERAPELLIDO)
				Nombre = Nombre + ' ' + row.PRIMERAPELLIDO;

			if(row.SEGUNDOAPELLIDO)
				Nombre = Nombre + ' ' + row.SEGUNDOAPELLIDO;

			if(!IDG){
				$.messager.alert('Atencion','Debe seleccionar un grupo !!','error');
			}
			
			if(row && IDG){
					$.ajax({
						type: "POST",
						url: "/app/si_cf_grupousuario/create",
						data: "IDUSUARIO="+ row.IDUSUARIO + "&IDGRUPO=" + IDG + "&NOMBRE=" + Nombre,
						success: function(){
							
							$('#tt').datagrid('load',{ IDGrupo: IDG });
							
							$.messager.show({
									title: 'Atenci&oacute;n',
									msg:'Se creo el usuario en el grupo'
								});
						}
					});
			}
		} // end insert

		function deleterow(index){

			$.messager.confirm('Confirmar','Esta seguro de eliminar ?',function(r){
			
				var row = $('#tt').datagrid('getSelected');
	
				if (r){
					var IDG = $('#cc').combobox('getValue');
					
					$.ajax({
						type: "POST",
						url: "/app/si_cf_grupousuario/delUsr",
						data: "IDGrupo=" + row.IDGRUPO + "&IDUsuario=" + row.IDUSUARIO,
						success: function(){
							
							$('#tt').datagrid('deleteRow', index);
							
							$('#tt').datagrid('load',{ IDGrupo: IDG });
							
							$.messager.show({
									title: 'Atenci&oacute;n',
									msg:'Se eliminó al usuario del grupo'
								});
						}
					});
					
				}
			});
		}
		
	</script>
</head>
<body>	
	
							
	
	<table id="tt" toolbar="#tb" rownumbers="true"></table>
	
	<div id="tb" style="">
		<span>Grupo :</span>
		<input id="cc" name="dept" value="">
		<div>Seleccione un usuario de la lista para agregarlo al grupo</div>
			<input id="cg" style="width:250px"></input>&nbsp;&nbsp;
		<a href="#" class="easyui-linkbutton" onclick="insertUser()">Agregar Usuario</a>
	
	
		
	</div>
	
	
</body>
</html>