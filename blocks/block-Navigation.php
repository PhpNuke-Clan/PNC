<?php



/************************************************************************/

/* TechGFX Navigation Block v.2.1.0                           COPYRIGHT */

/*                                                                      */

/* Copyright (c) 2004 - 2006 by http://www.techgfx.com                  */

/*     Techgfx - Graeme Allan                       (goose@techgfx.com) */

/*                                                                      */

/************************************************************************/

/* PHP-Nuke Platinum: Expect to be impressed                  COPYRIGHT */

/*                                                                      */

/* Copyright (c) 2004 - 2006 by http://www.techgfx.com                  */

/*     Techgfx - Graeme Allan                       (goose@techgfx.com) */

/*                                                                      */

/* Copyright (c) 2004 - 2006 by http://www.conrads-berlin.de            */

/*     MrFluffy - Axel Conrads                 (axel@conrads-berlin.de) */

/*                                                                      */

/* Refer to TechGFX.com for detailed information on PHP-Nuke Platinum   */

/*                                                                      */

/* TechGFX: Your dreams, our imagination                                */

/************************************************************************/





if ( !defined('CORE_FILE') ) {

	die("Illegal Block File Access");

}



global $prefix, $db, $admin, $user;



/*****************************************************/

/* Uncomment the following if you wish               */

/*****************************************************/

//$mouseOver = "#000000";

//$mouseOut = "#000000";



/*****************************************************/

/* 0 = No search                      1 = Yes search */

/*****************************************************/

$viewSearch = "0";



/*****************************************************/

/* 0 = Dropdown style                1 = Block style */

/*****************************************************/

$dropDown = "0";



/*****************************************************/

/* Variable declarations                             */

/*****************************************************/

$admcontent = "";

$actionMenu = "onMouseOver=\"this.style.background='$mouseOver'\" onMouseOut=\"this.style.background='$mouseOut'\" style=\"cursor:pointer;cursor:hand\" onclick=\"window.location.href=";



$result = $db->sql_query("select main_module from ".$prefix."_main");

list($main_module) = $db->sql_fetchrow($result);



/*****************************************************/

/* Remove module from database if does not exist     */

/*****************************************************/

$result = $db->sql_query("select title from ".$prefix."_modules");

while (list($title) = $db->sql_fetchrow($result)) {

    $a = 0;

    $handle=opendir('modules');

    while ($file = readdir($handle)) {

        if ($file == $title) {

            $a = 1;

        }

    }

    closedir($handle);

    if ($a == 0) {

        $db->sql_query("delete from ".$prefix."_modules where title='$title'");

    }

}



/*****************************************************/

/* Interface with correspondent url's                */

/*****************************************************/

$content = "<TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\" WIDTH=\"95%\">";

$content .="<TR><TD class=\"info1\"><b>Main</b></TD></TR>";

$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"index.php\">"._HOME."</a></TD></TR>\n";

//$content .= "<strong><big>·</big></strong> <a href=\"index.php\">"._HOME."</a><br>\n";



$sql = "SELECT mcid, mcname FROM ".$prefix."_modules_categories WHERE visible='1' ORDER BY mcid ASC";

$result2 = $db->sql_query($sql);

while ($row = $db->sql_fetchrow($result2)) {

    $mcid = $row[mcid];

    $mcname = $row[mcname];

    if (file_exists("images/blocks/modules/".$mcname.".gif")) {

        $content .="<tr><TD class=\"info1\" valign=middle> <img src=\"images/blocks/modules/".$mcname.".gif\"> <b>".$mcname."</b></td></tr>\n";

    } else {

        $content .="<tr><TD class=\"info1\"> <b>".$mcname."</b></td></tr>\n";

    }



/*****************************************************/

/* Module - NSN Groups v.1.6.3                 START */

/*****************************************************/

    $sql = "SELECT title, custom_title, view, groups FROM ".$prefix."_modules WHERE active='1' AND title!='$def_module' AND inmenu='1' AND mcid='$mcid' ORDER BY custom_title ASC";

/*****************************************************/

/* Module - NSN Groups v.1.6.3                   END */

/*****************************************************/

    $result = $db->sql_query($sql);

    while ($row = $db->sql_fetchrow($result)) {

        $m_title = $row[title];

        $custom_title = $row[custom_title];

        $view = $row[view];



/*****************************************************/

/* Module - NSN Groups v.1.6.3                 START */

/*****************************************************/

        $groups = $row['groups'];

/*****************************************************/

/* Module - NSN Groups v.1.6.3                   END */

/*****************************************************/

        if ($custom_title != "") {

            $m_title2 = $custom_title;

        }

        $m_title2 = ereg_replace("_", " ", $m_title2);



/*****************************************************/

/* Module - NSN Groups v.1.6.3                 START */

/*****************************************************/



        /*if ($m_title != $main_module) {

            if ((is_admin($admin) AND $view == 2) OR $view != 2) {

                $content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules.php?name=$m_title\">".boldit($m_title,$m_title2)."</a></TD></TR>\n";

            }*/



        if ($m_title != $main_module) {

	        if ($view == 0) {

		        if (eregi($m_title,$_SERVER['REQUEST_URI'])) {

    				$content .= "<TR><TD class=\"row1\">&nbsp;<b><a href=\"modules.php?name=$m_title\">$m_title2</a></b></TD></TR>\n"; 

					} else { 

						$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a></TD></TR>\n";

            	}



        } elseif ($view == 1 AND is_user($user)) {

                if (eregi($m_title,$_SERVER['REQUEST_URI'])) {

    				$content .= "<TR><TD class=\"row1\">&nbsp;<b><a href=\"modules.php?name=$m_title\">$m_title2</a></b></TD></TR>\n";

					} else { $content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a></TD></TR>\n";

            	} 

        } elseif ($view == 2 AND is_admin($admin)) {

                if (eregi($m_title,$_SERVER['REQUEST_URI'])) {

    				$content .= "<TR><TD class=\"row1\">&nbsp;<b><a href=\"modules.php?name=$m_title\">$m_title2</a></b></TD></TR>\n";

					} else { $content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a></TD></TR>\n";

            	}

        } elseif ($view == 3 AND paid()) {

                if (eregi($m_title,$_SERVER['REQUEST_URI'])) {

    				$content .= "<TR><TD class=\"row1\">&nbsp;<b><a href=\"modules.php?name=$m_title\">$m_title2</a></b></TD></TR>\n";

					} else { $content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a></TD></TR>\n";

            	} 

        } elseif ($view > 3 AND in_groups($groups)) {

                if (eregi($m_title,$_SERVER['REQUEST_URI'])) {

    				$content .= "<TR><TD class=\"row1\">&nbsp;<b><a href=\"modules.php?name=$m_title\">$m_title2</a></b></TD></TR>\n";

					} else { $content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a></TD></TR>\n";

					}

				}

			}

		}

	}



/*****************************************************/

/* Module - NSN Groups v.1.6.3                   END */

/*****************************************************/


$content .= "</table>\n";

$content .= "<TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\" WIDTH=\"95%\"><tr><TD class=\"info1\"><b>".Resources."</b></td></tr></table>\n";

$content .= "<TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\" WIDTH=\"95%\">\n";

$content .= "<tr><TD class=\"row1\">&nbsp;<a href=\"http://www.phpnuke-clan.net/\" target=_blank>PHPNUKE-CLAN</a><br>\n";
$content .= "<tr><TD class=\"row1\">&nbsp;<a href=\"http://www.areyouserved.com/index.php?aid=pra42493\" target=_blank>HOSTING</a><br>\n";
//$content .= "<tr><TD class=\"row1\">&nbsp;<a href=\"http://www.areyouserved.com/idevaffiliate/idevaffiliate.php?id=102\" target=_blank>HOSTING</a><br>\n";
$content .= "<tr><TD class=\"row1\">&nbsp;<a href=\"http://www.gamerthemes.com/\" target=_blank>THEMES</a><br>\n";
$content .= "<tr><TD class=\"row1\">&nbsp;<a href=\"http://www.vwar.de/\" target=_blank>VWAR</a><br>\n";
$content .= "<tr><TD class=\"row1\">&nbsp;<a href=\"http://www.squery.com/\" target=_blank>SQUERY</a><br>\n";
$content .= "<tr><TD class=\"row1\">&nbsp;<a href=\"http://www.ravenphpscripts.com/\" target=_blank>RAVENPHPSCRIPT</a>\n";
$content .= "</TD></TR>\n";

$content .= "<tr><TD class=\"row1\">&nbsp;<a href=\"http://www.clanservers.com/?ref=1583221/\" target=_blank>CLAN SERVERS</a></TD></TR>\n";

$content .= "<tr><TD class=\"row1\">&nbsp;<a href=\"https://secure.hostgator.com/cgi-bin/affiliates/clickthru.cgi?id=pratcom/\" target=_blank>HOST GATOR</a></TD></TR>\n";

$content .= "</table>\n";


/*****************************************************/

/* Dropdown / block style selection menu creation    */

/*****************************************************/

if ($dropDown == 0){

    $content .= "<br><TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\"><TR><td><FORM METHOD=\"POST\" ACTION=\"modules.php\"><SELECT NAME=\"name\" onChange=\"top.location.href=this.options[this.selectedIndex].value\"><OPTION VALUE=\"\">Full Selection";

} else {

    $content .= "<br><TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\"><TR><td><FORM METHOD=\"POST\" ACTION=\"modules.php\"><SELECT NAME=\"name\" MULTIPLE SIZE=\"$row2show\" onChange=\"top.location.href=this.options[this.selectedIndex].value\"><OPTION VALUE=\"\">Full Selection";

}



$content .= "<OPTION VALUE=\"\">---------------\n";

$result = $db->sql_query("select title, custom_title, view from ".$prefix."_modules where active='1' AND title!='$def_module' AND inmenu='1' ORDER BY title ASC");

while(list($m_title, $custom_title, $view) = $db->sql_fetchrow($result)) {

    if ($custom_title != "") {

        $m_title2 = $custom_title;

    }

    $m_title2 = ereg_replace("_", " ", $m_title2);

    if ($m_title != $main_module) {

        if ((is_admin($admin) AND $view == 2) OR $view != 2) {

            $content .= "<OPTION VALUE=\"modules.php?name=$m_title\">$m_title2\n";

        }

    }

}



/*****************************************************/

/* If admin, display inactive modules                */

/*****************************************************/

if (is_admin($admin)) {

    $handle=opendir('modules');

    while ($file = readdir($handle)) {

        if ( (!ereg("[.]",$file)) ) {

            $modlist .= "$file ";

        }

    }

    closedir($handle);

    $modlist = explode(" ", $modlist);

    sort($modlist);

    for ($i=0; $i < sizeof($modlist); $i++) {



/*****************************************************/

/* If module exists, add to database                 */

/*****************************************************/

    if($modlist[$i] != "") {

        $result = $db->sql_query("select mid from ".$prefix."_modules where title='$modlist[$i]'");

        list ($mid) = $db->sql_fetchrow($result);

        if ($mid == "") {

                    $db->sql_query("INSERT INTO ".$prefix."_modules values (NULL, '$modlist[$i]', '$modlist[$i]', '0', '0', '', '1', '0', '1', '')");

        }

    }

}



$content .= "<OPTION VALUE=\"\">---------------\n";

$content .= "<OPTION VALUE=\"\">"._INVISIBLEMODULES."\n";

$content .= "<OPTION VALUE=\"\">---------------\n";



/*****************************************************/

/* If admin, display invisible modules               */

/*****************************************************/

$admcontent .="</TABLE><BR>";

$admcontent .= "<TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\" WIDTH=\"95%\">\n";

$admcontent .="<TR><TD class=\"info1\"> <b>"._INVISIBLEMODULES."</b></TD></TR>\n";

$result = $db->sql_query("select title, custom_title from ".$prefix."_modules where active='1' AND inmenu='0' ORDER BY title ASC");

while(list($mn_title, $custom_title) = $db->sql_fetchrow($result)) {

    if ($custom_title != "") {

        $mn_title2 = $custom_title;

    }

    $mn_title2 = ereg_replace("_", " ", $mn_title2);

    if ($mn_title2 != "") {

        $content .= "<OPTION VALUE=\"modules.php?name=$mn_title\">$mn_title2\n";

        //@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo

        $admcontent .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules.php?name=$mn_title\">$mn_title2</a></TD></TR>\n";

        $dummy = 1;

    } else {

        $a = 1;

    }

}



/*****************************************************/

/* If no invisible modules, display lang variable    */

/*****************************************************/

if ($a = 1 AND $dummy != 1) {

    $content .= "<OPTION VALUE=\"\">"._NONE."\n";

    $admcontent .= "<TR><TD class=\"row1\">&nbsp;"._NONE."</TD></TR>\n";

}



$content .= "<OPTION VALUE=\"\">---------------\n";

$content .= "<OPTION VALUE=\"\">"._NOACTIVEMODULES."\n";

$content .= "<OPTION VALUE=\"\">---------------\n";



/*****************************************************/

/* If admin, display inactive modules                */

/*****************************************************/

$admcontent .= "<TR><TD class=\"info1\"> <b>"._NOACTIVEMODULES."</b></TD></TR>\n";

$result = $db->sql_query("select title, custom_title from ".$prefix."_modules where active='0' ORDER BY title ASC");

while(list($mn_title, $custom_title) = $db->sql_fetchrow($result)) {

    if ($custom_title != "") {

        $mn_title2 = $custom_title;

    }

    $mn_title2 = ereg_replace("_", " ", $mn_title2);

    if ($mn_title2 != "") {

        $content .= "<OPTION VALUE=\"modules.php?name=$mn_title\">$mn_title2\n";

        $admcontent .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules.php?name=$mn_title\">$mn_title2</a></TD></TR>\n";

        $dummy = 1;

    } else {

        $a = 1;

    }

}

/*****************************************************/

/* If no inactive modules, display lang variable     */

/*****************************************************/

if ($a = 1 AND $dummy != 1) {

    $content .= "<OPTION VALUE=\"\">"._NONE."\n";

    $admcontent .= "<TR><TD class=\"row1\">&nbsp;"._NONE."</TD></TR>\n";

}

}

$content .= "</SELECT></FORM></TD></TR>";

$content .= $admcontent;

$content .= "</TABLE>";



/*****************************************************/

/* Search function / feature                         */

/*****************************************************/

if ($viewSearch == 1){

    $content .= "<TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\"><TR><form action=\"modules.php?name=Search\" method=\"post\">";

    $content .= "<br><center><input type=\"text\" onfocus=\"value=''\" value=\"Site Search\" name=\"query\" size=\"20\"></center>";

    $content .= "</form></TD></TR></TABLE>";

} else {

    return;

} 



?>

