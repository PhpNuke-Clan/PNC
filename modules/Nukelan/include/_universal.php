<?php

if ( !defined('NUKELAN_FILE') )
{
        die ("NukeLan include security ");
}

include "modules/Nukelan/_config.php";
include "modules/Nukelan/include/_functions.php";
include "modules/Nukelan/include/cl_form.php";
include "modules/Nukelan/include/cl_display.php";

include_once "modules/Nukelan/include/lang/get_lang.php";
//include "include/lang/".$master["currentlanguage"]."/global.php";
include "modules/Nukelan/include/tournaments/tournament_types.php";

class universal extends form {
        var $_name, $_singular;
        var $_table_name, $_id, $_order;
        var $_permissions = array();            // which options to display to user.
        var $_notes = array();                  // notes to display to user
        var $_extra = array();                  // extra sql statements to run
        var $_security;                         // level 3: super admin only, level 2: admins+, level 1: users+, level 0: guests+
        var $_crutch;                           // if the crutch is true, some elements become unmodifiable. (must be the name of a column in the table)
        //var $_print;
        var $_related_links;
        var $_delmod_query;

        function universal($name, $singular, $security) {
                $this->_name = $name;
                $this->_singular = $singular;
                $this->_security = $security;

                $this->_table_name = "";
                $this->_id = "";
                $this->_order = "";

                $this->_permissions["add"] = 0;
                $this->_permissions["del"] = 0;
                $this->_permissions["mod"] = 0;
                $this->_permissions["update"] = 0;

                // initialize optional variables.
                $this->_notes["add"] = "";
                $this->_notes["del"] = "";
                $this->_notes["mod"] = "";
                $this->_notes["update"] = "";
                $this->_print = array();
                $this->_related_links = array();
                $this->_crutch = "";
                $this->_delmod_query = "";
        }
}

 ?>
