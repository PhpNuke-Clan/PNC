<?php //vwar
/* #####################################################################################
 *
 * $Id: dutch.inc.php,v 1.20 2004/03/14 20:22:10 mabu Exp $
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
	"al" => "Albani&euml;",
	"am" => "Armeni&euml;",
	"an" => "Nederlandse Antillen",
	"ao" => "Angola",
	"ar" => "Argentini&euml;",
	"at" => "Oostenrijk",
	"au" => "Australi&euml;",
	"aw" => "Aruba",
	"az" => "Azerbeidzjan",
	"ba" => "Bosni&euml;-Hercegovina",
	"bb" => "Barbados",
	"bd" => "Bangladesh",
	"be" => "Belgi&euml;",
	"bf" => "Burkina Faso",
	"bg" => "Bulgarije",
	"bh" => "Bahrein",
	"bi" => "Burundi",
	"bj" => "Benin",
	"bm" => "Bermuda",
	"bn" => "Brunei",
	"bo" => "Bolivia",
	"br" => "Brazili&euml;",
	"bs" => "Bahama&#8217;s",
	"bt" => "Bhutan",
	"bw" => "Botswana",
	"bx" => "Benelux",
	"by" => "Wit-Rusland",
	"bz" => "Belize",
	"ca" => "Canada",
	"cf" => "Centraalafrikaanse Republiek",
	"cg" => "Kongo",
	"ch" => "Zwitserland",
	"ci" => "Ivoorkust",
	"ck" => "Cookeilanden",
	"cm" => "Kameroen",
	"cn" => "China",
	"co" => "Colombia",
	"cr" => "Costa Rica",
	"cu" => "Cuba",
	"cv" => "Kaapverdi&euml;",
	"cy" => "Cyprus",
	"cz" => "Tsjechi&euml;",
	"de" => "Duitsland",
	"dk" => "Denemarken",
	"dz" => "Algerije",
	"ec" => "Ecuador",
	"ee" => "Estland",
	"eg" => "Egypte",
	"er" => "Eritrea",
	"es" => "Spanje",
	"et" => "Ethiopi&euml;",
	"eu" => "Europa",
	"fi" => "Finland",
	"fj" => "Fuji",
	"fo" => "Faer&oslash;er",
	"fr" => "Frankrijk",
	"ga" => "Gabon",
	"ge" => "Georgi&euml;",
	"gi" => "Gibraltar",
	"gl" => "Groenland",
	"gp" => "Guadeloupe",
	"gr" => "Griekenland",
	"gt" => "Guatemala",
	"gu" => "Guam",
	"gy" => "Guyana",
	"hk" => "Hongkong",
	"hr" => "Kroati&euml;",
	"ht" => "Ha&iuml;ti",
	"hu" => "Hongarije",
	"id" => "Indonesi&euml;",
	"ie" => "Ierland",
	"il" => "Isra&euml;l",
	"in" => "India",
	"int" => "Internationaal",
	"iq" => "Irak",
	"ir" => "Iran",
	"is" => "IJsland",
	"it" => "Itali&euml;",
	"jm" => "Jamaica",
	"jo" => "Jordani&euml;",
	"jp" => "Japan",
	"ke" => "Kenya",
	"kg" => "Kirgizi&euml;",
	"kh" => "Cambodja",
	"ki" => "Kiribati",
	"kp" => "Korea (Noord)",
	"kr" => "Korea",
	"ky" => "Caymaneilanden",
	"kz" => "Kazachstan",
	"lb" => "Libanon",
	"lc" => "Sint Lucia",
	"li" => "Liechtenstein",
	"lk" => "Sri Lanka",
	"lt" => "Litouwen",
	"lu" => "Luxemburg",
	"lv" => "Letland",
	"ly" => "Libi&euml;",
	"ma" => "Marokko",
	"mc" => "Monaco",
	"md" => "Moldovi&euml;",
	"mg" => "Madagaskar",
	"mn" => "Mongoli&euml;",
	"mo" => "Macau",
	"mp" => "Noordelijke Marianen",
	"ms" => "Montserrat",
	"mt" => "Malta",
	"mx" => "Mexico",
	"my" => "Maleisi&euml;",
	"mz" => "Mozambique",
	"na" => "Namibi&euml;",
	"nc" => "Nieuw-Caledoni&euml;",
	"nf" => "Norfolk",
	"nl" => "Nederland",
	"no" => "Noorwegen",
	"np" => "Nepal",
	"nr" => "Nauru",
	"nz" => "Nieuw-Zeeland",
	"om" => "Oman",
	"pa" => "Panama",
	"pe" => "Peru",
	"pf" => "Frans Polynesi&euml;",
	"ph" => "Filipijnen",
	"pk" => "Pakistan",
	"pl" => "Polen",
	"pm" => "Sint-Pierre en Miquelon",
	"pr" => "Puerto Rico",
	"pt" => "Portugal",
	"py" => "Paraguay",
	"qa" => "Katar",
	"ro" => "Roemeni&euml;",
	"ru" => "Rusland",
	"sa" => "Saudi-Arabi&euml;",
	"sb" => "Solomoneilanden",
	"sca" => "Scandinavi&euml;",
	"sd" => "Sudan",
	"se" => "Zweden",
	"sg" => "Singapore",
	"si" => "Sloveni&euml;",
	"sk" => "Slowakije",
	"sl" => "Sierra Leone",
	"so" => "Somalia",
	"tc" => "Turks en Caicoseilanden",
	"tg" => "Togo",
	"th" => "Thailand",
	"tn" => "Tunesi&euml;",
	"to" => "Tonga",
	"tp" => "Oost-Timor",
	"tr" => "Turkije",
	"tt" => "Trinidad en Tobago",
	"tv" => "Tuvalu",
	"tw" => "Taiwan",
	"tz" => "Tanzania",
	"ua" => "Oekra&iuml;ne",
	"ug" => "Uganda",
	"uk" => "Verenigd Koninkrijk",
	"us" => "Verenigde Staten",
	"uy" => "Uruguay",
	"va" => "Vaticaanstad",
	"ve" => "Venezuela",
	"vg" => "Virgineilanden (Engels)",
	"vi" => "Virgineilanden (V.S.)",
	"vn" => "Vietnam",
	"ws" => "Samoa",
	"ye" => "Jemen",
	"yu" => "Joegoslavi&euml;",
	"za" => "Zuid-Afrika",
	"zw" => "Zimbabwe"
);

## ------------------------------ DEFINE MONTH NAMES -------------------------------- ##
$monthnames = array(
	"1" => "Januari",
	"2" => "Februari",
	"3" => "Maart",
	"4" => "April",
	"5" => "Mei",
	"6" => "Juni",
	"7" => "Juli",
	"8" => "Augustus",
	"9" => "September",
	"10" => "Oktober",
	"11" => "November",
	"12" => "December"
);

## ----------------------------- DEFINE WEEKDAY NAMES ------------------------------- ##
$weekdaynames = array(
	"Zo",
	"Ma",
	"Di",
	"Wo",
	"Do",
	"Vr",
	"Za"
);

## ------------------------------- DEFINE LANGUAGES --------------------------------- ##
$languages = array(
	"german" => "Duits",
	"english" => "Engels",
	"french" => "Frans",
	"danish" => "Deens",
	"dutch" => "Nederlands",
	"spanish" => "Spaans",
	"portuguese" => "Portugees",
	"italian" => "Italiaans",
	"hungarian" => "Hongaars"
);

## ------------------------- DEFINE GLOBAL LANGUAGE VARS ---------------------------- ##
$str["SHOWIP"] = "Bekijk IP";
$str["NEWCOMMENT"] = "Nieuwe opmerking";
$str["ADDCOMMENT"] = "Plaats opmerking";
$str["EDITCOMMENT"] = "Bewerk opmerking";
$str["DELETECOMMENT"] = "Verwijder opmerking";
$str["COMMENT"] = "Opmerking";
$str["COMMENTS"] = "Opmerkingen";
$str["ENTERCOMMENT"] = "voer opmerking in";
$str["BACKTOCOMMENTS"] = "Terug naar opmerkingen";
$str["ADD"] = "Toevoegen";
$str["CLOSEWINDOW"] = "Sluit venster";
$str["CLICKONSMILIETOINSERT"] = "Klik op een smilie om deze toe te voegen";
$str["INSERTTHISSMILIE"]="voeg deze smilie toe";
$str["MORE"] = "meer";
$str["PLEASECHOOSE"] = "Maak je keuze";
$str["STATISTICS"] = "Statistieken";
$str["AVAILABLE"] = "beschikbaar";
$str["YES"] = "Ja";
$str["NO"] = "Nee";
$str["SHORT"] = "kort";
$str["NOTAVAILABLE"] = "niet beschikbaar";
$str["NOTAVAILABLESHORT"] = "n.b.";
$str["DATE"] = "Datum";
$str["DAY"] = "Dag";
$str["MONTH"] = "Maand";
$str["YEAR"] = "Jaar";
$str["TIME"] = "Tijd";
$str["OPPONENT"] = "Tegenstander";
$str["GAME"] = "Spel";
$str["RESULT"] = "Resultaat";
$str["CURRENTLY"] = "Momenteel";
$str["SHOW"] = "Toon";
$str["CHALLENGEUS"] = "Daag ons uit";
$str["LEGEND"] = "Legenda";
$str["NAME"] = "Naam";
$str["SERVER"] = "Server";
$str["FULL"] = "volledig";
$str["CONTACT"] = "Contact";
$str["PLAYERS"] = "Spelers";
$str["PLAYERPERTEAM"] = "Spelers per team";
$str["LOCATIONS"] = "Lokaties";
$str["LOCATION"] = "Lokatie";
$str["OWNSCORES"] = "Eigen score";
$str["OPPSCORES"] = "Score van de tegenstander";
$str["AVERAGE"] = "gemiddeld";
$str["ADDITIONALINFO"] = "Extra informatie";
$str["SIGNEDMEMBERS"] = "Ingeschreven leden";
$str["MOREREQUIRED"] = "meer noodzakelijk";
$str["OPTIONS"] = "Opties";
$str["SIGNUP"] = "Inschrijven";
$str["SIGNOFF"] = "Uitschrijven";
$str["CALENDAR"] = "Kalender";
$str["JUMPTOCURRENTMONTH"] = "Ga naar de huidige maand";
$str["ON"] = "aan";
$str["OFF"] = "uit";
$str["HTMLIS"] = "HTML is";
$str["SMILIES"] = "Smilies";
$str["ARE"] = "zijn";
$str["EVENTCALENDAR"] = "Kalender";
$str["EVENTDETAILS"] = "Activiteit details";
$str["BACKTOCALENDAR"] = "Terug naar kalender";
$str["ADDEDBY"] = "Toegevoegd door";
$str["VISITHOMEPAGE"] = "Bezoek website";
$str["ADDTOCONTACTLIST"] = "Voeg toe aan adresboek";
$str["CLICKMEMBERPROFILE"] = "Klik op ".makeimgtag($vwar_root . "images/button_profile.gif")." om het profiel te zien.";
$str["SHOWDETAILS"] = "Laat details zien";
$str["GAMES"] = "Games";
$str["SENDMAILTO"] = "Stuur e-mail naar";
$str["PROFILEOF"] = "Profiel van";
$str["PROFILELOCATION"] = "Stad";
$str["PROFILEBIRTHDAY"] = "Geboortedatum";
$str["PROFILEINTERESTS"] = "Interesses";
$str["PROFILEGRAPHICCARD"] = "Grafische kaart";
$str["PROFILECONNECTION"] = "Verbinding";
$str["PROFILEKEYBOARD"] = "Toetsenbord";
$str["PROFILEMOUSE"] = "Muis";
$str["PHONENUMBERS"] = "Telefoonnummers";
$str["ONLYVISIBLETOMEMBERS"] = "Aleen zichtbaar voor leden";
$str["PHONE"] = "Telefoon";
$str["CELLULARPHONE"] = "Mobiel";
$str["BACKTOWARLIST"] = "Terug naar wars overzicht";
$str["BACKTOMEMBERLIST"] = "Terug naar leden overzicht";
$str["BACKTOWARDETAILS"] = "Terug naar war details";
$str["GAMESPLAYED"] = "gespeelde wars";
$str["SHOWALL"] = "Laat alles zien";
$str["ENTERNAME"] = "Voer naam in";
$str["RESULTS"] = "Uitslagen";
$str["OTHERGAMESAGAINST"] = "Andere games tegen";
$str["PAGE"] = "pagina";
$str["SORTTHISFIELDASC"] = "Sorteer oplopend";
$str["SORTTHISFIELDDESC"] = "Sorteer aflopend";
$str["ASCENDING"] = "oplopend";
$str["DESCENDING"] = "aflopend";
$str["CHALLENGE"] = "Uitdagen";
$str["GENERAL"] = "Algemeen";
$str["GAMETYPE"] = "Speltype";
$str["MATCHTYPE"] = "Wartype";
$str["SELECT"] = "Selecteer";
$str["ENTERTEAMNAME"] = "Voer teamnaam in";
$str["ENTERSHORTTEAMNAME"] = "Voer korte teamnaam in";
$str["ENTERCONTACTNAME"] = "Voer contactnaam in";
$str["ENTERCONTACTEMAIL"] = "Voer contact e-mailadres in";
$str["CHALLENGEFORM"] = "Uitdagingsformulier";
$str["TEAM"] = "Team";
$str["ADDITIONALINFOFULL"] = "Voeg hier overige informatie toe (bijvoorbeeld speciale instellingen) of andere informatie die belangrijk voor ons zou kunnen zijn om te weten.";
$str["SELECTASMANY"] = "Selecteer het aantal gewenste velden";
$str["LOGGEDINAS"] = "Ingelogd als";
$str["NOTLOGGEDIN"] = "Niet ingelogd";
$str["LOGIN"] = "Login";
$str["LOGIN2"] = "Login met gebruikersnaam en wachtwoord:";
$str["LOGOUT"] = "Loguit";
$str["DETAILS"] = "Details";
$str["LANGUAGE"] = "Taal";
$str["LISTBYSTATUS"] = "status";
$str["LISTBYTEAMS"] = "teams";
$str["LISTBY"] = "Sorteer op";
$str["PICTURE"] = "Afbeelding";
$str["NONPUBLICDETAILS"] = "Details alleen zichtbaar voor leden";
$str["FIRSTPAGE"] = "Eerste pagina";
$str["LASTPAGE"] = "Laatste pagina";
$str["PREVIOUSPAGE"] = "Vorige pagina";
$str["NEXTPAGE"] = "Volgende pagina";
$str["ALL"] = "Alles";
$str["SCORE"] = "Score";
$str["COUNTRY"] = "Land";
$str["EDIT"] = "Bewerk";
$str["DELETE"] = "Verwijder";
$str["PERFORMDELETE"] = "Verwijderen uitvoeren?";
$str["GUEST"] = "Gast";
$str["REPORT"] = "Verslag";
$str["BIRTHDAY"] = "verjaardag";
$str["JOINUS"] = "Wordt lid";
$str["JOINUSFORM"] = "Aanvraagformulier om lid te worden";
$str["PERSONALDETAILS"] = "Persoonlijke details";
$str["JOINSUSADDITIONALINFO"] = "Beschrijf kort waarom je lid wilt worden en andere informatie die interessant voor ons zou kunnen zijn!";
$str["WEWILLCONTACTYOU"] = "Wij zullen zo snel mogelijk contact met je opnemen";
$str["THANKSFORREQUEST"] = "Bedankt voor je aanvraag";
$str["EQUIPMENT"] = "Apparatuur";
$str["GENERALINFORMATIONS"] = "Algemene informatie";
$str["AGE"] = "Leeftijd";
$str["ALLTIMESARE"] = "Alle tijden zijn";
$str["TIMENOWIS"] = "De tijd is nu";
$str["STATUSWARS"] = "Wars zonder status";
$str["TODAYWARS"] = "Wars van vandaag";
$str["WARSSTATUS"] = "Status<br><smallfont>(ingeschreven/nodig)</smallfont>";
$str["ALLSTATUSSET"] = "Op alle spellen is de status ingesteld";
$str["OWNGAMES"] = "Eigen games";
$str["NOENTRY"] = "Geen data";
$str["SITEGENERATEDWITH"] = "Site verwerkt met";
$str["QUERYSIN"] = "queries in";
$str["SIMPLEMODE"] = "Eenvoudige Mode";
$str["ADVANCEDMODE"] = "Geavanceerde Mode";
$str["CLOSECURRENTTAG"] = "Sluit de huidige tag";
$str["CLOSEALLTAGS"] = "Sluit alle tags";
$str["FORMATTEXT"] = "Voer de tekst in:";
$str["FORMATTEXTADDITIONAL"] = "Voer de tekst in - ";
$str["PROMPTLINKTEXT"] = "Voer de tekst in die zich voor zal doen als de link (optioneel):";
$str["PROMPTURLTEXT"] = "Voer de complete URL voor de link in:";
$str["PROMPTMAILTEXT"] = "Voer het e-mailadres voor de link in";
$str["PROMPTLISTITEM"] = "Voer een lijstitem in.\nLaat het hokje leeg of klik op 'Cancel' om de lijst compleet te maken.";
$str["SIZE"] = "grootte";
$str["HUGE"] = "reusachtig";
$str["BIG"] = "groot";
$str["NORMAL"] = "normaal";
$str["SMALL"] = "klein";
$str["FONT"] = "lettertype";
$str["COLOR"] = "kleur";
$str["BOLDTEXT"] = "vette tekst";
$str["ITALICTEXT"] = "cursieve tekst";
$str["UNDERLINEDTEXT"] = "onderstreepte tekst";
$str["CENTER"] = "centreren";
$str["CREATELIST"] = "Maak een lijst";
$str["INSERTHYPERLINK"] = "Voeg een hyperlink in";
$str["INSERTCODE"] = "Voeg een code in";
$str["INSERTMAIL"] = "Voeg een e-mailadres in";
$str["INSERTQUOTE"] = "Voeg een quote in";
$str["INSERTIMAGE"] = "Voeg een afbeelding in";
$str["HELP"] = "Help";
$str["CLICKONARROWTOINSERTCODE"] = "Klik op de pijl om de BBCode in te voegen.<br>Hoofdletters of kleine letters zijn niet belangrijk, URLs worden automatisch aangepast.";
$str["PLAY"] = "gespeeld of wordt nog gespeeld";
$str["CANCELLED"] = "geannuleerd";
$str["OPPONENTLIST"] = "Tegenstanderlijst";
$str["MEMBERGALLERY"] = "Membergallerij";
$str["CONTACTLIST"] = "Adressenlijst";
$str["RECEIVER"] = "Ontvanger";
$str["SENDERNAME"] = "Afzender naam";
$str["SENDERMAIL"] = "Afzender e-mail";
$str["SUBJECT"] = "Onderwerp";
$str["FORMAT"] = "Format";
$str["MESSAGE"] = "Bericht";
$str["CONTENT"] = "Inhoud";
$str["ENTER"] = "Vul in";
$str["SEND"] = "Verstuur";
$str["PRIORITY"] = "Prioriteit";
$str["BACKTONEWS"] = "Terug naar nieuwsdetails";
$str["QUOTE"] = "Quote";
$str["BACK"] = "terug";
$str["BBCODE"] = "BBCode";
$str["IS"] = "is";
$str["TITLE"] = "Titel";
$str["NOICON"] = "Geen icoon";
$str["PREVIEW"] = "Voorbeeld";
$str["TOTAL"] = "Totaal";
$str["GUESTBOOKOF"] = "Gastenboek van";
$str["FUNCTIONDISABLED"] = "Deze functie is <b>uitgeschakeld</b>!";
$str["GOTO"] = "Ga&nbsp;naar";
$str["PASSWORD"] = "Wachtwoord";
$str["FORGOTPASSWORD"] = "Wachtwoord vergeten?";
$str["ARCHIVE"] = "Archief";
$str["CATEGORY"] = "Categorie";
$str["SEARCH"] = "Zoeken";
$str["ENLARGE"] = "Vergroten";
$str["PRINT"] = "Print";
$str["SUBMIT"] = "Versturen";
$str["REDIRECT"] = "Klik hier als je niet langer wilt wachten<br>(of als je browser geen doorsturen ondersteund)";
$str["ENTEREDREGISTEREDDATA"] = "Je hebt geregistreerde gegevens ingevuld (naam, e-mailadres). Verander het naar niet-geregistreerde gegevens!";
$str["SEARCHKEYWORD"] = "Naar trefwoord zoeken";
$str["SEARCHAUTHOR"] = "Naar auteur zoeken";
$str["MATCHEXACTNAME"] = "Als exacte naam zoeken";
$str["MATCHPARTIALNAME"] = "Als gedeelte van een naam zoeken";
$str["USEWILDCARD"] = "Gebruik * (wildcard) om te zoeken naar een deel van een woord";
$str["SEARCHOPTIONS"] = "Je kan <u>AND</u>, <u>OR</u> en <u>NOT</u> gebruiken om gedetailleerder te zoeken";
$str["CONNECTSEARCHES"] = "Je kan het zoeken naar een trefwoord en het zoeken naar een auteur combineren";
$str["USEEXACTPHRASE"] = 'Tekst tussen twee " wordt als exacte woordcombinatie gezocht';
$str["SEARCHIN"] = "Zoeken in";
$str["SEARCHFORRESULTSIN"] = "Naar resultaten zoeken in";
$str["DISPLAYMODE"] = "Weergave";
$str["SEARCHINTEXT"] = "In de tekst zoeken";
$str["SEARCHINSUBJECT"] = "In het onderwerp zoeken";
$str["SHOWASOVERVIEW"] = "Als overzicht laten zien";
$str["SHOWINDETAILS"] = "Details laten zien";
$str["SEARCHFORRESULTS"] = "Zoek naar resultaten";
$str["SORTRESULTBY"] = "Sorteren op";
$str["OF"] = "van";
$str["LASTDAYS0"] = "alle datums";
$str["LASTDAYS1"] = "gisteren";
$str["LASTDAYS7"] = "vorige week";
$str["LASTDAYS14"] = "vorige twee weken";
$str["LASTDAYS30"] = "vorige maand";
$str["LASTDAYS90"] = "vorige drie maanden";
$str["LASTDAYS180"] = "vorige zes maanden";
$str["LASTDAYS365"] = "vorig jaar";
$str["AND"] = "en";
$str["NEWER"] = "nieuwer";
$str["OLDER"] = "ouder";
$str["AUTHOR"] = "Auteur";
$str["NUMLINKS"] = "Aantal links";
$str["ADVANCEDSEARCH"] = "Geavanceerd zoeken";
$str["REQUIREDFIELDS"] = 'Velden gemarkeerd met <font color="red">*</font> zijn noodzakelijk';
$str["OR"] = "of";
$str["LENGTHSEARCHWORD"] = "Het zoekwoord moet minstens uit 3 letters bestaan";
$str["SEARCHINFORMATION"] = "Zoekinformatie";
$str["NEWSCOMMENTS"] = "Nieuws opmerkingen";
$str["SENDNEWS"] = "Verstuur nieuws";
$str["RECEIVERMAIL"] = "Ontvanger e-mail";
$str["MOREFUNCTION"] = "Meer-functie: <b>ingeschakeld</b><br>Je kan je tekst opdelen met";
$str["SUBMITTED"] = "(verzonden)";
$str["AREYOUSURETODELETE"] = "Weet je zeker dat je het geselecteerde item wilt verwijderen?";
$str["NORMALMODE"] = "Normaal Mode";
$str["LISTMODE"] = "Lijst Mode";
$str["PROMPTLISTTYPE"] = "Type Lijst: '1' = genummerd, 'a' = alfabetisch,\n'I' = Romeinse cijfers, laat leeg = bolletjes";
$str["LASTEDITEDBY"] = "Last edited by";

## ---- START CUSTOM PART ---- ##
## ---- START "GB" ---- ##

$str["GB_NAME"] = "Gastenboek";

$str["GB_INFOLINE"] = "%1 %2 op %3 %4";

$str["GB_PAGE"] = "Pagina";

$str["GB_PAGES"] = "Pagina&#8217;s";

$str["GB_ENTRY"] = "Bericht";

$str["GB_ENTRIES"] = "Berichten";

$str["GB_ADDENTRY"] = "Voeg bericht toe";

$str["GB_ADDANENTRY"] = "Voeg een bericht toe aan het gastenboek";

$str["GB_EDITANENTRY"] = "Bewerk een bericht";

$str["GB_EDITENTRY"] = "Bewerk bericht";

$str["GB_BACKTOGB"] = "Terug naar gastenboek";

$str["GB_WARNINGNAME"] = "Voer een naam in a.u.b.!";

$str["GB_WARNINGTEXT"] = "Voer een tekst in a.u.b.!";

$str["GB_ADDNAME"] = "Naam";

$str["GB_ADDEMAIL"] = "e-mail";

$str["GB_ADDHOMEPAGE"] = "Homepage";

$str["GB_ADDICQ"] = "ICQ-UIN";

$str["GB_ADDAIM"] = "AIM";

$str["GB_ADDYIM"] = "YIM";

$str["GB_ADDMSN"] = "MSN";

$str["GB_TITLE"] = "Titel";

$str["GB_BLOCKED"] = "Je hebt al een bericht geschreven in de laatste <b>%1 %2</b>.";

$str["GB_MINUTE"] = "Minuut";

$str["GB_MINUTES"] = "Minuten";

$str["GB_COMMENT"] = "Opmerking";

$str["GB_COMMENTS"] = "Opmerkingen";

$str["GB_ENTRYBY"] = "Gastenboekbericht van";

## ---- END "GB" ---- ##
## ---- START "SPONSOR" ---- ##
$str["SPONSOR_CATEGORY"] = "Categorie";
$str["SPONSOR_SEARCH"] = "Zoek Sponsor";
$str["SPONSOR_NAME"] = "Links";
$str["SPONSOR_HITS"] = "Hits";
$str["SPONSOR_LANGUAGE"] = "Taal";
$str["SPONSOR_OPTION"] = "Opties";
$str["SPONSOR_DETAILS"] = "Details";
$str["SPONSOR_REDIRECT"] = "Klik hier als je niet langer wilt wachten<br>(of als je browser geen doorsturen ondersteund)";
$str["SPONSOR_LINKNAME"] = "Sponsornaam";
$str["SPONSOR_HOMEPAGE"] = "Website";
$str["SPONSOR_DESCRIPTION"] = "Sponsor Omschrijving";
$str["SPONSOR_BACK"] = "Terug";
$str["SPONSOR_BANNERURL"] = "Banner URL is fout";
$str["SPONSOR_BANNERNOT"] = "Geen Banner beschikbaar";
## ---- END "SPONSOR" ---- ##

## ---- START "SEX" ---- ##
$sex_array = array(
	"me" => "Man",
	"wo" => "Vrouw",
	"no" => "Geen commentaar",
);
$str["SEX"] = "Sex";
## ---- END "SEX" ---- ##
$str["WARTAG"]="War Tag";
## ---- END CUSTOM PART ---- ##
?>
