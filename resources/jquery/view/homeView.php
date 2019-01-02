<?php

//print_r( $userData);

//echo $userData['GS_CF_PARAM']['GSPARAM1'];

//print_r($_COOKIE);
// setcookie("COOKIE_SESION");

//print_r($_COOKIE);
 
 
/*
error_reporting(E_ALL);
	include("config.inc.php");

	Encabezado();
	$datos = Verifica_Sesion();


	$Nombre_Usuario = $datos["Nombre"];
	$Nivel =  $datos["Nivel"];
	$IDUsuario = $datos["IDUsuario"];
	$IDPerfil = $datos["IDPerfil"];
	$IDBodegaUsuario = $datos["IDBodega"];
	$CedulaUsr = $datos["Cedula"];
	$User = $datos["User"];

	require( "config.inc.php" );
	

	SIMUtil::cache();
	
	session_start();
	
	//handler de sesion
	
	$appSession = new APPSession( SESSION_LIMIT );

	$appSession->verificar();
	
	//print_r($appSession);
	
	//print_r($datos);
	//exit;
	
	if( !$appSession->sesionActiva )
	{
	    echo "/app/login/view";
		//header( "location: /app/login/view" );
		//exit;
	}
	

	$db_query_permisos = db_query("SELECT GP.IDGrupo,GP.IDPerfil,PO.IDModulo,PO.IDOperacion,MO.Operacion,M.Modulo,M.Posicion
								FROM SI_CF_GRUPOUSUARIO GU, SI_CF_GRUPOPERFIL GP, SI_CF_PERFILOPER PO, SI_CF_MODULOOPER MO, SI_CF_MODULO M
								WHERE GP.IDGrupo = GU.IDGrupo
								AND GP.IDPerfil = PO.IDPerfil
								AND MO.IDModulo = PO.IDModulo
								AND MO.IDOperacion = PO.IDOperacion
								AND M.IDModulo = MO.IDModulo
								AND GU.IDEmpleado = '$datos_user_obj->IDEmpleado'
								GROUP BY PO.IDModulo,PO.IDOperacion
								ORDER BY PO.IDModulo,M.Posicion
							 " );
															
				$Array_Permisos = array();
				$Array_Modulos = array();

				while($r_permiso = db_fetch_object($db_query_permisos)){
					
						$Array_Permisos[$r_permiso->Modulo][$r_permiso->Operacion] = $r_permiso->IDModulo;
						$Array_Modulos[$r_permiso->IDModulo] = $r_permiso->Modulo;
						
					//	db_query("DELETE FROM SI_CF_MODULOMENU WHERE IDEmpleado = '$datos_user_obj->IDEmpleado' ");
						
						get_Modulos($r_permiso->IDModulo,$array_ModUser);
					
					//	$array_ModUser = array_reverse($array_ModUser,true);
					
						foreach($array_ModUser  AS $key2 => $value2){
							$qry_mod = db_query("SELECT * FROM SI_CF_MODULO WHERE IDModulo = '$key2' ");
							
							$r_mod = db_fetch_object($qry_mod);
							
							db_query("INSERT IGNORE INTO SI_CF_MODULOMENU VALUES('$datos_user_obj->IDEmpleado','$r_mod->IDModulo','$r_mod->IDPadre','$r_mod->Nombre','$r_mod->Posicion','$r_mod->Dependiente','$r_mod->Modulo','','') ");
						}
				}
	
//print_r($datos["Permisos"]);
//print_r($datos["Modulos"]);

/*
foreach($datos["Modulos"] AS $key => $value){
	
	get_Modulos($key,$array_bodegas);
	
	foreach($array_bodegas  AS $key2 => $value2){
		$qry_mod = db_query("SELECT * FROM SI_CF_MODULO WHERE IDModulo = '$key2' ");
		
		$r_mod = db_fetch_object($qry_mod);
		
		db_query("INSERT IGNORE INTO SI_CF_MODULOMENU VALUES('$IDPerfil','$r_mod->IDModulo','$r_mod->IDPadre','$r_mod->Nombre','$r_mod->Posicion','$r_mod->Dependiente','$r_mod->Modulo','','') ");
	}
	
}

*/

?>
<html>
<head>
<title><?php echo $config->get('appName')?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/icon.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/default/easyui.css"/>
	<script type="text/javascript" src="<?php echo $config->get('jqueryFolder')?>jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.easyui.min.js"></script>
	
<style>
body{
    font-family:Arial,Helvetica,"Nimbus Sans L",sans-serif;
	background:#fafafa;
//	text-align:center;
}
  article, aside, figure, footer, header, hgroup, 
   nav, section { display: block; }
  .west{
    width:240px;
    padding:5px;
    background:#993333;
  }
  .north{
    height:74px;
  }
  #topmenu{
	 padding:0px 0 0 0;
	text-align:right;
	font-size:14px;
	color:#000;
	

}
#topmenu a{
	//display:inline-block;
	//padding:1px 3px;
	text-decoration:none;
	color:#000;
}
#topmenu a:hover{
	text-decoration:underline;
}

// PARA MENU NO ADMIN

#MenuNA
    {
        padding:105px;
      //  margin:0;
      
        font-size:18px;
        color:#717171;
        width:100%;
    }

    
     #MenuNA ul
    {
     //   border-bottom:1px solid #993333;
        margin:0;
       padding: 0px 0px 0px 18px;
         list-style-type:initial;
    }
    
    .submenu ul
    {
     //   border-bottom:1px solid #993333;
      //  margin:0;
       padding:0px 0px 3px 4px;
    }
    #MenuNA li
    {
       // border-bottom:1px solid #eeeeee;
        padding:0px 0px 3px 4px;
	
    }

    #MenuNA li:hover
    {
        background-color:#993333;
    }
#MenuNA li:hover a
    {
        color:White;
    }


    #MenuNA a:link
    {
        color:#993333;
        text-decoration:none;
    }

    #MenuNA a:hover
    {
        color:White;
    }

</style>
<script>
	
	 function Open3(text,url,closable){
	 
	    if($("#tabs").tabs('exists',text)){
		$('#tabs').tabs('select', text);
	    }else{
		   
		var content = ' <iframe src="'+url+'" style="overflow-x: hidden; overflow-y: scroll; width:98%;height:98%;margin: 5px 5px 5px 5px;border:1px solid white;"></iframe>';
	  
		$('#tabs').tabs('add', {
		      title:text,
		      url:url,
		      closable:closable,
		  content:content
		});
	    }
	}
	
$(function(){
  
     $.ajax({
        url: "/app/si_cf_modulomenu/list",
        dataType: "json",
        type: "get",
        beforeSend: function(xhr, settings) {
            $("#MenuNA").find("ul").remove();
        },
        success: function(data, status, xhr) {
	    console.log(data);
           // if (data["d"]) {
           //     if (data["d"].length) {
             //         var items = data,
            //              ul = $("<ul />").appendTo($("#Li2"));
            //          for (x in items) {
            //              var li = $("<li />").appendTo(ul);
            //              li.append($("<a />", { href: items[x].ReportUrl, text: items[x].text }));
            //          }
            //    }
           // }
	  // var ul = $('#Li2');
	   
	   var menu=$('#MenuNA');
	    parseMenu(menu, data);
	
	
        }
    });
     
      function parseMenu(ul, menu) {
	
	var urlOpt;
	
	for (var i=0;i<menu.length;i++) {
	    
		if(menu[i].attributes.url  != null)
		     //urlOpt = menu[i].attributes.url;
		    strOnclick = 'onClick="Open3(\'' + menu[i].text + '\',\'' + menu[i].attributes.url + '\',true);"';
		else
		    strOnclick = '';
		
		//console.log(strOnclick);
		
		// Open3(node.text,node.attributes.url,true);
		
		//var li=$(ul).append('<li><a href="'+urlOpt+'">'+menu[i].text+'</a></li>');
		
		 if(menu[i].text == 'Sistema ')
		      var li = $(ul).append('');
		else
		    var li = $(ul).append('<li><a href="javascript:void(0)" '+ strOnclick +'>'+menu[i].text+'</a></li>');
		
		if (menu[i].children != null) {
		    
		//    console.log(menu[i]);
			var subul = $('<ul id="submenu'+menu[i].id+'" class="submenu"></ul>');
			$(li).append(subul);
			parseMenu($(subul), menu[i].children);
		}
	}
    }
     
	$("#tree").tree({
	 // data:treeData,
	      //url:'includes/tree_modulos.php?opt=listPerfil&IDEmpleado=<?=$IDUsuario?>',
	      url:'/app/si_cf_modulomenu/list',
	      lines:true,
	      
	      onClick:function(node){
			  //  console.log(node);
		if(node.attributes){
		  //	alert(node.attributes.url);
		  if(node.attributes.url != '')	
		      Open3(node.text,node.attributes.url,true);
		  //   open1(node);
		  //	alert(node.attributes.url);
		}
	      },
	      onLoadSuccess : function () {
					
		    $('#tree').tree('collapseAll');
		}
	});
  
		function open1(plugin){
				if ($('#tabs').tabs('exists',plugin.text)){
					$('#tabs').tabs('select', plugin.text);
				} else {
					$('#tabs').tabs('add',{
						title:plugin.text,
						href:plugin.attributes.url,
						closable:true,
						//content:plugin.text,
						extractor:function(data){
							//alert(data);
							var tmp = $('<div></div>').html(data);
							data = tmp.find('#content').html();
							tmp.remove();
							return data;
						}
					});
				}
		}
			
  function Open(text,url,closable){
	//  alert(text);
    if($("#tabs").tabs('exists',text)){
        $('#tabs').tabs('select', text);
    }else{
	//	alert(url);
      $('#tabs').tabs('add', {
	    title:text,
	    href:url,
	    closable:closable,
      //  content:text,
		extractor:function(data){
		    	//	alert(data);
	    			var tmp = $('<div></div>').html(data);
			    	data = tmp.find('#content').html();
			    	tmp.remove();
			    	return data;
		}
      });
    }
  }
  
  
  
  $("#tabs").tabs({
    onContextMenu:function(e,title){
      e.preventDefault();
      $('#tabsMenu').menu('show', {  
        left: e.pageX,  
        top: e.pageY  
      }).data("tabTitle",title);
    }
  });
  
  $("#tabsMenu").menu({
    onClick:function(item){
      CloseTab(this,item.name);
    }
  });
  
  function CloseTab(menu,type){
    var curTabTitle = $(menu).data("tabTitle");
    var tabs = $("#tabs");
  
    if(type === "close"){
       tabs.tabs("close",curTabTitle);
      return;
    }
    
    var allTabs = tabs.tabs("tabs");
    var closeTabsTitle = [];
    
    $.each(allTabs,function(){
      var opt = $(this).panel("options");
      if(opt.closable && opt.title != curTabTitle && type === "Other"){
        closeTabsTitle.push(opt.title);
      }else if(opt.closable && type === "All"){
        closeTabsTitle.push(opt.title);
      }
    });
    
    for(var i = 0;i<closeTabsTitle.length;i++){
      tabs.tabs("close",closeTabsTitle[i]);
    }
  }
  
 Open3('Dashboard','/app/homeTab/dashboard',false); // indexnew.php?mod=Dashboard
  
});


</script>
<style type="text/css">
		.rtitle{
			font-size:16px;
			font-weight:bold;
			padding:5px 10px;
			background:#000066;
			color:#fff;
		}
</style>
<style id="jsbin-css"></style></head>
<body class="easyui-layout"> 
    <div data-options="region:'north'" style="background:#ddd;height:28px;padding:0px;">		
		
	<table cellpadding="0" cellspacing="0" style="width:100%;height:28px;padding-top:0px;background-image:url('<?php echo $config->get('jsImgs')?>banner_bg2.jpg');background-repeat: no-repeat;">
	<tr>
			<td rowspan="2" >
			</td>			
			<td style="width:100px;" style="padding-right:0px;text-align:right;vertical-align:bottom;">
				<div id="topmenu">				
					<span style="color: #fff;"><?php echo $config->get('appName')?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Usuario : <? echo $userData["NOMBRE"]; ?>
			<a href="/app/login/out" class="easyui-linkbutton" iconCls="icon-logout" title="Cerrar" onclick="document.location='/app/login/out';"></a> 
		
				</div>
			</td>
		</tr>
	</table>
	</div>
  <div region="center" >
    <div class="easyui-tabs" fit="true" border="false" id="tabs">
  
    </div>
  </div>
  <div region="west" class="west" title="&nbsp;">
   
  <div style="width:240px;height:auto;background:#993333;padding:2px;">
    
	<?php if(in_array(1,$userData['GRUPOS'])){
	?>
	<div class="easyui-panel"  collapsible="true" style="width:230px;height:auto;padding:4px;">
			 <ul id="tree"></ul>
			 </div>
	<?php }
	else{
	?>
	
	    <div class="easyui-panel" title="Menu Principal" collapsible="true" style="width:235px;height:auto;padding:0px;">
		<div id="MenuNA" style="padding:10px 0 0 10px;">
		   
		</div>
		
	    </div>
	
	<?php 
	}
	?>	
		<br/>
	</div>
  </div>
</body>
</html>