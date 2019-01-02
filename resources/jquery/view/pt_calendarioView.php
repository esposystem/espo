<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $config->get('appName')?></title>
	<?php
	
	
	/*
	<!--	<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/icon.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>themes/default/easyui.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $config->get('jeasiUIFolder')?>demo/demo.css">
	-->*/
	?>
		<script type="text/javascript" src="<?php echo $config->get('jqueryFolder')?>jquery.min.js"></script>
		<script type="text/javascript" src="http://arshaw.com/js/fullcalendar-2.0.2/lib/jquery-ui.custom.min.js"></script>
		
	<?php/*<!--
		<script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>jquery.easyui.min.js"></script>
                <script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>locale/easyui-lang-es.js"></script>
                <script type="text/javascript" src="<?php echo $config->get('jeasiUIFolder')?>datagrid-filter.js"></script>
		<script type="text/javascript" src="<?php echo $config->get('jsFolder')?>viewUtils.js"></script>
	-->*/
	?>
	
	
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.2/fullcalendar.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.2/lang/es.js"></script>
		
	<!--	<script type="text/javascript" src="cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.2/gcal.js"></script>
		-->
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.2/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.0.2/fullcalendar.print.css">
	
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/cupertino/jquery-ui.css" />
	<script type="text/javascript">
		var url;
                
        $(document).ready(function() {
        
		
		$('#external-events div.external-event').each(function() {
		
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};
			
			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);
			
			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});
			
		});

	
	
          var date = new Date();
          var d = date.getDate();
          var m = date.getMonth();
          var y = date.getFullYear();
          
          var calendar = $('#calendar').fullCalendar({
          	theme: true,
            header: {
              left: 'prev,next today',
              center: 'title',
              right: 'month,agendaWeek,agendaDay'
            },
	    editable: true,
	    droppable: true,
            selectable: true,
          //  selectHelper: true,
	    axisFormat:'HH:mm',
	     allDaySlot : false,
	     columnFormat:'ddd d/M',       
          weekends: false,
          defaultEventMinutes : 30, 
 	  //  defaultEventMinutes:30,
 	    firstHour:7,
 	   	minTime:'7',
 	   // maxTime:'18',
	    
           // select: function(start, end, allDay) {
           //   var title = prompt('Agendar Evento :');
            //  if (title) {
            //    calendar.fullCalendar('renderEvent',
            //      {
            //        title: title,
            //        start: start,
            //        end: end,
            //        allDay: allDay
            //      },
            //      true // make the event "stick"
            //    );
            //  }
            //  calendar.fullCalendar('unselect');
            //},
         //   editable: false,
	 
	 drop: function(date) { // this function is called when something is dropped
			
				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');
				
				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);
				
				// assign it the date that was reported
				copiedEventObject.start = date;
				
				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
				
				// is the "remove after drop" checkbox checked?
				if ($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}
				
			},

			
            eventSources: [
			 //{
			 //		url: "http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic",
		 //			editable: true,
		 //			className: 'holiday'
		 //	},
		        // your event source
			  {
		            url: '/app/pt_reparto/listForCalAud',
		            type: 'POST',
		            data: {
		                custom_param1: 'something',
		                custom_param2: 'somethingelse'
		            },
		            error: function() {
		                alert('Lista reparto ');
		            },
		            color: 'black',   // a non-ajax option
		            textColor: 'blue', // a non-ajax option
			//    className: 'holiday'
		        },
		        {
		            url: '/app/pr_dm_diafestivo/listForCal',
		            type: 'POST',
		            data: {
		                custom_param1: 'something',
		                custom_param2: 'somethingelse'
		            },
		            error: function() {
		                alert('there was an error while fetching events!');
		            },
		            color: 'black',   // a non-ajax option
		            textColor: 'yellow', // a non-ajax option
			//    className: 'holiday'
		        }

		        // any other sources...

		    ]
          });
          
        });   
                    
	
	</script>
	
	<style>

	body {
		margin-top: 20px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
	}
		
	#wrap {
		width: 910px;
		//margin: 0 auto;
	}
		
	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
		border: 1px solid #ccc;
		background: #eee;
		text-align: left;
	}
		
	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
	}
		
	.external-event { /* try to mimick the look of a real event */
		margin: 10px 0;
		padding: 2px 4px;
		background: #3366CC;
		color: #fff;
		font-size: .85em;
		cursor: pointer;
	}
		
	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
	}
		
	#external-events p input {
		margin: 0;
		vertical-align: middle;
	}

	#calendar {
		float: right;
		width: 730px;
	}

</style>

</head>

<body>
	<h2><?php echo $modDesc ?></h2>
	<div id='wrap'>
		<div id='external-events'>
			<h4>Peticiones Por Agendar</h4>
			<div class='external-event'>Proceso 900998123133</div>
			<div class='external-event'>Proceso 0012111001022939838</div>
			<div class='external-event'>Proceso 0012111001022939838</div>
			<div class='external-event'>Proceso 0012111001022939838</div>
			<div class='external-event'>Proceso 0012111001022939838</div>
			<p>
				<input type='checkbox' id='drop-remove' />
				<label for='drop-remove'>Eliminar luego de arrastrar</label>
			</p>
		</div>
		<div id='calendar'></div>

		<div style='clear:both'></div>
	</div>
</body>
</html>
