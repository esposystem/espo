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
                <?php	/**
			 *
			| IDACTUACIONPROCESO | int(11)                      | NO   | PRI | NULL                | auto_increment |
			| NUMRADICADOPROC    | varchar(30)                  | NO   |     |                     |                |
			| IDACTUACION        | varchar(15)                  | NO   |     | NULL                |                |
			| LEGALJUDICIAL      | set('S','N')                 | NO   |     | N                   |                |
			| TERMINO            | set('S','N')                 | NO   |     | N                   |                |
			| DIASTERMINO        | int(11)                      | NO   |     | 0                   |                |
			| FECHAINICIOTERMINO | date                         | NO   |     | NULL                |                |
			| FECHAFINTERMINO    | date                         | NO   |     | NULL                |                |
			| FOLIOS             | varchar(200)                 | YES  |     |                     |                |
			| CUADERNO           | varchar(200)                 | YES  |     |                     |                |
			| IDTIPOPROVICENCIA  | int(11)                      | NO   |     | NULL                |                |
			| NUMEROPROVIDENCIA  | int(11)                      | NO   |     | 0                   |                |
			| FECHAPROVIDENCIA   | date                         | NO   |     | NULL                |                |
			| NOTAACTUACION      | text                         | NO   |     | NULL                |                |
			| FECHAOFICIO        | date                         | NO   |     | NULL                |                |
			| NUMEROOFICIO       | int(11)                      | NO   |     | 0                   |                |
			| TIPOACTUACION      | set('Despacho','Secretaria') | NO   |     | NULL                |                |
			| BORRATERMINO       | set('S','N')                 | NO   |     | N                   |                |
			| RENUNCIATERMINO    | set('S','N')                 | NO   |     | N                   |                |
			 */
			 ?>
				cc.push('<td colspan=' + fields.length + ' style="padding:3px;border:0;">');
				if (!frozen){
					console.log(rowData);
					cc.push('<div style="float:left;margin-left:0px;">');
			
					rowStrCard = '<div class="tabla">';
					rowStrCard += '<p><div class="columna">No Proceso  :</div><div class="columnValor">' + rowData["NUMRADICADOPROC"] + '</div><div class="columna">Actuaci&oacute;n :</div><div class="columnValor2">' + rowData["IDACTUACION"] + ' No : '+ rowData["FECHAACTUACION"]  +'</div></p>';
					rowStrCard += '<p><div class="columna">Legal o Judicial  :</div><div class="columnValor">' + rowData["LEGALJUDICIAL"] +'</div><div class="columna">Termino :</div><div class="columnValor2">' + rowData["TERMINO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Termino  :</div><div class="columnValor">Dias ' + rowData["DIASTERMINO"] + ' Inicio ' + rowData["FECHAINICIOTERMINO"] + ' Fin ' + rowData["FECHAFINTERMINO"] +'</div><div class="columna">Folios :</div><div class="columnValor2">' + rowData["FOLIOS"] + ' Cuaderno : ' + rowData["CUADERNO"] + '</div></p>';
					
					rowStrCard += '<p><div class="columna">Tipo Providencia  :</div><div class="columnValor">' + rowData["IDTIPOPROVICENCIA"] + '</div><div class="columna">No Providencia :</div><div class="columnValor2">' + rowData["NUMEROPROVIDENCIA"] + ' Fecha ' + rowData["FECHAPROVIDENCIA"] +'</div></p>';
					
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
			
                    $('#dg').datagrid('enableFilter' ,[ {
					    field:'LEGALJUDICIAL',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'LEGALJUDICIAL');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'LEGALJUDICIAL',
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
				field:'IDTIPOPROVICENCIA',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/gs_dm_tipoprovidencia/list',
					valueField: 'IDTIPOPROVICENCIA',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDTIPOPROVICENCIA');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDTIPOPROVICENCIA',
								op: 'join',
								value: value,
								param: 'IDTIPOPROVICENCIA'
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
						    data:[{value:'',text:'Todos'},{value:'Despacho',  text:'Despacho' },{value:'Secretaria',  text:'Secretaria' }],
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
				    },{
					    field:'BORRATERMINO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'BORRATERMINO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'BORRATERMINO',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'RENUNCIATERMINO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'RENUNCIATERMINO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'RENUNCIATERMINO',
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
			$('input[name="LEGALJUDICIAL"]').filter('[value=N]').prop('checked', true);
			$('input[name="TERMINO"]').filter('[value=N]').prop('checked', true);
			$('input[name="TIPOACTUACION"]').filter('[value=]').prop('checked', true);
			$('input[name="BORRATERMINO"]').filter('[value=N]').prop('checked', true);
			$('input[name="RENUNCIATERMINO"]').filter('[value=N]').prop('checked', true);
			url = '/app/gs_actuacionproceso/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_actuacionproceso/update/'+row.IDACTUACIONPROCESO;
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
 float:left;width:110px;
 //border-right: 1px solid #ccc;
// border-bottom: 1px solid #ccc;
 font-weight:bold;
 }
 .tabla .columnValor {
 padding: 5px;
 float:left;width:240px;
 border-right: 1px solid #ccc;
// border-bottom: 1px solid #ccc;
 }
  .tabla .columnValor2 {
 padding: 5px;
 float:left;width:280px;
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
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_actuacionproceso/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="NUMRADICADOPROC" width="50" sortable="true">Numero de Proceso</th>
				<th field="IDACTUACION" width="50" sortable="true">Actuaci&oacute;n</th>
				<th field="LEGALJUDICIAL" width="50" sortable="true">Legal o Judicial</th>
				<th field="TERMINO" width="50" sortable="true">Actuaci&oacute;n con T&eacute;rmino</th>
				<th field="FECHAINICIOTERMINO" width="50" sortable="true">Fecha de Inicio T&eacute;rmino</th>
				<th field="FECHAFINTERMINO" width="50" sortable="true">Fecha de Fin T&eacute;rmino</th>
				<th field="IDTIPOPROVICENCIA" width="50" sortable="true">Tipo de Providencia</th>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:628px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Numero de Proceso</label>
				<input name="NUMRADICADOPROC" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Actuaci&oacute;n</label>
				<input name="IDACTUACION" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Legal o Judicial</label>
				<input type="radio" id="LEGALJUDICIAL" class="easyui-validatebox" name="LEGALJUDICIAL" value="S" >S<input type="radio" id="LEGALJUDICIAL" class="easyui-validatebox" name="LEGALJUDICIAL" value="N" checked="checked">N
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
				<label>Fecha de Inicio T&eacute;rmino</label>
				<input name="FECHAINICIOTERMINO" class="easyui-datebox textbox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Fin T&eacute;rmino</label>
				<input name="FECHAFINTERMINO" class="easyui-datebox textbox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Folio</label>
				<input name="FOLIOS" class="easyui-validatebox" validType="text"  >
			</div>
			<div class="fitem">
				<label>Cuaderno</label>
				<input name="CUADERNO" class="easyui-validatebox" validType="text"  >
			</div>
			<div class="fitem">
				<label>Tipo de Providencia</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPOPROVICENCIA" value="" required="true"
			    data-options="valueField: 'IDTIPOPROVICENCIA',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/gs_dm_tipoprovidencia/list'" />
			</div>
			<div class="fitem">
				<label>N&uacute;mero de Providencia</label>
				<input name="NUMEROPROVIDENCIA" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Fecha Providencia</label>
				<input name="FECHAPROVIDENCIA" class="easyui-datebox textbox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Nota Actuaci&oacute;n</label>
				<textarea name="NOTAACTUACION"  required="true"style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Fecha del Oficio</label>
				<input name="FECHAOFICIO" class="easyui-datebox textbox" readonly required="true">
			</div>
			<div class="fitem">
				<label>N&uacute;mero de Oficio</label>
				<input name="NUMEROOFICIO" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label>Actuaci&oacute;n Despacho o Secretaria</label>
				<input type="radio" id="TIPOACTUACION" class="easyui-validatebox" name="TIPOACTUACION" value="Despacho" >Despacho<input type="radio" id="TIPOACTUACION" class="easyui-validatebox" name="TIPOACTUACION" value="Secretaria" >Secretaria
			</div>
			<div class="fitem">
				<label>Borraron los T&eacute;rminos</label>
				<input type="radio" id="BORRATERMINO" class="easyui-validatebox" name="BORRATERMINO" value="S" >S<input type="radio" id="BORRATERMINO" class="easyui-validatebox" name="BORRATERMINO" value="N" checked="checked">N
			</div>
			<div class="fitem">
				<label>Renunciarion T&eacute;rminos</label>
				<input type="radio" id="RENUNCIATERMINO" class="easyui-validatebox" name="RENUNCIATERMINO" value="S" >S<input type="radio" id="RENUNCIATERMINO" class="easyui-validatebox" name="RENUNCIATERMINO" value="N" checked="checked">N
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
