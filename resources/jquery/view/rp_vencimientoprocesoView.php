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
					    field:'TIPOREPORTE',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'15 dias',  text:'15 dias' },{value:'30 dias',  text:'30 dias' },{value:'60 dias',  text:'60 dias' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'TIPOREPORTE');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'TIPOREPORTE',
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
			$('input[name="TIPOREPORTE"]').filter('[value=]').prop('checked', true);
			url = '/app/rp_vencimientoproceso/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/rp_vencimientoproceso/update/'+row.IDREPORTE;
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
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/rp_vencimientoproceso/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="NUMDOCUMENTO" width="50" sortable="true">Numero de Documento</th>
				<th field="NUMRADICADOPROC" width="50" sortable="true">Numero de Proceso</th>
				<th field="FECHAREPORTE" width="50" sortable="true">Fecha del Reporte</th>
				<th field="FECHALIBERTAD" width="50" sortable="true">Fecha de Vencimiento</th>
				<th field="TIPOREPORTE" width="50" sortable="true">Tipo de Reporte</th> </tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:290px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Numero de Documento</label>
				<input name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Numero de Proceso</label>
				<input name="NUMRADICADOPROC" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Fecha del Reporte</label>
				<input name="FECHAREPORTE" class="easyui-datetimebox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Vencimiento</label>
				<input name="FECHALIBERTAD" class="easyui-datetimebox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Tipo de Reporte</label>
				<input type="radio" id="TIPOREPORTE" class="easyui-validatebox" name="TIPOREPORTE" value="15 dias" >15 dias<input type="radio" id="TIPOREPORTE" class="easyui-validatebox" name="TIPOREPORTE" value="30 dias" >30 dias<input type="radio" id="TIPOREPORTE" class="easyui-validatebox" name="TIPOREPORTE" value="60 dias" >60 dias
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
