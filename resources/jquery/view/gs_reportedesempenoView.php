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
				//	console.log(rowData);
					//var aa = rowData.itemid.split('-');
					//var img = 'shirt' + aa[1] + '.gif';
					//cc.push('<img src="images/' + img + '" style="width:150px;float:left">');
					cc.push('<div style="float:left;margin-left:0px;">');
				
				//	for(var i=0; i<fields.length; i++){
				//		var copts = $(target).datagrid('getColumnOption', fields[i]);
				
					//	cc.push('<p><span class="c-label">' + copts.title + ':</span> ' + rowData[fields[i]] + '</p>');
					//cc.push('<div class="fitem"><label>' + copts.title + ':</label> ' + rowData[fields[i]] + '</div>');
					
					//<div class="fitem"><label>Estado de la Petici&oacute;n</label></div>
	//console.log(rowData);
//alert(fields[i]);
					rowStrCard = '<div class="tabla">';
					rowStrCard += '<p><div class="columna">Actividad  :</div><div class="columnValor">' + rowData["ACTIVIDAD"] + '</div><div class="columna">Identificación  :</div><div class="columnValor">' + rowData["NUMDOCUMENTO"] + '</div></p>'; //+ ' ' + rowData["APELLIDO2CONDENADO"] + ' ' +  rowData["NOMBRECONDENADO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Número de Certificado  :</div><div class="columnValor">' + rowData["NUMEROCERTIFICADO"] + '</div><div class="columna">Nombres Condenado :</div><div class="columnValor">' + rowData["NOMBRECONDENADO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Establecimiento  :</div><div class="columnValor">' + rowData["ESTABLECIMIENTO"] + '</div><div class="columna">Fecha de Acta :</div><div class="columnValor">' + rowData["FECHAACTA"] + '</div></p>';
					
					rowStrCard += '<p><div class="columna">Fecha de Inicio :</div><div class="columnValor">' + rowData["FECHAINICIO"] + '</div><div class="columna"> Fecha de Fin</div><div class="columnValor">' + rowData["FECHAFIN"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Calificación :</div><div class="columnValor">' + rowData["CALIFICACION"] + '</div><div class="columna"> </div><div class="columnValor"></div></p>';
					rowStrCard += '</div>';
				
					
					cc.push(rowStrCard);
	
						
				//	}
					
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
				field:'IDACTIVIDAD',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/gs_dm_actividad/list',
					valueField: 'IDACTIVIDAD',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDACTIVIDAD');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDACTIVIDAD',
								op: 'join',
								value: value,
								param: 'IDACTIVIDAD'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDESTABLECIMIENTO',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/er_establecimiento/list',
					valueField: 'IDESTABLECIMIENTO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDESTABLECIMIENTO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDESTABLECIMIENTO',
								op: 'join',
								value: value,
								param: 'IDESTABLECIMIENTO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'CALIFICACION',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Deficiente',  text:'Deficiente' },{value:'Sobresaliente',  text:'Sobresaliente' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'CALIFICACION');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'CALIFICACION',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'FUENTE',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Manual',  text:'Manual' },{value:'Automatica',  text:'Automatica' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'FUENTE');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'FUENTE',
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
			url = '/app/gs_reportedesempeno/create';
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			$('input[name="CALIFICACION"]').filter('[value=]').prop('checked', true);
$('input[name="FUENTE"]').filter('[value=]').prop('checked', true);
			
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_reportedesempeno/update/'+row.IDREPORTE;
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
 float:left;width:230px;
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
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_reportedesempeno/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="IDACTIVIDAD" width="50" sortable="true">Activida</th>
				<th field="IDESTABLECIMIENTO" width="50" sortable="true">Establecimiento</th>
				<th field="NUMDOCUMENTO" width="50" sortable="true">Identificación</th>
				<th field="FECHAINICIO" width="50" sortable="true">Fecha de Inicio</th>
				<th field="FECHAFIN" width="50" sortable="true">Fecha Final</th>
				<th field="CALIFICACION" width="50" sortable="true">Calificaci&oacute;n </th>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:602px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Codigo de la Actividad</label>
				<input id="ccb" class="easyui-combobox" name="IDACTIVIDAD" value="" required="true"
			    data-options="valueField: 'IDACTIVIDAD',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/gs_dm_actividad/list'" />
			</div>
			<div class="fitem">
				<label>Establecimiento Judicial</label>
				<input id="ccb" class="easyui-combobox" name="IDESTABLECIMIENTO" value="" required="true"
			    data-options="valueField: 'IDESTABLECIMIENTO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/er_establecimiento/list'" />
			</div>
			<div class="fitem">
				<label>Numero de Documento del Condenado</label>
				<input name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Numero de Interno</label>
				<input name="NUMEROINTERNO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Numero de Certifiado</label>
				<input name="NUMEROCERTIFICADO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Numero de Acta</label>
				<input name="NUMEROACTA" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Numero de Acta de Asignaci&oacute;n</label>
				<input name="NUMEROACTAASIGNACION" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Acta</label>
				<input name="FECHAACTA" class="easyui-datebox textbox"  >
			</div>
			<div class="fitem">
				<label>Orden Acta</label>
				<input name="ORDENACTA" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Descripci&oacute;n de la Labor</label>
				<input name="DESCRIPCIONLABOR" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Inicio</label>
				<input name="FECHAINICIO" class="easyui-datebox textbox"  >
			</div>
			<div class="fitem">
				<label>Fecha Final</label>
				<input name="FECHAFIN" class="easyui-datebox textbox"  >
			</div>
			<div class="fitem">
				<label>Calificaci&oacute;n </label>
				<input type="radio" id="CALIFICACION" class="easyui-validatebox" name="CALIFICACION" value="Deficiente" >Deficiente<input type="radio" id="CALIFICACION" class="easyui-validatebox" name="CALIFICACION" value="Sobresaliente" >Sobresaliente
			</div>
			<div class="fitem">
				<label>Archivo Digital Certificado</label>
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
				<label>Fuente de la Informaci&oacute;n </label>
				<input type="radio" id="FUENTE" class="easyui-validatebox" name="FUENTE" value="Manual" >Manual<input type="radio" id="FUENTE" class="easyui-validatebox" name="FUENTE" value="Automatica" >Automatica
			</div>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
	</div>
</body>
</html>
