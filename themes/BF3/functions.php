<?php
/*******************************************************************/
/* This theme is copyrighted to www.clanthemes.com and cannot be   */
/* redistributed or shared under any circumstances, if you suspect */
/* this theme is being shared please contact us                    */
/*******************************************************************/
if (stristr($_SERVER['SCRIPT_NAME'], "functions.php")) {
    die ("Access Denied");
}

/*******************************************************************/
// Some Theme Settings, if you mess this file up or your theme wont 
// load after editing this file, please revert back to the original 
// one and try again.
/*******************************************************************/


//Settings Start


/*******************************************************************/
// Top Advertisment/Banner Image
	$topbanner = "1"; // 1 = Show 0 = Hide
/*******************************************************************/

// Top Boxes Settings
	$topbox = "1"; // 1 = Show 0 = Hide 

	$titleone =   "Latest Images"; //Title For The First Box
	$titletwo =   "Latest Forums"; //Title For The Second Box
	
/*******************************************************************/
// Top Login Bar
	$loginbar = "1"; // 1 = Show 0 = Hide 
/*******************************************************************/
// Footer Copyrights
	$footercopyright = "1"; // 1 = Show 0 = Hide 
/*******************************************************************/

//DO NOT EDIT BELOW UNLESS YOU KNOW WHAT YOU ARE DOING
/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Avatar				                                		   */
/*******************************************************************/
function privatemessage() {
	global $sitename, $cookie, $username, $userinfo, $user, $prefix, $db;
	
	$username = $cookie[1];
    if (count($cookie)>1) $username = $cookie[1];
	if ($username == "") {
        $username = "Guest";
    }
	
	//Call The Private Messages
    $sql = "SELECT user_id FROM $user_prefix"._users." WHERE username='$uname'";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$uid = $row[user_id];
	$newpms = $db->sql_numrows($db->sql_query("SELECT privmsgs_to_userid FROM $prefix"._bbprivmsgs." WHERE privmsgs_to_userid='$uid' AND (privmsgs_type='5' OR privmsgs_type='1')"));
	$oldpms = $db->sql_numrows($db->sql_query("SELECT privmsgs_to_userid FROM $prefix"._bbprivmsgs." WHERE privmsgs_to_userid='$uid' AND privmsgs_type='0'"));
	$result = $db->sql_query( "select user_id from $prefix"._users." where username='$username'");
	list( $user_id ) = $db->sql_fetchrow( $result);
	$result2 = $db->sql_query( "select privmsgs_type from $prefix"._bbprivmsgs." where privmsgs_to_userid='$user_id' AND (privmsgs_type='1' or privmsgs_type='5')");
	$MesUnread = $db->sql_numrows( $result2 );
	$result3 = $db->sql_query( "select privmsgs_type from $prefix"._bbprivmsgs." where privmsgs_to_userid='$user_id' AND (privmsgs_type='0')");
	$MesRead = $db->sql_numrows( $result3 );
	//End Call Private Messages
	if ($username == 'Guest') {
	echo'Welcome to '.$sitename.'<br /> Please sign in <a href="modules.php?name=Your_Account">Here</a>';	
	} else {
	echo'Welcome back <a href="modules.php?name=Your_Account">'.$username.'</a><br />You have (<a href="modules.php?name=Private_Messages">'.$MesUnread.'</a>) Private Messages';
	}
}
/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Avatar				                                		   */
/*******************************************************************/
function avatar() {
	global $avatar, $userinfo, $prefix, $db, $admin;
					
	//Call the Avatar
	$bbconf = array();
	$result = $db->sql_query("SELECT * FROM ".$prefix."_bbconfig");
	while(list($config_name,$config_value) = $db->sql_fetchrow($result)){
	$bbconf[$config_name] = $config_value;
	}
	
	if ($userinfo['user_avatar_type'] == 1)  {
	echo"<img class='avatar-img' src=\"".$bbconf['avatar_path']."/".$userinfo['user_avatar']."\" width=\"30\" height=\"30\" alt= \"\" />";
	} elseif ($userinfo['user_avatar_type'] == 2) {
	echo"<img class='avatar-img' src=\"".$userinfo['user_avatar']."\" width=\"30\" height=\"30\">";
	} elseif ($userinfo['user_avatar'] == "") {
	echo"<img class='avatar-img' src=\"themes/BF3/forums/images/blank.gif\" width=\"30\" height=\"30\" alt= \"\" />";
	} else {
	echo"<img class='avatar-img' src=\"".$bbconf['avatar_gallery_path']."/".$userinfo['user_avatar']."\"  width=\"30\" height=\"30\" alt= \"\" />";
		}
	
	//End call Avatar
}
/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Search Bar	                                		   */
/*******************************************************************/

function themesearch() {

	echo'<form method="post" action="modules.php?name=Search" id="header-search">
    				<span class="field field-search">
						<span class="input-text input-text-search">
							<span>';
						echo"<input type=\"text\" value=\"Search The Site...\" onFocus=\"if(this.value=='Search The Site...')this.value='';\" name=\"query\" id=\"input-header-search\" class=\"default-text\" />";
			  		   echo'</span>
						</span>
							<span class="btn btn-4">
								<span>
									<input type="submit" value="Search" id="search" />
								</span>
							</span>
					</span>
				</form>';
}
/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Top Advertisment		                                		   */
/*******************************************************************/

function topbanner() {
	global $name, $topbanner, $banners, $db, $prefix;
	
	if ($topbanner==1) {				
	echo '<!-- Advertisment -->';
	echo '<div>';
	if ($banners== 1) {				
			echo '<div class="button">'; include("banners.php"); echo'</div>';
		}
	echo '</div>';
	if ($banners== 0) {
// removed by Palle	echo'<div id="spotlight"><p class="spotlight">To Place a Advertisment here please go to your <a href="./admin.php?op=BannersAdmin">Advertisment Admin Area</a> <br />and add a banner as position 0-Page Top</p></div>';
		} else {
	echo'<br />';
		}
	}
}


/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Top 3 Login Bar			                                	   */
/*******************************************************************/
function loginbar(){
	global $name, $loginbar, $user, $db, $prefix;
		if ($loginbar==1) {
			
	echo '<!-- Login Bar -->';
	if (!is_user($user) AND $name != "Your_Account") {
	echo '<div class="grid_12" id="sitebar"><a href="modules.php?name=Your_Account&amp;op=new_user"><img src="themes/BF3/images/warn.gif" alt="warning" />&nbsp;&nbsp;Welcome to '.$sitename.', You are not logged in. If you have not registered yet, please click here. Alternativly log into your account now.</a>
		</div>';
			}	
		} else {
			echo'';
	}
}
/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Top 3 Boxes Settings		                                	   */
/*******************************************************************/
function topbox() {
	global $name, $topbox, $titleone, $titletwo, $titlethree, $textone, $texttwo, $textthree, $db, $prefix;
		
	if ($topbox==1) {
		if (($name=='Forums') OR ($name=='Private_Messages') OR ($name=='Your_Account')  OR ($name=='Members_List')) {
			
	echo'';		
		} else {
	echo '<!-- Top 3 Boxes -->';
	echo '<div class="grid_9">
				<div class="box">
					<h2>'.$titleone.'</h2>
					<div class="block">					
						<div id="container"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this rotator.</div>	
							<script type="text/javascript">
									var s1 = new SWFObject("themes/BF3/imagerotator/imagerotator.swf","rotator","680","294","7");
									s1.addVariable("shownavigation","false");
									s1.addVariable("shuffle","true");
									s1.addVariable("transition","fade");
									s1.addVariable("file","themes/BF3/imagerotator/images.xml");
									s1.addVariable("width","680");
									s1.addVariable("height","294");
									s1.addParam("wmode","opaque");
									s1.write("container");
							</script>	
						</div>
					</div>
			</div>
			
			<div class="grid_3">
				<div class="box">
					<h2>'.$titletwo.'</h2>
					<div class="block">';					
						forumsscroll();										
					echo'</div>
				</div>
			</div>
			
			
			<div class="clear"></div>';	
		
		}
	}
}
/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Scrolling Forums 		                                	   */
/*******************************************************************/
function forumsscroll() {
	global $prefix, $user_prefix, $db, $user, $cookie, $group_id;
	
define("_BBFORUM_TOTTOPICS","Topics ");
define("_BBFORUM_TOTPOSTS","Posts ");
define("_BBFORUM_TOTVIEWS","Views ");
define("_BBFORUM_TOTREPLIES","Replies ");
define("_BBFORUM_TOTMEMBERS","Members");
define("_BBFORUM_FORUM","Forums");
define("_BBFORUM_SEARCH","Search");

$theme = get_theme();
$post_image = "themes/$theme/forums/images/icon_latest_reply.gif";


echo  '<script type="text/javascript">

/***********************************************
* Cross browser Marquee II- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

var delayb4scroll=2000 //Specify initial delay before marquee starts to scroll on page (2000=2 seconds)
var marqueespeed=1 //Specify marquee scroll speed (larger is faster 1-10)
var pauseit=1 //Pause marquee onMousever (0=no. 1=yes)?

////NO NEED TO EDIT BELOW THIS LINE////////////

var copyspeed=marqueespeed
var pausespeed=(pauseit==0)? copyspeed: 0
var actualheight=\'\'

function scrollmarquee(){
if (parseInt(cross_marquee.style.top)>(actualheight*(-1)+8))
cross_marquee.style.top=parseInt(cross_marquee.style.top)-copyspeed+"px"
else
cross_marquee.style.top=parseInt(marqueeheight)+8+"px"
}

function initializemarquee(){
cross_marquee=document.getElementById("vmarquee")
cross_marquee.style.top=0
marqueeheight=document.getElementById("marqueecontainer").offsetHeight
actualheight=cross_marquee.offsetHeight
if (navigator.userAgent.indexOf("Netscape/7")!=-1){ //if Netscape 7x, add scrollbars to scroll and exit
cross_marquee.style.height=marqueeheight+"px"
cross_marquee.style.overflow="scroll"
return
}
setTimeout(\'lefttime=setInterval("scrollmarquee()",30)\', delayb4scroll)
}

if (window.addEventListener)
window.addEventListener("load", initializemarquee, false)
else if (window.attachEvent)
window.attachEvent("onload", initializemarquee)
else if (document.getElementById)
window.onload=initializemarquee
</script>';

echo  '
<div id="marqueecontainer" style="position: relative; width:100%; height: 240px; overflow: hidden; padding: 2px;" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
<div id="vmarquee" style="position: absolute; width: 100%;">
';

$sql = "SELECT t.topic_id, t.topic_last_post_id, t.topic_title, f.forum_name, f.forum_id, u.username, u.user_id, p.poster_id, p.post_time FROM ".$prefix."_bbtopics t, ".$prefix."_bbforums f, ".$prefix."_bbposts p, ".$user_prefix."_users u WHERE p.post_id = t.topic_last_post_id AND u.user_id = p.poster_id AND t.forum_id=f.forum_id AND f.auth_view=0 ORDER BY t.topic_last_post_id DESC LIMIT 10";

$result1 = $db->sql_query($sql);
while(list($topic_id, $topic_last_post_id, $topic_title, $forum_name, $forum_id, $username, $user_id, $poster_id, $post_time) = $db->sql_fetchrow($result1)) {
  echo '
  <div style="border-bottom: 1px dotted #333; padding-bottom: 8px; padding-top: 8px;">
  	<img src="'.$post_image.'" alt="" border="0" />
  		<a href="modules.php?name=Forums&amp;file=viewtopic&amp;p='.$topic_last_post_id.'#'.$topic_last_post_id.'" title="'.$topic_title.'"><strong>'.$topic_title.'</strong></a><br />
  			<span class="tiny"><em>Last post by 
  		<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username='.$username.'" title="'.$username.'">'.$username.'</a> 
  in <a href="modules.php?name=Forums&amp;file=viewforum&amp;f='.$forum_id.'" title="'.$forum_name.'">'.$forum_name.'</a> on '.date("m/d/Y h:i a", $post_time).'</em>
  			</span>
  </div>'; 
}

echo '</div>
</div>
<div style="width:100%;height:50px;">
<div style="padding-top: 8px;" >
  <div style="float:left;">
    <a href="modules.php?name=Forums">Forum Index</a><br />
    <a href="modules.php?name=Forums&amp;file=search">Forum Search</a><br />
  </div>
  <div style="float:right; text-align: right;" >
    <span id="fast" style="cursor: pointer;" onClick="copyspeed=copyspeed+1; mqs=marqueespeed; marqueespeed=copyspeed"><img class="button" src="themes/BF3/images/up.png" alt="" title="Faster" /></span><br />
    <span id="slow" style="cursor: pointer;" onClick="copyspeed=copyspeed-1; mqs=marqueespeed; marqueespeed=copyspeed"><img class="button" src="themes/BF3/images/down.png" alt="" title="Slower" /></span>
  </div>
</div>
</div>';
}
/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Footer Copyrights		                                	   */
/*******************************************************************/

function footercopyright() {
	global $footercopyright, $footer_message, $foot1, $foot2, $foot3;
		if ($footercopyright==1) {
	echo'<div class="grid_12" id="site_info">';
				$footer_message = "$foot1$foot2$foot3";
			echo'<div class="footerbox">'.$footer_message.'</div>';
	echo'</div>';
	} else {
			echo'';
	}
}
?>