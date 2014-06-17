<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 16/06/2014
 * Time: 11:04
 */

function is_image($path)
{
	$a = getimagesize($path);
	$image_type = $a[2];

	if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
	{
		return true;
	}
	return false;
}

function get_images($dirname) {
	$images = array();

	foreach (scandir(dirname(__FILE__).'/assets/img/'.$dirname) as $field_name) {
		$path = dirname(__FILE__).'/assets/img/'.$dirname.'/'.$field_name;
		if (is_file($path) && is_image($path)) {
			$images[] = 'assets/img/'.$dirname.'/'.$field_name;
		}
	}

	return $images;
}