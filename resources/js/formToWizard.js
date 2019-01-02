/* Created by jankoatwarpspeed.com */

(function($) {
    $.fn.formToWizard = function(options) {
        options = $.extend({  
            submitButton: ''  
        }, options); 
        
        var element = this;

        var steps = $(element).find("fieldset");
        var count = steps.size();
        var submmitButtonName = "#" + options.submitButton;
        $(submmitButtonName).hide();

        // 2
        $(element).before("<ul id='steps'></ul>");

        steps.each(function(i) {
            $(this).wrap("<div id='step" + i + "'></div>");
            $(this).append("<p id='step" + i + "commands'></p>");

            // 2
            //var name = $(this).find("legend").html();
            
            var name = $(this).find("#stepTitle" + i).html();
            
            $("#steps").append("<li id='stepDesc" + i + "'>Paso " + (i + 1) + "<span>" + name + "</span></li>");

            if (i == 0) {
                createNextButton(i);
                selectStep(i);
            }
            else if (i == count - 1) {
                $("#step" + i).hide();
                createPrevButton(i);
            }
            else {
                $("#step" + i).hide();
                createPrevButton(i);
                createNextButton(i);
            }
        });

        function createPrevButton(i) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Prev' class='prev'>&laquo; &laquo; Regresar</a>");

            $("#" + stepName + "Prev").bind("click", function(e) {
                $("#" + stepName).hide();
                $("#step" + (i - 1)).show();
                $(submmitButtonName).hide();
                selectStep(i - 1);
            });
        }

        function createNextButton(i) {
			//alert('metodo');
            var stepName = "step" + i;  
			var control=false;		
			var control2=false;	
            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Next' class='next'>Siguiente &raquo; &raquo;</a>");

            $("#" + stepName + "Next").bind("click", function(e) {				
               
			   //Gonzalo J Perez
			   //12/02/2016
			   //Se modifico para que valiadara los campos input requeridos.
				$("#" + stepName + ' input').each(function (index) 
				{ 
					var clase=$(this).attr("class");
					if( String(clase).indexOf("validatebox-invalid")!='-1')
					{						
						$('#fm').form('validate');
						alert('Los campos en ROJO son obligatorios.');
						control=true;
						control2=true;
						return false;						
					}
						
				}) ;
				if(control2==false)
				{
					$("#" + stepName + ' textarea').each(function (index) 
					{ 
						var clase=$(this).attr("class");
						if( String(clase).indexOf("validatebox-invalid")!='-1')
						{						
							$('#fm').form('validate');
							alert('Los campos en ROJO son obligatorios.');
							control=true;
							return false;						
						}
							
					}) ;
				}
				

				if(control) 
				{				  
				   control=false;
				   return false;				   
				}				   
				else
				{ 
					$("#" + stepName).hide();
					$("#step" + (i + 1)).show();
					if (i + 2 == count)
						$(submmitButtonName).show();
					selectStep(i + 1);
				}
            });
        }

        function selectStep(i) {
            $("#steps li").removeClass("current");
            $("#stepDesc" + i).addClass("current");
        }

    }
})(jQuery);