<?php //vwar
/* #####################################################################################
 *
 * $Id: hungarian.inc.php,v 1.7 2004/02/21 14:21:21 frag Exp $
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
	"af" => "Afganisztán",
	"al" => "Albánia",
	"am" => "Arménia",
	"an" => "Andorra",
	"ao" => "Angola",
	"ar" => "Argentína",
	"at" => "Ausztria",
	"au" => "Ausztrália",
	"aw" => "Aruba",
	"az" => "Azerbajdzsán",
	"ba" => "Bosznia Hercegovina",
	"bb" => "Barbados",
	"bd" => "Banglades",
	"be" => "Belgium",
	"bf" => "Burkina Faso",
	"bg" => "Bulgária",
	"bh" => "Bahrain",
	"bi" => "Burundi",
	"bj" => "Benin",
	"bm" => "Bermuda",
	"bn" => "Brunei Darussalam",
	"bo" => "Bolívia",
	"br" => "Brazília",
	"bs" => "Bahamák",
	"bt" => "Bhután",
	"bw" => "Botswana",
	"bx" => "Benelux Államok",
	"by" => "Belarusz",
	"bz" => "Belize",
	"ca" => "Kanada",
	"cf" => "Közép-Afrikai Köztársaság",
	"cg" => "Kongó",
	"ch" => "Svájc",
	"ci" => "Elefántcsontpart",
	"ck" => "Cook Szigetek",
	"cm" => "Kamerun",
	"cn" => "Kína",
	"co" => "Kolumbia",
	"cr" => "Costa Rica",
	"cu" => "Kuba",
	"cv" => "Cape Verde",
	"cy" => "Ciprus",
	"cz" => "Csehország",
	"de" => "Németország",
	"dk" => "Dánia",
	"dz" => "Algéria",
	"ec" => "Ecuador",
	"ee" => "Esztónia",
	"eg" => "Egyiptom",
	"er" => "Eritrea",
	"es" => "Spanyolország",
	"et" => "Etiópia",
	"eu" => "Európa",
	"fi" => "Finnország",
	"fj" => "Fidzsi-szigetek",
	"fo" => "Fülöp-szigetek",
	"fr" => "Franciaország",
	"ga" => "Gabon",
	"ge" => "Georgia",
	"gi" => "Gibraltár",
	"gl" => "Greenland",
	"gp" => "Guadeloupe",
	"gr" => "Görögország",
	"gt" => "Guatemala",
	"gu" => "Guam",
	"gy" => "Guyana",
	"hk" => "Hong Kong",
	"hr" => "Horvátország",
	"ht" => "Haiti",
	"hu" => "Magyarország",
	"id" => "Indonézia",
	"ie" => "Írország",
	"il" => "Izreal",
	"in" => "India",
	"int" => "Nemzetközi",
	"iq" => "Irak",
	"ir" => "Irán",
	"is" => "Izland",
	"it" => "Olaszország",
	"jm" => "Jamaika",
	"jo" => "Jordánia",
	"jp" => "Japán",
	"ke" => "Kenya",
	"kg" => "Kirgizisztán",
	"kh" => "Kambodzsa",
	"ki" => "Kiribati",
	"kp" => "Észak-Kórea",
	"kr" => "Kóreai Köztársaság",
	"ky" => "Kajmán Szigetek",
	"kz" => "Kazahsztán",
	"lb" => "Libanon",
	"lc" => "Saint Lucia",
	"li" => "Liechtenstein",
	"lk" => "Srí Lanka",
	"lt" => "Litvánia",
	"lu" => "Luxemburg",
	"lv" => "Lettország",
	"ly" => "Líbia",
	"ma" => "Marokkó",
	"mc" => "Monaco",
	"md" => "Moldovai Köztársaság",
	"mg" => "Madagaszkár",
	"mn" => "Mongólia",
	"mo" => "Makaó",
	"mp" => "Northern Mariana Islands",
	"ms" => "Montserrat",
	"mt" => "Málta",
	"mx" => "Mexikó",
	"my" => "Malájzia",
	"mz" => "Mozambik",
	"na" => "Namibia",
	"nc" => "New Caledonia",
	"nf" => "Norfolk Island",
	"nl" => "Hollandia",
	"no" => "Norvégia",
	"np" => "Nepál",
	"nr" => "Nauru",
	"nz" => "Új-Zéaland",
	"om" => "Omán",
	"pa" => "Panama",
	"pe" => "Peru",
	"pf" => "Francia Polinéziák",
	"ph" => "Fülöp-szigetek",
	"pk" => "Pakisztán",
	"pl" => "Lengyelország",
	"pm" => "St. Pierre and Miquelon",
	"pr" => "Puerto Rico",
	"pt" => "Portugália",
	"py" => "Paraguay",
	"qa" => "Qatar",
	"ro" => "Románia",
	"ru" => "Oroszország",
	"sa" => "Szaúd-Arábia",
	"sb" => "Salamon-szigetek",
	"sca" => "Skandinávia",
	"sd" => "Szudán",
	"se" => "Svédország",
	"sg" => "Szingapur",
	"si" => "Szlovénia",
	"sk" => "Szlovákia",
	"sl" => "Sierra Leone",
	"so" => "Szomália",
	"tc" => "Turks and Caicos Islands",
	"tg" => "Togo",
	"th" => "Thaiföld",
	"tn" => "Tunézia",
	"to" => "Tonga",
	"tp" => "East Timor",
	"tr" => "Törökország",
	"tt" => "Trinidad és Tobago",
	"tv" => "Tuvalu",
	"tw" => "Taiwan",
	"tz" => "Tanzánia",
	"ua" => "Ukrajna",
	"ug" => "Uganda",
	"uk" => "Nagy-Britannia",
	"us" => "Amerika",
	"uy" => "Uruguay",
	"va" => "Vatikán",
	"ve" => "Venezuela",
	"vg" => "Virgin Szigetek (Angol)",
	"vi" => "Virgin Szigetek (Amerikai)",
	"vn" => "Vietnám",
	"ws" => "Samoa",
	"ye" => "Yemen",
	"yu" => "Jugoszlávia",
	"za" => "Dél-Afrika",
	"zw" => "Zimbabwe"
);

## ------------------------------ DEFINE MONTH NAMES -------------------------------- ##
$monthnames = array(
	"1" => "Január",
	"2" => "Február",
	"3" => "Március",
	"4" => "Április",
	"5" => "Május",
	"6" => "Június",
	"7" => "Július",
	"8" => "Augusztus",
	"9" => "Szeptember",
	"10" => "Október",
	"11" => "November",
	"12" => "December"
);

## ----------------------------- DEFINE WEEKDAY NAMES ------------------------------- ##
$weekdaynames = array(
	"Vas",
	"Hé",
	"Ke",
	"Szer",
	"Csüt",
	"Pé",
	"Szo"
);

## ------------------------------- DEFINE LANGUAGES --------------------------------- ##
$languages = array(
	"german" => "Német",
	"english" => "Angol",
	"french" => "Francia",
	"danish" => "Dán",
	"dutch" => "Holland",
	"spanish" => "Spanyol",
	"portuguese" => "Portugál",
	"italian" => "Olasz",
	"hungarian" => "Magyar"
);

## ------------------------- DEFINE GLOBAL LANGUAGE VARS ---------------------------- ##
$str["SHOWIP"] = "Mutasd az IP-t";
$str["NEWCOMMENT"] = "Új komment";
$str["ADDCOMMENT"] = "Komment fûzése";
$str["EDITCOMMENT"] = "Komment szerkesztése";
$str["DELETECOMMENT"] = "Komment törlése";
$str["COMMENT"] = "Komment";
$str["COMMENTS"] = "Kommentek";
$str["ENTERCOMMENT"] = "Szólj hozzá";
$str["BACKTOCOMMENTS"] = "Vissza a kommentekhez";
$str["ADD"] = "Hozzáad";
$str["CLOSEWINDOW"] = "Bezár";
$str["CLICKONSMILIETOINSERT"] = "Klikk a beillesztáshez";
$str["INSERTTHISSMILIE"] = "Illeszd be ezt a smiley-t";
$str["MORE"] = "még több";
$str["PLEASECHOOSE"] = "Válassz";
$str["STATISTICS"] = "Statisztikák";
$str["AVAILABLE"] = "választható";
$str["YES"] = "Igen";
$str["NO"] = "Nem";
$str["SHORT"] = "rövid";
$str["NOTAVAILABLE"] = "nincs meg";
$str["NOTAVAILABLESHORT"] = "n/a";
$str["DATE"] = "Dátum";
$str["DAY"] = "Nap";
$str["MONTH"] = "Hónap";
$str["YEAR"] = "Év";
$str["TIME"] = "Idô";
$str["OPPONENT"] = "Ellenfél";
$str["GAME"] = "Játék";
$str["RESULT"] = "Eredmény";
$str["CURRENTLY"] = "Jelenleg";
$str["SHOW"] = "Mutasd";
$str["CHALLENGEUS"] = "Kihívás";
$str["LEGEND"] = "Jelmagyarázat";
$str["NAME"]="Név";
$str["SERVER"] = "Szerver";
$str["FULL"] = "teli";
$str["CONTACT"] = "Kontakt";
$str["PLAYERS"] = "Játékosok";
$str["PLAYERPERTEAM"] = "Játékos csapatonként";
$str["LOCATIONS"] = "Pályák";
$str["LOCATION"] = "Pálya";
$str["OWNSCORES"] = "Saját eredmények";
$str["OPPSCORES"] = "Ellenfél eredményei";
$str["AVERAGE"] = "átlagos";
$str["ADDITIONALINFO"] = "További info";
$str["SIGNEDMEMBERS"] = "Jelentkezett tagok";
$str["MOREREQUIRED"] = "több szükséges";
$str["OPTIONS"] = "Opciók";
$str["SIGNUP"] = "Jelentkezés";
$str["SIGNOFF"] = "Leiratkozás";
$str["CALENDAR"] = "Naptár";
$str["JUMPTOCURRENTMONTH"] = "Ugrás az aktuális hónapra";
$str["ON"] = "Be";
$str["OFF"] = "Ki";
$str["HTMLIS"] = "HTML";
$str["SMILIES"] = "Smilie-k";
$str["ARE"] = "vannak";
$str["BBCODE"] = "BB kód";
$str["IS"] = "van";
$str["EVENTCALENDAR"] = "Eseménynaptár";
$str["EVENTDETAILS"] = "Esemény adatai";
$str["BACKTOCALENDAR"] = "Vissza a naptárhoz";
$str["ADDEDBY"] = "Írta";
$str["VISITHOMEPAGE"] = "Nézd meg a honlapját";
$str["ADDTOCONTACTLIST"] = "Kontaktlistához adni";
$str["CLICKMEMBERPROFILE"] = "Kattints a ".makeimgtag($vwar_root . "images/button_profile.gif")." az adatokhoz";
$str["SHOWDETAILS"] = "Adatok";
$str["GAMES"] = "Játékok";
$str["SENDMAILTO"] = "Email küldése";
$str["PROFILEOF"] = "Profil";
$str["PROFILELOCATION"] = "Város";
$str["PROFILEBIRTHDAY"] = "Születésnap";
$str["PROFILEINTERESTS"] = "Érdeklôdési kör";
$str["PROFILEGRAPHICCARD"] = "Grafikus kártya";
$str["PROFILECONNECTION"] = "Kapcsolat";
$str["PROFILEKEYBOARD"] = "Billentyûzet";
$str["PROFILEMOUSE"] = "Egér";
$str["PHONENUMBERS"] = "Telefonszámok";
$str["ONLYVISIBLETOMEMBERS"] = "Csak tagoknak";
$str["PHONE"] = "Telefon";
$str["CELLULARPHONE"] = "Mobiltelefon";
$str["BACKTOWARLIST"] = "Vissza a csatákhoz";
$str["BACKTOMEMBERLIST"] = "Vissza a tagokhoz";
$str["BACKTOWARDETAILS"] = "Vissza az adatokhoz";
$str["GAMESPLAYED"] = "játszott meccsek";
$str["SHOWALL"] = "Mind";
$str["ENTERNAME"] = "Írj be egy nevet";
$str["RESULTS"] = "Eredmények";
$str["OTHERGAMESAGAINST"] = "Régebbi meccsek";
$str["PAGE"] = "Oldal";
$str["SORTTHISFIELDASC"] = "Rendezd emelkedôbe";
$str["SORTTHISFIELDDESC"] = "Rendezd csökkenôbe";
$str["ASCENDING"] = "emelkedô";
$str["DESCENDING"] = "csökkenô";
$str["CHALLENGE"] = "Kihívás";
$str["GENERAL"] = "Általános";
$str["GAMETYPE"] = "Játéktípus";
$str["MATCHTYPE"] = "Meccstípus";
$str["SELECT"] = "Válassz";
$str["ENTERTEAMNAME"] = "Csapatnév";
$str["ENTERSHORTTEAMNAME"] = "Csapatnév (rövid)";
$str["ENTERCONTACTNAME"] = "Kontaktnév";
$str["ENTERCONTACTEMAIL"] = "Kontakt E-Mail";
$str["CHALLENGEFORM"] = "Kihívás formula";
$str["TEAM"] = "Csapat";
$str["ADDITIONALINFOFULL"] = "Megadhatsz további információkat (pld. speciális beállítások) vagy bármit, amirôl szeretnéd, ha emellett tudnánk";
$str["SELECTASMANY"] = "Válassz annyit, amennyi szükséges";
$str["LOGGEDINAS"] = "Bejelentkezve";
$str["NOTLOGGEDIN"] = "Nem vagy bejelentkezve";
$str["LOGIN"] = "Bejelentkezés";
$str["LOGIN2"] = "Jelentkezz be a user névvel és a kóddal:";
$str["LOGOUT"] = "Kijelentkezés";
$str["DETAILS"] = "Adatok";
$str["LANGUAGE"] = "Nyelv";
$str["LISTBYSTATUS"] = "Tagstátus";
$str["LISTBYTEAMS"] = "Csapatok";
$str["LISTBY"] = "Listázás";
$str["PICTURE"] = "Kép";
$str["NONPUBLICDETAILS"] = "Nem publikus adatok <small>(only visible to members)</small>";
$str["FIRSTPAGE"] = "Elsô oldal";
$str["LASTPAGE"] = "Utolsó oldal";
$str["PREVIOUSPAGE"] = "Elôzô oldal";
$str["NEXTPAGE"] = "Következô oldal";
$str["ALL"] = "Mind";
$str["SCORE"] = "Eredmény";
$str["COUNTRY"] = "Ország";
$str["EDIT"] = "Szerkeszt";
$str["DELETE"] = "Töröl";
$str["PERFORMDELETE"] = "Biztos, hogy töröl?";
$str["GUEST"] = "Vendég";
$str["REPORT"] = "Jelentés";
$str["BIRTHDAY"] = "Születésnap";
$str["JOINUS"] = "Csatlakozz";
$str["JOINUSFORM"] = "Jelentkezési ûrlap";
$str["PERSONALDETAILS"] = "Személyes adatok";
$str["JOINSUSADDITIONALINFO"] = "Röviden írd le miért szeretnél csatlakozni hozzánk és mi az, ami érdekelne minket Veled kapcsolatban!";
$str["WEWILLCONTACTYOU"] = "Amint tudunk, kapcsolatba lépünk Veled";
$str["THANKSFORREQUEST"] = "Köszönjük a kérésedet";
$str["EQUIPMENT"] = "Felszerelés";
$str["GENERALINFORMATIONS"] = "Általános információk";
$str["AGE"] = "Kor";
$str["ALLTIMESARE"] = "Az összes idô";
$str["TIMENOWIS"] = "Az idô most";
$str["STATUSWARS"] = "Státus nélküli csaták";
$str["TODAYWARS"] = "Mai csaták";
$str["WARSSTATUS"] = "Státus<br><smallfont>(signed up/required)</smallfont>";
$str["ALLSTATUSSET"] = "At all wars the status has been set";
$str["OWNGAMES"] = "Saját játékok";
$str["NOENTRY"] = "Nincs bejegyzés";
$str["SITEGENERATEDWITH"] = "Az oldalt generálta";
$str["QUERYSIN"] = "Kérdések";
$str["SIMPLEMODE"] = "Egyszerû mód";
$str["ADVANCEDMODE"] = "Haladó mód";
$str["CLOSECURRENTTAG"] = "Zárd be az aktuális címkét";
$str["CLOSEALLTAGS"] = "Zárj be minden címkét";
$str["FORMATTEXT"] = "Formázandó szöveg:";
$str["FORMATTEXTADDITIONAL"] = "Formázandó szöveg - ";
$str["PROMPTLINKTEXT"] = "Link magyarázat (tetszôleges):";
$str["PROMPTURLTEXT"] = "Link teljesen hivatkozása:";
$str["PROMPTMAILTEXT"] = "Link E-Mail címe";
$str["PROMPTLISTITEM"] = "Lista adat megadása.\nHagyd üresen a mezôt, vagy kattints a 'Cancel'-re a lista befejezéséhez.";
$str["SIZE"] = "méret";
$str["HUGE"] = "hatalmas";
$str["BIG"] = "nagy";
$str["NORMAL"] = "normál";
$str["SMALL"] = "kicsi";
$str["FONT"] = "betû";
$str["COLOR"] = "szín";
$str["BOLDTEXT"] = "Félkövér";
$str["ITALICTEXT"] = "Dôlt";
$str["UNDERLINEDTEXT"] = "Aláhúzott";
$str["CENTER"] = "Középre";
$str["CREATELIST"] = "Lista készítése";
$str["INSERTHYPERLINK"] = "Link beszúrása";
$str["INSERTCODE"] = "Kód beszúrása";
$str["INSERTMAIL"] = "Email beszúrása";
$str["INSERTQUOTE"] = "Insert a Quote";
$str["INSERTIMAGE"] = "Kép beszúrása";
$str["HELP"] = "Súgó";
$str["CLICKONARROWTOINSERTCODE"] = "Kattints a nyílra a BB kód beszúrásához.<br>Mindegy, hogy kicsi vagy nagybetû, az URL-ek automatikusan vannak alakítva.";
$str["PLAY"] = "játszott vagy kell még játszania";
$str["CANCELLED"] = "lemondták";
$str["OPPONENTLIST"] = "Ellenfél lista";
$str["MEMBERGALLERY"] = "Tagok galériája";
$str["CONTACTLIST"] = "Kontakt lista";
$str["RECEIVER"] = "Fogadó";
$str["SENDERNAME"] = "Feladó neve";
$str["SENDERMAIL"] = "Feladó Email-je";
$str["SUBJECT"] = "Tárgy";
$str["FORMAT"] = "Formátum";
$str["MESSAGE"] = "Üzenet";
$str["CONTENT"] = "Tartalom";
$str["ENTER"] = "Belépés";
$str["SEND"] = "Küldés";
$str["PRIORITY"] = "Prioritás";
$str["BACKTONEWS"] = "Vissza a hír adataihoz";
$str["QUOTE"] = "Hivatkozás";
$str["BACK"] = "vissza";
$str["TITLE"] = "Cím";
$str["NOICON"] = "Nincs ikon";
$str["PREVIEW"] = "Elônézet";
$str["TOTAL"] = "Összes";
$str["GUESTBOOKOF"] = "Vendégkönyve";
$str["FUNCTIONDISABLED"] = "Funkció <b>letiltva</b>!";
$str["GOTO"] = "Ugrás";
$str["PASSWORD"] = "Kód";
$str["FORGOTPASSWORD"] = "Elfelejtette jelszavát?";
$str["ARCHIVE"] = "Arhívum";
$str["CATEGORY"] = "Kategória";
$str["SEARCH"] = "Keresés";
$str["ENLARGE"] = "Nagyít";
$str["PRINT"] = "Nyomtat";
$str["SUBMIT"] = "Küldés";
$str["REDIRECT"] = "Kattints ide, ha nem szeretnél tovább várni<br>(vagy ha a böngészôd nem továbbít automatikusan)";
$str["ENTEREDREGISTEREDDATA"] = "Már regisztrált adatot írtál be (Név, E-Mail). Még nem használt adatokat adjál meg!";
$str["SEARCHKEYWORD"] = "Keresés kulcsszóra";
$str["SEARCHAUTHOR"] = "Keresés szerzôre";
$str["MATCHEXACTNAME"] = "Teljes megfelelés";
$str["MATCHPARTIALNAME"] = "Részleges megfelelés";
$str["USEWILDCARD"] = 'Használd a "*"-t, mint jokert részleges keresésnél';
$str["SEARCHOPTIONS"] = "Használhatod az <u>ÉS</u>, <u>VAGY</u> és <u>NEM</u> szavakat részletesebb kereséshez";
$str["CONNECTSEARCHES"] = "Kulcsszó keresését összekapcsolhatod a szerzô keresésével";
$str["USEEXACTPHRASE"] = 'A "-k közötti szöveg teljes kifejezésként lesz keresve';
$str["SEARCHIN"] = "Keress ebben";
$str["SEARCHFORRESULTSIN"] = "Keress találatokat ebben";
$str["DISPLAYMODE"] = "Kijelzés módja";
$str["SEARCHINTEXT"] = "Keress szövegben";
$str["SEARCHINSUBJECT"] = "Keress a tárgyban";
$str["SHOWASOVERVIEW"] = "Áttekintô nézet";
$str["SHOWINDETAILS"] = "Részletes nézet";
$str["SEARCHFORRESULTS"] = "Erdemények keresése";
$str["SORTRESULTBY"] = "Eredmény rendezése";
$str["OF"] = "";
$str["LASTDAYS0"] = "bármikor";
$str["LASTDAYS1"] = "tegnap";
$str["LASTDAYS7"] = "múlt hét";
$str["LASTDAYS14"] = "utolsó két hét";
$str["LASTDAYS30"] = "múlt hónap";
$str["LASTDAYS90"] = "utolsó három hónap";
$str["LASTDAYS180"] = "utolsó 6 hónap";
$str["LASTDAYS365"] = "elôzô év";
$str["AND"] = "és";
$str["NEWER"] = "newer";
$str["OLDER"] = "older";
$str["AUTHOR"] = "Szerzô";
$str["NUMLINKS"] = "Linkek száma";
$str["ADVANCEDSEARCH"] = "Részletes keresés";
$str["REQUIREDFIELDS"] = 'A <font color="red">*</font>-al jelölt mezôk kitöltése kötelezô';
$str["OR"] = "vagy";
$str["LENGTHSEARCHWORD"] = "A keresendô szó minimum 3 betûs legyen.";
$str["SEARCHINFORMATION"] = "Információ keresése";
$str["NEWSCOMMENTS"] = "Hírkommentek";
$str["SENDNEWS"] = "Hír küldése";
$str["RECEIVERMAIL"] = "Fogadó E-Mail-je";
$str["MOREFUNCTION"] = "Több funkció: <b>engedélyezve</b><br>A tartalmat feloszhatod";
$str["SUBMITTED"] = "(alávetve)";
$str["AREYOUSURETODELETE"] = "Biztos, hogy törölni akarod a kiválasztott elemet?";
$str["NORMALMODE"] = "Normál mód";
$str["LISTMODE"] = "Lista mód";
$str["PROMPTLISTTYPE"] = "Lista típusok: '1' = arab sorszámos, 'a' = kisbetûs,\n'I' = római sorszámos, üres = golyós";
$str["LASTEDITEDBY"] = "Utoljára módosította:";

## ---- START CUSTOM PART ---- ##
## ---- START "GB" ---- ##

$str["GB_NAME"] = "Vendékönyv";

$str["GB_INFOLINE"] = "%1 %2 %3 %4on";

$str["GB_PAGE"] = "Oldal";

$str["GB_PAGES"] = "Oldalak";

$str["GB_ENTRY"] = "Bejegyzés";

$str["GB_ENTRIES"] = "Bejegyzések";

$str["GB_ADDENTRY"] = "Bejegyzés hozzáadása";

$str["GB_ADDANENTRY"] = "Vendégkönyvbe írás";

$str["GB_EDITANENTRY"] = "Egy bejegyzés szerkesztése";

$str["GB_EDITENTRY"] = "Bejegyzés szerkesztése";

$str["GB_BACKTOGB"] = "Vissza a vendégkönyvhöz";

$str["GB_WARNINGNAME"] = "Írjál be egy nevet!";

$str["GB_WARNINGTEXT"] = "Írjál be szöveget!";

$str["GB_ADDNAME"] = "Név";

$str["GB_ADDEMAIL"] = "E-Mail";

$str["GB_ADDHOMEPAGE"] = "Weboldal";

$str["GB_ADDICQ"] = "ICQ-UIN";

$str["GB_ADDAIM"] = "AIM";

$str["GB_ADDYIM"] = "YIM";

$str["GB_ADDMSN"] = "MSN";

$str["GB_TITLE"] = "Cím";

$str["GB_BLOCKED"] = "Már írtál egy bejegyzést az utolsó <b>%1 %2</b>.";

$str["GB_MINUTE"] = "Perc";

$str["GB_MINUTES"] = "Percek";

$str["GB_COMMENT"] = "Komment";

$str["GB_COMMENTS"] = "Kommentek";

$str["GB_ENTRYBY"] = "Vengédkönyvbe bejegyezte";

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
