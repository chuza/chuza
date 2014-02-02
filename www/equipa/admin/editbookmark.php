<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://cmsmadesimple.sf.net
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id: editbookmark.php 5216 2008-11-02 21:49:15Z calguy1000 $

$CMS_ADMIN_PAGE=1;

require_once("../include.php");
$urlext='?'.CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY];

check_login();
global $gCms;
$db =& $gCms->GetDb();

$error = "";

$title = "";
if (isset($_POST["title"])) $title = $_POST["title"];

$myurl = "";
if (isset($_POST["url"])) $myurl = $_POST["url"];

$bookmark_id = -1;
if (isset($_POST["bookmark_id"])) $bookmark_id = $_POST["bookmark_id"];
else if (isset($_GET["bookmark_id"])) $bookmark_id = $_GET["bookmark_id"];

if (isset($_POST["cancel"])) {
	redirect("listbookmarks.php".$urlext);
	return;
}

$userid = get_userid();

if (isset($_POST["editbookmark"]))
	{
	$validinfo = true;
	if ($title == "")
		{
		$validinfo = false;
		$error .= "<li>".lang('nofieldgiven', array(lang('title')))."</li>";
		}
	if ($myurl == "")
		{
		$validinfo = false;
		$error .= "<li>".lang('nofieldgiven', array(lang('url')))."</li>";
		}

	if ($validinfo)
		{
		global $gCms;
		$gCms->GetBookmarkOperations();
		$markobj =& new Bookmark();
		$markobj->bookmark_id = $bookmark_id;
		$markobj->title = $title;
		$markobj->url = $myurl;
		$markobj->user_id = $userid;

		$result = $markobj->save();

		if ($result)
			{
			redirect("listbookmarks.php".$urlext);
			return;
			}
		else
			{
			$error .= "<li>".lang('errorupdatingbookmark')."</li>";
			}
		}

	}
else if ($bookmark_id != -1)
	{
	$query = "SELECT * from ".cms_db_prefix()."admin_bookmarks WHERE bookmark_id = ?";
	$result = $db->Execute($query, array($bookmark_id));
	
	$row = $result->FetchRow();

	$myurl = $row["url"];
	$title = $row["title"];
	}

if (strlen($title) > 0)
  {
    $CMS_ADMIN_SUBTITLE = $title;
  }

include_once("header.php");

if ($error != "")
	{
	echo '<div class="pageerrorcontainer"><p class="pageerror">'.$error.'</p></div>';
	}
?>

<div class="pagecontainer">
	<?php echo $themeObject->ShowHeader('editbookmark'); ?>
	<form method="post" action="editbookmark.php">
        <div>
          <input type="hidden" name="<?php echo CMS_SECURE_PARAM_NAME ?>" value="<?php echo $_SESSION[CMS_USER_KEY] ?>" />
        </div>
		<div class="pageoverflow">
			<p class="pagetext"><?php echo lang('title')?>:</p>
			<p class="pageinput"><input type="text" name="title" maxlength="255" value="<?php echo $title?>" /></p>
		</div>
		<div class="pageoverflow">
			<p class="pagetext"><?php echo lang('url')?>:</p>
			<p class="pageinput"><input type="text" name="url" size="80" maxlength="255" value="<?php echo $myurl ?>" /></p>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">&nbsp;</p>
			<p class="pageinput">
				<input type="hidden" name="bookmark_id" value="<?php echo $bookmark_id?>" /><input type="hidden" name="editbookmark" value="true" /><input type="hidden" name="userid" value="<?php echo $userid?>" />
				<input type="submit" value="<?php echo lang('submit')?>" class="pagebutton" onmouseover="this.className='pagebuttonhover'" onmouseout="this.className='pagebutton'" />
				<input type="submit" name="cancel" value="<?php echo lang('cancel')?>" class="pagebutton" onmouseover="this.className='pagebuttonhover'" onmouseout="this.className='pagebutton'" />
			</p>
		</div>		
	</form>
</div>
<?php

echo '<p class="pageback"><a class="pageback" href="'.$themeObject->BackUrl().'">&#171; '.lang('back').'</a></p>';
include_once("footer.php");

# vim:ts=4 sw=4 noet
?>
