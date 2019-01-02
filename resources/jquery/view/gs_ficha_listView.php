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
					rowStrCard += '<p><div class="columna">Juzgado EPMS  :</div><div class="columnValor">' + rowData["IDDESPACHORADICA"] + '</div><div class="columna">Identificación  :</div><div class="columnValor">' + rowData["NUMDOCUMENTO"] + '</div></p>';
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
			
			addTab('Detalle Ficha', '/app/gs_ficha/detail/'+row.NUMDOCUMENTO+'-'+row.NUMRADICADOPROC);
			return true;
			
		}
		
		function editRecord2(){
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
	
	
	<script>
		function addTab(title, url){
			if ($('#tt_pt').tabs('exists', title)){
				$('#tt_pt').tabs('select', title);
			} else {
				var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:900px;"></iframe>';
				$('#tt_pt').tabs('add',{
					title:title,
					content:content,
					closable:true
				});
			}
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
 padding: 2px;
 float:left;width:140px;
 //border-right: 1px solid #ccc;
// border-bottom: 1px solid #ccc;
 font-weight:bold;
 }
 .tabla .columnValor {
 padding: 2px;
 float:left;width:230px;
 border-right: 1px solid #ccc;
// border-bottom: 1px solid #ccc;
 }
	</style>

</head>

<body style="padding:5px">
	
	<div id="tt_pt" class="easyui-tabs" style="width:860px;height:525px;">
		<!-- INCIO TAB1-->
	<div title="Listado Fichas" style="padding:0px">
	<table id="dg" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:845px;height:484px"
	    
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
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Ver Ficha</a>
	</div>

	
	
	
	</div>
	
	<div id="dlgnew" class="easyui-dialog" title="Validaci&oacute;n del Proceso" style="width:510px;height:280px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttonsValida" modal="true">
		
		<div class="ftitle" style="padding:10px 10px 10px 10px;">Ingrese los Datos para buscar Ficha en Justicia XXI
		</div>
		<form id="fmVal" method="post" novalidate>
			<div class="fitem">
				<label style="width: 140px;">No de Proceso</label>
				<input style="width: 280px;" id="NUMRADICADOPROC" name="NUMRADICADOPROC" class="easyui-validatebox" maxlength="23" validType="text"  required="true" size="28">
			</div>

			<div class="fitem">
				<label style="width: 140px;">No de Doc. Condenado</label>
				<input style="width: 280px;" id="NUMDOCUMENTO" name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  size="28" required="true">
			</div>
			
			<div class="fitem">
				<label style="width: 140px;">Establecimiento de Reclusion</label>
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
	<div id="dlg-buttonsValida" >
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="setProcData()">Buscar</a>
	</div>
	
</body>
</html>
