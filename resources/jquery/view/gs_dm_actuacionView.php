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
                   $('#dg').datagrid('enableFilter' ,[ {
					    field:'CICLO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'CICLO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'CICLO',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'TERMINO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'TERMINO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'TERMINO',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'TIPOACTUACION',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'A',  text:'A' },{value:'D',  text:'D' },{value:'O',  text:'O' },{value:'P',  text:'P' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'TIPOACTUACION');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'TIPOACTUACION',
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
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			$('input[name="CICLO"]').filter('[value=N]').prop('checked', true);
			$('input[name="TERMINO"]').filter('[value=N]').prop('checked', true);
			$('input[name="TIPOACTUACION"]').filter('[value=]').prop('checked', true);
			url = '/app/gs_dm_actuacion/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_dm_actuacion/update/'+row.IDACTUACION;
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

	</script>
</head>

<body>
	<h2><?php echo $modDesc ?></h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Haga click en los botones de la barra de herramientas de la grilla para realizar las operaciones.</div>
	</div>
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:800px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_dm_actuacion/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="IDACTUACION" width="30" sortable="true">C&oacute;digo</th>
				<th field="IDPADRE" width="50" sortable="true">Actuaci&oacute;n Padre</th>
				<th field="NOMBRE" width="50" sortable="true">Nombre</th>
				<th field="CICLO" width="50" sortable="true">Definici&oacute;n de un Ciclo</th>
				<th field="TIPOTERMINO" width="50" sortable="true">Tipo T&eacute;rmino</th>
				<th field="TIPOACTUACION" width="50" sortable="true">Tipo Actuaci&oacute;n</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:342px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>C&oacute;digo</label>
				<input name="IDACTUACION" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Actuaci&oacute;n Padre</label>
				<input name="IDPADRE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Nombre</label>
				<input name="NOMBRE" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Definici&oacute;n de un Ciclo</label>
				<input type="radio" id="CICLO" class="easyui-validatebox" name="CICLO" value="S" >S<input type="radio" id="CICLO" class="easyui-validatebox" name="CICLO" value="N" checked="checked">N
			</div>
			<div class="fitem">
				<label>Actuaci&oacute;n con T&eacute;rmino</label>
				<input type="radio" id="TERMINO" class="easyui-validatebox" name="TERMINO" value="S" >S<input type="radio" id="TERMINO" class="easyui-validatebox" name="TERMINO" value="N" checked="checked">N
			</div>
			<div class="fitem">
				<label>N&uacute;mero de D&iacute;as del T&eacute;rmino</label>
				<input name="DIASTERMINO" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Tipo T&eacute;rmino</label>
				<input name="TIPOTERMINO" class="easyui-validatebox" maxlength="1" required="true">
			</div>
			<div class="fitem">
				<label>Tipo Actuaci&oacute;n</label>
				<input type="radio" id="TIPOACTUACION" class="easyui-validatebox" name="TIPOACTUACION" value="A" >A<input type="radio" id="TIPOACTUACION" class="easyui-validatebox" name="TIPOACTUACION" value="D" >D<input type="radio" id="TIPOACTUACION" class="easyui-validatebox" name="TIPOACTUACION" value="O" >O<input type="radio" id="TIPOACTUACION" class="easyui-validatebox" name="TIPOACTUACION" value="P" >P
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
