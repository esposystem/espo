<?php

namespace Lib;

class APPCal
{
	
	
	
	static function siguienteDia( $fecha, $dias = 1 )
	{
		//traer solo si no es ni sabado ni domingo
		
		$arrayCalendar = array();
		

		do{

			$fecha = date("Y-m-d", strtotime('+' . $dias . 'day', strtotime($fecha)));
			$dias = 1;

			$anio = substr($fecha, 0,4);
			$mes = substr($fecha, 6,2);
			$dia = substr($fecha, 8,2);

			$dayofweek =jddayofweek ( cal_to_jd(CAL_GREGORIAN, $mes,$dia, $anio)  ); 

			$arrayCalendar["fecha"] = $fecha;
			$arrayCalendar["anio"] = $anio * 1;
			$arrayCalendar["mes"] = $mes * 1;
			$arrayCalendar["dia"] = $dia * 1;

		} while( $dayofweek == 6 || $dayofweek == 0 );//end do while

		return $arrayCalendar["fecha"];

	}//end function

	//para obtener el dia de la semana al que corresponde una fecha
	static function diadelasemana( $fecha )
	{
		$anio = substr($fecha, 0,4);
		$mes = substr($fecha, 6,2);
		$dia = substr($fecha, 8,2);
		$dayofweek =jddayofweek ( cal_to_jd(CAL_GREGORIAN, $mes,$dia, $anio)  ); 
		return $dayofweek;
	}//end function


	static function getHorario( $minutosIntervalo = 30 ){

		$config = \Lib\Config::singleton();
		$arrayHorasDia = $config->get('HORAS_HABILES');

		foreach( $arrayHorasDia as $keyHora => $horasDia )
		{
			$hora = $horasDia[0];
			do
			{

				$arrayHorario[] = $hora;
				$arrayHora = explode(":", $hora);
				$h = $arrayHora[0];
				$m = $arrayHora[1];
				$hora = date( "H:i", mktime($h, $m + $minutosIntervalo  )  );

			}while( $hora <> $horasDia[1] ); //end while
		}//end for

		return $arrayHorario;

	}//end function

	//$Fecha = date("Y-m-d H:i:s"); // Fecha Actual
	//$Sumar = 1; // Cuantos minutos sumaremos

	static function sumarMinutosFecha($FechaStr, $MinASumar) {

		$FechaStr = str_replace("-", " ", $FechaStr);
		$FechaStr = str_replace(":", " ", $FechaStr);

		$FechaOrigen = explode(" ", $FechaStr);

		$Dia = $FechaOrigen[2];
		$Mes = $FechaOrigen[1];
		$Ano = $FechaOrigen[0];

		$Horas = $FechaOrigen[3];
		$Minutos = $FechaOrigen[4];
		$Segundos = $FechaOrigen[5];

		// Sumo los minutos
		$Minutos = ((int)$Minutos) + ((int)$MinASumar);

		// Asigno la fecha modificada a una nueva variable
		$FechaNueva = date("Y-m-d H:i:s",mktime($Horas,$Minutos,$Segundos,$Mes,$Dia,$Ano));

		return $FechaNueva;
	}//end fucntion

	static function sumarDiasFecha($FechaStr, $dias){

		list($year,$mon,$day) = explode( '-',substr( $FechaStr,0, 10 ) );
		return date('Y-m-d',mktime(0,0,0,$mon,$day+$dias,$year));
	
	}//end funcion

	public static function tiempo( $fecha ) 
	{
		
		//echo $fecha;
		$horafinal = "";
		
		$fechahora = explode( " " , $fecha );
		
		$fecha = explode( "-" , $fechahora[0] );
		
		if(!empty($fechahora[1]))
			$hora = explode( ":" , $fechahora[1] );
		
		if( !empty( $fecha ) )
			$horafinal .= APPResources::$meses[ $fecha[1] - 1 ] . " " . $fecha[2] . " de " . $fecha[0];
		
		if( !empty( $hora[0] ) )
		{
			$hora[0] = (int)$hora[0];
			
			if( $hora[0] > 12 )
			{
				$hora[0] = $hora[0] - 12;
				$merid = "pm";
				
				if( $hora[0] < 10 )
					$hora[0] = "0" . $hora[0];
			}
			else
			{
				if( $hora[0] == 12 )
					$merid = "pm";
				else
					$merid = "am";
					
			}
				
				
			 $horafinal .= " " . $hora[0] . ":" . $hora[1] . ":" . $hora[2] . " " . $merid;
		}
		

		return trim( $horafinal );	
	}//end function
	
	
/*END */

}//end class
?>