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
#$Id: listtags.php 6473 2010-07-04 03:21:29Z wishy $

$CMS_ADMIN_PAGE=1;
$CMS_LOAD_ALL_PLUGINS=1;

require_once("../include.php");
$urlext='?'.CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY];

check_login();

$plugin = "";
if (isset($_GET["plugin"])) $plugin = cms_htmlentities($_GET["plugin"]);

$action = "";
if (isset($_GET["action"])) $action = cms_htmlentities($_GET["action"]);

$userid = get_userid();
$access = check_permission($userid, "View Tag Help");
//if( !$access ) return;


if (!$access) {
	die('Permission Denied');
return;
}



#$smarty = new Smarty_CMS($gCms->config);

debug_buffer('before header');

include_once("header.php");

debug_buffer('after header');

if ($action == "showpluginhelp")
{
	if (function_exists('smarty_cms_help_function_'.$plugin))
	{
		echo '<div class="pagecontainer">';
		// Display the title along with a wiki help link
		$header  = '<div class="pageheader">';
		$header .= lang('pluginhelp', array($plugin));
		$wikiUrl = $config['wiki_url'];
		$module_name = $plugin;
		// Turn ModuleName into _Module_Name
		$moduleName =  preg_replace('/([A-Z])/', "_$1", $module_name);
		$moduleName =  preg_replace('/_([A-Z])_/', "$1", $moduleName);
		if ($moduleName{0} == '_')
		{
			$moduleName = substr($moduleName, 1);
		}
		$wikiUrl .= '/Tags/'.$moduleName;
		if (FALSE == get_preference($userid, 'hide_help_links'))
		{
			// Clean up URL
			$wikiUrl = str_replace(' ', '_', $wikiUrl);
			$wikiUrl = str_replace('&amp;', 'and', $wikiUrl);

			$help_title = lang('help_external');

			$image_help = $themeObject->DisplayImage('icons/system/info.gif', lang('help'),'','','systemicon');
			$image_help_external = $themeObject->DisplayImage('icons/system/info-external.gif', lang('help'),'','','systemicon');		
			$header .= '<span class="helptext"><a href="'.$wikiUrl.'" target="_blank">'.$image_help_external.'</a> <a href="'.$wikiUrl.'" target="_blank">'.lang('help').'</a> ('.lang('new_window').')</span>';
		}

		$header .= '</div>';
		echo $header;     

		// Get and display the plugin's help
		@ob_start();
		call_user_func_array('smarty_cms_help_function_'.$plugin, array());
		$content = @ob_get_contents();
		@ob_end_clean();

		echo $content;
		echo "</div>";
		echo '<p class="pageback"><a class="pageback" href="listtags.php'.$urlext.'">&#171; '.lang('back').'</a></p>';
	}
	else
	{
		echo '<div class="pagecontainer">';
		echo '<p class="pageheader">'.lang('pluginhelp', array($plugin)).'</p>';
		echo '<P>No help text available for this plugin.</P>';
		echo "</div>";
		echo '<p class="pageback"><a class="pageback" href="listtags.php'.$urlext.'">&#171; '.lang('back').'</a></p>';
	}
}
else if ($action == "showpluginabout")
{
	if (function_exists('smarty_cms_about_function_'.$plugin))
	{
		@ob_start();
		call_user_func_array('smarty_cms_about_function_'.$plugin, array());
		$content = @ob_get_contents();
		@ob_end_clean();
		echo '<div class="pagecontainer">';
		echo '<p class="pageheader">'.lang('pluginabout', array($plugin)).'</p>';
		echo $content;
		echo "</div>";
		echo '<p class="pageback"><a class="pageback" href="listtags.php'.$urlext.'">&#171; '.lang('back').'</a></p>';
	}
	else
	{
		echo '<div class="pagecontainer">';
		echo '<p class="pageheader">'.lang('pluginhelp', array($plugin)).'</p>';
		echo '<P>No help text available for this plugin.</P>';
		echo "</div>";
		echo '<p class="pageback"><a class="pageback" href="listtags.php'.$urlext.'">&#171; '.lang('back').'</a></p>';
	}
}
else
{

	echo '<div class="pagecontainer">';
	echo '<div class="pageoverflow">';
	echo $themeObject->ShowHeader('tags').'</div>';
	echo "<table cellspacing=\"0\" class=\"pagetable\">\n";
	echo '<thead>';
	echo "<tr>\n";
	echo "<th>".lang('name')."</th>\n";
	echo "<th class=\"pagew10\">".lang('help')."</th>\n";
	echo "<th class=\"pagew10\">".lang('about')."</th>\n";
	echo "</tr>\n";
	echo '</thead>';
	echo '<tbody>';

		$curclass = "row1";
		
		foreach($gCms->cmsplugins as $oneplugin)
		{
			if (!array_key_exists($oneplugin, $gCms->userplugins))
			{
				echo "<tr class=\"".$curclass."\" onmouseover=\"this.className='".$curclass.'hover'."';\" onmouseout=\"this.className='".$curclass."';\">\n";

				if (function_exists('smarty_cms_help_function_'.$oneplugin))
				{
					echo "<td><a href=\"listtags.php".$urlext."&amp;action=showpluginhelp&amp;plugin=".$oneplugin."\">".$oneplugin."</a></td>";
				}
				else
				{
					echo "<td>$oneplugin</td>\n";
				}
				if (function_exists('smarty_cms_help_function_'.$oneplugin))
				{
					echo "<td><a href=\"listtags.php".$urlext."&amp;action=showpluginhelp&amp;plugin=".$oneplugin."\">".lang('help')."</a></td>";
				}
				else
				{
					echo "<td>&nbsp;</td>";
				}
				if (function_exists('smarty_cms_about_function_'.$oneplugin))
				{
					echo "<td><a href=\"listtags.php".$urlext."&amp;action=showpluginabout&amp;plugin=".$oneplugin."\">".lang('about')."</a></td>";
				}
				else
				{
					echo "<td>&nbsp;</td>";
				}
			
				echo "</tr>\n";

				($curclass=="row1"?$curclass="row2":$curclass="row1");
			}
		}

	?>

	</tbody>
</table>
</div>

<?php
echo '<p class="pageback"><a class="pageback" href="'.$themeObject->BackUrl().'">&#171; '.lang('back').'</a></p>';
}

include_once("footer.php");

# vim:ts=4 sw=4 noet
?>
