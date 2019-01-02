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
			
			 $('#dgdoc').datagrid({
				onBeforeEdit:function(index,row){
					row.editing = true;
					updateActions(index);
				},
				onAfterEdit:function(index,row){
					row.editing = false;
					updateActions(index);
				},
				onCancelEdit:function(index,row){
					row.editing = false;
					updateActions(index);
				}
			});
                
			function updateActions(index){
				$('#dgdoc').datagrid('updateRow',{
					index: index,
					row:{}
				});
			}
		
		    $('#dgdoc').datagrid('enableFilter' ,[ {
				field:'TIPODOC',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pt_dm_tipodoc/list',
					valueField: 'IDTIPODOC',  
					textField: 'DESCRIPCION',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dgdoc').datagrid('removeFilterRule', 'TIPODOC');
						} else {
							 $('#dgdoc').datagrid('addFilterRule', {
								field: 'TIPODOC',
								op: 'join',
								value: value,
								param: 'IDTIPODOC'
							});
						}
						$('#dgdoc').datagrid('doFilter');
					}
				}
			},{
					    field:'LEGIBLE',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dgdoc').datagrid('removeFilterRule', 'LEGIBLE');
							    } else {
								     $('#dgdoc').datagrid('addFilterRule', {
									    field: 'LEGIBLE',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dgdoc').datagrid('doFilter');
						    }
					    }
				    } ]);
                   
                });   
                
		function editRecord(){
			var row = $('#dgdoc').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/pt_peticion/update/'+row.IDPETICION;
			}
		}
		
		function downloadFile(){
			
			alert("Descargar Archivo");
		}

		function formatDownUrl(val,row){
			var url = "/app/pt_documento/download/";
			return '<a href="'+url + row.IDDOCUMENTO+'">'+val+'</a>';
		}
		
		function formatAccion(value,row,index){
			
				if (row.editing){
					var s = '<a href="javascript:void(0)" onclick="endEditing(' + index +')">Guardar</a> ';
					var c = '<a href="javascript:void(0)" onclick="cancelrow(this)">Cancelar</a>';
					return s+c;
				}
				else {
					var e = '<a href="javascript:void(0)" onclick="editrow(this)">Validar</a> ';
					return e;
				}
		}
		
		function endEditing(editIndex){
			
				var ed = $('#dgdoc').datagrid('getEditor', {index:editIndex,field:'IDDOCUMENTO'});
				
				$('#dgdoc').datagrid('endEdit', editIndex);
			
				IDDOCUMENTO = $('#dgdoc').datagrid('getRows')[editIndex]['IDDOCUMENTO'];
				LEGIBLE = $('#dgdoc').datagrid('getRows')[editIndex]['LEGIBLE'];
				IDPETICION = $('#dgdoc').datagrid('getRows')[editIndex]['IDPETICION'];
			
				$.ajax({
						url: '/app/pt_documento/valida/' + IDDOCUMENTO,
						type:'post',
						data:{
							LEGIBLE: LEGIBLE,
							IDPETICION:IDPETICION
						},
						dataType:'json',
						success:function(){
							$.messager.show({
								title: 'Atenci&oacute;n',
								msg:'Documento Validado'
							});
						}
					});
				
				return true;

		}
		
		function editrow(target){
			$('#dgdoc').datagrid('beginEdit', getRowIndex(target));
		}
		function cancelrow(target){
			$('#dgdoc').datagrid('cancelEdit', getRowIndex(target));
		}
		function getRowIndex(target){
			var tr = $(target).closest('tr.datagrid-row');
			return parseInt(tr.attr('datagrid-row-index'));
		}
		
	</script>
</head>

<body>
	<h2><?php echo $modDesc ?></h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Haga click en los botones de la barra de herramientas de la grilla para realizar las operaciones.</div>
	</div>
	
	<table id="dgdoc" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:800px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/pt_documento/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="TIPODOC" width="70" sortable="true">Tipo de Objeto</th>
				<th field="IDPETICION" width="22" sortable="true">Petici&oacute;n</th>
				<th field="FILENAME" width="60" sortable="true" data-options="formatter:formatDownUrl" >Nombre</th>
				<th field="CODIGOHASH" width="60">Hash Asociado</th>
				<th field="LEGIBLE" width="20"> Legible</th>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="editRecord()">Ver Datos Objeto Digital</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:342px; padding: 0 10px 0 10px;" buttons="#dlg-buttons" closed="true" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" novalidate>
                        
			<div class="fitem">
				<label>Tipo de Documento</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPODOC" value="" required="true"
			    data-options="valueField: 'IDTIPODOC',  
                            textField: 'DESCRIPCION', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pt_dm_tipodoc/list'" />
			</div>
			<div class="fitem">
				<label>Petici&oacute;n</label>
				<input name="IDPETICION" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Nombre</label>
				<input name="FILENAME" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Tipo de Archivo</label>
				<input name="FILETYPE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Tama&ntilde;o del Archivo</label>
				<input name="FILESIZE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>C&oacute;digo Hash Asociado</label>
				<input name="CODIGOHASH" class="easyui-validatebox" validType="text"  >
			</div>
			<div class="fitem">
				<label>Documento Legible</label>
				<input type="radio" id="LEGIBLE" class="easyui-validatebox" name="LEGIBLE" value="S" checked="checked">S<input type="radio" id="LEGIBLE" class="easyui-validatebox" name="LEGIBLE" value="N" >N
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="downloadFile()">Descargar</a>
	</div>
</body>
</html>
