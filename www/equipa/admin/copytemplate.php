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
#$Id: copytemplate.php 6404 2010-06-25 01:17:04Z calguy1000 $

$CMS_ADMIN_PAGE=1;

require_once("../include.php");
require_once("../lib/classes/class.template.inc.php");
$urlext='?'.CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY];

check_login();

$error = "";

$template = "";
if (isset($_POST["template"])) $template = $_POST["template"];

$template_id = -1;
if (isset($_POST["template_id"])) $template_id = $_POST["template_id"];
else if (isset($_GET["template_id"])) $template_id = $_GET["template_id"];

$template_name = '';
if (isset($_REQUEST["template_name"])) { $template_name = $_REQUEST["template_name"]; }

$from = 'listtemplates.php'.$urlext;
if (isset($_GET['from']) )
  {
    $from = 'moduleinterface.php'.$urlext.'&amp;module='.$_GET['from'];
  }
else if( isset( $_POST['from'] ) )
  {
    $from = $_POST['from'];
  }

if (isset($_POST["cancel"]))
{
	redirect($from);
	return;
}

$userid = get_userid();
$access = check_permission($userid, 'Modify Templates');

global $gCms;
$templateops =& $gCms->GetTemplateOperations();

if ($access)
{
	if (isset($_POST["copytemplate"]))
	{
		$validinfo = true;
		if ($template == "")
		{
			$error .= "<li>".lang('nofieldgiven',array(lang('name')))."</li>";
			$validinfo = false;
		}
		else
		{
			if ($templateops->CheckExistingTemplateName($template))
			{
				$error .= "<li>".lang('templateexists')."</li>";
				$validinfo = false;
			}
		}

		$onetemplate = null;
		if ($validinfo)
		{
			$onetemplate = $templateops->LoadTemplateByID($template_id);

			if (!$onetemplate)
			{
				$error .= '<li>' . lang('errorretrievingtemplate') . '</li>';
				$validinfo = false;
			}
		}

		if ($onetemplate)
		{
			$onetemplate->id = -1; //Reset id so it will insert a new record
			$onetemplate->name = $template; //Change name
			$onetemplate->default = 0; //It can't be default
			$result = $onetemplate->Save();

			if ($result)
			{
				//Copy attached CSS templates as well...
				$db = &$gCms->GetDb();

				$query = "SELECT assoc_css_id, assoc_type, css_name, assoc_order FROM ".cms_db_prefix()."css_assoc, ".cms_db_prefix()."css WHERE assoc_to_id = " . $db->qstr($template_id) . " AND assoc_css_id = css_id";
				debug_buffer($query);
				$result2 = $db->Execute($query);
				debug_buffer($result2);

				# if any css was found.
				if ($result2)
				{
					while ($row = $result2->FetchRow())
					{
						$query = "INSERT INTO ".cms_db_prefix()."css_assoc (assoc_to_id,assoc_css_id,assoc_type,create_date,modified_date,assoc_order) VALUES ('".$onetemplate->id."','".$row['assoc_css_id']."','".$row['assoc_type']."',".$db->DBTimeStamp(time()).",".$db->DBTimeStamp(time()).",'".$row['assoc_order']."')";
						debug_buffer($query);
						$db->Execute($query);
					}
				}

				audit($onetemplate->id, $onetemplate->name, 'Copied Template');
				redirect($from.'&message='.lang('templatecopied'));
				return;
			}
			else
			{
				$error .= "<li>".lang('errorcopyingtemplate')."</li>";
			}
		}

	}
}

include_once("header.php");

if (!$access)
{
	echo "<div class=\"pageerrorcontainer\"><p class=\"pageerror\">".lang('noaccessto',array(lang('copytemplate')))."</p></div>";
}
else
{
	if ($error != "")
	{
		echo "<div class=\"pageerrorcontainer\"><ul class=\"pageerror\">".$error."</ul></div>";		
	}

?>


<div class="pagecontainer">
	<p class="pageheader"><?php echo lang('copytemplate')?></p>
	<form method="post" action="copytemplate.php">
        <div>
          <input type="hidden" name="<?php echo CMS_SECURE_PARAM_NAME ?>" value="<?php echo $_SESSION[CMS_USER_KEY] ?>" />
        </div>
		<div class="pageoverflow">
			<p class="pagetext"><?php echo lang('template'); ?>:</p>
			<p class="pageinput"><?php echo $template_name; ?></p>
		</div>
		<div class="pageoverflow">
			<p class="pagetext"><?php echo lang('newtemplatename'); ?>:</p>
			<p class="pageinput"><input type="text" name="template" maxlength="255" value="<?php echo $template?>"></p>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">&nbsp;</p>
			<p class="pageinput">
			      <input type="hidden" name="template_id" value="<?php echo $template_id?>" /><input type="hidden" name="copytemplate" value="true" /><input type="hidden" name="from" value="<?php echo $from?>" />
				<input type="submit" value="<?php echo lang('submit')?>" class="pagebutton" onmouseover="this.className='pagebuttonhover'" onmouseout="this.className='pagebutton'" />
				<input type="submit" name="cancel" value="<?php echo lang('cancel')?>" class="pagebutton" onmouseover="this.className='pagebuttonhover'" onmouseout="this.className='pagebutton'" />
			</p>
		</div>
	</form>
</div>

<?php

}

echo '<p class="pageback"><a class="pageback" href="listtemplates.php'.$urlext.'">&#171; '.lang('back').'</a></p>';

include_once("footer.php");

# vim:ts=4 sw=4 noet
?>
