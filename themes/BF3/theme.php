<?php
/*******************************************************************/
/* This theme is copyrighted to www.clanthemes.com and cannot be   */
/* redistributed or shared under any circumstances, if you suspect */
/* this theme is being shared please contact us                    */
/*******************************************************************/

if (stristr($_SERVER['SCRIPT_NAME'], "theme.php")) {
    die ("Access Denied");
}
/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Theme Colors Definition                                    	   */
/*******************************************************************/
$bgcolor1 = '#330303';
$bgcolor2 = '#330303';
$bgcolor3 = '#330303';
$bgcolor4 = '#330303';
$textcolor1 = '#CCCCCC';
$textcolor2 = '#CCCCCC';
/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Include Theme Settings                                   	   */
/*******************************************************************/
include("themes/BF3/navigation_menu.php");
include("themes/BF3/functions.php");
/*******************************************************************/
/* The theme and its contents were made by www.clanthemes.com      */
/* Theme Header	      	                                    	   */
/*******************************************************************/
function themeheader() {
	global $cookie, $username, $module_name, $banners, $admin, $user, $name, $sitename, $index, $admin_file, $nukeurl, $slogan;
	
	
	
	if (($name=='Forums') OR ($name=='Private_Messages') OR ($name=='Your_Account')  OR ($name=='Members_List')) {
		
	echo"<body class='main_two'>";	 
	
	} else {
	echo"<body class='main'>";		
	}
	echo "\n".'<!--[if IE 6]><link rel="stylesheet" type="text/css" href="themes/BF3/style/ie6.css" media="screen" /><![endif]-->'."\n";
	echo "".'<!--[if IE 7]><link rel="stylesheet" type="text/css" href="themes/BF3/style/ie.css" media="screen" /><![endif]-->'."\n";
	echo "<script type=\"text/javascript\" src=\"themes/BF3/style/swfobject.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"themes/BF3/style/jquery.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"themes/BF3/style/clan-themes.js\"></script>\n";
	
	echo'<div class="top-bg">';
		echo'<div class="top-bg-box">
			
					<div style="width:1000px;">
					<div class="avatar">'; avatar(); echo'</div>
    				<div class="search">'; themesearch(); echo'</div>					
    				<div class="pm">'; privatemessage(); echo'</div>
					</div>';		
				
			echo'</div>
		</div>';
	
	echo '<div class="container_12">';
	
	echo '<!-- Header Image -->';
	echo '<div class="grid_12">';
	
	echo '<!-- Logo -->';
	echo '<h1 id="logo">
					<a href="index.php">'.$sitename.'</a>
		  </h1>';
	echo '</div>';
	
	
	navmenu();
		
	if (!defined('ADMIN_FILE')){ //remove all the scrolling and following functions from admin area
		
	topbanner();
	
	topbox();
	
	loginbar();
			
	} else {
		echo '<p class="blocktitletext">Thanks For Purchasing This Theme, For <u>Theme Support</u> Please Visit <a target="_blank" href="http://www.clanthemes.com/forum-28-purchased-theme-support.html">www.clanthemes.com</a></p>';
	}
		
	echo '<!-- Content start - Column wrapper -->
	<div>';
	// Column 1 (left)
	if (($module_name != 'Forums') AND ($module_name !='Your_Account') AND ($module_name !='vwar') AND ($module_name !='vWar_Account') AND ($module_name !='Journal') AND ($module_name !='Topics') AND ($module_name !='Private_Messages') AND ($module_name !='Members_List')):
	echo '<div class="grid_3">'; //specifies the left width of blocks
	
	
	if (!defined('ADMIN_FILE')){
	blocks('l');
	}
	echo '</div>';
	endif;
	//coloum 2 (center)
	if (empty($index)) { $index = null; }
	if (defined('INDEX_FILE') || ($index == 1)) {
		// right blocks are showing
		echo '<div class="grid_6">';	//specifies the center width of blocks		
	}
	elseif ((!defined('ADMIN_FILE')) AND (($module_name != 'Forums') AND ($module_name !='Your_Account') AND ($module_name !='vWar_Account') AND ($module_name !='vwar') AND ($module_name !='Journal') AND ($module_name !='Topics') AND ($module_name !='Private_Messages') AND ($module_name !='Members_List')))
	{
	// right blocks are NOT showing
		echo '<div class="grid_9">';
	} else { 
		echo '<div class="grid_12">';	
	}
}


function themefooter() {
	global $foot1, $foot2, $foot3, $footer_message, $index;
	echo '</div><!-- end center -->';
	if (defined('INDEX_FILE') && INDEX_FILE===true || ($index === 1)) {
		echo '<!-- Column 3 (Right) -->
		<div class="grid_3">'; //specifies the right width of blocks
		blocks('r');
		echo '</div>';
	}
	
	echo '</div>
	<!-- end columns  -->';
	
	footercopyright();
	
	echo'<div class="clear"></div>
	
	
		</div><!-- end header container -->';
	
}

function themecenterbox($title, $content) {
	echo "\n".'<!-- table start --><div class="box">'."\n";
	echo " <h2>".$title."</h2>
	<div class='block'>".$content."</div> ";
	echo "\n".'</div><!-- table end -->'."\n";
}
function OpenTable() {
	echo "\n".'<!-- table start -->
		<div class="box">
			<h2>&nbsp;</h2>
			<div class="block">';
}

function CloseTable() {
	echo "</div> ";
	echo "".'</div>
	<!-- table end -->'."\n";
}

function OpenTable2() {
	echo "\n".'<div>'."\n";
}

function CloseTable2() {
	echo "\n".'</div>'."\n";
}

function themesidebox($title, $content) {
	echo "\n".'<!-- table start -->
		<div class="box">
			<h2>'."".$title."</h2>
			<div class='block'>".$content."</div> ";
	echo "".'</div>
	<!-- table end -->'."\n";
}

function FormatStory($thetext, $notes, $aid, $informant) {
    global $anonymous;

    if (!empty($notes)) {
        $notes = "<br /><br /><b>"._NOTE."</b> <i>$notes</i>\n";
    } else {
        $notes = "";
    }
    if ("$aid" == "$informant") {
        echo "$thetext$notes\n";
    } else {
        if(!empty($informant)) {
        	if(is_array($informant)) {
            	$boxstuff = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$informant[0]\">$informant[1]</a> ";
            } else {
            	$boxstuff = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$informant\">$informant</a> ";
            }
        } else {
            $boxstuff = "$anonymous ";
        }
        $boxstuff .= ""._WRITES." <i>\"$thetext\"</i>$notes\n";
        echo "<div class=\"content\">$boxstuff</div>\n";
    }
}

function themeindex ($aid, $informant, $time, $title, $counter, $topic, $thetext, $notes, $morelink, $topicname, $topicimage, $topictext) {

    global $prefix, $anonymous, $tipath, $admin_file, $sid, $db, $admin;

	$ThemeSel = get_theme();
    if (file_exists("themes/$ThemeSel/images/topics/$topicimage")) {

	$t_image = "themes/$ThemeSel/images/topics/$topicimage";

    } else {

	$t_image = "$tipath$topicimage";

    }
	
	$newtime=explode('@',$time);
	
	$newtitle=addslashes($title);
	
	$result = $db->sql_query("SELECT * FROM ".$prefix."_stories WHERE title='$newtitle'");

	$row = $db->sql_fetchrow($result);

	$score=$row['score'];

	$sid=$row['sid'];
	
	$posted .= get_author($aid);
	
	
	echo' <div class="box articles">
					<h2>
						&nbsp;
					</h2>
					<div class="block">
						<div class="first article">
							<h3>
								<a href="index.php?op=NEArticle&amp;sid='.$sid.'">'.$title.'</a>
							</h3>
							
							<p class="meta">Topic: '.$topictext.'</p>
							<a href="modules.php?name=News&amp;new_topic='.$topic.'" title="'.$topictext.'" class="image">							
								<img src="'.$t_image.'" width="60" height="60" alt="'.$topictext.'" />
							</a>';
									 FormatStory($thetext, $notes, $aid, $informant);
							echo' <p>Posted By <span class="postedby">'.$posted.'</span>, Read '.($counter).' Times, <a href="index.php?op=NEArticle&amp;sid='.$sid.'">Read Full Article</a></p>';
							echo' '.$morelink.' ';
						echo'</div>
					</div>
				</div>';
	}

function themearticle ($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {  
	
	global $admin, $sid, $tipath, $index;
	
	$ThemeSel = get_theme();
    if (file_exists("themes/$ThemeSel/images/topics/$topicimage")) {

	$t_image = "themes/$ThemeSel/images/topics/$topicimage";

    } else {

	$t_image = "$tipath$topicimage";

    }
	
		$thetext = '<div>'.$thetext.'</div>';
	$posted = _POSTEDON.' '.$datetime.' ';
	
	if (!empty($notes)) {
		$notes = '<br /><b>'._NOTE.'</b> <div>'.$notes.'</div>';
	} else {
		$notes = '';
	}
	if ($aid == $informant) {
		$content = $thetext.$notes;
	} else {
		if(!empty($informant)) {
			global $admin, $user;
			if (is_user($user)||is_admin($admin)) $content = '<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username='.$informant.'"><i>'.$informant.'</i></a> ';
			else $content = $informant.' ';//Raven 10/16/2005
		} else {
			$content = $anonymous.' ';
		}
		$content .= '<i>'._WRITES.'</i> <div>'.$thetext.'</div>'.$notes;
	}
	
	echo' <div class="box articles">
					<h2>
						&nbsp;
					</h2>
					<div class="block">
						<div class="first article">
							<h3>
								<a href="modules.php?name=News&amp;file=article&amp;sid='.$sid.'">'.$title.'</a>
							</h3>
							
							<p class="meta">Topic: '.$topictext.'</p>
							<a href="modules.php?name=News&amp;new_topic='.$topic.'" title="'.$topictext.'" class="image">							
								<img src="'.$t_image.'" width="60" height="60" alt="'.$topictext.'" />
							</a>';
									 FormatStory($thetext, $notes, $aid, $informant);
							echo' <p><br />Posted By <span class="postedby"><a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username='.$informant.'">'.$informant.'</a></span></p>
						</div>
					</div>
				</div>';
}
?>