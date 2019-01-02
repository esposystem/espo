<?php

//echo "audiencia";
//print_r($rowAudiencia);

//echo "ficha";
//print_r($rowFicha);

//echo "condena";
//print_r( $rowCondena );

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
        <script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>datagrid-detailview.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>viewUtils.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>jquery-dateFormat.js"></script>

	<script type="text/javascript">
		var url;
		var fechacaptura = '';

		var cardreporteactividad = $.extend({}, $.fn.datagrid.defaults.view, {
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
		
				cc.push('<td colspan=' + fields.length + ' style="padding:3px;border:0;">');
				if (!frozen){
				
					cc.push('<div style="float:left;margin-left:0px;">');

					rowStrCard = '<div class="tabla">';
					rowStrCard += '<p><div class="columna">Actividad  :</div><div class="columnValor">' + rowData["ACTIVIDAD"] + '</div><div class="columna">Certificado  :</div><div class="columnValor">' + rowData["NUMEROCERTIFICADO"] + '</div></p>'; //+ ' ' + rowData["APELLIDO2CONDENADO"] + ' ' +  rowData["NOMBRECONDENADO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Establecimiento  :</div><div class="columnValor">' + rowData["ESTABLECIMIENTO"] + '</div><div class="columna">Fecha del Reporte :</div><div class="columnValor">' + rowData["ANIO"] + ' / ' + rowData["MES"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Horas Reportadas:</div><div class="columnValor">' + rowData["NUMEROHORAS"] + '</div><div class="columna">Máximo de Horas Posibles</div><div class="columnValor">' + rowData["MAXIMOHORAS"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Horas a Tener en Cuenta:</div><div class="columnValor">' + rowData["HORASREDENCION"] + '</div><div class="columna">Días de Redención</div><div class="columnValor">' + rowData["DIASREDENCION"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Cumple Otorgamiento de Redención:</div><div class="columnValor">' + rowData["CUMPLE"] + '</div><div class="columna">Otorgar Redención</div><div class="columnValor">' + rowData["FECHATRCR"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Ver Archivo:</div><div class="columnValor">No disponible</div><div class="columna">Tipo de Reporte</div><div class="columnValor">' + rowData["FUENTE"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Usuario Reporta:</div><div class="columnValor">' + rowData["USUARIOTRCR"] + '</div><div class="columna">Fecha Reporte</div><div class="columnValor">' + rowData["FECHATRCR"] + '</div></p>';
					rowStrCard += '<p><div class="columna"></div><div class="columnValor"></div><div class="columna">Otorgar</div><div class="columnValor"><input type="checkbox" value="S" rel="' + rowData["DIASREDENCION"] + '" class="ckOtorgar" > Otorgar</div></p>';
					rowStrCard += '</div>';
				
					cc.push(rowStrCard);		
					cc.push('</div>');
				}
				cc.push('</td>');
				return cc.join('');
			}
		});

		var cardreportedesempeno = $.extend({}, $.fn.datagrid.defaults.view, {
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
		
				cc.push('<td colspan=' + fields.length + ' style="padding:3px;border:0;">');
				if (!frozen){
				
					cc.push('<div style="float:left;margin-left:0px;">');

					rowStrCard = '<div class="tabla">';
					rowStrCard += '<p><div class="columna">Actividad  :</div><div class="columnValor">' + rowData["ACTIVIDAD"] + '</div><div class="columna">Identificación  :</div><div class="columnValor">' + rowData["NUMDOCUMENTO"] + '</div></p>'; //+ ' ' + rowData["APELLIDO2CONDENADO"] + ' ' +  rowData["NOMBRECONDENADO"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Número de Certificado  :</div><div class="columnValor">' + rowData["NUMEROCERTIFICADO"] + '</div><div class="columna">Número de Acata :</div><div class="columnValor">' + rowData["NUMEROACTA"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Establecimiento  :</div><div class="columnValor">' + rowData["ESTABLECIMIENTO"] + '</div><div class="columna">Fecha de Acta :</div><div class="columnValor">' + rowData["FECHAACTA"] + '</div></p>';
					
					rowStrCard += '<p><div class="columna">Fecha de Inicio :</div><div class="columnValor">' + rowData["FECHAINICIO"] + '</div><div class="columna"> Fecha de Fin</div><div class="columnValor">' + rowData["FECHAFIN"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Calificación :</div><div class="columnValor">' + rowData["CALIFICACION"] + '</div><div class="columna"> </div><div class="columnValor"></div></p>';

					rowStrCard += '<p><div class="columna">Ver Archivo:</div><div class="columnValor">No disponible</div><div class="columna">Tipo de Reporte</div><div class="columnValor">' + rowData["FUENTE"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Usuario Reporta:</div><div class="columnValor">' + rowData["USUARIOTRCR"] + '</div><div class="columna">Fecha Reporte</div><div class="columnValor">' + rowData["FECHATRCR"] + '</div></p>';
					rowStrCard += '</div>';
				
					cc.push(rowStrCard);		
					cc.push('</div>');
				}
				cc.push('</td>');
				return cc.join('');
			}
		});

		var cardreporteconducta = $.extend({}, $.fn.datagrid.defaults.view, {
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
		
				cc.push('<td colspan=' + fields.length + ' style="padding:3px;border:0;">');
				if (!frozen){
				
					cc.push('<div style="float:left;margin-left:0px;">');

					rowStrCard = '<div class="tabla">';
					rowStrCard += '<p><div class="columna">Número de Certificado  :</div><div class="columnValor">' + rowData["NUMEROCERTIFICADO"] + '</div><div class="columna">Número de Acta :</div><div class="columnValor">' + rowData["NUMEROACTA"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Establecimiento  :</div><div class="columnValor">' + rowData["ESTABLECIMIENTO"] + '</div><div class="columna">Fecha de Acta :</div><div class="columnValor">' + rowData["FECHAACTA"] + '</div></p>';
					
					rowStrCard += '<p><div class="columna">Fecha de Inicio :</div><div class="columnValor">' + rowData["FECHAINICIO"] + '</div><div class="columna"> Fecha de Fin</div><div class="columnValor">' + rowData["FECHAFIN"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Calificación :</div><div class="columnValor">' + rowData["CALIFICACION"] + '</div><div class="columna"> </div><div class="columnValor"></div></p>';
					rowStrCard += '<p><div class="columna">Ver Archivo:</div><div class="columnValor">No disponible</div><div class="columna">Tipo de Reporte</div><div class="columnValor">' + rowData["FUENTE"] + '</div></p>';
					rowStrCard += '<p><div class="columna">Usuario Reporta:</div><div class="columnValor">' + rowData["USUARIOTRCR"] + '</div><div class="columna">Fecha Reporte</div><div class="columnValor">' + rowData["FECHATRCR"] + '</div></p>';
					rowStrCard += '</div>';
				
					cc.push(rowStrCard);		
					cc.push('</div>');
				}
				cc.push('</td>');
				return cc.join('');
			}
		});


		function loadCondena(documento, proceso){
			var param = {};
			var condenainicial = {};
			var condenaactual = {};
			param["filterRules"] = '[{"field":"NUMDOCUMENTO","op":"equal","value":"' + documento + '"},{"field":"NUMRADICADOPROC","op":"equal","value":"' + proceso + '"}]';
			param["sort"] = "FECHACOMPROMISO";
			param["order"] = "ASC";

			loadAjaxData('/app/gs_condena/list',param,function(data) {
				condenainicial = data[ 0 ];
				condenaactual = data[ data.length - 1 ];

				$("#txtFechaCondenaVigente").html( $.format.date( condenaactual.FECHACOMPROMISO, "dd MMM yyyy") );


				/*
				$.each(data, function(index, value) {
	 
					console.log(value.ANIOS);//aca viene la condena
					return true;
				})
				*/
				     
			}); // end loadajaxdata 
			
		}//end function loadCondena


		function loadSubrogados(documento, proceso, descuento){
			var param = {};
			param["filterRules"] = '[{"field":"NUMDOCUMENTO","op":"equal","value":"' + documento + '"},{"field":"NUMRADICADOPROC","op":"equal","value":"' + proceso + '"}]';
			param["sort"] = "FECHAINICIO";
			param["order"] = "ASC";
			param["descuento"] = descuento;

			loadAjaxData('/app/gs_condena/subrogados',param,function(data) {

				$("#txtFechaCaptura").html( data.FechaCaptura  );
				$("#txtLibertadCondicional35").html( data.FechaLibertadCondicional35  );
				$("#txtLibertadCondicional23").html( data.FechaLibertadCondicional23  );
				$("#txtPenaCumplida").html( data.FechaPenaCumplida );
				$("#txtDomiciliaria").html( data.FechaPrisionDomiciliaria );
				$("#txtDescuento").html( data.Descuento );
				$("#txtNuevaCondena").html( data.NuevaCondena );

				//Datos Condena desde el controller
				$("#txtCondenaInicial").html( data.CondenaInicial );
				$("#txtCondenaActual").html( data.CondenaActual );

				     
			}); // end loadajaxdata 
			
		}//end function loadCondena
	     
	    $(document).ready(function(){
			
			$('#fm').form('load','/app/gs_ficha/get/<?php echo $rowFicha['NUMDOCUMENTO']; ?>-<?php echo $rowFicha['NUMRADICADOPROC']; ?>');
			
			//$('#fmindiciados').form('load','/app/gs_indiciado/get/<?php echo $rowFicha['NUMDOCUMENTO']; ?>');
			//$('#fmcondena').form('load','/app/gs_condena/get/<?php echo $rowFicha['NUMDOCUMENTO']; ?>-<?php echo $rowFicha['NUMRADICADOPROC']; ?>');
			
			//Verificar cuales se otorgan
			
			preparaaccionesform();
			

	     });
			
		function preparaaccionesform()
		{
			var dias = 0;
			
		}//end function
			
   		

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
		padding: 2px;
		float:left;width:140px;
		//border-right: 1px solid #ccc;
		// border-bottom: 1px solid #ccc;
		font-weight:bold;
	}
	.tabla .columnValor {
		padding: 2px;
		float:left;width:230px;
		border-right: 1px solid #ccc;
		// border-bottom: 1px solid #ccc;
	}

	#contentCondena #DataProcDiv .fitem label{
		line-height: 17px;
	}

	#contentCondena #DataProcDiv .fitem {
		min-height: 62px;
	}

	#contentCondena{
		background-color: #f7f7f7;
	    border-bottom: 1px solid #ccc;
	    border-left: 1px solid #ddd;
	    border-top: 1px solid #ddd;
	    color: gray;
	    font-family: arial,verdana,times;
	    font-size: 12px;
	}
</style>


</head>

<body style="padding: 5px 0px 0px 10px;">
		
		<div class="easyui-panel" title="" style="width:1200px;height:1000px;padding:5px;">
			<!--cabecera -->
			<div title="Ficha T&eacute;cnica Redenciones" style="padding:6px;" >
				<div id="DataProcDiv">
					<div id="DataCon" class="ftitle" style="padding:5px 10px 5px 0px;background-color: #ddd">No de Radicado Proceso : <?php echo $rowFicha['NUMRADICADOPROC']; ?></div>
					<div class="fitem"><label style="width: 195px;"><strong>Condenado : </strong></label><?php echo $rowFicha['NOMBRECONDENADO']; ?> <strong>Documento : </strong><?php echo $rowFicha['NUMDOCUMENTO']; ?></div>
					<div class="fitem"><label style="width: 195px;"><strong>Ciudad : </strong></label><?php echo $rowFicha['IDCIUDAD'].' / '.$rowFicha['CIUDAD']; ?></div>
					<div class="fitem"><label style="width: 195px;"><strong>Establecimiento : </strong></label><?php echo $rowFicha['ESTABLECIMIENTO']; ?></div>
					<div class="fitem"><label style="width: 195px;"><strong>Fecha de Captura : </strong></label><span id="txtFechaCaptura"></span></div>
				</div>
			
			 
   
			</div>
			<div class="easyui-layout" data-options="fit:true">
				<div data-options="region:'west',split:true" style="width:260px;padding:5px">
<a href="#" onclick="javascript:openPopWin( '/app/gs_oficio/vistaPrevia/2_243_1','Vista Previa',880,550,false,true);" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:120px">Ver Providencia</a>
     
     			 <a href="#" onclick="javascript:openPopWin( 'http://opentokrtc.com/CSJ','Vista Previa',880,550,false,true);" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:160px">Video Conferencia</a>
   
     			 <a href="#" onclick="javascript:openPopWin( 'http://ada3.sistemafenix.co/app/gs_computoredenciones/detail/1.012.414.436-11001600001920130046200','Computo de Redenciones',1040,650,false,true);" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:200px">Computo de Redenciones</a>
    <a href="#" onclick="javascript:openPopWin( 'http://ada3.sistemafenix.co/app/gs_ficha/detail/1298411-05001600020620060089300','Calculo Condena',1040,650,false,true);" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:160px">Ver Ficha T&eacute;cnica</a>
    <a href="#" onclick="javascript:openPopWin( 'http://ada3.sistemafenix.co/app/pt_peticion/detail/243','Calculo Condena',1040,650,false,true);" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:160px">Ver Petición</a>
   
   
				</div>
				<div data-options="region:'center'" style="width:800px;padding:5px">


					<div id="tt" class="easyui-tabs" style="width:830px;height:auto" >
						
						
						
						
					</div>
			
				</div>
			</div>
		</div>

	<!--</div>
	<div id="dlg-buttonsValida" >
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="setProcData()">Buscar</a>
	</div>-->
	<div id="winpop" class="easyui-window" closed="true"><div id="panelpop"></div></div>  

</body>
</html>
