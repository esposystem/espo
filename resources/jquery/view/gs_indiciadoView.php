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
                <!--				
//| NUMDOCUMENTO       | varchar(30)  | NO   | PRI |                     |       |
//| NOMBRECONDENADO    | varchar(200) | NO   |     |                     |       |
//| APELLIDOCONDENADO  | varchar(200) | NO   |     |                     |       |
//| IDTIPOID           | varchar(15)  | NO   |     | NULL                |       |
//| IDCIUDAD           | int(11)      | NO   |     | NULL                |       |
//| IDESTADOCIVIL      | varchar(15)  | NO   |     | NULL                |       |
//| DIRECCION          | varchar(200) | YES  |     |                     |       |
//| DIRECCION2         | varchar(200) | YES  |     |                     |       |
//| TELEFONO           | varchar(30)  | NO   |     |                     |       |
//| TELEFONO2          | varchar(30)  | NO   |     |                     |       |
//| EMAIL              | varchar(40)  | NO   |     | NULL                |       |
//| SANCIONADO         | set('S','N') | NO   |     | N                   |       |
//| NOMBREPADRE        | varchar(200) | YES  |     |                     |       |
//| NOMBREMADRE        | varchar(200) | YES  |     |                     |       |
//| IDCIUDADNACIMIENTO | int(11)      | NO   |     | NULL                |       |
//| FECHANACIMIENTO    | date         | NO   |     | NULL                |       |
//| SEXO               | set('M','F') | NO   |     | NULL                |       |
  -->
		var cardview = $.extend({}, $.fn.datagrid.defaults.view, {
			renderRow: function(target, fields, frozen, rowIndex, rowData){
				
				var opts = $.data(target, 'datagrid').options;
				
			//	console.log(opts);
				var cc = [];
				
				if (frozen && opts.rownumbers){
					var rownumber = rowIndex + 1;
					if (opts.pagination){
						rownumber += (opts.pageNumber-1)*opts.pageSize;
					}
					cc.push('<td class="datagrid-td-rownumber"><div class="datagrid-cell-rownumber">'+rownumber+'</div></td>');
				}

				cc.push('<td colspan=' + fields.length + ' style="padding:3px;border:0;">');
				if (!frozen){
					console.log(rowData);
					cc.push('<div style="float:left;margin-left:0px;">');
			
					rowStrCard = '<div class="tabla">';
					rowStrCard += '<p><div class="columna">No Documento  :</div><div class="columnValor">' + rowData["NUMDOCUMENTO"] + '</div><div class="columna">Condenado :</div><div class="columnValor2">' + rowData["NOMBRECONDENADO"] + ' ' + rowData["APELLIDOCONDENADO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Tipo Documento  :</div><div class="columnValor">' + rowData["TIPOID"] + '</div><div class="columna">Identificaci&oacute;n :</div><div class="columnValor2">' + rowData["NUMDOCUMENTO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Ciudad  :</div><div class="columnValor">' + rowData["CIUDAD"] + '</div><div class="columna">Direcci&oacute;n :</div><div class="columnValor2">' + rowData["DIRECCION"] + '</div></p>';
					
					rowStrCard += '<p><div class="columna">Sexo  :</div><div class="columnValor">' + rowData["SEXO"] + '</div><div class="columna">Fecha Nacimiento :</div><div class="columnValor2">' + rowData["FECHANACIMIENTO"] + '</div></p>';
					
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
				field:'IDCIUDAD',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pr_dm_ciudad/list',
					valueField: 'IDCIUDAD',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDCIUDAD');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDCIUDAD',
								op: 'join',
								value: value,
								param: 'IDCIUDAD'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'SANCIONADO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'SANCIONADO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'SANCIONADO',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
				field:'IDCIUDADNACIMIENTO',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pr_dm_ciudad/list',
					valueField: 'IDCIUDAD',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDCIUDADNACIMIENTO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDCIUDADNACIMIENTO',
								op: 'join',
								value: value,
								param: 'IDCIUDAD'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'SEXO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'M',  text:'M' },{value:'F',  text:'F' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'SEXO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'SEXO',
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
			$('input[name="SANCIONADO"]').filter('[value=N]').prop('checked', true);
$('input[name="SEXO"]').filter('[value=]').prop('checked', true);
			url = '/app/gs_indiciado/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_indiciado/update/'+row.NUMDOCUMENTO;
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
 float:left;width:130px;
 border-right: 1px solid #ccc;
// border-bottom: 1px solid #ccc;
 }
  .tabla .columnValor2 {
 padding: 5px;
 float:left;width:380px;
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
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_indiciado/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="NUMDOCUMENTO" width="50" sortable="true">No Documento</th>
				<th field="NOMBRECONDENADO" width="50" sortable="true">Nombre del Condenado</th>
				<th field="APELLIDOCONDENADO" width="50" sortable="true">Apellido del Condenado</th>
				<th field="CIUDAD" width="50" sortable="true">Ciudad</th>
				<th field="SANCIONADO" width="50" sortable="true">Sancionado</th>
				<th field="FECHANACIMIENTO" width="50" sortable="true">Fecha de Nacimiento</th>
				<th field="SEXO" width="50" sortable="true">Sexo</th>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:528px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Numero de Documento</label>
				<input name="NUMDOCUMENTO" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label>Nombre del Condenado</label>
				<input name="NOMBRECONDENADO" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label>Apellido del Condenado</label>
				<input name="APELLIDOCONDENADO" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label>Tipo de Documento</label>
				<input name="IDTIPOID" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label>Ciudad</label>
				<input id="ccb" class="easyui-combobox" name="IDCIUDAD" value="" required="true"
			    data-options="valueField: 'IDCIUDAD',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pr_dm_ciudad/list'" />
			</div>
			<div class="fitem">
				<label>Estado Civil</label>
				<input name="IDESTADOCIVIL" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label>Direcci&oacute;n</label>
				<input name="DIRECCION" class="easyui-validatebox" validType="text" size="40" >
			</div>
			<div class="fitem">
				<label>Direcci&oacute;n 2</label>
				<input name="DIRECCION2" class="easyui-validatebox" validType="text" size="40" >
			</div>
			<div class="fitem">
				<label>Tel&eacute;fono</label>
				<input name="TELEFONO" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label>Tel&eacute;fono 2</label>
				<input name="TELEFONO2" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label>Email</label>
				<input name="EMAIL" class="easyui-validatebox" validType="email"  required="true">
			</div>
			<div class="fitem">
				<label>Sancionado</label>
				<input type="radio" id="SANCIONADO" class="easyui-validatebox" name="SANCIONADO" value="S" >S<input type="radio" id="SANCIONADO" class="easyui-validatebox" name="SANCIONADO" value="N" checked="checked">N
			</div>
			<div class="fitem">
				<label>Nombre del Padre</label>
				<input name="NOMBREPADRE" class="easyui-validatebox" validType="text" size="40" >
			</div>
			<div class="fitem">
				<label>Nombre de la Madre</label>
				<input name="NOMBREMADRE" class="easyui-validatebox" validType="text" size="40" >
			</div>
			<div class="fitem">
				<label>Ciudad de Nacimiento</label>
				<input id="ccb" class="easyui-combobox" name="IDCIUDADNACIMIENTO" value="" required="true"
			    data-options="valueField: 'IDCIUDAD',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pr_dm_ciudad/list'" />
			</div>
			<div class="fitem">
				<label>Fecha de Nacimiento</label>
				<input name="FECHANACIMIENTO" class="easyui-datebox textbox" readonly required="true">
			</div>
			<div class="fitem">
				<label>Sexo</label>
				<input type="radio" id="SEXO" class="easyui-validatebox" name="SEXO" value="M" >M<input type="radio" id="SEXO" class="easyui-validatebox" name="SEXO" value="F" >F
			</div>
			<div class="fitem">
				<label>Nivel de Estudios</label>
				<input name="IDNIVELESTUDIO" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label>Observaci&oacute;n</label>
				<textarea name="OBSERVACIONES"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
