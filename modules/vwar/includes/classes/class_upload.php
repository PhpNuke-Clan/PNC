<?php
/* #####################################################################################
 *
 * $Id: class_upload.php,v 1.11 2004/07/23 11:59:29 mabu Exp $
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

/*
* class upload
* ============
* image upload class to control http uploads
*
*/
class upload {

	var $ext_array;
	var $info_image;


	// ###################################################################################
	// FUNCTION:		doUpload()
	// ===================================================================================
	// Parameters:
	// file_array				: content of $HTTP_POST_FILES['thefile'] / $_FILES['thefile']
	// upload_dir				: target directory
	// createThumbnail	: create a thumbnail of the image
	// resize						: resize the uploaded image
	// prefix						: extend filename by a prefix
	// continue					: exit or continue on error
	// ===================================================================================
	// Description: 		controls the http upload
	// ###################################################################################

	function doUpload($file_array, $upload_dir, $createThumbnail=0, $resize=0, $prefix="", $continue=0)
	{
		global $thumbnailwidth, $thumbnailheight, $screenshotwidth, $screenshotheight,$vwarmod;

		@set_time_limit(1200);

		$upload_dir  = checkPath($upload_dir);
		$new_imgpath = $upload_dir . $prefix . strtolower($file_array['name']);

		// image defined?
		if (ini_get("file_uploads") == 1)
		{
			if ($file_array['name'] && $file_array['tmp_name'])
			{
				if ($this->validate_extension($file_array['name']))
				{
					if ($this->validate_upload_dir($upload_dir))
					{
						if (!is_writeable($new_imgpath) && !file_exists($new_imgpath))
						{
							if (is_uploaded_file($file_array['tmp_name']))
							{
								if (move_uploaded_file($file_array['tmp_name'], $new_imgpath))
								{
									$this->info_image = @getimagesize($new_imgpath);
									if ($resize != 1 AND $createThumbnail != 1)
									{
										// no resize, no image...
										return TRUE;
									}
									else if ($resize == 1 AND $createThumbnail != 1 AND $this->info_image AND $this->info_image[0] < $screenshotwidth AND $this->info_image[1] < $screenshotheight)
									{
										// no thumbnail, resize not necessary
										return TRUE;
									}
									else if ($resize != 1 AND $createThumbnail == 1 AND $this->info_image AND $this->info_image[0] < $thumbnailwidth AND $this->info_image[1] < $thumbnailheight)
									{
										// no resize, thumbnail not necessary
										return TRUE;
									}
									else if ($resize == 1 AND $createThumbnail == 1 AND $this->info_image AND $this->info_image[0] < $screenshotwidth AND $this->info_image[1] < $screenshotheight AND $this->info_image[0] < $thumbnailwidth AND $this->info_image[1] < $thumbnailheight)
									{
										// no resize and no thumbnail necessary
										return TRUE;
									}
									else if ($this->info_image)
									{
										if ($this->info_image[2] != 4)
										{
											if ($this->check_gd())
											{
												// it's an image (no flash) and we need to resize it in any way...
												if ($resize == 1 )
												{
													$this->resizeImage($upload_dir, $upload_dir . $prefix . strtolower($file_array['name']), strtolower($file_array['name']), $screenshotwidth, $screenshotheight);
												}
												if ($createThumbnail == 1)
												{
													$this->createThumbnail($upload_dir, $upload_dir . $prefix . strtolower($file_array['name']), $thumbnailwidth, $thumbnailheight);
												}
												return TRUE;
											} else {
												return $this->print_error($continue, "GD Library not installed!");
											}
									} else {
											return $this->print_error($continue, "Flash images cannot be resized!");
										}
									}
									else
									{
										// non-supported image type
										return $this->print_error($continue, "At the moment, PHP doesn't support this type of image to be uploaded!");
									}
								} else {
									return $this->print_error($continue, "File couldn't be moved out of the servers temp folder!");
								}
							} else {
								return $this->print_error($continue, "File couldn't be uploaded!");
							}
						} else {
							return $this->print_error($continue, "There's already existing a file with the same name you're trying to upload or the file isn't writeable!");
						}
					} else {
						return $this->print_error($continue, "Upload directory <b>".$upload_dir."</b> isn't writeable or doesn't exist!");
					}
				} else {
					return $this->print_error($continue, "Filetype isn't allowed to be uploaded!");
				}
			} else {
				return $this->print_error($continue, "You didn't specify a file to be uploaded!");
			}
		} else {
			return $this->print_error($continue, "File uploads are disabled in your php.ini!");
		}
	}

	// ###################################################################################
	// FUNCTION:		print_error()
	// ===================================================================================
	// Parameters:
	// continue : if it is set to '1', the script won't be aborted
	// errormsg	: the error message to print if continue != '1'
	// ===================================================================================
	// Description: 		prints an error message
	// ###################################################################################

	function print_error ($continue, $errormsg) {
		global $vwartpl,$vwarmod;

		if ($continue == 1)
		{
			return false;
		}
		else
		{
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_uploaderror")."\");");
			exit();
		}
	}

	// ###################################################################################
	// FUNCTION:		createThumbnail()
	// ===================================================================================
	// Parameters:
	// image_dir 				: source dir
	// image_file_path	: source path
	// ===================================================================================
	// Description: 		thumbnail creation
	// ###################################################################################

	function createThumbnail ($image_dir, $image_file_path, $thumbnailwidth, $thumbnailheight)
	{
		$image_file_name = basename ($image_file_path);
		if ($this->resizeImage($image_dir, $image_file_path, "th_" . $image_file_name, $thumbnailwidth, $thumbnailheight))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// ###################################################################################
	// FUNCTION:		resizeImage()
	// ===================================================================================
	// Parameters:
	// image_dir 					: source dir
	// image_file_path		: source path
	// new_image_filename	: new file name
	// max_width					: new width (max)
	// max_height					: new height (max)
	// ===================================================================================
	// Description: 		resize images
	// ####################################################################################

	function resizeImage ($image_dir, $image_file_path, $new_image_filename, $max_width=480, $max_height=1600 )
	{
			$return_val = 1;

			// create new image
			if ($this->info_image[2] == 3) {
				$ImageCreateFromType = "ImageCreateFromPNG";
				$ImageType           = "ImagePNG";
			} else if ($this->info_image[2] == 2) {
				$ImageCreateFromType = "ImageCreateFromJPEG";
				$ImageType           = "ImageJPEG";
			} else {
				$ImageCreateFromType = "ImageCreateFromGIF";
				$ImageType           = "ImageGIF";
			}

			$return_val 			= ( ($img = $ImageCreateFromType ( $image_file_path )) && $return_val == 1 ) ? "1" : "0";
			$FullImage_width 	= imagesx ($img);    // original width
			$FullImage_height = imagesy ($img);    // original width

			// now we check for over-sized images and pare them down
			// to the dimensions we need for display purposes
			$ratio 			= ( $FullImage_width > $max_width ) ? (real)($max_width / $FullImage_width) : 1 ;
			$new_width 	= ((int)($FullImage_width * $ratio));    //full-size width
			$new_height = ((int)($FullImage_height * $ratio));    //full-size height

			//check for images that are still too high
			$ratio 			= ( $new_height > $max_height ) ? (real)($max_height / $new_height) : 1 ;
			$new_width 	= ((int)($new_width * $ratio));    //mid-size width
			$new_height = ((int)($new_height * $ratio));    //mid-size height

			if ( $new_width != $FullImage_width && $new_height != $FullImage_height ) {

				// check to see if gd2+ libraries are compiled with php

				$gd_version = $this->check_gd();

				if ( $gd_version == "gd2" )
				{
					$full_id =  ImageCreateTrueColor ( $new_width , $new_height );
					ImageCopyResampled ( $full_id, $img, 0,0,0,0, $new_width, $new_height, $FullImage_width, $FullImage_height );
				}
				elseif ( $gd_version == "gd" )
				{
					$full_id = ImageCreate ( $new_width , $new_height );
					ImageCopyResized ( $full_id, $img, 0,0,0,0, $new_width, $new_height, $FullImage_width, $FullImage_height );
				}
				else return false;

				$return_val = ( $full = $ImageType ( $full_id, $image_dir . $new_image_filename ) && $return_val == 1 ) ? "1" :

				ImageDestroy( $full_id );
			}

		return ($return_val) ? TRUE : FALSE ;

	}

	// ###################################################################################
	// FUNCTION:		validate_upload_dir()
	// ===================================================================================
	// Parameters:
	// upload_dir			: the dir to validate
	// ===================================================================================
	// Description: 		validates if a dir is writeable and really a dir
	// ###################################################################################

	function validate_upload_dir($upload_dir) {

		if (is_dir($upload_dir) && is_writeable($upload_dir)) return true;
		else return false;

	}

	// ###################################################################################
	// FUNCTION:		validate_extension()
	// ===================================================================================
	// Parameters:
	// file_name 			: the file's name
	// ===================================================================================
	// Description: 		validate file extension
	// ####################################################################################

	function validate_extension($file_name)
	{
		$ext_array = $this->ext_array;
		if (!$file_name)
		{
			// no file name given
			return false;
		}
		else
		{
			if (!$ext_array)
			{
				// no extension array
				return true;
			}
			else
			{
				// is valid extension?
				if (in_array($this->get_extension($file_name), $ext_array)) return true;
				else return false;
			}
		}
	}

	// ###################################################################################
	// FUNCTION:		get_extension()
	// ===================================================================================
	// Parameters:
	// file_name 			: the file's name
	// ===================================================================================
	// Description: 		get file extension
	// ####################################################################################

	function get_extension ($file_name)
	{
		$file_name      = trim($file_name);
		$file_extension = strrchr($file_name, ".");
		$file_extension = strtolower($file_extension);
		return $file_extension;
	}

	// ###################################################################################
	// FUNCTION:		check_gd()
	// ===================================================================================
	// Parameters:
	// -
	// ===================================================================================
	// Description: 		check installed gd-version
	// ####################################################################################

	function check_gd()
	{
		$testGD = get_extension_funcs("gd");
		if (!$testGD)
		{
			// gd not installed
			return false;
		}
		else
		{
			ob_start();
			phpinfo(8);
			$grab = ob_get_contents();
			ob_end_clean();

			$version = strpos  ($grab,"2.0");

			if ( $version )
			{
				// gd2 available
				return "gd2";
			}
			else
			{
				// 'old' gd available
				return "gd";
			}
		}
	}

}
?>