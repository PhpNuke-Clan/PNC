<?php //vwar
/* #####################################################################################
 *
 * $Id: danish.inc.php,v 1.20 2004/03/14 20:22:10 mabu Exp $
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
	"af" => "Afghanistan",
	"al" => "Albanien",
	"am" => "Armenien",
	"an" => "Netherlands Antilles",
	"ao" => "Angola",
	"ar" => "Argentina",
	"at" => "&Oslash;strig",
	"au" => "Australien",
	"aw" => "Aruba",
	"az" => "Azerbadjan",
	"ba" => "Bosnien og Herzegovina",
	"bb" => "Barbados",
	"bd" => "Bangladesh",
	"be" => "Belgien",
	"bf" => "Burkina Faso",
	"bg" => "Bulgarien",
	"bh" => "Bahrain",
	"bi" => "Burundi",
	"bj" => "Benin",
	"bm" => "Bermuda",
	"bn" => "Brunei Darussalam",
	"bo" => "Bolivia",
	"br" => "Brazilien",
	"bs" => "Bahamas",
	"bt" => "Bhutan",
	"bw" => "Botswana",
	"bx" => "Benelux",
	"by" => "Belarus",
	"bz" => "Belize",
	"ca" => "Canada",
	"cf" => "Central Afrikanske Republik",
	"cg" => "Congo",
	"ch" => "Schweiz",
	"ci" => "Cote D'Ivoire (Elfenbenskysten)",
	"ck" => "Cook Islands",
	"cm" => "Cameroon",
	"cn" => "Kina",
	"co" => "Colombia",
	"cr" => "Costa Rica",
	"cu" => "Cuba",
	"cv" => "Cape Verde",
	"cy" => "Cypern",
	"cz" => "Tjekkiet",
	"de" => "Tyskland",
	"dk" => "Danmark",
	"dz" => "Algeriet",
	"ec" => "Ecuador",
	"ee" => "Estonien",
	"eg" => "Egypten",
	"er" => "Eritrea",
	"es" => "Spainien",
	"et" => "Ethiopien",
	"eu" => "Europa",
	"fi" => "Finland",
	"fj" => "Fiji",
	"fo" => "F&aelig;r&oslash;erne",
	"fr" => "Frankrig",
	"ga" => "Gabon",
	"ge" => "Georgien",
	"gi" => "Gibraltar",
	"gl" => "Gr&oslash;nland",
	"gp" => "Guadeloupe",
	"gr" => "Gr&aelig;kenland",
	"gt" => "Guatemala",
	"gu" => "Guam",
	"gy" => "Guyana",
	"hk" => "Hong Kong",
	"hr" => "Kroatien",
	"ht" => "Haiti",
	"hu" => "Ungarn",
	"id" => "Indonesien",
	"ie" => "Irland",
	"il" => "Israel",
	"in" => "Indien",
	"int" => "International",
	"iq" => "Irak",
	"ir" => "Iran",
	"is" => "Island",
	"it" => "Italien",
	"jm" => "Jamaica",
	"jo" => "Jordan",
	"jp" => "Japan",
	"ke" => "Kenya",
	"kg" => "Kyrgyzstan",
	"kh" => "Cambodia",
	"ki" => "Kiribati",
	"kp" => "Korea (Nord)",
	"kr" => "Korea",
	"ky" => "Cayman&oslash;erne ",
	"kz" => "Kazakhstan",
	"lb" => "Lebanon",
	"lc" => "Saint Lucia",
	"li" => "Liechtenstein",
	"lk" => "Sri Lanka",
	"lt" => "Lithauen",
	"lu" => "Luxembourg",
	"lv" => "Letland",
	"ly" => "Libyen",
	"ma" => "Marrokko",
	"mc" => "Monaco",
	"md" => "Moldavien",
	"mg" => "Madagascar",
	"mn" => "Mongoliet",
	"mo" => "Macau",
	"mp" => "Northern Mariana Islands",
	"ms" => "Montserrat",
	"mt" => "Malta",
	"mx" => "Mexico",
	"my" => "Malaysia",
	"mz" => "Mozambique",
	"na" => "Namibia",
	"nc" => "Ny Kaledonien",
	"nf" => "Norfolk Island",
	"nl" => "Holland",
	"no" => "Norge",
	"np" => "Nepal",
	"nr" => "Nauru",
	"nz" => "New Zealand",
	"om" => "Oman",
	"pa" => "Panama",
	"pe" => "Peru",
	"pf" => "Fransk Polynesien",
	"ph" => "Fillipinerne",
	"pk" => "Pakistan",
	"pl" => "Polen",
	"pm" => "St. Pierre and Miquelon",
	"pr" => "Puerto Rico",
	"pt" => "Portugal",
	"py" => "Paraguay",
	"qa" => "Qatar",
	"ro" => "Rum&aelig;nien",
	"ru" => "Rusland",
	"sa" => "Saudi Arabien",
	"sb" => "Solomon Islands",
	"sca" => "Skandinavien",
	"sd" => "Sudan",
	"se" => "Sverige",
	"sg" => "Singapore",
	"si" => "Slovenien",
	"sk" => "Slovakiet",
	"sl" => "Sierra Leone",
	"so" => "Somalia",
	"tc" => "Turks and Caicos Islands",
	"tg" => "Togo",
	"th" => "Thailand",
	"tn" => "Tunesien",
	"to" => "Tonga",
	"tp" => "&oslash;st Timor",
	"tr" => "Tyrkiet",
	"tt" => "Trinidad and Tobago",
	"tv" => "Tuvalu",
	"tw" => "Taiwan",
	"tz" => "Tanzania",
	"ua" => "Ukraine",
	"ug" => "Uganda",
	"uk" => "England",
	"us" => "USA",
	"uy" => "Uruguay",
	"va" => "Vatikanet (Holy See)",
	"ve" => "Venezuela",
	"vg" => "Jomfru&oslash;erne (Engelsk)",
	"vi" => "Jomfru&oslash;erne (U.S.)",
	"vn" => "Vietnam",
	"ws" => "Samoa",
	"ye" => "Yemen",
	"yu" => "Jugoslavien",
	"za" => "Syd Afrika",
	"zw" => "Zimbabwe"
);

## ------------------------------ DEFINE MONTH NAMES -------------------------------- ##
$monthnames = array(
	"1" => "Januar",
	"2" => "Februar",
	"3" => "Marts",
	"4" => "April",
	"5" => "Maj",
	"6" => "Juni",
	"7" => "Juli",
	"8" => "August",
	"9" => "September",
	"10" => "Oktober",
	"11" => "November",
	"12" => "December"
);

## ----------------------------- DEFINE WEEKDAY NAMES ------------------------------- ##
$weekdaynames = array(
	"S�",
	"Ma",
	"Ti",
	"On",
	"To",
	"Fr",
	"L�"
);

## ------------------------------- DEFINE LANGUAGES --------------------------------- ##
$languages = array(
	"german" => "Tysk",
	"english" => "Engelsk",
	"french" => "Fransk",
	"danish" => "Dansk",
	"dutch" => "Hollansk",
	"spanish" => "Spansk",
	"portuguese" => "Portuguese",
	"italian" => "Italiensk",
	"hungarian" => "Ungarer"
);

## ------------------------- DEFINE GLOBAL LANGUAGE VARS ---------------------------- ##
$str["SHOWIP"] = "Vis IP";
$str["NEWCOMMENT"] = "Ny kommentar";
$str["ADDCOMMENT"] = "Tilf�j kommentar";
$str["EDITCOMMENT"] = "Rediger kommentar";
$str["DELETECOMMENT"] = "Slet Kommentar";
$str["COMMENT"] = "Kommentar";
$str["COMMENTS"] = "Kommentarer";
$str["ENTERCOMMENT"] = "Skriv kommentar";
$str["BACKTOCOMMENTS"] = "Tilbage til kommentarer";
$str["ADD"] = "Tilf�j";
$str["CLOSEWINDOW"] = "Luk vindue";
$str["CLICKONSMILIETOINSERT"] = "Klik p� en smiley for at indst�tte";
$str["INSERTTHISSMILIE"] = "Inds�t Smiley";
$str["MORE"] = "mere";
$str["PLEASECHOOSE"] = "V�lg venligst";
$str["STATISTICS"] = "Statistik";
$str["AVAILABLE"] = "Tilmeldt";
$str["YES"] = "Ja";
$str["NO"] = "Nej";
$str["SHORT"] = "kort";
$str["NOTAVAILABLE"] = "ikke tilg�ngelig";
$str["NOTAVAILABLESHORT"] = "n/a";
$str["DATE"] = "Dato";
$str["DAY"] = "Dag";
$str["MONTH"] = "M�ned";
$str["YEAR"] = "�r";
$str["TIME"] = "Tid";
$str["OPPONENT"] = "Modstander";
$str["GAME"] = "Spil";
$str["RESULT"] = "Resultat";
$str["CURRENTLY"] = "For �jeblikket har vi";
$str["SHOW"] = "Vis";
$str["CHALLENGEUS"] = "Udfordre os";
$str["LEGEND"] = "Betydning";
$str["NAME"] = "Navn";
$str["SERVER"] = "Server";
$str["FULL"] = "fuld";
$str["CONTACT"] = "Kontakt";
$str["PLAYERS"] = "Spillere";
$str["PLAYERPERTEAM"] = "Spillere per Hold";
$str["LOCATIONS"] = "Maps";
$str["LOCATION"] = "Map";
$str["OWNSCORES"] = "Egne resultater";
$str["OPPSCORES"] = "Modstanders resultater";
$str["AVERAGE"] = "gennemsnit";
$str["ADDITIONALINFO"] = "Yderligere Info";
$str["SIGNEDMEMBERS"] = "Tilmeldte medlemmer";
$str["MOREREQUIRED"] = "Mangler";
$str["OPTIONS"] = "Valg";
$str["SIGNUP"] = "Tilmeld/Afmeld";
$str["SIGNOFF"] = "Fjern fra listen";
$str["CALENDAR"] = "Kalender";
$str["JUMPTOCURRENTMONTH"] = "G� til nuv�rende m�ned";
$str["ON"] = "Til";
$str["OFF"] = "Fra";
$str["HTMLIS"] = "HTML er";
$str["SMILIES"] = "Smileys";
$str["ARE"] = "er";
$str["BBCODE"] = "bbCode";
$str["IS"] = "er";
$str["EVENTCALENDAR"] = "Event Kalender";
$str["EVENTDETAILS"] = "Event Detaljer";
$str["BACKTOCALENDAR"] = "Tilbage til kalenderen";
$str["ADDEDBY"] = "Tilf�jet af";
$str["VISITHOMEPAGE"] = "Bes�g hjemmesiden som tilh�rer";
$str["ADDTOCONTACTLIST"] = "Tilf�j til kontaktliste";
$str["CLICKMEMBERPROFILE"] = "Klik p� ".makeimgtag($vwar_root . "images/button_profile.gif")." for at se medlemsprofilen";
$str["SHOWDETAILS"] = "Vis detaljer";
$str["GAMES"] = "Spil";
$str["SENDMAILTO"] = "Send en eMail til";
$str["PROFILEOF"] = "Profilen som tilh�rer";
$str["PROFILELOCATION"] = "Landsdel";
$str["PROFILEBIRTHDAY"] = "F�dselsdag";
$str["PROFILEINTERESTS"] = "Interesser";
$str["PROFILEGRAPHICCARD"] = "Grafikkort";
$str["PROFILECONNECTION"] = "Internetforbindelse";
$str["PROFILEKEYBOARD"] = "Keyboard";
$str["PROFILEMOUSE"] = "Mus";
$str["PHONENUMBERS"] = "Telefonnummer";
$str["ONLYVISIBLETOMEMBERS"] = "Kun synligt for medlemmer";
$str["PHONE"] = "Telefon";
$str["CELLULARPHONE"] = "Mobiltelefon";
$str["BACKTOWARLIST"] = "Tilbage til Kamplisten";
$str["BACKTOMEMBERLIST"] = "Tilbage til Medlemslisten";
$str["BACKTOWARDETAILS"] = "Tilbage til Kampdetaljer";
$str["GAMESPLAYED"] = "Spillede kampe";
$str["SHOWALL"] = "Vis alle";
$str["ENTERNAME"] = "Skriv navn";
$str["RESULTS"] = "Resultater";
$str["OTHERGAMESAGAINST"] = "Andre kampe imod";
$str["PAGE"] = "Side";
$str["SORTTHISFIELDASC"] = "Sort�r dette felt stigende";
$str["SORTTHISFIELDDESC"] = "Sort�r dette felt faldende";
$str["ASCENDING"] = "stigende";
$str["DESCENDING"] = "faldende";
$str["CHALLENGE"] = "Udfordre";
$str["GENERAL"] = "Generelt";
$str["GAMETYPE"] = "Spiltype";
$str["MATCHTYPE"] = "Kamptype";
$str["SELECT"] = "V�lg";
$str["ENTERTEAMNAME"] = "Skriv klanens navn";
$str["ENTERSHORTTEAMNAME"] = "Skriv klanens tag";
$str["ENTERCONTACTNAME"] = "Skriv Kontaktperson";
$str["ENTERCONTACTEMAIL"] = "Skriv Kontaktemail";
$str["CHALLENGEFORM"] = "Udfordrings Blanket";
$str["TEAM"] = "Hold";
$str["ADDITIONALINFOFULL"] = "Tilf�j yderligere info her (F.eks. speciel ops�tning) eller hvad du ellers mener vi burde vide udover de allerede angivne data";
$str["SELECTASMANY"] = "V�lg s� mange du har brug for";
$str["LOGGEDINAS"] = "Du er logget ind som";
$str["NOTLOGGEDIN"] = "Du er ikke logget ind";
$str["LOGIN"] = "Log ind";
$str["LOGIN2"] = "Log ind med brugernavn og kodeord:";
$str["LOGOUT"] = "Log ud";
$str["DETAILS"] = "Detaljer";
$str["LANGUAGE"] = "Sprog";
$str["LISTBYSTATUS"] = "Medlemsstatus";
$str["LISTBYTEAMS"] = "Holdnavn";
$str["LISTBY"] = "Vis efter";
$str["PICTURE"] = "Billede";
$str["NONPUBLICDETAILS"] = "Ikke-offentlige Detaljer <small>(Kun synlige for medlemmer)</small>";
$str["FIRSTPAGE"] = "F�rste Side";
$str["LASTPAGE"] = "Sidste Side";
$str["PREVIOUSPAGE"] = "Forrige Side";
$str["NEXTPAGE"] = "N�ste Side";
$str["ALL"] = "Alle";
$str["SCORE"] = "Score";
$str["COUNTRY"] = "Land";
$str["EDIT"] = "Redig�r";
$str["DELETE"] = "Slet";
$str["PERFORMDELETE"] = "Udf�r sletning ?";
$str["GUEST"] = "G�st";
$str["REPORT"] = "Rapport";
$str["BIRTHDAY"] = "F�dselsdag";
$str["JOINUS"] = "Join os";
$str["JOINUSFORM"] = "Ans�gnings Blanket";
$str["PERSONALDETAILS"] = "Personlige Detaljer";
$str["JOINSUSADDITIONALINFO"] = "Skriv kort hvorfor du vil joine os samt yderligere informationer som du mener der kunne interessere os!";
$str["WEWILLCONTACTYOU"] = "Vi vil kontakte dig hurtigst muligt";
$str["THANKSFORREQUEST"] = "Tak for din ans�gning";
$str["EQUIPMENT"] = "Udstyr";
$str["GENERALINFORMATIONS"] = "Generel Information";
$str["AGE"] = "Alder";
$str["ALLTIMESARE"] = "Alle tider er i";
$str["TIMENOWIS"] = "Klokken er nu";
$str["STATUSWARS"] = "Kampe uden status";
$str["TODAYWARS"] = "Dagens kampe";
$str["WARSSTATUS"] = "Status<br><smallfont>(tilmeldte/mangler)</smallfont>";
$str["ALLSTATUSSET"] = "Status er sat p� alle kampe";
$str["OWNGAMES"] = "Egne spil";
$str["NOENTRY"] = "Ingen kampe idag";
$str["SITEGENERATEDWITH"] = "Siden er udf�rt med";
$str["QUERYSIN"] = "Foresp�rgsler p�";
$str["SIMPLEMODE"] = "Simpelt Layout";
$str["ADVANCEDMODE"] = "Avanceret Layout";
$str["CLOSECURRENTTAG"] = "Luk nuv�rende m�rke";
$str["CLOSEALLTAGS"] = "Luk alle m�rker";
$str["FORMATTEXT"] = "Skriv teksten du �nsker at formatere:";
$str["FORMATTEXTADDITIONAL"] = "Skriv teksten du �nsker at formatere - ";
$str["PROMPTLINKTEXT"] = "Skriv teksten som skal vises for linket (valgfrit):";
$str["PROMPTURLTEXT"] = "Skriv den fulde adresse for linket:";
$str["PROMPTMAILTEXT"] = "Skriv e-mail adressen for linket";
$str["PROMPTLISTITEM"] = "Inds�t en ting i listen.\nEfterlad boksen tom eller tryk 'Fortryd' for at f�rdigg�re listen.";
$str["SIZE"] = "st�rrelse";
$str["HUGE"] = "k�mpe";
$str["BIG"] = "stor";
$str["NORMAL"] = "normal";
$str["SMALL"] = "lille";
$str["FONT"] = "skrift";
$str["COLOR"] = "farve";
$str["BOLDTEXT"] = "Fed Tekst";
$str["ITALICTEXT"] = "Kursiv Tekst";
$str["UNDERLINEDTEXT"] = "Understreget Tekst";
$str["CENTER"] = "Centrer";
$str["CREATELIST"] = "Lav en liste";
$str["INSERTHYPERLINK"] = "Inds�t et link";
$str["INSERTCODE"] = "Inds�t en kode";
$str["INSERTMAIL"] = "Inds�t en E-Mail Adresse";
$str["INSERTQUOTE"] = "Inds�t en Note";
$str["INSERTIMAGE"] = "Inds�t et Billede";
$str["HELP"] = "Hj�lp";
$str["CLICKONARROWTOINSERTCODE"] = "Klik p� pilen for at inds�tte BB Koden.<br>Sm� og Store Bogstaver er ligemeget, Hjemmeside adresser bliver indsat automatisk.";
$str["PLAY"] = "spillet eller skal spilles";
$str["CANCELLED"] = "aflyst";
$str["OPPONENTLIST"] = "Modstander Liste";
$str["MEMBERGALLERY"] = "Medlems Galleri";
$str["CONTACTLIST"] = "Kontaktliste";
$str["RECEIVER"] = "Modtager";
$str["SENDERNAME"] = "Afsenders Navn";
$str["SENDERMAIL"] = "Afsenders eMail";
$str["SUBJECT"] = "Emne";
$str["FORMAT"] = "Format";
$str["MESSAGE"] = "Besked";
$str["CONTENT"] = "Indhold";
$str["ENTER"] = "Enter";
$str["SEND"] = "Send";
$str["PRIORITY"] = "Prioritet";
$str["BACKTONEWS"] = "Tilbage til Nyhedsdetaljer";
$str["QUOTE"] = "Note";
$str["BACK"] = "tilbage";
$str["TITLE"] = "Titel";
$str["NOICON"] = "Ingen Ikon";
$str["PREVIEW"] = "Preview";
$str["TOTAL"] = "Total";
$str["GUESTBOOKOF"] = "G�stebog af";
$str["FUNCTIONDISABLED"] = "Denne funktion er <b>disabled</b>!";
$str["GOTO"] = "G�&nbsp;til";
$str["PASSWORD"] = "Password";
$str["FORGOTPASSWORD"] = "Glemt Password?";
$str["ARCHIVE"] = "Arkiv";
$str["CATEGORY"] = "Kategori";
$str["SEARCH"] = "S�g";
$str["ENLARGE"] = "Forst�r";
$str["PRINT"] = "Print";
$str["SUBMIT"] = "Tilf�j";
$str["REDIRECT"] = "Klik her hvis du ikke vil vente l�ngere<br>(eller hvis din browser ikke automatisk sender dig videre)";
$str["ENTEREDREGISTEREDDATA"] = "Du har indtastet registreret data(Navn, E-Mail). �ndre det til en ikke-registreret v�rdi!";
$str["SEARCHKEYWORD"] = "S�g efter n�gleord";
$str["SEARCHAUTHOR"] = "S�g efter forfatter";
$str["MATCHEXACTNAME"] = "Match specifikt navn";
$str["MATCHPARTIALNAME"] = "Match delvist navn";
$str["USEWILDCARD"] = "Brug * som en joker for delvis match";
$str["SEARCHOPTIONS"] = "Du kan bruge <u>AND</u>, <u>OR</u> og <u>NOT</u> til at s�ge mere detaljeret";
$str["CONNECTSEARCHES"] = "Du kan kombinere s�gningen efter et n�gleord med en s�gning efter en forfatter";
$str["USEEXACTPHRASE"] = 'Tekst mellem to " vil blive s�gt efter som en pr�cis frase';
$str["SEARCHIN"] = "S�g i";
$str["SEARCHFORRESULTSIN"] = "S�g efter resultater i";
$str["DISPLAYMODE"] = "Displaymode";
$str["SEARCHINTEXT"] = "S�g i tekst";
$str["SEARCHINSUBJECT"] = "S�g i emne";
$str["SHOWASOVERVIEW"] = "Vis overordnet";
$str["SHOWINDETAILS"] = "Vis i detaljer";
$str["SEARCHFORRESULTS"] = "S�g efter resultater";
$str["SORTRESULTBY"] = "Sorter resultater efter";
$str["OF"] = "af";
$str["LASTDAYS0"] = "alle datoer";
$str["LASTDAYS1"] = "ig�r";
$str["LASTDAYS7"] = "sidste uge";
$str["LASTDAYS14"] = "sidste to uger";
$str["LASTDAYS30"] = "sidste m�ned";
$str["LASTDAYS90"] = "sidste tre m�neder";
$str["LASTDAYS180"] = "sidste seks m�neder";
$str["LASTDAYS365"] = "sidste �r";
$str["AND"] = "og";
$str["NEWER"] = "nyere";
$str["OLDER"] = "�ldre";
$str["AUTHOR"] = "Forfatter";
$str["NUMLINKS"] = "Antal links";
$str["ADVANCEDSEARCH"] = "Avanceret s�gning";
$str["REQUIREDFIELDS"] = 'Felter markeret med <font color="red">*</font> skal udfyldes';
$str["OR"] = "eller";
$str["LENGTHSEARCHWORD"] = "L�ngden p� s�geordet skal v�re p� minimum 3 tegn.";
$str["SEARCHINFORMATION"] = "S�gnings Information";
$str["NEWSCOMMENTS"] = "Nyheds Kommentar";
$str["SENDNEWS"] = "Send Nyhed";
$str["RECEIVERMAIL"] = "Modtager E-Mail";
$str["MOREFUNCTION"] = "More-Funktion: <b>enabled</b><br>Du kan dele dit indhold op med";
$str["SUBMITTED"] = "(tilf�jet)";
$str["AREYOUSURETODELETE"] = "Er du sikker p� at du vil slette det markerede?";
$str["NORMALMODE"] = "Normal Mode";
$str["LISTMODE"] = "List Mode";
$str["PROMPTLISTTYPE"] = "Listtypes: '1' = numbered, 'a' = small letters,\n'I' = upper roman, leave blank = bullet points";
$str["LASTEDITEDBY"] = "Last edited by";

## ---- START CUSTOM PART ---- ##
## ---- START "GB" ---- ##

$str["GB_NAME"] = "G�stebog";

$str["GB_INFOLINE"] = "%1 %2 p� %3 %4";

$str["GB_PAGE"] = "Side";

$str["GB_PAGES"] = "Sider";

$str["GB_ENTRY"] = "Indl�g";

$str["GB_ENTRIES"] = "Indl�g";

$str["GB_ADDENTRY"] = "Tilf�j Indl�g";

$str["GB_ADDANENTRY"] = "Tilf�j et indl�g til g�stebogen";

$str["GB_EDITANENTRY"] = "Rediger et indl�g";

$str["GB_EDITENTRY"] = "Rediger Indl�g";

$str["GB_BACKTOGB"] = "Tilbage til G�stebog";

$str["GB_WARNINGNAME"] = "Indtast venligst et navn!";

$str["GB_WARNINGTEXT"] = "Indtast venligst en tekst!";

$str["GB_ADDNAME"] = "Navn";

$str["GB_ADDEMAIL"] = "eMail";

$str["GB_ADDHOMEPAGE"] = "Hjemmeside";

$str["GB_ADDICQ"] = "ICQ-UIN";

$str["GB_ADDAIM"] = "AIM";

$str["GB_ADDYIM"] = "YIM";

$str["GB_ADDMSN"] = "MSN";

$str["GB_TITLE"] = "Titel";

$str["GB_BLOCKED"] = "Du har allerede lavet et indl�g indenfor de sidste <b>%1 %2</b>.";

$str["GB_MINUTE"] = "Minut";

$str["GB_MINUTES"] = "Minutter";

$str["GB_COMMENT"] = "Kommentar";

$str["GB_COMMENTS"] = "Kommentarer";

$str["GB_ENTRYBY"] = "G�stebogs indl�g af";

## ---- END "GB" ---- ##
## ---- START "SPONSOR" ---- ##
$str["SPONSOR_CATEGORY"] = "Kategori";
$str["SPONSOR_SEARCH"] = "S�g Sponsor";
$str["SPONSOR_NAME"] = "Links";
$str["SPONSOR_HITS"] = "Hits";
$str["SPONSOR_LANGUAGE"] = "Sprog";
$str["SPONSOR_OPTION"] = "Valgmuligheder";
$str["SPONSOR_DETAILS"] = "Detaljer";
$str["SPONSOR_REDIRECT"] = "Klik her hvis du ikke vil vente mere (eller hvis din browser ikke automatisk vidersender dig)";
$str["SPONSOR_LINKNAME"] = "Sponsornavn";
$str["SPONSOR_HOMEPAGE"] = "Hjemmeside";
$str["SPONSOR_DESCRIPTION"] = "Sponsor Beskrivelse";
$str["SPONSOR_BACK"] = "Tilbage";
$str["SPONSOR_BANNERURL"] = "Banner URL er inkorrekt";
$str["SPONSOR_BANNERNOT"] = "Intet Banner tilg�ngeligt";
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
