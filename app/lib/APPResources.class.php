<?php
namespace Lib;

class APPResources
{
	
	//MIME Types
	static $mimes = array(
								"text/plain"=>"Archivo de Texto",
								"application/msword"=>"MS Word",
								"application/pdf"=>"Acrobat Reader",
								"application/vnd.ms-excel" =>"MS Excel",
								"application/vnd.ms-powerpoint"=>"MS PowerPoint",
								"application/ms-powerpoint"=>"MS PowerPoint",
								"application/mspowerpoint"=>"MS PowerPoint",
								"application/x-shockwave-flash"=>"MacroMedia Flash",
								"text/html"=>"Formato Web",
								"image/tiff"=>"Archivo de Imagen",
								"image/gif"=>"Archivo de Imagen",
								"image/jpeg"=>"Archivo de Imagen",
								"audio/mpeg"=>"Audio MP3",
								"audio/x-midi"=>"Audio Secuencia MIDI",
								"audio/x-wav"=>"Audio Audio WAV",
								"video/mpeg"=>"Video MPEG",
								"video/vndvivo"=>"Formato de Video",
								"video/quicktime"=>"Video Quicktime",
								"video/x-msvideo"=>"Video AVI",
								"video/x-ms-wmv"=>"Video Windows Media",
								"application/acad"=>"Formato Autocad",
								"application/vndms-project"=>"MS-Project",
								"application/vnd.ms-project"=>"MS-Project",
								"application/wordperfect51"=>"Word Perfect 5.1",
								"application/octet-stream"=>"Archivo de Texto",
								"application/x-gzip"=>"Archivo Comprimido",
								"application/zip"=>"Archivo Comprimido",
								"application/x-tar"=>"Archivo Comprimido",
								"image/bmp"=>"Archivo de Imagen",
								"image/png"=>"Archivo de Imagen",
								"image/x-png"=>"Archivo de Imagen",
								"text/rtf"=>"Texto Enriquecido",
								"application/vnd.sun.xml.writer"=>"Archivo SXW",
								"application/vnd.sun.xml.writer.global"=>"Archivo SXG",
								"application/vnd.sun.xml.draw"=>"Archivo SXD",
								"application/vnd.sun.xml.calc"=>"Archivo SXC",
								"application/vnd.sun.xml.impress"=>"Archivo SXI",
								"text/vcf"=>"Archivo VCard",
								"application/x-gzip"=>"Archivo TGZ",
								"application/x-gzip"=>"Archivo GZ"
							);
	
	//Meses
	static $meses = array( "Ene" , "Feb" , "Mar" , "Abr" , "May" , "Jun" , "Jul" , "Ago" , "Sept" , "Oct" , "Nov" , "Dic" );	
			
	//Estado civil			
	static $estadoCivil = array( "CA" => "Casado" , "SO" => "Soltero" , "SE" => "Separado" , "VI" => "Viudo" , "UL" => "Union Libre" );
	
	//si y no
	static $sino = array( "S" => "Si" , "N" => "No");

        //si y no
	static $TiposDocumentos = array( "CC" => "Cedula de Ciudadania" , "TI" => "Tarjeta de Identidad", "CE" => "Cedula Extranjera","PS" => "Pasaporte");
	
	//TipoRegistro
	static $TipoRegistro = array( "Inscrito" => "Inscrito" , "Referido" => "Referido");
	
	//TipoPregunta
	static $TipoPregunta = array( "Mundial" => "Mundial" , "Acierta" => "Acierta");
	
	//TipoPregunta
	static $TipoPreguntaSoluciones = array( "Mundial" => "Mundial" , "Soluciones" => "Soluciones");

        //TipoPregunta
	static $TipoPreguntaBonos = array( "Bonos" => "Bonos" );

        //tipo Pregunta
	static $PreguntaCT1 = array( "Cuadrado" => "Cuadrado" , "Triangulo" => "Triangulo" , "Circulo" => "Circulo");

	//para los temas de los foros
	static $TemasForo = array( "General" => "General" , "Especifico" => "Especifico");
	
	//volas arreglo tildes
	static $ArregloTildes = array( "�" => "á" , "�" => "é" , "�" => "í" , "�" => "ó" , "�" => "ú" , "�" => "ñ");
	
	//SWF y IMG
	static $imgSWF = array( "Img" => "Img" , "SWF" => "SWF");
	
	//Ubicacion Banners
	static $UbicacionBanner = array( "Home" => "Home", "Superior" => "Banner Superior" , "InferiorHomeLeft" => "Banner Home Inferior Left" , "InferiorHomeRight" => "Banner Home Inferior Right" , "AsociadoLeft" => "Asociado Secion Left", "BannerInterna" => "Banner Interna" );

	//Ubicacion Seccion
	static $UbicacionSeccion = array( "Menu" => "Menu" , "Derecha" => "Derecha" , "Izquierdo" => "Izquierdo" , "Inferior" => "Inferior");

        //Ubicacion galeria noticia
	static $UbicacionGaleria = array( "Menu" => "Menu" , "Derecha" => "Derecha" , "Izquierdo" => "Izquierdo" , "Inferior" => "Inferior");
	
	//Ubicacion Noticia
	static $UbicacionNoticia = array( "general" => "general" , "prensa" => "prensa" );

        //Ubicacion Categoria Receta
	static $UbicacionCategoriaReceta = array( "Superior" => "Superior" , "DestacadoHomeReceta" => "Destacado Home Receta" , "SuperiorSalud" => "Superior Salud Y Bienestar" );

        //Ubicacion receta
	static $UbicacionReceta = array( "DestacadoHomeReceta" => "Destacado Home Receta" );
	
	//MIME types validos
	static $mimeValidos = array(
								"image/gif",	//imagen gif
								"image/pjpeg",	//imagen jpeg
								"image/jpeg",	//imagen jpeg
								"image/png",	//imagen png
								"application/x-shockwave-flash",//Archivo compilado de flash
								"text/plain",	//Texto Plano
								"application/msword",	//Documento de MS Word
								"application/pdf",	//Documento de Adobe Acrobat
								"application/vnd.ms-excel",	//Hoja de calculo de MS Excel
								"application/vnd.ms-powerpoint",	//Presentacion de MS PowerPoint
								"text/rtf",	//Documento
								"text/css",	//Hoja de estilo en cascada
								"application/octet-stream",
								"audio/mpeg",
								"audio/x-midi",
								"audio/x-wav",
								"video/mpeg",
								"video/vndvivo",
								"video/quicktime",
								"video/x-msvideo",
								"video/x-ms-wmv",
								"application/acad",
								"text/vcf",
								"application/x-gzip",
								"application/x-gzip",
								"application/acad",
								"application/vndms-project",
								"application/vnd.ms-project",
								"application/wordperfect51",
								"application/vnd.sun.xml.writer",
								"application/vnd.sun.xml.writer.global",
								"application/vnd.sun.xml.draw",
								"application/vnd.sun.xml.calc",
								"application/vnd.sun.xml.impress",
								"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
								"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
								"application/vnd.openxmlformats-officedocument.presentationml.presentation"


							);
	
	//MIME types de imagenes validos
	static $mimeImagenValidos = array(
								"image/gif",	//imagen gif
								"image/pjpeg",	//imagen jpeg
								"image/jpeg",	//imagen jpeg
								"image/png",		//imagen png
								"application/x-shockwave-flash"		//flash
							);
	
	//MIME types graficos validos
	static $mimeGraficoValidos = array(
								"image/gif",	//imagen gif
								"image/pjpeg",	//imagen jpeg
								"image/jpeg",	//imagen jpeg
								"image/png",	//imagen png
								"application/x-shockwave-flash",//Archivo compilado de flash
								"audio/mpeg",
								"audio/x-midi",
								"audio/x-wav",
								"video/mpeg",
								"video/vndvivo",
								"video/quicktime",
								"video/x-msvideo",
								"video/x-ms-wmv",
								"application/acad",
								"application/vnd.sun.xml.draw"
							);
							
	//MIME types de video validos
	static $mimeVideoValidos = array(
								"application/x-shockwave-flash",//Archivo compilado de flash
								"audio/mpeg",
								"audio/x-midi",
								"audio/x-wav",
								"video/mpeg",
								"video/vndvivo",
								"video/quicktime",
								"video/x-msvideo",
								"video/x-ms-wmv"
							);		
	
	//MIME types de documento validos
	static $mimeDocsValidos = array(

								"text/plain",	//Texto Plano
								"application/msword",	//Documento de MS Word
								"application/pdf",	//Documento de Adobe Acrobat
								"application/vnd.ms-excel",	//Hoja de calculo de MS Excel
								"application/vnd.ms-powerpoint",	//Presentacion de MS PowerPoint
								"text/rtf",	//Documento
								"text/vcf",								
								"application/acad",
								"application/vndms-project",
								"application/vnd.ms-project",
								"application/wordperfect51",
								"application/vnd.sun.xml.writer",
								"application/vnd.sun.xml.writer.global",
								"application/vnd.sun.xml.draw",
								"application/vnd.sun.xml.calc",
								"application/vnd.sun.xml.impress",
								"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
								"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
								"application/vnd.openxmlformats-officedocument.presentationml.presentation"
							);
	
	//arreglo de mensajes
	static $mensajes = 	array( 	"insertarexito" => array( "msg" => "El registro se ha ingresado con exito" , "type" => "info" ),
								"guardarexito" => array( "msg" => "Los cambios han sido guardados satisfactoriamente", "type" => "info" ),
								"eliminarexito" => array( "msg" => "El registro se ha eliminado con exito" , "type" => "info" ),
								"error" => array( "msg" => "Ha ocurrido un error durante el proceso" , "type" => "error" ),
								"duplicada" => array( "msg" => "La propuesta ha sido duplicada con exito" , "type" => "info" )
							 );
	
	//errores de sesion
	static $session = array( "NSA" => "No tienes una sesi&oacute;n activa",
							 "XS" => "Tu sesi&oacute;n ha expirado",
							 "LI" => "Verifica tu usuario y contrase&ntilde;a",
							 "EX" => "Sesi&aacute;n terminada con exito"
						   );
						   
	static $medidas = array( "IM" => "Impresiones",
							 "CL" => "Clicks",
							 "EN" => "Env&iacute;os"	
						 );
	
	static $cortes = array( "Mensual" => "Mensual",
							 "Trimestral" => "Trimestral"
						 );
						 
	static $inversionmin = array( "IM" => "Impresiones",
							 	  "VM" => "Inversi&oacute;n M&iacute;nima"
						 );
	
	static $efectividad = array( "EF" => "Efectividad Clicks",
							 	 "EA" => "Efectividad en Aperturas",
							 	 "PC" => "Porcentaje de Cumplimiento"
						 );
	
	static $niveles_acceso = array( "1" => "Administrador",
							 	 "2" => "Ejecutivo",
							 	 "3" => "Clientes"
						 );
		
	/*static $modulos_2_buscar = array(
									"Seccion"=>array( 
										"Title"=>"Nombre",
										"string"=>array( "Nombre","Descripcion" ),
										"URL"=>"interna.php?ids="
										
									),
									"Noticia"=>array( 
										"Title"=>"Titular",
										"string"=>array( "Titular","Introduccion", "Cuerpo" ),
										"URL"=>"interna.php?id="
									),
									"Empresa"=>array( 
										"Title"=>"Nombre",
										"string"=>array( "Nombre","Nit","Direccion","PaginaWeb", "Categoria" ),
										"join"=>array( "IDPais"=>"Pais,Nombre", "IDDepartamento"=>"Departamento,Nombre", "IDCiudad"=>"Ciudad,Nombre" ),
										"ljoin"=>array( "IDEmpresa"=>"Productos,Nombre" ),
										"URL"=>"detalle_empresa.php?id=" 
									),
									"SitiosInteres"=>array( 
										"Title"=>"Nombre",
										"string"=>array( "Nombre","Descripcion" ),
										"URL"=>"link_interes.php?id="
									),
									"CategoriaEmpresa"=>array( 
										"Title"=>"Nombre",
										"string"=>array( "Nombre","Descripcion" ),
										"URL"=>"resultado_busqueda_subcategoria_empresa.php?id="
									),
									"Productos"=>array( 
										"Title"=>"Nombre",
										"string"=>array( "Nombre","Descripcion" , "Categoria" ) ,
										"join"=>array( "IDEmpresa"=>"Empresa,Nombre" ),
										"URL"=>"detalle_empresa.php?idp="
									),
									"Licitacion"=>array( 
										"Title"=>"Ciudad",
										"string"=>array( "Ciudad","Objeto","EnteLicitador" ),
										"URL"=>"interna.php?ids="
									),
									"Exportadores"=>array( 
										"Title"=>"NombreEmpresa",
										"string"=>array( "NombreEmpresa","PaginaWeb","Actividad","Productos","Paises" ),
										"URL"=>"exportadores.php?id="
									),
									"Eventos"=>array( 
										"Title"=>"Nombre",
										"string"=>array( "Nombre","Observaciones","PaginaWeb" ),
										"URL"=>"interna.php?ids="
									),
									"Publicaciones"=>array( 
										"Title"=>"Nombre",
										"string"=>array( "Nombre","NombreContacto","Descripcion" ),
										"URL"=>"interna.php?ids="
									)
									
								);*/

		static $modulos_2_buscar = array(
						"Seccion"=>array( 
							"Title"=>"Nombre",
							"string"=>array( "Nombre","Descripcion" )
						),
						"Noticia"=>array( 
							"Title"=>"Titular",
							"string"=>array( "Titular","Introduccion", "Cuerpo" )							
						),
						"Receta"=>array( 
							"Title"=>"Nombre",
							"string"=>array( "Nombre", "Introduccion", "Preparacion", "Ingredientes", "Porciones" )
						),
						"PRODUCTO_Categoria"=>array( 
							"Title"=>"Nombre",
							"string"=>array( "Nombre")							
						),
						
						"Promocion"=>array( 
							"Title"=>"Descripcion",
							"string"=>array( "Descripcion" )							
						),
						"GaleriaVideo"=>array( 
							"Title"=>"Video",
							"string"=>array( "Nombre" )							
						)											
						
					);
	
	static $modulos_2_buscar_int = array(
						"SeccionInt"=>array( 
							"Title"=>"Nombre",
							"string"=>array( "Nombre","Descripcion" )
						),
						"NoticiaInt"=>array( 
							"Title"=>"Titular",
							"string"=>array( "Titular","Introduccion", "Cuerpo" )							
						),
						"RecetaInt"=>array( 
							"Title"=>"Nombre",
							"string"=>array( "Nombre", "Introduccion", "Preparacion", "Ingredientes", "Porciones" )
						),
						"PRODUCTO_CategoriaInt"=>array( 
							"Title"=>"Nombre",
							"string"=>array( "Nombre")							
						),						
						"PromocionInt"=>array( 
							"Title"=>"Descripcion",
							"string"=>array( "Descripcion" )							
						)
					);
}
?>