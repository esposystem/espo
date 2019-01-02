<?php

//print_r( $userData);

//echo $userData['GS_CF_PARAM']['GSPARAM1'];

//print_r($_COOKIE);
// setcookie("COOKIE_SESION");
//print_r($_COOKIE);

?>
<html>
<head>
<title><?php echo $config->get('appName')?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php	echo Lib\APPUtil::headerView(); ?>
	<!-- Bootstrap Core CSS -->
    <link href="<?php echo $config->get('bootstrapFolder'); ?>/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo $config->get('bootstrapFolder'); ?>css/sb-admin.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="<?php echo $config->get('bootstrapFolder'); ?>css/plugins/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo $config->get('bootstrapFolder'); ?>font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $config->get('bootstrapFolder'); ?>js/bootstrap.min.js"></script>
	<!-- Estilos Especiales Sistema de Ejecución de Penas -->
  	
<style>
body{
    font-family:Arial,Helvetica,"Nimbus Sans L",sans-serif;
	background:#fafafa;
}
  article, aside, figure, footer, header, hgroup, 
   nav, section { display: block; }
  .west{
    width:246px;
    padding:5px;
    
  }
  .north{
    height:74px;
    background-color: #1D1E50;
  }
  #topmenu{
	 padding:0px 0 0 0;
	text-align:right;
	font-size:14px;
	color:#fff;
	

}
#topmenu a{
	//display:inline-block;
	//padding:1px 3px;
	text-decoration:none;
	color:#FFF;
}
#topmenu a:hover{
	text-decoration:underline;
}
</style>
<script>
	
	var defaultTabTxt = '';
	var defaultTabUrl = '';
	var defaultTabAttr = '';
	
	 function openTabMod(text,url,closable,nodeAttr){
	 
	// console.log(nodeAttr);
	    if($("#tabs").tabs('exists',text)){
		$('#tabs').tabs('select', text);
	    }else{
		  
		var toolHelp = [];
		
		if (nodeAttr.FILEMANUAL != null  && (typeof nodeAttr.FILEMANUAL != 'undefined' ))	
		    if(nodeAttr.FILEMANUAL != ""){
		      var toolHelp =  [{
				iconCls:'icon-helpn',
				handler:function(){

					 textTab = 'Tutorial '+text;
					 
						if($("#tabs").tabs('exists',textTab)){
						   // alert(textTab);
							$('#tabs').tabs('select', textTab);
						    }else{
							    var content = ' <iframe src="'+ nodeAttr.FILEMANUAL +'" style="overflow-x: hidden; overflow-y: scroll; width:100%;height:100%;margin: 0px;border:1px solid white;"></iframe>';

							$('#tabs').tabs('add', {
							      title: textTab,
							      url:url,
							      closable:closable,
							    content:content
							});
						    }
				}
			    }];
		    }
		
		var content = ' <iframe src="'+url+'" style="overflow-x: hidden; overflow-y: scroll; width:100%;height:100%;margin: 0px;border:1px solid white;"></iframe>';
	  
		$('#tabs').tabs('add', {
		      title:text,
		      url:url,
		      closable:closable,
		      tools:toolHelp,
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
	   var menu=$('#MenuNA');
	    parseMenu(menu, data);
	    preparamenu();
        }
    });
     
	
    function parseMenu(ul, menu) {
	
	var urlOpt;
	var icono = "";
	var collapsable = "";
	var iconoflecha = "";
	var padding = "";
	
	for (var i=0;i<menu.length;i++) {

		icono = "";
		collapsable = "";
		iconoflecha = "";
		padding = "";
	    

			      
		if(menu[i].attributes.url  != null){
		     //urlOpt = menu[i].attributes.url;
		    strOnclick = 'onClick="openTabMod(\'' + menu[i].text + '\',\'' + menu[i].attributes.url + '\',true,\' + menu[i].attributes + \' );"';
		
		  if(defaultTabTxt == ''){
			defaultTabTxt = menu[i].text;
			defaultTabUrl = menu[i].attributes.url;
			defaultTabAttr = menu[i].attributes;
		  }
		  		
		}
		else
		    strOnclick = '';
		
		//console.log(strOnclick);
		
		// Open3(node.text,node.attributes.url,true);
		
		//var li=$(ul).append('<li><a href="'+urlOpt+'">'+menu[i].text+'</a></li>');
		
		//console.log(menu[i].text);
		 if(menu[i].text == 'Sistema ' || menu[i].text == 'DashBoard')
		      var li = $(ul).append('');
		else
		{
			if( menu[i].icon != null ) //para pintar el menu de la opcion
			{
				icono = "<i class='fa " + menu[i].icon + "'></i> ";
			}//end if

			//verificar si tiene hijos para el collapsable
			if (menu[i].children.length > 0 ) {
				collapsable = " data-toggle='collapse' data-target='#submenu" + menu[i].id + "'' ";
				iconoflecha = "<i class='fa fa-fw fa-caret-down'></i>";
				
			}//end if
			//else
				//padding = " style='padding-left:50px;' ";
			

		    var li = $(ul).append('<li><a ' + collapsable + padding + ' href="javascript:void(0)" '+ strOnclick +'>'+ icono + menu[i].text + iconoflecha + '</a></li>');
		}//end else
		
		if (menu[i].children.length > 0) {
		    
		//    console.log(menu[i]);
			var subul = $('<ul id="submenu'+menu[i].id+'" class="submenu collapse"></ul>');
			$(li).append(subul);
			parseMenu($(subul), menu[i].children);
		}
	}
    }
    
	$("#tree").tree({
	      url:'/app/si_cf_modulomenu/list',
	      lines:true,
	      
	      onClick:function(node){
		if(node.attributes){

		  if(node.attributes.url != '')	
		      openTabMod(node.text,node.attributes.url,true,node.attributes);
		}
	      },
	      onLoadSuccess : function () {
					
		    $('#tree').tree('collapseAll');
		}
	});

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
 
});

	 $(document).ready(function(){
		preparamenu();
		
     });

	function preparamenu()
	{
		$( ".submenu:first-child" ).addClass( "nav navbar-nav side-nav" );
		$( ".submenu:first-child" ).removeClass( "collapse" );
		
		<?php if(!empty($userData["PERMISOS"]["/app/homeTab/dashboard"]))
			    echo " openTabMod('DashBoard','/app/homeTab/dashboard',false,''); ";
			else
			   echo " if(defaultTabTxt != '') openTabMod(defaultTabTxt,defaultTabUrl,true,defaultTabAttr);";
		 ?>
		   
	}//end function
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
    <div data-options="region:'north'" style="background:#1D1E50;height:74px;padding:0px;">		
		
	<table cellpadding="0" cellspacing="0" style="width:100%;height:72px;padding-top:0px;background-image:url('<?php echo $config->get('jsImgs')?>banner_bg_472.jpg');background-repeat: no-repeat;">
		<tr>		
			<td style="width:100px;" style="text-align:right;vertical-align:bottom;">
				<div id="topmenu" style="padding-right:5px;">				
					<span style="color: #fff;"><?php echo $config->get('appName')?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Usuario : <?php echo $userData["NOMBRE"]; ?>
			<a href="/app/login/out" class="easyui-linkbutton" iconCls="icon-turnoff" title="Cerrar" onclick="document.location='/app/login/out';"></a> 
		
				</div>
			</td>
		</tr>
	</table>
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	    </button>
	</div>
  <div region="center" >
    <div class="easyui-tabs" fit="true" border="false" id="tabs">
  
    </div>
  </div>
  <div region="west" class="west" title="&nbsp;">
   
  <div style="width:240px;height:auto;padding:2px;">
    
	
	<div class="easyui-panel"  collapsible="true" style="width:230px;height:auto;padding:4px;">
			 <ul id="tree" ></ul>


			 </div>
	
		<br/>
	</div>
  </div>
</body>
</html>