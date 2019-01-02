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
                <script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>datagrid-filter.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>viewUtils.js"></script>

	<script type="text/javascript">
		var url,urlInsertVA,urlInsertVJ;
              
		urlInsertVA = '/app/pt_peticionva/create/<?php echo $rowPt['IDPETICION']; ?>';
		urlInsertVJ = '/app/pt_peticionvj/create/<?php echo $rowPt['IDPETICION']; ?>';
		var urlInsertEP = '/app/pt_estudioprevio/create/<?php echo $rowPt['IDPETICION']; ?>';
			
			$(document).ready(function(){
				
				$('#tt_det').tabs('disableTab', 2);
				$('#tt_det').tabs('disableTab', 3);
				
				$('#fmva').form({
						onLoadSuccess: function(data){
								
							if(data!=null){
								$('#bt_saveva').linkbutton('disable');
								$('#bt_savevj').linkbutton('enable');
								$('#tt_det').tabs('enableTab', 2);
							}
						}
					});
				
				$('#fmvj').form({
						onLoadSuccess: function(data){
							
							if(data!=null){
								$('#tt_det').tabs('enableTab', 3);
								$('#bt_savevj').linkbutton('disable');
								$('#bt_saveep').linkbutton('enable');
							}
						}
					});
			
				$('#fmep').form({
						onLoadSuccess: function(data){
							if(data!=null){
							//	$('#tt_det').tabs('enableTab', 3);
								$('#bt_savevj').linkbutton('disable');
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
			if(index == 2){
				url = urlInsertVJ;
				
				formSelected = $('#fmvj');
			}
			if(index == 3){
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
						
						if(index == 2){
							$('#bt_savevj').linkbutton('disable');
							$('#tt_det').tabs('enableTab', 3);
							$('#fmvj').form('load','/app/pt_peticionvj/list/<?php echo $rowPt['IDPETICION']; ?>');
							
						}
						if(index == 3){
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
				     
			}); // end loadajaxdata 
			
		}
	</script>
		
</head>

<body style="padding: 10px;">
	
		<!--<div id="ttpt" class="easyui-tabs" style="width:819px;height:300px" >
	<div title="Datos de <?php echo $opcDesc; ?>" data-options="tools:'#p-tools'" style="padding: 0 0px 0 0px;">
	<div id="pnldet" class="easyui-panel"  style="width:809px;height:580px;" closed="false" data-options="closable:true" style="padding: 0 0px 0 0px;">
-->
	<div id="pnldet"  style="padding: 0px;">
	
			<form id="fm" style="padding: 0 0px 0 0px;">
			<div id='DataProcDiv'>
				<div class="fitem"><label style="width: 195px;">No de Radicado : </label>
					 <?php echo $rowPt['RADICADO']; ?>
					 Estado : <?php echo $rowPt['ESTADOPETICION']; ?>
					 Fuente : <?php echo $rowPt['FUENTE']; ?>
					 <a href="/app/pt_peticion/download/<?php echo $rowPt['IDPETICION']; ?>" >
					 <img src="/MVC_CRUD_JEASY/resources/images/pdf_icon.png"></a>
				<div>
				<div class="fitem"><label style="width: 195px;">Tipo de Petici&oacute;n : </label><?php echo $rowPt['TIPOPETICION']; ?><div>
				<div class="fitem"><label style="width: 195px;">No de Proceso : </label><?php echo $rowPt['NUMRADICADOPROC']; ?><div>
				
			</div>
			<div id="DataCon" class="ftitle" style="padding:5px 10px 5px 0px;">Condenado :
				
				<?php echo  $rowPt['APELLIDOCONDENADO'] . ' ' . $rowPt['APELLIDO2CONDENADO'].' '.$rowPt['NOMBRECONDENADO'].' '.$rowPt['NOMBRE2CONDENADO'].' Establecimiento : '.$rowPt['ESTABLECIMIENTO']; ?>
			</div>	
				
				
			<div id='DataCondDiv'>
				<div class="fitem">
					<label style="width: 195px;">Identificaci&oacute;n : </label><?php echo $rowPt['TIPOIDENTIFICACION']; ?>  No <?php echo $rowPt['NUMEROIDENTIFICACION']; ?><div>
				<div class="fitem"><label style="width: 195px;">Juzgado Fallador : </label><?php echo $rowPt['JUZGADOFALLADOR']; ?> Juzgado Ejecuta : <?php echo $rowPt['JUZGADOEJE']; ?> Ciudad : <?php echo $rowPt['CIUDAD']; ?> / <?php echo $rowPt['DEPARTAMENTO']; ?> <div>
				<div class="fitem"><label style="width: 195px;">Fecha Condena : </label><?php echo $rowPt['FECHACONDENA']; ?> Quantum : A&ntilde;os <?php echo $rowPt['QANTUMANIOS']; ?> Meses : <?php echo $rowPt['QANTUMMESES']; ?> D&iacute;as : <?php echo $rowPt['QANTUMDIAS']; ?><div>
				<div class="fitem"><label style="width: 195px;">Juzgado Fallador : </label><?php echo $rowPt['JUZGADOFALLADOR']; ?> Juzgado Ejecuta : <?php echo $rowPt['JUZGADOEJE']; ?><div>
				<div class="fitem"><label style="width: 195px;">Otro Tipo de Petici&oacute;n : </label><?php echo $rowPt['OTRO']; ?><div>
				<div class="fitem"><label style="width: 195px;">Argumentos : </label><?php echo $rowPt['ARGUMENTOS']; ?><div>
			</div>
			<div id="DataSol" class="ftitle" style="padding:5px 10px 5px 0px;">Solicitante :
				<?php echo $rowPt['APELLIDOSOL'] . ' ' .$rowPt['APELLIDO2SOL'] . ' '. $rowPt['NOMBRESOL'] .' '.  $rowPt['NOMBRE2SOL']; ?>
			</div>
			<div id='DataSolDiv'>
				<div class="fitem"><label style="width: 195px;">Identificaci&oacute;n : </label><?php echo $rowPt['TIPOIDSOLICITANTE']; ?> No <?php echo $rowPt['NUMIDENTIFSOL']; ?><div>
				<div class="fitem"><label style="width: 195px;">Tipo de Relaci&oacute;n : </label>  Otra : <?php echo $rowPt['OTRARELACION']; ?> <div>
				<div class="fitem"><label style="width: 195px;">Direcci&oacute;n : </label><?php echo $rowPt['JUZGADOFALLADOR']; ?> Tel&eacute;fono : <?php echo $rowPt['TELEFONO']; ?> Celular : <?php echo $rowPt['CELULAR']; ?><div>
				<div class="fitem"><label style="width: 195px;">Email : </label><?php echo $rowPt['EMAIL']; ?><div>
			</div>
		</form>
		</div>
		
	</div>
	 <div id="tt_det" class="easyui-tabs" style="width:796px;height:342px" >
		
		<div title="Documentos"  style="padding: 0 0px 0 0px;">
			<table id="dgdoc"class="easyui-datagrid" style="width:790px;height:auto"
			data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,url:'/app/pt_documento/getPtDocs/<?php echo $rowPt['IDPETICION']; ?>'"
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
		<div title="Validaci&oacute;n Administrativa" style="padding:10px">
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
				<label style="width: 350px;">Observaciones :</label>
				<textarea name="VA_OBSERVACIONES"  style="height: 30px;width:580px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Fecha de la Validaci&oacute;n :</label>
				<input name="VA_FECHA" class="easyui-validatebox" size="20" readonly >
			</div>
			<div class="fitem">
				<label>Usuario que realiza : </label>
				<input name="VA_USUARIO" class="easyui-validatebox" validType="text" size="40" readonly>
			</div>
			<div class="fitem">
				<label>Tipo de Resoluci&oacute;n :</label>
				<input type="radio" id="TIPORESOLUCION" class="easyui-validatebox" name="TIPORESOLUCION" value="De Tramite" >De Tramite<input type="radio" id="TIPORESOLUCION" class="easyui-validatebox" name="TIPORESOLUCION" value="Interlocutora" >Interlocutora
			</div>
			 <div align=right style="padding: 10px">
				<a href="#" id="bt_saveva" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
			</div>
		</form>
        </div>
	<div title="Validaci&oacute;n Jur&iacute;dica" style="padding:10px;height: 360px;">
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
	
	
	<div title="Estudio Previo" style="padding:10px;height: 360px;">
		<form id="fmep" method="post" novalidate>
                        
			<div class="fitem">
				<label>Estado :</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Terminado" >Terminado<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="En Estudio" >En Estudio
			</div>
			<div class="fitem">
				<label>Observaci&oacute;n :</label>
				<textarea name="OBSERVACIONES"  style="height: 120px;width:680px;" wrap="virtual"></textarea>
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
	
	</div>
<!--        </div>  
	</div>-->
	  
</body>
</html>
