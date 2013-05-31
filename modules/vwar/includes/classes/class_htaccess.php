<?php

/* #####################################################################################
 *
 * $Id: class_htaccess.php,v 1.3 2004/02/22 12:26:54 mabu Exp $
 *
 * This notice must remain untouched at all times.
 *
 * Modifications to the script, except the official addons or hacks,
 * without the owners permission are prohibited.
 * All rights reserved to their proper authors.
 *
 * ---------------------------------------------
 * http://www.vwar.de || Copyright (C) 2001-2004
 * ---------------------------------------------
 *
 * #####################################################################################
 */

class htaccess
{
		var $file_name;
		var $file_handle;
		var $load_override = 0;
		var $users = array();

		// constructor
		function htaccess ($file_name)
		{
				$this->file_name = $file_name;
		}

		function openFile ($mode="w+")
		{
				if(empty($this->file_handle))
				{
						$this->file_handle = fopen($this->file_name,$mode);
				}
		}

		function readFile ($length,$offset="",$whence=SEEK_SET)
		{
				if(!empty($offset) && is_numeric($offset)) fseek($this->file_handle,$offset,$whence);
				return fread($this->file_handle,$length);
		}

		function writeFile ($data)
		{
				if(!empty($data)) fwrite($this->file_handle,$data,strlen($data));
		}

		function closeFile ()
		{
				fclose($this->file_handle);
				$this->file_handle = NULL;
		}

		function createAccessFile ($userfile,$area="Secured Area")
		{
				$data = "AuthName \"$area\"\r\nAuthType Basic\r\nAuthUserFile $userfile\r\nrequire valid-user";
				$this->openFile();
		$this->writeFile($data);
		$this->closeFile();
		}

		function loadUser ()
		{
				if($this->load_override == 1) return;

				$content = @file($this->file_name);
				if(!$content) return;
				foreach($content as $data)
				{
						$data = trim($data);
						if(!empty($data))
						{
								$tmp = explode(":",$data);
								if(!empty($tmp[0]) && !empty($tmp[1]))
								{
										$this->users[$tmp[0]] = $tmp[1];
										unset($tmp);
								}
						}
				}
		}

		function addUser ($name,$password)
		{
				if(empty($name) || empty($password)) return;

				if(sizeof($this->users) == 0) $this->loadUser();
				if(!empty($this->users[$name])) return;
				$this->users[$name] = crypt(trim($password));
		}

		function modifyUser ($name,$password)
		{
				if(empty($name) || empty($password)) return;

				if(sizeof($this->users) == 0) $this->loadUser();
				if(empty($this->users[$name]))
				{
						$this->addUser($name,$password);
						return;
				}

				$this->users[$name] = crypt(trim($password));
		}

		function deleteUser ($name)
		{
				if(empty($name)) return;

				if(sizeof($this->users) == 0) $this->loadUser();
				if(!empty($this->users[$name])) unset($this->users[$name]);
		}

		function flushUsers ($excludes="")
		{
				foreach($this->users as $name => $password)
				{
						if(is_array($excludes))
						{
								if(!in_array($name,$excludes)) unset($this->users[$name]);
						}
						else unset($this->users[$name]);
				}
		}

		function commitUserChanges ()
		{
				foreach($this->users as $name => $password)
				{
						$content .= $name.":".$password."\r\n";
				}

				$this->openFile();
				$this->writeFile($content);
				$this->closeFile();
		}
}

?>