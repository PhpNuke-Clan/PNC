<?php //vwar
/* #####################################################################################
 *
 * $Id: german.inc.php,v 1.22 2004/03/14 20:22:10 mabu Exp $
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
	"an" => "Niederl&auml;ndische Antillen",
	"ao" => "Angola",
	"ar" => "Argentinien",
	"at" => "&Ouml;sterreich",
	"au" => "Australien",
	"aw" => "Aruba",
	"az" => "Aserbaidschan",
	"ba" => "Bosnien und Herzegowina",
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
	"bo" => "Bolivien",
	"br" => "Brasilien",
	"bs" => "Bahamas",
	"bt" => "Bhutan",
	"bw" => "Botswana",
	"bx" => "Benelux",
	"by" => "Weissrussland",
	"bz" => "Belize",
	"ca" => "Kanada",
	"cf" => "Zentralafrikanische Republik",
	"cg" => "Kongo",
	"ch" => "Schweiz",
	"ci" => "Cote D'Ivoire (Ivory Coast)",
	"ck" => "Cook Islands",
	"cm" => "Kamerun",
	"cn" => "China",
	"co" => "Kolumbien",
	"cr" => "Costa Rica",
	"cu" => "Kuba",
	"cv" => "Kap Verde",
	"cy" => "Zypern",
	"cz" => "Tschechische Republik",
	"de" => "Deutschland",
	"dk" => "D&auml;nemark",
	"dz" => "Algerien",
	"ec" => "Ecuador",
	"ee" => "Estland",
	"eg" => "&auml;gypten",
	"er" => "Eritrea",
	"es" => "Spanien",
	"et" => "&Auml;thopien",
	"eu" => "Europa",
	"fi" => "Finnland",
	"fj" => "Fiji",
	"fo" => "Faroe Inseln",
	"fr" => "Frankreich",
	"ga" => "Gabun",
	"ge" => "Georgien",
	"gi" => "Gibraltar",
	"gl" => "Gr&ouml;nland",
	"gp" => "Guadeloupe",
	"gr" => "Griechenland",
	"gt" => "Guatemala",
	"gu" => "Guam",
	"gy" => "Guyana",
	"hk" => "Hong Kong",
	"hr" => "Kroatien",
	"ht" => "Haiti",
	"hu" => "Ungarn",
	"id" => "Indonesien",
	"ie" => "Irland",
	"il" => "Isreal",
	"in" => "Indien",
	"int" => "International",
	"iq" => "Irak",
	"ir" => "Iran",
	"is" => "Island",
	"it" => "Italien",
	"jm" => "Jamaika",
	"jo" => "Jordanien",
	"jp" => "Japan",
	"ke" => "Kenia",
	"kg" => "Kirgisistan",
	"kh" => "Kambodscha",
	"ki" => "Kiribati",
	"kp" => "Korea (Nord)",
	"kr" => "Korea",
	"ky" => "Cayman Islands",
	"kz" => "Kasachstan",
	"lb" => "Libanon",
	"lc" => "Saint Lucia",
	"li" => "Liechtenstein",
	"lk" => "Sri Lanka",
	"lt" => "Litauen",
	"lu" => "Luxemburg",
	"lv" => "Lettland",
	"ly" => "Lybien",
	"ma" => "Marokko",
	"mc" => "Monaco",
	"md" => "Moldawien",
	"mg" => "Madagascar",
	"mn" => "Mongolei",
	"mo" => "Macau",
	"mp" => "Northern Mariana Islands",
	"ms" => "Montserrat",
	"mt" => "Malta",
	"mx" => "Mexiko",
	"my" => "Malaysia",
	"mz" => "Mosambique",
	"na" => "Namibia",
	"nc" => "Neu Kaledonien",
	"nf" => "Norfolk Island",
	"nl" => "Niederlande",
	"no" => "Norwegen",
	"np" => "Nepal",
	"nr" => "Nauru",
	"nz" => "Neuseeland",
	"om" => "Oman",
	"pa" => "Panama",
	"pe" => "Peru",
	"pf" => "Franz&ouml;sisch Polynesien",
	"ph" => "Philippinen",
	"pk" => "Pakistan",
	"pl" => "Polen",
	"pm" => "St. Pierre and Miquelon",
	"pr" => "Puerto Rico",
	"pt" => "Portugal",
	"py" => "Paraguay",
	"qa" => "Qatar",
	"ro" => "Rum&auml;nien",
	"ru" => "Russland",
	"sa" => "Saudi Arabien",
	"sb" => "Solomon Islands",
	"sca" => "Skadinavien",
	"sd" => "Sudan",
	"se" => "Schweden",
	"sg" => "Singapur",
	"si" => "Slowenien",
	"sk" => "Slowakei (Slowakische Republik)",
	"sl" => "Sierra Leone",
	"so" => "Somalia",
	"tc" => "Turks and Caicos Islands",
	"tg" => "Togo",
	"th" => "Thailand",
	"tn" => "Tunesien",
	"to" => "Tonga",
	"tp" => "East Timor",
	"tr" => "T&uuml;rkei",
	"tt" => "Trinidad und Tobago",
	"tv" => "Tuvalu",
	"tw" => "Taiwan",
	"tz" => "Tansania",
	"ua" => "Ukraine",
	"ug" => "Uganda",
	"uk" => "Vereinigtes K&ouml;nigreich",
	"us" => "Vereinigte Staaten von Amerika",
	"uy" => "Uruguay",
	"va" => "Vatican City State (Holy See)",
	"ve" => "Venezuela",
	"vg" => "Virgin Islands (Britisch)",
	"vi" => "Virgin Islands (U.S.)",
	"vn" => "Vietnam",
	"ws" => "Samoa",
	"ye" => "Yemen",
	"yu" => "Jugoslawien",
	"za" => "S&uuml;dafrika",
	"zw" => "Simbabwe"
);

## ------------------------------ DEFINE MONTH NAMES -------------------------------- ##
$monthnames = array(
	"1" => "Januar",
	"2" => "Februar",
	"3" => "März",
	"4" => "April",
	"5" => "Mai",
	"6" => "Juni",
	"7" => "Juli",
	"8" => "August",
	"9" => "September",
	"10" => "Oktober",
	"11" => "November",
	"12" => "Dezember"
);

## ----------------------------- DEFINE WEEKDAY NAMES ------------------------------- ##
$weekdaynames = array(
	"So",
	"Mo",
	"Di",
	"Mi",
	"Do",
	"Fr",
	"Sa"
);

## ------------------------------- DEFINE LANGUAGES --------------------------------- ##
$languages = array(
	"german" => "Deutsch",
	"english" => "Englisch",
	"french" => "Französisch",
	"danish" => "Dänisch",
	"dutch" => "Holländisch",
	"spanish" => "Spanisch",
	"portuguese" => "Portugiesisch",
	"italian" => "Italienisch",
	"hungarian" => "Ungarisch"
);

## ------------------------- DEFINE GLOBAL LANGUAGE VARS ---------------------------- ##
$str["SHOWIP"] = "IP anzeigen";
$str["NEWCOMMENT"] = "Neuer Kommentar";
$str["ADDCOMMENT"] = "Kommentar hinzuf&uuml;gen";
$str["EDITCOMMENT"] = "Kommentar bearbeiten";
$str["DELETECOMMENT"] = "Kommentar l&ouml;schen";
$str["COMMENT"] = "Kommentar";
$str["COMMENTS"] = "Kommentare";
$str["ENTERCOMMENT"] = "Bitte Kommentar eingeben";
$str["BACKTOCOMMENTS"] = "Zurück zu den Kommentaren";
$str["ADD"] = "Eintragen";
$str["CLOSEWINDOW"] = "Fenster schließen";
$str["CLICKONSMILIETOINSERT"] = "Klicke auf einen Smilie um ihn einzufügen";
$str["INSERTTHISSMILIE"] = "Füge diesen Smilie ein";
$str["MORE"] = "mehr";
$str["PLEASECHOOSE"] = "Bitte wähle";
$str["STATISTICS"] = "Statistiken";
$str["AVAILABLE"] = "verfügbar";
$str["YES"] = "Ja";
$str["NO"] = "Nein";
$str["SHORT"] = "kurz";
$str["NOTAVAILABLE"] = "nicht verfügbar";
$str["NOTAVAILABLESHORT"] = "n/a";
$str["DATE"] = "Datum";
$str["DAY"] = "Tag";
$str["MONTH"] = "Monat";
$str["YEAR"] = "Jahr";
$str["TIME"] = "Zeit";
$str["OPPONENT"] = "Gegner";
$str["GAME"] = "Spiel";
$str["RESULT"] = "Ergebnis";
$str["CURRENTLY"] = "Derzeit";
$str["SHOW"] = "Zeige";
$str["CHALLENGEUS"] = "Fordere uns heraus";
$str["LEGEND"] = "Legende";
$str["FULL"] = "voll";
$str["NAME"] = "Name";
$str["SERVER"] = "Server";
$str["CONTACT"] = "Kontakt";
$str["PLAYERS"] = "Spieler";
$str["PLAYERPERTEAM"] = "Spieler pro Team";
$str["LOCATIONS"] = "Locations";
$str["LOCATION"] = "Location";
$str["OWNSCORES"] = "Eigene Punkte";
$str["OPPSCORES"] = "Gegnerische Punkte";
$str["AVERAGE"] = "durchschnittlich";
$str["ADDITIONALINFO"] = "Zusatzinfo";
$str["SIGNEDMEMBERS"] = "Angemeldete Member";
$str["MOREREQUIRED"] = "mehr nötig";
$str["OPTIONS"] = "Optionen";
$str["SIGNUP"] = "Anmelden";
$str["SIGNOFF"] = "Abmelden";
$str["CALENDAR"] = "Kalender";
$str["JUMPTOCURRENTMONTH"] = "Springe zum aktuellen Monat";
$str["ON"] = "An";
$str["OFF"] = "Aus";
$str["HTMLIS"] = "HTML ist";
$str["SMILIES"] = "Smilies";
$str["ARE"] = "sind";
$str["BBCODE"] = "bbCode";
$str["IS"] = "ist";
$str["EVENTCALENDAR"] = "Ereignis Kalender";
$str["EVENTDETAILS"] = "Ereignis Details";
$str["BACKTOCALENDAR"] = "Zurück zum Kalender";
$str["ADDEDBY"] = "Hinzugefügt von";
$str["VISITHOMEPAGE"] = "Besuche die Homepage von";
$str["ADDTOCONTACTLIST"] = "Zur Kontaktliste hinzufügen";
$str["CLICKMEMBERPROFILE"] = "Klicke auf ".makeimgtag($vwar_root . "images/button_profile.gif")." um das Profil eines Members zu sehen";
$str["SHOWDETAILS"] = "Details anzeigen";
$str["GAMES"] = "Spiele";
$str["SENDMAILTO"] = "Sende eine Email an";
$str["PROFILEOF"] = "Profil von";
$str["PROFILELOCATION"] = "Wohnort";
$str["PROFILEBIRTHDAY"] = "Geburtstag";
$str["PROFILEINTERESTS"] = "Interessen";
$str["PROFILEGRAPHICCARD"] = "Grafikkarte";
$str["PROFILECONNECTION"] = "Verbindung";
$str["PROFILEKEYBOARD"] = "Tastatur";
$str["PROFILEMOUSE"] = "Maus";
$str["PHONENUMBERS"] = "Telefonnummern";
$str["ONLYVISIBLETOMEMBERS"] = "Nur für Members sichtbar";
$str["PHONE"] = "Telefon";
$str["CELLULARPHONE"] = "Handy";
$str["BACKTOWARLIST"] = "Zurück zur Warübersicht";
$str["BACKTOMEMBERLIST"] = "Zurück zur Memberübersicht";
$str["BACKTOWARDETAILS"] = "Zurück zu den Wardetails";
$str["GAMESPLAYED"] = "gespielte Spiele";
$str["SHOWALL"] = "Zeige alle";
$str["ENTERNAME"] = "Bitte Namen eingeben";
$str["RESULTS"] = "Ergebnisse";
$str["OTHERGAMESAGAINST"] = "Andere Spiele gegen";
$str["PAGE"] = "Seite";
$str["SORTTHISFIELDASC"] = "Sortiere dieses Feld aufsteigend";
$str["SORTTHISFIELDDESC"] = "Sortiere dieses Feld absteigend";
$str["ASCENDING"] = "aufsteigend";
$str["DESCENDING"] = "absteigend";
$str["CHALLENGE"] = "Herausfordern";
$str["GENERAL"] = "Allgemein";
$str["GAMETYPE"] = "Gametyp";
$str["MATCHTYPE"] = "Matchtyp";
$str["SELECT"] = "Wähle";
$str["ENTERTEAMNAME"] = "Teamnamen eingeben";
$str["ENTERSHORTTEAMNAME"] = "Teamkürzel eingeben";
$str["ENTERCONTACTNAME"] = "Kontaktnamen eingeben";
$str["ENTERCONTACTEMAIL"] = "Kontaktemail eingeben";
$str["CHALLENGEFORM"] = "Forderungsformular";
$str["TEAM"] = "Team";
$str["ADDITIONALINFOFULL"] = "füge Zusatzinformationen hinzu (z.B. spezielle Einstellungen), von denen du denkst, daß sie uns zusätzlich zu den angegebenen Daten interessieren könnten";
$str["SELECTASMANY"] = "Wähle soviele wie benötigt";
$str["LOGGEDINAS"] = "Du bist eingeloggt als";
$str["NOTLOGGEDIN"] = "Du bist nicht eingeloggt";
$str["LOGIN"] = "Einloggen";
$str["LOGIN2"] = "Einloggen mit Username und Passwort:";
$str["LOGOUT"] = "Ausloggen";
$str["DETAILS"] = "Details";
$str["LANGUAGE"] = "Sprache";
$str["LISTBYSTATUS"] = "Memberstatus";
$str["LISTBYTEAMS"] = "Teams";
$str["LISTBY"] = "Auflisten nach";
$str["PICTURE"] = "Bild";
$str["NONPUBLICDETAILS"] = "Nicht-öffentliche Details <small>(nur für Members sichtbar)</small>";
$str["FIRSTPAGE"] = "Erste Seite";
$str["LASTPAGE"] = "Letzte Seite";
$str["PREVIOUSPAGE"] = "Vorherige Seite";
$str["NEXTPAGE"] = "Nächste Seite";
$str["ALL"] = "Alle";
$str["SCORE"] = "Punkte";
$str["COUNTRY"] = "Land";
$str["EDIT"] = "Bearbeiten";
$str["DELETE"] = "Löschen";
$str["PERFORMDELETE"] = "Wirklich löschen ?";
$str["GUEST"] = "Gast";
$str["REPORT"] = "Bericht";
$str["BIRTHDAY"] = "Geburtstag";
$str["JOINUS"] = "Beitreten";
$str["JOINUSFORM"] = "Beitrittsformular";
$str["PERSONALDETAILS"] = "Persönliche Details";
$str["JOINSUSADDITIONALINFO"] = "Beschreibe kurz warum du uns beitreten willst und was uns noch zu deiner Person interessieren könnte!";
$str["WEWILLCONTACTYOU"] = "Wir werden uns so schnell wie möglich mit dir in Verbindung setzen";
$str["THANKSFORREQUEST"] = "Danke für deine Anfrage";
$str["EQUIPMENT"] = "Ausstattung";
$str["GENERALINFORMATIONS"] = "Allgemeine Informationen";
$str["AGE"] = "Alter";
$str["ALLTIMESARE"] = "Alle Zeiten sind";
$str["TIMENOWIS"] = "Es ist jetzt";
$str["STATUSWARS"] = "Wars ohne Status";
$str["TODAYWARS"] = "Heutige Wars";
$str["WARSSTATUS"] = "Status<br><smallfont>(angemeldet/n&ouml;tig)</smallfont>";
$str["ALLSTATUSSET"] = "Zu allen Wars wurde der Status gesetzt";
$str["OWNGAMES"] = "Eigene Spiele";
$str["NOENTRY"] = "Keine Eintr&auml;ge vorhanden";
$str["SITEGENERATEDWITH"] = "Seite generiert mit";
$str["QUERYSIN"] = "Abfragen in";
$str["SIMPLEMODE"] = "Einfacher Modus";
$str["ADVANCEDMODE"] = "Erweiterter Modus";
$str["CLOSECURRENTTAG"] = "Aktuellen Tag schliessen";
$str["CLOSEALLTAGS"] = "Alle Tags schliessen";
$str["FORMATTEXT"] = "Gebe einen Text ein:";
$str["FORMATTEXTADDITIONAL"] = "Gebe einen Text ein - ";
$str["PROMPTLINKTEXT"] = "Gebe einen Linknamen ein (optional):";
$str["PROMPTURLTEXT"] = "Gebe die volle URL des Links ein:";
$str["PROMPTMAILTEXT"] = "Gebe die Email Adresse ein:";
$str["PROMPTLISTITEM"] = "Gebe einen Listepunkt ein.\nGebe nichts ein oder drücke 'Cancel' um die Liste fertigzustellen.";
$str["SIZE"] = "Grösse";
$str["HUGE"] = "riesig";
$str["BIG"] = "gross";
$str["NORMAL"] = "normal";
$str["SMALL"] = "klein";
$str["FONT"] = "Schriftart";
$str["COLOR"] = "Farbe";
$str["BOLDTEXT"] = "fettgedruckter Text";
$str["ITALICTEXT"] = "kursiver Text";
$str["UNDERLINEDTEXT"] = "unterstrichener Text";
$str["CENTER"] = "zentriert";
$str["CREATELIST"] = "Liste erstellen";
$str["INSERTHYPERLINK"] = "Hyperlink einf&uuml;gen";
$str["INSERTCODE"] = "Code einf&uuml;gen";
$str["INSERTMAIL"] = "eMail Adresse einf&uuml;gen";
$str["INSERTQUOTE"] = "Zitat einf&uuml;gen";
$str["INSERTIMAGE"] = "Bild einf&uuml;gen";
$str["HELP"] = "Hilfe";
$str["CLICKONARROWTOINSERTCODE"] = "Klicke auf den Pfeil um den BB Code einzuf&uuml;gen.<br>Gross-/Kleinschreibung wird nicht ber&uuml;cksichtigt, URLs werden automatisch umgewandelt.";
$str["PLAY"] = "gespielt oder zu spielen";
$str["CANCELLED"] = "abgebrochen";
$str["OPPONENTLIST"] = "Gegnerliste";
$str["MEMBERGALLERY"] = "Membergallerie";
$str["CONTACTLIST"] = "Kontaktliste";
$str["RECEIVER"] = "Empf&auml;nger";
$str["SENDERNAME"] = "Absendername";
$str["SENDERMAIL"] = "Absender E-Mail";
$str["SUBJECT"] = "Betreff";
$str["FORMAT"] = "Format";
$str["MESSAGE"] = "Nachricht";
$str["CONTENT"] = "Inhalt";
$str["ENTER"] = "Ausf&uuml;llen";
$str["SEND"] = "Versenden";
$str["PRIORITY"] = "Priorit&auml;t";
$str["BACKTONEWS"] = "Zur&uuml;ck zu den Newsdetails";
$str["QUOTE"] = "Zitieren";
$str["BACK"] = "zur&uuml;ck";
$str["TITLE"] = "Titel";
$str["NOICON"] = "Kein Icon";
$str["PREVIEW"] = "Vorschau";
$str["TOTAL"] = "Gesamt";
$str["GUESTBOOKOF"] = "G&auml;stebuch von";
$str["FUNCTIONDISABLED"] = "Diese Funktion ist <b>deaktiviert</b>!";
$str["GOTO"] = "Gehe&nbsp;zu";
$str["PASSWORD"] = "Passwort";
$str["FORGOTPASSWORD"] = "Passwort vergessen?";
$str["ARCHIVE"] = "Archiv";
$str["CATEGORY"] = "Kategorie";
$str["SEARCH"] = "Suche";
$str["ENLARGE"] = "Vergr&ouml;ssern";
$str["PRINT"] = "Print";
$str["SUBMIT"] = "Einschicken";
$str["REDIRECT"] = "Klicke hier, wenn Du nicht l&auml;nger warten willst<br>(oder wenn Dein Browser keine Weiterleitung unterst&uuml;tzt)";
$str["ENTEREDREGISTEREDDATA"] = "Du hast registrierte Daten eingegeben (Name, E-Mail). &Auml;ndere sie nach nicht registrierten Angaben ab!";
$str["SEARCHKEYWORD"] = "Nach Schl&uuml;sselwort suchen";
$str["SEARCHAUTHOR"] = "Nach Autor suchen";
$str["MATCHEXACTNAME"] = "Als exakter Name finden";
$str["MATCHPARTIALNAME"] = "Als Teil des Namens finden";
$str["USEWILDCARD"] = "Du kannst * als Platzhalter in den Suchbegriff einf&uuml;gen";
$str["SEARCHOPTIONS"] = "Benutze <u>AND</u>, <u>OR</u> und <u>NOT</u> in Verbindung mit Deinen Suchbegriffen, um detaillierter zu suchen";
$str["CONNECTSEARCHES"] = "Du kannst eine Suche nach einem Schl&uuml;sselwort mit einer Suche nach einem Autor verbinden";
$str["USEEXACTPHRASE"] = 'Text zwischen zwei " wird als exakte Wortgruppe gesucht';
$str["SEARCHIN"] = "Suchen in";
$str["SEARCHFORRESULTSIN"] = "Wo nach Resultaten suchen";
$str["DISPLAYMODE"] = "Anzeige-Modus";
$str["SEARCHINTEXT"] = "Im Text suchen";
$str["SEARCHINSUBJECT"] = "In der &Uuml;berschrift suchen";
$str["SHOWASOVERVIEW"] = "Als &Uuml;bersicht zeigen";
$str["SHOWINDETAILS"] = "Details zeigen";
$str["SEARCHFORRESULTS"] = "Nach Resultaten suchen";
$str["SORTRESULTBY"] = "Sortieren nach";
$str["OF"] = "von";
$str["LASTDAYS0"] = "jedem Datum";
$str["LASTDAYS1"] = "gestern";
$str["LASTDAYS7"] = "letzter Woche";
$str["LASTDAYS14"] = "letzten zwei Wochen";
$str["LASTDAYS30"] = "letzten Monat";
$str["LASTDAYS90"] = "letzten drei Monaten";
$str["LASTDAYS180"] = "letzten sechs Monaten";
$str["LASTDAYS365"] = "letzten Jahr";
$str["AND"] = "und";
$str["NEWER"] = "neuer";
$str["OLDER"] = "&auml;lter";
$str["AUTHOR"] = "Autor";
$str["NUMLINKS"] = "Anzahl Links";
$str["ADVANCEDSEARCH"] = "Erweiterte Suche";
$str["REQUIREDFIELDS"] = 'Mit <font color="red">*</font> markierte Felder sind erforderlich';
$str["OR"] = "oder";
$str["LENGTHSEARCHWORD"] = "Die L&auml;nge des Suchwortes muss die minimale Wortl&auml;nge von 3 Buchstaben erf&uuml;llen.";
$str["SEARCHINFORMATION"] = "Suchinfo";
$str["NEWSCOMMENTS"] = "News Kommentare";
$str["SENDNEWS"] = "News verschicken";
$str["RECEIVERMAIL"] = "Empf&auml;nger E-Mail";
$str["MOREFUNCTION"] = "Mehr-Funktion: <b>eingeschaltet</b><br>Du kannst Deinen Text aufteilen mit";
$str["SUBMITTED"] = "(eingeschickt)";
$str["AREYOUSURETODELETE"] = "Bist du sicher, daß du den ausgew&auml;hlten Eintrag l&ouml;schen m&ouml;chtest?";
$str["NORMALMODE"] = "Normaler Modus";
$str["LISTMODE"] = "Listen Modus";
$str["PROMPTLISTTYPE"] = "Listentypen: '1' = nummeriert, 'a' = buchstabiert,\n'I' = römische Zahlen, leer lassen = dicke Punkte";
$str["LASTEDITEDBY"] = "Zuletzt bearbeitet von";

## ---- START CUSTOM PART ---- ##
## ---- START "GB" ---- ##

$str["GB_NAME"] = "G&auml;stebuch";

$str["GB_INFOLINE"] = "%1 %2 auf %3 %4";

$str["GB_PAGE"] = "Seite";

$str["GB_PAGES"] = "Seiten";

$str["GB_ENTRY"] = "Eintrag";

$str["GB_ENTRIES"] = "Eintr&auml;ge";

$str["GB_ADDENTRY"] = "Eintrag hinzuf&uuml;gen";

$str["GB_ADDANENTRY"] = "Einen Eintrag zum G&auml;stebuch hinzuf&uuml;gen";

$str["GB_EDITANENTRY"] = "Einen Eintrag bearbeiten";

$str["GB_EDITENTRY"] = "Eintrag bearbeiten";

$str["GB_BACKTOGB"] = "Zur&uuml;ck zum G&auml;stebuch";

$str["GB_WARNINGNAME"] = "Bitte gebe einen Namen ein!";

$str["GB_WARNINGTEXT"] = "Bitte gebe einen Text ein!";

$str["GB_ADDNAME"] = "Name";

$str["GB_ADDEMAIL"] = "eMail";

$str["GB_ADDHOMEPAGE"] = "Homepage";

$str["GB_ADDICQ"] = "ICQ-UIN";

$str["GB_ADDAIM"] = "AIM";

$str["GB_ADDYIM"] = "YIM";

$str["GB_ADDMSN"] = "MSN";

$str["GB_TITLE"] = "Titel";

$str["GB_BLOCKED"] = "Du hast bereits einen Eintrag in den/der letzten <b>%1 %2</b> verfasst.";

$str["GB_MINUTE"] = "Minute";

$str["GB_MINUTES"] = "Minuten";

$str["GB_COMMENT"] = "Kommentar";

$str["GB_COMMENTS"] = "Kommentare";

$str["GB_ENTRYBY"] = "G&auml;stebucheintrag von";

## ---- END "GB" ---- ##
## ---- START "SPONSOR" ---- ##
$str["SPONSOR_CATEGORY"] = "Kategorie";
$str["SPONSOR_SEARCH"] = "Sponsor suchen";
$str["SPONSOR_NAME"] = "Sponsor";
$str["SPONSOR_HITS"] = "Hits";
$str["SPONSOR_LANGUAGE"] = "Sprache";
$str["SPONSOR_OPTION"] = "Options";
$str["SPONSOR_DETAILS"] = "Details";
$str["SPONSOR_REDIRECT"] = "Sie werden in 5 sekunden weitergeleitet. Klicke hier wenn die weiterleitung bei dir nicht geht.";
$str["SPONSOR_LINKNAME"] = "Sponsor Name";
$str["SPONSOR_HOMEPAGE"] = "Webseite";
$str["SPONSOR_DESCRIPTION"] = "Sponsor Beschreibung";
$str["SPONSOR_BACK"] = "Zur&uuml;ck";
$str["SPONSOR_BANNERURL"] = "Die Url zum Banner ist falsch";
$str["SPONSOR_BANNERNOT"] = "Kein Banner angegeben";
## ---- END "SPONSOR" ---- ##
## ---- START "SEX" ---- ##
$sex_array = array(
	"me" => "Männlich",
	"wo" => "Weiblich",
	"no" => "Kein Kommentar",
);
$str["SEX"] = "Geschlecht";
## ---- END "SEX" ---- ##
$str["WARTAG"]="War Tag";
## ---- END CUSTOM PART ---- ##
?>
