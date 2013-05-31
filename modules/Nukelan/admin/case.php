<?php
// filename: case.php
if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
$module_name = "Nukelan";
include_once("modules/$module_name/admin/language/lang-".$currentlang.".php");

switch($op) {
   case 'admin_home':
      include "modules/$module_name/admin/incl/nukelan_menu.php";
	  include "modules/$module_name/admin/index.php";
	  break;
   case 'admin_show_lans':
      include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/index.php";
	  break;
   case 'usr_status_lans':
      include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_view_party.php";
      break;
   case 'add_party_lans':
      include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_add_party.php";
      break;
   case 'add_location_lans':
      include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_add_location.php";
      break;
   case 'add_host_lans':
      include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_add_host.php";
      break;
   case 'add_paypal_lans':
      include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_add_paypal.php";
      break;
   case 'edit_config':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
	  include "modules/$module_name/admin/nl_config.php";
	  break;
   case 'add_seating':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
	  include "modules/$module_name/admin/nl_seating_chart.php";
	  break;
   case 'mass_mail':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
	  include "modules/$module_name/admin/nl_mailer.php";
	  break;
   case 'add_tournament':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
	  include "modules/$module_name/admin/nl_add_tourney.php";
	  break;
	case 'add_prize':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
	  include "modules/$module_name/admin/nl_add_prizes.php";
	  break;
	case 'add_hotel':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
	  include "modules/$module_name/admin/nl_add_hotels.php";
	  break;
	case 'add_team':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
	  include "modules/$module_name/admin/nl_add_teams.php";
	  break;  
   case 'admin_checkin':
      include "modules/$module_name/admin/incl/nukelan_menu.php";
	  include "modules/$module_name/admin/nl_check_in.php";
      break;
   case 'admin_show_jobs':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_show_jobs.php";
      break;
   case 'usr_status_jobs':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_view_jobs.php";
      break;
   case 'add_jobs':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_add_job.php";
      break;
   case 'add_games':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_add_games.php";
      break;
   case 'nl_admin':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_admin.php";
      break;
   case 'add_sponsor':
	  include "modules/$module_name/admin/incl/nukelan_menu.php";
      include "modules/$module_name/admin/nl_add_sponsor.php";
      break;
   }

?>
