<?php

//------------------------------------------------------------------------------------------------------------+

  if (!defined("ADMIN_FILE")) { die ("YOU DO NOT HAVE PERMISSION TO CONFIGURE LGSL"); }

//------------------------------------------------------------------------------------------------------------+

  require "header.php";

  graphicadmin();

  opentable();

//------------------------------------------------------------------------------------------------------------+

  define("LGSL_ADMIN", "1");

  $output = "";

  require "modules/LGSL/lgsl_files/lgsl_admin.php";

  echo $output;

  $output = "";

//------------------------------------------------------------------------------------------------------------+

  closetable();

  require "footer.php";

//------------------------------------------------------------------------------------------------------------+

?>