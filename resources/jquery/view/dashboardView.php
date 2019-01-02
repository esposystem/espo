<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!--<<title>Fenix :: Grupo</title>
	<link rel="stylesheet" type="text/css" href="jeasyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="jeasyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="jeasyui/demo.css">
	script type="text/javascript" src="jquery/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="jeasyui/jquery.easyui.min.js"></script>-->
		
	
	<title><?php echo $config->get('appName')?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/icon.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/default/easyui.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>demo/demo.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>portal.css">
		<script type="text/javascript" src="<?php echo $config->get('jqueryFolder')?>jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.easyui.min.js"></script>
                <script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>locale/easyui-lang-es.js"></script>

		<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.portal.js"></script>
	
	

	<!--<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
-->
	
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
	</style>
	
	
	<script type="text/javascript">
		$(function(){
		//	$('#dg').datagrid({
		//		url: 'SI_CF_GRUPO/get_users.php',
		//		saveUrl: 'SI_CF_GRUPO/save_user.php',
		//		updateUrl: 'SI_CF_GRUPO/update_user.php',
		//		destroyUrl: 'SI_CF_GRUPO/destroy_user.php'
		//	});
		});
	</script>
	
	
	<script>
		$(function(){
			$('#pp').portal({
				border:false,
				fit:true
			});
			//add();
		});
		function add(){
			for(var i=0; i<2; i++){
				var p = $('<div/>').appendTo('body');
				p.panel({
					title:'Notificaci&oacute;n '+i,
					content:'<div style="padding:5px;">Alerta Documental'+(i+1)+'</div>',
					height:100,
					closable:true,
					collapsible:true
				});
				$('#pp').portal('add', {
					panel:p,
					columnIndex:i
				});
			}
			$('#pp').portal('resize');
		}
		function remove(){
			$('#pp').portal('remove',$('#pgrid'));
			$('#pp').portal('resize');
		}

		
	</script>
	
</head>
<body class="easyui-layout">
	<div region="north" class="title" border="false" style="height:40px;">
		Cuadro de Control
	</div>
	<div region="center" border="false">
		<div id="pp" style="position:relative">
			<div style="width:25%;">
				<div id="pgrid" title="Peticiones Recibidas" closable="true" style="height:200px;">
					<table class="easyui-datagrid" style="width:380px;height:auto"
							fit="true" border="false"
							singleSelect="true" showFooter="true"
							idField="itemid" url="/app/pt_peticion/getNumxEdo">
						<thead>
							<tr>
								<th field="ESTADOPETICION" width="280">Estado</th>
								<th field="NUMPT">N&uacute;mero</th>
							</tr>
						</thead>
					</table>
				</div>
				
			    <div id="pgrid" title="Audiencias por Estado" closable="true" style="height:140px;">
					<table class="easyui-datagrid" style="width:240px;height:auto"
							fit="true" border="false"
							singleSelect="true"
							idField="itemid" url="/app/pt_reparto/getNumxEdo">
						<thead>
							<tr>
								<th field="ESTADO" width="200">Estado</th>
								<th field="NUMPT">N&uacute;mero</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			
			
			<div style="width:20%;">
				<div id="pgrid" title="Procesos por Estado" closable="true" style="height:105px;">
					<table class="easyui-datagrid" style="width:200px;height:auto"
							fit="true" border="false"
							singleSelect="true"
							idField="itemid" url="/app/gs_ficha/getNumVigentes">
						<thead>
							<tr>
								<th field="VIGENTE" width="160">Vigente</th>
								<th field="NUMFICHAS">N&uacute;mero</th>
							</tr>
						</thead>
					</table>
				</div>
				<div id="pgrid" title="Condenados en el Sistema" closable="true" style="height:105px;">
					<table class="easyui-datagrid" style="width:200px;height:auto"
							fit="true" border="false"
							singleSelect="true"
							idField="itemid" url="/app/gs_ficha/getNumCondenados">
						<thead>
							<tr>
								<th field="VIGENTE" width="160">Vigente</th>
								<th field="NUMCONDENADOS">N&uacute;mero</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			
			
			
			<div style="width:20%;">
				<div id="pgrid" title="Procesos en el Sistema" closable="true" style="height:105px;">
					<table class="easyui-datagrid" style="width:200px;height:auto"
							fit="true" border="false"
							singleSelect="true"
							idField="itemid" url="/app/gs_ficha/getNumProcesos">
						<thead>
							<tr>
								<th field="VIGENTE" width="160">Vigente</th>
								<th field="NUMPROC">N&uacute;mero</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>