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

		<!--<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>-->
		
		<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>ckeditor/ckeditor.js"></script>
		<script src="<?php echo $config->get('jsFolder')?>/ckeditor/adapters/jquery.js"></script>
		<style>

		/* Style the CKEditor element to look like a textfield */
		.cke_textarea_inline
		{
			padding: 10px;
			height: 80px;
			overflow: auto;

			border: 1px solid gray;
			-webkit-appearance: textfield;
		}
		
		
		.tblDatos table {     font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
    font-size: 11px !important;  border-spacing: 0px;}

.tblDatos th {     font-size: 11px;     font-weight: normal;     background: #b9c9fe;
    border-top: 0px solid #aabcfe;    border-bottom: 0px solid #fff; color: #039; }

.tblDatos td {   background: #e8edff;     border-bottom: 0px solid #fff;
    color: #669;    border-top: 0px solid #aabcfe; }

.tblDatos tr:hover td { background: #d0dafd; color: #339; }


	</style>
		
		<!--<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>/nicEdit.js"></script>
-->
		
	<script type="text/javascript">
		var url,IDFormato;
                
		$( document ).ready( function() {
			
			//$( '#HEADER' ).ckeditor();
			
			CKEDITOR.replace( 'HEADER',{filebrowserBrowseUrl:'',
                            filebrowserUploadUrl: '/app/pr_dm_formato/upload/'
			});
			
			CKEDITOR.replace( 'BODY',{filebrowserBrowseUrl:'',
                            filebrowserUploadUrl: '/app/pr_dm_formato/upload/'
			});
			
			CKEDITOR.replace( 'FOOTER',{filebrowserBrowseUrl:'',
                            filebrowserUploadUrl: '/app/pr_dm_formato/upload/'
			});
			
		});
		
		function insert_variable(fieldName){
			CKEDITOR.instances['BODY'].insertText(fieldName);       
		}

                $(function(){
		
			
                    $('#dg').datagrid('enableFilter' ,[ {
				field:'TIPO',
				type:'combobox',
				options:{
						panelHeight:'60',
						loader : cloader,
						url:'/app/pr_dm_tipoformato/list',
						valueField: 'IDTIPO',  
						textField: 'NOMBRE',
						listAll : true,
						onChange:function(value){
							if (value == ''){
								 $('#dg').datagrid('removeFilterRule', 'TIPO');
							} else {
								 $('#dg').datagrid('addFilterRule', {
									field: 'TIPO',
									op: 'join',
									value: value,
									param: 'IDTIPO'
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
						    data:[{value:'',text:'Todos'},{value:'Activo',  text:'Activo' },{value:'Inactivo',  text:'Inactivo' }],
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
			$('#dlg').panel('open').panel('setTitle','Crear Formato');
			$('#pp').panel('close');
			
			$('#fm').form('clear');
			$('input[name="PDF_PAGE_ORIENTATION"]').filter('[value=Portrait]').prop('checked', true);
			$('input[name="PDF_UNIT"]').filter('[value=mm]').prop('selected', true);
			$('input[name="PDF_PAGE_FORMAT"]').filter('[value=A4]').prop('checked', true);
			$('input[name="ESTADO"]').filter('[value=Activo]').prop('checked', true);
			url = '/app/pr_dm_formato/create';
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			
			if (row){
			//	console.log(row);
				$('#pp').panel('close');
				$('#dlg').panel('open').panel('setTitle','Editar Formulario');
				$('#fm').form('load',row);
			
				IDFormato = row.IDFORMATO;
			
			//	nicEditors.findEditor( "HEADER" ).setContent(row.HEADER );
			//	nicEditors.findEditor( "BODY" ).setContent(row.BODY );
			//	nicEditors.findEditor( "FOOTER" ).setContent(row.FOOTER );
				
				//$("textarea#HEADER").val(row.HEADER);
				  
				//$("textarea#BODY").html(row.BODY);
				//$("textarea#FOOTER").val(row.FOOTER);
				
				CKEDITOR.instances['HEADER'].setData(row.HEADER);
				CKEDITOR.instances['BODY'].setData(row.BODY);
				CKEDITOR.instances['FOOTER'].setData(row.FOOTER);
				
				url = '/app/pr_dm_formato/update/'+row.IDFORMATO;
			}
		}
		
		function saveRecord(){
			
			//nicEditors.findEditor('HEADER').saveContent();
			//nicEditors.findEditor('BODY').saveContent();
			//nicEditors.findEditor('FOOTER').saveContent();
			
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
                                                
						$('#dlg').panel('close');	// close the dialog
						$('#pp').panel('open');
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
		
		function openVistaPrev(){
			
			alert("vista previ");
			$('#vistaPrevPanel').panel('open');
			//$('#vistaPrevPanel').panel('open').panel('setTitle','Vista Previa');
			
		}
		
		

	</script>
</head>

<body>
	
<?php
/*
<script type="text/javascript">
//<![CDATA[
    <!--
    bkLib.onDomLoaded(function() { nicEditors.allTextAreas({fullPanel : true}) });
    -->
  //]]>
  </script>
*/
?>
	<h2><?php echo $modDesc ?></h2>
	
	
<div id="pp" class="easyui-panel" title="<?php echo $opcDesc; ?>" style="width:860px;">	
	<table id="dg" class="easyui-datagrid" style="width:860px;height:394px"
	    
	    data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/pr_dm_formato/list'"
			toolbar="#toolbar" pagination="true"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
    				<th field="CODIGO" width="30" sortable="true">C&oacute;digo </th>
				<th field="NOMBRE" width="80" sortable="true">Formato</th>
				<th field="TIPO" width="80" sortable="true">Tipo de Formato</th>
				<th field="ESTADO" width="50" sortable="true">Estado</th> </tr>
		</thead>
	</table>
</div>
	<div id="toolbar">
		<a href="#" id="btn_new" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRecord()">Crear</a>
		<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRecord()">Editar</a>
	</div>
	
	<div id="dlg" class="easyui-panel"  style="width:880px;height:auto" closed="true" title="a">
		
       <form id="fm" method="post" novalidate>
			
		<table width="800px" class="tblDatos">
			<tr><td>
			C&oacute;digo :
				<input name="CODIGO" class="easyui-validatebox"  validType="text" required="true">
			
			</td><td>
				<label style="width:140px;">Nombre Formato :</label>
				<input name="NOMBRE" class="easyui-validatebox" validType="text" size="50" required="true">
			
			</td></tr>
			<tr><td><div class="fitem">
				<label style="width:140px;">Tipo de Formato :</label>
				<input id="ccb" class="easyui-combobox" name="IDTIPO" value="" required="true"
					data-options="valueField: 'IDTIPO',  
					textField: 'NOMBRE', 
					width:200,
					loader : cloader,
					panelHeight:'150',
					url: '/app/pr_dm_tipoformato/list'" />
				</div>
			</td><td>
				<div class="fitem">
				<label style="width:155px;">Vertical P/Horizontal L :</label>
				<input type="radio" id="PDF_PAGE_ORIENTATION" class="easyui-validatebox" name="PDF_PAGE_ORIENTATION" value="P" checked="checked">Portrait<input type="radio" id="PDF_PAGE_ORIENTATION" class="easyui-validatebox" name="PDF_PAGE_ORIENTATION" value="L" >Landscape
				</div>
			</td></tr>
			
			<tr><td>
				<div class="fitem">
				<label style="width:140px;">Margen Superior :</label>
				
				<input class="easyui-numberspinner"  name="MARGIN_TOP" value="1" style="width:150px;"
        data-options="increment:0.2,required:true,min:1,max:10,precision:1,groupSeparator:',',decimalSeparator:'.',prefix:' cm '">
					
			<!--	<input class="easyui-combobox" name="PDF_UNIT" data-options="
					valueField: 'value',
					textField: 'label',
					 width:'200',
					 panelHeight: 'auto',
					data: [{
						label: 'Mil&iacute;metros',
						value: 'mm'
					},{
						label: 'Puntos',
						value: 'pt'
					},{
						label: 'Cent&iacute;metros',
						value: 'cm'
						
					},{
						label: 'Pulgadas',
						value: 'in'
						
					}]" />
			-->
				</div>
				
			</td><td>
			
				<div class="fitem">
				<label>Formato P&aacute;gina :</label>
				
	
				<input class="easyui-combobox" name="PDF_PAGE_FORMAT" data-options="
					valueField: 'value',
					textField: 'label',
					 width:'240',
					 panelHeight: 'auto',
					data: [{
						label: 'A3 (297x420 mm ; 11.69x16.54 in)',
						value: 'A3'
					},{
						label: 'A4 (210x297 mm ; 8.27x11.69 in)',
						value: 'A4'
					},{
						label: 'A6 (105x148 mm ; 4.13x5.83 in)',
						value: 'A6'
					}]" />
			
				
			</div>
			</td></tr>
			
			<tr><td>
				<div class="fitem">
				<label>Autor :</label>
				<input name="AUTOR" class="easyui-validatebox" validType="text" size="40" required="true">
				</div>
			</td><td>
				<div class="fitem" >
				<label style="width:140px;">T&iacute;tulo :</label>
				<input name="TITULO" class="easyui-validatebox" validType="text" size="40" required="true">
				</div>
				
			</td></tr>
			
			<tr><td>
				<div class="fitem">
				<label style="width:140px;">Asunto :</label>
				<input name="ASUNTO" class="easyui-validatebox" validType="text" size="40" required="true">
				</div>
			</td><td>
				<div class="fitem">
				<label style="width:140px;">Palabras Clave :</label>
				<input name="KEYWORDS" class="easyui-validatebox" size="40" validType="text">
				</div>
				
			</td></tr>
			<tr><td colspan="2">
				<div class="fitem"><label>Descripci&oacute;n :</label>
				<input name="DESCRIPCION" class="easyui-validatebox" validType="text" size="120" required="true">
			</td></tr>
		</table>
			
			
			<div class="fitem">
				<label>Encabezado</label>
				 <input type="button" onclick="javascript:openPopWin( '/app/pr_dm_formato/vistaPrevia/' + IDFormato,'Vista Previa',920,550,false,true);" class="button" value="Vista Previa"> 
				
				   <a href="#" onclick="javascript:openPopWin( '/app/pr_dm_formato/vistaPrevia/' + IDFormato,'Vista Previa',920,550,false,true);" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:120px">Vista Previa</a>
     
				<textarea id="HEADER" name="HEADER" style="height: 120px;width:750px;" wrap="virtual"></textarea>
			</div>
			
			<div class="fitem">
				<label>Cuerpo
				<!-- <input type="button" onclick="insert_variable('EL CAMPO');" class="button" value="Insert"> -->
				</label>
				<textarea id="BODY" name="BODY" style="height: 120px;width:750px;" wrap="virtual"></textarea>
			</div>
			<div class="fitem">
				<label>Pie</label>
				<textarea id="FOOTER" name="FOOTER" wrap="virtual" class="cke_textarea_inline"></textarea>
			</div>
			<div class="fitem">
				<label>Estado</label>
				<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Activo" checked="checked">Activo<input type="radio" id="ESTADO" class="easyui-validatebox" name="ESTADO" value="Inactivo" >Inactivo
			</div>
		</form>
		<div align=right style="padding: 10px"><a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').panel('close');$('#pp').panel('open');$('#dg').datagrid('reload');">Cancelar</a>
		</div>
	</div>
	
	<div id="winpop"><div id="panelpop"></div></div>  
    
	<script>
		//CKEDITOR.inline( 'HEADER' );
		//CKEDITOR.inline( 'BODY' );
	</script>
</body>
</html>
