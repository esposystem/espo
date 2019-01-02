<?php
	//$config = \Lib\Config::singleton();
	//$userData = $config->get('SESSION_DATA');
	//print_r($userData);
	$router = \Lib\Router::singleton();
	//print_r($router);
	//echo $router->request_uri;
	
	if(!empty($userData["PERMISOS"]["/app/homeTab/dashboard"]))
		$dashOpc = array_keys($userData["PERMISOS"]["/app/homeTab/dashboard"]);
	
	if(empty($dashOpc))
			$dashOpc = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">	
	<title><?php echo $config->get('appName')?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php	echo Lib\APPUtil::headerView(); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>portal.css">
	<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.portal.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>jquery-dateFormat.js"></script>

	<!-- Bootstrap Core CSS -->
    <link href="<?php echo $config->get('bootstrapFolder'); ?>css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo $config->get('bootstrapFolder'); ?>css/sb-admin.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="<?php echo $config->get('bootstrapFolder'); ?>css/plugins/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo $config->get('bootstrapFolder'); ?>font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $config->get('bootstrapFolder'); ?>js/bootstrap.min.js"></script>

	<style type="text/css">
		.title{
			font-size:16px;
			font-weight:bold;
			padding:10px 10px;
			background:#eee;
			overflow:hidden;
			border-bottom:1px solid #ccc;
		}
		.t-list{
			padding:5px;
		}

		.gridProcesos{
			display: block;
		}
	</style>
	<script>


		var cardview = $.extend({}, $.fn.datagrid.defaults.view, {
			renderRow: function(target, fields, frozen, rowIndex, rowData){

				if( rowData.IDENVIO > 0 )
				{


					var opts = $.data(target, 'datagrid').options;
					
					var cc = [];
					
					if (frozen && opts.rownumbers){
						var rownumber = rowIndex + 1;
						if (opts.pagination){
							rownumber += (opts.pageNumber-1)*opts.pageSize;
						}
						cc.push('<td class="datagrid-td-rownumber"><div class="datagrid-cell-rownumber">'+rownumber+'</div></td>');
					}
			
					cc.push('<td colspan=' + fields.length + ' style="padding:3px;border:0;">');
					if (!frozen && !jQuery.isEmptyObject(rowData)){

						cc.push('<div class="content-tabla" style="float:left;margin-left:0px;">');
					
					
						rowStrCard = '<div class="tabla">';
						rowStrCard += '<p><div class="columna">Fecha Creación  :</div><div class="columnValor">' + rowData.FECHA + '</div><div class="columna">Fecha Recogida  :</div><div class="columnValor">' + rowData.FECHARECOGIDA + ' ' + rowData.JORNADA + '</div></p>'; 
						rowStrCard += '<p><div class="columna">Cliente  :</div><div class="columnValor">' + rowData.APELLIDO + " " + rowData.NOMBRE + '</div><div class="columna">Numero Documento  :</div><div class="columnValor">' + rowData.NUMERODOCUMENTO + '</div></p>'; 
						rowStrCard += '<p><div class="columna">Tipo de Envío  :</div><div class="columnValor">' + rowData["TIPOENVIO"] + '</div><div class="columna">Descripción  :</div><div class="columnValor">' + rowData["DESCRIPCION"] + '</div></p>'; 
						rowStrCard += '<p><div class="columna">Pagado  :</div><div class="columnValor">' + rowData["PAGADO"] + '</div><div class="columna">Estado  :</div><div class="columnValor">' + rowData["ESTADODETALLE"] + '</div></p>'; 
						rowStrCard += '<p><div class="columna">Valor Declarado  :</div><div class="columnValor">' + rowData["VALORDECLARADO"] + '</div><div class="columna">Total :</div><div class="columnValor">' + rowData["VALORTOTAL"] + '</div></p>';
						rowStrCard += '<p><div class="columna">Factura  :</div><div class="columnValor">' + rowData["NUMEROFACTURA"] + '</div><div class="columna">Referencia</div><div class="columnValor">' + rowData.IDENVIO + '</div></p>';
						
						rowStrCard += '</div>';
					
						
						cc.push(rowStrCard);
		
							
					//	}
						
						cc.push('</div>');
					}
					cc.push('</td>');
					return cc.join('');

				}//end if
			}//end function
		});



        $(function(){

        	$('#dgEnvios').datagrid({
				view: cardview
			});



			$('#dgEnvios').datagrid('enableFilter' ,[ 

           		{
					field:'FECHA',
					type:'datebox',
					options:{

						formatter:function(date){
							var y = date.getFullYear();
							var m = ("0" + (date.getMonth() + 1)).slice(-2);
							var d = date.getDate();
							return y+'-'+m+'-'+d;
						},


						onSelect:function(date){
							var dateString = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
							if (dateString == ''){
								 $('#dgEnvios').datagrid('removeFilterRule', 'FECHA');
							}
						},

						onChange:function(value){
							console.log( value );
							if (value == ''){
								 $('#dgEnvios').datagrid('removeFilterRule', 'FECHA');
							} else {
								 $('#dgEnvios').datagrid('addFilterRule', {
									field: 'FECHA',
									op: 'equal',
									value: value,
									param: 'FECHA'
								});
							}
							$('#dgEnvios').datagrid('doFilter');
						}


					}

					
				},


				{
					field:'ED.ESTADO',
					type:'text',
					
					op: 'contains'

					
				},

				{
					field:'C.NUMERODOCUMENTO',
					type:'text',
					
					op: 'contains'

					
				}



 


            ]);   




		});
		
		$(document).ready(function(){
			
			preparacontadores();

		});

		function viewEnvios(){

			var row = $('#dgEnvios').datagrid('getSelected');

			if (row){
				openPopWin( '/app/envio/detail/'+row.IDENVIO+"-"+row.IDDETALLEENVIO,'Detalle de Envío',$(window).width(),$(window).height(),false,false,false,false);

			}

		}




		
		function preparacontadores(){

			origenes();
			envios();
			clientes();
			servicios();

		}//end fuctnion

		function origenes(){

			var param = {};
			var condenainicial = {};
			var condenaactual = {};
			//param["filterRules"] = '[{"field":"IDJUEZ","op":"equal","value":"<?=$userData["IDJUEZ"] ?>"}]';
			//param["sort"] = "HORAAUDIENCIA";
			//param["order"] = "ASC";

			loadAjaxData('/app/origen/list',param,function(data) {

				$(".txtOrigenes").html( data.length );
				     
			}); // end loadajaxdata 
			
		}//end function

		function envios(){

			var param = {};
			var condenainicial = {};
			var condenaactual = {};
			param["filterRules"] = '[{"field":"PAGADO","op":"equal","value":"S"}]';
			//param["sort"] = "HORAAUDIENCIA";
			//param["order"] = "ASC";

			loadAjaxData('/app/envio/list',param,function(data) {

				$(".txtEnvios").html( data.length );
				     
			}); // end loadajaxdata 
			
		}//end function


		function clientes(){

			var param = {};
			var condenainicial = {};
			var condenaactual = {};
			//param["filterRules"] = '[{"field":"IDJUEZ","op":"equal","value":"<?=$userData["IDJUEZ"] ?>"}]';
			//param["sort"] = "HORAAUDIENCIA";
			//param["order"] = "ASC";

			loadAjaxData('/app/cliente/list',param,function(data) {

				$(".txtClientes").html( data.length );
				     
			}); // end loadajaxdata 
			
		}//end function

		function servicios(){

			var param = {};
			var condenainicial = {};
			var condenaactual = {};
			//param["filterRules"] = '[{"field":"IDJUEZ","op":"equal","value":"<?=$userData["IDJUEZ"] ?>"}]';
			//param["sort"] = "HORAAUDIENCIA";
			//param["order"] = "ASC";

			loadAjaxData('/app/servicio/list',param,function(data) {

				$(".txtServicios").html( data.length );
				     
			}); // end loadajaxdata 
			
		}//end function





		
	</script>

	
	
</head>
<body class="easyui-layout">
	<div region="north" class="title" border="false" style="height:35px;">
		Cuadro de Control
	</div>
	<div region="center" border="false">

		<!-- container fluid -->

		<div id="page-wrapper">
			<div class="container-fluid">

				<div class="row">
		            <div class="col-lg-3 col-md-6">
		                <div class="panel panel-primary">
		                    <div class="panel-heading">
		                        <div class="row">
		                            <div class="col-xs-3">
		                                <i class="fa fa-comments fa-5x"></i>
		                            </div>
		                            <div class="col-xs-9 text-right">
		                                <div class="huge txtOrigenes">0</div>
		                                <div>Orígenes Creados</div>
		                            </div>
		                        </div>
		                    </div>
		                    <a class="linkOrigenes"  href="javascript:parent.openTabMod('Orígenes Creados','/app/origen/view',true,'');">
		                        <div class="panel-footer">
		                            <span class="pull-left">Ver Más</span>
		                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                            <div class="clearfix"></div>
		                        </div>
		                    </a>
		                </div>
		            </div>
		            <div class="col-lg-3 col-md-6">
		                <div class="panel panel-green">
		                    <div class="panel-heading">
		                        <div class="row">
		                            <div class="col-xs-3">
		                                <i class="fa fa-video-camera fa-5x"></i>
		                            </div>
		                            <div class="col-xs-9 text-right">
		                                <div class="huge txtEnvios">0</div>
		                                <div>Envios Pagos</div>
		                            </div>
		                        </div>
		                    </div>
		                    <a class="linkEnvios" href="javascript:parent.openTabMod('Envios','/app/envio/listView',true,'');">
		                        <div class="panel-footer">
		                            <span class="pull-left">Ver Más</span>
		                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                            <div class="clearfix"></div>
		                        </div>
		                    </a>
		                </div>
		            </div>
		            <div class="col-lg-3 col-md-6">
		                <div class="panel panel-yellow">
		                    <div class="panel-heading">
		                        <div class="row">
		                            <div class="col-xs-3">
		                                <i class="fa fa-file fa-5x"></i>
		                            </div>
		                            <div class="col-xs-9 text-right">
		                                <div class="huge txtClientes">0</div>
		                                <div>Clientes en Sistema</div>
		                            </div>
		                        </div>
		                    </div>
		                    <a class="linkClientes" href="javascript:parent.openTabMod('Clientes','/app/cliente/listView',true,'');">
		                        <div class="panel-footer">
		                            <span class="pull-left">Ver Más</span>
		                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                            <div class="clearfix"></div>
		                        </div>
		                    </a>
		                </div>
		            </div>
		            <div class="col-lg-3 col-md-6">
		                <div class="panel panel-red">
		                    <div class="panel-heading">
		                        <div class="row">
		                            <div class="col-xs-3">
		                                <i class="fa fa-folder fa-5x"></i>
		                            </div>
		                            <div class="col-xs-9 text-right">
		                                <div class="huge txtServicios">0</div>
		                                <div>Servicios Publicados</div>
		                            </div>
		                        </div>
		                    </div>
		                    <a class="linkServicios" href="javascript:parent.openTabMod('Servicios','/app/servicio/view',true,'');">
		                        <div class="panel-footer">
		                            <span class="pull-left">Ver Más</span>
		                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                            <div class="clearfix"></div>
		                        </div>
		                    </a>
		                </div>
		            </div>
		        </div>



		        <!-- GRILLAS DE RESUMEN -->
		        <!-- Últimos Envíos -->
				
					<table id="dgEnvios" class="easyui-datagrid" title="Últimos Envíos en el Sistema"  style="width:100%;height:394px" fit="true"
						data-options="pageSize: <?php echo $config->get('GRID_NUMROWS')?>,remoteFilter:true,url:'/app/envio/list'"
						toolbar="#toolbarEnvios" pagination="true"
						rownumbers="true" fitColumns="true" singleSelect="true">
					

						<thead>

							<tr>

				    				<th field="IDENVIO" width="16%" sortable="true">REFERENCIA</th>
								<th field="C.NUMERODOCUMENTO" width="16%" sortable="true">DOCUMENTO CLIENTE</th>
								<th field="ED.ESTADO" width="16%" sortable="true">ESTADO</th>
								<th field="FECHA" width="16%" sortable="true">FECHA</th>
								<th field="PAGADO" width="16%" sortable="true">PAGADO</th>
								<th field="VALORTOTAL" width="16%" enableFilter="false" >TOTAL</th> </tr>

						</thead>


		
					</table>

					<div id="toolbarEnvios">


						<a href="#" id="btn_edit "class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="viewEnvios()">Ver Detalle</a>

					</div>
		        <!-- Fin Últimos Envíos -->
				<!-- FIN GRILLAS DE RESUMEN -->



		   	</div>
		</div>
	   	<!-- container fluid -->

		<div id="winpop" class="easyui-window" closed="true"><div id="panelpop"></div></div>  
</body>
</html>