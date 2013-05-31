<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (stristr(htmlentities($_SERVER['PHP_SELF']), "javascript.php")) {
    Header("Location: ../index.php");
    die();
}

##################################################
# Include for some common javascripts functions  #
##################################################
if ($userpage == 1) {
    echo "<SCRIPT  LANGUAGE=\"JavaScript\" type=\"text/javascript\">\n";
    echo "<!--\n";
    echo "function showimage() {\n";
    echo "if (!document.images)\n";
    echo "return\n";
    echo "document.images.avatar.src=\n";
    echo "'$nukeurl/modules/Forums/images/avatars/gallery/' + document.Register.user_avatar.options[document.Register.user_avatar.selectedIndex].value\n";
    echo "}\n";
    echo "//-->\n";
    echo "</SCRIPT>\n\n";
}

global $name;

if (defined('MODULE_FILE') AND file_exists("modules/".$name."/copyright.php")) {
    echo "<script  LANGUAGE=\"JavaScript\" type=\"text/javascript\">\n";
    echo "<!--\n";
    echo "function openwindow(){\n";
    echo "	window.open (\"modules/".$name."/copyright.php\",\"Copyright\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=400,height=200\");\n";
    echo "}\n";
    echo "//-->\n";
    echo "</SCRIPT>\n\n";
}
/*****************************************************/
/* PopUp Center (copyright)                   START  */
/*****************************************************/
echo "<SCRIPT LANGUAGE=\"JavaScript\" type=\"text/javascript\">\n";
echo "function PopupCentrer(page,largeur,hauteur,options) {\n";
echo "var top=(screen.height-hauteur)/2;\n";
echo "var left=(screen.width-largeur)/2;\n";
echo "window.open(page,\"\",\"top=\"+top+\",left=\"+left+\",width=\"+largeur+\",height=\"+hauteur+\",\"+options);\n";
echo "}\n";
echo "</SCRIPT>\n";
/*****************************************************/
/* PopUp Center (copyright)                     END  */
/*****************************************************/
?>