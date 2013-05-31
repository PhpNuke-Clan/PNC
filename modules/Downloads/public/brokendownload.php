<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
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

$lid = intval($lid);
include("header.php");
menu(1);
echo "<br>\n";
OpenTable();
echo "<center><font class='option'><b>"._REPORTBROKEN."</b></font><br><br><br><font class='content'>\n";
echo "<form action='modules.php?name=$module_name' method='post'>\n";
echo "<input type='hidden' name='lid' value='$lid'>\n";
echo ""._THANKSBROKEN."<br>"._SECURITYBROKEN."<br><br>\n";
echo "<input type='hidden' name='op' value='brokendownloadS'><input type='submit' value='"._REPORTBROKEN."'></center></form>\n";
CloseTable();
include("footer.php");

?>