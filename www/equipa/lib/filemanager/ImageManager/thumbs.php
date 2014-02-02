<?php
/**
 * On the fly Thumbnail generation.
 * Creates thumbnails given by thumbs.php?img=/relative/path/to/image.jpg
 * relative to the base_dir given in config.inc.php
 * @author $Author: Wei Zhuo $
 * @version $Id: thumbs.php 4169 2007-09-21 06:28:49Z silmarillion $
 * @package ImageManager
 */

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/include.php');
check_login();

$userid = get_userid();
if (!check_permission($userid, 'Modify Files')) die();

require_once('config.inc.php');
require_once('Classes/ImageManager.php');
require_once('Classes/Thumbnail.php');

//check for img parameter in the url
if(!isset($_GET['img']))
	exit();


$manager = new ImageManager($IMConfig);

//get the image and the full path to the image
$image = rawurldecode($_GET['img']);
$fullpath = Files::makeFile($manager->getBaseDir(),$image);

//not a file, so exit
if(!is_file($fullpath))
{
	//show the default image, otherwise we quit!
	$default = $manager->getDefaultThumb();
	if($default)
	{
		header('Location: '.$default);
		exit();
	}
}

$imgInfo = @getImageSize($fullpath);

//Not an image, send default thumbnail
if(!is_array($imgInfo))
{
	//show the default image, otherwise we quit!
	$default = $manager->getDefaultThumb();
	if($default)
	{
		header('Location: '.$default);
		exit();
	}
}

//Check for thumbnails
$thumbnail = $manager->getThumbName($fullpath);
if(is_file($thumbnail))
{
	//if the thumbnail is newer, send it
	if(filemtime($thumbnail) >= filemtime($fullpath))
	{
		header('Location: '.$manager->getThumbURL($image));
		exit();
	}
}

//creating thumbnails
// if image smaller than config size for thumbs
	if ($imgInfo[0] <= $IMConfig['thumbnail_width'] && $imgInfo[1] <= $IMConfig['thumbnail_height'])
	{
		$thumbnailer = new Thumbnail($imgInfo[0],$imgInfo[1]);
		$thumbnailer->createThumbnail($fullpath, $thumbnail);
	}
 
// if image bigger than config size for thumbs
	else {
		$thumbnailer = new Thumbnail($IMConfig['thumbnail_width'],$IMConfig['thumbnail_height']);
		$thumbnailer->createThumbnail($fullpath, $thumbnail);
	}

//Check for NEW thumbnails
if(is_file($thumbnail))
{
	//send the new thumbnail
	header('Location: '.$manager->getThumbURL($image));
	exit();
}
else
{
	//show the default image, otherwise we quit!
	$default = $manager->getDefaultThumb();
	if($default)
		header('Location: '.$default);
}
?>