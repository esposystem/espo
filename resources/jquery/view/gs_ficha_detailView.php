<?php

//print_r($rowFicha);
?>
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
	     
	     $(document).ready(function(){
		
			$('#fm').form('load','/app/gs_ficha/get/<?php echo $rowFicha['NUMDOCUMENTO']; ?>-<?php echo $rowFicha['NUMRADICADOPROC']; ?>');
			
			$('#fmindiciados').form('load','/app/gs_indiciado/get/<?php echo $rowFicha['NUMDOCUMENTO']; ?>');
			$('#fmcondena').form('load','/app/gs_condena/get/<?php echo $rowFicha['NUMDOCUMENTO']; ?>-<?php echo $rowFicha['NUMRADICADOPROC']; ?>');
			
			$('#dgdelitos').datagrid({
			    url:'/app/gs_delitoproceso/get/<?php echo $rowFicha['NUMRADICADOPROC']; ?>'
			});
			
			//$('#dgdelitos').datagrid('reload');
			
			$('#dgactuaciones').datagrid({
			    url:'/app/gs_actuacionproceso/get/<?php echo $rowFicha['NUMRADICADOPROC']; ?>'
			});
			//$('#dgactuaciones').datagrid('reload');
			
			$('#dgalias').datagrid({
			    url:'/app/gs_alias/get/<?php echo $rowFicha['NUMDOCUMENTO']; ?>'
			});
			//$('#dgalias').datagrid('reload');
	     });
			
			
        function newRecordJjusticia(){
			$('#dlgnew').dialog('open').dialog('setTitle','Crear ');
			$('#fm').form('clear');
			url = '/app/gs_ficha/create';
		}   
                    
		function newRecord(){
			$('#tt').hide();
			//$('#pp').panel('close');
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
				//$('#pp').panel('close');
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
                                               
						
						$.messager.alert('Confirmaci&oacute;n',result.msg,'info');
						
						//$('#pp').panel('open');
						
						$('#dlg').dialog('close');	// close the dialog
						$('#dg').datagrid('reload');	// reload the user data
					} else {
						
						$.messager.alert('Confirmaci&oacute;n',result.msg,'error');
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


</head>

<body style="padding: 5px 0px 0px 10px;">
	
<!--	<div id="toolbardelitos">
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

-->
<?php  /*   "NUMRADICADOPROC": "11001600004920060152000",
    "NUMDOCUMENTO": "79653416",
    "IDCIUDAD": "11001",
    "IDESTABLECIMIENTO": "4132",
    "IDDESPACHORADICA": "2",
    "DETENIDO": "S",
    "DOCREPRESENTANTE": "41634822",
    "NOMBREREPRESENTANTE": "CARMEN ELIZA BARON RUBIO",
    "FUNCIONARIOABOGADO": " ",
    "IDENTIDADFUNCIONARIO": "0",
    "IDESPFUNCIONARIO": "0",
    "IDDESPFUNCIONARIO": "",
    "CARGOFUNCIONARIO": "",
    "IDSANCION": "0",
    "IDINSTANCIA": "0",
    "FOLIOS": "",
    "CUADERNOS": "",
    "IDCIUDADREMITE": "11001",
    "IDDESPACHOREMITE": "49",
    "VIGENTE": "N",
    "FECHATRCR": "",
    "USUARIOTRCR": "",
    "FECHATRED": "",
    "USUARIOTRED": "",
    "CIUDAD": "BOGOTA, D.C. (CUNDINAMARCA)",
    "NOMBRECONDENADO": "ROOSVELT MEDINA PEREZ"
    */
    ?>

	<!--<div id="dlg" class="easyui-panel" style="width:900px;height:auto; padding: 0 0px 0 0px;" closed="false" buttons="#dlg-buttons" modal="true">
		-->
		<div title="Ficha T&eacute;cnica" style="padding:6px;" >
			<div id="DataProcDiv">
				<div id="DataCon" class="ftitle" style="padding:5px 10px 5px 0px;background-color: #ddd">No de Radicado : <?php echo $rowFicha['NUMRADICADOPROC']; ?></div>
				<div class="fitem"><label style="width: 195px;"><strong>Condenado : </strong></label><?php echo $rowFicha['NOMBRECONDENADO']; ?> <strong>Documento : </strong><?php echo $rowFicha['NUMDOCUMENTO']; ?><div>
				<div class="fitem"><label style="width: 195px;"><strong>Ciudad : </strong></label><?php echo $rowFicha['IDCIUDAD'].' / '.$rowFicha['CIUDAD']; ?><div>
				<div class="fitem"><label style="width: 195px;"><strong>Establecimiento : </strong></label><?php echo $rowFicha['ESTABLECIMIENTO']; ?><div>
			
			<div id='DataProcDiv'>
				<div id="DataCon" class="ftitle" style="padding:5px 10px 5px 0px;">Representante :</div>
				<div class="fitem"><label style="width: 195px;"><strong>Apoderado : </strong></label><?php echo $rowFicha['NOMBREREPRESENTANTE']; ?><strong> Documento :</strong><?php echo $rowFicha['DOCREPRESENTANTE']; ?><div>
				<div class="fitem"><label style="width: 195px;"><strong>Vigente : </strong></label><?php echo $rowFicha['VIGENTE']; ?><strong> Detenido :</strong> <?php echo $rowFicha['DETENIDO']; ?><div>
				<div class="fitem"><label style="width: 195px;"><strong>Folios :</strong></label><?php echo $rowFicha['FOLIOS']; ?><strong> Cuadernos :</strong> <?php echo $rowFicha['CUADERNOS']; ?><div>
			</div>
			
				
		</div>
			<div id="DataCon" class="ftitle" style="padding:0px 10px 5px 0px;"></div>
			<div id="tt" class="easyui-tabs" style="width:830px;height:auto" >
			<div title="Condenado" style="padding:10px">
				<form id="fmindiciados" method="post" novalidate>
					
					<div class="fitem">
						<label>Estado Civil</label>
						<input style="width: 280px;" name="IDESTADOCIVIL"  validType="text">
					</div>
					<div class="fitem">
						<label>Direcci&oacute;n</label>
						<input style="width: 280px;" name="DIRECCION"  validType="text"  >
					</div>
					<div class="fitem">
						<label>Direcci&oacute;n 2</label>
						<input style="width: 280px;" name="DIRECCION2" validType="text"  >
					</div>
					<div class="fitem">
						<label>Tel&eacute;fono</label>
						<input style="width: 280px;" name="TELEFONO">
					</div>
					<div class="fitem">
						<label>Tel&eacute;fono 2</label>
						<input style="width: 280px;" name="TELEFONO2">
					</div>
					<div class="fitem">
						<label>Email</label>
						<input style="width: 280px;" name="EMAIL" class="easyui-validatebox" validType="email"  >
					</div>
					<div class="fitem">
						<label>Sancionado</label>
						<input type="radio" id="SANCIONADO" class="easyui-validatebox" name="SANCIONADO" value="S" >S<input type="radio" id="SANCIONADO" class="easyui-validatebox" name="SANCIONADO" value="N" checked="checked">N
					</div>
					<div class="fitem">
						<label>Nombre del Padre</label>
						<input style="width: 280px;" name="NOMBREPADRE">
					</div>
					<div class="fitem">
						<label>Nombre de la Madre</label>
						<input style="width: 280px;" name="NOMBREMADRE">
					</div>
					<div class="fitem">
						<label>Ciudad de Nacimiento</label>
						<input id="ccb" class="easyui-combobox" name="IDCIUDADNACIMIENTO" value="" 
					    data-options="valueField: 'IDCIUDAD',  
		                            textField: 'NOMBRE', 
		                            width:280,
					    loader : cloader,
					    panelHeight:'150',
		                            url: '/app/pr_dm_ciudad/list'" />
					</div>
					<div class="fitem">
						<label>Fecha de Nacimiento</label>
						<input style="width: 280px;" name="FECHANACIMIENTO" class="easyui-datebox textbox" readonly >
					</div>
					<div class="fitem">
						<label>Sexo</label>
						<input type="radio" id="SEXO" class="easyui-validatebox" name="SEXO" value="M" >M<input type="radio" id="SEXO" class="easyui-validatebox" name="SEXO" value="F" >F
					</div>
					<div class="fitem">
						<label>Nivel de Estudios</label>
						<input style="width: 280px;" name="IDNIVELESTUDIO">
					</div>
					<div class="fitem">
						<label>Observaci&oacute;n</label>
						<textarea name="OBSERVACIONES"  style="height: 60px;width:280px;" wrap="virtual"></textarea>
					</div>
				</form>
			</div>
			<div title="Condena" style="padding:10px">
				<form id="fmcondena" method="post" novalidate>
		                       
					<div class="fitem">
						<label><strong>Condena :</strong> </label>Dias
						<input style="width: 30px;" name="DIAS" class="easyui-numberbox" >
						Meses
						<input style="width: 30px;" name="MESES" class="easyui-numberbox" >
						A&ntilde;os
						<input style="width: 30px;" name="ANIOS" class="easyui-numberbox" >
					</div>
					
					<div class="fitem">
						<label><strong> Rebaja :</strong></label>Dias 
						<input style="width: 30px;" name="DIASREBAJA" class="easyui-numberbox" >
						Meses
						<input style="width: 30px;" name="MESESREBAJA" class="easyui-numberbox" >
						A&ntilde;os
						<input style="width: 30px;" name="ANIOSREBAJA" class="easyui-numberbox" >
					</div>
					
					<div class="fitem">
						<label><strong>Acumula de Pena :</strong></label>Dias
						<input style="width: 30px;" name="DIASACUM" class="easyui-numberbox" >
						Meses
						<input style="width: 30px;" name="MESESACUM" class="easyui-numberbox" >
						A&ntilde;os
						<input style="width: 30px;" name="ANIOSACUM" class="easyui-numberbox" >
					</div>
					
					
					
					<div class="fitem">
						<label><strong> Condena Actual :</strong></label>Dias
						<input style="width: 30px;" name="DIASACTUAL" class="easyui-numberbox" >
						Meses
						<input style="width: 30px;" name="MESESACTUAL" class="easyui-numberbox" >
						A&ntilde;os
						<input style="width: 30px;" name="ANIOSACTUAL" class="easyui-numberbox" >
					
					</div>
					
					
					<div class="fitem">
						<label><strong>Total Dias Condena Actual :</strong></label>
						<input style="width: 50px;" name="TOTALDIAS" class="easyui-numberbox" >
					</div>
					<div class="fitem">
						<label>Observaciones Compromiso de la Condena</label>
						<textarea name="OBS_COMPROMISO"  style="height: 30px;width:560px;" wrap="virtual"></textarea>
					</div>
					<div class="fitem">
						<label>Observaciones de la Condena Condicional</label>
						<textarea name="OBS_CONDICIONAL"  style="height: 40px;width:560px;" wrap="virtual"></textarea>
					
					</div>
					<div class="fitem">
						<label>Fecha de Compromiso</label>
						<input style="width: 100px;" name="FECHACOMPROMISO" class="easyui-datebox textbox" readonly >
					</div>
					<div class="fitem">
						<label>Fecha de Terminaci&oacute;n del Compromiso</label>
						<input style="width: 100px;" name="FECHA_TERM_COMPROMISO" class="easyui-datebox textbox" readonly >
					</div>
					<div class="fitem">
						<label>Fecha de Finalizaci&oacute;n Condena</label>
						<input style="width: 100px;" name="FECHAFINALIZACION" class="easyui-datebox textbox" readonly >
					</div>
					<div class="fitem">
						<label>Fecha de Cumplimiento del Compromiso</label>
						<input style="width: 100px;" name="FECHACUMPLIMIENTO" class="easyui-datebox textbox" readonly>
					</div>
					<div class="fitem">
						<label>Fecha de Revocatoria del Compromiso</label>
						<input style="width: 100px;" name="FECHAREVOCATORIA" class="easyui-datebox textbox" readonly >
					</div>
				</form>
			</div>
			<div title="Delitos" style="padding:0px">
				<table id="dgdelitos" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:828px;height:310px"
	    
				    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true"
						toolbar="#toolbardelitos" pagination="false"
						rownumbers="true" fitColumns="true" singleSelect="true">
					<thead>
						<tr>
			    				<th field="DELITO" width="50" sortable="true">Delito</th>
							<th field="MODADELITO" width="50" sortable="true">Modalidad Delito</th> </tr>
					</thead>
				</table>
			</div>
			<div title="Actuaciones" style="padding:0px">
				<table id="dgactuaciones" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:825px;height:310px"
	    
				    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true"
						toolbar="#toolbaractuaciones" pagination="false"
						rownumbers="true" fitColumns="true" singleSelect="true">
					<thead>
						<tr>
			    			<th field="FECHADESANOTACION" width="10%" sortable="true">Fecha</th>
			    			<th field="NOMBRE" width="20%" sortable="true">Nombre</th>
							<th field="NOTAACTUACION" width="50%" sortable="true">Anotaci&oacute;n</th>
							<th field="FOLIOS" width="10%" sortable="true">Folio</th>
							<th field="CUADERNO" width="10%" sortable="true">Cuaderno</th>
						</tr>
					</thead>
				</table>
			</div>
			<div title="Alias" style="padding:10px">
				<table id="dgalias" title="<?php echo $opcDesc; ?>" class="easyui-datagrid" style="width:825px;height:310px"
	    
				    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true"
						toolbar="#toolbaralias" pagination="false"
						rownumbers="true" fitColumns="true" singleSelect="true">
					<thead>
						<tr>
			    			<th field="NUMDOCUMENTO" width="50" sortable="true">Numero de Documento</th>
							<th field="DESCALIAS" width="50" sortable="true">Alias</th> </tr>
					</thead>
				</table>
			</div>
		</div>
	<!--</div>
	<div id="dlg-buttonsValida" >
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="setProcData()">Buscar</a>
	</div>-->
	
</body>
</html>
