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
                
		var cardview = $.extend({}, $.fn.datagrid.defaults.view, {
			renderRow: function(target, fields, frozen, rowIndex, rowData){
				
				var opts = $.data(target, 'datagrid').options;
				var cc = [];
				
				if (frozen && opts.rownumbers){
					var rownumber = rowIndex + 1;
					if (opts.pagination){
						rownumber += (opts.pageNumber-1)*opts.pageSize;
					}
					cc.push('<td class="datagrid-td-rownumber"><div class="datagrid-cell-rownumber">'+rownumber+'</div></td>');
				}
<?php
		/*
		 *mysql> desc GS_CONDENA;
			| IDCONDENA             | int(11)      | NO   | PRI | NULL                | auto_increment |
			| NUMRADICADOPROC       | varchar(30)  | NO   |     |                     |                |
			| NUMDOCUMENTO          | varchar(30)  | NO   |     |                     |                |
			| DIAS                  | int(11)      | NO   |     | 0                   |                |
			| MESES                 | int(11)      | NO   |     | 0                   |                |
			| ANIOS                 | int(11)      | NO   |     | 0                   |                |
			| DIASREBAJA            | int(11)      | NO   |     | 0                   |                |
			| MESESREBAJA           | int(11)      | NO   |     | 0                   |                |
			| ANIOSREBAJA           | int(11)      | NO   |     | 0                   |                |
			| DIASACUM              | int(11)      | NO   |     | 0                   |                |
			| MESESACUM             | int(11)      | NO   |     | 0                   |                |
			| ANIOSACUM             | int(11)      | NO   |     | 0                   |                |
			| DIASACTUAL            | int(11)      | NO   |     | 0                   |                |
			| MESESACTUAL           | int(11)      | NO   |     | 0                   |                |
			| ANIOSACTUAL           | int(11)      | NO   |     | 0                   |                |
			| TOTALDIAS             | int(11)      | NO   |     | 0                   |                |
			| OBS_COMPROMISO        | varchar(200) | NO   |     |                     |                |
			| OBS_CONDICIONAL       | varchar(200) | NO   |     |                     |                |
			| FECHACOMPROMISO       | date         | NO   |     | NULL                |                |
			| FECHA_TERM_COMPROMISO | date         | NO   |     | NULL                |                |
			| FECHAFINALIZACION     | date         | NO   |     | NULL                |                |
			| FECHACUMPLIMIENTO     | date         | NO   |     | NULL                |                |
			| FECHAREVOCATORIA      | date         | NO   |     | NULL                |                |
		 *
		 **/
		?>
		
				cc.push('<td colspan=' + fields.length + ' style="padding:3px;border:0;">');
				if (!frozen){
					console.log(rowData);
					cc.push('<div style="float:left;margin-left:0px;">');
			
					rowStrCard = '<div class="tabla">';
					rowStrCard += '<p><div class="columna">No Proceso  :</div><div class="columnValor">' + rowData["NUMRADICADOPROC"] + '</div><div class="columna">Doc Condenado :</div><div class="columnValor2">' + rowData["NUMDOCUMENTO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Condena  :</div><div class="columnValor">Dias ' + rowData["DIAS"] + ' Meses ' + rowData["MESES"] + ' A&ntilde;os ' + rowData["ANIOS"] +'</div><div class="columna">Rebaja :</div><div class="columnValor2">Dias ' + rowData["DIASREBAJA"] + ' Meses ' + rowData["MESESREBAJA"] + ' A&ntilde;os ' + rowData["ANIOSREBAJA"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Acumulados  :</div><div class="columnValor">Dias ' + rowData["DIASACUM"] + ' Meses ' + rowData["MESESACUM"] + ' A&ntilde;os ' + rowData["ANIOSACUM"] +'</div><div class="columna">Actual :</div><div class="columnValor2">Dias ' + rowData["DIASACTUAL"] + ' Meses ' + rowData["MESESACTUAL"] + ' A&ntilde;os ' + rowData["ANIOSACTUAL"] + '</div></p>';
					
					rowStrCard += '<p><div class="columna">Total Dias  :</div><div class="columnValor">' + rowData["TOTALDIAS"] + '</div><div class="columna">Fecha Compromiso :</div><div class="columnValor2">' + rowData["FECHACOMPROMISO"] + '</div></p>';
					
					rowStrCard += '</div>';
				
					cc.push(rowStrCard);
		
					cc.push('</div>');
				}
				cc.push('</td>');
				return cc.join('');
			}
		});
		
                $(function(){
			
			$('#dg').datagrid({
				view: cardview
			});
			
                    $('#dg').datagrid('enableFilter');    
                });   
                    
		function newRecord(){
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			
			url = '/app/gs_condena/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_condena/update/'+row.IDCONDENA;
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
	<style type="text/css">
		.c-label{
			display:inline-block;
			width:350px;
			font-weight:bold;
		}
		
		.tabla {
 width: 786px;
 border-top:1px solid #ddd;
 border-left:1px solid #ddd;
 background-color:#F7F7F7;
 color: gray;
// text-align:center;
 font-family:arial,verdana,times;
 font-size:12px;
  border-bottom: 1px solid #ccc;

 }
.tabla p {
 clear:both;
 width: 100%;
 margin: 0;
}

.tabla .titulo {
 padding: 2px;
 background-color: #ddd;
 font-family:arial,verdana,times;
 float:left;
 width:100px;
 border-right: 1px solid #ccc;
 font-weight:bold;
 }

.tabla .columna {
 padding: 5px;
 float:left;width:140px;
 //border-right: 1px solid #ccc;
// border-bottom: 1px solid #ccc;
 font-weight:bold;
 }
 .tabla .columnValor {
 padding: 5px;
 float:left;width:180px;
 border-right: 1px solid #ccc;
// border-bottom: 1px solid #ccc;
 }
  .tabla .columnValor2 {
 padding: 5px;
 float:left;width:260px;
 border-right: 1px solid #ccc;
// border-bottom: 1px solid #ccc;
 }
	</style>	
</head>

<body>
	<h2><?php echo $modDesc ?></h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Haga click en los botones de la barra de herramientas de la grilla para realizar las operaciones.</div>
	</div>
	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:820px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_condena/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="NUMRADICADOPROC" width="50" sortable="true">No de Proceso</th>
				<th field="NUMDOCUMENTO" width="50" sortable="true">No Documento</th>
				<th field="FECHACOMPROMISO" width="50" sortable="true">Fecha de Compromiso</th>
				<th field="FECHA_TERM_COMPROMISO" width="50" sortable="true">Fin Compromiso</th>
				<th field="FECHAFINALIZACION" width="50" sortable="true">Fin Condena</th>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:532px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Numero de Proceso</label>
				<input name="NUMRADICADOPROC" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label>Numero de Documento</label>
				<input name="NUMDOCUMENTO" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label>Dias Condena</label>
				<input name="DIAS" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Meses Condena</label>
				<input name="MESES" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>A&ntilde;os Condena</label>
				<input name="ANIOS" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Dias Rebaja de Pena</label>
				<input name="DIASREBAJA" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Meses Rebaja de Pena</label>
				<input name="MESESREBAJA" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>A&ntilde;os Rebaja de Pena</label>
				<input name="ANIOSREBAJA" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Dias Rebaja de Pena</label>
				<input name="DIASACUM" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Meses Acumulaci6oacute;n de Condena</label>
				<input name="MESESACUM" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>A&ntilde;os Acumulaci&oacute; de Condena</label>
				<input name="ANIOSACUM" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Dias Condena Actual</label>
				<input name="DIASACTUAL" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Meses Condena Actual</label>
				<input name="MESESACTUAL" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>A&ntilde;os Condena Actual</label>
				<input name="ANIOSACTUAL" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Total Dias Condena Actual</label>
				<input name="TOTALDIAS" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Obs. Compromiso de la Condena</label>
			</div>
			<div class="fitem">
				<textarea name="OBS_COMPROMISO"  style="height: 50px;width:460px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem" style="width:420px;">
				<label>Obs. Condena Condicional</label>
				<textarea name="OBS_CONDICIONAL"  style="height: 70px;width:460px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Fecha de Compromiso</label>
				<input name="FECHACOMPROMISO" class="easyui-datebox textbox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Termiinaci&oacute;n del Compromiso</label>
				<input name="FECHA_TERM_COMPROMISO" class="easyui-datebox textbox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Finalizaci&oacute;n Condena</label>
				<input name="FECHAFINALIZACION" class="easyui-datebox textbox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Cumplimiento del Compromiso</label>
				<input name="FECHACUMPLIMIENTO" class="easyui-datebox textbox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Revocatoria del Compromiso</label>
				<input name="FECHAREVOCATORIA" class="easyui-datebox textbox" readonly required="true">
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
