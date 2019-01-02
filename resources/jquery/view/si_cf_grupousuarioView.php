<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Fenix :: Grupo Usuario</title>
	
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/icon.css">
		
		
	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>demo/demo.css">

	<!--<link rel="stylesheet" type="text/css" href="../themes/icon.css">-->
	<script type="text/javascript" src="<?php echo $config->get('jqueryFolder')?>jquery.min.js"></script>	
	<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.easyui.min.js"></script>
	<style type="text/css">
		.title{
			font-size:16px;
			font-weight:bold;
			padding:10px 5px;
			background:#eee;
			overflow:hidden;
		//	border-bottom:0px solid #ccc;
		}
		.t-list{
			padding:5px;
		}
	</style>
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
			//	onClickRow:function(rowData){
			//		var row = $('#cg').combogrid('grid').datagrid('getSelected');
					//puedes acceder a cualquier valor de los de la tabla
				//	alert(row.id+" "+row.Nombre);
                          //      }
			});
			
			//var IDGrupo = '';
			
			$('#cc').combobox({ 
				url:'/app/si_cf_grupo/listJson',  
				valueField:'IDGRUPO',  
				textField:'NOMBRE',
				mode:'remote',
				onSelect: function(rec){
				//	var url = 'get_data2.php?id='+rec.id;
					//console.log(rec);
					
				//	IDGrupo = rec.id;

				      //   $('#tt').edatagrid('url', url);
				//      var options = {};
				 //     var opts = $.extend({}, $.fn.edatagrid.defaults, $.fn.edatagrid.parseOptions(this), options)
				//	 console.log(opts);
				
				//	$('#tt').datagrid('reload');
				
						
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
				idField:'itemid',
				
				url:'/app/si_cf_grupousuario/getGrupo',
			//	saveUrl: 'get_users.php',
			//	updateUrl: 'get_users.php',
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
						formatter:function(value,row,index){
							if (row.editing){
							//	var s = '<a href="#" onclick="saverow('+index+')">Save</a> ';
								//var s = '<a href="#" onclick="saverow('+index+')">Save</a> ';
								
							//	var c = '<a href="#" onclick="cancelrow('+index+')">Cancel</a>';
							//	return s+c;
							//	return c;
							} else {
							//	var e = '<a href="#" onclick="editrow('+index+')">Edit</a> ';
								var d = '<a href="#" onclick="deleterow('+index+')">Eliminar</a>';
							//	return e+d;
								return d;
							}
						}
					}
				]],
			//	onBeforeEdit:function(index,row){
			//		row.editing = true;
			//		updateActions();
			//	},
			//	onAfterEdit:function(index,row){
			//		console.log(row);
			//		row.editing = false;
			//		updateActions();
			//	},
			//	onCancelEdit:function(index,row){
			//		row.editing = false;
			//		updateActions();
			//	}
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
		
	//	function updateActions(){
	//		var rowcount = $('#tt').datagrid('getRows').length;
	//		for(var i=0; i<rowcount; i++){
	//			$('#tt').datagrid('updateRow',{
	//				index:i,
	//				row:{action:''}
	//			});
	//		}
	//	}
	//	function editrow(index){
	//		$('#tt').datagrid('beginEdit', index);
	//	}
	
		function deleterow(index){

			$.messager.confirm('Confirmar','Esta seguro de eliminar ?',function(r){
			
				var row = $('#tt').datagrid('getSelected');

						
				if (r){
					console.log(row);
					var IDG = $('#cc').combobox('getValue');
					
					$.ajax({
						type: "POST",
						url: "/app/si_cf_grupousuario/del",
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
	
	//	function saverow(index){
	//		$('#tt').datagrid('endEdit', index);
	//	}
	
	//	function cancelrow(index){
	//		$('#tt').datagrid('cancelEdit', index);
	//	}
		
	//	function insert(){
	//		var row = $('#cg').combogrid('grid').datagrid('getSelected');
					
	//		if (row){
	//			var index = $('#tt').datagrid('getRowIndex', row);
	//		} else {
	//			index = 0;
	//		}
			
			
	//		$('#tt').datagrid('insertRow', {
	//			index: index,
	//			row:{
	//				//status:'P'
	//			}
	//		});
	//		$('#tt').datagrid('selectRow',index);
	//		$('#tt').datagrid('beginEdit',index);
	//	}
		
		
		
	</script>
</head>
<body>	
	<h2>Administrar Usuarios en grupo</h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div>Seleccione el grupo para listar los usuarios asignados</div>
	</div>
	
	
	<table id="tt" toolbar="#tb" rownumbers="true"></table>
	
	<div id="tb" style="">
		<span>Grupo :</span>
		<input id="cc" name="dept" value="">
	</div>
	<div class="demo-info" style="margin:10px 0;">
		<div>Seleccione un usuario de la lista para agregarlo al grupo</div>
	</div>
	
	<div style="margin:10px 0">
		<input id="cg" style="width:250px"></input>&nbsp;&nbsp;
		<a href="#" class="easyui-linkbutton" onclick="insertUser()">Agregar Usuario</a>
	</div>
	
</body>
</html>