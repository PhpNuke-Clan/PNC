<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* Website Document Mod V1.0                                            */
/* Copyright (c) 2002 by Shawn Archer                                   */
/* http://www.NukeStyles.com                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/**********************************************************************************************/
/* PNC 3.0.0: PHOENIX Edition                                 COPYRIGHT                       */
/*                                                                                            */
/* Copyright (c) 2005 - 2006 by http://phpnuke-clan.com                                       */
/*  PHPNUKE-CLAN - SUPPORT                (support@phpnuke-clan.com)                          */
/*  PNC 3.0.0  Online Installation Guide - http://www.phpnuke-clan.com/guide/3.0.0/index.htm  */
/**********************************************************************************************/
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

// Choose your settings below. If you don't to use a particular page,
// then set the number 1 to a number 0 for 'off'.


########################################

// Show the About Us page link?

$aboutus = 1;

########################################

// Show the Disclaimer Statement link?

$disclaimer = 1;

########################################

// Show the Privacy Statement link?

$privacy = 1;

########################################

// Show the Terms of Service link?

$terms = 1;

########################################

// Use the Contact Module or Feedback Module for questions pertaining 
// to your Docs... or None?   0 = None   1 = Contact   2 = Feedback

$questions = 1;

########################################





################################################################
#                                                              #
#   DO NOT TOUCH CODE BELOW, UNLESS YOU KNOW WHAT YOUR DOING   #
#                                                              #
################################################################


function ns_doc_questions() {
global $questions, $module_name, $sitename;	
    if ((is_active("Feedback")) && $questions == 2) {
echo ""._NSFEEDBACK."";
    } else if ((is_active("Contact")) && $questions == 1) {
echo ""._NSCONTACT."";
    } else if ($questions == 0) {
echo "<br><br>";
    }
}


function ns_doc_links() {
global $aboutus, $disclaimer, $privacy, $terms, $module_name;
echo "<center>";
if ($aboutus == 1) {
echo "[ <a href=\"modules.php?name=$module_name&amp;file=about\">"._NSABOUTUS."</a> ]";
}
if ($aboutus == 1 && $disclaimer == 1) {
echo " - ";
}
if ($disclaimer == 1) {
echo "[ <a href=\"modules.php?name=$module_name&amp;file=disclaimer\">"._NSDISCLAIMER."</a> ]";
}
if ($disclaimer == 1 && $privacy == 1) {
echo " - ";
}
if ($privacy == 1) {
echo "[ <a href=\"modules.php?name=$module_name&amp;file=privacy\">"._NSPRIVACY."</a> ]";
}
if (($privacy == 1 || $aboutus == 1 || $disclaimer ==1) AND ($terms == 1)) {
echo " - ";
}
if ($terms == 1) {
echo "[ <a href=\"modules.php?name=$module_name&amp;file=terms\">"._NSTERMS."</a> ]";
}
echo "</center>";
echo "<br><br>";
}

?>