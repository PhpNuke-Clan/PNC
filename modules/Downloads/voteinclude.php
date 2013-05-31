<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* Enhanced Downloads Module - Version 1.6                              */
/* Copyright (c) 2002 by Shawn Archer                                   */
/* http://www.NukeStyles.com                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/**********************************************************************************************/
/* PNC 3.0.0: PHOENIX Edition                                 COPYRIGHT                       */
/*                                                                                            */
/* Copyright (c) 2005 - 2006 by http://phpnuke-clan.com                                       */
/*  PHPNUKE-CLAN - SUPPORT                (support@phpnuke-clan.com)                          */
/*  PNC 3.0.0  Online Installation Guide - http://www.phpnuke-clan.com/guide/3.0.0/index.htm  */
/**********************************************************************************************/
/*                                                                      */
/* Based on Journey Links Hack                                          */
/* Copyright (c) 2000 by James Knickelbein                              */
/* Journey Milwaukee (http://www.journeymilwaukee.com)                  */
/*                                                                      */
/************************************************************************/
/* PHP-Nuke Platinum: Expect to be impressed                  COPYRIGHT */
/*                                                                      */
/* Copyright (c) 2004 - 2006 by http://www.techgfx.com                  */
/*     Techgfx - Graeme Allan                       (goose@techgfx.com) */
/*                                                                      */
/* Copyright (c) 2004 - 2006 by http://www.conrads-berlin.de            */
/*     MrFluffy - Axel Conrads                 (axel@conrads-berlin.de) */
/*                                                                      */
/* Refer to TechGFX.com for detailed information on PHP-Nuke Platinum   */
/*                                                                      */
/* TechGFX: Your dreams, our imagination                                */
/************************************************************************/

if ( !defined('MODULE_FILE') ) {
	die("Illegal Module File Access");
}

$module_name = basename(dirname(__FILE__));
@require_once("modules/$module_name/ns_downloads_file.php");  
@require_once("mainfile.php");


global $prefix, $db, $ns_dl_anon_weight, $ns_dl_outside_weight;
    $result_ii = $db->sql_query("SELECT ns_dl_outside_vote, ns_dl_anon_wait_days, ns_dl_outside_wait_days, ns_dl_anon_weight, ns_dl_outside_weight, ns_dl_main_dec, ns_dl_detail_dec from ".$prefix."_ns_downloads");
    list($ns_dl_outside_vote, $ns_dl_anon_wait_days, $ns_dl_outside_wait_days, $ns_dl_anon_weight, $ns_dl_outside_weight, $ns_dl_main_dec, $ns_dl_detail_dec) = $db->sql_fetchrow($result_ii);

$outsidevotes = 0;
$anonvotes = 0;
$outsidevoteval = 0;
$anonvoteval = 0;
$regvoteval = 0;
$truecomments = $totalvotesDB;
while(list($ratingDB, $ratinguserDB, $ratingcommentsDB)=sql_fetch_row($voteresult, $dbi)) {
    if ($ratingcommentsDB=="") $truecomments--;
    if ($ratinguserDB==$anonymous) {
	$anonvotes++;
	$anonvoteval += $ratingDB;
    }
    if ($ns_dl_outside_vote == 1) {
    	if ($ratinguserDB=='outside') {
	    $outsidevotes++;
	    $outsidevoteval += $ratingDB;
	}
    } else {
	$outsidevotes = 0;
    }
    if ($ratinguserDB!=$anonymous && $ratinguserDB!="outside") {
	$regvoteval += $ratingDB;
    }
}
$regvotes = $totalvotesDB - $anonvotes - $outsidevotes;
if ($totalvotesDB == 0) {
    $finalrating = 0;
} else if ($anonvotes == 0 && $regvotes == 0) {
    /* Figure Outside Only Vote */
    $finalrating = $outsidevoteval / $outsidevotes;
    $finalrating = number_format($finalrating, 4);
} else if ($outsidevotes == 0 && $regvotes == 0) {
    /* Figure Anon Only Vote */
    $finalrating = $anonvoteval / $anonvotes;
    $finalrating = number_format($finalrating, 4);
} else if ($outsidevotes == 0 && $anonvotes == 0) {
    /* Figure Reg Only Vote */
    $finalrating = $regvoteval / $regvotes;
    $finalrating = number_format($finalrating, 4);
} else if ($regvotes == 0 && $ns_dl_outside_vote == 1 && $outsidevotes != 0 && $anonvotes != 0 ) {
    /* Figure Reg and Anon Mix */
    $avgAU = $anonvoteval / $anonvotes;
    $avgOU = $outsidevoteval / $outsidevotes;
    if ($ns_dl_anon_weight > $ns_dl_outside_weight) {
	/* Anon is 'standard weight' */
	$newimpact = $ns_dl_anon_weight / $ns_dl_outside_weight;
	$impactAU = $anonvotes;
	$impactOU = $outsidevotes / $newimpact;
	$finalrating = ((($avgOU * $impactOU) + ($avgAU * $impactAU)) / ($impactAU + $impactOU));
	$finalrating = number_format($finalrating, 4); 
    } else {
	/* Outside is 'standard weight' */
	$newimpact = $ns_dl_outside_weight / $ns_dl_anon_weight;
	$impactOU = $outsidevotes;
	$impactAU = $anonvotes / $newimpact;
	$finalrating = ((($avgOU * $impactOU) + ($avgAU * $impactAU)) / ($impactAU + $impactOU));
	$finalrating = number_format($finalrating, 4); 
    }       		         	
} else {
    /* Registered User vs. Anonymous vs. Outside User Weight Calutions */
    $impact = $ns_dl_anon_weight;
    $outsideimpact = $ns_dl_outside_weight;
    if ($regvotes == 0) {
	$regvotes = 0;
    } else { 
	$avgRU = $regvoteval / $regvotes;
    }
    if ($anonvotes == 0) {
	$avgAU = 0;
    } else {
	$avgAU = $anonvoteval / $anonvotes;
    }
    if ($outsidevotes == 0 ) {
	$avgOU = 0;
    } else {
	$avgOU = $outsidevoteval / $outsidevotes;
    }
    $impactRU = $regvotes;
    $impactAU = $anonvotes / $impact;
    $impactOU = $outsidevotes / $outsideimpact;
    $finalrating = (($avgRU * $impactRU) + ($avgAU * $impactAU) + ($avgOU * $impactOU)) / ($impactRU + $impactAU + $impactOU);
    $finalrating = number_format($finalrating, 4); 
}

?>
