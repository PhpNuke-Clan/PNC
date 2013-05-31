<?php //vwar
/* #####################################################################################
 *
 * $Id: french.inc.php,v 1.22 2004/03/14 20:22:10 mabu Exp $
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
	"al" => "L'Albanie",
	"am" => "L'Arm&amp;eacute;nie",
	"an" => "Antilles hollandaise",
	"ao" => "Angola",
	"ar" => "L'Argentine",
	"at" => "L'Autriche",
	"au" => "L'Australie",
	"aw" => "Aruba",
	"az" => "L'Azerba&amp;iuml;djan",
	"ba" => "La Bosnie-Herzegowine",
	"bb" => "Barbades",
	"bd" => "Bangladesh",
	"be" => "La Belgique",
	"bf" => "Burkina Faso",
	"bg" => "La Bulgarie",
	"bh" => "Bahre&iuml;n",
	"bi" => "Burundi",
	"bj" => "Benin",
	"bm" => "Bermuda",
	"bn" => "Brunei",
	"bo" => "Bolivie",
	"br" => "Le Br&amp;eacute;sil",
	"bs" => "Bahamas",
	"bt" => "Bhoutan",
	"bw" => "Botswana",
	"bx" => "Benelux",
	"by" => "La Bi&amp;eacute;lorussie",
	"bz" => "Belize",
	"ca" => "Le Canada",
	"cf" => "Centrafrique",
	"cg" => "Congo",
	"ch" => "La Suisse",
	"ci" => "Cote D'Ivoire (Ivory Coast)",
	"ck" => "Les Iles Cook",
	"cm" => "Le Cameroun",
	"cn" => "La Chine",
	"co" => "La Colombie",
	"cr" => "Costa Rica",
	"cu" => "Cuba",
	"cv" => "Cape Vert",
	"cy" => "Chypre",
	"cz" => "R&amp;eacute;publique Tch&amp;egrave;que",
	"de" => "L'Allemagne",
	"dk" => "Le Danemark",
	"dz" => "L'Alg&amp;eacute;rie",
	"ec" => "Equateur",
	"ee" => "L'Estonie",
	"eg" => "L'Egypte",
	"er" => "Erythr&amp;eacute;e",
	"es" => "L'Espagne",
	"et" => "Ethiopie",
	"eu" => "L'Europe",
	"fi" => "La Finlande",
	"fj" => "Fiji",
	"fo" => "Iles F&eacute;ro&eacute;",
	"fr" => "La France",
	"ga" => "Gabon",
	"ge" => "La G&amp;eacute;orgie",
	"gi" => "Gibraltar",
	"gl" => "Le Groenland",
	"gp" => "Guadeloupe",
	"gr" => "La Gr&amp;egrave;ce",
	"gt" => "Guatemala",
	"gu" => "Guam",
	"gy" => "Guyana",
	"hk" => "Hong Kong",
	"hr" => "Croatie",
	"ht" => "Haiti",
	"hu" => "La Hongrie",
	"id" => "Indonesie",
	"ie" => "L'Irlande",
	"il" => "Israel",
	"in" => "India",
	"int" => "International",
	"iq" => "L'Irak",
	"ir" => "L'Iran",
	"is" => "L'Islande",
	"it" => "L'Italie",
	"jm" => "Jama&iuml;que",
	"jo" => "Jordanie",
	"jp" => "Le Japon",
	"ke" => "Kenya",
	"kg" => "Kyrgyzstan",
	"kh" => "Cambodge",
	"ki" => "Kiribati",
	"kp" => "Cor&eacute;e du Nord",
	"kr" => "Cor&eacute;e du Sud",
	"ky" => "Iles Ca&iuml;man",
	"kz" => "Kazakhstan",
	"lb" => "Liban",
	"lc" => "Saint Lucie",
	"li" => "Liechtenstein",
	"lk" => "Sri Lanka",
	"lt" => "La Lithuanie",
	"lu" => "Le Luxembourg",
	"lv" => "Lettonie",
	"ly" => "Libye",
	"ma" => "Le Maroc",
	"mc" => "Monaco",
	"md" => "R&eacute;publique de moldavie",
	"mg" => "Madagascar",
	"mn" => "La Mongolie",
	"mo" => "Macao",
	"mp" => "Iles Mariannes",
	"ms" => "Montserrat",
	"mt" => "Malte",
	"mx" => "Le Mexique",
	"my" => "Malaysie",
	"mz" => "Mozambique",
	"na" => "Namibie",
	"nc" => "Nouvelle Cal&eacute;donie",
	"nf" => "Iles Norfolk",
	"nl" => "La Hollande",
	"no" => "La Norv&egrave;ge",
	"np" => "Nepal",
	"nr" => "Nauru",
	"nz" => "Nouvelle-Z&eacute;lande",
	"om" => "Oman",
	"pa" => "Panama",
	"pe" => "Peru",
	"pf" => "Polynesie Fran&ccedil;aise",
	"ph" => "Philippines",
	"pk" => "Pakistan",
	"pl" => "La Pologne",
	"pm" => "St. Pierre and Miquelon",
	"pr" => "Puerto Rico",
	"pt" => "Le Portugal",
	"py" => "Paraguay",
	"qa" => "Qatar",
	"ro" => "La Roumanie",
	"ru" => "La Russie",
	"sa" => "L'Arabie Saoudite",
	"sb" => "Iles Solomon",
	"sca" => "Scandinavie",
	"sd" => "Soudan",
	"se" => "La Su&egrave;de",
	"sg" => "Singapour",
	"si" => "La Slov&eacute;nie",
	"sk" => "La Slovaquie",
	"sl" => "Sierra Leone",
	"so" => "Somalie",
	"tc" => "Turks et Ca&iuml;ques",
	"tg" => "Togo",
	"th" => "Thailand",
	"tn" => "La Tunisie",
	"to" => "Tonga",
	"tp" => "Timor",
	"tr" => "La Turquie",
	"tt" => "Trinit&eacute; et Tobago",
	"tv" => "Tuvalu",
	"tw" => "Taiwan",
	"tz" => "Tanzanie",
	"ua" => "L'Ukraine",
	"ug" => "Ouganda",
	"uk" => "Le Royaume Uni",
	"us" => "Les Etats-Unis d'Am&eacute;rique",
	"uy" => "Uruguay",
	"va" => "Vatican City",
	"ve" => "Le Venezuela",
	"vg" => "Vierges Britaniques",
	"vi" => "Vierges am&eacute;ricaines",
	"vn" => "Viet Nam",
	"ws" => "Samoa",
	"ye" => "Yemen",
	"yu" => "La Yougoslavie",
	"za" => "Afrique du Sud",
	"zw" => "Zimbabwe"
);

## ------------------------------ DEFINE MONTH NAMES -------------------------------- ##
$monthnames = array(
	"1" => "Janvier",
	"2" => "F�vrier",
	"3" => "Mars",
	"4" => "Avril",
	"5" => "Mai",
	"6" => "Juin",
	"7" => "Juillet",
	"8" => "Ao�t",
	"9" => "Septembre",
	"10" => "Octobre",
	"11" => "Novembre",
	"12" => "D�cembre"
);

## ----------------------------- DEFINE WEEKDAY NAMES ------------------------------- ##
$weekdaynames = array(
	"Dim",
	"Lun",
	"Mar",
	"Mer",
	"Jeu",
	"Ven",
	"Sam"
);

## ------------------------------- DEFINE LANGUAGES --------------------------------- ##
$languages = array(
	"german" => "Allemand",
	"english" => "Anglais",
	"french" => "Fran�ais",
	"danish" => "Danois",
	"dutch" => "Hollandais",
	"spanish" => "Espagnol",
	"portuguese" => "Portugaise",
	"italian" => "Italien",
	"hungarian" => "Hongrois"
);

## ------------------------- DEFINE GLOBAL LANGUAGE VARS ---------------------------- ##
$str["SHOWIP"] = "Afficher IP";
$str["NEWCOMMENT"] = "Nouveau Commentaire";
$str["ADDCOMMENT"] = "Ajouter Commentaire";
$str["EDITCOMMENT"] = "Editer Commentaire";
$str["DELETECOMMENT"] = "Supprimer Commentaire";
$str["COMMENT"] = "Commentaire";
$str["COMMENTS"] = "Commentaires";
$str["ENTERCOMMENT"] = "Veuillez �crire le commentaire";
$str["BACKTOCOMMENTS"] = "Retour aux commentaires";
$str["ADD"] = "Ajouter";
$str["CLOSEWINDOW"] = "Fermer fen�tre";
$str["CLICKONSMILIETOINSERT"] = "Cliquez sur un smiley pour l'ins�rer";
$str["INSERTTHISSMILIE"] = "Ins�rez ce Smiley";
$str["MORE"] = "plus";
$str["PLEASECHOOSE"] = "Choisissez";
$str["STATISTICS"] = "Statistiques";
$str["AVAILABLE"] = "disponible(s)";
$str["YES"] = "Oui";
$str["NO"] = "Non";
$str["SHORT"] = "bri�vement";
$str["NOTAVAILABLE"] = "non disponible";
$str["NOTAVAILABLESHORT"] = "n/a";
$str["DATE"] = "Date";
$str["DAY"] = "Jour";
$str["MONTH"] = "Mois";
$str["YEAR"] = "Ann�e";
$str["TIME"] = "Heure";
$str["OPPONENT"] = "Adversaire";
$str["GAME"] = "Jeu";
$str["RESULT"] = "R�sultat";
$str["CURRENTLY"] = "Actuel";
$str["SHOW"] = "Montrer";
$str["CHALLENGEUS"] = "D�fiez-nous";
$str["LEGEND"] = "L�gende";
$str["NAME"] = "Nom";
$str["SERVER"] = "Serveur";
$str["FULL"] = "compl�tement";
$str["CONTACT"] = "Contact";
$str["PLAYERS"] = "Joueurs";
$str["PLAYERPERTEAM"] = "Joueur par �quipe";
$str["LOCATIONS"] = "Maps";
$str["LOCATION"] = "Map";
$str["OWNSCORES"] = "Scores du clan ";
$str["OPPSCORES"] = "Scores de l'adversaire ";
$str["AVERAGE"] = "moyenne";
$str["ADDITIONALINFO"] = "Informations Suppl�mentaires";
$str["SIGNEDMEMBERS"] = "membres inscrits";
$str["MOREREQUIRED"] = "N�cessaires";
$str["OPTIONS"] = "Options";
$str["SIGNUP"] = "S'inscrire";
$str["SIGNOFF"] = "Se d�inscrire";
$str["CALENDAR"] = "Calendrier";
$str["JUMPTOCURRENTMONTH"] = "Aller au mois en cours";
$str["ON"] = "On";
$str["OFF"] = "Off";
$str["HTMLIS"] = "HTML est";
$str["SMILIES"] = "Smileys";
$str["ARE"] = "sont";
$str["BBCODE"] = "bbCode";
$str["IS"] = "est";
$str["EVENTCALENDAR"] = "Calendrier D'�v�nements";
$str["EVENTDETAILS"] = "D�tails D'�v�nement";
$str["BACKTOCALENDAR"] = "Retour au calendrier";
$str["ADDEDBY"] = "Ajout� par";
$str["VISITHOMEPAGE"] = "Visitez le site de";
$str["ADDTOCONTACTLIST"] = "Ajoutez � la liste de contacts";
$str["CLICKMEMBERPROFILE"] = "Cliquez sur ".makeimgtag($vwar_root . "images/button_profile.gif")." pour voir le profil d'un membre";
$str["SHOWDETAILS"] = "Montrez Les D�tails";
$str["GAMES"] = "Jeux";
$str["SENDMAILTO"] = "Envoyez un eMail �";
$str["PROFILEOF"] = "Profil de";
$str["PROFILELOCATION"] = "Ville";
$str["PROFILEBIRTHDAY"] = "Anniversaire";
$str["PROFILEINTERESTS"] = "Int�r�ts";
$str["PROFILEGRAPHICCARD"] = "Carte graphique";
$str["PROFILECONNECTION"] = "Connexion";
$str["PROFILEKEYBOARD"] = "Clavier";
$str["PROFILEMOUSE"] = "Souris";
$str["PHONENUMBERS"] = "Num�ros de t�l�phone";
$str["ONLYVISIBLETOMEMBERS"] = "Seulement visible par les membres";
$str["PHONE"] = "T�l�phone";
$str["CELLULARPHONE"] = "T�l�phone Portable";
$str["BACKTOWARLIST"] = "Retour � la liste des Matchs";
$str["BACKTOMEMBERLIST"] = "Retour � la liste des membres";
$str["BACKTOWARDETAILS"] = "Retour aux d�tails des Matchs";
$str["GAMESPLAYED"] = "Matchs jou�s";
$str["SHOWALL"] = "Montrez tout";
$str["ENTERNAME"] = "Veuillez �crire le nom";
$str["RESULTS"] = "R�sultats";
$str["OTHERGAMESAGAINST"] = "Autres Matchs contre";
$str["PAGE"] = "Page";
$str["SORTTHISFIELDASC"] = "Tri croissant";
$str["SORTTHISFIELDDESC"] = "Tri d�croissant";
$str["ASCENDING"] = "croissant";
$str["DESCENDING"] = "d�croissant";
$str["CHALLENGE"] = "D�fi�";
$str["GENERAL"] = "G�n�ral";
$str["GAMETYPE"] = "Type de Jeu";
$str["MATCHTYPE"] = "Type de match";
$str["SELECT"] = "S�lectionner";
$str["ENTERTEAMNAME"] = "Entrez le nom de la team";
$str["ENTERSHORTTEAMNAME"] = "Entrez le Tag de la Team";
$str["ENTERCONTACTNAME"] = "Entrez le nom du contact";
$str["ENTERCONTACTEMAIL"] = "Entrez l'email du contact";
$str["CHALLENGEFORM"] = "Formulaire de D�fi";
$str["TEAM"] = "�quipe";
$str["ADDITIONALINFOFULL"] = "ajoutez les infos suppl�mentaires ici (par exemple configurations sp�ciales)";
$str["SELECTASMANY"] = "Choisissez-en autant que n�cessaire";
$str["LOGGEDINAS"] = "Vous �tes connect� en tant que ";
$str["NOTLOGGEDIN"] = "Vous n'�tes pas connect�";
$str["LOGIN"] = "Login";
$str["LOGIN2"] = "Login avec le nom et le mot de passe:";
$str["LOGOUT"] = "Logout";
$str["DETAILS"] = "D�tails";
$str["LANGUAGE"] = "Langue";
$str["LISTBYSTATUS"] = "le Statut des membres";
$str["LISTBYTEAMS"] = "�quipes";
$str["LISTBY"] = "Trier par";
$str["PICTURE"] = "Image";
$str["NONPUBLICDETAILS"] = "D�tails non-public <small>(seulement visible par les membres)</small>";
$str["FIRSTPAGE"] = "Premi�re Page";
$str["LASTPAGE"] = "Derni�re Page";
$str["PREVIOUSPAGE"] = "Page Pr�c�dente";
$str["NEXTPAGE"] = "Prochaine Page";
$str["ALL"] = "Tout";
$str["SCORE"] = "Points";
$str["COUNTRY"] = "Pays";
$str["EDIT"] = "�ditez";
$str["DELETE"] = "Supprimez";
$str["PERFORMDELETE"] = "Ex�cutez la suppression ?";
$str["GUEST"] = "Visiteur";
$str["REPORT"] = "Rapport";
$str["BIRTHDAY"] = "Anniversaire";
$str["JOINUS"] = "Candidature";
$str["JOINUSFORM"] = "Formulaire d'adh�sion";
$str["PERSONALDETAILS"] = "D�tails personnels";
$str["JOINSUSADDITIONALINFO"] = "D�crivez bri�vement ce pourquoi vous voulez nous rejoindre et quels autres d�tails pourraient �tre int�ressant pour nous.";
$str["WEWILLCONTACTYOU"] = "Nous vous contacterons aussit�t que possible";
$str["THANKSFORREQUEST"] = "Merci de votre demande";
$str["EQUIPMENT"] = "�quipement";
$str["GENERALINFORMATIONS"] = "Informations G�n�rales";
$str["AGE"] = "�ge";
$str["ALLTIMESARE"] = "Toutes les heures sont";
$str["TIMENOWIS"] = "L'heure est";
$str["STATUSWARS"] = "Matchs sans statut";
$str["TODAYWARS"] = "Matchs d'aujourd'hui";
$str["WARSSTATUS"] = "Statut<br><smallfont>(incrits/requis)</smallfont>";
$str["ALLSTATUSSET"] = "A tous les matchs, le statut a �t� mis";
$str["OWNGAMES"] = "Propres jeux";
$str["NOENTRY"] = "Entr�e indisponible!";
$str["SITEGENERATEDWITH"] = "Site g�n�r� avec";
$str["QUERYSIN"] = "Requ�tes";
$str["SIMPLEMODE"] = "Mode Simple";
$str["ADVANCEDMODE"] = "Mode Avanc�";
$str["CLOSECURRENTTAG"] = "Fermer les Tags en cours";
$str["CLOSEALLTAGS"] = "Fermer tous les Tags";
$str["FORMATTEXT"] = "Entrez le texte que vous souhaitez formater:";
$str["FORMATTEXTADDITIONAL"] = "Entrez le texte que vous souhaitez formater - ";
$str["PROMPTLINKTEXT"] = "Entre le texte � afficher pour le lien (optionnel):";
$str["PROMPTURLTEXT"] = "Entrez l'URL compl�te du lien:";
$str["PROMPTMAILTEXT"] = "Entrez l'adresse e-mail pour le lien";
$str["PROMPTLISTITEM"] = "Entrez l'objet dans la liste.\nLaissez la case vide ou appuyez sur 'Annuler' pour compl�ter la liste.";
$str["SIZE"] = "taille";
$str["HUGE"] = "�norme";
$str["BIG"] = "grande";
$str["NORMAL"] = "normale";
$str["SMALL"] = "petite";
$str["FONT"] = "Police";
$str["COLOR"] = "couleur";
$str["BOLDTEXT"] = "Gras";
$str["ITALICTEXT"] = "Italic";
$str["UNDERLINEDTEXT"] = "Soulign�";
$str["CENTER"] = "Centr�";
$str["CREATELIST"] = "Cr�er une Liste";
$str["INSERTHYPERLINK"] = "Ins�rer un lien Hypertexte";
$str["INSERTCODE"] = "Ins�rer un Code";
$str["INSERTMAIL"] = "Ins�rer une adresse e-mail";
$str["INSERTQUOTE"] = "Ins�rer des guillemets";
$str["INSERTIMAGE"] = "Ins�rer une Image";
$str["HELP"] = "Aide";
$str["CLICKONARROWTOINSERTCODE"] = "Cliquez sur la fl�che pour ins�rer du BB Code.<br>Majuscules ou minuscules n'a pas d'importance, les URLs sont automatiquement redimensionn�es.";
$str["PLAY"] = "jou� ou � jouer";
$str["CANCELLED"] = "annul�";
$str["OPPONENTLIST"] = "Liste des Adversaires";
$str["MEMBERGALLERY"] = "Gallerie des membres";
$str["CONTACTLIST"] = "Liste des contact";
$str["RECEIVER"] = "Destinataire";
$str["SENDERNAME"] = "Nom de l'expediteur";
$str["SENDERMAIL"] = "eMail de l'exp�diteur";
$str["SUBJECT"] = "Sujet";
$str["FORMAT"] = "Format";
$str["MESSAGE"] = "Message";
$str["CONTENT"] = "Contenu";
$str["ENTER"] = "Entrer";
$str["SEND"] = "Envoyer";
$str["PRIORITY"] = "Priorit�";
$str["BACKTONEWS"] = "Retour aux details de la news";
$str["QUOTE"] = "Citer";
$str["BACK"] = "retour";
$str["TITLE"] = "Titre";
$str["NOICON"] = "Pas d'Ic�ne";
$str["PREVIEW"] = "Pr�visualiser";
$str["TOTAL"] = "Total";
$str["GUESTBOOKOF"] = "Livre d'or de";
$str["FUNCTIONDISABLED"] = "Cette Fonction est <b>d�activ�e</b>!";
$str["GOTO"] = "Aller&nbsp;�";
$str["PASSWORD"] = "Mot de passe";
$str["FORGOTPASSWORD"] = "Mot de passe oubli�?";
$str["ARCHIVE"] = "Archive";
$str["CATEGORY"] = "Categorie";
$str["SEARCH"] = "Recherche";
$str["ENLARGE"] = "Elargir";
$str["PRINT"] = "Imprimer";
$str["SUBMIT"] = "Soumettre";
$str["REDIRECT"] = "Cliquez ici si vous ne voulez pas attendre<br>(ou si votre Navigateurs ne le fait pas)";
$str["ENTEREDREGISTEREDDATA"] = "Vous avez saisi les donn�es enregistr�es (nom, email).  Changez-les en valeurs non-enregistr�es!";
$str["SEARCHKEYWORD"] = "Recherche de mot-cl�";
$str["SEARCHAUTHOR"] = "Recherche d'auteur";
$str["MATCHEXACTNAME"] = "Rechercher le nom exact";
$str["MATCHPARTIALNAME"] = "Rechercher une partie du nom";
$str["USEWILDCARD"] = 'Utilisez un ast�risque "*" pour ajouter un mot � rechercher (*war renvoit vwar etc)';
$str["SEARCHOPTIONS"] = "oindre les mots avec: <u>AND</u> (et), <u>OR</u> (ou) et <u>NOT</u> (non) pour controller votre recherche en d�tail";
$str["CONNECTSEARCHES"] = "Vous pouvez relier la recherche d'un mot-cl� � une recherche d'un auteur";
$str["USEEXACTPHRASE"] = 'Le texte entre deux " sera recherch� comme expression exacte';
$str["SEARCHIN"] = "Rechercher dans";
$str["SEARCHFORRESULTSIN"] = "Rechercher des r�sultats dans";
$str["DISPLAYMODE"] = "Mode d'affichage";
$str["SEARCHINTEXT"] = "Rechercher dans le texte";
$str["SEARCHINSUBJECT"] = "Recherche dans les titres";
$str["SHOWASOVERVIEW"] = "Montrez comme vue d'ensemble";
$str["SHOWINDETAILS"] = "Montrez dans les d�tails";
$str["SEARCHFORRESULTS"] = "Recherche des r�sultats";
$str["SORTRESULTBY"] = "Trier les r�sultats par";
$str["OF"] = "de";
$str["LASTDAYS0"] = "Peu Importe";
$str["LASTDAYS1"] = "Hier";
$str["LASTDAYS7"] = "Cette semaine";
$str["LASTDAYS14"] = "2 semaines";
$str["LASTDAYS30"] = "1 mois";
$str["LASTDAYS90"] = "3 mois";
$str["LASTDAYS180"] = "6 mois";
$str["LASTDAYS365"] = "1 an";
$str["AND"] = "et";
$str["NEWER"] = "r�cent";
$str["OLDER"] = "ancien";
$str["AUTHOR"] = "Auteur";
$str["NUMLINKS"] = "Nombre des liens";
$str["ADVANCEDSEARCH"] = "Recherche Avanc�e";
$str["REQUIREDFIELDS"] = "les champs marqu�s d'une <font color='red'>*</font> sont obligatoires";
$str["OR"] = "ou";
$str["LENGTHSEARCHWORD"] = "La longueur du mot rechercher doit �tre d'au moins de 3 lettres.";
$str["SEARCHINFORMATION"] = "Information De Recherche";
$str["NEWSCOMMENTS"] = "Commentaires De News";
$str["SENDNEWS"] = "Envoyer une News";
$str["RECEIVERMAIL"] = "E-Mail du Destinataire";
$str["MOREFUNCTION"] = "Plus De Fonction: <b>activer</b><br>Vous pouvez diviser votre contenu avec";
$str["SUBMITTED"] = "(soumis)";
$str["AREYOUSURETODELETE"] = "�tes-vous s�r vous voulez-vous l'effacement de 9l'item choisi?";
$str["NORMALMODE"] = "Mode Normal";
$str["LISTMODE"] = "Mode De Liste";
$str["PROMPTLISTTYPE"] = "Listtypes: '1' = numbered, 'a' = small letters,\n'I' = upper roman, leave blank = bullet points";
$str["LASTEDITEDBY"] = "Last edited by";

## ---- START CUSTOM PART ---- ##
## ---- START "GB" ---- ##

$str["GB_NAME"] = "Livre d\'or";

$str["GB_INFOLINE"] = "%1 %2 sur %3 %4";

$str["GB_PAGE"] = "Page";

$str["GB_PAGES"] = "Pages";

$str["GB_ENTRY"] = "Entr�e";

$str["GB_ENTRIES"] = "Entr�es";

$str["GB_ADDENTRY"] = "Ajouter Entr�e";

$str["GB_ADDANENTRY"] = "Ajouter une Entr�e au Livre d\'or";

$str["GB_EDITANENTRY"] = "Editer une Entr�e";

$str["GB_EDITENTRY"] = "Editer Entr�e";

$str["GB_BACKTOGB"] = "Retour au Livre d\'or";

$str["GB_WARNINGNAME"] = "Veuillez �crire un nom!";

$str["GB_WARNINGTEXT"] = "Veuillez �crire un texte!";

$str["GB_ADDNAME"] = "Nom";

$str["GB_ADDEMAIL"] = "eMail";

$str["GB_ADDHOMEPAGE"] = "Page d\'accueil";

$str["GB_ADDICQ"] = "ICQ-UIN";

$str["GB_ADDAIM"] = "AIM";

$str["GB_ADDYIM"] = "YIM";

$str["GB_ADDMSN"] = "MSN";

$str["GB_TITLE"] = "Titre";

$str["GB_BLOCKED"] = "Vous avez d�j� �crit une entr�e les dernieres <b>%1 %2</b>.";

$str["GB_MINUTE"] = "Minute";

$str["GB_MINUTES"] = "Minutes";

$str["GB_COMMENT"] = "Commentaire";

$str["GB_COMMENTS"] = "Commentaires";

$str["GB_ENTRYBY"] = "Livre d\'or Entr�e par";

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
## ---- END CUSTOM PART ---- ##
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
