<?php

/********************************************************/
/* NSN Center Blocks                                    */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Original by: Richard Benfield                        */
/* http://www.benfield.ws                               */
/********************************************************/

$pagetitle = "NSN Center Blocks: Error Loading Functions";
include("header.php");
title($pagetitle);
OpenTable();
 echo "It appears that NSN Center Blocks has not been configured correctly.  The
most common cause is that you either have an error in the syntax that is
including includes/nsncb_func.php from your mainfile.php, or you have not
added the NSN Center Blocks code to your mainfile.php.  This code must be placed
immediately before the closing ?&gt; tag in mainfile.php.  So your first 7
lines in mainfile.php <b>must look like this</b>:<br /><br />
<pre>if (defined('FORUM_ADMIN')) {
&nbsp;&nbsp;include(\"../../../includes/nsncb_func.php\");
} elseif (defined('INSIDE_MOD')) {
&nbsp;&nbsp;include(\"../../includes/nsncb_func.php\");
} else {
&nbsp;&nbsp;include(\"includes/nsncb_func.php\");
}
?&gt;</pre>";
CloseTable();
include("footer.php");

?>