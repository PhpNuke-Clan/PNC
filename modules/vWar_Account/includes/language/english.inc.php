<?php //vwar
/* #####################################################################################
 *
 * $Id: english.inc.php,v 1.21 2004/03/14 20:22:10 mabu Exp $
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
	"an" => "Netherlands Antilles",
	"ao" => "Angola",
	"ar" => "Argentina",
	"at" => "Austria",
	"au" => "Australia",
	"aw" => "Aruba",
	"az" => "Azerbaijan",
	"ba" => "Bosnia and herzegowina",
	"bb" => "Barbados",
	"bd" => "Bangladesh",
	"be" => "Belgium",
	"bf" => "Burkina Faso",
	"bg" => "Bulgaria",
	"bh" => "Bahrain",
	"bi" => "Burundi",
	"bj" => "Benin",
	"bm" => "Bermuda",
	"bn" => "Brunei Darussalam",
	"bo" => "Bolivia",
	"br" => "Brazil",
	"bs" => "Bahamas",
	"bt" => "Bhutan",
	"bw" => "Botswana",
	"bx" => "Benelux",
	"by" => "Belarus",
	"bz" => "Belize",
	"ca" => "Canada",
	"cf" => "Central African Republic",
	"cg" => "Congo",
	"ch" => "Switzerland",
	"ci" => "Cote D'Ivoire (Ivory Coast)",
	"ck" => "Cook Islands",
	"cm" => "Cameroon",
	"cn" => "China",
	"co" => "Colombia",
	"cr" => "Costa Rica",
	"cu" => "Cuba",
	"cv" => "Cape Verde",
	"cy" => "Cyprus",
	"cz" => "Czech republic",
	"de" => "Germany",
	"dk" => "Denmark",
	"dz" => "Algeria",
	"ec" => "Ecuador",
	"ee" => "Estonia",
	"eg" => "Egypt",
	"er" => "Eritrea",
	"es" => "Spain",
	"et" => "Ethiopia",
	"eu" => "Europe",
	"fi" => "Finland",
	"fj" => "Fiji",
	"fo" => "Faroe Islands",
	"fr" => "France",
	"ga" => "Gabon",
	"ge" => "Georgia",
	"gi" => "Gibraltar",
	"gl" => "Greenland",
	"gp" => "Guadeloupe",
	"gr" => "Greece",
	"gt" => "Guatemala",
	"gu" => "Guam",
	"gy" => "Guyana",
	"hk" => "Hong Kong",
	"hr" => "Croatia",
	"ht" => "Haiti",
	"hu" => "Hungary",
	"id" => "Indonesia",
	"ie" => "Ireland",
	"il" => "Isreal",
	"in" => "India",
	"int" => "International",
	"iq" => "Iraq",
	"ir" => "Iran",
	"is" => "Iceland",
	"it" => "Italy",
	"jm" => "Jamaica",
	"jo" => "Jordan",
	"jp" => "Japan",
	"ke" => "Kenya",
	"kg" => "Kyrgyzstan",
	"kh" => "Cambodia",
	"ki" => "Kiribati",
	"kp" => "Korea (North)",
	"kr" => "Republic of korea",
	"ky" => "Cayman Islands",
	"kz" => "Kazakhstan",
	"lb" => "Lebanon",
	"lc" => "Saint Lucia",
	"li" => "Liechtenstein",
	"lk" => "Sri Lanka",
	"lt" => "Lithuania",
	"lu" => "Luxembourg",
	"lv" => "Latvia",
	"ly" => "Libya",
	"ma" => "Morocco",
	"mc" => "Monaco",
	"md" => "Republic of moldova",
	"mg" => "Madagascar",
	"mn" => "Mongolia",
	"mo" => "Macau",
	"mp" => "Northern Mariana Islands",
	"ms" => "Montserrat",
	"mt" => "Malta",
	"mx" => "Mexico",
	"my" => "Malaysia",
	"mz" => "Mozambique",
	"na" => "Namibia",
	"nc" => "New Caledonia",
	"nf" => "Norfolk Island",
	"nl" => "Netherlands",
	"no" => "Norway",
	"np" => "Nepal",
	"nr" => "Nauru",
	"nz" => "New zealand",
	"om" => "Oman",
	"pa" => "Panama",
	"pe" => "Peru",
	"pf" => "French Polynesia",
	"ph" => "Philippines",
	"pk" => "Pakistan",
	"pl" => "Poland",
	"pm" => "St. Pierre and Miquelon",
	"pr" => "Puerto Rico",
	"pt" => "Portugal",
	"py" => "Paraguay",
	"qa" => "Qatar",
	"ro" => "Romania",
	"ru" => "Russian federation",
	"sa" => "Saudi arabia",
	"sb" => "Solomon Islands",
	"sca" => "Scandinavia",
	"sd" => "Sudan",
	"se" => "Sweden",
	"sg" => "Singapore",
	"si" => "Slovenia",
	"sk" => "Slovakia (slovak republic)",
	"sl" => "Sierra Leone",
	"so" => "Somalia",
	"tc" => "Turks and Caicos Islands",
	"tg" => "Togo",
	"th" => "Thailand",
	"tn" => "Tunisia",
	"to" => "Tonga",
	"tp" => "East Timor",
	"tr" => "Turkey",
	"tt" => "Trinidad and Tobago",
	"tv" => "Tuvalu",
	"tw" => "Taiwan",
	"tz" => "Tanzania",
	"ua" => "Ukraine",
	"ug" => "Uganda",
	"uk" => "United Kingdom",
	"us" => "United states of america",
	"uy" => "Uruguay",
	"va" => "Vatican City State (Holy See)",
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
	"1" => "January",
	"2" => "February",
	"3" => "March",
	"4" => "April",
	"5" => "May",
	"6" => "June",
	"7" => "July",
	"8" => "August",
	"9" => "September",
	"10" => "October",
	"11" => "November",
	"12" => "December"
);

## ----------------------------- DEFINE WEEKDAY NAMES ------------------------------- ##
$weekdaynames = array(
	"Su",
	"Mo",
	"Tu",
	"Wed",
	"Thu",
	"Fr",
	"Sa"
);

## ------------------------------- DEFINE LANGUAGES --------------------------------- ##
$languages = array(
	"german" => "German",
	"english" => "English",
	"french" => "French",
	"danish" => "Danish",
	"dutch" => "Dutch",
	"spanish" => "Spanish",
	"portuguese" => "Portuguese",
	"italian" => "Italian",
	"hungarian" => "Hungarian"
);

## ------------------------- DEFINE GLOBAL LANGUAGE VARS ---------------------------- ##
$str["SHOWIP"] = "Show IP";
$str["NEWCOMMENT"] = "New Comment";
$str["ADDCOMMENT"] = "Add Comment";
$str["EDITCOMMENT"] = "Edit Comment";
$str["DELETECOMMENT"] = "Delete Comment";
$str["COMMENT"] = "Comment";
$str["COMMENTS"] = "Comments";
$str["ENTERCOMMENT"] = "Please enter Comment";
$str["BACKTOCOMMENTS"] = "Back to Comments";
$str["ADD"] = "Add";
$str["CLOSEWINDOW"] = "Close Window";
$str["CLICKONSMILIETOINSERT"] = "Click on a smilie to insert it";
$str["INSERTTHISSMILIE"] = "Insert this Smilie";
$str["MORE"] = "more";
$str["PLEASECHOOSE"] = "Please choose";
$str["STATISTICS"] = "Statistics";
$str["AVAILABLE"] = "available";
$str["YES"] = "Yes";
$str["NO"] = "No";
$str["SHORT"] = "short";
$str["NOTAVAILABLE"] = "not available";
$str["NOTAVAILABLESHORT"] = "n/a";
$str["DATE"] = "Date";
$str["DAY"] = "Day";
$str["MONTH"] = "Month";
$str["YEAR"] = "Year";
$str["TIME"] = "Time";
$str["OPPONENT"] = "Opponent";
$str["GAME"] = "Game";
$str["RESULT"] = "Result";
$str["CURRENTLY"] = "Currently";
$str["SHOW"] = "Show";
$str["CHALLENGEUS"] = "Challenge us";
$str["LEGEND"] = "Legend";
$str["NAME"]="Name";
$str["SERVER"] = "Server";
$str["FULL"] = "full";
$str["CONTACT"] = "Contact";
$str["PLAYERS"] = "Players";
$str["PLAYERPERTEAM"] = "Player per Team";
$str["LOCATIONS"] = "Locations";
$str["LOCATION"] = "Location";
$str["OWNSCORES"] = "Own Scores";
$str["OPPSCORES"] = "Opponent Scores";
$str["AVERAGE"] = "average";
$str["ADDITIONALINFO"] = "Additional Info";
$str["SIGNEDMEMBERS"] = "Signed up Members";
$str["MOREREQUIRED"] = "more required";
$str["OPTIONS"] = "Options";
$str["SIGNUP"] = "Signup";
$str["SIGNOFF"] = "Signoff";
$str["CALENDAR"] = "Calendar";
$str["JUMPTOCURRENTMONTH"] = "Jump to current Month";
$str["ON"] = "On";
$str["OFF"] = "Off";
$str["HTMLIS"] = "HTML is";
$str["SMILIES"] = "Smilies";
$str["ARE"] = "are";
$str["BBCODE"] = "BB Code";
$str["IS"] = "is";
$str["EVENTCALENDAR"] = "Event Calendar";
$str["EVENTDETAILS"] = "Event Details";
$str["BACKTOCALENDAR"] = "Back to Calendar";
$str["ADDEDBY"] = "Added by";
$str["VISITHOMEPAGE"] = "Visit Homepage of";
$str["ADDTOCONTACTLIST"] = "Add to Contactlist";
$str["CLICKMEMBERPROFILE"] = "Click on ".makeimgtag($vwar_root . "images/button_profile.gif")." to see a members Profile";
$str["SHOWDETAILS"] = "Show Details";
$str["GAMES"] = "Games";
$str["SENDMAILTO"] = "Send an eMail to";
$str["PROFILEOF"] = "Profile of";
$str["PROFILELOCATION"] = "Location";
$str["PROFILEBIRTHDAY"] = "Birthday";
$str["PROFILEINTERESTS"] = "Interests";
$str["PROFILEGRAPHICCARD"] = "Graphiccard";
$str["PROFILECONNECTION"] = "Connection";
$str["PROFILEKEYBOARD"] = "Keyboard";
$str["PROFILEMOUSE"] = "Mouse";
$str["PHONENUMBERS"] = "Phone numbers";
$str["ONLYVISIBLETOMEMBERS"] = "Only visible to members";
$str["PHONE"] = "Phone";
$str["CELLULARPHONE"] = "Cellular Phone";
$str["BACKTOWARLIST"] = "Back to Warlist";
$str["BACKTOMEMBERLIST"] = "Back to Memberlist";
$str["BACKTOWARDETAILS"] = "Back to Wardetails";
$str["GAMESPLAYED"] = "played games";
$str["SHOWALL"] = "Show all";
$str["ENTERNAME"] = "Please enter Name";
$str["RESULTS"] = "Results";
$str["OTHERGAMESAGAINST"] = "Other Games against";
$str["PAGE"] = "Page";
$str["SORTTHISFIELDASC"] = "Sort this field ascending";
$str["SORTTHISFIELDDESC"] = "Sort this field descending";
$str["ASCENDING"] = "ascending";
$str["DESCENDING"] = "descending";
$str["CHALLENGE"] = "Challenge";
$str["GENERAL"] = "General";
$str["GAMETYPE"] = "Gametype";
$str["MATCHTYPE"] = "Matchtype";
$str["SELECT"] = "Select";
$str["ENTERTEAMNAME"] = "Enter Teamname";
$str["ENTERSHORTTEAMNAME"] = "Enter short Teamname";
$str["ENTERCONTACTNAME"] = "Enter Contactname";
$str["ENTERCONTACTEMAIL"] = "Enter Contactemail";
$str["CHALLENGEFORM"] = "Challenge Form";
$str["TEAM"] = "Team";
$str["ADDITIONALINFOFULL"] = "add additional infos here (e.g. special settings) or whatever you think we should know in addition to the given data";
$str["SELECTASMANY"] = "Select as many as needed";
$str["LOGGEDINAS"] = "You are logged in as";
$str["NOTLOGGEDIN"] = "You are not logged in";
$str["LOGIN"] = "Login";
$str["LOGIN2"] = "Login with username and password:";
$str["LOGOUT"] = "Logout";
$str["DETAILS"] = "Details";
$str["LANGUAGE"] = "Language";
$str["LISTBYSTATUS"] = "Memberstatus";
$str["LISTBYTEAMS"] = "Teams";
$str["LISTBY"] = "List by";
$str["PICTURE"] = "Picture";
$str["NONPUBLICDETAILS"] = "Non-Public Details <small>(only visible to members)</small>";
$str["FIRSTPAGE"] = "First Page";
$str["LASTPAGE"] = "Last Page";
$str["PREVIOUSPAGE"] = "Previous Page";
$str["NEXTPAGE"] = "Next Page";
$str["ALL"] = "All";
$str["SCORE"] = "Score";
$str["COUNTRY"] = "Country";
$str["EDIT"] = "Edit";
$str["DELETE"] = "Delete";
$str["PERFORMDELETE"] = "Perform Delete ?";
$str["GUEST"] = "Guest";
$str["REPORT"] = "Report";
$str["BIRTHDAY"] = "Birthday";
$str["JOINUS"] = "Join us";
$str["JOINUSFORM"] = "Application form";
$str["PERSONALDETAILS"] = "Personal Details";
$str["JOINSUSADDITIONALINFO"] = "Describe shortly why do you want to join us and which information could be of interest to us additionally!";
$str["WEWILLCONTACTYOU"] = "We will contact you as soon as possible";
$str["THANKSFORREQUEST"] = "Thank you for your request";
$str["EQUIPMENT"] = "Equipment";
$str["GENERALINFORMATIONS"] = "General Information";
$str["AGE"] = "Age";
$str["ALLTIMESARE"] = "All times are";
$str["TIMENOWIS"] = "The time now is";
$str["STATUSWARS"] = "Wars without status";
$str["TODAYWARS"] = "Today's Wars";
$str["WARSSTATUS"] = "Status<br><smallfont>(signed up/required)</smallfont>";
$str["ALLSTATUSSET"] = "At all wars the status has been set";
$str["OWNGAMES"] = "Own games";
$str["NOENTRY"] = "No entries available";
$str["SITEGENERATEDWITH"] = "Site generated with";
$str["QUERYSIN"] = "Queries in";
$str["SIMPLEMODE"] = "Simple Mode";
$str["ADVANCEDMODE"] = "Advanced Mode";
$str["CLOSECURRENTTAG"] = "Close current Tag";
$str["CLOSEALLTAGS"] = "Close all Tags";
$str["FORMATTEXT"] = "Enter the text you want to format:";
$str["FORMATTEXTADDITIONAL"] = "Enter the text you want to format - ";
$str["PROMPTLINKTEXT"] = "Enter the text to be displayed for the link (optional):";
$str["PROMPTURLTEXT"] = "Enter the full URL for the link:";
$str["PROMPTMAILTEXT"] = "Enter the email address for the link";
$str["PROMPTLISTITEM"] = "Enter a list item.\nLeave the box empty or press 'Cancel' to complete the list.";
$str["SIZE"] = "size";
$str["HUGE"] = "huge";
$str["BIG"] = "big";
$str["NORMAL"] = "normal";
$str["SMALL"] = "small";
$str["FONT"] = "font";
$str["COLOR"] = "color";
$str["BOLDTEXT"] = "Bold Text";
$str["ITALICTEXT"] = "Italic Text";
$str["UNDERLINEDTEXT"] = "Underlined Text";
$str["CENTER"] = "Center";
$str["CREATELIST"] = "Create a List";
$str["INSERTHYPERLINK"] = "Insert a Hyperlink";
$str["INSERTCODE"] = "Insert a Code";
$str["INSERTMAIL"] = "Insert an eMail Address";
$str["INSERTQUOTE"] = "Insert a Quote";
$str["INSERTIMAGE"] = "Insert an Image";
$str["HELP"] = "Help";
$str["CLICKONARROWTOINSERTCODE"] = "Click on the Arrow to insert the BB Code.<br>Low or High Case is unimportant, URLs are transformed automatically.";
$str["PLAY"] = "played or to be played";
$str["CANCELLED"] = "cancelled";
$str["OPPONENTLIST"] = "Opponent List";
$str["MEMBERGALLERY"] = "Member Gallery";
$str["CONTACTLIST"] = "Contact List";
$str["RECEIVER"] = "Receiver";
$str["SENDERNAME"] = "Sender Name";
$str["SENDERMAIL"] = "Sender E-Mail";
$str["SUBJECT"] = "Subject";
$str["FORMAT"] = "Format";
$str["MESSAGE"] = "Message";
$str["CONTENT"] = "Content";
$str["ENTER"] = "Enter";
$str["SEND"] = "Send";
$str["PRIORITY"] = "Priority";
$str["BACKTONEWS"] = "Back to Newsdetails";
$str["QUOTE"] = "Quote";
$str["BACK"] = "back";
$str["TITLE"] = "Title";
$str["NOICON"] = "No Icon";
$str["PREVIEW"] = "Preview";
$str["TOTAL"] = "Total";
$str["GUESTBOOKOF"] = "Guestbook of";
$str["FUNCTIONDISABLED"] = "This function is <b>disabled</b>!";
$str["GOTO"] = "Go&nbsp;to";
$str["PASSWORD"] = "Password";
$str["FORGOTPASSWORD"] = "Forgot Password?";
$str["ARCHIVE"] = "Archive";
$str["CATEGORY"] = "Category";
$str["SEARCH"] = "Search";
$str["ENLARGE"] = "Enlarge";
$str["PRINT"] = "Print";
$str["SUBMIT"] = "Submit";
$str["REDIRECT"] = "Click here if you do not want to wait any longer<br>(or if your browser does not automatically forward you)";
$str["ENTEREDREGISTEREDDATA"] = "You entered registered Data (Name, E-Mail). Change it to a non-registered value!";
$str["SEARCHKEYWORD"] = "Search for keyword";
$str["SEARCHAUTHOR"] = "Search for author";
$str["MATCHEXACTNAME"] = "Match exact name";
$str["MATCHPARTIALNAME"] = "Match partial name";
$str["USEWILDCARD"] = "Use * as a wildcard for partial matches";
$str["SEARCHOPTIONS"] = "You can use <u>AND</u>, <u>OR</u> and <u>NOT</u> to search more detailed";
$str["CONNECTSEARCHES"] = "You can connect the search for a keyword with a search for an author";
$str["USEEXACTPHRASE"] = 'Text between two " will be searched as an exact phrase';
$str["SEARCHIN"] = "Search in";
$str["SEARCHFORRESULTSIN"] = "Search for results in";
$str["DISPLAYMODE"] = "Displaymode";
$str["SEARCHINTEXT"] = "Search in text";
$str["SEARCHINSUBJECT"] = "Search in subject";
$str["SHOWASOVERVIEW"] = "Show as overview";
$str["SHOWINDETAILS"] = "Show in details";
$str["SEARCHFORRESULTS"] = "Search for results";
$str["SORTRESULTBY"] = "Sort result by";
$str["OF"] = "of";
$str["LASTDAYS0"] = "any date";
$str["LASTDAYS1"] = "yesterday";
$str["LASTDAYS7"] = "last week";
$str["LASTDAYS14"] = "last two weeks";
$str["LASTDAYS30"] = "last month";
$str["LASTDAYS90"] = "last three months";
$str["LASTDAYS180"] = "last six months";
$str["LASTDAYS365"] = "last year";
$str["AND"] = "and";
$str["NEWER"] = "newer";
$str["OLDER"] = "older";
$str["AUTHOR"] = "Author";
$str["NUMLINKS"] = "Number of links";
$str["ADVANCEDSEARCH"] = "Advanced Search";
$str["REQUIREDFIELDS"] = 'Fields marked with <font color="red">*</font> are required';
$str["OR"] = "or";
$str["LENGTHSEARCHWORD"] = "The length of the searchword must fulfill the word length of at least 3 letters.";
$str["SEARCHINFORMATION"] = "Search Information";
$str["NEWSCOMMENTS"] = "News Comments";
$str["SENDNEWS"] = "Send News";
$str["RECEIVERMAIL"] = "Receiver E-Mail";
$str["MOREFUNCTION"] = "More-Function: <b>enabled</b><br>You can divide your content with";
$str["SUBMITTED"] = "(submitted)";
$str["AREYOUSURETODELETE"] = "Are you sure you want delete the selected item?";
$str["NORMALMODE"] = "Normal Mode";
$str["LISTMODE"] = "List Mode";
$str["PROMPTLISTTYPE"] = "Listtypes: '1' = numbered, 'a' = small letters,\n'I' = upper roman, leave blank = bullet points";
$str["LASTEDITEDBY"] = "Last edited by";

## ---- START CUSTOM PART ---- ##
## ---- START "GB" ---- ##

$str["GB_NAME"] = "Guestbook";

$str["GB_INFOLINE"] = "%1 %2 on %3 %4";

$str["GB_PAGE"] = "Page";

$str["GB_PAGES"] = "Pages";

$str["GB_ENTRY"] = "Entry";

$str["GB_ENTRIES"] = "Entries";

$str["GB_ADDENTRY"] = "Add Entry";

$str["GB_ADDANENTRY"] = "Add an Entry to the Guestbook";

$str["GB_EDITENTRY"] = "Edit Entry";

$str["GB_EDITANENTRY"] = "Edit an Entry";

$str["GB_BACKTOGB"] = "Back to Guestbook";

$str["GB_WARNINGNAME"] = "Please enter a Name!";

$str["GB_WARNINGTEXT"] = "Please enter a Text!";

$str["GB_ADDNAME"] = "Name";

$str["GB_ADDEMAIL"] = "eMail";

$str["GB_ADDHOMEPAGE"] = "Homepage";

$str["GB_ADDICQ"] = "ICQ-UIN";

$str["GB_ADDAIM"] = "AIM";

$str["GB_ADDYIM"] = "YIM";

$str["GB_ADDMSN"] = "MSN";

$str["GB_TITLE"] = "Title";

$str["GB_BLOCKED"] = "You already wrote an entry in the last <b>%1 %2</b>.";

$str["GB_MINUTE"] = "Minute";

$str["GB_MINUTES"] = "Minutes";

$str["GB_COMMENT"] = "Comment";

$str["GB_COMMENTS"] = "Comments";

$str["GB_ENTRYBY"] = "Guestbook Entry by";
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
	"me" => "Male",
	"wo" => "Female",
	"no" => "No comment",
);
$str["SEX"] = "Sex";
## ---- END "SEX" ---- ##
$str["WARTAG"]="War Tag";
## ---- END CUSTOM PART ---- ##
?>
