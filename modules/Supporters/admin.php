<?php

/********************************************************/
/* NSN Supporters(TM) Universal                         */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2003 by NukeScripts Network              */
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

if(!isset($op)) { $op = "Supporters"; }
if($op == "pending") { $op = "Supporterspending"; }
if($op == "active") { $op = "Supportersactive"; }
if($op == "inactive") { $op = "Supportersinactive"; }
global $admin_file;
Header("Location: ".$admin_file.".php?op=$op");

?>