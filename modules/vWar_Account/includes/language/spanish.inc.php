<?php //vwar
/* #####################################################################################
 *
 * $Id: spanish.inc.php,v 1.18 2004/03/14 20:22:10 mabu Exp $
 *
 * This notice must remain untouched at all times.
 *
 * Modifications to the script, except the official addons or hacks,
 * without the owners permission are prohibited.
 * All rights reserved to their proper authors.
 *
 * ---------------------------------------------
 * http://www.vwar.de || Copyright (C) 2001-2004
 * ---------------------------------------------
 *
 * #####################################################################################
 */

## ---- THIS FILE WILL BE EDITED BY A MACHINE ---- ##
## ----        DON'T CHANGE IT BY HAND        ---- ##

## ------------------------------- DEFINE COUNTRIES --------------------------------- ##
$country_array = array(
	"af" => "Afganist�n",
	"al" => "Albania",
	"am" => "Armenia",
	"an" => "Pa�ses Bajos Antillas",
	"ao" => "Angola",
	"ar" => "Argentina",
	"at" => "Austria",
	"au" => "Australia",
	"aw" => "Aruba",
	"az" => "Azerbaiy&aacute;n",
	"ba" => "Bosnia y herzegowina",
	"bb" => "Barbados",
	"bd" => "Bangladesh",
	"be" => "B�lgica",
	"bf" => "Burkina Faso",
	"bg" => "Bulgaria",
	"bh" => "Bahrein",
	"bi" => "Burundi",
	"bj" => "Benin",
	"bm" => "Bermudas",
	"bn" => "Brunei Darussalam",
	"bo" => "Bolivia",
	"br" => "Brasil",
	"bs" => "Bahamas",
	"bt" => "Bhut�n",
	"bw" => "Botswana",
	"bx" => "Benelux",
	"by" => "Bielorrusia",
	"bz" => "Belice",
	"ca" => "Canad�",
	"cf" => "Rep�blica De Africano Central",
	"cg" => "Congo",
	"ch" => "Suiza",
	"ci" => "Cote D'Ivoire (Costa de Marfil)",
	"ck" => "Islas De Cocinero",
	"cm" => "Camerun",
	"cn" => "China",
	"co" => "Colombia",
	"cr" => "Costa Rica",
	"cu" => "Cuba",
	"cv" => "Cape Verde",
	"cy" => "Chipre",
	"cz" => "Republica Checa",
	"de" => "Alemania",
	"dk" => "Dinamarca",
	"dz" => "Argelia",
	"ec" => "Ecuador",
	"ee" => "Estonia",
	"eg" => "Egipto",
	"er" => "Eritrea",
	"es" => "Espa&ntilde;a",
	"et" => "Etiop�a",
	"eu" => "Europa",
	"fi" => "Finlandia",
	"fj" => "Fiji",
	"fo" => "Islas De Faroe",
	"fr" => "Francia",
	"ga" => "Gab�n",
	"ge" => "Georgia",
	"gi" => "Gibraltar",
	"gl" => "Groenlandia",
	"gp" => "Guadeloupe",
	"gr" => "Grecia",
	"gt" => "Guatemala",
	"gu" => "Guam",
	"gy" => "Guyana",
	"hk" => "Hong Kong",
	"hr" => "Croacia",
	"ht" => "Hait�",
	"hu" => "Hungria",
	"id" => "Indonesia",
	"ie" => "Irlanda",
	"il" => "Isreal",
	"in" => "India",
	"int" => "Internacional",
	"iq" => "Iraq",
	"ir" => "Iran",
	"is" => "Islandia",
	"it" => "Italia",
	"jm" => "Jamaica",
	"jo" => "Jordania",
	"jp" => "Japon",
	"ke" => "Kenia",
	"kg" => "Kyrgyzstan",
	"kh" => "Camboya",
	"ki" => "Kiribati",
	"kp" => "Corea (Norte)",
	"kr" => "Republica de Corea",
	"ky" => "Islas De Cayman",
	"kz" => "Kazakhstan",
	"lb" => "L�bano",
	"lc" => "Santo Lucia",
	"li" => "Liechtenstein",
	"lk" => "Sri Lanka",
	"lt" => "Lituania",
	"lu" => "Luxemburgo",
	"lv" => "Letonia",
	"ly" => "Libia",
	"ma" => "Marruecos",
	"mc" => "M�naco",
	"md" => "Rep&uacute;blica de Moldavia",
	"mg" => "Madagascar",
	"mn" => "Mongolia",
	"mo" => "Macau",
	"mp" => "Islas De Mariana Norte�as",
	"ms" => "Montserrat",
	"mt" => "Malta",
	"mx" => "M�xico",
	"my" => "Malasia",
	"mz" => "Mozambique",
	"na" => "Namibia",
	"nc" => "Caledonia Nuevo",
	"nf" => "Isla De Norfolk",
	"nl" => "Holanda",
	"no" => "Noruega",
	"np" => "Nepal",
	"nr" => "Nauru",
	"nz" => "Nueva Zelanda",
	"om" => "Om�n",
	"pa" => "Panam�",
	"pe" => "Per�",
	"pf" => "Polinesia Francesa",
	"ph" => "Filipinas",
	"pk" => "Paquist�n",
	"pl" => "Polonia",
	"pm" => "St. Pierre y Miquelon",
	"pr" => "Puerto Rico",
	"pt" => "Portugal",
	"py" => "Paraguay",
	"qa" => "Qatar",
	"ro" => "Rumania",
	"ru" => "Federaci&oacute;n Rusa",
	"sa" => "Saudi De Arabia",
	"sb" => "Islas De Solomon",
	"sca" => "Escandinavia",
	"sd" => "Sud�n",
	"se" => "Suecia",
	"sg" => "Singapur",
	"si" => "Eslovenia",
	"sk" => "Eslovaquia",
	"sl" => "Sierra Leone",
	"so" => "Somalia",
	"tc" => "Turcos e islas de Caicos",
	"tg" => "Togo",
	"th" => "Tailandia",
	"tn" => "Tunez",
	"to" => "Tonga",
	"tp" => "Timor Del este",
	"tr" => "Turquia",
	"tt" => "Trinidad y Tobago",
	"tv" => "Tuvalu",
	"tw" => "Taiw�n",
	"tz" => "Tanzania",
	"ua" => "Ucrania",
	"ug" => "Uganda",
	"uk" => "Reino Unido",
	"us" => "Estados Unidos",
	"uy" => "Uruguay",
	"va" => "Estado De la Ciudad De Vatican (Santo Vea)",
	"ve" => "Venezuela",
	"vg" => "Islas De la Virgen (Brit�nicas)",
	"vi" => "Islas De la Virgen (los E.E.U.U..)",
	"vn" => "Vietnam",
	"ws" => "Samoa",
	"ye" => "Yemen",
	"yu" => "Yugoslavia",
	"za" => "�frica Del sur",
	"zw" => "Zimbabwe"
);

## ------------------------------ DEFINE MONTH NAMES -------------------------------- ##
$monthnames = array(
	"1" => "Enero",
	"2" => "Febrero",
	"3" => "Marzo",
	"4" => "Abril",
	"5" => "Mayo",
	"6" => "Junio",
	"7" => "Julio",
	"8" => "Agosto",
	"9" => "Septiembre",
	"10" => "Octubre",
	"11" => "Noviembre",
	"12" => "Diciembre"
);

## ----------------------------- DEFINE WEEKDAY NAMES ------------------------------- ##
$weekdaynames = array(
	"Dom",
	"Lun",
	"Mar",
	"Mie",
	"Jue",
	"Vie",
	"Sab"
);

## ------------------------------- DEFINE LANGUAGES --------------------------------- ##
$languages = array(
	"german" => "Alem�n",
	"english" => "Ingl�s",
	"french" => "Franc�s",
	"danish" => "Dan�s",
	"dutch" => "Holand�s",
	"spanish" => "Espa�ol",
	"portuguese" => "Portugu�s",
	"italian" => "Italiano",
	"hungarian" => "H�ngaro"
);

## ------------------------- DEFINE GLOBAL LANGUAGE VARS ---------------------------- ##
$str["SHOWIP"] = "Ense�ar IP";
$str["NEWCOMMENT"] = "Nuevo Comentario";
$str["ADDCOMMENT"] = "A�ade el comentario";
$str["EDITCOMMENT"] = "Corrija el comentario";
$str["DELETECOMMENT"] = "Cancela el commentario";
$str["COMMENT"] = "Comantario";
$str["COMMENTS"] = "Comentarios";
$str["ENTERCOMMENT"] = "Escriba un Comentario";
$str["BACKTOCOMMENTS"] = "Volver a los Comentarios";
$str["ADD"] = "A�adir";
$str["CLOSEWINDOW"] = "Cerrar Ventana";
$str["CLICKONSMILIETOINSERT"] = "Picha en un smilie para insertarlo";
$str["INSERTTHISSMILIE"] = "Insertar este smilie";
$str["MORE"] = "mas";
$str["PLEASECHOOSE"] = "Elija";
$str["STATISTICS"] = "Estadisticas";
$str["AVAILABLE"] = "disponible";
$str["YES"] = "Si";
$str["NO"] = "No";
$str["SHORT"] = "corto";
$str["NOTAVAILABLE"] = "No disponible";
$str["NOTAVAILABLESHORT"] = "n/d";
$str["DATE"] = "Fecha";
$str["DAY"] = "Dia";
$str["MONTH"] = "Mes";
$str["YEAR"] = "A�o";
$str["TIME"] = "Hora";
$str["OPPONENT"] = "Oponente";
$str["GAME"] = "Juego";
$str["RESULT"] = "Resultado";
$str["CURRENTLY"] = "Actualmente";
$str["SHOW"] = "Mostrar";
$str["CHALLENGEUS"] = "Retanos";
$str["LEGEND"] = "Leyenda";
$str["NAME"] = "Nombre";
$str["SERVER"] = "Server";
$str["FULL"] = "lleno";
$str["CONTACT"] = "Contacto";
$str["PLAYERS"] = "Jugadores";
$str["PLAYERPERTEAM"] = "Jugadores por equipo";
$str["LOCATIONS"] = "Mapas";
$str["LOCATION"] = "Mapa";
$str["OWNSCORES"] = "Marcador Propio";
$str["OPPSCORES"] = "Marcador Oponente";
$str["AVERAGE"] = "promedio";
$str["ADDITIONALINFO"] = "Informacion Adicional";
$str["SIGNEDMEMBERS"] = "Miembros Apuntados";
$str["MOREREQUIRED"] = "m�s necesarios";
$str["OPTIONS"] = "Opciones";
$str["SIGNUP"] = "Apuntarse";
$str["SIGNOFF"] = "Descartarse";
$str["CALENDAR"] = "Calendario";
$str["JUMPTOCURRENTMONTH"] = "Ir al mes actual";
$str["ON"] = "On";
$str["OFF"] = "Off";
$str["HTMLIS"] = "HTML est�";
$str["SMILIESARE"] = "Smilies";
$str["ARE"] = "estan";
$str["BBCODEIS"] = "bbCode";
$str["IS"] = "est�";
$str["EVENTCALENDAR"] = "Calendario de Eventos";
$str["EVENTDETAILS"] = "Informacion del Evento";
$str["BACKTOCALENDAR"] = "Volver al Calendario";
$str["ADDEDBY"] = "Enviado por";
$str["VISITHOMEPAGE"] = "Visitar web de";
$str["ADDTOCONTACTLIST"] = "A�adir a la Lista de Contactos";
$str["CLICKMEMBERPROFILE"] = "Pincha en ".makeimgtag($vwar_root . "images/button_profile.gif")." para ver el Perfil del miembro";
$str["SHOWDETAILS"] = "Mostrar informacion";
$str["GAMES"] = "Juegos";
$str["SENDMAILTO"] = "Enviar un eMail a";
$str["PROFILEOF"] = "Perfil de";
$str["PROFILELOCATION"] = "Ciudad";
$str["PROFILEBIRTHDAY"] = "Cumplea�os";
$str["PROFILEINTERESTS"] = "Intereses";
$str["PROFILEGRAPHICCARD"] = "Tarjeta grafica";
$str["PROFILECONNECTION"] = "Conexion";
$str["PROFILEKEYBOARD"] = "Teclado";
$str["PROFILEMOUSE"] = "Raton";
$str["PHONENUMBERS"] = "Telefono";
$str["ONLYVISIBLETOMEMBERS"] = "Solo visible por miembros";
$str["PHONE"] = "Telefono";
$str["CELLULARPHONE"] = "Movil";
$str["BACKTOWARLIST"] = "Volver a Lista de Combates";
$str["BACKTOMEMBERLIST"] = "Volver a Miembros";
$str["BACKTOWARDETAILS"] = "Volver a Informacion de Combates";
$str["GAMESPLAYED"] = "Partidas jugadas";
$str["SHOWALL"] = "Mostrar todo";
$str["ENTERNAME"] = "Introduzca un nombre";
$str["RESULTS"] = "Resultados";
$str["OTHERGAMESAGAINST"] = "Otros Combates contra";
$str["PAGE"] = "Pagina";
$str["SORTTHISFIELDASC"] = "Orden ascendente";
$str["SORTTHISFIELDDESC"] = "Orden descendente";
$str["ASCENDING"] = "ascendente";
$str["DESCENDING"] = "descendente";
$str["CHALLENGE"] = "Reto";
$str["GENERAL"] = "General";
$str["GAMETYPE"] = "Modo de juego";
$str["MATCHTYPE"] = "Tipo de Combate";
$str["SELECT"] = "Seleccionar";
$str["ENTERTEAMNAME"] = "Introduzca nombre del equipo";
$str["ENTERSHORTTEAMNAME"] = "Introduzca Tag del equipo";
$str["ENTERCONTACTNAME"] = "Introduzca Nombre de contacto";
$str["ENTERCONTACTEMAIL"] = "Introduzca Email de contacto";
$str["CHALLENGEFORM"] = "Formulario de Reto";
$str["TEAM"] = "Equipo";
$str["ADDITIONALINFOFULL"] = "a�adir informacion adicional aqui o cualquier cosa que considere debamos conocer adem�s de los datos aportados";
$str["SELECTASMANY"] = "Seleccione tantos como necesite";
$str["LOGGEDINAS"] = "Estas identificado como";
$str["NOTLOGGEDIN"] = "Usted no esta identificado";
$str["LOGIN"] = "Identificarse";
$str["LOGIN2"] = "Identificarse con nick y contrase�a:";
$str["LOGOUT"] = "Desconectar";
$str["DETAILS"] = "Informacion";
$str["LANGUAGE"] = "Idioma";
$str["LISTBYSTATUS"] = "Estado";
$str["LISTBYTEAMS"] = "Equipos";
$str["LISTBY"] = "Ordenar por";
$str["PICTURE"] = "Imagen";
$str["NONPUBLICDETAILS"] = "Informaci�n privada <small>(solo para miembros)</small>";
$str["FIRSTPAGE"] = "Primera Pagina";
$str["LASTPAGE"] = "Ultima Pagina";
$str["PREVIOUSPAGE"] = "Pagina Anterior";
$str["NEXTPAGE"] = "Pagina Siguiente";
$str["ALL"] = "Todo";
$str["SCORE"] = "Resultado";
$str["COUNTRY"] = "Pais";
$str["EDIT"] = "Editar";
$str["DELETE"] = "Eliminar";
$str["PERFORMDELETE"] = "�Confirmar eliminacion?";
$str["GUEST"] = "Invitado";
$str["REPORT"] = "Informe";
$str["BIRTHDAY"] = "Cumplea�os";
$str["JOINUS"] = "Unete al clan";
$str["JOINUSFORM"] = "Formulario";
$str["PERSONALDETAILS"] = "Informacion personal";
$str["JOINSUSADDITIONALINFO"] = "Indica brevemente porque quieres unirte al clan y cualquier otra informacion que nos pueda ser de interes";
$str["WEWILLCONTACTYOU"] = "Nos pondremos en contacto tan pronto como podamos";
$str["THANKSFORREQUEST"] = "Gracias";
$str["EQUIPMENT"] = "Equipo";
$str["GENERALINFORMATIONS"] = "Informaciones Generales";
$str["AGE"] = "Edad";
$str["ALLTIMESARE"] = "Todas las horas son";
$str["TIMENOWIS"] = "Ahora son las";
$str["STATUSWARS"] = "Combates sin estado";
$str["TODAYWARS"] = "Combates para Hoy";
$str["WARSSTATUS"] = "Estado<br><smallfont>(apuntados/necesarios)</smallfont>";
$str["ALLSTATUSSET"] = "Todos los combates tienen estado";
$str["OWNGAMES"] = "Partidas propias";
$str["NOENTRY"] = "�Ninguna entrada disponible!";
$str["SITEGENERATEDWITH"] = "P�gina creada con";
$str["QUERYSIN"] = "Consultas";
$str["SIMPLEMODE"] = "Modo Simple";
$str["ADVANCEDMODE"] = "Modo Avanzado";
$str["CLOSECURRENTTAG"] = "Cerrar el Tag actual";
$str["CLOSEALLTAGS"] = "Cerrar todos los Tags";
$str["FORMATTEXT"] = "Introduzca el texto a dar formato:";
$str["FORMATTEXTADDITIONAL"] = "Introduzca el texto a dar formato - ";
$str["PROMPTLINKTEXT"] = "Introduzca el texto del enlace (opcional):";
$str["PROMPTURLTEXT"] = "Introduzca la URL completa del enlace:";
$str["PROMPTMAILTEXT"] = "Introduzca la direcci�n de correo electr�nico";
$str["PROMPTLISTITEM"] = "Introduzca un art�culo de la lista.\nDeje el campo vacio o presione 'Cancelar' para terminar la lista.";
$str["SIZE"] = "tama�o";
$str["HUGE"] = "enorme";
$str["BIG"] = "grande";
$str["NORMAL"] = "normal";
$str["SMALL"] = "peque�o";
$str["FONT"] = "fuente";
$str["COLOR"] = "color";
$str["BOLDTEXT"] = "Negrita";
$str["ITALICTEXT"] = "Cursiva";
$str["UNDERLINEDTEXT"] = "Subrayado";
$str["CENTER"] = "Centrar";
$str["CREATELIST"] = "Crear una Lista";
$str["INSERTHYPERLINK"] = "Insertar un Enlace";
$str["INSERTCODE"] = "Insertar Codigo";
$str["INSERTMAIL"] = "Insertar Correo Electr�nico";
$str["INSERTQUOTE"] = "Insertar Cita";
$str["INSERTIMAGE"] = "Insertar Imagen";
$str["HELP"] = "Ayuda";
$str["CLICKONARROWTOINSERTCODE"] = "Pincha en la flecha para insertar el BB Code.<br>Usar may�sculas o min�sculas es indiferente, las URLs se transforman autom�ticamente.";
$str["PLAY"] = "jugado o a ser jugado";
$str["CANCELLED"] = "cancelado";
$str["OPPONENTLIST"] = "Lista Opuesta";
$str["MEMBERGALLERY"] = "Galer�a de los miembros";
$str["CONTACTLIST"] = "Lista del Contacto";
$str["RECEIVER"] = "Receptor";
$str["SENDERNAME"] = "Nombre del remitente";
$str["SENDERMAIL"] = "Email del remitente";
$str["SUBJECT"] = "Tema";
$str["FORMAT"] = "Formato";
$str["MESSAGE"] = "Message";
$str["CONTENT"] = "Contenido";
$str["ENTER"] = "Entre";
$str["SEND"] = "Env�e";
$str["PRIORITY"] = "Priority";
$str["BACKTONEWS"] = "De nuevo a los detalles de las news";
$str["QUOTE"] = "cotiza";
$str["BACK"] = "parte posteriora";
$str["TITLE"] = "T�tulo";
$str["NOICON"] = "Ning�n Icon";
$str["PREVIEW"] = "Preview";
$str["TOTAL"] = "Total";
$str["GUESTBOOKOF"] = "Guestbook of";
$str["FUNCTIONDISABLED"] = "Esta funci�n es <b>lisiada</b>!";
$str["GOTO"] = "Vaya&nbsp;a";
$str["PASSWORD"] = "Contrase�a";
$str["FORGOTPASSWORD"] = "Olvid� el contrase�a?";
$str["ARCHIVE"] = "Archivo";
$str["CATEGORY"] = "Categor�a";
$str["SEARCH"] = "B�squeda";
$str["ENLARGE"] = "Enlarge";
$str["PRINT"] = "Imprimir";
$str["SUBMIT"] = "Confirmar";
$str["REDIRECT"] = " Click aqu� si tu no deseas esperar m�s<br>(o si tu browser no le remite autom�ticamente)";
$str["ENTEREDREGISTEREDDATA"] = "Usted incorpor� los datos registrados (nombre, email). �Camb�elo a un valor no-registrado!";
$str["SEARCHKEYWORD"] = "Buscar para la palabra clave";
$str["SEARCHAUTHOR"] = "Buscar para un autor";
$str["MATCHEXACTNAME"] = "Entrada del nombre exacto";
$str["MATCHPARTIALNAME"] = "Entrada de un parto del nombre";
$str["USEWILDCARD"] = "Usa * como un wildcard para partos de lluegos";
$str["SEARCHOPTIONS"] = "Puedes usar <u>Y</u>, <u>O</u> y <u>NO</u> para buscar con m�s detailles";
$str["CONNECTSEARCHES"] = "Usted puede conectar la b�squeda para una palabra clave con una b�squeda para un autor";
$str["USEEXACTPHRASE"] = 'El texto entre dos "ser� buscado como frase exacta';
$str["SEARCHIN"] = "Buscar en";
$str["SEARCHFORRESULTSIN"] = "Buscar para resultados en";
$str["DISPLAYMODE"] = "Displaymode";
$str["SEARCHINTEXT"] = "Buscar en texto";
$str["SEARCHINSUBJECT"] = "Buscar en t�tulo";
$str["SHOWASOVERVIEW"] = "Ense�ar vista general";
$str["SHOWINDETAILS"] = "Ense�ar en detailles";
$str["SEARCHFORRESULTS"] = "Buscar para resultados";
$str["SORTRESULTBY"] = "Clasificar resultados por";
$str["OF"] = "de";
$str["LASTDAYS0"] = "cualquier fecha";
$str["LASTDAYS1"] = "ayer";
$str["LASTDAYS7"] = "semana pasada";
$str["LASTDAYS14"] = "�ltimo dos semanas";
$str["LASTDAYS30"] = "mes pasado";
$str["LASTDAYS90"] = "�ltimo tres meses";
$str["LASTDAYS180"] = "�ltimo seis meses";
$str["LASTDAYS365"] = "a�o pasado";
$str["AND"] = "y";
$str["NEWER"] = "m�s nuevo";
$str["OLDER"] = "m�s viejo";
$str["AUTHOR"] = "Autor";
$str["NUMLINKS"] = "N�mero de links";
$str["ADVANCEDSEARCH"] = "B�squeda Avanzada";
$str["REQUIREDFIELDS"] = 'Los campos marcados con <font color="red">*</font> sea obligatorio';
$str["OR"] = "o";
$str["LENGTHSEARCHWORD"] = "La longitud de la palabra b�squeda debe satisfacer el largo de una palabra por lo menos de 3 letras.";
$str["SEARCHINFORMATION"] = "Informaci�n De la B�squeda";
$str["NEWSCOMMENTS"] = "Comentarios de las Noticias";
$str["SENDNEWS"] = "Env�e Noticias";
$str["RECEIVERMAIL"] = "Email del receptor";
$str["MOREFUNCTION"] = "M�s functiones: <b>enabled</b><br />You puede dividir tu contenido con";
$str["SUBMITTED"] = "(confirmado)";
$str["AREYOUSURETODELETE"] = "Estas seguro desea la cancelaci�n del item seleccionado?";
$str["NORMALMODE"] = "Modo normal";
$str["LISTMODE"] = "Modo de la lista";
$str["PROMPTLISTTYPE"] = "Tipos de la lista: '1' = numerado, 'a' = letras peque�as,\n'I' = romano superior, deje el espacio en blanco= puntos de la bala";
$str["LASTEDITEDBY"] = "�ltimo correcion por";

## ---- START CUSTOM PART ---- ##
## ---- START "GB" ---- ##

$str["GB_NAME"] = "Libro de la hu�sped";

$str["GB_INFOLINE"] = "%1 %2 en %3 %4";

$str["GB_PAGE"] = "Pagina";

$str["GB_PAGES"] = "Paginas";

$str["GB_ENTRY"] = "Entrada";

$str["GB_ENTRIES"] = "Entradas";

$str["GB_ADDENTRY"] = "A�ade la entrada";

$str["GB_ADDANENTRY"] = "A�ade un entrada al libro de la hu�sped";

$str["GB_EDITANENTRY"] = "Corrija un entrada";

$str["GB_EDITENTRY"] = "Corrija la entrada";

$str["GB_BACKTOGB"] = "De nuevo al libro de la hu�sped";

$str["GB_WARNINGNAME"] = "Incorpore por favor un nombre!";

$str["GB_WARNINGTEXT"] = "Incorpore por favor un texto!";

$str["GB_ADDNAME"] = "Nombre";

$str["GB_ADDEMAIL"] = "eMail";

$str["GB_ADDHOMEPAGE"] = "Homepage";

$str["GB_ADDICQ"] = "ICQ-UIN";

$str["GB_ADDAIM"] = "AIM";

$str["GB_ADDYIM"] = "YIM";

$str["GB_ADDMSN"] = "MSN";

$str["GB_TITLE"] = "T�tulo";

$str["GB_BLOCKED"] = "Ya has escrito una entrada en el �ltimo <b>%1 %2</b>.";

$str["GB_MINUTE"] = "Minuto";

$str["GB_MINUTES"] = "Minutos";

$str["GB_COMMENT"] = "Commentario";

$str["GB_COMMENTS"] = "Commentarios";

$str["GB_ENTRYBY"] = "Entrada en el libro de la hu�sped de";

## ---- END "GB" ---- ##
## ---- START "SPONSOR" ---- ##
$str["SPONSOR_CATEGORY"] = "Category";
$str["SPONSOR_SEARCH"] = "Search Sponsor";
$str["SPONSOR_NAME"] = "Links";
$str["SPONSOR_HITS"] = "Hits";
$str["SPONSOR_LANGUAGE"] = "Language";
$str["SPONSOR_OPTION"] = "Options";
$str["SPONSOR_DETAILS"] = "Details";
$str["SPONSOR_REDIRECT"] = "Click here if you do not want to wait any longer (or if your browser does not automatically forward you)";
$str["SPONSOR_LINKNAME"] = "Sponsorname";
$str["SPONSOR_HOMEPAGE"] = "Website";
$str["SPONSOR_DESCRIPTION"] = "Sponsor Description";
$str["SPONSOR_BACK"] = "Back";
$str["SPONSOR_BANNERURL"] = "Banner URL is incorrect";
$str["SPONSOR_BANNERNOT"] = "No Banner available";
## ---- END "SPONSOR" ---- ##

## ---- START "SEX" ---- ##
$sex_array = array(
	"me" => "Men",
	"wo" => "Women",
	"no" => "No comment",
);
$str["SEX"] = "Sex";
## ---- END "SEX" ---- ##
$str["WARTAG"]="War Tag";
## ---- END CUSTOM PART ---- ##
?>
