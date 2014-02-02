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
#$Id: adminlog.php 6002 2009-09-18 10:59:43Z ronnyk $

$CMS_ADMIN_PAGE=1;

require_once("../include.php");
$urlext='?'.CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY];
check_login();

global $gCms;
$db =& $gCms->GetDb();

$dateformat = trim(get_preference(get_userid(),'date_format_string','%x %X')); 
		  if( empty($dateformat) )
		   {
			 $dateformat = '%x %X';
		   }


$result = $db->Execute("SELECT * FROM ".cms_db_prefix()."adminlog ORDER BY timestamp DESC");
$totalrows = $result->RecordCount();

if (isset($_GET['download']))
{
	header('Content-type: text/plain');
	header('Content-Disposition: attachment; filename="adminlog.txt"');
	if ($result && $result->RecordCount() > 0) 
	{
		while ($row = $result->FetchRow()) 
		{
		  echo strftime($dateformat,$row['timestamp'])."\t";
//			echo date("D M j, Y G:i:s", $row["timestamp"]) . "\t";
		  echo $row['username'] . "\t";
		  echo $row['item_id'] . "\t";
		  echo $row['item_name'] . "\t";
		  echo $row['action'] . "\t";
		  echo "\n";
		}
	}
	return;
}

include_once("header.php");

$userid = get_userid();
$access = check_permission($userid, 'Clear Admin Log');

if (check_permission($userid, 'Modify Site Preferences'))
{
	if (isset($_GET['clear']) && $access) {
	       $query = "DELETE FROM ".cms_db_prefix()."adminlog";
	       $db->Execute($query);
	       echo $themeObject->ShowMessage(lang('adminlogcleared'));
	}

	$page = 1;
	if (isset($_GET['page']))$page = $_GET['page'];

	$limit = 20;
	$page_string = "";
	$from = ($page * $limit) - $limit;

	$result = $db->SelectLimit('SELECT * from '.cms_db_prefix().'adminlog ORDER BY timestamp DESC', $limit, $from);


	echo '<div class="pagecontainer">';
	echo '<div class="pageoverflow">';

	if ($result && $result->RecordCount() > 0) 
	{
	
		$page_string = pagination($page, $totalrows, $limit);
		echo "<p class=\"pageshowrows\">".$page_string."</p>";
		echo $themeObject->ShowHeader('adminlog').'</div>';
		echo '<a href="adminlog.php'.$urlext.'&amp;download=1">'.lang('download').'</a>';

		echo "<table cellspacing=\"0\" class=\"pagetable\">\n";
		echo '<thead>';
		echo "<tr>\n";
		echo "<th>".lang('user')."</th>\n";
		echo "<th>".lang('itemid')."</th>\n";
		echo "<th>".lang('itemname')."</th>\n";
		echo "<th>".lang('action')."</th>\n";
		echo "<th>".lang('date')."</th>\n";
		echo "</tr>\n";
		echo '</thead>';
		echo '<tbody>';

	       $currow = "row1";
	       while ($row = $result->FetchRow()) {

	               echo "<tr class=\"$currow\" onmouseover=\"this.className='".$currow.'hover'."';\" onmouseout=\"this.className='".$currow."';\">\n";
	               echo "<td>".$row["username"]."</td>\n";
	               echo "<td>".($row["item_id"]!=-1?$row["item_id"]:"&nbsp;")."</td>\n";
	               echo "<td>".$row["item_name"]."</td>\n";
	               echo "<td>".$row["action"]."</td>\n";
				   echo "<td>".strftime($dateformat,$row['timestamp'])."</td>\n";
		       //               echo "<td>".date("D M j, Y G:i:s", $row["timestamp"])."</td>\n";
	               echo "</tr>\n";

	               ($currow == "row1"?$currow="row2":$currow="row1");

	       }
	   
		echo '</tbody>';
		echo '</table>';

		}
		else {
			echo '<p class="pageheader">'.lang('adminlog').'</p></div>';
			echo '<p>'.lang('adminlogempty').'</p>';
		}

	if ($access && $result && $result->RecordCount() > 0) {
		echo '<div class="pageoptions">';
		echo '<p class="pageoptions">';
		echo '<a href="adminlog.php'.$urlext.'&amp;clear=true">';
		echo $themeObject->DisplayImage('icons/system/delete.gif', lang('delete'),'','','systemicon').'</a>';
		echo '<a class="pageoptions" href="adminlog.php'.$urlext.'&amp;clear=true">'.lang('clearadminlog').'</a>';
		echo '</p>';
		echo '</div>';
	}

	echo '</div>';

}

echo '<p class="pageback"><a class="pageback" href="'.$themeObject->BackUrl().'">&#171; '.lang('back').'</a></p>';


include_once("footer.php");

# vim:ts=4 sw=4 noet
?>
