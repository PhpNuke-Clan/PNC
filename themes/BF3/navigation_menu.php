<?php
/*******************************************************************/
/* This theme is copyrighted to www.clanthemes.com and cannot be   */
/* redistributed or shared under any circumstances, if you suspect */
/* this theme is being shared please contact us                    */
/*******************************************************************/

if (stristr($_SERVER['SCRIPT_NAME'], "navigation_menu.php")) {
    die ("Access Denied");
}
/*******************************************************************/
// Theme Menu Settings, if you mess this file up or your theme wont 
// load after editing this file, please revert back to the original 
// one and try again.
/*******************************************************************/

function navmenu() {
	global $user, $admin, $db, $prefix;
	
echo'<!-- BEGIN: Menu -->
<div id="mod-menu" class="mod">

	<div class="mod-content">
		<ul>';
		
	//START THE MENU FOR EDITING BELOW
	
	//First Link
echo'<li class="item-1 odd first  ">
			<a href="index.php" title="Home">
				<span class="label">Home</span>
			</a>';
					
	//Second Link				
echo'<li class="item-2 even   has-sub-nav">
        	<a title="Languages">
				<span class="label">Languages</span>
			</a>';
					
	//Second Link Sub Menu Links			
	echo'<div class="sub-nav">
            <ul>
			    <li class="item-1 odd first  ">
					<a href="index.php?newlang=english" title="United Kingdom">
						<span class="label"><img src="themes/BF3/images/gb.png" width="16" height="11" /> United Kingdom</span>
					</a>
		    	<li class="item-2 even   ">
        			<a href="index.php?newlang=french" title="France">
						<span class="label"><img src="themes/BF3/images/fr.png" width="16" height="11" /> France</span>
					</a>
		    	<li class="item-3 odd   ">
					<a href="index.php?newlang=german" title="Germany">
						<span class="label"><img src="themes/BF3/images/de.png" width="16" height="11" /> Germany</span>
					</a>
		    	<li class="item-4 even   ">
        			<a href="index.php?newlang=spanish" title="Spain">
						<span class="label"><img src="themes/BF3/images/es.png" width="16" height="11" /> Spain</span>
					</a>
		    	<li class="item-5 odd  last ">
					<a href="index.php?newlang=hungarian" title="Hungarian">
						<span class="label"><img src="themes/BF3/images/hu.png" width="16" height="11" /> Hungarian</span>
					</a>
		    </ul>
        </div>';
		
		//Third Link
	echo'<li class="item-3 odd   has-sub-nav">
        	<a href="modules.php?name=Forums" title="Forums">
				<span class="label">Forums</span>
			</a>';
					
	//Third Link Sub Menu Links			
	echo'<div class="sub-nav">
            <ul>
			    <li class="item-1 odd first  ">
        			<a href="modules.php?name=Forums&amp;file=search" title="Forums Search">
						<span class="label">Forums Search</span>
					</a>
		    	<li class="item-2 even ">
					<a href="modules.php?name=Members_List" title="Members List">
						<span class="label">Members List</span>
					</a>
				<li class="item-3 odd ">
					<a href="modules.php?name=Forums&amp;file=search&amp;search_id=newposts" title="New Posts">
						<span class="label">New Posts</span>
					</a>
				<li class="item-4 even ">
					<a href="modules.php?name=Forums&amp;file=search&amp;search_id=unanswered" title="Unanswered Posts">
						<span class="label">Unanswered Posts</span>
					</a>
				<li class="item-5 odd  last ">
					<a href="modules.php?name=Forums&amp;file=search&amp;search_id=egosearch" title="View Your Posts">
						<span class="label">View Your Posts</span>
					</a>
		    </ul>
        </div>';
		
		//Fourth Link
	echo'<li class="item-4 even  has-sub-nav">
        	<a title="Other Pages">
				<span class="label">Other Pages</span>
			</a>';
					
	//Fourth Link Sub Menu Links			
	echo'<div class="sub-nav">
            <ul>
			    <li class="item-1 odd first  ">
        			<a href="modules.php?name=News" title="News">
						<span class="label">News</span>
					</a>
		    	<li class="item-2 even   ">
					<a href="modules.php?name=Topics" title="News Topics">
						<span class="label">News Topics</span>
					</a>
		    	<li class="item-3 odd  ">
        			<a href="modules.php?name=HTML_Newsletter" title="Newsletter">
						<span class="label">Newsletter</span>
					</a>
				<li class="item-4 even  ">
        			<a href="modules.php?name=Recommend_Us" title="Reccomend Us">
						<span class="label">Reccomend Us</span>
					</a>
				<li class="item-5 odd  ">
        			<a href="modules.php?name=Content" title="Content">
						<span class="label">Content</span>
					</a>
				<li class="item-6 even  ">
        			<a href="modules.php?name=Surveys" title="Surveys">
						<span class="label">Surveys</span>
					</a>
				<li class="item-7 odd  last">
        			<a href="modules.php?name=Web_Links" title="Web Links">
						<span class="label">Web Links</span>
					</a>
		    </ul>
        </div>';
		
		//Fifth Link
	echo'<li class="item-5 odd  has-sub-nav ">
        	<a title="Site Info">
				<span class="label">Site Info</span>
			</a>';
					
	//Fifth Link Sub Menu Links			
	echo'<div class="sub-nav">
            <ul>
			    <li class="item-1 odd first  ">
        			<a href="modules.php?name=Feedback" title="Feedback">
						<span class="label">Feedback</span>
					</a>
		    	<li class="item-2 even   ">
					<a href="modules.php?name=Feedback" title="Contact Us">
						<span class="label">Contact Us</span>
					</a>
		    	<li class="item-3 odd  ">
        			<a href="modules.php?name=Legal" title="Legal">
						<span class="label">Legal</span>
					</a>
				<li class="item-4 even  ">
        			<a href="modules.php?name=Statistics" title="Statistics">
						<span class="label">Statistics</span>
					</a>
				<li class="item-5 odd  last">
        			<a href="modules.php?name=Advertising" title="Advertising">
						<span class="label">Advertising</span>
					</a>
		    </ul>
        </div>';
		
		//Sixth Link
	echo'<li class="item-6 even   has-sub-nav">
        	<a href="modules.php?name=Downloads" title="Downloads">
				<span class="label">Downloads</span>
			</a>';
					
	//Sixth Link Sub Menu Links			
	echo'<div class="sub-nav">
            <ul>
			    <li class="item-1 odd first  ">
        			<a href="modules.php?name=Downloads&amp;d_op=NewDownloads" title="New Downloads">
						<span class="label">New Downloads</span>
					</a>
		    	<li class="item-2 even   ">
					<a href="modules.php?name=Downloads&amp;d_op=MostPopular" title="Most Popular">
						<span class="label">Most Popular</span>
					</a>
		    	<li class="item-3 odd  last ">
        			<a href="modules.php?name=Downloads&amp;d_op=TopRated" title="Top Rated">
						<span class="label">Top Rated</span>
					</a>
		    </ul>
        </div>';
		
		//END Menu
		
		//This is where the Account Menu Starts, I would not edit this one below as it has if statements for diffrent user levels including Admin options.
			    
			    echo'<li class="item-7 odd  last has-sub-nav">
        			<a href="modules.php?name=Your_Account" title="Account">
						<span class="label">Account</span>
					</a>
		<div class="sub-nav">
            <ul>';
			if (!is_user($user)) {
		   echo'<li class="item-1 odd first  ">
       		 		<a href="modules.php?name=Your_Account&amp;op=new_user" title="New Account">
						<span class="label">New Account</span>
					</a>
		    	<li class="item-2 even last  ">
					 <a href="modules.php?name=Your_Account&amp;op=pass_lost" title="Lost Password">
						<span class="label">Lost Password</span>
					</a>';
				} else {					   
		   echo'<li class="item-1 odd  first ">
        			<a href="modules.php?name=Your_Account&amp;op=edituser" title="Edit Account">
						<span class="label">Edit Account</span>
					</a>
		    	<li class="item-2 even   ">
					 <a href="modules.php?name=Private_Messages" title="Messages">
						<span class="label">Messages</span>
					</a>
		    	<li class="item-3 odd   ">
        			<a href="modules.php?name=Your_Account&amp;op=chgtheme" title="Change Theme">
						<span class="label">Change Theme</span>
					</a>
		    	<li class="item-4 even  last">
					<a href="modules.php?name=Your_Account&amp;op=logout" title="Log Out">
						<span class="label">Log Out</span>
					</a>';
				if (is_admin($admin)){
					
			echo'<hr /><li class="item-1 odd  first ">
        			<a href="admin.php" title="Admin">
						<span class="adminlabel">Admin Area</span>
					</a>
		    	<li class="item-2 even   ">
					 <a href="admin.php?op=BlocksAdmin" title="Blocks Admin">
						<span class="adminlabel">Blocks Admin</span>
					</a>
		    	<li class="item-3 odd   ">
        			<a href="admin.php?op=modules" title="Modules Admin">
						<span class="adminlabel">Modules Admin</span>
					</a>
		    	<li class="item-4 even  ">
					<a href="admin.php?op=Configure" title="Site Prefrences">
						<span class="adminlabel">Site Prefrences</span>
					</a>
				<li class="item-5 odd   ">
        			<a href="admin.php?op=forums" title="Forums Admin">
						<span class="adminlabel">Forums Admin</span>
					</a>
				<li class="item-6 even   ">
        			<a href="admin.php?op=yaAdmin" title="Edit Users">
						<span class="adminlabel">Edit Users</span>
					</a>
				<li class="item-7 odd  last ">
        			<a href="admin.php?op=logout" title="Logout Admin">
						<span class="adminlabel">Logout Admin</span>
					</a>';
					
				// End Account Menu
				} 
			}
		 echo'</ul>
        </div>
	</ul>
</div>

</div>
<!-- END: Menu -->';

}


?>