<?php
/*************************************************************************/
/* ForumNews Advance v3.0                                      COPYRIGHT */
/*                                                                       */
/* Copyright (c) 2002 - 2006 by http://www.code-area51.com               */
/*     Mighty_Y - Yannick Reekmans           (webmaster@code-area51.com) */
/*                                                                       */
/* See Code-Area51.com for detailed information on the ForumNews Advance */
/*                                                                       */
/*************************************************************************/
function trimText2( $hometext )
  {
 $pos = strpos( $hometext, htmlspecialchars( '<!--break-->' ) );
if( ($pos !== false) && ($pos < strlen( $hometext )) ) {
      $trimmed = true;
      $hometext = substr( $hometext, 0, $pos );
      $hometext .= '...';
      return $hometext;
    }
  }

function trimText( $hometext, $size, $trimmed )
  {
    $pos = strpos( $hometext, htmlspecialchars( '<!--break-->' ) );
    if( ($pos !== false) && ($pos < strlen( $hometext )) ) {
      $trimmed = true;
      $hometext = substr( $hometext, 0, $pos );
      $hometext .= '...';
      return $hometext;
    }
    $segments = preg_split(
          '#(\[([a-zA-Z]+?).*?\].+?\[/\\2.*?\])#s' ,
          $hometext, -1,
          PREG_SPLIT_NO_EMPTY | PREG_SPLIT_OFFSET_CAPTURE );

    foreach( $segments as $segment )
    {
      if( ($segment[1] + strlen($segment[0]) > $size) &&
        ($segment[1] <= $size) )
      {
        $trimmed = true;
        $hometext = substr( $hometext, 0, $size );
        if (strlen($segment[0]) > strlen($segment[1])){
        $hometext .= '...';
        $shortened = "1";
        }else{
        $shortened = "0";
        }
        return $hometext;
      }
      elseif( $segment[1] > $size )
      {
        $trimmed = true;
        $hometext = substr( $hometext, 0, $segment[1] );
        if (strlen($segment[0]) > strlen($segment[1])){
        $hometext .= '...';
        $shortened = "1";
        }else{
        $shortened = "0";
        }
        return $hometext;
      }
    }
    $shortened = "0";
    return $hometext;

  }

function parseMessage( $hometext, $bbcode_uid )
  {
    $hometext  = parse_bbcode( $hometext, $bbcode_uid );
    $delim = htmlspecialchars( '<!--break-->' );
    $pos = strpos( $hometext, $delim );
    if( ($pos !== false) && ($pos < strlen( $hometext )) ) {
      $hometext = substr_replace( $hometext, html_entity_decode($delim), $pos, strlen($delim) );
    }
    return $hometext;
  }

function parse_bbcode($hometext, $bbcode_uid){

global $currentlang;

//include("./modules/ForumNews/language/lang-".$currentlang.".php");
		$bbcode_tpl = array();
		$bbcode_tpl['b'] = "<span style=\"font-weight: bold;\">";
		$bbcode_tpl['b_close'] = "</span>";
		$bbcode_tpl['strike'] = "<span><strike>";
		$bbcode_tpl['strike_close'] = "</strike></span>";
		$bbcode_tpl['acronym'] = "<acronym title=\"$1\">";
		$bbcode_tpl['acronym_close'] = "</acronym>";
		$bbcode_tpl['i'] = "<span style=\"font-style: italic;\">";
		$bbcode_tpl['i_close'] = "</span>";
		$bbcode_tpl['u'] = "<span style=\"text-decoration: underline;\">";
		$bbcode_tpl['u_close'] = "</span>";
		$bbcode_tpl['size_open'] = "<span style=\"font-size: $1px; line-height: normal\">";
		$bbcode_tpl['size_close'] = "</span>";
		$bbcode_tpl['color_open'] = "<span style=\"color: $1;\">";
		$bbcode_tpl['color_close'] = "</span>";
		$bbcode_tpl['img'] = "<img src=\"$1\" border=\"0\" />";
		$bbcode_tpl['url1'] = "<a href=\"$1$2\" target=\"_blank\" class=\"postlink\">$1$2</a>";
		$bbcode_tpl['url2'] = "<a href=\"http://$1\" target=\"_blank\" class=\"postlink\">$1</a>";
		$bbcode_tpl['url3'] = "<a href=\"$1$2\" target=\"_blank\" class=\"postlink\">$6</a>";
		$bbcode_tpl['url4'] = "<a href=\"http://$1\" target=\"_blank\" class=\"postlink\">$5</a>";
		$bbcode_tpl['email'] = "<a href=\"mailto:$1\" class=\"postlink\">$1</a>";
		$bbcode_tpl['code_open'] = "</span><table width=\"85%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\"><tr><td><span class=\"genmed\"><b>"._FNA_LANGCODE.":</b></span></td></tr><tr><td class=\"code\">";
		$bbcode_tpl['code_close'] = "</td></tr></table><span class=\"postbody\">";
		$bbcode_tpl['align_open'] = "<div style=\"text-align:$1\">";
		$bbcode_tpl['align_close'] = "</div>";
		$bbcode_tpl['quote_open'] = "</span><table width=\"85%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\"><tr><td><span class=\"genmed\"><b>"._FNA_LANGQUOTE.":</b></span></td></tr><tr><td class=\"quote\">";
		$bbcode_tpl['quote_close'] = "</td></tr></table><span class=\"postbody\">";
		$bbcode_tpl['quote_username_open'] = "</span><table width=\"85%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\"><tr><td><span class=\"genmed\"><b>$1 "._FNA_LANGWROTE.":</b></span></td></tr><tr><td class=\"quote\">";
        $bbcode_tpl['ulist_open'] = "<ul>";
		$bbcode_tpl['ulist_close'] = "</ul>";
		$bbcode_tpl['olist_open'] = "<ol type=\"$1\">";
		$bbcode_tpl['olist_close'] = "</ol>";
		$bbcode_tpl['list_item'] = "<li>";
		$bbcode_tpl['hr'] = "<hr noshade color='#000000' size='1'>";
		$bbcode_tpl['font_open'] = "<span style=\"font-family:$1\">";
		$bbcode_tpl['font_close'] = "</span>";
		$bbcode_tpl['marq_open'] = "<marquee direction=\"$1\" scrolldelay=\"120\">";
		$bbcode_tpl['marq_close'] = "</marquee>";
		$bbcode_tpl['fade_open'] = "<span style=\"height: 1; Filter: Alpha(Opacity=100, FinishOpacity=0, Style=1, StartX=0, FinishX=100%)\">";
		$bbcode_tpl['fade_close'] = "</span>";
		$bbcode_tpl['edit_open'] = "<table width=\"85%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\" align=\"center\"><tr><td><span class=\"genmed\"><b>Update:</b></span></td></tr><tr><td class=\"code\">";
		$bbcode_tpl['edit_close'] = "	</tr></table><span class=\"postbody\">";
		$bbcode_tpl['flash'] = "<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0\" WIDTH=\"$1\" HEIGHT=\"$2\"><PARAM NAME=movie VALUE=\"$3\"><PARAM NAME=quality VALUE=high> <PARAM NAME=scale VALUE=noborder> <PARAM NAME=wmode VALUE=transparent> <PARAM NAME=bgcolor VALUE=#000000><EMBED src=\"$3\" quality=high scale=noborder wmode=transparent bgcolor=#000000 WIDTH=\"$1\" HEIGHT=\"$2\" TYPE=\"application/x-shockwave-flash\" PLUGINSPAGE=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\"></EMBED></OBJECT>";
		$bbcode_tpl['video'] = "<OBJECT id=\"mediaPlayer\" width=\"$1\" height=\"$2\" classid=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\" codebase=\"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701\" standby=\"Loading Microsoft Windows Media Player components...\" type=\"application/x-oleobject\"> <param name=\"fileName\" value=\"$3\"><param name=\"animationatStart\" value=\"true\"><param name=\"transparentatStart\" value=\"false\"><param name=\"autoStart\" value=\"false\"><param name=\"showControls\" value=\"true\"><param name=\"loop\" value=\"false\"><EMBED type=\"application/x-mplayer2\" pluginspage=\"http://microsoft.com/windows/mediaplayer/en/download/\" id=\"mediaPlayer\" name=\"mediaPlayer\" displaysize=\"4\" autosize=\"-1\" bgcolor=\"darkblue\" showcontrols=\"true\" showtracker=\"-1\" showdisplay=\"0\" showstatusbar=\"-1\" videoborder3d=\"-1\" width=\"$1\" height=\"$2\" src=\"$3\" autostart=\"0\" designtimesp=\"5311\" loop=\"0\"></EMBED></OBJECT>";
		$bbcode_tpl['spoil_open'] = "<div align=\"center\"><div class=\"spoiltitle\"><b>".$lang['BBCode_box_hidden']."</b>&nbsp;<input class=\"spoilbtn\" type=\"button\" value='".$lang['BBcode_box_view']."' onClick=\"javascript:if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerText = ''; this.value = '".$lang['BBcode_box_hide']."'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = '".$lang['BBcode_box_view']."'; }\" onfocus=\"this.blur();\"></div><div class=\"spoildiv\"><div style=\"display: none;\">";
		$bbcode_tpl['spoil_close'] = "</div></div></div><span class=\"postbody\">";
		$bbcode_tpl['youtube'] = "<object width=\"425\" height=\"350\"><param name=\"movie\" value=\"http://www.youtube.com/v/$1\"></param><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" width=\"425\" height=\"350\"></embed></object><br /><a href=\"http://youtube.com/watch?v=$1\" target=\"_blank\">Link</a><br />";
		$bbcode_tpl['GVideo'] = "<object width=\"425\" height=\"350\"><param name=\"movie\" value=\"http://video.google.com/googleplayer.swf?docId=$1\"></param><embed style=\"width:400px; height:326px;\" id=\"VideoPlayback\" align=\"middle\" type=\"application/x-shockwave-flash\" src=\"http://video.google.com/googleplayer.swf?docId=$1\" allowScriptAccess=\"sameDomain\" quality=\"best\" bgcolor=\"#ffffff\" scale=\"noScale\" salign=\"TL\"  FlashVars=\"playerMode=embedded\"></embed></object><br /><a href=\"http://video.google.com/googleplayer.swf?docId=$1\" target=\"_blank\">Link</a><br />";
		$bbcode_tpl['stream'] = "<object id=\"wmp\" width=300 height=70 classid=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\" codebase=\"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,0,0,0\" standby=\"Loading Microsoft Windows Media Player components...\" type=\"application/x-oleobject\"><param name=\"FileName\" value=\"$1\"><param name=\"ShowControls\" value=\"1\"><param name=\"ShowDisplay\" value=\"0\"><param name=\"ShowStatusBar\" value=\"1\"><param name=\"AutoSize\" value=\"1\"><param name=\"autoplay\" value=\"0\"><embed type=\"application/x-mplayer2\" pluginspage=\"http://www.microsoft.com/windows95/downloads/contents/wurecommended/s_wufeatured/mediaplayer/default.asp\" src=\"$1\" name=MediaPlayer2 showcontrols=1 showdisplay=0 showstatusbar=1 autosize=1 autostart=\"0\" visible=1 animationatstart=0 transparentatstart=1 loop=0 height=70 width=300></embed></object>";
		$bbcode_tpl['expand_caption_open'] = "<div><div class=\"expandtitle\"><input class=\"expandbtn\" type=\"image\" src=\"images/expand.gif\" onClick=\"javascript:if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.src = 'images/collapse.gif'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.src = 'images/expand.gif'; }\" onfocus=\"this.blur();\">&nbsp;<b>$1</b>&nbsp;</div><div class=\"expanddiv\"><div style=\"display: none;\">";
		$bbcode_tpl['expand_open'] = "<div><div class=\"expandtitle\"><input class=\"expandbtn\" type=\"image\" src=\"images/expand.gif\" onClick=\"javascript:if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.src = 'images/collapse.gif'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.src = 'images/expand.gif'; }\" onfocus=\"this.blur();\"></div><div class=\"expanddiv\"><div style=\"display: none;\">";
		$bbcode_tpl['expand_close'] = "</div></div></div>";

		$patterns = array();
		$replacements = array();
		$patterns[] = "#\[img:$bbcode_uid\](.*?)\[/img:$bbcode_uid\]#si";
		$replacements[] = $bbcode_tpl['img'];
		$patterns[] = "#\[url\]([a-z0-9]+?://){1}([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)\[/url\]#is";
		$replacements[] = $bbcode_tpl['url1'];
		$patterns[] = "#\[url\]((www|ftp)\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*?)?)\[/url\]#si";
		$replacements[] = $bbcode_tpl['url2'];
		$patterns[] = "#\[url=([a-z0-9]+://)([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*?)?)\](.*?)\[/url\]#si";
		$replacements[] = $bbcode_tpl['url3'];
		$patterns[] = "#\[url=(([\w\-]+\.)*?[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)\](.*?)\[/url\]#si";
		$replacements[] = $bbcode_tpl['url4'];
		$patterns[] = "#\[email\]([a-z0-9\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]#si";
		$replacements[] = $bbcode_tpl['email'];
		$patterns[] = "#\[flash width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9]):$bbcode_uid\](.*?)\[/flash:$bbcode_uid\]#si";
		$replacements[] = $bbcode_tpl['flash'];
		$patterns[] = "#\[video width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-9]?[0-9]):$bbcode_uid\](.*?)\[/video:$bbcode_uid\]#si";
		$patterns[] = "#\[expand=(.*?):$bbcode_uid\](.*?)\[/ex:$bbcode_uid\]#si";
		$replacements[] = $bbcode_tpl['video'];
		$replacements[] = $bbcode_tpl['expand_caption'];
	    $patterns[] = "#\[youtube\]http://(?:www\.)?youtube.com/watch\?v=([0-9A-Za-z-_]{11})[^[]*\[/youtube\]#is";
		$replacements[] = $bbcode_tpl['youtube'];
		$patterns[] = "#\[GVideo\]http://video.google.[A-Za-z0-9.]{2,5}/videoplay\?docid=([0-9A-Za-z-_]*)[^[]*\[/GVideo\]#is";
		$replacements[] = $bbcode_tpl['GVideo'];
		$patterns[] = "#\[stream:$bbcode_uid\](.*?)\[/stream:$bbcode_uid\]#si";
		$replacements[] = $bbcode_tpl['stream'];
		//$patterns[] = "#\[web:$bbcode_uid\](.*?)\[/web:$bbcode_uid\]#si";
		//$replacements[] = $bbcode_tpl['web'];


		$hometext = preg_replace($patterns, $replacements, $hometext);

		$code_start_html = $bbcode_tpl['code_open'];
		$code_end_html =  $bbcode_tpl['code_close'];

		$match_count = preg_match_all("#\[code:1:$bbcode_uid\](.*?)\[/code:1:$bbcode_uid\]#si", $hometext, $matches);
		for ($i = 0; $i < $match_count; $i++)
		{
			$before_replace = $matches[1][$i];
			$after_replace = $matches[1][$i];
			$after_replace = str_replace("  ", "&nbsp; ", $after_replace);
			$after_replace = str_replace("  ", " &nbsp;", $after_replace);
			$after_replace = str_replace("\t", "&nbsp; &nbsp;", $after_replace);
			$str_to_match = "[code:1:$bbcode_uid]" . $before_replace . "[/code:1:$bbcode_uid]";
			$replacement = $code_start_html;
			$replacement .= $after_replace;
			$replacement .= $code_end_html;
			$hometext = str_replace($str_to_match, $replacement, $hometext);
		}

		$hometext = str_replace("[code:$bbcode_uid]", $code_start_html, $hometext);
		$hometext = str_replace("[/code:$bbcode_uid]", $code_end_html, $hometext);
	    $hometext = preg_replace("/\[acronym:$bbcode_uid=\"(.*?)\"\]/si", $bbcode_tpl['acronym'], $hometext);
	    $hometext = str_replace("[/acronym:$bbcode_uid]", $bbcode_tpl['acronym_close'], $hometext);
		$hometext = str_replace("[quote:$bbcode_uid]", $bbcode_tpl['quote_open'], $hometext);
		$hometext = str_replace("[/quote:$bbcode_uid]", $bbcode_tpl['quote_close'], $hometext);
		$hometext = preg_replace("/\[quote:$bbcode_uid=\"(.*?)\"\]/si", $bbcode_tpl['quote_username_open'], $hometext);
		$hometext = str_replace("[list:$bbcode_uid]", $bbcode_tpl['ulist_open'], $hometext);
        $hometext = preg_replace("/\[align=(left|right|center|justify):$bbcode_uid\]/si", $bbcode_tpl['align_open'], $hometext);
        $hometext = str_replace("[/align:$bbcode_uid]", $bbcode_tpl['align_close'], $hometext);
        $hometext = str_replace("[hr:$bbcode_uid]", $bbcode_tpl['hr'], $hometext);
        $hometext = preg_replace("/\[marq=(left|right|up|down):$bbcode_uid\]/si", $bbcode_tpl['marq_open'], $hometext);
        $hometext = str_replace("[/marq:$bbcode_uid]", $bbcode_tpl['marq_close'], $hometext);
		$hometext = str_replace("[*:$bbcode_uid]", $bbcode_tpl['listitem'], $hometext);
		$hometext = str_replace("[/list:u:$bbcode_uid]", $bbcode_tpl['ulist_close'], $hometext);
		$hometext = str_replace("[/list:o:$bbcode_uid]", $bbcode_tpl['olist_close'], $hometext);
		$hometext = preg_replace("/\[list=([a1]):$bbcode_uid\]/si", $bbcode_tpl['olist_open'], $hometext);
        $hometext = preg_replace("/\[font=(.*?):$bbcode_uid\]/si", $bbcode_tpl['font_open'], $hometext);
        $hometext = str_replace("[/font:$bbcode_uid]", $bbcode_tpl['font_close'], $hometext);
		$hometext = str_replace("[b:$bbcode_uid]", $bbcode_tpl['b'], $hometext);
		$hometext = str_replace("[/b:$bbcode_uid]", $bbcode_tpl['b_close'], $hometext);
        $hometext = str_replace("[strike:$bbcode_uid]", $bbcode_tpl['strike'], $hometext);
        $hometext = str_replace("[/strike:$bbcode_uid]", $bbcode_tpl['strike_close'], $hometext);
   		$hometext = str_replace("[u:$bbcode_uid]", $bbcode_tpl['u'], $hometext);
		$hometext = str_replace("[i:$bbcode_uid]", $bbcode_tpl['i'], $hometext);
		$hometext = str_replace("[/u:$bbcode_uid]", $bbcode_tpl['u_close'], $hometext);
		$hometext = str_replace("[/i:$bbcode_uid]", $bbcode_tpl['i_close'], $hometext);
		$hometext = preg_replace("/\[size=([1-2]?[0-9]):$bbcode_uid\]/si", $bbcode_tpl['size_open'], $hometext);
		$hometext = str_replace("[/size:$bbcode_uid]", $bbcode_tpl['size_close'], $hometext);
		$hometext = preg_replace("/\[color=(\#[0-9A-F]{6}|[a-z]+):$bbcode_uid\]/si", $bbcode_tpl['color_open'], $hometext);
		$hometext = str_replace("[/color:$bbcode_uid]", $bbcode_tpl['color_close'], $hometext);
        $hometext = str_replace("[edit:$bbcode_uid]", $bbcode_tpl['edit_open'], $hometext);
        $hometext = str_replace("[/edit:$bbcode_uid]", $bbcode_tpl['edit_close'], $hometext);
        $hometext = str_replace("[s:$bbcode_uid]", '<strike>', $hometext);
		$hometext = str_replace("[/s:$bbcode_uid]", '</strike>', $hometext);
		$hometext = str_replace("[sub:$bbcode_uid]", '<sub>', $hometext);
		$hometext = str_replace("[/sub:$bbcode_uid]", '</sub>', $hometext);
		$hometext = str_replace("[sup:$bbcode_uid]", '<sup>', $hometext);
		$hometext = str_replace("[/sup:$bbcode_uid]", '</sup>', $hometext);
		$hometext = str_replace("[spoil:$bbcode_uid]", $bbcode_tpl['spoil_open'], $hometext);
		$hometext = str_replace("[/spoil:$bbcode_uid]", $bbcode_tpl['spoil_close'], $hometext);
		$hometext = preg_replace("/\[expand:$bbcode_uid=\"(.*?)\"\]/si", $bbcode_tpl['expand_caption_open'], $hometext);
		$hometext = str_replace("[expand:$bbcode_uid]", $bbcode_tpl['expand_open'], $hometext);
		$hometext = str_replace("[/expand:$bbcode_uid]", $bbcode_tpl['expand_close'], $hometext);
		$hometext = str_replace("[fade:$bbcode_uid]", $bbcode_tpl['fade_open'], $hometext);
		$hometext = str_replace("[/fade:$bbcode_uid]", $bbcode_tpl['fade_close'], $hometext);
        $hometext = smilies_pass( $hometext );
        $hometext = make_clickable($hometext);
        $hometext = str_replace("\n", '<br>', $hometext);
		return $hometext;
}

function smilies_pass($message)
{
	static $orig, $repl;
	if (!isset($orig))
	{
		global $db, $prefix;
		$orig = $repl = array();
		$sql = "SELECT * FROM ".$prefix."_bbsmilies";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't obtain smilies data", "", __LINE__, __FILE__, $sql);
		}
		$smilies = $db->sql_fetchrowset($result);

		if (count($smilies))
		{
			usort($smilies, 'smiley_sort');
		}

		for ($i = 0; $i < count($smilies); $i++)
		{
			$orig[] = "/(?<=.\W|\W.|^\W)" . pregquote($smilies[$i]['code'], "/") . "(?=.\W|\W.|\W$)/";
			$repl[] = '<img src="modules/Forums/images/smiles/' . $smilies[$i]['smile_url'] . '" alt="' . $smilies[$i]['emoticon'] . '" border="0" />';
		}
	}

	if (count($orig))
	{
		$message = preg_replace($orig, $repl, ' ' . $message . ' ');
		$message = substr($message, 1, -1);
	}

	return $message;
}

function smiley_sort($a, $b)
{
	if ( strlen($a['code']) == strlen($b['code']) )
	{
		return 0;
	}

	return ( strlen($a['code']) > strlen($b['code']) ) ? -1 : 1;
}

function pregquote( $str, $delimiter )
{
   $txt = preg_quote( $str );
   $txt = str_replace($delimiter, '\\' . $delimiter, $txt );
   $hometext = $txt;
   return $hometext;
}

function make_clickable($text)
{
	$ret = ' ' . $text;
	$ret = preg_replace("#([\t\r\n ])([a-z0-9]+?){1}://([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)#i", '\1<a href="\2://\3" target="_blank">\2://\3</a>', $ret);
	$ret = preg_replace("#([\t\r\n ])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)#i", '\1<a href="http://\2.\3" target="_blank">\2.\3</a>', $ret);
	$ret = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
	$ret = substr($ret, 1);
	$hometext = $ret;

	return $hometext;
}
?>