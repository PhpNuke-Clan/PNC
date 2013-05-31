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
	"af" => "Afganiszt�n",
	"al" => "Alb�nia",
	"am" => "Arm�nia",
	"an" => "Andorra",
	"ao" => "Angola",
	"ar" => "Argent�na",
	"at" => "Ausztria",
	"au" => "Ausztr�lia",
	"aw" => "Aruba",
	"az" => "Azerbajdzs�n",
	"ba" => "Bosznia Hercegovina",
	"bb" => "Barbados",
	"bd" => "Banglades",
	"be" => "Belgium",
	"bf" => "Burkina Faso",
	"bg" => "Bulg�ria",
	"bh" => "Bahrain",
	"bi" => "Burundi",
	"bj" => "Benin",
	"bm" => "Bermuda",
	"bn" => "Brunei Darussalam",
	"bo" => "Bol�via",
	"br" => "Braz�lia",
	"bs" => "Baham�k",
	"bt" => "Bhut�n",
	"bw" => "Botswana",
	"bx" => "Benelux �llamok",
	"by" => "Belarusz",
	"bz" => "Belize",
	"ca" => "Kanada",
	"cf" => "K�z�p-Afrikai K�zt�rsas�g",
	"cg" => "Kong�",
	"ch" => "Sv�jc",
	"ci" => "Elef�ntcsontpart",
	"ck" => "Cook Szigetek",
	"cm" => "Kamerun",
	"cn" => "K�na",
	"co" => "Kolumbia",
	"cr" => "Costa Rica",
	"cu" => "Kuba",
	"cv" => "Cape Verde",
	"cy" => "Ciprus",
	"cz" => "Csehorsz�g",
	"de" => "N�metorsz�g",
	"dk" => "D�nia",
	"dz" => "Alg�ria",
	"ec" => "Ecuador",
	"ee" => "Eszt�nia",
	"eg" => "Egyiptom",
	"er" => "Eritrea",
	"es" => "Spanyolorsz�g",
	"et" => "Eti�pia",
	"eu" => "Eur�pa",
	"fi" => "Finnorsz�g",
	"fj" => "Fidzsi-szigetek",
	"fo" => "F�l�p-szigetek",
	"fr" => "Franciaorsz�g",
	"ga" => "Gabon",
	"ge" => "Georgia",
	"gi" => "Gibralt�r",
	"gl" => "Greenland",
	"gp" => "Guadeloupe",
	"gr" => "G�r�gorsz�g",
	"gt" => "Guatemala",
	"gu" => "Guam",
	"gy" => "Guyana",
	"hk" => "Hong Kong",
	"hr" => "Horv�torsz�g",
	"ht" => "Haiti",
	"hu" => "Magyarorsz�g",
	"id" => "Indon�zia",
	"ie" => "�rorsz�g",
	"il" => "Izreal",
	"in" => "India",
	"int" => "Nemzetk�zi",
	"iq" => "Irak",
	"ir" => "Ir�n",
	"is" => "Izland",
	"it" => "Olaszorsz�g",
	"jm" => "Jamaika",
	"jo" => "Jord�nia",
	"jp" => "Jap�n",
	"ke" => "Kenya",
	"kg" => "Kirgiziszt�n",
	"kh" => "Kambodzsa",
	"ki" => "Kiribati",
	"kp" => "�szak-K�rea",
	"kr" => "K�reai K�zt�rsas�g",
	"ky" => "Kajm�n Szigetek",
	"kz" => "Kazahszt�n",
	"lb" => "Libanon",
	"lc" => "Saint Lucia",
	"li" => "Liechtenstein",
	"lk" => "Sr� Lanka",
	"lt" => "Litv�nia",
	"lu" => "Luxemburg",
	"lv" => "Lettorsz�g",
	"ly" => "L�bia",
	"ma" => "Marokk�",
	"mc" => "Monaco",
	"md" => "Moldovai K�zt�rsas�g",
	"mg" => "Madagaszk�r",
	"mn" => "Mong�lia",
	"mo" => "Maka�",
	"mp" => "Northern Mariana Islands",
	"ms" => "Montserrat",
	"mt" => "M�lta",
	"mx" => "Mexik�",
	"my" => "Mal�jzia",
	"mz" => "Mozambik",
	"na" => "Namibia",
	"nc" => "New Caledonia",
	"nf" => "Norfolk Island",
	"nl" => "Hollandia",
	"no" => "Norv�gia",
	"np" => "Nep�l",
	"nr" => "Nauru",
	"nz" => "�j-Z�aland",
	"om" => "Om�n",
	"pa" => "Panama",
	"pe" => "Peru",
	"pf" => "Francia Polin�zi�k",
	"ph" => "F�l�p-szigetek",
	"pk" => "Pakiszt�n",
	"pl" => "Lengyelorsz�g",
	"pm" => "St. Pierre and Miquelon",
	"pr" => "Puerto Rico",
	"pt" => "Portug�lia",
	"py" => "Paraguay",
	"qa" => "Qatar",
	"ro" => "Rom�nia",
	"ru" => "Oroszorsz�g",
	"sa" => "Sza�d-Ar�bia",
	"sb" => "Salamon-szigetek",
	"sca" => "Skandin�via",
	"sd" => "Szud�n",
	"se" => "Sv�dorsz�g",
	"sg" => "Szingapur",
	"si" => "Szlov�nia",
	"sk" => "Szlov�kia",
	"sl" => "Sierra Leone",
	"so" => "Szom�lia",
	"tc" => "Turks and Caicos Islands",
	"tg" => "Togo",
	"th" => "Thaif�ld",
	"tn" => "Tun�zia",
	"to" => "Tonga",
	"tp" => "East Timor",
	"tr" => "T�r�korsz�g",
	"tt" => "Trinidad �s Tobago",
	"tv" => "Tuvalu",
	"tw" => "Taiwan",
	"tz" => "Tanz�nia",
	"ua" => "Ukrajna",
	"ug" => "Uganda",
	"uk" => "Nagy-Britannia",
	"us" => "Amerika",
	"uy" => "Uruguay",
	"va" => "Vatik�n",
	"ve" => "Venezuela",
	"vg" => "Virgin Szigetek (Angol)",
	"vi" => "Virgin Szigetek (Amerikai)",
	"vn" => "Vietn�m",
	"ws" => "Samoa",
	"ye" => "Yemen",
	"yu" => "Jugoszl�via",
	"za" => "D�l-Afrika",
	"zw" => "Zimbabwe"
);

## ------------------------------ DEFINE MONTH NAMES -------------------------------- ##
$monthnames = array(
	"1" => "Janu�r",
	"2" => "Febru�r",
	"3" => "M�rcius",
	"4" => "�prilis",
	"5" => "M�jus",
	"6" => "J�nius",
	"7" => "J�lius",
	"8" => "Augusztus",
	"9" => "Szeptember",
	"10" => "Okt�ber",
	"11" => "November",
	"12" => "December"
);

## ----------------------------- DEFINE WEEKDAY NAMES ------------------------------- ##
$weekdaynames = array(
	"Vas",
	"H�",
	"Ke",
	"Szer",
	"Cs�t",
	"P�",
	"Szo"
);

## ------------------------------- DEFINE LANGUAGES --------------------------------- ##
$languages = array(
	"german" => "N�met",
	"english" => "Angol",
	"french" => "Francia",
	"danish" => "D�n",
	"dutch" => "Holland",
	"spanish" => "Spanyol",
	"portuguese" => "Portug�l",
	"italian" => "Olasz",
	"hungarian" => "Magyar"
);

## ------------------------- DEFINE GLOBAL LANGUAGE VARS ---------------------------- ##
$str["SHOWIP"] = "Mutasd az IP-t";
$str["NEWCOMMENT"] = "�j komment";
$str["ADDCOMMENT"] = "Komment f�z�se";
$str["EDITCOMMENT"] = "Komment szerkeszt�se";
$str["DELETECOMMENT"] = "Komment t�rl�se";
$str["COMMENT"] = "Komment";
$str["COMMENTS"] = "Kommentek";
$str["ENTERCOMMENT"] = "Sz�lj hozz�";
$str["BACKTOCOMMENTS"] = "Vissza a kommentekhez";
$str["ADD"] = "Hozz�ad";
$str["CLOSEWINDOW"] = "Bez�r";
$str["CLICKONSMILIETOINSERT"] = "Klikk a beilleszt�shez";
$str["INSERTTHISSMILIE"] = "Illeszd be ezt a smiley-t";
$str["MORE"] = "m�g t�bb";
$str["PLEASECHOOSE"] = "V�lassz";
$str["STATISTICS"] = "Statisztik�k";
$str["AVAILABLE"] = "v�laszthat�";
$str["YES"] = "Igen";
$str["NO"] = "Nem";
$str["SHORT"] = "r�vid";
$str["NOTAVAILABLE"] = "nincs meg";
$str["NOTAVAILABLESHORT"] = "n/a";
$str["DATE"] = "D�tum";
$str["DAY"] = "Nap";
$str["MONTH"] = "H�nap";
$str["YEAR"] = "�v";
$str["TIME"] = "Id�";
$str["OPPONENT"] = "Ellenf�l";
$str["GAME"] = "J�t�k";
$str["RESULT"] = "Eredm�ny";
$str["CURRENTLY"] = "Jelenleg";
$str["SHOW"] = "Mutasd";
$str["CHALLENGEUS"] = "Kih�v�s";
$str["LEGEND"] = "Jelmagyar�zat";
$str["NAME"]="N�v";
$str["SERVER"] = "Szerver";
$str["FULL"] = "teli";
$str["CONTACT"] = "Kontakt";
$str["PLAYERS"] = "J�t�kosok";
$str["PLAYERPERTEAM"] = "J�t�kos csapatonk�nt";
$str["LOCATIONS"] = "P�ly�k";
$str["LOCATION"] = "P�lya";
$str["OWNSCORES"] = "Saj�t eredm�nyek";
$str["OPPSCORES"] = "Ellenf�l eredm�nyei";
$str["AVERAGE"] = "�tlagos";
$str["ADDITIONALINFO"] = "Tov�bbi info";
$str["SIGNEDMEMBERS"] = "Jelentkezett tagok";
$str["MOREREQUIRED"] = "t�bb sz�ks�ges";
$str["OPTIONS"] = "Opci�k";
$str["SIGNUP"] = "Jelentkez�s";
$str["SIGNOFF"] = "Leiratkoz�s";
$str["CALENDAR"] = "Napt�r";
$str["JUMPTOCURRENTMONTH"] = "Ugr�s az aktu�lis h�napra";
$str["ON"] = "Be";
$str["OFF"] = "Ki";
$str["HTMLIS"] = "HTML";
$str["SMILIES"] = "Smilie-k";
$str["ARE"] = "vannak";
$str["BBCODE"] = "BB k�d";
$str["IS"] = "van";
$str["EVENTCALENDAR"] = "Esem�nynapt�r";
$str["EVENTDETAILS"] = "Esem�ny adatai";
$str["BACKTOCALENDAR"] = "Vissza a napt�rhoz";
$str["ADDEDBY"] = "�rta";
$str["VISITHOMEPAGE"] = "N�zd meg a honlapj�t";
$str["ADDTOCONTACTLIST"] = "Kontaktlist�hoz adni";
$str["CLICKMEMBERPROFILE"] = "Kattints a ".makeimgtag($vwar_root . "images/button_profile.gif")." az adatokhoz";
$str["SHOWDETAILS"] = "Adatok";
$str["GAMES"] = "J�t�kok";
$str["SENDMAILTO"] = "Email k�ld�se";
$str["PROFILEOF"] = "Profil";
$str["PROFILELOCATION"] = "V�ros";
$str["PROFILEBIRTHDAY"] = "Sz�let�snap";
$str["PROFILEINTERESTS"] = "�rdekl�d�si k�r";
$str["PROFILEGRAPHICCARD"] = "Grafikus k�rtya";
$str["PROFILECONNECTION"] = "Kapcsolat";
$str["PROFILEKEYBOARD"] = "Billenty�zet";
$str["PROFILEMOUSE"] = "Eg�r";
$str["PHONENUMBERS"] = "Telefonsz�mok";
$str["ONLYVISIBLETOMEMBERS"] = "Csak tagoknak";
$str["PHONE"] = "Telefon";
$str["CELLULARPHONE"] = "Mobiltelefon";
$str["BACKTOWARLIST"] = "Vissza a csat�khoz";
$str["BACKTOMEMBERLIST"] = "Vissza a tagokhoz";
$str["BACKTOWARDETAILS"] = "Vissza az adatokhoz";
$str["GAMESPLAYED"] = "j�tszott meccsek";
$str["SHOWALL"] = "Mind";
$str["ENTERNAME"] = "�rj be egy nevet";
$str["RESULTS"] = "Eredm�nyek";
$str["OTHERGAMESAGAINST"] = "R�gebbi meccsek";
$str["PAGE"] = "Oldal";
$str["SORTTHISFIELDASC"] = "Rendezd emelked�be";
$str["SORTTHISFIELDDESC"] = "Rendezd cs�kken�be";
$str["ASCENDING"] = "emelked�";
$str["DESCENDING"] = "cs�kken�";
$str["CHALLENGE"] = "Kih�v�s";
$str["GENERAL"] = "�ltal�nos";
$str["GAMETYPE"] = "J�t�kt�pus";
$str["MATCHTYPE"] = "Meccst�pus";
$str["SELECT"] = "V�lassz";
$str["ENTERTEAMNAME"] = "Csapatn�v";
$str["ENTERSHORTTEAMNAME"] = "Csapatn�v (r�vid)";
$str["ENTERCONTACTNAME"] = "Kontaktn�v";
$str["ENTERCONTACTEMAIL"] = "Kontakt E-Mail";
$str["CHALLENGEFORM"] = "Kih�v�s formula";
$str["TEAM"] = "Csapat";
$str["ADDITIONALINFOFULL"] = "Megadhatsz tov�bbi inform�ci�kat (pld. speci�lis be�ll�t�sok) vagy b�rmit, amir�l szeretn�d, ha emellett tudn�nk";
$str["SELECTASMANY"] = "V�lassz annyit, amennyi sz�ks�ges";
$str["LOGGEDINAS"] = "Bejelentkezve";
$str["NOTLOGGEDIN"] = "Nem vagy bejelentkezve";
$str["LOGIN"] = "Bejelentkez�s";
$str["LOGIN2"] = "Jelentkezz be a user n�vvel �s a k�ddal:";
$str["LOGOUT"] = "Kijelentkez�s";
$str["DETAILS"] = "Adatok";
$str["LANGUAGE"] = "Nyelv";
$str["LISTBYSTATUS"] = "Tagst�tus";
$str["LISTBYTEAMS"] = "Csapatok";
$str["LISTBY"] = "List�z�s";
$str["PICTURE"] = "K�p";
$str["NONPUBLICDETAILS"] = "Nem publikus adatok <small>(only visible to members)</small>";
$str["FIRSTPAGE"] = "Els� oldal";
$str["LASTPAGE"] = "Utols� oldal";
$str["PREVIOUSPAGE"] = "El�z� oldal";
$str["NEXTPAGE"] = "K�vetkez� oldal";
$str["ALL"] = "Mind";
$str["SCORE"] = "Eredm�ny";
$str["COUNTRY"] = "Orsz�g";
$str["EDIT"] = "Szerkeszt";
$str["DELETE"] = "T�r�l";
$str["PERFORMDELETE"] = "Biztos, hogy t�r�l?";
$str["GUEST"] = "Vend�g";
$str["REPORT"] = "Jelent�s";
$str["BIRTHDAY"] = "Sz�let�snap";
$str["JOINUS"] = "Csatlakozz";
$str["JOINUSFORM"] = "Jelentkez�si �rlap";
$str["PERSONALDETAILS"] = "Szem�lyes adatok";
$str["JOINSUSADDITIONALINFO"] = "R�viden �rd le mi�rt szeretn�l csatlakozni hozz�nk �s mi az, ami �rdekelne minket Veled kapcsolatban!";
$str["WEWILLCONTACTYOU"] = "Amint tudunk, kapcsolatba l�p�nk Veled";
$str["THANKSFORREQUEST"] = "K�sz�nj�k a k�r�sedet";
$str["EQUIPMENT"] = "Felszerel�s";
$str["GENERALINFORMATIONS"] = "�ltal�nos inform�ci�k";
$str["AGE"] = "Kor";
$str["ALLTIMESARE"] = "Az �sszes id�";
$str["TIMENOWIS"] = "Az id� most";
$str["STATUSWARS"] = "St�tus n�lk�li csat�k";
$str["TODAYWARS"] = "Mai csat�k";
$str["WARSSTATUS"] = "St�tus<br><smallfont>(signed up/required)</smallfont>";
$str["ALLSTATUSSET"] = "At all wars the status has been set";
$str["OWNGAMES"] = "Saj�t j�t�kok";
$str["NOENTRY"] = "Nincs bejegyz�s";
$str["SITEGENERATEDWITH"] = "Az oldalt gener�lta";
$str["QUERYSIN"] = "K�rd�sek";
$str["SIMPLEMODE"] = "Egyszer� m�d";
$str["ADVANCEDMODE"] = "Halad� m�d";
$str["CLOSECURRENTTAG"] = "Z�rd be az aktu�lis c�mk�t";
$str["CLOSEALLTAGS"] = "Z�rj be minden c�mk�t";
$str["FORMATTEXT"] = "Form�zand� sz�veg:";
$str["FORMATTEXTADDITIONAL"] = "Form�zand� sz�veg - ";
$str["PROMPTLINKTEXT"] = "Link magyar�zat (tetsz�leges):";
$str["PROMPTURLTEXT"] = "Link teljesen hivatkoz�sa:";
$str["PROMPTMAILTEXT"] = "Link E-Mail c�me";
$str["PROMPTLISTITEM"] = "Lista adat megad�sa.\nHagyd �resen a mez�t, vagy kattints a 'Cancel'-re a lista befejez�s�hez.";
$str["SIZE"] = "m�ret";
$str["HUGE"] = "hatalmas";
$str["BIG"] = "nagy";
$str["NORMAL"] = "norm�l";
$str["SMALL"] = "kicsi";
$str["FONT"] = "bet�";
$str["COLOR"] = "sz�n";
$str["BOLDTEXT"] = "F�lk�v�r";
$str["ITALICTEXT"] = "D�lt";
$str["UNDERLINEDTEXT"] = "Al�h�zott";
$str["CENTER"] = "K�z�pre";
$str["CREATELIST"] = "Lista k�sz�t�se";
$str["INSERTHYPERLINK"] = "Link besz�r�sa";
$str["INSERTCODE"] = "K�d besz�r�sa";
$str["INSERTMAIL"] = "Email besz�r�sa";
$str["INSERTQUOTE"] = "Insert a Quote";
$str["INSERTIMAGE"] = "K�p besz�r�sa";
$str["HELP"] = "S�g�";
$str["CLICKONARROWTOINSERTCODE"] = "Kattints a ny�lra a BB k�d besz�r�s�hoz.<br>Mindegy, hogy kicsi vagy nagybet�, az URL-ek automatikusan vannak alak�tva.";
$str["PLAY"] = "j�tszott vagy kell m�g j�tszania";
$str["CANCELLED"] = "lemondt�k";
$str["OPPONENTLIST"] = "Ellenf�l lista";
$str["MEMBERGALLERY"] = "Tagok gal�ri�ja";
$str["CONTACTLIST"] = "Kontakt lista";
$str["RECEIVER"] = "Fogad�";
$str["SENDERNAME"] = "Felad� neve";
$str["SENDERMAIL"] = "Felad� Email-je";
$str["SUBJECT"] = "T�rgy";
$str["FORMAT"] = "Form�tum";
$str["MESSAGE"] = "�zenet";
$str["CONTENT"] = "Tartalom";
$str["ENTER"] = "Bel�p�s";
$str["SEND"] = "K�ld�s";
$str["PRIORITY"] = "Priorit�s";
$str["BACKTONEWS"] = "Vissza a h�r adataihoz";
$str["QUOTE"] = "Hivatkoz�s";
$str["BACK"] = "vissza";
$str["TITLE"] = "C�m";
$str["NOICON"] = "Nincs ikon";
$str["PREVIEW"] = "El�n�zet";
$str["TOTAL"] = "�sszes";
$str["GUESTBOOKOF"] = "Vend�gk�nyve";
$str["FUNCTIONDISABLED"] = "Funkci� <b>letiltva</b>!";
$str["GOTO"] = "Ugr�s";
$str["PASSWORD"] = "K�d";
$str["FORGOTPASSWORD"] = "Elfelejtette jelszav�t?";
$str["ARCHIVE"] = "Arh�vum";
$str["CATEGORY"] = "Kateg�ria";
$str["SEARCH"] = "Keres�s";
$str["ENLARGE"] = "Nagy�t";
$str["PRINT"] = "Nyomtat";
$str["SUBMIT"] = "K�ld�s";
$str["REDIRECT"] = "Kattints ide, ha nem szeretn�l tov�bb v�rni<br>(vagy ha a b�ng�sz�d nem tov�bb�t automatikusan)";
$str["ENTEREDREGISTEREDDATA"] = "M�r regisztr�lt adatot �rt�l be (N�v, E-Mail). M�g nem haszn�lt adatokat adj�l meg!";
$str["SEARCHKEYWORD"] = "Keres�s kulcssz�ra";
$str["SEARCHAUTHOR"] = "Keres�s szerz�re";
$str["MATCHEXACTNAME"] = "Teljes megfelel�s";
$str["MATCHPARTIALNAME"] = "R�szleges megfelel�s";
$str["USEWILDCARD"] = 'Haszn�ld a "*"-t, mint jokert r�szleges keres�sn�l';
$str["SEARCHOPTIONS"] = "Haszn�lhatod az <u>�S</u>, <u>VAGY</u> �s <u>NEM</u> szavakat r�szletesebb keres�shez";
$str["CONNECTSEARCHES"] = "Kulcssz� keres�s�t �sszekapcsolhatod a szerz� keres�s�vel";
$str["USEEXACTPHRASE"] = 'A "-k k�z�tti sz�veg teljes kifejez�sk�nt lesz keresve';
$str["SEARCHIN"] = "Keress ebben";
$str["SEARCHFORRESULTSIN"] = "Keress tal�latokat ebben";
$str["DISPLAYMODE"] = "Kijelz�s m�dja";
$str["SEARCHINTEXT"] = "Keress sz�vegben";
$str["SEARCHINSUBJECT"] = "Keress a t�rgyban";
$str["SHOWASOVERVIEW"] = "�ttekint� n�zet";
$str["SHOWINDETAILS"] = "R�szletes n�zet";
$str["SEARCHFORRESULTS"] = "Erdem�nyek keres�se";
$str["SORTRESULTBY"] = "Eredm�ny rendez�se";
$str["OF"] = "";
$str["LASTDAYS0"] = "b�rmikor";
$str["LASTDAYS1"] = "tegnap";
$str["LASTDAYS7"] = "m�lt h�t";
$str["LASTDAYS14"] = "utols� k�t h�t";
$str["LASTDAYS30"] = "m�lt h�nap";
$str["LASTDAYS90"] = "utols� h�rom h�nap";
$str["LASTDAYS180"] = "utols� 6 h�nap";
$str["LASTDAYS365"] = "el�z� �v";
$str["AND"] = "�s";
$str["NEWER"] = "newer";
$str["OLDER"] = "older";
$str["AUTHOR"] = "Szerz�";
$str["NUMLINKS"] = "Linkek sz�ma";
$str["ADVANCEDSEARCH"] = "R�szletes keres�s";
$str["REQUIREDFIELDS"] = 'A <font color="red">*</font>-al jel�lt mez�k kit�lt�se k�telez�';
$str["OR"] = "vagy";
$str["LENGTHSEARCHWORD"] = "A keresend� sz� minimum 3 bet�s legyen.";
$str["SEARCHINFORMATION"] = "Inform�ci� keres�se";
$str["NEWSCOMMENTS"] = "H�rkommentek";
$str["SENDNEWS"] = "H�r k�ld�se";
$str["RECEIVERMAIL"] = "Fogad� E-Mail-je";
$str["MOREFUNCTION"] = "T�bb funkci�: <b>enged�lyezve</b><br>A tartalmat feloszhatod";
$str["SUBMITTED"] = "(al�vetve)";
$str["AREYOUSURETODELETE"] = "Biztos, hogy t�r�lni akarod a kiv�lasztott elemet?";
$str["NORMALMODE"] = "Norm�l m�d";
$str["LISTMODE"] = "Lista m�d";
$str["PROMPTLISTTYPE"] = "Lista t�pusok: '1' = arab sorsz�mos, 'a' = kisbet�s,\n'I' = r�mai sorsz�mos, �res = goly�s";
$str["LASTEDITEDBY"] = "Utolj�ra m�dos�totta:";

## ---- START CUSTOM PART ---- ##
## ---- START "GB" ---- ##

$str["GB_NAME"] = "Vend�k�nyv";

$str["GB_INFOLINE"] = "%1 %2 %3 %4on";

$str["GB_PAGE"] = "Oldal";

$str["GB_PAGES"] = "Oldalak";

$str["GB_ENTRY"] = "Bejegyz�s";

$str["GB_ENTRIES"] = "Bejegyz�sek";

$str["GB_ADDENTRY"] = "Bejegyz�s hozz�ad�sa";

$str["GB_ADDANENTRY"] = "Vend�gk�nyvbe �r�s";

$str["GB_EDITANENTRY"] = "Egy bejegyz�s szerkeszt�se";

$str["GB_EDITENTRY"] = "Bejegyz�s szerkeszt�se";

$str["GB_BACKTOGB"] = "Vissza a vend�gk�nyvh�z";

$str["GB_WARNINGNAME"] = "�rj�l be egy nevet!";

$str["GB_WARNINGTEXT"] = "�rj�l be sz�veget!";

$str["GB_ADDNAME"] = "N�v";

$str["GB_ADDEMAIL"] = "E-Mail";

$str["GB_ADDHOMEPAGE"] = "Weboldal";

$str["GB_ADDICQ"] = "ICQ-UIN";

$str["GB_ADDAIM"] = "AIM";

$str["GB_ADDYIM"] = "YIM";

$str["GB_ADDMSN"] = "MSN";

$str["GB_TITLE"] = "C�m";

$str["GB_BLOCKED"] = "M�r �rt�l egy bejegyz�st az utols� <b>%1 %2</b>.";

$str["GB_MINUTE"] = "Perc";

$str["GB_MINUTES"] = "Percek";

$str["GB_COMMENT"] = "Komment";

$str["GB_COMMENTS"] = "Kommentek";

$str["GB_ENTRYBY"] = "Veng�dk�nyvbe bejegyezte";

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
