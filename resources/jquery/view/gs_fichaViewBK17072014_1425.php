<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $config->get('appName')?></title>	
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/icon.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/default/easyui.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>demo/demo.css">
		<style>
		.fitem label {
			display: inline-block;
			width: 241px;
			}
		
		</style>
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
					rowStrCard += '<p><div class="columna">Juzgado EPMS  :</div><div class="columnValor">' + rowData["IDDESPACHORADICA"] + '</div><div class="columna">Identificación  :</div><div class="columnValor">' + rowData["NUMDOCUMENTO"] + ' ' + rowData["APELLIDO2CONDENADO"] + ' ' +  rowData["NOMBRECONDENADO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Número de Radicación  :</div><div class="columnValor">' + rowData["NUMRADICADOPROC"] + '</div><div class="columna">Nombres Condenado :</div><div class="columnValor">' + rowData["NOMBRECONDENADO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Ciudad  :</div><div class="columnValor">' + rowData["CIUDAD"] + '</div><div class="columna">Detenido :</div><div class="columnValor">' + rowData["DETENIDO"] + '</div></p>';
					
					rowStrCard += '<p><div class="columna">Vigente :</div><div class="columnValor">' + rowData["VIGENTE"] + '</div><div class="columna">Representante Doc. :</div><div class="columnValor">' + rowData["DOCREPRESENTANTE"] + '</div></p>';
					
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
				field:'IDCIUDAD',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pr_dm_ciudad/list',
					valueField: 'CODIGO',  
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
				field:'IDDESPACHORADICA',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/dj_despacho/list',
					valueField: 'IDDESPACHO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDDESPACHORADICA');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDDESPACHORADICA',
								op: 'join',
								value: value,
								param: 'IDDESPACHO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'DETENIDO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'DETENIDO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'DETENIDO',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
				field:'IDINSTANCIA',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/gs_dm_instancia/list',
					valueField: 'IDINSTANCIA',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDINSTANCIA');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDINSTANCIA',
								op: 'join',
								value: value,
								param: 'IDINSTANCIA'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'VIGENTE',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'VIGENTE');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'VIGENTE',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    } ]);   
                });
        function newRecordJjusticia(){
			$('#dlgnew').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			url = '/app/gs_ficha/create';
		}   
                    
		function newRecord(){
			$('#tt').hide();
			$('#pp').panel('close');
			$('#dlg').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			$('input[name="DETENIDO"]').filter('[value=N]').prop('checked', true);
$('input[name="VIGENTE"]').filter('[value=N]').prop('checked', true);
			url = '/app/gs_ficha/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			$('#tt').show();
			if (row){
				$('#pp').panel('close');
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/gs_ficha/update/'+row.NUMRADICADOPROC;
				urlInsertInd = '/app/gs_indiciado/create/'+row.NUMDOCUMENTO;
			}
			$('#fmindiciados').form('load','/app/gs_indiciado/get/'+row.NUMDOCUMENTO);
			$('#fmcondena').form('load','/app/gs_condena/get/'+row.NUMDOCUMENTO+'-'+row.NUMRADICADOPROC);
			$('#dgdelitos').datagrid({
			    url:'/app/gs_delitoproceso/get/'+row.NUMRADICADOPROC
			});
			$('#dgdelitos').datagrid('reload');
			$('#dgactuaciones').datagrid({
			    url:'/app/gs_actuacionproceso/get/'+row.NUMRADICADOPROC
			});
			$('#dgactuaciones').datagrid('reload');
			$('#dgalias').datagrid({
			    url:'/app/gs_alias/get/'+row.NUMDOCUMENTO
			});
			$('#dgalias').datagrid('reload');
		}
		function saveRecord(){

			var tab = $('#tt').tabs('getSelected');
			var index = $('#tt').tabs('getTabIndex',tab);
			if(index == 0){
				formSelected = $('#fm');
				url = url;
				console.log(url);
			}
			if(index == 1){
				url = urlInsertInd;
				formSelected = $('#fmindiciados');
			}
			formSelected.form('submit',{
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
                        $('#pp').panel('open');                    
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
		function setProcData(){
			$.messager.progress({ title: 'Buscando proceso en Justicia XXI',
				msg: 'Espere por favor',
				text:'Enviando Datos',
				interval : '80'
			});

			 $('#fmVal').form('submit',{
				url : '/app/gs_ficha/valProcJXXI',
				onSubmit: function(){
					
					return $(this).form('validate');
				},
				success: function(result){
					//var result = eval('('+result+')');
					
					$.messager.progress('close');
					console.log(result);
					 var result = eval('(' + result + ')');  // change the JSON string to javascript object
					//if (result.success){
					//    alert(result.message)
					//}
					
					if (result.success){
                                              
                        $.messager.show({
							title: 'Confirmaci&oacute;n',
							msg: 'Ficha creada'
						});
                                                
						$('#dlgnew').dialog('close');
						
						//$('#dlgnew').panel('open');
						//$('#fm').form('load',result.rows);
						
						$('#dg').datagrid('reload');
						
					} else {
						$.messager.show({
							title: 'Error',
							msg: 'Proceso No encontrado'
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
	<div id="pp" class="easyui-panel"  style="width:850px;padding: 0px">	
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:860px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_ficha/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="NUMRADICADOPROC" width="50" sortable="true">No Proceso</th>
				<th field="NUMDOCUMENTO" width="50" sortable="true">No de Documento</th>
				<th field="IDESTABLECIMIENTO" width="50" sortable="true">Establecimiento</th>
				<th field="IDDESPACHORADICA" width="50" sortable="true">Despacho Radica</th>
				<th field="DETENIDO" width="50" sortable="true">Detenido</th>
				<th field="VIGENTE" width="50" sortable="true">Proceso Vigente</th> </tr>
		</thead>
	</table>
</div>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecordJjusticia()">Traer de Justicia XXI</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>

	<div id="toolbardelitos">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecordDelito()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecordDelito()">Editar</a>
	</div>

	<div id="toolbaractuaciones">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>

	<div id="toolbaralias">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>

	<div id="dlgnew" class="easyui-dialog" title="Validaci&oacute;n del Proceso" style="width:510px;height:220px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttonsValida" modal="true">
		
		<div class="ftitle" style="padding:10px 10px 10px 10px;">Ingrese los Datos para buscar Ficha en Justicia XXI
		</div>
		<form id="fmVal" method="post" novalidate>
			<div class="fitem">
				<label style="width: 190px;">N&uacute;mero de Proceso</label>
				<input style="width: 280px;" id="NUMRADICADOPROC" name="NUMRADICADOPROC" class="easyui-validatebox" maxlength="23" validType="text"  required="true" size="32">
			</div>

			<div class="fitem">
				<label style="width: 190px;">N&uacute;mero de Documento del Condenado</label>
				<input style="width: 280px;" id="NUMDOCUMENTO" name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  size="32" required="true">
			</div>
			
			<div class="fitem">
				<label style="width: 190px;">Establecimiento de Reclusion</label>
				<input id="ccb" class="easyui-combobox" name="IDESTABLECIMIENTO" value="" required="true"
			    data-options="valueField: 'IDESTABLECIMIENTO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/er_establecimiento/list'" />
			</div>
		</form>
		<div class="ftitle" style="padding:10px 10px 0px 10px;">
		</div>
			
	</div>
	
	<div id="dlg" class="easyui-panel" style="width:900px;height:auto; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		
			<div title="Ficha T&eacute;cnica" style="padding:10px">

				<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
				<form id="fm" method="post" novalidate>
		            <div class="fitem">
						<label>Juzgado de EPMS</label>
						<input id="ccb" class="easyui-combobox" name="IDDESPACHORADICA" value="" required="true"
					    data-options="valueField: 'IDDESPACHO',  
		                            textField: 'NOMBRE', 
		                            width:280,
					    loader : cloader,
					    panelHeight:'150',
		                            url: '/app/dj_despacho/list'" />
					</div>     
					<div class="fitem">
						<label>N&uacute;mero &uacute;nico de radicaci&oacute;</label>
						<input style="width: 280px;" name="NUMRADICADOPROC" value="" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Ciudad</label>
						<input id="ccb_ciudad" class="easyui-combobox" name="IDCIUDAD" value="" required="true"
					    data-options="valueField: 'CODIGO',  
		                            textField: 'NOMBRE', 
		                            width:280,
					    loader : cloader,
					    panelHeight:'150',
		                            url: '/app/pr_dm_ciudad/list'" />
					</div>
					<div class="fitem">
						<label>Numero de Documento</label>
						<input style="width: 280px;" name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
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
						<label>Detenido</label>
						<input type="radio" id="DETENIDO" class="easyui-validatebox" name="DETENIDO" value="S" >S<input type="radio" id="DETENIDO" class="easyui-validatebox" name="DETENIDO" value="N" checked="checked">N
					</div>
					<div class="fitem">
						<label>Numero de Documento Apoderado</label>
						<input style="width: 280px;" name="DOCREPRESENTANTE" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Nombre del Apoderado</label>
						<input style="width: 280px;" name="NOMBREREPRESENTANTE" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Abogado o Funcionario Judicial</label>
						<input style="width: 280px;" name="FUNCIONARIOABOGADO" class="easyui-validatebox" required="true">
					</div>
					<div class="fitem">
						<label>Entidad Funcionario</label>
						<input id="ccb" class="easyui-combobox" name="IDENTIDADFUNCIONARIO" value="" required="true"
					    data-options="valueField: 'IDENTIDAD',  
		                            textField: 'NOMBRE', 
		                            width:280,
					    loader : cloader,
					    panelHeight:'150',
		                            url: '/app/pr_dm_entidad/list'" />
					</div>
					<div class="fitem">
						<label>Especialidad Despacho Funcionario</label>
						<input id="ccb" class="easyui-combobox" name="IDESPFUNCIONARIO" value="" required="true"
					    data-options="valueField: 'IDESPECIALIDAD',  
		                            textField: 'NOMBRE', 
		                            width:280,
					    loader : cloader,
					    panelHeight:'150',
		                            url: '/app/pr_dm_especialidad/list'" />
					</div>
					<div class="fitem">
						<label>Despacho Funcionario</label>
						<input id="ccb" class="easyui-combobox" name="IDDESPFUNCIONARIO" value="" required="true"
					    data-options="valueField: 'IDDESPACHO',  
		                            textField: 'NOMBRE', 
		                            width:280,
					    loader : cloader,
					    panelHeight:'150',
		                            url: '/app/dj_despacho/list'" />
					</div>
					<div class="fitem">
						<label>Cargo del Funcionario</label>
						<input style="width: 280px;" name="CARGOFUNCIONARIO" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Sancion Disciplinaria CSJ</label>
						<input id="ccb" class="easyui-combobox" name="IDSANCION" value="" required="true"
					    data-options="valueField: 'IDSANCION',  
		                            textField: 'NOMBRE', 
		                            width:280,
					    loader : cloader,
					    panelHeight:'150',
		                            url: '/app/gs_dm_sanciondisciplina/list'" />
					</div>
					<div class="fitem">
						<label>Instancia Donde se Radica el Proceso</label>
						<input id="ccb" class="easyui-combobox" name="IDINSTANCIA" value="" required="true"
					    data-options="valueField: 'IDINSTANCIA',  
		                            textField: 'NOMBRE', 
		                            width:280,
					    loader : cloader,
					    panelHeight:'150',
		                            url: '/app/gs_dm_instancia/list'" />
					</div>
					<div class="fitem">
						<label>N&uacute;mero de Folios</label>
						<input style="width: 280px;" name="FOLIOS" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>N&uacute;mero de Cuadernos</label>
						<input style="width: 280px;" name="CUADERNOS" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Ciudad que Remite</label>
						<input id="ccb" class="easyui-combobox" name="IDCIUDADREMITE" value="" required="true"
					    data-options="valueField: 'CODIGO',  
		                            textField: 'NOMBRE', 
		                            width:280,
					    loader : cloader,
					    panelHeight:'150',
		                            url: '/app/pr_dm_ciudad/list'" />
					</div>
					<div class="fitem">
						<label>IDDESPACHOREMITE</label>
						<input style="width: 280px;" name="IDDESPACHOREMITE" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>Proceso Vigente</label>
						<input type="radio" id="VIGENTE" class="easyui-validatebox" name="VIGENTE" value="S" >S<input type="radio" id="VIGENTE" class="easyui-validatebox" name="VIGENTE" value="N" checked="checked">N
					</div>
				</form>
				<div id="dlg-buttons">
					<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
					<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close'); $('#pp').panel('open');">Cancelar</a>
				</div>
			</div>
			<div id="tt" class="easyui-tabs" style="width:880px;height:auto" >
			<div title="DATOS DEL CONDENADO" style="padding:10px">
				<div class="ftitle">Indiciado de <?php echo $opcDesc; ?></div>
				<form id="fmindiciados" method="post" novalidate>
                        
					<div class="fitem">
						<label>Numero de Documento</label>
						<input style="width: 280px;" name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Nombre del Condenado</label>
						<input style="width: 280px;" name="NOMBRECONDENADO" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Apellido del Condenado</label>
						<input style="width: 280px;" name="APELLIDOCONDENADO" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Tipo de Documento</label>
						<input style="width: 280px;" name="IDTIPOID" class="easyui-validatebox" validType="text"  required="true">
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
						<input style="width: 280px;" name="IDESTADOCIVIL" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Direcci&oacute;n</label>
						<input style="width: 280px;" name="DIRECCION" class="easyui-validatebox" validType="text"  >
					</div>
					<div class="fitem">
						<label>Direcci&oacute;n 2</label>
						<input style="width: 280px;" name="DIRECCION2" class="easyui-validatebox" validType="text"  >
					</div>
					<div class="fitem">
						<label>Tel&eacute;fono</label>
						<input style="width: 280px;" name="TELEFONO" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Tel&eacute;fono 2</label>
						<input style="width: 280px;" name="TELEFONO2" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Email</label>
						<input style="width: 280px;" name="EMAIL" class="easyui-validatebox" validType="email"  required="true">
					</div>
					<div class="fitem">
						<label>Sancionado</label>
						<input type="radio" id="SANCIONADO" class="easyui-validatebox" name="SANCIONADO" value="S" >S<input type="radio" id="SANCIONADO" class="easyui-validatebox" name="SANCIONADO" value="N" checked="checked">N
					</div>
					<div class="fitem">
						<label>Nombre del Padre</label>
						<input style="width: 280px;" name="NOMBREPADRE" class="easyui-validatebox" validType="text"  >
					</div>
					<div class="fitem">
						<label>Nombre de la Madre</label>
						<input style="width: 280px;" name="NOMBREMADRE" class="easyui-validatebox" validType="text"  >
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
						<input style="width: 280px;" name="FECHANACIMIENTO" class="easyui-datebox textbox" readonly required="true">
					</div>
					<div class="fitem">
						<label>Sexo</label>
						<input type="radio" id="SEXO" class="easyui-validatebox" name="SEXO" value="M" >M<input type="radio" id="SEXO" class="easyui-validatebox" name="SEXO" value="F" >F
					</div>
					<div class="fitem">
						<label>Nivel de Estudios</label>
						<input style="width: 280px;" name="IDNIVELESTUDIO" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Observaci&oacute;n</label>
						<textarea name="OBSERVACIONES"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
					</div>
				</form>
			</div>
			<div title="DATOS DE LA CONDENA" style="padding:10px">
				<div class="ftitle">Condena de <?php echo $opcDesc; ?></div>
				<form id="fmcondena" method="post" novalidate>
		                        
					<div class="fitem">
						<label>Numero de Proceso</label>
						<input style="width: 280px;" name="NUMRADICADOPROC" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Numero de Documento</label>
						<input style="width: 280px;" name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Dias Condena</label>
						<input style="width: 280px;" name="DIAS" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>Meses Condena</label>
						<input style="width: 280px;" name="MESES" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>A&ntilde;os Condena</label>
						<input style="width: 280px;" name="ANIOS" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>Dias Rebaja de Pena</label>
						<input style="width: 280px;" name="DIASREBAJA" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>Meses Rebaja de Pena</label>
						<input style="width: 280px;" name="MESESREBAJA" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>A&ntilde;os Rebaja de Pena</label>
						<input style="width: 280px;" name="ANIOSREBAJA" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>Dias Rebaja de Pena</label>
						<input style="width: 280px;" name="DIASACUM" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>Meses Acumulaci6oacute;n de Condena</label>
						<input style="width: 280px;" name="MESESACUM" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>A&ntilde;os Acumulaci&oacute; de Condena</label>
						<input style="width: 280px;" name="ANIOSACUM" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>Dias Condena Actual</label>
						<input style="width: 280px;" name="DIASACTUAL" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>Meses Condena Actual</label>
						<input style="width: 280px;" name="MESESACTUAL" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>A&ntilde;os Condena Actual</label>
						<input style="width: 280px;" name="ANIOSACTUAL" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>Total Dias Condena Actual</label>
						<input style="width: 280px;" name="TOTALDIAS" class="easyui-numberbox" required="true">
					</div>
					<div class="fitem">
						<label>Observaciones Compromiso de la Condena</label>
						<input style="width: 280px;" name="OBS_COMPROMISO" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Observaciones de la Condena Condicional</label>
						<input style="width: 280px;" name="OBS_CONDICIONAL" class="easyui-validatebox" validType="text"  required="true">
					</div>
					<div class="fitem">
						<label>Fecha de Compromiso</label>
						<input style="width: 280px;" name="FECHACOMPROMISO" class="easyui-datebox textbox" readonly required="true">
					</div>
					<div class="fitem">
						<label>Fecha de Termiinaci&oacute;n del Compromiso</label>
						<input style="width: 280px;" name="FECHA_TERM_COMPROMISO" class="easyui-datebox textbox" readonly required="true">
					</div>
					<div class="fitem">
						<label>Fecha de Finalizaci&oacute;n Condena</label>
						<input style="width: 280px;" name="FECHAFINALIZACION" class="easyui-datebox textbox" readonly required="true">
					</div>
					<div class="fitem">
						<label>Fecha de Cumplimiento del Compromiso</label>
						<input style="width: 280px;" name="FECHACUMPLIMIENTO" class="easyui-datebox textbox" readonly required="true">
					</div>
					<div class="fitem">
						<label>Fecha de Revocatoria del Compromiso</label>
						<input style="width: 280px;" name="FECHAREVOCATORIA" class="easyui-datebox textbox" readonly required="true">
					</div>
				</form>
			</div>
			<div title="DELITOS" style="padding:10px">
				<table id="dgdelitos" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:860px;height:394px"
	    
				    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_delitoproceso/get/'"
						toolbar="#toolbardelitos" pagination="true"
						rownumbers="true" fitColumns="true" singleSelect="true">
					<thead>
						<tr>
			    				<th field="NUMRADICADOPROC" width="50" sortable="true">Numero de Proceso</th>
							<th field="IDDELITO" width="50" sortable="true">Delito</th>
							<th field="IDMODADELITO" width="50" sortable="true">Modalidad Delito</th> </tr>
					</thead>
				</table>
			</div>
			<div title="ACTUACIONES" style="padding:10px">
				<table id="dgactuaciones" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:860px;height:394px"
	    
				    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_actuacionproceso/list'"
						toolbar="#toolbaractuaciones" pagination="true"
						rownumbers="true" fitColumns="true" singleSelect="true">
					<thead>
						<tr>
			    			<th field="FECHADESANOTACION" width="10%" sortable="true">FECHA</th>
			    			<th field="TIPOACTUACION" width="10%" sortable="true">TIPO ACTUACIÓN</th>
							<th field="NOTAACTUACION" width="60%" sortable="true">ANOTACI&Oacute;N</th>
							<th field="FOLIOS" width="10%" sortable="true">FOLIO</th>
							<th field="CUADERNO" width="10%" sortable="true">CUADERNO</th>
						</tr>
					</thead>
				</table>
			</div>
			<div title="Alias" style="padding:10px">
				<table id="dgalias" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:860px;height:394px"
	    
				    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_alias/list'"
						toolbar="#toolbaralias" pagination="true"
						rownumbers="true" fitColumns="true" singleSelect="true">
					<thead>
						<tr>
			    			<th field="NUMDOCUMENTO" width="50" sortable="true">Numero de Documento</th>
							<th field="DESCALIAS" width="50" sortable="true">Alias</th> </tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<div id="dlg-buttonsValida" >
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="setProcData()">Buscar</a>
	</div>
	
</body>
</html>
