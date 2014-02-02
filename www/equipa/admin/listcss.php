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
#$Id: listcss.php 6404 2010-06-25 01:17:04Z calguy1000 $

/**
 * This page is in charge of listing all CSS, and giving acces to editing and
 * deleting.
 *
 * There is no particular argument.
 *
 * @since	0.6
 * @author	calexico
 */

$CMS_ADMIN_PAGE=1;

require_once("../include.php");
require_once(cms_join_path($dirname,'lib','html_entity_decode_utf8.php'));
$urlext='?'.CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY];

check_login();
$userid = get_userid();
$access = check_permission($userid, "Modify Stylesheets")
  || check_permission($userid, "Add Stylesheets")
  || check_permission($userid, "Remove Stylesheets")
  || check_permission($userid, "Modify Stylesheet Assoc")
  || check_permission($userid, "Add Stylesheet Assoc")
  || check_permission($userid, "Remove Stylesheet Assoc");


if (!$access) {
  echo "<div class=\"pageerrorcontainer\"><p class=\"pageerror\">".lang('noaccessto', array(lang('listcss')))."</p></div>";
  return;
}


include_once("header.php");
global $gCms;
$db =& $gCms->GetDb();

#******************************************************************************
# first : displaying error message, if any.
#******************************************************************************
if (isset($_GET["message"])) {
	$message = preg_replace('/\</','',$_GET['message']);
	echo '<div class="pagemcontainer"><p class="pagemessage">'.$message.'</p></div>';
}

?>
<form action="multistylesheet.php<?php echo $urlext ?>" method="post">

<div class="pagecontainer">
	<div class="pageoverflow">
<?php

#******************************************************************************
# first getting all permission : we only display elements the user has access
# too
#******************************************************************************
	$userid       = get_userid();

	$modify       = check_permission($userid, 'Modify Stylesheets');
	$addcss       = check_permission($userid, 'Add Stylesheets');
	$delcss       = check_permission($userid, 'Remove Stylesheets');
	$modifyAssoc  = check_permission($userid, 'Modify Stylesheet Assoc');
	$addAssoc  = check_permission($userid, 'Add Stylesheet Assoc');
	$delAssoc  = check_permission($userid, 'Remove Stylesheet Assoc');

	$query = "SELECT * FROM ".cms_db_prefix()."css ORDER BY css_name";
	$result = $db->Execute($query);

	$page = 1;
	if (isset($_GET['page'])) $page = $_GET['page'];
        $limit = get_preference($userid,'liststylesheets_pagelimit',20);
	if ($result->RecordCount() > $limit)
	{
		echo "<p class=\"pageshowrows\">".pagination($page, $result->RecordCount(), $limit)."</p>";
	}
	echo $themeObject->ShowHeader('liststylesheets').'</div>';


	if ($result && $result->RecordCount() > 0)
	{
		# displaying the table header
		echo "<table cellspacing=\"0\" class=\"pagetable\">\n";
		echo '<thead>';
		echo "<tr>\n";
		echo "<th>".lang('title')."</th>\n";
		echo "<th class=\"pageicon\">&nbsp;</th>\n";
		echo "<th class=\"pageicon\">&nbsp;</th>\n";
		echo "<th class=\"pageicon\">&nbsp;</th>\n";
		echo "<th class=\"pageicon\">&nbsp;</th>\n";
		echo "<th class=\"pageicon\">&nbsp;</th>\n";
		echo "</tr>\n";
		echo '</thead>';
		echo '<tbody>';

		# this var is used to show each line with different color
		$currow = "row1";

		# we now show each line
		$counter = 0;
		while ($one = $result->FetchRow()){
		  if ($counter < $page*$limit && $counter >= ($page*$limit)-$limit) {
		    echo "<tr class=\"$currow\" onmouseover=\"this.className='".$currow.'hover'."';\" onmouseout=\"this.className='".$currow."';\">\n";
		    if( $modify )
		      {
			echo "<td><a href=\"editcss.php".$urlext."&amp;css_id=".$one["css_id"]."\">".$one["css_name"]."</a></td>\n";
		      }
		    else
		      {
			echo "<td>".$one["css_name"]."</td>\n";
		      }

		    if( $modifyAssoc || $delAssoc || $addAssoc )
		      {
			echo "<td class=\"icons_wide\"><a href=\"templatecss.php".$urlext."&amp;id=".$one["css_id"]."&amp;type=template\">";
			echo $themeObject->DisplayImage('icons/system/css.gif', lang('attachtotemplate'),'','','systemicon');
			echo "</a></td>\n";
		      }
		    else
		      {
			echo "<td>&nbsp;</td>";
		      }

                    // if user has right to add (copy)
		    if ($addcss)
		      {
			echo '<td class="icons_wide"><a href="copystylesheet.php'.$urlext.'&amp;stylesheet_id=' . $one['css_id'] . '&amp;stylesheet_name=' . urlencode($one['css_name']) . '">';
			echo $themeObject->DisplayImage('icons/system/copy.gif', lang('copy'),'','','systemicon');
			echo "</a></td>\n";
		      }
		    else
		      {
			echo "<td>&nbsp;</td>";
		      }

		    // if user has right to edit
		    if ($modify)
		      {
			echo "<td class=\"icons_wide\"><a href=\"editcss.php".$urlext."&amp;css_id=".$one["css_id"]."\">";
			echo $themeObject->DisplayImage('icons/system/edit.gif', lang('edit'),'','','systemicon');
			echo "</a></td>\n";
		      }
		    else
		      {
			echo "<td>&nbsp;</td>";
		      }

                    // if user has right to delete
		    if ($delcss)
		      {
			echo "<td class=\"icons_wide\"><a href=\"deletecss.php".$urlext."&amp;css_id=".$one["css_id"]."\" onclick=\"return confirm('".cms_html_entity_decode_utf8(lang('deleteconfirm', $one['css_name']),true)."');\">";
			echo $themeObject->DisplayImage('icons/system/delete.gif', lang('delete'),'','','systemicon');
			echo "</a></td>\n";
		      }
		    else
		      {
			echo "<td>&nbsp;</td>";
		      }

		    if( $delcss )
		      {
			echo '<td><input type="checkbox" name="multistylesheet-'.$one['css_id'].'" /></td>';
		      }
		    else
		      {
			echo '<td></td>';
		      }
		    echo "</tr>\n";

		    ("row1" == $currow) ? $currow="row2" : $currow="row1";
		  }
		  $counter++;
		} ## foreach

		echo '</tbody>';
		echo "</table>\n";
		
	} # end if result

// this bottom stuff is ugly
?>
	<div class="pageoptions">
		<p class="pageoptions">
<?php
	# if user can add css
	if ($addcss)
	  {
?>
	    <span style="float: left;">
	    <a href="addcontent.php<?php echo $urlext ?>">
	    <?php 
	    echo $themeObject->DisplayImage('icons/system/newobject.gif', lang('addstylesheet'),'','','systemicon').'</a>';
	    echo ' <a class="pageoptions" href="addcss.php'.$urlext.'">'.lang("addstylesheet");
	    ?>
	    </a>
	    </span>
<?php
	  }
        if ($delcss)
	  {
?>
			<span style="margin-right: 30px; float: right; text-align: right">
				<?php echo lang("selecteditems"); ?>: <select name="multiaction">
				<option value="delete"><?php echo lang('delete') ?></option>
				<!--
				<option value="active"><?php echo lang('active') ?></option>
				<option value="inactive"><?php echo lang('inactive') ?></option>
				-->
				</select>
				<input type="submit" value="<?php echo lang('submit') ?>" />
			</span>
			<br />
<?php
  	 }
?>
		</p>
	</div>
</div>

</form>
<p class="pageback"><a class="pageback" href="<?php echo $themeObject->BackUrl(); ?>">&#171; <?php echo lang('back')?></a></p>

<?php

include_once("footer.php");

# vim:ts=4 sw=4 noet
?>
