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
		var param;
                  
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
 <?php /*
		       *
		       *
		  | IDREPARTO             | int(11)                                                                           | NO   | PRI | NULL                | auto_increment |
| IDPETICION            | int(11)                                                                           | NO   |     | NULL                |                |
| NUMDOCUMENTO       | varchar(30)                                                                       | NO   |     |                     |                |
| NUMRADICADOPROC | varchar(30)                                                                       | NO   |     |                     |                |
| IDESTABLECIMIENTO     | int(11)                                                                           | NO   |     | NULL                |                |
| IDDESPACHO            | int(11)                                                                           | NO   |     | NULL                |                |
| IDJUEZ                | int(11)                                                                           | NO   |     | NULL                |                |
| IDSALA                | int(11)                                                                           | NO   |     | NULL                |                |
| IDSALACSJ             | int(11)                                                                           | NO   |     | NULL                |                |
| FECHAESTUDIO          | datetime                                                                          | YES  |     | 0000-00-00 00:00:00 |                |
| HORAESTUDIO           | datetime                                                                          | YES  |     | 0000-00-00 00:00:00 |                |
| FECHAAUDIENCIA        | datetime                                                                          | YES  |     | 0000-00-00 00:00:00 |                |
| HORAAUDIENCIA         | datetime                                                                          | YES  |     | 0000-00-00 00:00:00 |                |
| ESTADO                | set('Reparto','Estudio Previo','Audiencia','Finalizado','Cancelada','Reagendada') | NO   |     | NULL                |                |
| OBSERVACIONES         | text                                                                              | YES  |     | NULL                |                |

		       *
		       *
		       **/
		?>
		
				cc.push('<td colspan=' + fields.length + ' style="padding:3px;border:0;">');
				if (!frozen){
					console.log(rowData);
					cc.push('<div style="float:left;margin-left:0px;">');
			
					rowStrCard = '<div class="tabla">';
					rowStrCard += '<p><div class="columna">No Proceso  :</div><div class="columnValor">' + rowData["NUMRADICADOPROC"] + '</div><div class="columna">Condenado :</div><div class="columnValor2">' + rowData["NUMDOCUMENTO"] + ' ' +rowData["CONDENADO"] +  '</div></p>';
					rowStrCard += '<p><div class="columna">Establecimiento  :</div><div class="columnValor">' + rowData["ESTABLECIMIENTO"] + '</div><div class="columna">Despacho :</div><div class="columnValor2">' + rowData["DESPACHO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Juez  :</div><div class="columnValor"> ' + rowData["JUEZ"] +'</div><div class="columna">Sala Virtual :</div><div class="columnValor2">' + rowData["SALA"] + '<strong> Audicencia : </strong>'+ rowData["FECHAAUDIENCIA"] + ' ' + rowData['HORAESTUDIO'] +'</div></p>';
					
					rowStrCard += '<p><div class="columna">Sala CSJ  :</div><div class="columnValor">' + rowData["SALACSJ"] + '</div><div class="columna">Estudio :</div><div class="columnValor2">' + rowData["FECHAESTUDIO"] + ' ' + rowData["HORAESTUDIO"] + '</div></p>';
					
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
				field:'IDPETICION',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pt_peticion/list',
					valueField: 'IDPETICION',  
					textField: 'IDPETICION',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDPETICION');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDPETICION',
								op: 'join',
								value: value,
								param: 'IDPETICION'
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
				field:'IDDESPACHO',
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
							 $('#dg').datagrid('removeFilterRule', 'IDDESPACHO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDDESPACHO',
								op: 'join',
								value: value,
								param: 'IDDESPACHO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDJUEZ',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/jz_juez/list',
					valueField: 'IDJUEZ',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDJUEZ');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDJUEZ',
								op: 'join',
								value: value,
								param: 'IDJUEZ'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDSALA',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/er_sala/list',
					valueField: 'IDSALA',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDSALA');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDSALA',
								op: 'join',
								value: value,
								param: 'IDSALA'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDSALACSJ',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/dj_sala/list',
					valueField: 'IDSALA',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDSALACSJ');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDSALACSJ',
								op: 'join',
								value: value,
								param: 'IDSALA'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'ESTADO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Reparto',  text:'Reparto' },{value:'Estudio Previo',  text:'Estudio Previo' },{value:'Audiencia',  text:'Audiencia' },{value:'Finalizado',  text:'Finalizado' },{value:'Cancelada',  text:'Cancelada' },{value:'Reagendada',  text:'Reagendada' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'ESTADO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'ESTADO',
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
			$('input[name="ESTADO"]').filter('[value=]').prop('checked', true);
			url = '/app/pt_reparto/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/pt_reparto/update/'+row.IDREPARTO;
			}
		}

		function Reparto(){
			url = '/app/pt_reparto/reparto/';
			
			loadAjaxData(url,param,function(data) {
			
				$.each(data, function(index, value) {
 
					///se procesa la respuesta
					//console.log( index + " - " + value );	
				})
				
				     
			}); // end loadajaxdata 
			$('#dg').datagrid('reload');

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
 float:left;width:105px;
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
  .tabla .columnValor2 {
 padding: 5px;
 float:left;width:300px;
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
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/pt_reparto/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="NUMDOCUMENTO" width="50" sortable="true">No Documento</th>
				<th field="NUMRADICADOPROC" width="50" sortable="true">No Proceso</th>
				<th field="IDESTABLECIMIENTO" width="50" sortable="true">Establecimiento </th>
				<th field="IDDESPACHO" width="50" sortable="true">Despacho Radica</th>
				<th field="IDJUEZ" width="50" sortable="true">Juez</th>
				<th field="IDSALA" width="50" sortable="true">Sala C. Reclusi&oacute;n</th>
				<th field="IDSALACSJ" width="50" sortable="true">Sala C. de Servicios </th>
				<th field="ESTADO" width="50" sortable="true">Estado</th>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" id="btn_reparto "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="Reparto()">Realizar Reparto</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:560px;height:524px; padding: 0 10px 0 10px;"
			closed="true" buttons="#dlg-buttons" modal="true">
		<div class="ftitle">Datos de <?php echo $opcDesc; ?></div>
		<form id="fm" method="post" novalidate>
                        
			<div class="fitem">
				<label>Petici&oacute;n</label>
				<input id="ccb" class="easyui-combobox" name="IDPETICION" value="" required="true"
			    data-options="valueField: 'IDPETICION',  
                            textField: 'IDPETICION', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pt_peticion/list'" />
			</div>
			<div class="fitem">
				<label>Numero de Documento</label>
				<input name="NUMDOCUMENTO" class="easyui-validatebox" validType="text"  required="true">
			</div>
			<div class="fitem">
				<label>Numero de Proceso</label>
				<input name="NUMRADICADOPROC" class="easyui-validatebox" validType="text"  required="true">
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
				<label>Despacho Radica</label>
				<input id="ccb" class="easyui-combobox" name="IDDESPACHO" value="" required="true"
			    data-options="valueField: 'IDDESPACHO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_despacho/list'" />
			</div>
			<div class="fitem">
				<label>Juez</label>
				<input id="ccb" class="easyui-combobox" name="IDJUEZ" value="" required="true"
			    data-options="valueField: 'IDJUEZ',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/jz_juez/list'" />
			</div>
			<div class="fitem">
				<label>Sala Centro Reclusi&oacute;n</label>
				<input id="ccb" class="easyui-combobox" name="IDSALA" value="" required="true"
			    data-options="valueField: 'IDSALA',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/er_sala/list'" />
			</div>
			<div class="fitem">
				<label>Sala Centro Centro de Servicios Judiciales</label>
				<input id="ccb" class="easyui-combobox" name="IDSALACSJ" value="" required="true"
			    data-options="valueField: 'IDSALA',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_sala/list'" />
			</div>
			<div class="fitem">
				<label>FECHAESTUDIO</label>
				<input name="FECHAESTUDIO" class="easyui-datetimebox" readonly >
			</div>
			<div class="fitem">
				<label>HORAESTUDIO</label>
				<input name="HORAESTUDIO" class="easyui-datetimebox" readonly >
			</div>
			<div class="fitem">
				<label>FECHAAUDIENCIA</label>
				<input name="FECHAAUDIENCIA" class="easyui-datetimebox" readonly >
			</div>
			<div class="fitem">
				<label>HORAAUDIENCIA</label>
				<input name="HORAAUDIENCIA" class="easyui-datetimebox" readonly >
			</div>
			<div class="fitem">
				<label>Estado</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Reparto" >Reparto<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Estudio Previo" >Estudio Previo<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Audiencia" >Audiencia<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Finalizado" >Finalizado<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Cancelada" >Cancelada<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Reagendada" >Reagendada
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
