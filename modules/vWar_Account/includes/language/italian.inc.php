<?php //vwar
/* #####################################################################################
 *
 * $Id: italian.inc.php,v 1.10 2004/03/14 20:22:10 mabu Exp $
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
	"al" => "Albania",
	"am" => "Armenia",
	"an" => "Antille Olandesi",
	"ao" => "Angola",
	"ar" => "Argentina",
	"at" => "Austria",
	"au" => "Australia",
	"aw" => "Aruba",
	"az" => "Azerbaijan",
	"ba" => "Bosnia and herzegowina",
	"bb" => "Barbados",
	"bd" => "Bangladesh",
	"be" => "Belgio",
	"bf" => "Burkina Faso",
	"bg" => "Bulgaria",
	"bh" => "Bahrain",
	"bi" => "Burundi",
	"bj" => "Benin",
	"bm" => "Bermuda",
	"bn" => "Brunei Darussalam",
	"bo" => "Bolivia",
	"br" => "Brasile",
	"bs" => "Bahamas",
	"bt" => "Bhutan",
	"bw" => "Botswana",
	"bx" => "Benelux",
	"by" => "Belarus",
	"bz" => "Belize",
	"ca" => "Canada",
	"cf" => "Repubblica dell'africa centrale",
	"cg" => "Congo",
	"ch" => "Svizzera",
	"ci" => "Costa D'Avorio (Ivory Coast)",
	"ck" => "Cook Islands",
	"cm" => "Camerun",
	"cn" => "Cina",
	"co" => "Colombia",
	"cr" => "Costa Rica",
	"cu" => "Cuba",
	"cv" => "Cape Verde",
	"cy" => "Cipro",
	"cz" => "Repubblica Ceca",
	"de" => "Germania",
	"dk" => "Danimarca",
	"dz" => "Algeria",
	"ec" => "Ecuador",
	"ee" => "Estonia",
	"eg" => "Egitto",
	"er" => "Eritrea",
	"es" => "Spagna",
	"et" => "Ethiopia",
	"eu" => "Europa",
	"fi" => "Finlandia",
	"fj" => "Fiji",
	"fo" => "Faroe Islands",
	"fr" => "Francia",
	"ga" => "Gabon",
	"ge" => "Georgia",
	"gi" => "Gibraltar",
	"gl" => "Greenland",
	"gp" => "Guadeloupe",
	"gr" => "Grecia",
	"gt" => "Guatemala",
	"gu" => "Guam",
	"gy" => "Guyana",
	"hk" => "Hong Kong",
	"hr" => "Croatzia",
	"ht" => "Haiti",
	"hu" => "Hungaria",
	"id" => "Indonesia",
	"ie" => "Irlanda",
	"il" => "Israele",
	"in" => "India",
	"int" => "Internazionale",
	"iq" => "Iraq",
	"ir" => "Iran",
	"is" => "Iceland",
	"it" => "Italia",
	"jm" => "Jamaica",
	"jo" => "Jordan",
	"jp" => "Giappone",
	"ke" => "Kenya",
	"kg" => "Kyrgyzstan",
	"kh" => "Cambogia",
	"ki" => "Kiribati",
	"kp" => "Korea (Nord)",
	"kr" => "Repubblica Koreana",
	"ky" => "Isole Cayman",
	"kz" => "Kazakhstan",
	"lb" => "Lebanon",
	"lc" => "Saint Lucia",
	"li" => "Liechtenstein",
	"lk" => "Sri Lanka",
	"lt" => "Lituania",
	"lu" => "Lussemburgo",
	"lv" => "Latvia",
	"ly" => "Libia",
	"ma" => "Marocco",
	"mc" => "Monaco",
	"md" => "Republic di moldova",
	"mg" => "Madagascar",
	"mn" => "Mongolia",
	"mo" => "Macau",
	"mp" => "Northern Mariana Islands",
	"ms" => "Montserrat",
	"mt" => "Malta",
	"mx" => "Messico",
	"my" => "Malesia",
	"mz" => "Mozambico",
	"na" => "Namibia",
	"nc" => "New Caledonia",
	"nf" => "Norfolk Island",
	"nl" => "Olanda",
	"no" => "Norvegia",
	"np" => "Nepal",
	"nr" => "Nauru",
	"nz" => "New zealand",
	"om" => "Oman",
	"pa" => "Panama",
	"pe" => "Peru",
	"pf" => "French Polynesia",
	"ph" => "Philippines",
	"pk" => "Pakistan",
	"pl" => "Polonia",
	"pm" => "St. Pierre and Miquelon",
	"pr" => "Puerto Rico",
	"pt" => "Portogallo",
	"py" => "Paraguay",
	"qa" => "Qatar",
	"ro" => "Romania",
	"ru" => "Federazione Russa",
	"sa" => "Saudi arabia",
	"sb" => "Solomon Islands",
	"sca" => "Scandinavia",
	"sd" => "Sudan",
	"se" => "Svezia",
	"sg" => "Singapore",
	"si" => "Slovenia",
	"sk" => "Slovacchia (repubblica slovacca)",
	"sl" => "Sierra Leone",
	"so" => "Somalia",
	"tc" => "Turks and Caicos Islands",
	"tg" => "Togo",
	"th" => "Thailand",
	"tn" => "Tunisia",
	"to" => "Tonga",
	"tp" => "East Timor",
	"tr" => "Turchia",
	"tt" => "Trinidad and Tobago",
	"tv" => "Tuvalu",
	"tw" => "Taiwan",
	"tz" => "Tanzania",
	"ua" => "Ucraina",
	"ug" => "Uganda",
	"uk" => "Inghilterra",
	"us" => "America",
	"uy" => "Uruguay",
	"va" => "Città del vaticano (Holy See)",
	"ve" => "Venezuela",
	"vg" => "Virgin Islands (British)",
	"vi" => "Virgin Islands (U.S.)",
	"vn" => "Viet Nam",
	"ws" => "Samoa",
	"ye" => "Yemen",
	"yu" => "Yugoslavia",
	"za" => "South Africa",
	"zw" => "Zimbabwe"
);

## ------------------------------ DEFINE MONTH NAMES -------------------------------- ##
$monthnames = array(
	"1" => "Gennaio",
	"2" => "Febbraio",
	"3" => "Marzo",
	"4" => "Aprile",
	"5" => "Maggio",
	"6" => "Giugno",
	"7" => "Luglio",
	"8" => "Agosto",
	"9" => "Settmbre",
	"10" => "Ottobre",
	"11" => "Novembre",
	"12" => "Dicembre"
);

## ----------------------------- DEFINE WEEKDAY NAMES ------------------------------- ##
$weekdaynames = array(
	"Dom",
	"Lun",
	"Mar",
	"Mer",
	"Gio",
	"Ven",
	"Sab"
);

## ------------------------------- DEFINE LANGUAGES --------------------------------- ##
$languages = array(
	"german" => "Tedesco",
	"english" => "Inglese",
	"french" => "Francese",
	"danish" => "Danese",
	"dutch" => "Olandese",
	"spanish" => "Spagnolo",
	"portuguese" => "Portoghese",
	"italian" => "Italiano",
	"hungarian" => "Ungherese"
);

## ------------------------- DEFINE GLOBAL LANGUAGE VARS ---------------------------- ##
$str["SHOWIP"] = "Mostra IP";
$str["NEWCOMMENT"] = "Nuovi Commenti";
$str["ADDCOMMENT"] = "Aggiungi Commento";
$str["EDITCOMMENT"] = "Modifica Commento";
$str["DELETECOMMENT"] = "Cancella Commento";
$str["COMMENT"] = "Commento";
$str["COMMENTS"] = "Commenti";
$str["ENTERCOMMENT"] = "Per piacere, inserisci un commento";
$str["BACKTOCOMMENTS"] = "Torna ai commenti";
$str["ADD"] = "Aggiungi";
$str["CLOSEWINDOW"] = "Chiudi la finestra";
$str["CLICKONSMILIETOINSERT"] = "Clicca su uno Smile per inserirlo";
$str["INSERTTHISSMILIE"] = "Inserisci questo Smile";
$str["MORE"] = "Di più";
$str["PLEASECHOOSE"] = "Per piacere, scegli";
$str["STATISTICS"] = "Statistiche";
$str["AVAILABLE"] = "disponibilie";
$str["YES"] = "Si";
$str["NO"] = "No";
$str["SHORT"] = "corto";
$str["NOTAVAILABLE"] = "non disponibile";
$str["NOTAVAILABLESHORT"] = "n/d";
$str["DATE"] = "Data";
$str["DAY"] = "Giorno";
$str["MONTH"] = "Mese";
$str["YEAR"] = "Anno";
$str["TIME"] = "Ora";
$str["OPPONENT"] = "Avversario";
$str["GAME"] = "Gioco";
$str["RESULT"] = "Risultato";
$str["CURRENTLY"] = "Al momento";
$str["SHOW"] = "Visualizza";
$str["CHALLENGEUS"] = "Sfidaci";
$str["LEGEND"] = "Legenda";
$str["NAME"]="Nome";
$str["SERVER"] = "Server";
$str["FULL"] = "pieno";
$str["CONTACT"] = "Contatto";
$str["PLAYERS"] = "Giocatori";
$str["PLAYERPERTEAM"] = "Giocatori per squadra";
$str["LOCATIONS"] = "Mappe";
$str["LOCATION"] = "Mappa";
$str["OWNSCORES"] = "Nostro punteggio";
$str["OPPSCORES"] = "Punteggio dell'avversario";
$str["AVERAGE"] = "medio";
$str["ADDITIONALINFO"] = "Altre Informazioni";
$str["SIGNEDMEMBERS"] = "Membri registrati";
$str["MOREREQUIRED"] = "richiesti di più";
$str["OPTIONS"] = "Opzioni";
$str["SIGNUP"] = "Registrati";
$str["SIGNOFF"] = "Log-Off";
$str["CALENDAR"] = "Calendario";
$str["JUMPTOCURRENTMONTH"] = "Salta al mese corrente";
$str["ON"] = "On";
$str["OFF"] = "Off";
$str["HTMLIS"] = "HTML è";
$str["SMILIES"] = "Smiles";
$str["ARE"] = "sono";
$str["BBCODE"] = "BB Code";
$str["IS"] =  "è";
$str["EVENTCALENDAR"] = "Calendario degli eventi";
$str["EVENTDETAILS"] = "Dettagli degli eventi";
$str["BACKTOCALENDAR"] = "Torna al calendario";
$str["ADDEDBY"] = "Inserito da";
$str["VISITHOMEPAGE"] = "Visita l'home page di";
$str["ADDTOCONTACTLIST"] = "Aggiungi alla lista dei contatti";
$str["CLICKMEMBERPROFILE"] = "Clicca su ".makeimgtag($vwar_root . "images/button_profile.gif")." per vedere il profilo del giocatore";
$str["SHOWDETAILS"] = "Mostra i dettagli";
$str["GAMES"] = "Giochi";
$str["SENDMAILTO"] = "Manda una E-Mail a";
$str["PROFILEOF"] = "Profilo di";
$str["PROFILELOCATION"] = "Mappa";
$str["PROFILEBIRTHDAY"] = "Data di nascita";
$str["PROFILEINTERESTS"] = "Interessi";
$str["PROFILEGRAPHICCARD"] = "Scheda video";
$str["PROFILECONNECTION"] = "Connessione";
$str["PROFILEKEYBOARD"] = "Tastiera";
$str["PROFILEMOUSE"] = "Mouse";
$str["PHONENUMBERS"] = "Numero di telefono";
$str["ONLYVISIBLETOMEMBERS"] = "Visibile solo ai membri";
$str["PHONE"] = "Telefono";
$str["CELLULARPHONE"] = "Cellulare";
$str["BACKTOWARLIST"] = "Torna alla lista delle CW";
$str["BACKTOMEMBERLIST"] = "Torna alla lista dei Membri";
$str["BACKTOWARDETAILS"] = "Torna ai dettagli CW";
$str["GAMESPLAYED"] = "partite giocate";
$str["SHOWALL"] = "Mostra tutto";
$str["ENTERNAME"] = "Per piacere, digita il nome";
$str["RESULTS"] = "Risultati";
$str["OTHERGAMESAGAINST"] = "Altro gioco contro";
$str["PAGE"] = "Pagina";
$str["SORTTHISFIELDASC"] = "Per ordine crescente";
$str["SORTTHISFIELDDESC"] = "Per ordine decrescente";
$str["ASCENDING"] = "crescente";
$str["DESCENDING"] = "decrescente";
$str["CHALLENGE"] = "Sfida";
$str["GENERAL"] = "Generale";
$str["GAMETYPE"] = "Tipo di gioco";
$str["MATCHTYPE"] = "Tipo di partita";
$str["SELECT"] = "Seleziona";
$str["ENTERTEAMNAME"] = "Inserisci il nome del Team";
$str["ENTERSHORTTEAMNAME"] = "Inserisci la TAG del team";
$str["ENTERCONTACTNAME"] = "Inserisci il nome del contatto";
$str["ENTERCONTACTEMAIL"] = "Inserisci l'email del contatto";
$str["CHALLENGEFORM"] = "Scheda della sfida";
$str["TEAM"] = "Team";
$str["ADDITIONALINFOFULL"] = "aggiungi altre informazioni qui (es. settaggi speciali) o qualsiasi altra cosa che pensi dovremmo sapere";
$str["SELECTASMANY"] = "Selezionane tanti quanti ne servono";
$str["LOGGEDINAS"] = "Sei registrato come";
$str["NOTLOGGEDIN"] = "Non hai effettuato il Log-In";
$str["LOGIN"] = "Login";
$str["LOGIN2"] = "Login con username e password:";
$str["LOGOUT"] = "Logout";
$str["DETAILS"] = "Dettagli";
$str["LANGUAGE"] = "Lingua";
$str["LISTBYSTATUS"] = "Stato dei Membri";
$str["LISTBYTEAMS"] = "Teams";
$str["LISTBY"] = "Ordinato per";
$str["PICTURE"] = "Foto";
$str["NONPUBLICDETAILS"] = "Dettagli non-pubblici <small>(visibili solo ai membri registrati)</small>";
$str["FIRSTPAGE"] = "Prima Pagina";
$str["LASTPAGE"] = "Ultima Pagina";
$str["PREVIOUSPAGE"] = "pagina Precendente";
$str["NEXTPAGE"] = "Prossima Pagina";
$str["ALL"] = "Tutto";
$str["SCORE"] = "Punteggio";
$str["COUNTRY"] = "Paese";
$str["EDIT"] = "Modifica";
$str["DELETE"] = "Cancella";
$str["PERFORMDELETE"] = "Effettuo la cancellazione ?";
$str["GUEST"] = "Ospite";
$str["REPORT"] = "Report";
$str["BIRTHDAY"] = "Data di nascita";
$str["JOINUS"] = "Arruolati";
$str["JOINUSFORM"] = "Scheda di arruolamento";
$str["PERSONALDETAILS"] = "Dettagli personali";
$str["JOINSUSADDITIONALINFO"] = "Descrivi brevemente perchè ti vuoi arruolare con noi e altre informazioni che ci potrebbero interessare per valutare il tuo arruolamento";
$str["WEWILLCONTACTYOU"] = "Ti contatteremo prima possibile";
$str["THANKSFORREQUEST"] = "Grazie per la tua richiesta";
$str["EQUIPMENT"] = "Equipaggiamento";
$str["GENERALINFORMATIONS"] = "Informazioni Generali";
$str["AGE"] = "Età";
$str["ALLTIMESARE"] = "Tutti gli orari sono";
$str["TIMENOWIS"] = "Sono le";
$str["STATUSWARS"] = "CW senza status";
$str["TODAYWARS"] = "CW di oggi";
$str["WARSSTATUS"] = "E' richiesta<br><smallfont>(la registrazione)</smallfont>";
$str["ALLSTATUSSET"] = "Lo stato per le clan war è stato impostato su";
$str["OWNGAMES"] = "I Nostri giochi";
$str["NOENTRY"] = "Nessun dato disponibile";
$str["SITEGENERATEDWITH"] = "Sito generato con";
$str["QUERYSIN"] = "Elaborato in";
$str["SIMPLEMODE"] = "Modo semplice";
$str["ADVANCEDMODE"] = "Modo avanzato";
$str["CLOSECURRENTTAG"] = "Chiudi la TAG corrente";
$str["CLOSEALLTAGS"] = "Chiudi tutte le TAG";
$str["FORMATTEXT"] = "Inserisci il testo che vuoi formattare:";
$str["FORMATTEXTADDITIONAL"] = "Inserisci il testo che vuoi formattare - ";
$str["PROMPTLINKTEXT"] = "Inserisci il testo che apparirà come link (opzionale):";
$str["PROMPTURLTEXT"] = "Inserisci l'URL completo per il link:";
$str["PROMPTMAILTEXT"] = "Inserisci l'indirizzo e-mail per il link";
$str["PROMPTLISTITEM"] = "Inserisci l'elemento della lista.\nlascia lo spazio vuoto o premi 'Cancel' per completare la lista.";
$str["SIZE"] = "Dimensione";
$str["HUGE"] = "Enorme";
$str["BIG"] = "Grande";
$str["NORMAL"] = "Normale";
$str["SMALL"] = "Piccola";
$str["FONT"] = "Carattere";
$str["COLOR"] = "Colore";
$str["BOLDTEXT"] = "Grassetto";
$str["ITALICTEXT"] = "Corsivo";
$str["UNDERLINEDTEXT"] = "Sottolineato";
$str["CENTER"] = "Centrato";
$str["CREATELIST"] = "Crea una Lista";
$str["INSERTHYPERLINK"] = "Inserisci un LINK";
$str["INSERTCODE"] = "Inserisci del Codice";
$str["INSERTMAIL"] = "Inserisci un e-mail";
$str["INSERTQUOTE"] = "Inserisci un Quote";
$str["INSERTIMAGE"] = "Inserisci un'immagine";
$str["HELP"] = "Aiuto";
$str["CLICKONARROWTOINSERTCODE"] = "Clicca sulla freccia per inserire il BB Code.<br>Maiuscolo o minuscolo non è importante, gli URLs sono trasformati automaticamente.";
$str["PLAY"] = "giocata o da giocare";
$str["CANCELLED"] = "cancellata";
$str["OPPONENTLIST"] = "Lista Degli avversari";
$str["MEMBERGALLERY"] = "Galleria dei Giocatori Registrati";
$str["CONTACTLIST"] = "Lista dei contatti";
$str["RECEIVER"] = "Destinatario";
$str["SENDERNAME"] = "Mittente";
$str["SENDERMAIL"] = "E-Mail Mittente";
$str["SUBJECT"] = "Oggetto";
$str["FORMAT"] = "Formato";
$str["MESSAGE"] = "Messaggio";
$str["CONTENT"] = "Contenuto";
$str["ENTER"] = "Inserisci";
$str["SEND"] = "Invia";
$str["PRIORITY"] = "Priorità";
$str["BACKTONEWS"] = "Torna alle news";
$str["QUOTE"] = "Quote";
$str["BACK"] = "indietro";
$str["TITLE"] = "Titolo";
$str["NOICON"] = "Senza Icona";
$str["PREVIEW"] = "Anteprima";
$str["TOTAL"] = "Totale";
$str["GUESTBOOKOF"] = "Guestbook di";
$str["FUNCTIONDISABLED"] = "Questa funzione è <b>disabilitata</b>!";
$str["GOTO"] = "Vai&nbsp;a";
$str["PASSWORD"] = "Password";
$str["FORGOTPASSWORD"] = "Password dimenticata?";
$str["ARCHIVE"] = "Archivio";
$str["CATEGORY"] = "Categoria";
$str["SEARCH"] = "Cerca";
$str["ENLARGE"] = "Allarga";
$str["PRINT"] = "Stampa";
$str["SUBMIT"] = "Conferma";
$str["REDIRECT"] = "Clicca qui se non vuoi aspettare<br>(o se il tuo browser non ti reindirizza automaticamente)";
$str["ENTEREDREGISTEREDDATA"] = "Hai inserito dei dati registrati (Name, E-Mail). cambiali in valori non registrati!";
$str["SEARCHKEYWORD"] = "Cerca per le parole chiavi";
$str["SEARCHAUTHOR"] = "Cerca per autore author";
$str["MATCHEXACTNAME"] = "Trova il termine esatto";
$str["MATCHPARTIALNAME"] = "Trova il termine parziale";
$str["USEWILDCARD"] = "Usa * come simbolo per ricerche parziali";
$str["SEARCHOPTIONS"] = "Puoi usare <u>AND</u>, <u>OR</u> and <u>NOT</u> per effettuare ricerche più dettagliate";
$str["CONNECTSEARCHES"] = "Puoi unire la ricerca per parole chiavi con una ricerca per autori";
$str["USEEXACTPHRASE"] = 'Il testo fra due " sarà ricercato come frase completa';
$str["SEARCHIN"] = "Cerca in";
$str["SEARCHFORRESULTSIN"] = "Cerca per i risultati in";
$str["DISPLAYMODE"] = "Modo di visualizzazione";
$str["SEARCHINTEXT"] = "Cerca nel testo";
$str["SEARCHINSUBJECT"] = "Cerca nell'oggetto";
$str["SHOWASOVERVIEW"] = "Visualizza nell'anteprima";
$str["SHOWINDETAILS"] = "Visualizza nei dettagli";
$str["SEARCHFORRESULTS"] = "Cerca per i risultati";
$str["SORTRESULTBY"] = "Ordina i risultati per";
$str["OF"] = "di";
$str["LASTDAYS0"] = "qualsiasi data";
$str["LASTDAYS1"] = "ieri";
$str["LASTDAYS7"] = "la scorsa settimana";
$str["LASTDAYS14"] = "le ultime due settimane";
$str["LASTDAYS30"] = "l'ultimo mese";
$str["LASTDAYS90"] = "gli ultimi tre mesi";
$str["LASTDAYS180"] = "gli ultimi sei mesi";
$str["LASTDAYS365"] = "l'ultimo anno";
$str["AND"] = "e";
$str["NEWER"] = "mai";
$str["OLDER"] = "più vecchio";
$str["AUTHOR"] = "Autore";
$str["NUMLINKS"] = "Numero di links";
$str["ADVANCEDSEARCH"] = "Ricerca avanzata";
$str["REQUIREDFIELDS"] = 'I campi accompagnati da un <font color="red">*</font> sono obbligatori';
$str["OR"] = "oppure";
$str["LENGTHSEARCHWORD"] = "La lunghezza della parola chiave deve essere almeno di tre lettere.";
$str["SEARCHINFORMATION"] = "Informazion per la ricerca";
$str["NEWSCOMMENTS"] = "Commenti alle news";
$str["SENDNEWS"] = "Invia la news";
$str["RECEIVERMAIL"] = "E-Mail del destinatario";
$str["MOREFUNCTION"] = "Più-Funzioni: <b>abilitate</b><br>Puoi suddividere il contenuto con queste";
$str["SUBMITTED"] = "(inviato)";
$str["AREYOUSURETODELETE"] = "Sei veramente sicuro di voler cancellare gli elementi selezionati?";
$str["NORMALMODE"] = "Modo Normale";
$str["LISTMODE"] = "Modo a Lista";
$str["PROMPTLISTTYPE"] = "Tipi di liste: '1' = Numerata, 'a' = piccole lettere,\n'I' = Lista Romana, leave blank = palline";
$str["LASTEDITEDBY"] = "L'ultima modifica è di";

## ---- START CUSTOM PART ---- ##
## ---- START "GB" ---- ##

$str["GB_NAME"] = "Guestbook";

$str["GB_INFOLINE"] = "%1 %2 su %3 %4";

$str["GB_PAGE"] = "Pagina";

$str["GB_PAGES"] = "Pagine";

$str["GB_ENTRY"] = "messaggio";

$str["GB_ENTRIES"] = "Messaggi";

$str["GB_ADDENTRY"] = "Aggiungi il messaggio";

$str["GB_ADDANENTRY"] = "Aggiungi un messaggio";

$str["GB_EDITENTRY"] = "Modifica il messaggio";

$str["GB_EDITANENTRY"] = "Modifica un messaggio";

$str["GB_BACKTOGB"] = "Torna al Guestbook";

$str["GB_WARNINGNAME"] = "Per piacere, inserisci un nome!";

$str["GB_WARNINGTEXT"] = "Per piacere, inserisci il testo!";

$str["GB_ADDNAME"] = "Nome";

$str["GB_ADDEMAIL"] = "eMail";

$str["GB_ADDHOMEPAGE"] = "Homepage";

$str["GB_ADDICQ"] = "ICQ-UIN";

$str["GB_ADDAIM"] = "AIM";

$str["GB_ADDYIM"] = "YIM";

$str["GB_ADDMSN"] = "MSN";

$str["GB_TITLE"] = "Titolo";

$str["GB_BLOCKED"] = "Hai gia scritto nel GuestBook negli ultimi <b>%1 %2</b>.";

$str["GB_MINUTE"] = "Minuto";

$str["GB_MINUTES"] = "Minuti";

$str["GB_COMMENT"] = "Commento";

$str["GB_COMMENTS"] = "Commenti";

$str["GB_ENTRYBY"] = "Messaggio di";

## ---- END "GB" ---- ##
## ---- START "SPONSOR" ---- ##
$str["SPONSOR_CATEGORY"] = "Categoria";
$str["SPONSOR_SEARCH"] = "Cerca Sponsor";
$str["SPONSOR_NAME"] = "Links";
$str["SPONSOR_HITS"] = "Hits";
$str["SPONSOR_LANGUAGE"] = "Lingua";
$str["SPONSOR_OPTION"] = "Opzioni";
$str["SPONSOR_DETAILS"] = "Dettagli";
$str["SPONSOR_REDIRECT"] = "Clicca qui se non vuoi aspettare oltre (o se il tuo browser non ti reindirizza automaticamente)";
$str["SPONSOR_LINKNAME"] = "Nome dello Sponsor";
$str["SPONSOR_HOMEPAGE"] = "Sito Web";
$str["SPONSOR_DESCRIPTION"] = "Descrizione dello Sponsor";
$str["SPONSOR_BACK"] = "Indietro";
$str["SPONSOR_BANNERURL"] = "L'URL del Banner è errato";
$str["SPONSOR_BANNERNOT"] = "Nessun Banner disponibile";
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
