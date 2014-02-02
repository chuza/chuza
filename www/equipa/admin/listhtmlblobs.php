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
#$Id: listhtmlblobs.php 6252 2010-04-23 20:40:58Z calguy1000 $

$CMS_ADMIN_PAGE=1;

require_once("../include.php");
$urlext='?'.CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY];

check_login();

include_once("header.php");

if (isset($_GET["message"])) {
	$message = preg_replace('/\</','',$_GET['message']);
	echo '<div class="pagemcontainer"><p class="pagemessage">'.$message.'</p></div>';
}

?>
<div class="pagecontainer">
	<div class="pageoverflow">

<?php
	$userid	= get_userid();

	global $gCms;
	$gcbops =& $gCms->GetGlobalContentOperations();

	$modifyall = check_permission($userid, 'Modify Global Content Blocks');
	$htmlbloblist = $gcbops->LoadHtmlBlobs();
	$myblobs = $gcbops->AuthorBlobs($userid);

	$page = 1;
	if (isset($_GET['page'])) $page = $_GET['page'];
        $limit = get_preference($userid,'listgcbs_pagelimit',20);
	echo "<p class=\"pageshowrows\">".pagination($page, count($htmlbloblist), $limit)."</p>";
	echo $themeObject->ShowHeader('htmlblobs').'</div>';

	if ($htmlbloblist && count($htmlbloblist) > 0) {
		echo "<table cellspacing=\"0\" class=\"pagetable\">\n";
		echo '<thead>';
		echo "<tr>\n";
		echo "<th>".lang('name')."</th>\n";
		echo "<th>".lang('tagtousegcb')."</th>\n";
		echo "<th class=\"pageicon\">&nbsp;</th>\n";
		echo "<th class=\"pageicon\">&nbsp;</th>\n";
		echo "</tr>\n";
		echo '</thead>';
		echo '<tbody>';

		$currow = "row1";
		// construct true/false button images
        $image_true = $themeObject->DisplayImage('icons/system/true.gif', lang('true'),'','','systemicon');
        $image_false = $themeObject->DisplayImage('icons/system/false.gif', lang('false'),'','','systemicon');

		$counter = 0;
		foreach ($htmlbloblist as $onehtmlblob){
			if ($counter < $page*$limit && $counter >= ($page*$limit)-$limit) {
            if ($modifyall ||  quick_check_authorship($onehtmlblob->id, $myblobs))
				{
				echo "<tr class=\"$currow\" onmouseover=\"this.className='".$currow.'hover'."';\" onmouseout=\"this.className='".$currow."';\">\n";
				echo "<td><a href=\"edithtmlblob.php".$urlext."&amp;htmlblob_id=".$onehtmlblob->id."\">".$onehtmlblob->name."</a></td>\n";
				echo "<td>{global_content name='".$onehtmlblob->name."'}</td>\n";
				echo "<td><a href=\"edithtmlblob.php".$urlext."&amp;htmlblob_id=".$onehtmlblob->id."\">";
                echo $themeObject->DisplayImage('icons/system/edit.gif', lang('edit'),'','','systemicon');
                echo "</a></td>\n";
		echo "<td>";
		if( $modifyall || check_permission($userid,'Remove Global Content Blocks') )
		  {
		    echo "<a href=\"deletehtmlblob.php".$urlext."&amp;htmlblob_id=".$onehtmlblob->id."\" onclick=\"return confirm('".lang('deleteconfirm', $onehtmlblob->name)."');\">";
		    echo $themeObject->DisplayImage('icons/system/delete.gif', lang('delete'),'','','systemicon')."</a>";
		  }
                echo "</td>\n";
				echo "</tr>\n";

				($currow=="row1"?$currow="row2":$currow="row1");
				}
			}
			$counter++;
		}

		echo '</tbody>';
		echo "</table>\n";
	}

#if ($add) {
if (check_permission($userid, 'Add Global Content Blocks'))
	{
?>
	<div class="pageoptions">
		<p class="pageoptions">
			<a href="addhtmlblob.php<?php echo $urlext ?>">
				<?php 
					echo $themeObject->DisplayImage('icons/system/newobject.gif', lang('addhtmlblob'),'','','systemicon').'</a>';
					echo ' <a class="pageoptions" href="addhtmlblob.php'.$urlext.'">'.lang("addhtmlblob");
				?>
			</a>
		</p>		
	</div>
<?php } ?>
</div>
<p class="pageback"><a class="pageback" href="<?php echo $themeObject->BackUrl(); ?>">&#171; <?php echo lang('back')?></a></p>

<?php
#}

include_once("footer.php");

# vim:ts=4 sw=4 noet
?>
