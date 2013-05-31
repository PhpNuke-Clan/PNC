<?php

//------------------------------------------------------------------------------------------------------------+

  defined("MODULE_FILE") or die("DIRECT ACCESS NOT ALLOWED");

  require_once "mainfile.php";

  require "header.php";

  opentable();

//------------------------------------------------------------------------------------------------------------+

  $output = "";

  if (is_numeric($_GET['s']))
  {
    require "modules/LGSL/lgsl_files/lgsl_details.php";
  }
  else
  {
    require "modules/LGSL/lgsl_files/lgsl_list.php";
  }

  echo $output;

  $output = "";

//------------------------------------------------------------------------------------------------------------+

  closetable();

  require "footer.php";

//------------------------------------------------------------------------------------------------------------+

?>
