<?php
/* #####################################################################################
 *
 * $Id: class_backup.php,v 1.5 2004/02/28 21:28:13 mabu Exp $
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

class backup
{
	var $file_name;
	var $file_handle;
	var $output_mode;
	var $post_files;
	var $tables = array();
	var $crlf;

	// constructor
	function backup ($options="")
	{
		// init class
		$this->getCRLF();

		if (is_array($options))
		{
			foreach ($options as $name => $value)
			{
				eval("\$this->$name = \$value;");
			}
		}
	}

	// available modes: s = send, f = file
	function writeData ($data)
	{
		if ($this->output_mode == "s")
		{
			print $data;
		}
		else if ($this->output_mode == "f")
		{
			fwrite($this->file_handle,$data,strlen($data));
		}
	}

	function getCRLF ()
	{
		if (eregi("Win",PHP_OS))
		{
			$this->crlf = "\r\n";
		}
		else
		{
			$this->crlf = "\n";
		}
	}

	// available modes: a = all, v = vwar
	function getTables ($table_mode="a")
	{
		global $sql,$n,$vwarmod;

		$result = mysql_list_tables($sql["database"]);

		for ($i = 0; $i < mysql_num_rows($result); $i++)
		{
			$table_name = mysql_tablename($result, $i);
			if ($table_mode == "a")
			{
				$tmp[] = $table_name;
			}
			else if ($table_mode == "v")
			{
				if (substr(strtolower($table_name),0,(4+strlen($n))) == "vwar".$n)
				{
					$tmp[] = $table_name;
				}
			}
		}

		return $tmp;
	}

	function getSQLStatement (&$content,$pattern,$phpcompliant=1)
	{
		global $do,$vwarmod;

		if (!preg_match($pattern,$content,$matches))
		{
			$do = FALSE;
		}
		else
		{
			$content = str_replace($matches[0],"",$content);

			if ($phpcompliant)
			{
				$matches[0] = trim($matches[0]);

				if (substr($matches[0],(strlen($matches[0]) - 1),1) == ";")
				{
					$matches[0] = substr($matches[0],0,(strlen($matches[0]) - 1));
				}
			}

			return $matches;
		}
	}

	function PingPong ()
	{
		global $time_start,$vwarmod;

		// header for bypass
		if (!isset($time_start))
		{
			$time_start = time();
		}
		else
		{
			if (time() >= $time_start + 25)
			{
				$time_start = time();
				header("X-pmaPing: Pong");
			}
		}
	}

	// do restore
	// available modes: u = upload, f = file
	function doRestore ()
	{
		global $vwardb,$vwartpl,$vwarversion,$vwarmod;

		@set_time_limit(600);
		$crlf = $this->crlf;
		$crlf_len = strlen($crlf);

		if($this->output_mode == "u")
		{
			// check for filled field
			if (empty($this->post_files["sqlfile"]))
			{
				eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
				exit;
			}

			$sqlfile = $this->post_files["sqlfile"]["tmp_name"];
		}
		else
		{
			$sqlfile = $this->file_name;
		}

		if (file_exists($sqlfile))
		{
			if ($this->output_mode == "u") $content = getFileContent($sqlfile,"rb");
			else if ($this->output_mode == "f") $content = fileReader($sqlfile,"rb");
		}
		else
		{
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_db_import_error")."\");");
			exit;
		}

		if (empty($content) || strpos($content,$vwarversion) != 37)
		{
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_db_import_error")."\");");
			exit;
		}

		// get sql queries
		// maybe not a good solution, but it works
		//$vwardb->show_error = 0;
		if (sizeof($this->tables) > 0)
		{
			foreach($this->tables as $tablename)
			{
				// Ping? Pong!
				$this->PingPong();

				$pattern_create = "#CREATE TABLE {$tablename} \((?:.*)\);#siU";
				$pattern_insert = "#INSERT INTO {$tablename} \((?:.*)\) VALUES(?:.*)\((?:.*)\);(?:\r)*(?:\n)+#siU";

				$statement = $this->getSQLStatement($content,$pattern_create);

				if (is_array($statement) && sizeof($statement) > 0)
				{
					$vwardb->query("DROP TABLE IF EXISTS ".$tablename);
					$vwardb->query($statement[0]);
				}

				$statement = $this->getSQLStatement($content,$pattern_insert);

				if (is_array($statement) && sizeof($statement) > 0)
				{
					$vwardb->query($statement[0]);
				}
			}
		}
		else
		{
			$do = TRUE;
			$pattern_create = "#CREATE TABLE (.*) \((?:.*)\);#isU";
			$pattern_insert = "#INSERT INTO (.*) \((.*)\) VALUES(.*)\((.*)\);(\r)*(\n)+#siU";

			do
			{
				// Ping? Pong!
				$this->PingPong();

				$statement = $this->getSQLStatement($content,$pattern_create);

				if (is_array($statement) && sizeof($statement) > 0)
				{
					$vwardb->query("DROP TABLE IF EXISTS ".$statement[1]);
					$vwardb->query($statement[0]);
				}
			}
			while ($do);

			$do = TRUE;
			do
			{
				// Ping? Pong!
				$this->PingPong();

				$statement = $this->getSQLStatement($content,$pattern_insert);

				if (is_array($statement) && sizeof($statement) > 0)
				{
					$vwardb->query($statement[0]);
				}
			}
			while($do);
		}
	}

	// do backup
	// available modes: s = send, w = write
	function doBackup ($with_drop=0)
	{
		global $vwardb,$vwartpl,$vwar_root,$vwarversion,$phpversion_nr,$sql,$vwarmod;

		@set_time_limit(600);
		$crlf = $this->crlf;

		// send header
		if (!empty($this->file_name))
		{
			$file_name = $this->file_name;
		}
		else
		{
			$file_name = $vwar_root . "backup/vwar_backup_".date("m").date("d").date("Y").".sql";
		}

		if ($this->output_mode == "s")
		{
			getSendHeader(basename($file_name));
		}
		else
		{
			$this->file_handle = fopen($file_name,"wb");
		}

		// file header
		$server = $vwardb->query_first("SELECT VERSION() AS version");
		$time = formatdatetime(time());
		eval("\$fileheader = \"".$vwartpl->get("admin_db_export_fileheader")."\";");
		$this->writeData($fileheader);

		foreach($this->tables as $tablename)
		{
			if(!@mysql_query("DESCRIBE $tablename"))
			{
				$this->writeData("$crlf$crlf# Table '$tablename' doesn't exist$crlf");
				$this->writeData("# --------------------------------------------------------");
				continue;
			}

			$schema_create = "$crlf#$crlf# Structure for Table '$tablename'$crlf#$crlf$crlf";
			if(!$with_drop) $schema_create .= "#";
			$schema_create .= "DROP TABLE IF EXISTS $tablename;$crlf";
			$schema_create .= "CREATE TABLE $tablename ($crlf";

			// create structure
			$result = $vwardb->query("SHOW FIELDS FROM $tablename");
			while ($row = $vwardb->fetch_array($result))
			{
				$schema_create .= "    ".$row['Field']." ".strtoupper($row['Type']);
				if (!empty($row['Default'])) $schema_create .= " DEFAULT '".addslashes($row['Default'])."'";
				if ($row['Null'] != "YES") $schema_create .= " NOT NULL";
				if ($row['Extra'] != "") $schema_create .= " ".$row['Extra'];
				$schema_create .= ",$crlf";
			}
			$vwardb->free_result($result);

			$schema_create = ereg_replace(",".$crlf."$","",$schema_create);
			$result = $vwardb->query("SHOW KEYS FROM $tablename");
			while ($row = $vwardb->fetch_array($result))
			{
					$kname = $row['Key_name'];
					$comment = (isset($row['Comment'])) ? $row['Comment'] : "";
					$sub_part = (isset($row['Sub_part'])) ? $row['Sub_part'] : "";

					if($kname != "PRIMARY" && $row['Non_unique'] == 0)	$kname = "UNIQUE|$kname";
					if($comment == "FULLTEXT")	$kname = "FULLTEXT|$kname";
					$index[$kname] = array();

					if ($sub_part > 1)	$index[$kname][] = $row['Column_name']."(".$sub_part.")";
					else $index[$kname][] = $row['Column_name'];

					while (list($x, $columns) = @each($index))
					{
							$schema_create .= ",$crlf";

							if($x == "PRIMARY") $schema_create .= "    PRIMARY KEY (";
							elseif(substr($x,0,6) == "UNIQUE") $schema_create .= "    UNIQUE ".substr($x,7)." (";
							elseif(substr($x,0,8) == "FULLTEXT") $schema_create .= "    FULLTEXT ".substr($x,9)." (";
							else $schema_create .= "    KEY ".$x." (";
							$schema_create .= implode($columns,", ").")";
						 }
						 unset($index);
						}
						$vwardb->free_result($result);
						$schema_create .= "$crlf);$crlf";

						// build dump data
						$schema_insert = "$crlf#$crlf# Dumping Data for Table '$tablename'$crlf#$crlf$crlf";
						$result = $vwardb->query("SELECT * FROM $tablename");
						$num_rows = $vwardb->num_rows($result);

						$current_row = 0;
						if($num_rows > 0)
						{
					$num_fields = $vwardb->num_fields($result);
					$search = array("\x00","\x0a","\x0d","\x1a");
					$replace = array('\0','\n','\r','\Z');

					for($i = 0; $i < $num_fields; $i++)
					{
							if($i < $num_fields - 1) $fields .= $vwardb->field_name($result,$i).", ";
							else $fields .= $vwardb->field_name($result,$i);
							$fieldtype = $vwardb->field_type($result,$i);

							if ($fieldtype=="tinyint" || $fieldtype=="smallint"
									|| $fieldtype=="mediumint" || $fieldtype=="int"
									|| $fieldtype=="bigint"  || $fieldtype =="timestamp") $field_num[$i] = true;
						else $field_num[$i] = false;
					}

					$schema_insert .= "INSERT INTO $tablename ($fields) VALUES$crlf    (";
					unset($fields);

					while($row = $vwardb->fetch_array($result, MYSQL_NUM))
					{
							for($i = 0; $i < $num_fields; $i++)
							{
									if (!isset($row[$i])) $values .= "NULL";
									elseif($row[$i] == "0" || $row[$i] != "")
									{
											if ($field_num[$i]) $values .= $row[$i];
											else
											{
									$row[$i] = str_replace('\'', '\\\'', str_replace('\\', '\\\\', $row[$i]));
									$values .= "'".str_replace($search,$replace,$row[$i])."'";
														}
								}
								else $values .= "''";

								if ($i < $num_fields - 1) $values .= ", ";
								else
								{
										if($current_row == $num_rows-1) $values .= ");$crlf";
										else $values .= "),$crlf    (";
								}
										}
										$current_row++;

							$schema_insert .= $values;
										unset($values);
					}
						}
						else $schema_insert .= "# no data available$crlf$crlf";
						$schema_insert .= "# --------------------------------------------------------$crlf";

						// print whole table
						$this->writeData($schema_create);
						$this->writeData($schema_insert);
		}

				fclose($this->file_handle);
	}
}
?>