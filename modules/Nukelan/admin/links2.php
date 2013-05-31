 <?php
// filename: links.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}


//if (($radminsuper==1) OR ($radminlan_parties==1) OR ($radminlan_staff==1) OR ($radminlan_checkin==1) OR ($radminlan_access==1)) {
    adminmenu("".$admin_file.".php?op=admin_home", "NukeLan Admin", "lan.gif");
//}


?>
