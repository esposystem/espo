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
		var url,urlInsertVA,urlInsertVJ;
                
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
					rowStrCard += '<p><div class="columna">Tipo de Petici&oacute;n  :</div><div class="columnValor">' + rowData["TIPOPETICION"] + '</div><div class="columna">Condenado :</div><div class="columnValor">' + rowData["APELLIDOCONDENADO"] + ' ' + rowData["APELLIDO2CONDENADO"] + ' ' +  rowData["NOMBRECONDENADO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Centro de Servicios  :</div><div class="columnValor">' + rowData["CENTROSERVICIOS"] + '</div><div class="columna">Identificaci&oacute;n :</div><div class="columnValor">' + rowData["NUMEROIDENTIFICACION"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Ciudad  :</div><div class="columnValor">' + rowData["CIUDAD"] + '</div><div class="columna">No Proceso :</div><div class="columnValor">' + rowData["NUMEROPROCESO"] + '</div></p>';
					
					rowStrCard += '<p><div class="columna">Estado Petici&oacute;n  :</div><div class="columnValor">' + rowData["ESTADOPETICION"] + '</div><div class="columna">No Radicado :</div><div class="columnValor">' + rowData["RADICADO"] + '</div></p>';
					
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
				field:'TIPOPETICION',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pt_dm_tipo/list',
					valueField: 'IDTIPOPETICION',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'TIPOPETICION');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'TIPOPETICION',
								op: 'join',
								value: value,
								param: 'IDTIPOPETICION'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'CENTROSERVICIOS',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/dj_centroservicios/list',
					valueField: 'IDCENTROSERVICIOS',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'CENTROSERVICIOS');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'CENTROSERVICIOS',
								op: 'join',
								value: value,
								param: 'IDCENTROSERVICIOS'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'ESTADOPETICION',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pt_dm_estado/list',
					valueField: 'IDESTADO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'ESTADOPETICION');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'ESTADOPETICION',
								op: 'join',
								value: value,
								param: 'IDESTADOPETICION'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			} ]);
                   
                });   
                
		$('#dg').datagrid('resize');
		
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			
			urlInsertVA = '/app/pt_peticionva/create/'+row.IDPETICION;
			urlInsertVJ = '/app/pt_peticionvj/create/'+row.IDPETICION;
			
			if (row){
				$('#tt').tabs('select',0);
				$('#ttpt').tabs('select',0);
				
				$('#pp').panel('close');
				$('#dlg').dialog('open').dialog('setTitle','Validaci&oacute;n');
				$('#fm').form('load',row);
				
				$('#fmva').form('load','/app/pt_peticionva/list/'+row.IDPETICION);
				$('#fmvj').form('load','/app/pt_peticionvj/list/'+row.IDPETICION);
				
				//loadDocs('/app/pt_documento/list',row);
				
				param = '[{"field":"IDPETICION","op":"equal","value":' + row.IDPETICION + '}]';
			
				$('#dgdoc').datagrid({
					url:'/app/pt_documento/list',
					queryParams: {
						filterRules: param
					}
				});
			
			//$('#dgdoc').datagrid('load');
			console.log(row);
				
				var newBoxDiv = $(document.createElement('div')).attr("id", 'DataProcDiv');
				$("#DataProcDiv").html('');
				$("#DataCon").html('');
				
				strData = '<div class="fitem"><label style="width: 195px;">No de Radicado : </label>'+ row.RADICADO + ' Estado : ' + row.ESTADOPETICION + ' Fuente : ' + row.FUENTE +' <a href="/app/pt_peticion/download/' + row.IDPETICION + '" class="easyui-linkbutton" data-options="iconCls:\'icon-search\'"><img src="/MVC_CRUD_JEASY/resources/images/pdf_icon.png">Formato</a><div>' +
					  '<div class="fitem"><label style="width: 195px;">Tipo de Petici&oacute;n : </label>'+ row.TIPOPETICION +'<div>' +
					  '<div class="fitem"><label style="width: 195px;">No de Proceso : </label>'+ row.NUMEROPROCESO +'<div>';
				
				newBoxDiv.after().html(strData);
			    
				newBoxDiv.appendTo("#DataProcDiv");
				
				$("#DataCon").append(row.APELLIDOCONDENADO + ' ' + row.APELLIDO2CONDENADO  + ' ' + row.NOMBRECONDENADO + ' ' + row.NOMBRE2CONDENADO + ' Establecimiento : ' + row.ESTABLECIMIENTO);
				
				var newBoxDiv = $(document.createElement('div')).attr("id", 'DataCondDiv');
				$("#DataCondDiv").html('');
				
				strData = '<div class="fitem"><label style="width: 195px;">Identificaci&oacute;n : </label>'+ row.TIPOIDENTIFICACION + ' No ' + row.NUMEROIDENTIFICACION + '<div>' +
					  '<div class="fitem"><label style="width: 195px;">Juzgado Fallador : </label>'+ row.JUZGADOFALLADOR + ' Juzgado Ejecuta : '+ row.JUZGADOEJE + ' Ciudad : ' + row.CIUDAD + '/' + row.DEPARTAMENTO + '<div>' +
					  '<div class="fitem"><label style="width: 195px;">Fecha Condena : </label>'+ row.FECHACONDENA + ' Quantum : A&ntilde;os ' + row.QANTUMANIOS + ' Meses : ' + row.QANTUMMESES + ' D&iacute;as : ' + row.QANTUMDIAS + '<div>' +
					  '<div class="fitem"><label style="width: 195px;">Juzgado Fallador : </label>'+ row.JUZGADOFALLADOR + ' Juzgado Ejecuta : '+ row.JUZGADOEJE + '<div>'
					  '<div class="fitem"><label style="width: 195px;">Otro Tipo de Petici&oacute;n : </label>'+ row.OTRO +'<div>' +
					  '<div class="fitem"><label style="width: 195px;">Argumentos : </label>'+ row.ARGUMENTOS +'<div>';
				
				
				newBoxDiv.after().html(strData);
			    
				newBoxDiv.appendTo("#DataCondDiv");
				
				var newBoxDiv = $(document.createElement('div')).attr("id", 'DataSolDiv');
				
				$("#DataSolDiv").html('');
				$("#DataSol").html('');
				
				$("#DataSol").append(row.APELLIDOSOL + ' ' + row.APELLIDO2SOL  + ' ' + row.NOMBRESOL + ' ' + row.NOMBRE2SOL );
				
							
				strData = '<div class="fitem"><label style="width: 195px;">Identificaci&oacute;n : </label>'+ row.TIPOIDSOLICITANTE  + ' No ' + row.NUMIDENTIFSOL +'<div>' +
					  '<div class="fitem"><label style="width: 195px;">Tipo de Relaci&oacute;n : </label>'+ row.TIPORELACION +' Otra : ' + row.OTRARELACION + '<div>' +
					  '<div class="fitem"><label style="width: 195px;">Direcci&oacute;n : </label>'+ row.JUZGADOFALLADOR + ' Tel&eacute;fono : '+ row.TELEFONO + ' Celular : ' + row.CELULAR + '<div>' +
					  '<div class="fitem"><label style="width: 195px;">Email : </label>'+ row.EMAIL +'<div>';
				
				
				newBoxDiv.after().html(strData);
			    
				newBoxDiv.appendTo("#DataSolDiv");
			    
				url = '/app/pt_peticion/update/'+row.IDPETICION;
			}
			
		}
		
		function saveRecord(){
			
			var tab = $('#tt').tabs('getSelected');
			var index = $('#tt').tabs('getTabIndex',tab);
			
			if(index == 0){
				formSelected = $('#fmva');
				url = urlInsertVA;
			}
			if(index == 1){
				url = urlInsertVJ;
				
				formSelected = $('#fmvj');
			}
			
			formSelected.form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					
					var results = eval('(' + result + ')');
                                        
					if (results.success){
                                                
                                                $.messager.show({
							title: 'Confirmaci&oacute;n',
							msg: results.msg
						});
                                                
						if(index == 0) $('#tt').tabs('enableTab', 1);
						if(index == 0) $('#dg').datagrid('reload');	// reload the user data
					} else {
						$.messager.show({
							title: 'Error',
							msg: results.msg
						});
					}
				}
			});
			
		}
		function saveRecord2(){
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

	
	<script type="text/javascript">
	        
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
		});
		
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
		
		function loadDocs(urlJson,rec){
			var listTipo;
			//alert(rec.id);
	
//			filterRules:[{"field":"IDPETICION","op":"contains","value":"10"}]

			loadAjaxData(urlJson,param,function(data) {
			console.log(data);
			
				$('#dgdoc').datagrid('load',data);
				$('#dgdoc').datagrid('reload');
						
			//$.each(data, function(index, value) {
 
			//	console.log(value);		
			//})
				     
			}); // end loadajaxdata 
			
		}
	</script>
		
</head>

<body>
	<h2> <?php echo $modDesc ?></h2>
	

	<div id="pp" class="easyui-panel"  style="width:850px;padding: 0px">	
	<table id="dg" class="easyui-datagrid" style="width:848px;height:494px"
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/pt_peticion/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="TIPOPETICION" width="50" sortable="true">Tipo de Petici&oacute;n</th>
				<th field="CENTROSERVICIOS" width="50" sortable="true">Centro de Servicios </th>
				<th field="ESTADOPETICION" width="50" sortable="true">Estado</th>
				<th field="RADICADO" width="30" sortable="true">No de Radicado</th>
				<th field="NUMEROPROCESO" width="40" sortable="true">No de Proceso</th>
		</thead>
	</table>
	</div>
	<div id="toolbar">
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Ver Informaci&oacute;n</a>
	</div>
	
	<div id="dlg" class="easyui-panel"  style="width:819px;height:580px;" closed="true" title="a" data-options="closable:true">

	 <div id="ttpt" class="easyui-tabs" style="width:819px;height:300px" >
		<div title="Datos de <?php echo $opcDesc; ?>" data-options="tools:'#p-tools'" style="padding: 0 0px 0 0px;">
			<form id="fm">
				<div id='DataProcDiv'>
				</div>
				<div id="DataCon" class="ftitle" style="padding:5px 10px 5px 0px;">Condenado :
				</div>
				<div id='DataCondDiv'>
				</div>
				<div id="DataSol" class="ftitle" style="padding:5px 10px 5px 0px;">Solicitante :
				</div>
				<div id='DataSolDiv'>
				</div>
		</form>
		</div>
		<div title="Documentos"  style="padding: 0 0px 0 0px;">
			<table id="dgdoc"class="easyui-datagrid" style="width:816px;height:269px"
			data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true"
			rownumbers="true" fitColumns="true" singleSelect="true">
			<thead>
				<tr>
					<th field="TIPODOC" width="70" sortable="true">Tipo de Objeto</th>
					<th field="FILENAME" width="60" sortable="true" data-options="formatter:formatDownUrl" >Nombre</th>
					<th field="CODIGOHASH" width="60">Hash Asociado</th>
					<th field="LEGIBLE" width="20" data-options="editor:{type:'checkbox',options:{on:'S',off:'N'}}"> Legible</th>
					<th field="ACCION" width="40" data-options='formatter:formatAccion'> Acci&oacute;n</th>
				</tr>
			</thead>
			</table>
		</div>
	 </div>
	 <div id="tt" class="easyui-tabs" style="width:820px;height:542px" >
		
		<div title="Validaci&oacute;n Administrativa" style="padding:10px">
		<div class="ftitle"></div>
		<form id="fmva" method="post" novalidate>
                        
			<div class="fitem">
				<label style="width: 350px;">N&uacute;mero de Documento Correcto ?</label>
				<input type="radio" id="VA_NUMERODOCUMENTO" class="easyui-validatebox" name="VA_NUMERODOCUMENTO" value="S" >S<input type="radio" id="VA_NUMERODOCUMENTO" class="easyui-validatebox" name="VA_NUMERODOCUMENTO" value="N" checked="checked">N
			</div>
			<div class="fitem">
				<label style="width: 350px;">El Condenado se Encuentra en el Centro de Reclusi&oacute;n ?</label>
				<input type="radio" id="VA_ESTABLECIMIENTORECLUSION" class="easyui-validatebox" name="VA_ESTABLECIMIENTORECLUSION" value="S" >S<input type="radio" id="VA_ESTABLECIMIENTORECLUSION" class="easyui-validatebox" name="VA_ESTABLECIMIENTORECLUSION" value="N" checked="checked">N
			</div>
			<div class="fitem">
				<label style="width: 350px;">La Informaci&oacute;n de la Petici&oacute;n es legible ?</label>
				<input type="radio" id="VA_LEGIBLE" class="easyui-validatebox" name="VA_LEGIBLE" value="S" >S<input type="radio" id="VA_LEGIBLE" class="easyui-validatebox" name="VA_LEGIBLE" value="N" checked="checked">N
			</div>
			<div class="fitem">
				<label style="width: 350px;">Los Documentos de la Petici&oacute;n son legibles ?</label>
				<input type="radio" id="VA_DOCUMENTACIONLEGIBLE" class="easyui-validatebox" name="VA_DOCUMENTACIONLEGIBLE" value="S" >S<input type="radio" id="VA_DOCUMENTACIONLEGIBLE" class="easyui-validatebox" name="VA_DOCUMENTACIONLEGIBLE" value="N" checked="checked">N
			</div>
			<div class="fitem">
				<label style="width: 350px;">Observaciones de la Validaci&oacute;n Administrativa :</label>
				<textarea name="VA_OBSERVACIONES"  style="height: 30px;width:580px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Fecha de la Validaci&oacute;n Administrativa</label>
				<input name="VA_FECHA" class="easyui-datetimebox" readonly >
			</div>
			<div class="fitem">
				<label>Usuario que realiza la Validaci&oacute;n Administrativa</label>
				<input name="VA_USUARIO" class="easyui-validatebox" validType="text"  >
			</div>
			<div class="fitem">
				<label>Tipo de Resoluci&oacute;n de la Petici&oacute;n</label>
				<input type="radio" id="TIPORESOLUCION" class="easyui-validatebox" name="TIPORESOLUCION" value="De Tramite" >De Tramite<input type="radio" id="TIPORESOLUCION" class="easyui-validatebox" name="TIPORESOLUCION" value="Interlocutora" >Interlocutora
			</div>
			 <div align=right style="padding: 10px">
				<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
				<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').panel('close');$('#pp').panel('open');$('#dg').datagrid('reload');">Cancelar</a>
			</div>
		</form>
        </div>
	<div title="Validaci&oacute;n Jur&iacute;dica" style="padding:10px;height: 360px;">
		<div class="ftitle"></div>
		<form id="fmvj" method="post" novalidate>
                        
			<div class="fitem">
				<label>Estado de la Validaci&oacute;n</label>
				<input type="radio" id="VJ_ESTADO" class="easyui-validatebox" name="VJ_ESTADO" value="Sin Validar" checked="checked">Sin Validar<input type="radio" id="VJ_ESTADO" class="easyui-validatebox" name="VJ_ESTADO" value="Aprobada" >Aprobada<input type="radio" id="VJ_ESTADO" class="easyui-validatebox" name="VJ_ESTADO" value="Rechazada" >Rechazada
			</div>
			<div class="fitem">
				<label>Motivo de Rechazo de la Validaci&oacute;n Jur&iacute;dica</label>
				<textarea name="VJ_MOTIVORECHAZO"  style="height: 80px;width:420px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Observaciones de la Validaci&oacute;n Jur&iacute;dica</label>
				<textarea name="VJ_OBSERVACIONES"  style="height: 80px;width:420px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Fecha de la Validaci&oacute;n Jur&iacute;dica</label>
				<input name="VJ_FECHA" class="easyui-datetimebox" readonly >
			</div>
			<div class="fitem">
				<label>Usuario que realiza la Validaci&oacute;n Jur&iacute;dica</label>
				<input name="VJ_USUARIO" class="easyui-validatebox" validType="text"  >
			</div>
			<div class="fitem">
				<label>Archivo Auto Resoluci&oacute;n</label>
				<input name="VJ_AUTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>C&oacute;digo Hash Auto</label>
				<input name="VJ_AUTOCODIGOHASH" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Archivo Oficio Rechazo</label>
				<input name="VJ_OFICIO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>C&oacute;digo Hash Oficio</label>
				<input name="VJ_OFICIOCODIGOHASH" class="easyui-validatebox" validType="text"  required="true">
			</div>
			
			 <div align=right style="padding: 10px">
				<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
				<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').panel('close');$('#pp').panel('open');$('#dg').datagrid('reload');">Cancelar</a>
			</div>
		</form>
	
        </div>  
	</div>
	</div>
	  
</body>
</html>
