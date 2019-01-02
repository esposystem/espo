<?php

$rowColor = array("1"=>"#F7F7F7","2"=>"#2E64FE","3"=>"#A9F5F2","4"=>"#FACC2E","5"=>"#81F7BE","6"=>"")

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
					cc.push('<div style="float:left;margin-left:0px;">');
				
					rowStrCard = '<div class="tabla" style="background-color: '+ rowData["COLOR"] +'">';
					rowStrCard += '<p><div class="columna">Tipo de Petici&oacute;n  :</div><div class="columnValor">' + rowData["TIPOPETICION"] + '</div><div class="columna">Condenado :</div><div class="columnValor">' + rowData["APELLIDOCONDENADO"] + ' ' + rowData["APELLIDO2CONDENADO"] + ' ' +  rowData["NOMBRECONDENADO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Centro de Servicios  :</div><div class="columnValor">' + rowData["CENTROSERVICIOS"] + '</div><div class="columna">Identificaci&oacute;n :</div><div class="columnValor">' + rowData["NUMDOCUMENTO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Ciudad  :</div><div class="columnValor">' + rowData["CIUDAD"] + '</div><div class="columna">No Proceso :</div><div class="columnValor">' + rowData["NUMRADICADOPROC"] + '</div></p>';
					
					rowStrCard += '<p><div class="columna">Estado Petici&oacute;n  :</div><div class="columnValor">' + rowData["ESTADOPETICION"] + '</div><div class="columna">No Radicado :</div><div class="columnValor">' + rowData["RADICADO"] + '</div></p>';
					
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
			
			$('#winpop').window({
				onBeforeClose: function(title){
				      $('#dg').datagrid('reload');
				}
			});
						      
			 $('#dg').datagrid('enableFilter' ,[ {
				field:'TIPOPETICION',
				type:'combobox',
				options:{
					panelHeight:'160',
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
					panelHeight:'160',
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
					panelHeight:'160',
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
			
			if (row)
				//addTab('Detalle Petici&oacute;n', '/app/pt_peticion/detail/'+row.IDPETICION);
				
				openPopWin( '/app/pt_peticion/detail/'+row.IDPETICION,'Detalle de Petici&oacute;n',920,550,false,true);
			
		}
		
	</script>
	<style type="text/css">
		.c-label{
			display:inline-block;
			width:350px;
			font-weight:bold;
		}
		
		.tabla {
 width: 796px;
 border-top:1px solid #ddd;
 border-left:1px solid #ddd;
 
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
 padding: 1px;
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
 float:left;width:248px;
 border-right: 1px solid #ccc;
// border-bottom: 1px solid #ccc;
 }
	</style>
	
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

</head>

<body>
    
	<div id="tt_pt" class="easyui-tabs" style="width:850px;height:500px;">
		<!-- INCIO TAB1-->
		<div title="Listado Peticiones" style="padding:0px">
			<table id="dg" class="easyui-datagrid" style="width:848px;height:468px"
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
			    
			    <div id="toolbar">
				    <a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Ver Informaci&oacute;n</a>
			    </div>
		</div>
		<!-- FIN TAB1-->
		</div>	
	</div>
	<div id="winpop" class="easyui-window" closed="true"><div id="panelpop"></div></div>  
</body>
</html>
