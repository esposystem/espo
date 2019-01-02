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
		<script type="text/javascript" src="<?php echo $config->get('jqueryFolder')?>/jquery.simple-color.min.js"></script>


	<script  type="text/javascript">
	$(document).ready(function(){
		$('.simple_color').simpleColor();
		
		$('.simple_color_custom').simpleColor({
				cellWidth: 9,
				cellHeight: 9,
				border: '1px solid #333333',
				buttonClass: 'button',
				displayColorCode: true
		});
		
		$('input#alert_button').click( function() {
			alert($('input.simple_color_custom')[0].value);
		});
		
	});
	</script>
	<style type="text/css">
		
		.simpleColorDisplay {
			float: left;
			font-family: Helvetica;
		}
		
		
	</style>

	<script type="text/javascript">
		var url;
                
                $(function(){
                    $('#dg').datagrid('enableFilter' ,[ {
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
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			$('input[name="ESTADO"]').filter('[value=Inactivo]').prop('checked', true);
			url = '/app/pt_dm_estado/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			console.log(row);
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				
				url = '/app/pt_dm_estado/update/'+row.IDESTADO;
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
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:700px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/pt_dm_estado/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="CODIGO" width="50" sortable="true">C&oacute;digo</th>
				<th field="NOMBRE" width="50" sortable="true">Estado </th>
				<th field="DESCRIPCION" width="50" sortable="true">Descripci&oacute;n</th>
				<th field="ESTADO" width="50" sortable="true">Estado</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:344px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate> 
			<div class="fitem">
				<label>C&oacute;digo </label>
				<input name="CODIGO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Estado</label>
				<input name="NOMBRE" class="easyui-validatebox" validType="text" size="40" >
			</div>
			<div class="fitem">
				<label>Descripci&oacute;n</label>
				<textarea name="DESCRIPCION"  style="height:20px;width:460px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Estado</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Activo" >Activo<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Inactivo" checked="checked">Inactivo
			</div>
			<div class="fitem"></label>
				<label>Color </label><input id="COLOR" name="COLOR" class="simple_color_custom" value="" validType="text">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
