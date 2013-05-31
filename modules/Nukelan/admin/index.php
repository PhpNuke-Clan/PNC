<?php
// filename: index.php
if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
global $db, $prefix, $prefix_users, $radminsuper, $op, $ops, $sop, $sops, $aop, $aops, $aid, $admin_file;
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_authors WHERE aid='$aid'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_admins WHERE aid='$aid'"));
$radminlan_parties = $row2['parties'];
$radminlan_checkin = $row2['check_in'];
$radminlan_access = $row2['accessories'];
$radminlan_staff = $row2['staff'];
$radminlan_tourneymod = $row2['tourney_mod'];
$radminlan_editadmins = $row2['edit_admins'];
$radminsuper = $row['radminsuper'];
global $db, $prefix, $admin_file;

include ("header.php");
lan_menu();
OpenTable();
echo " <table border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"100%\">\n"
    ."  <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
    ."   <td width=\"25%\">"._NLEVENT."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLVIEW."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLEDIT."</td>\n"
        ."   <td width=\"9%\">"._NLMASSMAIL."</td>\n"
    ."   <td width=\"35%\">"._NLDATE."</td>\n"
    ."   <td width=\"7%\" align=center>"._NLATTD."</td>\n"
    ."   <td width=\"7%\" align=center>"._NLSTATUS."</td>\n"
    ."  </tr>\n";

$result = $db->sql_query("SELECT * FROM nukelan_parties ORDER BY party_id");
$bc = $bgcolor3;
while($lan = $db->sql_fetchrow($result)) {
   if ($bc == $bgcolor3) $bc = $bgcolor4;
   else $bc = $bgcolor3;
   echo "  <tr bgcolor=\"$bc\">\n"
       ."   <td><a href=\"".$admin_file.".php?op=usr_status_lans&amp;lan_id=$lan[party_id]&amp;lan_name=$lan[keyword]\">$lan[keyword]</a></td>\n"
       ."   <td align=center><a href=\"".$admin_file.".php?op=usr_status_lans&amp;lan_id=$lan[party_id]&amp;lan_name=$lan[keyword]\"><img src=\"modules/Nukelan/images/admin_show.gif\" alt=\"View/Change Signed-Up Users\" border=0></a></td>\n"
       ."   <td align=center><a href=\"".$admin_file.".php?op=add_party_lans&amp;lanop=edit_party&amp;editParty=$lan[party_id]\"><img src=\"modules/Nukelan/images/admin_edit.gif\" alt=\"Edit party details.\" border=0></a></td>\n"
       ."   <td align=center><a href=\"".$admin_file.".php?op=mass_mail&amp;pid=$lan[party_id]\"><img src=\"modules/Forums/templates/subSilver/images/lang_english/icon_email.gif\" alt=\"Send an E-Mail to all registered users.\" border=0></a></td>\n"
           ."   <td>";
   echo date ("l, M j, Y - g:ia",strtotime("$lan[date]"));
   echo "</td>\n"
       ."   <td align=center>";
   echo $db->sql_numrows($db->sql_query("SELECT lan_uid FROM nukelan_signedup WHERE lan_id='$lan[party_id]'"));
   if ($lan[max]) echo "/$lan[max]";
   echo "</td>\n"
       ."   <td align=center>";
   if ($lan[stop]) echo "<font color=red>"._NLSTOPPED."</font>";
   else echo "<font color=green>"._NLNORMAL."</font>";
   echo "</td>\n"
       ."  </tr>";
   }
if (!$db->sql_numrows($result)) echo "  <tr><td colspan=5 align=center>"._NLNOPARTIESRUNNING."</td></tr>\n";
echo " </table>\n";
CloseTable();
include ("footer.php");

?>
