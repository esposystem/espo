<?php

//print_r($rowPt);

?>
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
        <!--        <script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>datagrid-filter.js"></script>
                <script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>datagrid-detailview.js"></script>
	-->
	<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>viewUtils.js"></script>

	<script type="text/javascript">
		var url,urlInsertVA,urlInsertVJ;
              
		urlInsertVA = '/app/pt_peticionva/create/<?php echo $rowPt['IDPETICION']; ?>';
		urlInsertVJ = '/app/pt_peticionvj/create/<?php echo $rowPt['IDPETICION']; ?>';
		var urlInsertEP = '/app/pt_estudioprevio/create/<?php echo $rowPt['IDPETICION']; ?>';
			
			$(document).ready(function(){
				
				$('#tt_det').tabs('disableTab', 2);
				$('#tt_det').tabs('disableTab', 2);
				
				$('#fmva').form({
						onLoadSuccess: function(data){
								
							if(data!=null){
								$('#bt_saveva').linkbutton('disable');
								//$('#bt_savevj').linkbutton('enable');
								$('#tt_det').tabs('enableTab', 2);
							}
						}
					});
				
				$('#fmvj').form({
						onLoadSuccess: function(data){
							
							if(data!=null){
								$('#tt_det').tabs('enableTab', 2);
								//$('#bt_savevj').linkbutton('disable');
								$('#bt_saveep').linkbutton('enable');
							}
						}
					});
			
				$('#fmep').form({
						onLoadSuccess: function(data){
							if(data!=null){
							//	$('#tt_det').tabs('enableTab', 3);
							//	$('#bt_savevj').linkbutton('disable');
								$('#bt_saveep').linkbutton('disable');
							}
						}
					});
				
				$('#fmva').form('load','/app/pt_peticionva/list/<?php echo $rowPt['IDPETICION']; ?>');
				
				$('#fmvj').form('load','/app/pt_peticionvj/list/<?php echo $rowPt['IDPETICION']; ?>');
				
				$('#fmep').form('load','/app/pt_estudioprevio/list/<?php echo $rowPt['IDPETICION']; ?>');
				
			});
					
			function editRecord(){
				var row = $('#dg').datagrid('getSelected');
				
				
				if (row){
					$('#tt').tabs('select',0);
				//	$('#ttpt').tabs('select',0);
					
					$('#pp').panel('close');
					$('#dlg').dialog('open').dialog('setTitle','Validaci&oacute;n');
					$('#fm').form('load',row);
					
					
					//loadDocs('/app/pt_documento/list',row);
					
					param = '[{"field":"IDPETICION","op":"equal","value":' + <?php echo $rowPt['IDPETICION']; ?> + '}]';
				
					url = '/app/pt_peticion/update/'+row.IDPETICION;
				}
				
			}
		
		
		function saveRecord(){
			
			var tab = $('#tt_det').tabs('getSelected');
			var index = $('#tt_det').tabs('getTabIndex',tab);
			
			if(index == 1){
				formSelected = $('#fmva');
				url = urlInsertVA;
			}
			//if(index == 2){
			//	url = urlInsertVJ;
				
			//	formSelected = $('#fmvj');
			//}
			
			if(index == 2){
				url = urlInsertEP;
				formSelected = $('#fmep');
			}
			
			
			formSelected.form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					
					var results = eval('(' + result + ')');
                                        
					if (results.success){
                                                
                                              //  $.messager.show({
						//	title: 'Confirmaci&oacute;n',
					//		msg: results.msg
					//	});
					
							
                                                $.messager.confirm('Confirmaci&oacute;n',results.msg);
						
						if(index == 1){
							$('#fmva').form('load','/app/pt_peticionva/list/<?php echo $rowPt['IDPETICION']; ?>');
						
							$('#tt_det').tabs('enableTab', 2);
							$('#bt_saveva').linkbutton('disable');
							 $('#dg').datagrid('reload');
							
						//	$('#fmva').form('load','/app/pt_peticionva/list/<?php echo $rowPt['IDPETICION']; ?>');
						}// reload datagrid
						
					//	if(index == 2){
					//		$('#bt_savevj').linkbutton('disable');
					//		$('#tt_det').tabs('enableTab', 3);
					//		$('#fmvj').form('load','/app/pt_peticionvj/list/<?php echo $rowPt['IDPETICION']; ?>');
							
					//	}
						if(index == 2){
							$('#bt_saveep').linkbutton('disable');
							//$('#tt_det').tabs('enableTab', 3);
							$('#fmep').form('load','/app/pt_estudioprevio/list/<?php echo $rowPt['IDPETICION']; ?>');
							
						}
						
						
						
					} else {
						//$.messager.show({
						//	title: 'Error',
						//	msg: results.msg
						//});
						
						$.messager.alert('Atenci&oacute;n',results.msg);
					}
				}
			});
			
		}
		
	</script>
	<script type="text/javascript">
	        
                $(function(){
			
			$('#tt_pt').tabs({
				onBeforeClose: function(title){
				      $('#dg').datagrid('reload');
				}
			});
			
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
			
			function formatPrevBoton(value,row,index){
				
				var e = ' <a href="#" onclick="javascript:openPopWin( \'/app/gs_oficio/vistaPrevia/2_' + row.IDPETICION +'_' + row.IDOFICIO + '\',\'Vista Previa\',880,550,false,true);" class="easyui-linkbutton" data-options="iconCls:\'icon-search\'" style="width:120px">Vista Previa</a>';
     
//						var e = '<a href="javascript:void(0)" onclick="editrow(this)">Validar</a> ';
						return e;
					
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
				     
			}); // end loadajaxdata 
			
		}

		function newDocs(){
			$('#docnew').dialog('open').dialog('setTitle','Agregar documento');
			//$('#fm').form('clear');
			//url = '/app/gs_ficha/create';
		} 

		function newOficio(){
			$('#oficionew').dialog('open').dialog('setTitle','Agregar Oficio');
			//$('#fm').form('clear');
			//url = '/app/gs_ficha/create';
		} 
		
		function subirDoc(){
			
			var tab = $('#tt_det').tabs('getSelected');
			var index = $('#tt_det').tabs('getTabIndex',tab);
			formSelected = $('#fmDocs');
			url =  '/app/pt_documento/upload/';
		
			formSelected.form('submit',{
				url: url,
				onSubmit: function(){

					return $(this).form('validate');
				},
				success: function(result){
					console.log(result);
					var results = eval('(' + result + ')');
                                        
					if (results.success){
						$('#oficionew').dialog('close');
						$('#dgdoc').datagrid('reload');
                        $.messager.confirm('Confirmaci&oacute;n',results.msg);
						
					} else {
						$.messager.alert('Atenci&oacute;n',results.msg);
					}
				}
			});
			
		}
		
		function crearOf(){
			
			//var tab = $('#tt_det').tabs('getSelected');
			//var index = $('#tt_det').tabs('getTabIndex',tab);
			formSelected = $('#fmOf');
			url =  '/app/gs_oficio/create/';
		
			formSelected.form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					console.log(result);
					var results = eval('(' + result + ')');
                                        
					if (results.success){
						$('#oficionew').dialog('close');
						$('#dgOf').datagrid('reload');
						$.messager.confirm('Confirmaci&oacute;n',results.msg);
						
					} else {
						$.messager.alert('Atenci&oacute;n',results.msg);
					}
				}
			});
			
		}
	</script>
	
	<style>
		.tblDatos table {      font-size: 11px;     font-weight: normal;     background: #b9c9fe;
			border-top: 0px solid #aabcfe;    border-bottom: 0px solid #fff; color: #039;}
		    
		    .tblDatos th {     font-size: 11px;   padding: 1px;  font-weight: bold;  text-align: left;   background: #ddd;
			 color: #039; white-space: nowrap;}
		    
		    .tblDatos td {  font-size: 11px;   background: #e8edff;     border-bottom: 0px solid #fff;
			color: #669;    border-top: 0px solid #aabcfe; }
		    
		    .tblDatos tr:hover td { background: #d0dafd; color: #339; }
	</style>
		
</head>

<body style="padding: 2px;">
	
		<!--<div id="ttpt" class="easyui-tabs" style="width:819px;height:300px" >
	<div title="Datos de <?php echo $opcDesc; ?>" data-options="tools:'#p-tools'" style="padding: 0 0px 0 0px;">
	<div id="pnldet" class="easyui-panel"  style="width:809px;height:580px;" closed="false" data-options="closable:true" style="padding: 0 0px 0 0px;">
-->
	<div id="docnew" class="easyui-dialog" title="Agregar Documento" style="width:510px;height:220px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttonsValida" modal="true">
		
		<div class="ftitle" style="padding:10px 10px 10px 10px;">Ingrese los Datos
		</div>
		<form id="fmDocs" method="post" novalidate enctype="multipart/form-data">
			<div class="fitem">
				<label style="width: 100px;">Documento</label>
				<input style="width: 280px;" type="file" id="NUMRADICADOPROC" name="NUMRADICADOPROC" class="easyui-validatebox" maxlength="23" validType="file"  required="true" size="32">
			</div>
			
			<div class="fitem">
				<label style="width: 100px;">Tipo de objeto</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPODOC" value="" required="true"
					data-options="valueField: 'IDTIPODOC',  
					textField: 'NOMBRE', 
					width:280,
					loader : cloader,
					panelHeight:'150',
					url: '/app/pt_dm_tipodoc/list'" />
				<input id="" name="IDPETICION" value="<?php echo $rowPt['IDPETICION']; ?>" type="hidden">
			</div>
		</form>
		<div class="ftitle" style="padding:10px 10px 0px 10px;">
		</div>
			
	</div>
	
	<div id="oficionew" class="easyui-dialog" title="Generar Oficio" style="width:540px;height:400px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttonsValida" modal="true">
		<form id="fmOf" method="post" novalidate>
                        
			<input name="IDTIPOOFICIO" type="hidden" value="2">
			
			<input name="IDACTUACION" type="hidden" value="0">
			<input name="IDPETICION" type="hidden" value="<?php echo $rowPt['IDPETICION']; ?>">
			
			<input name="NUMDOCUMENTO" type="hidden" value="<?php echo $rowPt['NUMDOCUMENTO']; ?>">
			<input name="NUMRADICADOPROC" type="hidden" value="<?php echo $rowPt['NUMRADICADOPROC']; ?>">
			<input name="IDAUDIENCIA" type="hidden" value="0">
			
			<div class="fitem">
				<label>Fecha</label>
				<input name="FECHA" class="easyui-datetimebox" size="25" required="true">
			</div>
			<div class="fitem">
				<label>Fecha de Vencimiento</label>
				<input name="FECHAVENCIMIENTO" class="easyui-datetimebox" size="25" required="true">
			</div>
			<div class="fitem">
				<label>Destinatario</label>
				<input name="DESTINATARIO" class="easyui-validatebox" validType="text" size="40"  required="true">
			</div>
			<div class="fitem">
				<label>Email Destinatario</label>
				<input name="EMAILDESTINATARIO" class="easyui-validatebox" validType="email" size="40"  required="true">
			</div>
			<div class="fitem">
				Contenido<br>
				<textarea name="CONTENIDO"  required="true"style="height: 80px;width:420px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Estado</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="PDTE JUEZ" >PDTE JUEZ<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="AUTORIZADO" >AUTORIZADO
			</div>
		</form>
	</div>
		
	</div>
	<div id="pnldet"  style="padding: 0px; width:860px;height:210px;">
	
			<form id="fm" style="padding: 0 0px 0 0px;">
				
		<table width="860px" class="tblDatos">
			<tr><th>No de Radicado :
				</th>
				<td> <?php echo $rowPt['RADICADO']; ?>
				</td>
				<th>
					 Estado : 
				</th>
				<td>
					 <?php echo $rowPt['ESTADOPETICION']; ?>
				</td>
				<th>
					 Fuente :
				</th>
				<td>
					  <?php echo $rowPt['FUENTE']; ?>
					 <a href="/app/pt_peticion/download/<?php echo $rowPt['IDPETICION']; ?>" >
					 <img src="/MVC_CRUD_JEASY/resources/images/pdf_icon.png"></a>
				</td>
			</tr>
			<tr>
				<th>Tipo de Petici&oacute;n : 
				</th>
				<td> <?php echo $rowPt['TIPOPETICION']; ?>
				</td>
				<th>No de Proceso :
				</th>
				<td colspan="3"><?php echo $rowPt['NUMRADICADOPROC']; ?>
				</td>
			</tr>
			<tr>
				<th colspan="6">
					Condenado : 	<?php echo  $rowPt['APELLIDOCONDENADO'] . ' ' . $rowPt['APELLIDO2CONDENADO'].' '.$rowPt['NOMBRECONDENADO'].' '.$rowPt['NOMBRE2CONDENADO'].' Establecimiento : '.$rowPt['ESTABLECIMIENTO']; ?>
			
				</th>
			</tr>
			<tr><th>Identificaci&oacute;n :
				</th>
				<td> <?php echo $rowPt['TIPOIDENTIFICACION']; ?>  No <?php echo $rowPt['NUMDOCUMENTO']; ?>
				</td>
				<th>
					 Juzgado Fallador :
				</th>
				<td>
					<?php echo $rowPt['JUZGADOFALLADOR']; ?>
				</td>
				<th>
					Juzgado Ejecuta : 
				</th>
				<td>
					 <?php echo $rowPt['JUZGADOEJE']; ?> Ciudad : <?php echo $rowPt['CIUDAD']; ?> / <?php echo $rowPt['DEPARTAMENTO']; ?>
				</td>
			</tr>
			
			<tr><th>Fecha Condena :
				</th>
				<td> <?php echo $rowPt['FECHACONDENA']; ?>
				</td>
				<th>
					 Quantum : 
				</th>
				<td colspan="3">
					A&ntilde;os <?php echo $rowPt['QANTUMANIOS']; ?> Meses : <?php echo $rowPt['QANTUMMESES']; ?> D&iacute;as : <?php echo $rowPt['QANTUMDIAS']; ?>
				</td>
				
			</tr>
			<tr><th>Otro Tipo :
				</th>
				<td> <?php echo $rowPt['OTRO']; ?>
				</td>
				<th>
					 Argumentos :
				</th>
				<td colspan="3">
					<?php echo $rowPt['ARGUMENTOS']; ?>	 
				</td>
				
			</tr>
			<tr>
				<th colspan="6">
					Solicitante :		<?php echo $rowPt['APELLIDOSOL'] . ' ' .$rowPt['APELLIDO2SOL'] . ' '. $rowPt['NOMBRESOL'] .' '.  $rowPt['NOMBRE2SOL']; ?>
			
				</th>
			</tr>
			<tr><th>Identificaci&oacute;n :
				</th>
				<td> <?php echo $rowPt['TIPOIDSOLICITANTE']; ?> No <?php echo $rowPt['NUMIDENTIFSOL']; ?>
				</td>
				<th>
					Tipo de Relaci&oacute;n :
				</th>
				<td>
					<?php echo $rowPt['TIPORELACION']; ?>
				</td>
				<th>
					 Otro Tipo :
				</th>
				<td>
					 <?php echo $rowPt['OTRARELACION']; ?>
				</td>
			</tr>
			<tr><th>Direcci&oacute;n :
				</th>
				<td> <?php echo $rowPt['DIRECCION']; ?>
				</td>
				
				<th>
					 Tel&eacute;fono / Celular:
				</th>
				<td>
					 <?php echo $rowPt['TELEFONO']; ?> /  <?php echo $rowPt['CELULAR']; ?>
				</td>
				<th>
					Email :
				</th>
				<td>
					 <?php echo $rowPt['EMAIL']; ?>
				</td>
			</tr>
		</table>
		
		</form>
		</div>
		
	</div>
	 <div id="tt_det" class="easyui-tabs" style="width:860px;height:270px" >
		
		<div title="Documentos"  style="padding: 0 0px 0 0px;">
			<table id="dgdoc"class="easyui-datagrid" style="width:790px;height:auto"
			data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,url:'/app/pt_documento/getPtDocs/<?php echo $rowPt['IDPETICION']; ?>'"
			rownumbers="true" toolbar="#docstoolbar" fitColumns="true" singleSelect="true">
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
		<div id="docstoolbar">
			<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newDocs()">Agregar documento</a>
		</div>
		
		<div title="Validaci&oacute;n Administrativa" style="padding:10px">
		<form id="fmva" method="post" novalidate>
			
		<table><tr><td>N&uacute;mero de Documento Correcto ?</td>
				<td>
					<input type="radio" id="VA_NUMERODOCUMENTO" class="easyui-validatebox" name="VA_NUMERODOCUMENTO" value="S" >S
				<input type="radio" id="VA_NUMERODOCUMENTO" class="easyui-validatebox" name="VA_NUMERODOCUMENTO" value="N" checked="checked">N
				</td>
			<td><label>El Condenado se Encuentra en el Centro de Reclusi&oacute;n ?</label></td>
				<td>
					<input type="radio" id="VA_ESTABLECIMIENTORECLUSION" class="easyui-validatebox" name="VA_ESTABLECIMIENTORECLUSION" value="S" >S<input type="radio" id="VA_ESTABLECIMIENTORECLUSION" class="easyui-validatebox" name="VA_ESTABLECIMIENTORECLUSION" value="N" checked="checked">N
				</td>
			</tr>
			<tr><td>La Informaci&oacute;n de la Petici&oacute;n es legible ?</td>
				<td>	<input type="radio" id="VA_LEGIBLE" class="easyui-validatebox" name="VA_LEGIBLE" value="S" >S<input type="radio" id="VA_LEGIBLE" class="easyui-validatebox" name="VA_LEGIBLE" value="N" checked="checked">N
			</td>
				<td>Los Documentos de la Petici&oacute;n son legibles ?</td>
				<td>	<input type="radio" id="VA_DOCUMENTACIONLEGIBLE" class="easyui-validatebox" name="VA_DOCUMENTACIONLEGIBLE" value="S" >S<input type="radio" id="VA_DOCUMENTACIONLEGIBLE" class="easyui-validatebox" name="VA_DOCUMENTACIONLEGIBLE" value="N" checked="checked">N
			</td>
			</tr>
			<tr><td colspan="4">Observaciones :<br>
				<textarea name="VA_OBSERVACIONES"  style="height: 30px;width:580px;" wrap="virtual"></textarea>
				</td>
				
			</tr>
			<tr><td>Fecha de la Validaci&oacute;n :</td>
				<td>
				<input name="VA_FECHA" class="easyui-validatebox" size="20" readonly >
				</td>
				<td colspan="2">Usuario que realiza : <input name="VA_USUARIO" class="easyui-validatebox" validType="text" size="40" readonly>
				</td>
			</tr>
			<tr><td>Tipo de Resoluci&oacute;n :</td>
				<td>
					<input type="radio" id="TIPORESOLUCION" class="easyui-validatebox" name="TIPORESOLUCION" value="De Tramite" >De Tramite<input type="radio" id="TIPORESOLUCION" class="easyui-validatebox" name="TIPORESOLUCION" value="Interlocutora" >Interlocutora
				</td>
				<td colspan="2">
					
				</td>
			</tr>
		</table>
		
			 <div align=right style="padding: 10px">
				<a href="#" id="bt_saveva" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
			</div>
		</form>
        </div>
	<!--<div title="Validaci&oacute;n Jur&iacute;dica" style="padding:10px;height: 360px;">
		<form id="fmvj" method="post" novalidate>
                        
			<div class="fitem">
				<label>Estado de Validaci&oacute;n :</label>
				<input type="radio" id="VJ_ESTADO" class="easyui-validatebox" name="VJ_ESTADO" value="Sin Validar" checked="checked">Sin Validar<input type="radio" id="VJ_ESTADO" class="easyui-validatebox" name="VJ_ESTADO" value="Aprobada" >Aprobada<input type="radio" id="VJ_ESTADO" class="easyui-validatebox" name="VJ_ESTADO" value="Rechazada" >Rechazada
			</div>
			<div class="fitem">
				<label>Motivo de Rechazo :</label><br>
				<textarea name="VJ_MOTIVORECHAZO" style="height: 40px;width:620px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Observaciones :</label><br>
				<textarea name="VJ_OBSERVACIONES" style="height: 40px;width:620px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Fecha de la Validaci&oacute;n :</label>
				<input name="VJ_FECHA" class="easyui-validatebox" size="20" readonly>
			</div>
			<div class="fitem">
				<label>Usuario que realiza :</label>
				<input name="VJ_USUARIO" class="easyui-validatebox" validType="text" size="40" readonly>
			</div>
			
			<div class="fitem">
				<label>Archivo Auto Resoluci&oacute;n :</label>
				<input type="file" style="width:200px" name="VJ_AUTO" id="VJ_AUTO">
			</div>
			<div class="fitem">
				<label>Archivo Oficio  VJ_OFICIO:</label>
				<input type="file" name="VJ_OFICIO"  style="width:180px" id="VJ_OFICIO">
     
			</div>
			
			<input type="hidden" name="VJ_AUTO" value="">
			<input type="hidden" name="VJ_OFICIO" value="">
			
			 <div align=right style="padding: 10px">
				<a href="#" id="bt_savevj" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
			</div>
		</form>
	</div>
	-->
	
	<div title="Estudio Previo" style="padding:5px;height: 240px;">
		<form id="fmep" method="post" novalidate>
                        
			<div class="fitem">
				<label>Estado :</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Terminado" >Terminado<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="En Estudio" >En Estudio
			</div>
			<div class="fitem">
				Observaci&oacute;n :<br>
				<textarea name="OBSERVACIONES"  style="height: 80px;width:740px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Usuario que realiza :</label>
				<input name="USUARIOTRCR" class="easyui-validatebox" validType="text" size="40" readonly>
			</div>
			<div align=right style="padding: 10px">
				<a href="#" id="bt_saveep" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
			</div>
		</form>
	</div>
	
	<div title="Oficios" style="padding:5px;height: 240px;">
		<?php  $rowPt['IDOFICIO'] = 1; ?>
		
		<div title="Oficios"  style="padding: 0 0px 0 0px;">
			<table id="dgOf" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:840px;height:200px"
				data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/gs_oficio/getOfPT/<?php echo $rowPt['IDPETICION']; ?>'"
				toolbar="#oficiostoolbar" pagination="true"
				rownumbers="true" fitColumns="true" singleSelect="true">
			<thead>
			<tr>
    				<th field="TIPOOFICIO" width="50" sortable="true">Tipo de Oficio</th>
				<th field="FECHA" width="50" sortable="true">Fecha</th>
				<th field="FECHAVENCIMIENTO" width="50" sortable="true">Fecha Vencimiento</th>
				<th field="DESTINATARIO" width="50" sortable="true">Destinatario</th>
				<th field="EMAILDESTINATARIO" width="50" sortable="true">Email Destinatario</th>
				<th field="BOTON" width="40" data-options='formatter:formatPrevBoton'> Oficio</th>
			</thead>
			</table>
		</div>
		<div id="oficiostoolbar">
			<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newOficio()">Agregar Oficio</a>
		</div>
		
		
	</div>
	
	</div>
<!--        </div>  
	</div>-->
	<div id="dlg-buttonsValida" >
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="crearOf()">Crear Oficio</a>
	</div>
	
	<div id="winpop" class="easyui-window" closed="true"><div id="panelpop"></div></div>  

</body>
</html>
