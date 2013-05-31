<?php
/************************************************************************/
/* PHP-Nuke ThemeConsole v.1                                  COPYRIGHT */
/*                                                                      */
/* Copyright (c) 2004 by http://www.techgfx.com                         */
/*     Techgfx  (goose@techgfx.com)                                     */
/* Copyright (c) 2004 by http://www.portedmods.com                      */
/*     Anor     (anor@portedmods.com)                                   */
/*     Mighty_Y (mighty_y@portedmods.com)                               */
/*                                                                      */
/* TechGFX: Your dreams, Our imagination                                */
/************************************************************************/
if ( !defined('ADMIN_FILE') )
{
	die ("Access Denied");
}
global $admin_file;
//if (!eregi("".$admin_file.".php", $PHP_SELF)) { die ("Access Denied"); }
//if (!eregi("".$admin_file.".php", $_SERVER['PHP_SELF'])) { die ("Access Denied"); }

$result = $db->sql_query("select radminsuper from ".$prefix."_authors where aid='$aid'");
list($radminsuper) = $db->sql_fetchrow($result);
if ($radminsuper==1) {
if (file_exists("admin/language/themeconsole/lang-$language-admin.php"))
{
	include("admin/language/themeconsole/lang-$language-admin.php");
}
else
{
	include("admin/language/themeconsole/lang-english-admin.php");
}
function IndexAdmin() {
    global $user, $userinfo, $Default_Theme, $cookie, $module_name;
        include ("header.php");
        GraphicAdmin();
        title(_TC_THEMESELECTION);
        OpenTable();
        echo "<center>\n"
            ."<form action='admin.php' method='post'>\n"
            ."<b>"._TC_SELECTTHEME."</b><br>\n"
            ."<select name='theme'>\n";
        $handle=opendir('themes');
        while ($file = readdir($handle)) {
            if ( (!ereg("[.]",$file) AND file_exists("themes/$file/theme.php")) ) {
                $themelist .= "$file ";
            }
        }
        closedir($handle);
        $themelist = explode(" ", $themelist);
        sort($themelist);
        for ($i=0; $i < sizeof($themelist); $i++) {
            if($themelist[$i]!="") {
                echo "<option value='$themelist[$i]'>$themelist[$i]</option>\n";
            }
        }
        echo "</select><br><br />\n"
            ."<input type='hidden' name='op' value='themeconsolemake'>\n"
            ."<input type='submit' value='"._TC_THEME."'>\n"
            ."</form>\n";
        CloseTable();
echo "<script type=\"text/javascript\">\n";
echo "<!--\n";
echo "function tcopenpopup(){\n";
echo "	window.open (\"admin.php?op=tccopyright\",\"ThemeConsole\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=auto,resizable=no,copyhistory=no,width=400,height=230\");\n";
echo "}\n";
echo "//-->\n";
echo "</SCRIPT>\n\n";
echo "<div align=\"right\">© <a href=\"javascript:tcopenpopup()\">ThemeConsole</a></div>";
        include ("footer.php");
}
function ThemeConsole($theme) {
    global $prefix, $db, $bgcolor2;
    $result = $db->sql_query("SELECT * FROM ".$prefix."_themeconsole WHERE themename='$theme'");
    if ($db->sql_numrows($result) == 0){
    $db->sql_query("INSERT INTO ".$prefix."_themeconsole SET themename='$theme'");
    $result = $db->sql_query("SELECT * FROM ".$prefix."_themeconsole WHERE themename='$theme'");
    $themeconsole = $db->sql_fetchrow($result);
    }else{
    $themeconsole = $db->sql_fetchrow($result);
    }
    include ("header.php");
    GraphicAdmin();
    title(_TC_THEMECONSOLE.$theme);
    OpenTable();
    echo "<center>\n";
    echo "<table border='0'>\n";
    echo "<form action='admin.php' method='post'>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_MESS1."</td><td><input type='text' name='xmess1' value='".$themeconsole['marq1']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_MESS2."</td><td><input type='text' name='xmess2' value='".$themeconsole['marq2']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_MESS3."</td><td><input type='text' name='xmess3' value='".$themeconsole['marq3']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_MESS4."</td><td><input type='text' name='xmess4' value='".$themeconsole['marq4']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_MESS5."</td><td><input type='text' name='xmess5' value='".$themeconsole['marq5']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_MESSSTYLE."</td><td><select name='xstyle'>\n";
    if ($themeconsole['marqstyle'] == '1'){
    echo "<option value='1' selected>DHTML Scroller</option>\n";
    }else{
    echo "<option value='1'>DHTML Scroller</option>\n";
    }
    if ($themeconsole['marqstyle'] == '2'){
    echo "<option value='2' selected>Fading Scroller</option>\n";
    }else{
    echo "<option value='2'>Fading Scroller</option>\n";
    }
    if ($themeconsole['marqstyle'] == '3'){
    echo "<option value='3' selected>Marquee</option>\n";
    }else{
    echo "<option value='3'>Marquee</option>\n";
    }
    if ($themeconsole['marqstyle'] == '99'){
    echo "<option value='99' selected>None</option>\n";
    }else{
    echo "<option value='99'>None</option>\n";
    }
    echo "</select></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_LINK1."</td><td><input type='text' name='xlink1' value='".$themeconsole['hlink1']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_LINK1URL."</td><td><input type='text' name='xlink1url' value='".$themeconsole['hlinkurl1']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_LINK2."</td><td><input type='text' name='xlink2' value='".$themeconsole['hlink2']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_LINK2URL."</td><td><input type='text' name='xlink2url' value='".$themeconsole['hlinkurl2']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_LINK3."</td><td><input type='text' name='xlink3' value='".$themeconsole['hlink3']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_LINK3URL."</td><td><input type='text' name='xlink3url' value='".$themeconsole['hlinkurl3']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_LINK4."</td><td><input type='text' name='xlink4' value='".$themeconsole['hlink4']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_LINK4URL."</td><td><input type='text' name='xlink4url' value='".$themeconsole['hlinkurl4']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_LINK5."</td><td><input type='text' name='xlink5' value='".$themeconsole['hlink5']."' size='40' maxlength='255'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_LINK5URL."</td><td><input type='text' name='xlink5url' value='".$themeconsole['hlinkurl5']."' size='40' maxlength='255'></td></tr>\n";
    if ($themeconsole['searchbox']==1) {$sel1 = "checked"; $sel2 = ""; } else { $sel1 = ""; $sel2 = "checked"; }
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_SEARCHBOX." </td><td><input type='radio' name='xsearchbox' value='1' $sel1>"._TC_ON." &nbsp; <input type='radio' name='xsearchbox' value='0' $sel2>"._TC_OFF."</td></tr>\n";
    if ($themeconsole['flashswitch']==1) {$sel1 = "checked"; $sel2 = ""; } else { $sel1 = ""; $sel2 = "checked"; }
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_FLASH." </td><td><input type='radio' name='xflashswitch' value='1' $sel1>"._TC_ON." &nbsp; <input type='radio' name='xflashswitch' value='0' $sel2>"._TC_OFF."</td></tr>\n";
    if ($themeconsole['pubbox']==1) {$sel1 = "checked"; $sel2 = ""; } else { $sel1 = ""; $sel2 = "checked"; }
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_PUBBOX." </td><td><input type='radio' name='xpubbox' value='1' $sel1>"._TC_ON." &nbsp; <input type='radio' name='xpubbox' value='0' $sel2>"._TC_OFF."</td></tr>\n";
	if ($themeconsole['disrightclick']==1) {$sel1 = "checked"; $sel2 = ""; } else { $sel1 = ""; $sel2 = "checked"; }
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_RIGHTCLICKDIS." </td><td><input type='radio' name='xdisrightclick' value='1' $sel1>"._TC_ON." &nbsp; <input type='radio' name='xdisrightclick' value='0' $sel2>"._TC_OFF."</td></tr>\n";
	if ($themeconsole['adminright']==1) {$sel1 = "checked"; $sel2 = ""; } else { $sel1 = ""; $sel2 = "checked"; }
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_ADMINRIGHT." </td><td><input type='radio' name='xadminright' value='1' $sel1>"._TC_ON." &nbsp; <input type='radio' name='xadminright' value='0' $sel2>"._TC_OFF."</td></tr>\n";
    if ($themeconsole['disselectall']==1) {$sel1 = "checked"; $sel2 = ""; } else { $sel1 = ""; $sel2 = "checked"; }
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_SELECTALLDIS." </td><td><input type='radio' name='xdisselectall' value='1' $sel1>"._TC_ON." &nbsp; <input type='radio' name='xdisselectall' value='0' $sel2>"._TC_OFF."</td></tr>\n";
	if ($themeconsole['adminselect']==1) {$sel1 = "checked"; $sel2 = ""; } else { $sel1 = ""; $sel2 = "checked"; }
	echo "<tr><td bgcolor='$bgcolor2'>"._TC_ADMINSELECT." </td><td><input type='radio' name='xadminselect' value='1' $sel1>"._TC_ON." &nbsp; <input type='radio' name='xadminselect' value='0' $sel2>"._TC_OFF."</td></tr>\n";
	if ($themeconsole['encrypt']==1) {$sel1 = "checked"; $sel2 = ""; } else { $sel1 = ""; $sel2 = "checked"; }
    echo "<tr><td bgcolor='$bgcolor2'>"._TC_ENCRYPT." </td><td><input type='radio' name='xencrypt' value='1' $sel1>"._TC_ON." &nbsp; <input type='radio' name='xencrypt' value='0' $sel2>"._TC_OFF."</td></tr>\n";
	echo "<tr><td colspan='2' align='center'>";
    echo "<input type='hidden' name='theme' value='$theme'>";
    echo "<input type='hidden' name='op' value='themeconsolesave'>";
    echo "<br><input type='submit' value='"._TC_SAVECHANGES."'></td></tr>";
    echo "</form>\n";
    echo "</table></center>\n";
    CloseTable();
echo "<script type=\"text/javascript\">\n";
echo "<!--\n";
echo "function tcopenpopup(){\n";
echo "	window.open (\"admin.php?op=tccopyright\",\"ThemeConsole\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=auto,resizable=no,copyhistory=no,width=400,height=230\");\n";
echo "}\n";
echo "//-->\n";
echo "</SCRIPT>\n\n";
echo "<div align=\"right\">© <a href=\"javascript:tcopenpopup()\">ThemeConsole</a></div>";
    include ("footer.php");
}
function tccopyright() {
    $module_version = "1.0.0";
    $module_description = "This ThemeConsole allows you to edit different parts of a ThemeConsole compatible theme, very easy to add 5 lines of marquee, 5 links and some functions to turn on or off";

    echo "<html>\n"
	."<body bgcolor=\"#F6F6EB\" link=\"#363636\" alink=\"#363636\" vlink=\"#363636\">\n"
	."<title>ThemeConsole: Copyright Information</title>\n"
	."<font size=\"2\" color=\"#363636\" face=\"Verdana, Helvetica\">\n"
	."<center><b>ThemeConsole &copy; Information</b></center><br>"
	."<img src=\"images/arrow.gif\" border=\"0\">&nbsp;<b>Author:</b> Mighty_Y, TechGFX<br>\n"
	."<img src=\"images/arrow.gif\" border=\"0\">&nbsp;<b>Version:</b> $module_version<br>\n"
	."<img src=\"images/arrow.gif\" border=\"0\">&nbsp;<b>Description:</b> $module_description<br>\n"
	."<img src=\"images/arrow.gif\" border=\"0\">&nbsp;<b>Bug Tested by:</b> <a href=\"http://www.techgfx.com\" target=\"blank\">TechGFX</a>, <a href=\"http://www.portedmods.com\" target=\"blank\">Mighty_Y</a><br><br>\n"
	."<center>[ <a href=\"http://www.techgfx.com\" target=\"new\">Author's HomePage</a> | <a href=\"javascript:void(0)\" onClick=javascript:self.close()>Close</a> ]</center>\n"
	."</font>\n"
	."</body>\n"
	."</html>";
}
switch($op) {
default:
    case "themeconsole":
    IndexAdmin();
    break;

    case "themeconsolemake":
    ThemeConsole($theme);
    break;

    case "themeconsolesave":
    $xmess1 = htmlentities($xmess1, ENT_QUOTES);
    $xmess2 = htmlentities($xmess2, ENT_QUOTES);
    $xmess3 = htmlentities($xmess3, ENT_QUOTES);
	$xmess4 = htmlentities($xmess4, ENT_QUOTES);
    $xmess5 = htmlentities($xmess5, ENT_QUOTES);
    $xlink1 = htmlentities($xlink1, ENT_QUOTES);
    $xlink2 = htmlentities($xlink2, ENT_QUOTES);
    $xlink3 = htmlentities($xlink3, ENT_QUOTES);
    $xlink4 = htmlentities($xlink4, ENT_QUOTES);
    $xlink5 = htmlentities($xlink5, ENT_QUOTES);
    $xlink1url = htmlentities($xlink1url, ENT_QUOTES);
    $xlink1url = htmlentities($xlink1url, ENT_QUOTES);
    $xlink1url = htmlentities($xlink1url, ENT_QUOTES);
    $xlink1url = htmlentities($xlink1url, ENT_QUOTES);
    $xlink1url = htmlentities($xlink1url, ENT_QUOTES);
    $db->sql_query("UPDATE ".$prefix."_themeconsole SET marq1='$xmess1', marq2='$xmess2', marq3='$xmess3', marq4='$xmess4', marq5='$xmess5', hlink1='$xlink1', hlinkurl1='$xlink1url', hlink2='$xlink2', hlinkurl2='$xlink2url', hlink3='$xlink3', hlinkurl3='$xlink3url', hlink4='$xlink4', hlinkurl4='$xlink4url', hlink5='$xlink5', hlinkurl5='$xlink5url', searchbox='$xsearchbox', flashswitch='$xflashswitch', disrightclick='$xdisrightclick', adminright='$xadminright', disselectall='$xdisselectall', adminselect='$xadminselect', encrypt='$xencrypt', marqstyle='$xstyle', pubbox='$xpubbox' WHERE themename='$theme'");
    Header("Location: admin.php?op=themeconsolemake&theme=$theme");
    break;

    case "tccopyright":
	tccopyright();
	break;

}

} else {
    echo "Access Denied";
}

?>