
// Cloader retorna para un combobox los datos de un json
// Si el parametro del combo opts.listAll es true agrega una opci—n "Todos" para los filtros de la grid 
// ASIGNA data.rows on sucesss para no crear nuevo metodo list en el controller y usar la misma respuesta del json de la grid

var cloader = function(param, success, error){
			
		    var opts = $(this).combobox('options');
//console.log($(this));	
		    if (!opts.url) return false;
			    $.ajax({
			    	type: opts.method,
			    	url: opts.url,
			    	data: param,
		    		dataType: 'json',
	    			success: function(data){
                                      	    if (data.rows){
					    		if(opts.listAll){                     
                                        			var dataArray = new Object();
			    					dataArray[opts.valueField] = '';
		    						dataArray[opts.textField] = 'Todos';
			    					data.rows.unshift(dataArray);
			    				}
                                                      
		    					success(data.rows);  // used the data.rows array to fill combobox list
                                                    } else {		
								success(data);
						    }
						},
						error: function(){
							error.apply(this, arguments);
				}
				
			    });
		}

var ctreeloader = function(param, success, error){
	//  var opts = $(this).combobox('options');
        console.log($(this));		
//		    var opts = $(this).options;
//console.log(opts);

		    if (!opts.url) return false;
			    $.ajax({
			    	type: opts.method,
			    	url: opts.url,
			    	data: param,
		    		dataType: 'json',
	    			success: function(data){
                                      	    if (data.rows){
					    		if(opts.listAll){                     
                                        			var dataArray = new Object();
			    					dataArray[opts.valueField] = '';
		    						dataArray[opts.textField] = 'Todos';
			    					data.rows.unshift(dataArray);
			    				}
                                                      
		    					success(data.rows);  // used the data.rows array to fill combobox list
                                                    } else {		
								success(data);
						    }
						},
						error: function(){
							error.apply(this, arguments);
				}
				
			    });
		}
 function loadAjaxData(urlJson,param,handleData){
				
		  //  if (!urlJson) return false;
		  return  $.ajax({
		    		type: 'post',
		    			url: urlJson,
		    			data: param,
		    			dataType: 'json',
		    			success: function(data){
		    				//console.log(data);

                                                if (data.rows){
                                                            handleData(data.rows);
                                                     //  console.log(data.susses);
                                                        //	return data.rows;
							//	console.log(data);
                                                } else {
                                                           //  console.log();
							      handleData(data);
							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							alert( textStatus );
						}
				
				});
		} // end loadAjaxData
                
$.extend($.fn.validatebox.defaults.rules, {
			requireRadio: {  
				validator: function(value, param){  
					var input = $(param[0]);
					
					input.off('.requireRadio').on('click.requireRadio',function(){
						$(this).focus();
					});
					return $(param[0] + ':checked').val() != undefined;
				},  
				message: 'Seleccione una opci&oacute;n para {1}.'  
			}  
		});


    function openPopWin(URL,Title,Pwidth,Pheight,Pminimizable,Pmaximizable,Pclosable,Fit){			
				
	    $('#winpop').window({
			minimizable : Pminimizable,
		    	maximizable : Pmaximizable,
                        fit: Fit,
			width: Pwidth,  
			height: Pheight,
                        draggable:false,
                        closable:true,
                        closed:true,
			modal:true,
			title: Title,
                         top: 2,
                         left:2
		    });
						
		    $('#panelpop').panel({  
		    		width: Pwidth - 14,  
		    		height: Pheight - 36,
                                fit: Fit
		    });
						
	    $('#winpop').window('open');
				
	    var contentdata = ' <iframe src="'+URL+'" style="overflow-x: hidden; overflow-y: scroll; width:' + (Pwidth - 5) + 'px;height:' + (Pheight - 4) + 'px;margin: 1px;border:1px solid white;"></iframe>';
                    
	    $('#panelpop').panel({content:contentdata});
           //$('#winpop').window({content:contentdata});
                    //	$('#panelpop').panel('open').panel('refresh',URL);
		
     }
                
         function myformatter(date){
                    
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
           
            return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
        }

        function myparser(s){
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[2],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d);
            } else {
                return new Date();
            }
        }
        
        function isNullVal(fieldStr){
               //    console.log(fieldStr);
                    
                   // if() && !isNaN(fieldStr)
                     //   return 'isnan';
				
				if(fieldStr && fieldStr != '0000-00-00 00:00:00' )
					return fieldStr;
				else
					return '';
        }
  
	jQuery(document).ready(function(){
		/*
		jQuery('input').blur(function() {
                    if( !$(this).hasClass( "lowercase" ) ){
                        this.value = this.value.toLocaleUpperCase();
                    }
                    else{						
						console.log(this.value);
					}
                                       
		});
		*/
		jQuery('textarea').blur(function() {
                    if( !$(this).hasClass( "lowercase" ) )
                                        this.value = this.value.toLocaleUpperCase();
                                        
                                       
		});
	 });
		