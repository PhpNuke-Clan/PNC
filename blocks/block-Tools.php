<?php



if (eregi("block-Tools.php",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}
$content  =  "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=Module\">"._MODULEC."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=Block\">"._BLOCKC."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=HTMLPHP\">"._HTMLC."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=HTMLASP\">"._HTMLASP."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=HTMLJSP\">"._HTMLJSP."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=HTMLPERL\">"._HTMLPERL."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=HTMLJS\">"._HTMLJS."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=HTMLSWS\">"._HTMLSWS."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=Source\">"._EDITORC."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=MTags\">"._METAC."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=Pop\">"._POPUP."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=Scroll\">"._SCROLLC."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=Color\">"._HEXC."</a><BR>";

$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=PREVIEWER\">"._PREVIEWER."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=SourceCoder\">"._SCODER."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=HTMLENCODER\">"._HTMLCODER."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=URLENCODER\">"._URLCODER."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=EMAIL\">"._EMAILCODER."</a><BR>";
$content  .= "<strong><big>· </big></strong><a href=\"modules.php?name=PHP-Nuke_Tools&file=index&amp;func=ROT\">"._ROTCODER."</a><BR>";

?>