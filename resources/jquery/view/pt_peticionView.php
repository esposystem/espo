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
		
		
		<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>formToWizard.js"></script>
		
		   <style type="text/css">
    //    body { font-family:Lucida Sans, Arial, Helvetica, Sans-Serif; font-size:13px; margin:20px;}
    //    #main { width:960px; margin: 0px auto; border:solid 1px #b2b3b5; -moz-border-radius:10px; padding:20px; background-color:#f6f6f6;}
        #header { text-align:center; border-bottom:solid 1px #b2b3b5; margin: 0 0 20px 0; }
        fieldset { border:none; }
    //    legend { font-size:18px; margin:0px; padding:10px 0px; color:#b0232a; font-weight:bold;}
    //    label { display:block; margin:15px 0 5px;}
    //    input[type=text], input[type=password] { width:300px; padding:5px; border:solid 1px #000;}
        .prev, .next { background-color:#b0232a; padding:5px 10px; color:#fff; text-decoration:none;}
        .prev:hover, .next:hover { background-color:#000; text-decoration:none;}
        .prev { float:left;}
        .next { float:right;}
        #steps { list-style:none; width:100%; overflow:hidden; margin:0px; padding:0px;}
        #steps li {font-size:24px; float:left; padding:10px; color:#b0b1b3;}
        #steps li span {font-size:11px; display:block;}
        #steps li.current { color:#000;}
        #makeWizard { background-color:#b0232a; color:#fff; padding:5px 10px; text-decoration:none; font-size:18px;}
        #makeWizard:hover { background-color:#000;}
    </style>
		   

	<script type="text/javascript">
		var url;
                
                $(function(){
                 //   $('#dg').datagrid({ remoteFilter:true,url:'/app/pt_peticion/list' });       
                    $('#dg').datagrid('enableFilter' ,[ {
				field:'IDTIPOPETICION',
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
							 $('#dg').datagrid('removeFilterRule', 'IDTIPOPETICION');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDTIPOPETICION',
								op: 'join',
								value: value,
								param: 'IDTIPOPETICION'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDCENTROSERVICIOS',
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
							 $('#dg').datagrid('removeFilterRule', 'IDCENTROSERVICIOS');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDCENTROSERVICIOS',
								op: 'join',
								value: value,
								param: 'IDCENTROSERVICIOS'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDESTADOPETICION',
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
							 $('#dg').datagrid('removeFilterRule', 'IDESTADOPETICION');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDESTADOPETICION',
								op: 'join',
								value: value,
								param: 'IDESTADO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
					    field:'TIPOIDENTIFICACION',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Cedula Ciudadania',  text:'Cedula Ciudadania' },{value:'Cedula Extranjeria',  text:'Cedula Extranjeria' },{value:'Pasaporte',  text:'Pasaporte' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'TIPOIDENTIFICACION');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'TIPOIDENTIFICACION',
									    op: 'equal',
									    value: value
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
					url:'/app/er_establecimientos/list',
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
				field:'IDJUZGADOFALLADOR',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/pr_dm_juzgadofallador/list',
					valueField: 'IDJUZGADOFALLADOR',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDJUZGADOFALLADOR');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDJUZGADOFALLADOR',
								op: 'join',
								value: value,
								param: 'IDJUZGADOFALLADOR'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDDEPARTAMENTO',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/dj_dm_departamento/list',
					valueField: 'IDDEPARTAMENTO',  
					textField: 'NOMBRE',
					listAll : true,
					onChange:function(value){
						if (value == ''){
							 $('#dg').datagrid('removeFilterRule', 'IDDEPARTAMENTO');
						} else {
							 $('#dg').datagrid('addFilterRule', {
								field: 'IDDEPARTAMENTO',
								op: 'join',
								value: value,
								param: 'IDDEPARTAMENTO'
							});
						}
						$('#dg').datagrid('doFilter');
					}
				}
			},{
				field:'IDCIUDAD',
				type:'combobox',
				options:{
					panelHeight:'60',
					loader : cloader,
					url:'/app/dj_dm_ciudad/list',
					valueField: 'IDCIUDAD',  
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
					    field:'TIPOIDSOLICITANTE',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Cedula Ciudadania',  text:'Cedula Ciudadania' },{value:'Cedula Extranjeria',  text:'Cedula Extranjeria' },{value:'Pasaporte',  text:'Pasaporte' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'TIPOIDSOLICITANTE');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'TIPOIDSOLICITANTE',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'TIPORELACION',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Condenado',  text:'Condenado' },{value:'Familiar',  text:'Familiar' },{value:'Abogado',  text:'Abogado' },{value:'Defensor Publico',  text:'Defensor Publico' },{value:'Otro',  text:'Otro' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'TIPORELACION');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'TIPORELACION',
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
						    data:[{value:'',text:'Todos'},{value:'Privada',  text:'Privada' },{value:'Publica',  text:'Publica' },{value:'Centro Servicios',  text:'Centro Servicios' },{value:'Establecimiento de Reclusion',  text:'Establecimiento de Reclusion' }],
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
				    },{
					    field:'VA_NUMERODOCUMENTO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'VA_NUMERODOCUMENTO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'VA_NUMERODOCUMENTO',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'VA_ESTABLECIMIENTORECLUSION',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'VA_ESTABLECIMIENTORECLUSION');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'VA_ESTABLECIMIENTORECLUSION',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'VA_LEGIBLE',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'VA_LEGIBLE');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'VA_LEGIBLE',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'VA_DOCUMENTACIONLEGIBLE',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'S',  text:'S' },{value:'N',  text:'N' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'VA_DOCUMENTACIONLEGIBLE');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'VA_DOCUMENTACIONLEGIBLE',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'TIPORESOLUCION',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'De Tramite',  text:'De Tramite' },{value:'Interlocutora',  text:'Interlocutora' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'TIPORESOLUCION');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'TIPORESOLUCION',
									    op: 'equal',
									    value: value
								    });
							    }
							    $('#dg').datagrid('doFilter');
						    }
					    }
				    },{
					    field:'VJ_ESTADO',
					    type:'combobox',
					    options:{
						    panelHeight:'auto',
						    data:[{value:'',text:'Todos'},{value:'Sin Validar',  text:'Sin Validar' },{value:'Aprobada',  text:'Aprobada' },{value:'Rechazada',  text:'Rechazada' }],
						    onChange:function(value){
							    if (value == ''){
								     $('#dg').datagrid('removeFilterRule', 'VJ_ESTADO');
							    } else {
								     $('#dg').datagrid('addFilterRule', {
									    field: 'VJ_ESTADO',
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
			$('input[name="TIPOIDENTIFICACION"]').filter('[value=]').prop('checked', true);
			$('input[name="TIPOIDSOLICITANTE"]').filter('[value=]').prop('checked', true);
			$('input[name="TIPORELACION"]').filter('[value=]').prop('checked', true);
			$('input[name="FUENTE"]').filter('[value=]').prop('checked', true);
			$('input[name="VA_NUMERODOCUMENTO"]').filter('[value=N]').prop('checked', true);
			$('input[name="VA_ESTABLECIMIENTORECLUSION"]').filter('[value=N]').prop('checked', true);
			$('input[name="VA_LEGIBLE"]').filter('[value=N]').prop('checked', true);
			$('input[name="VA_DOCUMENTACIONLEGIBLE"]').filter('[value=N]').prop('checked', true);
			$('input[name="TIPORESOLUCION"]').filter('[value=]').prop('checked', true);
			$('input[name="VJ_ESTADO"]').filter('[value=Sin Validar]').prop('checked', true);
			url = '/app/pt_peticion/create';
			
		}
		
		function editRecord(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Editar');
				$('#fm').form('load',row);
				url = '/app/pt_peticion/update/'+row.IDPETICION;
			}
		}
		function saveRecord(){
			
			url = '/app/pt_peticion/create';
			
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
                                        
					if (result.success){
						
						$('<div><a href="'+result.url+'" target="_blank">Archivo</a></div>').appendTo("#FileDiv");

                                                
                                                $.messager.show({
							title: 'Confirmaci&oacute;n',
							msg: result.msg
						});
                                              
						$('#dlg').dialog('close');	// close the dialog
						//$('#dg').datagrid('reload');	// reload the user data
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
			
			url = 'http://ada3.sistemafenix.co/prueba_sqlsrv.php?action=proceso&numero_proceso=' + $("#NUMEROPROCESOVAL").val() + '&identificacion_condenado=' + $("#NUMEROIDENTIFICACIONVAL").val(),
			
			// http://ada3.sistemafenix.co/odbc/test.php?action=proceso&numero_proceso=11001600009820060001100&identificacion_condenado=79853815
			$.messager.progress({ title: 'Validando Proceso',
						msg: 'Espere por favor',
						text:'Enviando Datos',
						interval : '80'
					});
			
			 $('#fmVal').form('submit',{
			//	url: 'http://ada3.sistemafenix.co/odbc/test.php?action=proceso&numero_proceso=' + $("#NUMEROPROCESOVAL").val() + '&identificacion_condenado=' + $("#NUMEROIDENTIFICACIONVAL").val(),
			//	url: 'http://ada3.sistemafenix.co/prueba_sqlsrv.php?action=proceso&numero_proceso=' + $("#NUMEROPROCESOVAL").val() + '&identificacion_condenado=' + $("#NUMEROIDENTIFICACIONVAL").val(),
				url : '/app/pt_peticion/valProcJXXI',
				onSubmit: function(){
					
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
					
					//alert(result);
					
					console.log(result);
					
					$.messager.progress('close');
					// var result = eval('(' + result + ')');  // change the JSON string to javascript object
					//if (result.success){
					//    alert(result.message)
					//}
					
					if (result.success){
                                                
                                                $.messager.show({
							title: 'Confirmaci&oacute;n',
							msg: 'Proceso encontrado'
						});
                                                
						$('#dlg').dialog('close');
						$('#pnl').panel('open');
						//	
						$("#NUMEROPROCESO").val($("#NUMEROPROCESOVAL").val());
						$("#NUMEROIDENTIFICACION").val($("#NUMEROIDENTIFICACIONVAL").val());
						$("#IDCENTROSERVICIOS").val($("#IDCENTROSERVICIOSVAL").val());
						
						
						
					} else {
						$.messager.show({
							title: 'Error',
							msg: 'Proceso No encontrado'
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
		
		var numFiles = 0;
		
		function loadTipoDoc(urlJson,rec){
			var listTipo;
			//alert(rec.id);
			
			if(numFiles != 0){
				for(i=1;i<=numFiles;i++)
					$("#FileBoxDiv" + i).remove();
				
				numFiles = 0;
			}
			
			param = 'filterRules=[{"field":"TIPOPETICION","op":"join","value":' + rec.IDTIPOPETICION + ',"param":"IDTIPOPETICION"}]';
			
			loadAjaxData(urlJson,param,function(data) {
			
			$.each(data, function(index, value) {
 
				var newFileBoxDiv = $(document.createElement('div')).attr("id", 'FileBoxDiv' + (numFiles + 1 ));
			    
				   newFileBoxDiv.after().html('<div class="fitem" style="background-color: #F7F7F7;"><label style="width: 260px;font-weight:bold;"> ' + (numFiles + 1 ) + ' - ' + value.NOMBRE  + ' : </label>' +
					 '<input type="file" name="FileInput' + value.IDTIPODOC + 
					 '" id="FileInput' + value.IDTIPODOC + '" required="true"></div>');
			    
				  newFileBoxDiv.appendTo("#FileDiv");
			    
				numFiles++;		
			})
				     
			}); // end loadajaxdata 
			
		}
		
	jQuery(document).ready(function(){
		
		MakeWizard();
		
		jQuery('input').keyup(function() {
		    this.value = this.value.toLocaleUpperCase();
		});
		jQuery('textarea').keyup(function() {
		    this.value = this.value.toLocaleUpperCase();
		});
	 });
		
	
	function MakeWizard() {
            $("#fm").formToWizard({ submitButton: 'SaveAccount' })
            $("#makeWizard").hide();
            $("#info").fadeIn(400);
        }
	
	</script>
</head>

<body>
	<h2><?php echo $modDesc ?></h2>
	
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Haga click en los botones de la barra de herramientas de la grilla para realizar las operaciones.</div>
	</div>
	 
	    
	<div id="dlg" class="easyui-dialog" title="Validaci&oacute;n del Proceso" style="width:510px;height:220px; padding: 0 10px 0 10px;"
			closed="false" buttons="#dlg-buttonsValida" modal="true">
		
		<div class="ftitle" style="padding:10px 10px 10px 10px;">Ingrese los Datos
		</div>
		<form id="fmVal" method="post" novalidate>
			<div class="fitem">
				<label style="width: 190px;">N&uacute;mero de Proceso</label>
				<input id="NUMEROPROCESOVAL" name="NUMEROPROCESOVAL" class="easyui-validatebox" maxlength="23" validType="text"  required="true" size="32">
			</div>
			
			<div class="fitem">
				<label style="width: 190px;">Identificaci&oacute;n Condenado</label>
				<input id="NUMEROIDENTIFICACIONVAL" name="NUMEROIDENTIFICACIONVAL" class="easyui-validatebox" validType="text"  size="32" required="true">
			</div>
			<div class="fitem">
				<label style="width: 190px;">Centro de Servicios Judiciales</label>
				<input id="ccb" class="easyui-combobox" name="IDCENTROSERVICIOSVAL" value="" required="true"
			    data-options="valueField: 'IDCENTROSERVICIOS',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_centroservicios/list'" />
			</div>
		</form>
		<div class="ftitle" style="padding:10px 10px 0px 10px;">
		</div>
			
	</div>	

<div id="pnl" class="easyui-panel" closed="true" title="Radicar Petici&oacute;n" style="width:700px" buttons="#dlg-buttonsValida">
       
       
       <form id="fm" method="post" novalidate enctype="multipart/form-data">
	   <fieldset>
		<div id="stepTitle0" class="ftitle" style="padding:10px 0 5px 0">Datos Generales</div>
		
                        <input type="hidden" name="IDESTADOPETICION" value="1">
				
                        <input id="IDCENTROSERVICIOS" type="hidden" name="IDCENTROSERVICIOS" value="">
				
			<div class="fitem">
				<label style="width: 195px;">Tipo de Petici&oacute;n</label>
				<input id="ccbTipo" class="easyui-combobox" name="IDTIPOPETICION" value="" required="true"
			    data-options="valueField: 'IDTIPOPETICION',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pt_dm_tipo/list',
			    onSelect: function(rec){ loadTipoDoc('/app/pt_dm_tipodoc/list',rec); }" />
			</div>
			
			<input type="hidden" name="IDESTADO" value="1">
			
			<div class="fitem">
				<label style="width: 195px;">N&uacute;mero de Radicado</label>
				<input name="RADICADO" class="easyui-validatebox" validType="text" size= required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">N&uacute;mero de Proceso</label>
				<input id="NUMEROPROCESO" name="NUMEROPROCESO" class="easyui-validatebox" maxlength="23" size="28" required="true">
					<!-- data-options="required:true,validType:['length[0,23]'] -->
					
			</div>
		</fieldset>
		<fieldset>
			<div id="stepTitle1" class="ftitle" style="padding:10px 10px 5px 5px;">Datos del Condenado
			</div>
			<!--
			<div class="fitem">
				<label style="width: 195px;">Tipo de Identificaci&oacute;n</label>
				<input type="radio" id="TIPOIDENTIFICACION" class="easyui-validatebox" name="TIPOIDENTIFICACION" value="Cedula Ciudadania" >
				Cedula Ciudadania
				<input type="radio" id="TIPOIDENTIFICACION" class="easyui-validatebox" name="TIPOIDENTIFICACION" value="Cedula Extranjeria" >
				Cedula Extranjeria
				<input type="radio" id="TIPOIDENTIFICACION" class="easyui-validatebox" name="TIPOIDENTIFICACION" value="Pasaporte" >
				Pasaporte
			</div>
			-->
			<div class="fitem">
				<label style="width: 195px;">Tipo de Identificaci&oacute;n</label>
				
				<select class="easyui-combobox" name="TIPOIDENTIFICACION">
					    <option value="Cedula">Cedula Ciudadania</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                            <option value="Cedula_Extranjeria">Cedula Extranjeria</option>
                                </select>
				
			</div>
			<div class="fitem">
				<label style="width: 195px;">N&uacute;mero de Identificacion </label>
				<input id="NUMEROIDENTIFICACION" name="NUMEROIDENTIFICACION" class="easyui-validatebox" validType="text"  size="40" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Primer Apellido </label>
				<input name="APELLIDOCONDENADO" class="easyui-validatebox" validType="text" size="40" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Segundo Apellido </label>
				<input name="APELLIDO2CONDENADO" class="easyui-validatebox" validType="text"  size="40">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Primer Nombre</label>
				<input name="NOMBRECONDENADO" class="easyui-validatebox" validType="text"  size="40" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Segundo Nombre</label>
				<input name="NOMBRE2CONDENADO" class="easyui-validatebox" validType="text"  size="40">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Establecimiento Reclusi&oacute;n</label>
				<input id="ccb" class="easyui-combobox" name="IDESTABLECIMIENTO" value="" required="true"
			    data-options="valueField: 'IDESTABLECIMIENTO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/er_establecimiento/list'" />
			</div>
			<div class="fitem">
				<label style="width: 195px;">Fecha de la Condena</label>
				<input name="FECHACONDENA" class="easyui-datebox textbox"  required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Quantum A&ntilde;os</label>
				<input name="QANTUMANIOS" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Quantum Meses</label>
				<input name="QANTUMMESES" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Quantum D&iacute;as</label>
				<input name="QANTUMDIAS" class="easyui-numberbox" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Juzgado Fallador</label>
				<input id="ccb" class="easyui-combobox" name="IDJUZGADOFALLADOR" value="" required="true"
			    data-options="valueField: 'IDJUZGADO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pr_dm_juzgado/list'" />
			</div>
			<div class="fitem">
				<label style="width: 195px;">Juzgado que Ejecuta la Pena</label>
				<input id="ccb" class="easyui-combobox" name="IDJUZGADOEJE" value="" required="true"
			    data-options="valueField: 'IDJUZGADO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pr_dm_juzgado/list'" />
			</div>
			<div class="fitem">
				<label style="width: 195px;">Departamento</label>
				<input id="ccb" class="easyui-combobox" name="IDDEPARTAMENTO" value="" required="true"
			    data-options="valueField: 'IDDEPARTAMENTO',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/dj_dm_departamento/list'" />
			</div>
			<div class="fitem">
				<label style="width: 195px;">Ciudad</label>
				<input id="ccb" class="easyui-combobox" name="IDCIUDAD" value="" required="true"
			    data-options="valueField: 'IDCIUDAD',  
                            textField: 'NOMBRE', 
                            width:280,
			    loader : cloader,
			    panelHeight:'150',
                            url: '/app/pr_dm_ciudad/list'" />
			</div>
			<div class="fitem">
				<label style="width: 195px;">Otro Tipo de Petici&oacute;n</label>
				<input name="OTRO" class="easyui-validatebox" validType="text"  size="40">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Argumentos</label>
				<textarea name="ARGUMENTOS"  required="true"style="height: 60px;width:280px;" wrap="virtual"></textarea>
			</div>
		  </fieldset>
		  <fieldset>
			<div id="stepTitle2" class="ftitle" style="padding:10px 10px 5px 0px;">Datos del Solicitante
			</div>
			<div class="fitem">
				<label style="width: 195px;">Tipo de Identificaci&oacute;n del Solicitante</label>
				<input type="radio" id="TIPOIDSOLICITANTE" class="easyui-validatebox" name="TIPOIDSOLICITANTE" value="Cedula Ciudadania" >Cedula Ciudadania<input type="radio" id="TIPOIDSOLICITANTE" class="easyui-validatebox" name="TIPOIDSOLICITANTE" value="Cedula Extranjeria" >Cedula Extranjeria<input type="radio" id="TIPOIDSOLICITANTE" class="easyui-validatebox" name="TIPOIDSOLICITANTE" value="Pasaporte" >Pasaporte
			</div>
			<div class="fitem">
				<label style="width: 195px;">N&uacute;mero de Identificaci&oacute;n</label>
				<input name="NUMIDENTIFSOL" class="easyui-numberbox" validType="text"  size="40" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Primer Apellido</label>
				<input name="APELLIDOSOL" class="easyui-validatebox" validType="text"  size="40" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Segundo Apellido</label>
				<input name="APELLIDO2SOL" class="easyui-validatebox" validType="text"  size="40">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Primer Nombre</label>
				<input name="NOMBRESOL" class="easyui-validatebox" validType="text"  size="40" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Segundo Nombre</label>
				<input name="NOMBRE2SOL" class="easyui-validatebox" validType="text"  size="40">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Tipo de Relaci&oacute;n con el Condenado</label>
				<input type="radio" id="TIPORELACION" class="easyui-validatebox" name="TIPORELACION" value="Condenado" >Condenado<input type="radio" id="TIPORELACION" class="easyui-validatebox" name="TIPORELACION" value="Familiar" >Familiar<input type="radio" id="TIPORELACION" class="easyui-validatebox" name="TIPORELACION" value="Abogado" >Abogado<input type="radio" id="TIPORELACION" class="easyui-validatebox" name="TIPORELACION" value="Defensor Publico" >Defensor Publico<input type="radio" id="TIPORELACION" class="easyui-validatebox" name="TIPORELACION" value="Otro" >Otro
			</div>
			<div class="fitem">
				<label style="width: 195px;">Otro Tipo de Relaci&oacute;n con el Condenado</label>
				<input name="OTRARELACION" class="easyui-validatebox" validType="text"  size="40">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Direcci&oacute;n</label>
				<input name="DIRECCION" class="easyui-validatebox" validType="text"  size="40" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Tel&eacute;fono</label>
				<input name="TELEFONO" class="easyui-validatebox" validType="text"  size="40" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Celular</label>
				<input name="CELULAR" class="easyui-numberbox" validType="text"  size="40" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Email</label>
				<input name="EMAIL" class="easyui-validatebox" validType="email" size="40" required="true">
			</div>
			<div class="fitem">
				<label style="width: 195px;">Fuente de la Petici&oacute;n</label>
				<input type="radio" id="FUENTE" class="easyui-validatebox" name="FUENTE" value="Privada" >Privada<input type="radio" id="FUENTE" class="easyui-validatebox" name="FUENTE" value="Publica" >Publica<input type="radio" id="FUENTE" class="easyui-validatebox" name="FUENTE" value="Centro Servicios" >Centro Servicios<input type="radio" id="FUENTE" class="easyui-validatebox" name="FUENTE" value="Establecimiento de Reclusion" >Establecimiento de Reclusion
			</div>
		
		  </fieldset>
		  <fieldset>	
			<div class="fitem">
				<label style="width: 195px;">C&oacute;digo Hash Asociado</label>
				<input name="CODIGOHASH" class="easyui-validatebox" validType="text"  >
			</div>
			<div id="stepTitle3" class="ftitle" style="padding:15px 10px 10px 0px;">Documentos que Debe Adjuntar</div>
			<div id='FileDiv'>
			
			</div>
			
			<div id="dlg-buttons" align="right" style="padding: 10px;">
				<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveRecord()">Guardar</a>
				<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancelar</a>
			</div>
		  </fieldset>		
		</form>
	</div>
	
	<div id="dlg-buttonsValida" >
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="setProcData()">Validar</a>
	</div>
</body>
</html>
