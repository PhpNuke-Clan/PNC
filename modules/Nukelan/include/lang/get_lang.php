<?php
// string getting function <- technical term

function get_lang2($desc) {
	global $lang;
	if(!empty($lang[$desc])) {
		return $lang[$desc];
	} else {
		return "";
	}
}
?>
