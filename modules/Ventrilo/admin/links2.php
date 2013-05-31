<?php

/* Maps Management Module                */
/* Version: 2.75                         */
/* Author: gotcha(ztgotcha@hotmail.com)  */
if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
//if (!eregi("admin.php", $_SERVER['PHP_SELF'])) { die ("Access Denied"); }
adminmenu("admin.php?op=ventrilo", "".Ventrilo."", "ventrillo.gif");

?>