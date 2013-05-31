<?php

/********************************************************/
/* Hall of Shame                                     	*/
/* By: Troy Moore (Duck@mrc.clanservers.com)			*/
/* http://mrc.clanservers.com                           */
/* Copyright © 2006-2011 by JesStep Enterprises         */
/********************************************************/
/* Hall of Shame                                        */
/* For PHP-Nuke 6.5+                                    */
/* By Troy Moore - http://mrc.clanservers.com        	*/
/********************************************************/


if ( !defined('ADMIN_FILE') ) {
	die("Illegal Admin File Access");
}


$pagetitle = " "._HoS_HALLOFSHAME.": ".$hos_config['version_number'].": "._HoS_HELP;
@include("header.php");
adminheader(_HoS_HALLOFSHAME.": "._HoS_HELP);
$displayblock = "<br><br><h1>Table Of Contents<a name='TOC'></a></h1><br>
<p><a href='#ConfigMembers'>How do I configure the Members Config?</a></p>
<p><a href='#DefaultConfigs'>What are the Default Settings in configuration?</a></p>
<p><a href='#Uploadss'>Can I upload more than 1 Screenshot per punk?</a></p>
<p><a href='#uploaddemo'>Can I upload more than 1 Demo per punk?</a></p>
<p><a href='#GameorServer'>Can I add a Game or Server that the punk is banned
  from?</a></p>
<p><a href='#RightSideBlocks'>I turned right side blocks on in the config but
  I still can't see them?</a></p>
<p><a href='#Ver2'>Will you be making a version 2 of The Hall of Shame? If so
  what features do you intend to add?</a></p>
<p><a href='#Contact'>How may I contact the Author?</a></p>
<p><a href='#thks'>Thanks</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<h1><strong>How do I configure the Members Config?</strong><a name='ConfigMembers'></a></h1>
<p>I have coded this so if you have a table you already use for clan members you
  can use that table to populate your Banned By lists.</p>
<p>When you add a punk to the hall of shame you can drop down a list for Banned
  By</p>
<p>That list is populated by a query similar to this.</p>
<p><br>
  Select * From membertable Where memberstatus >= 8</p>
<p><br>
  So if you wish to use an existing table (like vwar) you can fill out the info
  in the Member config so it looks at that table instead of my members table.
  If you choose your own table instead of my table the Add member links etc are
  removed from the Admin header. I myself use vwar table so my configs are like
  this:</p>
<table width='60%' border='0' align='center'>
  <tr>
    <td><p></p>
      <p>Member Table = vwar_member</p>
      <p>Member ID Field = memberid</p>
      <p>Name Field Title = name</p>
      <p>Status Field Title = status</p>
      <p>Status Divider = 8 </p>
      <p>Status Operator = &gt;=</p>
</td>
  </tr>
</table>
<p></p>
<p></p>
<p><br>
  The status divider I set to 8 because the numbers below 8 are for members with
  status like Inactive or retired etc. My members with officer ranks have a status
  of 8 or more. Hope this helps you understand that part of the config. It'll
  help you from having to populate your bannedby list yourself</p>
<p><strong>* NOTE: If you use my built in table for members make sure you leave
  the statusdivider at 0</strong>.</p>
<p><a href='#TOC'>Return to Top</a><br><br>
</p>
<p>&nbsp;</p>
<h1><strong>What are the Default Settings in configuration?</strong><a name='DefaultConfigs'></a></h1>
<p>&nbsp;</p>
<h2>General Configurations</h2>
<p><br>
  Date Format: Y-m-d H:i:s<br>
  <br>
  Punks Per Page: 20<br>
  <br>
  Reason Per Row: 5<br>
  <br>
  Maximum in Search: 30<br>
  <br>
  Sort Order Admin: date_add<br>
  <br>
  Admin Results ASC or DESC: DESC<br>
  <br>
  Sort Order Public: date_add<br>
  <br>
  Public Results ASC or DESC: DESC<br>
</p>
<h2></h2>
<h2>Screenshot Configurations</h2>
<p><br>
  Screenshot Path: modules/Hall_of_Shame/punkss/<br>
  <br>
  Maximum Screenshot File Size: 100000<br>
  <br>
  Allowable SS File Extensions: .jpg, .gif<br>
  <br>
  Maximum Screenshot Height: 400<br>
  <br>
  Maximum Screenshot Width: 400<br>
</p>
<h2></h2>
<h2>Demo Configurations</h2>
<p><br>
  Demo Path: modules/Hall_of_Shame/punkdemo/<br>
  <br>
  Maximum Demo File Size: 2000000<br>
  <br>
  Alowable Demo File Extensions: .wmv<br>
  <br>
  Demo Height: 400<br>
  <br>
  Demo Width: 400<br>
</p>
<h2></h2>
<h2>Member Configurations</h2>
<p><br>
  Banned By Table Name: The prefix of your db tables and _hos_members eg: If you
  use PNC it would be pnc_hos_members Or Nuke would be nuke_hos_members<br>
  <br>
  Banned By Name Field Title: membername<br>
  <br>
  The Banned By ID Field Title: : memberid<br>
  <br>
  The Banned By Status Field Title: : memberstatus<br>
  <br>
  The Banned By Status Divider: : 0<br>
  <br>
  The Banned By Status Operator: : &gt;=<br>
</p>
<p><a href='#TOC'>Return to Top</a></p><br><br>
<h1>Can I upload more than 1 Screenshot per punk?<a name='Uploadss'></a></h1>
<p>Technically Yes. You can't do it thru upload ss but you can use the demo for
  a ss or make a slide show of screenshots in movie maker and upload it in the
  demo. </p>
<p><a href='#TOC'>Return to Top</a></p><br><br>
<h1>Can I upload more than 1 Demo per punk?<a name='uploaddemo'></a></h1>
<p>No.</p>
<p><a href='#TOC'>Return to Top</a></p><br><br>
<h1>Can I add a Game or Server that the punk is banned from?<a name='GameorServer'></a></h1>
<p>While there is no category for this you could add this info to the Punk notes
  section and it is retrievable by a search.</p>
<p><a href='#TOC'>Return to Top</a></p><br><br>
<h1>I turned right side blocks on in the config but I still can't see them?<a name='RightSideBlocks'></a></h1>
<p>This is probably to do with your theme. Try a them which you know works with
  right side blocks and see if that helps.</p>
<p><a href='#TOC'>Return to Top</a></p><br><br>
<h1>Will you be making a version 2 of The Hall of Shame? If so what features do
  you intend to add?<a name='Ver2'></a></h1>
<p>At this point I have no definative plans but if I do the following features
  will be at the top of my list.</p>
<ul>
  <li>Clickable Heading sorts on all lists</li>
  <li>Which headings to display configurable by admin</li>
  <li>Ability to Add games and servers</li>
  <li>A SS and Demo random browser</li>
  <li>A suspected hacker public notification form</li>
  <li>Possible a centralized database for clans to share their lists</li>
  <li>Maybe more hehe</li>
</ul>
<p><a href='#TOC'>Return to Top</a></p><br><br>
<h1>How may I contact the Author?<a name='Contact'></a></h1>
<p>Email WhomKnows@hotmail.com Subject Hall of Shame</p>
<p><a href='#TOC'>Return to Top</a></p><br><br>
<h1>Thanks To:<a name='thks'></a></h1>
<p>All the guys that created and help out at phpnuke-clan.net. They Have the best
  Clan CMS out there.</p>
<p><strong>Special thanks to:</strong></p>
<ul>
  <li>MRC-Stickman my friend and original Beta Tester who also suggested the idea
    for the project and kept throwing features he wanted at me lol</li>
  <li>Hunter_ER for the Admin HoS.gif and Beta testing</li>
  <li>icekohl for the nocheat.gif</li>
  <li>Palbin for Beta testing</li>
  <li>TRURAIN for Beta testing</li>
  <li>XenoMorpH for Beta testing</li>
  <li>U_B_Dead for Beta testing</li>
</ul>
<p><a href='#TOC'>Return to Top</a></p>";


echo "<br>\n";
OpenTable();
echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='80%'>\n";
echo "<tr><td align='center'><h1><strong>".$pagetitle."</strong></h1></td></tr>";
echo "<tr><td>".$displayblock."</tr></td>";
echo "</table>";

CloseTable();
@include("footer.php");

?>
