<?php

if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}
// Your vwar installation folder in the modules folder:
$vwar_folder = "vwar";
$content = ""
            ."<strong><big>&middot;</big></strong><a href=\"modules.php?name=$vwar_folder&file=war\">Virtual War</a><br />"
            ."<strong><big>&middot;</big></strong><a href=\"modules.php?name=$vwar_folder&file=war&action=nextaction\">Next Actions</a><br />"
            ."<strong><big>&middot;</big></strong><a href=\"modules.php?name=$vwar_folder&file=member\">Members</a><br />"
            ."<strong><big>&middot;</big></strong><a href=\"modules.php?name=$vwar_folder&file=calendar\">Calendar</a><br />"
            ."<strong><big>&middot;</big></strong><a href=\"modules.php?name=$vwar_folder&file=stats\">War Stats</a><br />"
            ."<strong><big>&middot;</big></strong><a href=\"modules.php?name=$vwar_folder&file=joinus\">Join us</a><br />"
            ."<strong><big>&middot;</big></strong><a href=\"modules.php?name=$vwar_folder&file=challenge\">Fight us</a><br />"
            ."<strong><big>&middot;</big></strong><a href=\"modules/$vwar_folder/admin/\">Your Profile</a><br />"
            ."<strong><big>&middot;</big></strong><a href=\"modules.php?name=$vwar_folder\">News</a><br />";


?>
